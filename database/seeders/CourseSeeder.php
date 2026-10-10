<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\CourseAnswer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure test student exists
        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'John Student',
                'password' => bcrypt('password'),
            ]
        );

        if (!$student->hasRole('student')) {
            $student->assignRole('student');
        }

        // 2. Get category and teacher
        $category = Category::where('slug', 'programming')->first() ?? Category::first();
        $teacher = User::where('email', 'jackson@teacher.com')->first();

        // 3. Create or update course
        $course = Course::firstOrCreate(
            ['slug' => 'laravel-advanced-mastery'],
            [
                'name' => 'Laravel Advanced Mastery',
                'category_id' => $category->id,
                'teacher_id' => $teacher ? $teacher->id : null,
                'cover' => 'course_covers/default_laravel.png',
            ]
        );

        // Remove old dummy questions if any
        $course->questions()->delete();

        // 4. Enroll the student in the course
        if (!$course->students()->where('user_id', $student->id)->exists()) {
            $course->students()->attach($student->id);
        }

        // 5. 10 Real CBT Technical Questions with authentic options
        $questionsData = [
            [
                'question' => 'Dalam siklus hidup request di framework Laravel, method manakah pada Service Provider yang bertugas khusus untuk mendaftarkan binding ke Service Container tanpa mengeksekusi logika yang bergantung pada service lain?',
                'answers' => [
                    ['text' => 'register()', 'is_correct' => true],
                    ['text' => 'boot()', 'is_correct' => false],
                    ['text' => 'resolve()', 'is_correct' => false],
                    ['text' => 'handle()', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Pendekatan manakah yang paling tepat untuk mengatasi masalah performa N+1 Query Problem pada Eloquent ORM saat memuat relasi author dari daftar artikel?',
                'answers' => [
                    ['text' => "Post::lazy()->author", 'is_correct' => false],
                    ['text' => "Post::with('author')->get()", 'is_correct' => true],
                    ['text' => "Post::join('users', 'posts.user_id', '=', 'users.id')->get()", 'is_correct' => false],
                    ['text' => "Post::all()->loadMissing('author')", 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Manakah struktur kode middleware yang benar jika kita ingin menjalankan suatu logika setelah request selesai diproses oleh controller (Post-Middleware)?',
                'answers' => [
                    ['text' => 'return $next($request->after());', 'is_correct' => false],
                    ['text' => 'return $this->terminate($request, $next);', 'is_correct' => false],
                    ['text' => '$response = $next($request); /* Logika setelah eksekusi controller */; return $response;', 'is_correct' => true],
                    ['text' => '$this->dispatchAfter($request); return $next($request);', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Metode database transaction manakah pada Laravel yang secara otomatis membatalkan (rollback) seluruh transaksi query jika terjadi exception selama proses eksekusi?',
                'answers' => [
                    ['text' => 'DB::autoRollback(callable $callback)', 'is_correct' => false],
                    ['text' => 'DB::beginTransaction(callable $callback)', 'is_correct' => false],
                    ['text' => 'DB::safeExecute(callable $callback)', 'is_correct' => false],
                    ['text' => 'DB::transaction(callable $callback)', 'is_correct' => true],
                ],
            ],
            [
                'question' => 'Pada kelas Form Request Laravel (app/Http/Requests), method apakah yang digunakan untuk menentukan apakah pengguna yang sedang login memiliki hak akses untuk mengeksekusi request tersebut?',
                'answers' => [
                    ['text' => 'authorize()', 'is_correct' => true],
                    ['text' => 'authenticate()', 'is_correct' => false],
                    ['text' => 'validate()', 'is_correct' => false],
                    ['text' => 'canAccess()', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Dalam route Route::get(\'/courses/{course:slug}\', ...), apa fungsi spesifik dari parameter penamaan {course:slug}?',
                'answers' => [
                    ['text' => 'Mengganti kolom pencarian model Course dari kolom primary key id default menjadi kolom slug', 'is_correct' => true],
                    ['text' => 'Menambahkan parameter query string berupa ?slug= pada URL yang diminta', 'is_correct' => false],
                    ['text' => 'Menerapkan filter regex agar segmen URL hanya menerima format teks slug', 'is_correct' => false],
                    ['text' => 'Mengarahkan HTTP request ke grup middleware bernama slug', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Dalam skema migrasi database Laravel, sintaks foreign key manakah yang secara otomatis menghapus rekaman relasi anak ketika baris data induknya dihapus?',
                'answers' => [
                    ['text' => "\$table->foreign('course_id')->references('id')->onDeleteRestrict();", 'is_correct' => false],
                    ['text' => "\$table->foreignId('course_id')->constrained()->cascadeOnDelete();", 'is_correct' => true],
                    ['text' => "\$table->unsignedBigInteger('course_id')->dropOnParent();", 'is_correct' => false],
                    ['text' => "\$table->integer('course_id')->autoCascade();", 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Interface manakah yang wajib diimplementasikan oleh sebuah kelas Job di Laravel agar job tersebut dieksekusi secara asinkron di antrean (Queue)?',
                'answers' => [
                    ['text' => 'Queueable', 'is_correct' => false],
                    ['text' => 'Dispatchable', 'is_correct' => false],
                    ['text' => 'ShouldQueue', 'is_correct' => true],
                    ['text' => 'InteractsWithQueue', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Pada template engine Blade Laravel, sintaks direktif manakah yang digunakan untuk mencetak nilai variabel secara mentah tanpa escaping karakter HTML (raw HTML)?',
                'answers' => [
                    ['text' => '{{ $content }}', 'is_correct' => false],
                    ['text' => '@raw($content)', 'is_correct' => false],
                    ['text' => '{!! $content !!}', 'is_correct' => true],
                    ['text' => '{{-- $content --}}', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Bagaimana mekanisme proteksi Cross-Site Request Forgery (CSRF) bawaan Laravel bekerja dalam mengamankan form submit aplikasi web?',
                'answers' => [
                    ['text' => 'Memvalidasi kesesuaian token rahasia sesi yang disematkan melalui direktif @csrf pada middleware ValidateCsrfToken', 'is_correct' => true],
                    ['text' => 'Mengenkripsi seluruh nilai input form menggunakan cipher AES-256 sebelum data dikirim ke web server', 'is_correct' => false],
                    ['text' => 'Memeriksa alamat IP pengguna dan membatasi pengiriman form maksimal satu kali per sesi browser', 'is_correct' => false],
                    ['text' => 'Menolak seluruh request HTTP POST yang tidak menyertakan Basic Auth Authorization header', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($questionsData as $qData) {
            $question = CourseQuestion::create([
                'course_id' => $course->id,
                'question' => $qData['question'],
            ]);

            foreach ($qData['answers'] as $aData) {
                CourseAnswer::create([
                    'course_question_id' => $question->id,
                    'answer' => $aData['text'],
                    'is_correct' => $aData['is_correct'],
                ]);
            }
        }

        $this->command->info('Course "Laravel Advanced Mastery" updated with 10 authentic questions.');
    }
}
