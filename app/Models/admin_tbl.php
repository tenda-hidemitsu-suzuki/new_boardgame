<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//管理者テーブル
class admin_tbl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table =  'admin_tbl';
    protected $fillable = ['admin_id', 'admin_pass'];
}

