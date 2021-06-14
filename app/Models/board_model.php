<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ショッピングテーブル(購入履歴)
class shop_history_tbl extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_st_id', 'customer_name', 'customer_kana', 'customer_address', 'customer_post', 'customer_tel', 'customer_mail', 'purchase_time_id'];
}

//会員テーブル
class user_tbl extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'user_name', 'user_kana', 'post', 'address', 'tel', 'mail', 'passwd'];
}

//商品テーブル
class item_tbl extends Model
{
    use HasFactory;
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

//カートテーブル
class cart_tbl extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id', 'user_id', 'item_id', 'cart_num'];
}

//ショッピングテーブル(詳細)
class shop_detail_tbl extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'purchase_st_id',
        'item_id',
        'purchase_num',
        'item_price'
    ];
}

//商品付属タグテーブル
class tag_tbl extends Model
{
    use HasFactory;
    protected $fillable = ['tag_item_id', 'item_id', 'tag_id', 'tag_name'];
}

//タグ一覧テーブル
class tag_list_tbl extends Model
{
    use HasFactory;
    protected $fillable = ['tag_id', 'tag_name', 'tag_type', 'tag_banner'];
}

//管理者テーブル
class admin_tbl extends Model
{
    use HasFactory;
    protected $fillable = ['admin_id', 'admin_pass'];
}

//ゲストテーブル
class guest_tbl extends Model
{
    use HasFactory;
    protected $fillable = ['guest_id', 'time'];
}

//ゲストカートテーブル
class guest_cart_tbl extends Model
{
    use HasFactory;
    protected $fillable = ['guest_cart_id', 'guest_id', 'item_id', 'guest_cart_num'];
}


