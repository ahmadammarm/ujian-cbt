<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  untuk php artisan migrate:rollback digunakan untuk mengembalikan migrasi pada kondisi sebelum migrasi ini dijalankan
    //  untuk php artisan migrate:refresh digunakan untuk menghapus semua tabel yang ada di database dan menjalankan kembali semua migrasi
    //  untuk php artisan migrate:fresh digunakan untuk menghapus semua tabel yang ada di database dan menjalankan kembali semua migrasi tanpa mengembalikan kondisi sebelumnya
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
