<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_assessments', function (Blueprint $table) {
            $table->unsignedInteger('violations_count')->default(0)->after('score');
            $table->string('submitted_reason')->default('normal')->after('violations_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_assessments', function (Blueprint $table) {
            $table->dropColumn(['violations_count', 'submitted_reason']);
        });
    }
};
