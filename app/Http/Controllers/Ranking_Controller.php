<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use Illuminate\Support\Facades\DB;

class Ranking_Controller extends Controller
{


	//ランキング
   	public function ranking(){
   	
   		//$items = \App\Item::select('name')->get();
   		
   		
   		//商品テーブルの情報を販売個数の多い順にソートして表示
   		//Model版に修正の可能性あり
   		//$table_datas = item_tbl::select('item_id', 'item_name', 'item_price', 'sale_num')->get(); 
    	$items = DB::select('select item_id,item_name,item_price,sale_num from item_tbl ORDER BY sale_num DESC LIMIT 0, 10');
    	$rank = 1;
   	
   		//変数
   		/*
   		$variable = [
   		    'rank' => 1,  //順位(初期値1)
   		 	'items' => $items
   		];
   		*/
   		
   		require("Header_Controller_func.php");
   		return view('board_user.ranking',compact('rank', 'items', 'name'));

	}



}