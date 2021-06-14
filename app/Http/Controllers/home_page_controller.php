<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\board_model;
use App\Models\tag_list_tbl;
use App\Models\item_tbl;
use App\Models\tag_tbl;
//コントローラー
class home_page_controller extends Controller{
	//ヘッダーからきたときのメソッド
	public function from_header(){
		//検索条件を配列に格納(初期値を格納)
		$search_info=array('name'=>"", 'age'=>2147483647, 'player_num'=>0, 'tag_id'=>"0", 'time'=>0, 'price'=>0, 'size'=>0, 'sort'=>0, 'tag_type'=>1);
		
		//タグ一覧を配列に格納(簡単を格納)
		$tag_lists = tag_list_tbl::select('*')->where('tag_type', 1)->get()->toArray();
		
		
		//検索条件に合う情報をDBから取得(全部)
		$item_info = item_tbl::select('*')->get()->toArray();
		
		//バナータグを取得
		$banner_tag_lists = tag_list_tbl::select('*')->where('tag_banner', '>=' ,1)->get()->toArray();
		
		//商品テーブルの情報を販売個数の多い順にソートして表示
    	$items = item_tbl::select('*')->orderBy('sale_num', 'DESC')->limit(3)->get()->toArray();
   		//var_dump($items);
		
		//変数渡してview呼び出し
		return view('board_user.home_page',compact('search_info', 'tag_lists', 'item_info', 'banner_tag_lists', 'items'));
	}
}