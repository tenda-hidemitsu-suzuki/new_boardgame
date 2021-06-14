<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//タグ一覧テーブル
class tag_list_tbl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table =  'tag_list_tbl';
    protected $fillable = ['tag_id', 'tag_name', 'tag_type', 'tag_banner'];
}
