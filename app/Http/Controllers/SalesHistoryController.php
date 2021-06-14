<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

//この下に使うモデルを記載
use App\Models\item_tbl;
use App\Models\shop_detail_tbl;
use App\Models\shop_history_tbl;


class SalesHistoryController extends Controller
{
    public function sales_history()
    {
    
        //DBのテーブルを結合して取得する
        $table_datas = shop_detail_tbl::
        select('shop_id',
            'shop_detail_tbl.purchase_st_id' ,
            'shop_detail_tbl.item_id',
            'item_name',
            'purchase_num' ,
            'shop_detail_tbl.item_price',
            'customer_name', 
            'customer_kana', 
            'customer_address',
            'customer_post',
            'customer_tel',
            'customer_mail',
            'purchase_time_id')
        ->join('item_tbl', 'shop_detail_tbl.item_id', '=', 'item_tbl.item_id')
        ->join('shop_history_tbl', 'shop_detail_tbl.purchase_st_id', '=', 'shop_history_tbl.purchase_st_id')
        ->get();
        
        $datas = $table_datas->toArray();//配列化
        
        //バナー編集画面へ移動
        return view('board_manager.sales_history', ['datas' => $datas]);
    }
    
}
?>

