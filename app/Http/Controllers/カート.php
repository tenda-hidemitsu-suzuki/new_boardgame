<?php

namespace App\Http\Controllers;

//モデル
use App\Models\cart_tbl;
use App\Models\guest_cart_tbl;
use App\Models\item_tbl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{

//ヘッダーから遷移
	public function header(Request $request){
	
	$user_id = 1;
	
	//会員かゲストか判別
	//if(isset($request->session()->get('user_name'))){
	if($user_id == 1){
	
	//会員としてログインしている場合↓
		//セッションから会員idを取得
		//$user_id  = $request -> session()->get('user_id');
		
		
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
				$cart_ids = cart_tbl::select('cart_id')->where('user_id',$user_id)->get();
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
				$cart_ids = cart_tbl::select('cart_id')->where('user_id',$user_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
				
				//カートテーブルの商品の数量を1減らす
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
				$cart_ids = cart_tbl::select('cart_id')->where('user_id',$user_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
			    
				//カートテーブルの商品idを削除
				cart_tbl::where('cart_id',$cart_id)->delete('item_id',$item_id);
		}
		
		
		//カートテーブルから会員idに該当する商品idを取得
		$item_id_date = cart_tbl::select('item_id')->where('user_id',$user_id)->get();
		
		$item_id_list = $item_id_date ->toArray();//配列化
		
		//$item_id_listの配列の数を数える
		$cun = count($item_id_list);
		
		
		//商品テーブルからitem_nameカラムを指定して商品名を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_names[] = item_tbl::select('item_name')->where('item_id',$item_id_list[$i])->get();
			
			//foreachで一つ値を引き出す
			foreach($item_names[$i] as $item_name){
				$item_name = array($item_name->item_name);
			}
		}
		
		
	    //商品テーブルからitem_priceカラムを指定して価格を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_prices[] = item_tbl::select('item_price')->where('item_id',$item_id_list[$i])->get();
			
			foreach($item_prices[$i] as $item_price){
				$item_price =array( $item_price->item_price);
			}	
		}
		
		
		//カートテーブルからカート内個数を取得し配列に格納
		for($i = 0 ; $i < $cun; $i++ ){
			$cart_nums[] = cart_tbl::select('cart_num')->where('user_id',$user_id)->get();
			
			foreach($cart_nums[$i] as $cart_num){
				$cart_num = array($cart_num->cart_num);
			}	
		}
		
		
		//合計金額の計算
		$price = [];
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    	$price[] =  $item_price[$i] *  $cart_num[$i];
	    }
	    
	    $total_price = 0;
	    
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price += $price[$i];
	    }
	    
	return view('cart',compact('item_name','item_price','cart_num','total_price','cun'));
	
	}else{

	//ゲストとしてログインしている場合↓
		//セッションからゲストidを取得
		//$guest_id = $request -> session()->get('guest_id');
		
		$guest_id = 1;
		
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
				
				//ゲストカートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = guest_cart_tbl::select('guest_cart_id')->where('guest_id',$guest_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
				
				//ゲストカートテーブルの商品の数量を1増やす
				guest_cart_tbl::where('guest_cart_id',$cart_id)->where('item_id',$item_id)->update(['guest_cart_num' => $num]);
		}
		
		//カートページで-ボタンが押されたときの処理
		if(!empty($request->add)){
			//POSTの受け取り
			$name = $request->item_name;
			$num = $request->cart_num;
			$num = --$num;
			
				//商品テーブルから$nameに該当する商品idを取得
				$item_ids = item_tbl::select('item_id')->where('item_name',$name)->get();
				foreach($item_ids as $item_id){
					$item_id = $item_id->item_id;
			    }
				
				//ゲストカートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = guest_cart_tbl::select('guest_cart_id')->where('guest_id',$guest_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
				
				//ゲストカートテーブルの商品の数量を1減らす
				guest_cart_tbl::where('guest_cart_id',$cart_id)->where('item_id',$item_id)->update(['guest_cart_num' => $num]);
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
				
				//ゲストカートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = guest_cart_tbl::select('guest_cart_id')->where('user_id',$user_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
			    
				//ゲストカートテーブルの商品idを削除
				guest_cart_tbl::where('cart_id',$cart_id)->delete('item_id',$item_id);
		}
		
		
		//ゲストカートテーブルからゲストidに該当する商品idを取得しリスト化
		$item_id_date = \DB::table('guest_cart_tbl')->select('item_id')->where('guest_id','$guest_id')->get();
		$item_id_list = $item_id_date ->toArray();//配列化
		
		//$item_id_listの配列の数を数える
		$cun = count($item_id_list);
		
		//商品テーブルからitem_nameカラムを指定して商品名を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_names[] = item_tbl::select('item_name')->where('item_id',$item_id_list[$i])->get();
			
			//foreachで一つ値を引き出す
			foreach($item_names[$i] as $item_name){
				$item_name = array($item_name->item_name);
			}
		}
		
	    //商品テーブルからitem_priceカラムを指定して価格を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_prices[] = item_tbl::select('item_price')->where('item_id',$item_id_list[$i])->get();
			
			foreach($item_prices[$i] as $item_price){
				$item_price =array( $item_price->item_price);
			}	
		}
		
		
		//ゲストカートテーブルからカート内個数を取得し配列に格納
		for($i = 0 ; $i < $cun; $i++ ){
			$cart_nums[] = guest_cart_tbl::select('cart_num')->where('guest_id',$guest_id)->get();
			
			foreach($cart_nums[$i] as $cart_num){
				$cart_num = array($cart_num->cart_num);
			}	
		}
		
		
		//合計金額の計算
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    	$price[] =  $item_price[$i] *  $cart_num[$i];
	    }
	    
	    $total_price = 0;
	    
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price += $price[$i];
	    }
	    
	return view('cart',compact('item_name','item_price','cart_num','total_price','cun'));
	}
	}





