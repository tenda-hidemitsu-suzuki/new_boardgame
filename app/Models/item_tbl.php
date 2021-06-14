<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//商品テーブル
class item_tbl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table =  'item_tbl';
    protected $fillable = [
        'item_id',
        'item_name',
        'item_price',
        'item_description',
        'sale_num',
        'age',
        'player_num_min',
        'player_num_max',
        'player_time_min',
        'player_time_max',
        'length',
        'width',
        'hight'
    ];




}


