<?php

namespace App\Http\Controllers;

//モデル
use App\Models\cart_tbl;
use App\Models\guest_cart_tbl;
use App\Models\item_tbl;

use Illuminate\Http\Request;

class CartController extends Controller
{

//ヘッダーから遷移

	public function header(Request $request){
	
	//$user_id = 2;

	//会員かゲストか判別
	if(session()->has( 'user_name')){
	//if($user_id == 1){
	
	//会員としてログインしている場合↓
		//セッションから会員idを取得
		$user_id  = $request -> session()->get('user_id');
		
		
		//カートページで+ボタンが押されたときの処理
		if(!empty($request->add)){
			//POSTの受け取り
			$name = $request->item_name;
			$num = $request->cart_num;
			$num = ++$num;
			
				//商品テーブルから$nameに該当する商品idを取得
				$item_ids = item_tbl::select('item_id')->where('item_name',$name)->get();
				foreach($item_ids as $item_id){
					$item_id = $item_id->item_id;
			    }
				
				//カートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = cart_tbl::select('cart_id')->where('item_id',$item_id)->where('user_id',$user_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
				
				//カートテーブルの商品の数量を1増やす
				cart_tbl::where('cart_id',$cart_id)->where('item_id',$item_id)->update(['cart_num' => $num]);
		}
		
		//カートページで-ボタンが押されたときの処理
		if(!empty($request->sub)){
		//POSTの受け取り
			$name = $request->item_name;
			$num = $request->cart_num;
			$num = --$num;
			
				//商品テーブルから$nameに該当する商品idを取得
				$item_ids = item_tbl::select('item_id')->where('item_name',$name)->get();
				foreach($item_ids as $item_id){
					$item_id = $item_id->item_id;
			    }
	
				//カートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = cart_tbl::select('cart_id')->where('item_id',$item_id)->where('user_id',$user_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
				
				//カートテーブルの商品の数量を1増やす
				cart_tbl::where('cart_id',$cart_id)->where('item_id',$item_id)->update(['cart_num' => $num]);
		}
		
		//カートページで削除ボタンが押されたときの処理
		if(!empty($request->del)){
		//POSTの受け取り
			$name = $request->item_name;
			$num = $request->cart_num;
			
				//商品テーブルから$nameに該当する商品idを取得
				$item_ids = item_tbl::select('item_id')->where('item_name',$name)->get();
				foreach($item_ids as $item_id){
					$item_id = $item_id->item_id;
			    }
				
				//カートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = cart_tbl::select('cart_id')->where('item_id',$item_id)->where('user_id',$user_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
			    
				//カートテーブルの商品idを削除
				cart_tbl::where('cart_id',$cart_id)->delete('item_id',$item_id);
		}
		
		
		//カートテーブルから会員idに該当する商品idを取得
		$item_id_date = cart_tbl::select('item_id')->where('user_id',$user_id)->get();
		
		$item_id_lists = $item_id_date ->toArray();//配列化
		//var_dump($item_id_lists);
		
		//$item_id_listsの配列の数を数える
		$cun = count($item_id_lists);
		//echo $cun;
		
		
		//$item_id_listsを配列から文字列にする
		for($i = 0 ; $i < $cun; $i++ ){
		foreach($item_id_lists[$i] as $item_id_listss){
				$item_id_list[] = array($item_id_listss);
			}
		}
		
		//var_dump($item_id_list);
		
		
		//商品テーブルからitem_nameカラムを指定して商品名を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_names[$i] = item_tbl::select('item_name')->where('item_id',$item_id_list[$i])->get();
			
			//foreachで一つ値を引き出す
			foreach($item_names[$i] as $item_namess){
				$item_name[$i] = $item_namess->item_name;
			}
		}
		
		
	    //商品テーブルからitem_priceカラムを指定して価格を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_prices[$i] = item_tbl::select('item_price')->where('item_id',$item_id_list[$i])->get();
			foreach($item_prices[$i] as $item_pricess){
				$item_price[$i] =  $item_pricess->item_price;
			}	
		}
		
		
		//カートテーブルからカート内個数を取得し配列に格納
		for($i = 0 ; $i < $cun; $i++ ){
			$cart_nums[$i] = cart_tbl::select('cart_num')->where('item_id',$item_id_list[$i])->get();
			foreach($cart_nums[$i] as $cart_numss){
				$cart_num[$i] = $cart_numss->cart_num;
			}	
		}
		

		
		//echo $item_price[0];
		//echo $cart_num[0];
		
