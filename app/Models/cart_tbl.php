<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

//カートテーブル
class cart_tbl extends Model
{
    use HasFactory; 
	public $timestamps = false;
    protected $table =  'cart_tbl';
    protected $fillable = ['cart_id', 'user_id', 'item_id', 'cart_num'];
}



