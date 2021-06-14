<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\board_model;
use App\Models\tag_list_tbl;
use App\Models\item_tbl;
use App\Models\tag_tbl;

//コントローラー
class item_list_controller extends Controller{
	//検索ボタンから飛んだとき
	public function search(Request $request){
		echo "$request->tag_type";
		//POST受け取り
		$search_name=$request->search_name;
		$age=$request->age;
		//人数が設定されなかったときはすべてひっかかるように特殊処理
		if($request->player_num == 0){
			$player_num_min=2147483647;
			$player_num_max=0;
		}else{
			$player_num_min=$request->player_num;
			$player_num_max=$request->player_num;
		}
		$tag=$request->tag;
		$time=$request->time;
		//選択肢に対応した時間範囲を格納
		if($time==1){
			$time_min=0;
			$time_max=10;
		}elseif($time==2){
			$time_min=10;
			$time_max=30;
		}elseif($time==3){
			$time_min=30;
			$time_max=60;
		}elseif($time==4){
			$time_min=60;
			$time_max=2147483647;
		}else{
			$time_min=0;
			$time_max=2147483647;
		}
		
		$price=$request->price;
		//選択肢に対応した値段範囲を格納
		if($price==1){
			$price_min=0;
			$price_max=1000;
		}elseif($price==2){
			$price_min=1000;
			$price_max=3000;
		}elseif($price==3){
			$price_min=3000;
			$price_max=5000;
		}elseif($price==4){
			$price_min=5000;
			$price_max=10000;
		}elseif($price==5){
			$price_min=10000;
			$price_max=2147483647;
		}else{
			$price_min=0;
			$price_max=2147483647;
		}
		if($request->size==1){
			$size=15;
		}else{
			$size=2147483647;
		}
		
		$sort=$request->sort;
		//ソート条件を格納(いらん説)
		if($sort==1){
			$order='item_price';
			$asc_desc='asc';
		}else{
			$order='sale_num';
			$asc_desc='desc';
		}
		
		$tag_type=$request->tag_type;
		//検索条件を配列に格納
		$search_info=array('name'=>"$search_name", 'age'=>"$age", 'player_num'=>"$player_num_max", 'tag_id'=>"$tag", 'time'=>"$time", 'price'=>"$price", 'size'=>"$request=>size", 'sort'=>"$sort", 'tag_type'=>"$tag_type");
		
		//タグ一覧を配列に格納
		if($tag_type==1){
			$tag_lists = tag_list_tbl::select('*')->where('tag_type', 1)->get()->toArray();
		}else{
			$tag_lists = tag_list_tbl::select('*')->get()->toArray();
		}
		
		//タグ検索の結果のidを取得
		if($tag == 0){
			$result_id_tag = tag_tbl::select('item_id')->get()->toArray();
			$i=0;
			foreach($result_id_tag as $result){
				$result_id_tag_array_all[$i] = $result['item_id'];
				$i++;
			}
			$result_id_tag_array=array_unique($result_id_tag_array_all);
		}else{
			$result_id_tag = tag_tbl::select('item_id')->where('tag_id', $tag)->get()->toArray();
			$i=0;
			foreach($result_id_tag as $result){
				$result_id_tag_array[$i] = $result['item_id'];
				$i++;
			}
		}
		
		//テスト用
		
		
		//検索条件に合う商品idをDBから取得(タグ以外)
		$result_id_search = item_tbl::select('item_id')->where('item_name', 'like', '%' . $search_name . '%')->where('age', '<=' ,$age)->where('player_num_min', '<=' ,$player_num_min)->where('player_num_max', '>=' ,$player_num_max)->where('player_time_min', '>=' ,$time_min)->where('player_time_max', '<=' ,$time_max)->where('item_price', '>=' ,$price_min)->where('item_price', '<=' ,$price_max)->where('length', '<=' ,$size)->where('width', '<=' ,$size)->where('hight', '<=' ,$size)->get()->toArray();
		$i=0;
		foreach($result_id_search as $result){
			$result_id_search_array[$i] = $result['item_id'];
			$i++;
		}
		
		if(!isset($result_id_search_array)){
			$result_id_search_array="";
		}
		
		if(!isset($result_id_tag_array)){
			$result_id_tag_array="";
		}
		
		
		//テスト用
		//var_dump($result_id_search_array);
		//var_dump(array_intersect($result_id_tag_array, $result_id_search_array));
		
		//二つの配列の共通項を格納
		if(is_array($result_id_search_array)&&is_array($result_id_tag_array)){
			$result_id = array_intersect($result_id_tag_array, $result_id_search_array);
		}elseif($result_id_search_array==$result_id_tag_array){
			$result_id = $result_id_search;
		}
		
		
		
		
		//ソート
		if(!isset($result_id)){
			$item_info=array(array('item_id'=>0, 'item_name'=>'商品が見つかりません', 'item_price'=>'0'));
		}elseif($sort==1){
			//取得した情報を変数に格納
			$i=0;
			foreach($result_id as $id){
				$item_info_result = item_tbl::select('*')->where('item_id', $id)->orderBy("$order", "$asc_desc")->get()->toArray();
				$item_info[$i] =$item_info_result[0];
				$i++;
			}
			// foreachで1つずつ値を取り出す
			foreach ($item_info as $key => $value) {
			  $item_price[$key] = $value['item_price'];
			}
			// array_multisortで'item_price'の列を昇順に並び替える
			array_multisort($item_price, SORT_ASC, $item_info);
		}else{
			//取得した情報を変数に格納
			$i=0;
			foreach($result_id as $id){
				$item_info_result = item_tbl::select('*')->where('item_id', $id)->orderBy("$order", "$asc_desc")->get()->toArray();
				$item_info[$i] =$item_info_result[0];
				$i++;
			}
			
			// foreachで1つずつ値を取り出す
			foreach ($item_info as $key => $value) {
			  $sale_num[$key] = $value['sale_num'];
			}
			// array_multisortで'item_price'の列を昇順に並び替える
			array_multisort($sale_num, SORT_DESC, $item_info);
		}
		require("Header_Controller_func.php");
		//変数渡してview呼び出し
		return view('board_user.item_list',compact('search_info', 'tag_lists', 'item_info', 'name'));
	}