		//合計金額の計算
	    for( $i = 0 ; $i < $cun; $i++ ){
	    	$price[$i] =  $item_price[$i] *  $cart_num[$i];
	    }
	    
	    //var_dump($price);
	    
	    $total_price = 0;
	    
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price += $price[$i];
	    }
	    
	    //カートになにも入っていないときの処理
	    if(empty($item_id)){
	    
	    $msg = 'カートにはなにも入っていません。';
	    
	    return view('board_user/cart_null',compact('msg'));
	    
	    }else{
	    
		return view('board_user/cart',compact('item_name','item_price','cart_num','total_price','cun'));
		}
	
	}else{

	//ゲストとしてログインしている場合↓
		//セッションからゲストidを取得
		$guest_id = $request -> session()->get('guest_id');
		
		//$guest_id = 1;
		
		//カートページで+ボタンが押されたときの処理
		if(!empty($request->add)){
			//POSTの受け取り
			$name = $request->item_name;
			$num = $request->cart_num;
			$num = ++$num;
			
			//echo $num;
			
				//商品テーブルから$nameに該当する商品idを取得
				$item_ids = item_tbl::select('item_id')->where('item_name',$name)->get();
				foreach($item_ids as $item_id){
					$item_id = $item_id->item_id;
			    }
				
				//ゲストカートテーブルから商品idとゲストidに該当するゲストカートidを取得
				$guest_cart_ids = guest_cart_tbl::select('guest_cart_id')->where('item_id',$item_id)->where('guest_id',$guest_id)->get();
				foreach($guest_cart_ids as $guest_cart_id){
					$guest_cart_id = $guest_cart_id->guest_cart_id;
			    }
				
				//ゲストカートテーブルの商品の数量を1増やす
				guest_cart_tbl::where('guest_cart_id',$guest_cart_id)->where('item_id',$item_id)->update(['guest_cart_num' => $num]);
		}
		
		//カートページで-ボタンが押されたときの処理
		if(!empty($request->sub)){
			//POSTの受け取り
			$name = $request->item_name;
			$num = $request->cart_num;
			$num = --$num;
			
				//商品テーブルから$nameに該当する商品idを取得
				$item_ids = item_tbl::select('item_id')->where('item_name',$name)->get();
				foreach($item_ids as $item_id){
					$item_id = $item_id->item_id;
			    }
				
				//ゲストカートテーブルから商品idとゲストidに該当するゲストカートidを取得
				$guest_cart_ids = guest_cart_tbl::select('guest_cart_id')->where('item_id',$item_id)->where('guest_id',$guest_id)->get();
				foreach($guest_cart_ids as $guest_cart_id){
					$guest_cart_id = $guest_cart_id->guest_cart_id;
			    }
				
				//ゲストカートテーブルの商品の数量を減らす
				guest_cart_tbl::where('guest_cart_id',$guest_cart_id)->where('item_id',$item_id)->update(['guest_cart_num' => $num]);
		}
		
		//カートページで削除ボタンが押されたときの処理
		if(!empty($request->del)){
		//POSTの受け取り
			$name = $request->item_name;
			$num = $request->cart_num;
			
				//商品テーブルから$nameに該当する商品idを取得
				$item_ids = item_tbl::select('item_id')->where('item_name',$name)->get();
				foreach($item_ids as $item_id){
					$item_id = $item_id->item_id;
			    }
				
				//ゲストカートテーブルから商品idとゲストidに該当するゲストカートidを取得
				$guest_cart_ids = guest_cart_tbl::select('guest_cart_id')->where('item_id',$item_id)->where('guest_id',$guest_id)->get();
				foreach($guest_cart_ids as $guest_cart_id){
					$guest_cart_id = $guest_cart_id->guest_cart_id;
			    }
			    
				//ゲストカートテーブルの商品idを削除
				guest_cart_tbl::where('guest_cart_id',$guest_cart_id)->delete('item_id',$item_id);
		}
		
		
		//ゲストカートテーブルからゲストidに該当する商品idを取得
		$item_id_date = guest_cart_tbl::select('item_id')->where('guest_id',$guest_id)->get();
		
		$item_id_lists = $item_id_date ->toArray();//配列化
		//var_dump($item_id_lists);
		
		//$item_id_listsの配列の数を数える
		$cun = count($item_id_lists);
		//echo $cun;
		
		
		//$item_id_listsを配列から文字列にする
		for($i = 0 ; $i < $cun; $i++ ){
		foreach($item_id_lists[$i] as $item_id_listss){
				$item_id_list[] = array($item_id_listss);
			}
		}
		
		//var_dump($item_id_list);
		
		
		//商品テーブルからitem_nameカラムを指定して商品名を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_names[$i] = item_tbl::select('item_name')->where('item_id',$item_id_list[$i])->get();
			
			//foreachで一つ値を引き出す
			foreach($item_names[$i] as $item_namess){
				$item_name[$i] = $item_namess->item_name;
			}
		}
		
		
	    //商品テーブルからitem_priceカラムを指定して価格を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_prices[$i] = item_tbl::select('item_price')->where('item_id',$item_id_list[$i])->get();
			foreach($item_prices[$i] as $item_pricess){
				$item_price[$i] =  $item_pricess->item_price;
			}	
		}
		
		
		//ゲストカートテーブルからカート内個数を取得し配列に格納
		for($i = 0 ; $i < $cun; $i++ ){
			$cart_nums[$i] = guest_cart_tbl::select('guest_cart_num')->where('item_id',$item_id_list[$i])->get();
			foreach($cart_nums[$i] as $cart_numss){
				$cart_num[$i] = $cart_numss->guest_cart_num;
			}	
		}
		

		
		//echo $item_price[0];
		//echo $cart_num[0];
		
		//合計金額の計算
	    for( $i = 0 ; $i < $cun; $i++ ){
	    	$price[$i] =  $item_price[$i] *  $cart_num[$i];
	    }
	    
	    //var_dump($price);
	    
	    $total_price = 0;
	    
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price += $price[$i];
	    }
	    
	    //カートになにも入っていないときの処理
	    if(empty($item_id)){
	    
	    $msg = 'カートにはなにも入っていません。';
	    
	    return view('board_user/cart_null',compact('msg'));
	    
	    }else{
	    
		return view('board_user/cart',compact('item_name','item_price','cart_num','total_price','cun'));
		}
		}
	}


