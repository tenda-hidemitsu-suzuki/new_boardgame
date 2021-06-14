<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ゲストテーブル
class guest_tbl extends Model
{
    use HasFactory;
    protected $table = 'guest_tbl';
    protected $fillable = ['guest_id', 'time'];
}
