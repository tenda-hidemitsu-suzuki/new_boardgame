<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//会員テーブル
class user_tbl extends Model
{
    use HasFactory;
    protected $table =  'user_tbl';
    protected $fillable = ['user_id', 'user_name', 'user_kana', 'post', 'address', 'tel', 'mail', 'passwd'];
}







