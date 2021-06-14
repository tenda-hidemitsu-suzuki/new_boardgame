<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//商品付属タグテーブル
class tag_tbl extends Model
{
    use HasFactory;
    protected $table =  'tag_tbl';
    protected $fillable = ['tag_item_id', 'item_id', 'tag_id', 'tag_name'];
}

