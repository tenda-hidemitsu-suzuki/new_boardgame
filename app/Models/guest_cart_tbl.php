<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ゲストカートテーブル
class guest_cart_tbl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table =  'guest_cart_tbl';
    protected $fillable = ['guest_cart_id', 'guest_id', 'item_id', 'guest_cart_num'];
}