//商品個別ページから遷移
	public function item(Request $request){
	
	//$user_id = 1;
	    
	//会員かゲストか判別
    if(session()->has( 'user_name')){
	//if($user_id == 1){
	//会員としてログインしている場合↓
		//セッションから会員idを取得

	//var_dump($user_id);
	//POSTで会員ID,商品ID,カート内個数を受け取る

	$user_id   = $request->session()->get('user_id');
    $item_id = $request['item_id'];
    //$item_id = 1;
    //$num = 1;
    $cart_num = $request['cart_num'];
    echo "$user_id";
    echo "$item_id";
    echo "$cart_num";
    /*

	    //DBのcartテーブルに会員ID,商品ID,カート内個数を挿入
	    cart_tbl::insert([
	    'user_id' => $user_id,
        'item_id' => $item_id,
        'cart_num' => $cart_num
	    ]);
   */
    //もしカートへ入れるボタンが押されたら
    if(!empty($request->shop_check)){
        DB::insert('INSERT INTO cart_tbl(user_id, item_id, cart_num) values(?,?,?)',[$user_id,$item_id,$cart_num]);
    }
	    
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
				$cart_ids = cart_tbl::select('cart_id')->where('user_id',$user_id)->get();
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
				$cart_ids = cart_tbl::select('cart_id')->where('user_id',$user_id)->get();
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
				$cart_ids = cart_tbl::select('cart_id')->where('user_id',$user_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
			    
				//カートテーブルの商品idを削除
				cart_tbl::where('cart_id',$cart_id)->delete('item_id',$item_id);
		}
	    
	    
	    //カートテーブルから会員idに該当する商品idを取得
		$item_id_date = cart_tbl::select('item_id')->where('user_id',$user_id)->get();
		$item_id_list = $item_id_date ->toArray();//配列化
		
		//$item_id_listの配列の数を数える
		$cun = count($item_id_list);
		
		
		//商品テーブルからitem_nameカラムを指定して商品名を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_names[] = item_tbl::select('item_name')->where('item_id',$item_id_list[$i])->get();
			
			
			//foreachで一つ値を引き出す
			foreach($item_names[$i] as $item_name){
				$item_name = array($item_name->item_name);
			}
		}
		
	    //商品テーブルからitem_priceカラムを指定して価格を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_prices[] = item_tbl::select('item_price')->where('item_id',$item_id_list[$i])->get();
			
			foreach($item_prices[$i] as $item_price){
				$item_price =array( $item_price->item_price);
			}	
		}
		
		
		//カートテーブルからカート内個数を取得し配列に格納
		for($i = 0 ; $i < $cun; $i++ ){
			$cart_nums[] = cart_tbl::select('cart_num')->where('user_id',$user_id)->get();
			
			foreach($cart_nums[$i] as $cart_num){
				$cart_num = array($cart_num->cart_num);
			}	
		}
		/*
		//$price = [];
		//合計金額の計算
		$total_price =0;
		for( $i = 0 ; $i < $cun; $i++ ){
		    $total_price +=  $item_price[$i] * $cart_num[$i];
		}
		*/
		
		for( $i = 0 ; $i < $cun; $i++ ){
		    $price[] =  $item_price[$i] *  $cart_num[$i];
		}
		
		$total_price = 0;
		
		for( $i = 0 ; $i < $cun; $i++ ){
		    $total_price += $price[$i];
		}
		
		
		

	    //$total_price = 1500;
	    
	return view('board_user.cart',compact('item_name','item_price','cart_num','total_price','cun'));
	
	}else{
	
	//ゲストとしてログインしている場合↓
		//セッションからゲストidを取得
		$guest_id = $request -> session()->get('guest_id');
		
		//POSTで会員ID,商品ID,カート内個数を受け取る
		//$user_id =  $request['user_id'];
    
    	$item_id = $request['item_id'];
    
    	$num = $request['guest_cart_num'];
	
	    //ゲスト用のcartテーブルに会員ID,商品ID,カート内個数を挿入
	    guest_cart_tbl::insert([
	    'guest_id' => $guest_id,
        'item_id' => $item_id,
        'cart_num' => $guest_cart_num
	    ]);
		
		
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
				
				//ゲストカートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = guest_cart_tbl::select('guest_cart_id')->where('guest_id',$guest_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
				
				//ゲストカートテーブルの商品の数量を1増やす
				guest_cart_tbl::where('guest_cart_id',$cart_id)->where('item_id',$item_id)->update(['guest_cart_num' => $num]);
		}
		
		//カートページで-ボタンが押されたときの処理
		if(!empty($request->add)){
			//POSTの受け取り
			$name = $request->item_name;
			$num = $request->cart_num;
			$num = --$num;
			
				//商品テーブルから$nameに該当する商品idを取得
				$item_ids = item_tbl::select('item_id')->where('item_name',$name)->get();
				foreach($item_ids as $item_id){
					$item_id = $item_id->item_id;
			    }
				
				//ゲストカートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = guest_cart_tbl::select('guest_cart_id')->where('guest_id',$guest_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
				
				//ゲストカートテーブルの商品の数量を1減らす
				guest_cart_tbl::where('guest_cart_id',$cart_id)->where('item_id',$item_id)->update(['guest_cart_num' => $num]);
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
				
				//ゲストカートテーブルから商品idと会員idに該当するカートidを取得
				$cart_ids = guest_cart_tbl::select('guest_cart_id')->where('user_id',$user_id)->get();
				foreach($cart_ids as $cart_id){
					$cart_id = $cart_id->cart_id;
			    }
			    
				//ゲストカートテーブルの商品idを削除
				guest_cart_tbl::where('cart_id',$cart_id)->delete('item_id',$item_id);
		}
		
		
		//ゲストカートテーブルからゲストidに該当する商品idを取得しリスト化
		$item_id_date = \DB::table('guest_cart_tbl')->select('item_id')->where('guest_id','$guest_id')->get();
		$item_id_list = $item_id_date ->toArray();//配列化
		
		//$item_id_listの配列の数を数える
		$cun = count($item_id_list);
		
		//商品テーブルからitem_nameカラムを指定して商品名を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_name[] = \item_tbl::select('item_name')->where('item_id','$item_id_list[$i]')->get();	
		}
	    
	    //商品テーブルからitem_priceカラムを指定して価格を取得し配列に格納
	    for($i = 0 ; $i < $cun; $i++ ){
			$item_price[] = item_tbl::select('item_price')->where('item_id','$item_id_list[$i]')->get();
		}
		
		
		//ゲストカートテーブルからカート内個数を取得し配列に格納
		for($i = 0 ; $i < $cun; $i++ ){
			$cart_num[] = guest_cart_tbl::select('guest_cart_num')->where('guest_id','$guest_id')->get();
		}
		
		//合計金額の計算
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price +=  $item_price[$i] * $cart_num[$i];
	    }
	
	return view('cart',compact('item_name','item_price','cart_num','total_price','cun'));
	}
	}

}