//商品個別ページから遷移
	public function item(Request $request){
	
	//$user_id = 2;
	
	//会員かゲストか判別
	if(session()->has( 'user_name')){
	//if($user_id == 1){
	
	//会員としてログインしている場合↓
		//セッションから会員idを取得
		$user_id  = $request -> session()->get('user_id');
	
	//POSTで会員ID,商品ID,カート内個数を受け取る
	//$user_id =  $request['user_id'];
    
    $item_id = $request['item_id'];
    //$item_id = 1;
    
    $num = $request['cart_num'];
	//$num = 1;
	
	
	    //DBのcartテーブルに会員ID,商品ID,カート内個数を挿入
	    cart_tbl::insert([
	    'user_id' => $user_id,
        'item_id' => $item_id,
        'cart_num' => $num
	    ]);
	
	    
	    //カートテーブルから会員idに該当する商品idを取得
		$item_id_date = cart_tbl::select('item_id')->where('user_id',$user_id)->get();
		
		$item_id_lists = $item_id_date ->toArray();//配列化
		//var_dump($item_id_lists);
		
		//$item_id_listsの配列の数を数える
		$cun = count($item_id_lists);
		//echo $cun;
		
		
		//$item_id_listsを配列から文字列にする
		for($i = 0 ; $i < $cun; $i++ ){
		foreach($item_id_lists[$i] as $item_id_listss){
				$item_id_list[] = array($item_id_listss);
			}
		}
		
		//var_dump($item_id_list);
		
		
		//商品テーブルからitem_nameカラムを指定して商品名を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_names[$i] = item_tbl::select('item_name')->where('item_id',$item_id_list[$i])->get();
			
			//foreachで一つ値を引き出す
			foreach($item_names[$i] as $item_namess){
				$item_name[$i] = $item_namess->item_name;
			}
		}
		
		
	    //商品テーブルからitem_priceカラムを指定して価格を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_prices[$i] = item_tbl::select('item_price')->where('item_id',$item_id_list[$i])->get();
			foreach($item_prices[$i] as $item_pricess){
				$item_price[$i] =  $item_pricess->item_price;
			}	
		}
		
		
		//カートテーブルからカート内個数を取得し配列に格納
		for($i = 0 ; $i < $cun; $i++ ){
			$cart_nums[$i] = cart_tbl::select('cart_num')->where('item_id',$item_id_list[$i])->get();
			foreach($cart_nums[$i] as $cart_numss){
				$cart_num[$i] = $cart_numss->cart_num;
			}	
		}
		
		/*
		var_dump($item_name);
		var_dump($item_price);
		var_dump($cart_num);
		*/
		
		//echo $item_price[0];
		//echo $cart_num[0];
		
		//合計金額の計算
	    for( $i = 0 ; $i < $cun; $i++ ){
	    	$price[$i] =  $item_price[$i] *  $cart_num[$i];
	    }
	    
	    //var_dump($price);
	    
	    $total_price = 0;
	    
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price += $price[$i];
	    }
	    
	return view('board_user/cart',compact('item_name','item_price','cart_num','total_price','cun'));
	
	}else{
	
	//ゲストとしてログインしている場合↓
		//セッションからゲストidを取得
		$guest_id = $request -> session()->get('guest_id');
		
		//$guest_id = 1;
		
		//POSTで会員ID,商品ID,カート内個数を受け取る
		//$user_id =  $request['user_id'];
    
    	$item_id = $request['item_id'];
    
    	$num = $request['cart_num'];
	
		
	    //ゲスト用のcartテーブルに会員ID,商品ID,カート内個数を挿入
	    guest_cart_tbl::insert([
	    'guest_id' => $guest_id,
        'item_id' => $item_id,
        'guest_cart_num' => $num
	    ]);
		
		
		
		//ゲストカートテーブルから会員idに該当する商品idを取得
		$item_id_date = guest_cart_tbl::select('item_id')->where('guest_id',$guest_id)->get();
		
		$item_id_lists = $item_id_date ->toArray();//配列化
		//var_dump($item_id_lists);
		
		//$item_id_listsの配列の数を数える
		$cun = count($item_id_lists);
		//echo $cun;
		
		
		//$item_id_listsを配列から文字列にする
		for($i = 0 ; $i < $cun; $i++ ){
		foreach($item_id_lists[$i] as $item_id_listss){
				$item_id_list[] = array($item_id_listss);
			}
		}
		
		//var_dump($item_id_list);
		
		
		//商品テーブルからitem_nameカラムを指定して商品名を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_names[$i] = item_tbl::select('item_name')->where('item_id',$item_id_list[$i])->get();
			
			//foreachで一つ値を引き出す
			foreach($item_names[$i] as $item_namess){
				$item_name[$i] = $item_namess->item_name;
			}
		}
		
		
	    //商品テーブルからitem_priceカラムを指定して価格を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_prices[$i] = item_tbl::select('item_price')->where('item_id',$item_id_list[$i])->get();
			foreach($item_prices[$i] as $item_pricess){
				$item_price[$i] =  $item_pricess->item_price;
			}	
		}
		
		
		//ゲストカートテーブルからカート内個数を取得し配列に格納
		for($i = 0 ; $i < $cun; $i++ ){
			$cart_nums[$i] = guest_cart_tbl::select('guest_cart_num')->where('item_id',$item_id_list[$i])->get();
			foreach($cart_nums[$i] as $cart_numss){
				$cart_num[$i] = $cart_numss->guest_cart_num;
			}	
		}
		
		/*
		var_dump($item_name);
		var_dump($item_price);
		var_dump($cart_num);
		*/
		
		//echo $item_price[0];
		//echo $cart_num[0];
		
		//合計金額の計算
	    for( $i = 0 ; $i < $cun; $i++ ){
	    	$price[$i] =  $item_price[$i] *  $cart_num[$i];
	    }
	    
	    //var_dump($price);
	    
	    $total_price = 0;
	    
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price += $price[$i];
	    }
	    
	return view('board_user/cart',compact('item_name','item_price','cart_num','total_price','cun'));
	}
	}

}
