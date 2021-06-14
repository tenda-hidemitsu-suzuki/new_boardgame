<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ショッピングテーブル(購入履歴)
class shop_history_tbl extends Model
{
    use HasFactory;
    protected $table =  'shop_history_tbl';
    protected $fillable = ['purchase_st_id', 'customer_name', 'customer_kana', 'customer_address', 'customer_post', 'customer_tel', 'customer_mail', 'purchase_time_id'];
}