	//個別ページに遷移するコントローラー?


	//クリアボタン・ヘッダーからきたときのメソッド
	public function from_header(){
		//検索条件を配列に格納(初期値を格納)
		$search_info=array('name'=>"", 'age'=>2147483647, 'player_num'=>0, 'tag_id'=>"0", 'time'=>0, 'price'=>0, 'size'=>0, 'sort'=>0, 'tag_type'=>1);
		
		//タグ一覧を配列に格納(簡単を格納)
		$tag_lists = tag_list_tbl::select('*')->where('tag_type', 1)->get()->toArray();
		
		
		//検索条件に合う情報をDBから取得(全部)
		$item_info = item_tbl::select('*')->get()->toArray();
		
		require("Header_Controller_func.php");
		//変数渡してview呼び出し
		return view('board_user.item_list',compact('search_info', 'tag_lists', 'item_info', 'name'));
	}
	
	
	//詳しいタグで検索ボタンが押されたとき
	public function all_tag(){
		//検索条件を配列に格納(初期値を格納)
		$search_info=array('name'=>"", 'age'=>2147483647, 'player_num'=>0, 'tag_id'=>"0", 'time'=>0, 'price'=>0, 'size'=>0, 'sort'=>0, 'tag_type'=>0);
		
		//タグ一覧を配列に格納(簡単を格納)
		$tag_lists = tag_list_tbl::select('*')->get()->toArray();
		
		
		//検索条件に合う情報をDBから取得(全部)
		$item_info = item_tbl::select('*')->get()->toArray();
		
		require("Header_Controller_func.php");
		//変数渡してview呼び出し
		return view('board_user.item_list',compact('search_info', 'tag_lists', 'item_info', 'name'));
	}
	
	//バナーで飛んできたとき
	public function banner(Request $request){
		$tag_id=$request->tag_id;
		//検索条件を配列に格納(初期値を格納)
		$search_info=array('name'=>"", 'age'=>2147483647, 'player_num'=>0, 'tag_id'=>"$tag_id", 'time'=>0, 'price'=>0, 'size'=>0, 'sort'=>0, 'tag_type'=>0);
		
		//タグ一覧を配列に格納(簡単を格納)
		$tag_lists = tag_list_tbl::select('*')->where('tag_type', 1)->get()->toArray();
		
		
		//検索条件に合う情報をDBから取得
		$result_id = tag_tbl::select('item_id')->where('tag_id', $tag_id)->get()->toArray();
		if(empty($result_id)){
			$item_info=array(array('item_id'=>0, 'item_name'=>'商品が見つかりません', 'item_price'=>'0'));
		}else{
		$i=0;
			foreach($result_id as $id){
				$item_info_result = item_tbl::select('*')->where('item_id', $id)->get()->toArray();
				$item_info[$i] =$item_info_result[0];
				$i++;
			}
			
			// foreachで1つずつ値を取り出す
			foreach ($item_info as $key => $value) {
			  $sale_num[$key] = $value['sale_num'];
			}
			// array_multisortで'item_price'の列を昇順に並び替える
			array_multisort($sale_num, SORT_DESC, $item_info);
		}
		require("Header_Controller_func.php");
		//変数渡してview呼び出し
		return view('board_user.item_list',compact('search_info', 'tag_lists', 'item_info','name'));
	}
}