<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    // menggunakan protected $guarded untuk menghindari mass assignment
    // mass assignment adalah proses mengisi data ke dalam model secara massal
    // dengan menggunakan array atau collection
    // misalnya: Category::create(['name' => 'Programming', 'slug' => 'programming']);

    // untuk itu dengan menggunakan protected $guarded kita bisa membiarkan laravel yang mengisi field id, created_at, updated_at, dan deleted_at
    protected $guarded = [
        'id'
    ];


}
