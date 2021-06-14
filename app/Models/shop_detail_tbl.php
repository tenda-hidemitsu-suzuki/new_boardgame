<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ショッピングテーブル(詳細)
class shop_detail_tbl extends Model
{
    use HasFactory;
    protected $table =  'shop_detail_tbl';
    protected $fillable = [
        'shop_id',
        'purchase_st_id',
        'item_id',
        'purchase_num',
        'item_price'
    ];
}
