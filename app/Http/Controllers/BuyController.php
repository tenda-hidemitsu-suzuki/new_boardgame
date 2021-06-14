<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

//この下に使うモデルを記載
use App\Models\user_tbl;
use App\Models\cart_tbl;
use App\Models\guest_cart_tbl;
use App\Models\item_tbl;
use App\Models\shop_history_tbl;
use App\Models\shop_detail_tbl;


//この下に使うバリデーションルールを記載
use App\Rules\name_full;
use App\Rules\name_kana;
//use App\Rules\double_check;

class BuyController extends Controller
{
    //購入画面に最初に表示させるクラスを作成
    public function index(Request $request){
    
    //セッションから会員idを取得
	$user_name  = $request -> session()->get('user_name');
	$user_id  = $request -> session()->get('user_id');
	//$user_id = 1;
	
	/*
        if(session()->has( 'user_name')){
	
        	$user_names = user_tbl::select('user_name')->where('user_id',$user_id)->get();
        	$user_kanas = user_tbl::select('user_kana')->where('user_id',$user_id)->get();
        	$posts = user_tbl::select('post')->where('user_id',$user_id)->get();
        	$addresss = user_tbl::select('address')->where('user_id',$user_id)->get();
        	$tels = user_tbl::select('tel')->where('user_id',$user_id)->get();
        	$mails = user_tbl::select('mail')->where('user_id',$user_id)->get();
        	
        		//foreachで一つ値を引き出す
        			foreach($user_names as $user_name){
        					$user_name = $user_name->user_name;
        			    }
        			foreach($user_kanas as $user_kana){
        					$user_kana = $user_kana->user_kana;
        			    }
        			foreach($posts as $post){
        					$post = $post->post;
        			    }
        			foreach($addresss as $address){
        					$address = $address->address;
        			    }
        			foreach($tels as $tel){
        					$tel = $tel->tel;
        			    }
        			foreach($mails as $mail){
        					$mail = $mail->mail;
        			    }
    	
            return view('board_user/input_buy',compact('user_name','user_kana','post','address','tel','mail'));
        }
    */
        $msg=[
            'user_name' =>'',
            'user_kana' =>'',
            'post' =>'',
            'address' =>'',
            'tel' =>'',
            'mail' =>'',
        ];
        
        return view('board_user/input_buy', $msg);
        
        
        
        
    }
    
    
    //バリデーションを実行してうまくいけば購入確認画面へ遷移
    public function buy_check(Request $request)
    {
        //バリデーションの規則を記載
        $validate_rule = [
            'user_name' => ['required', new name_full],
            'user_kana' => ['required', new name_full, new name_kana],
            'post' => ['required', 'digits:7', 'numeric'],
            'address' => ['required'],
            'tel' => ['required', 'digits_between:10,11', 'numeric'],
            'mail' => ['required', 'email'],
        ];
        //バリデーションの実行
        $this->validate($request, $validate_rule);
        
        
        //バリデーションチェックに成功した場合、購入確認画面へ遷移
        //値の受け取り
        $user_name = $request->user_name;
        $user_kana = $request->user_kana;
        $post = $request->post;
        $address = $request->address;
        $tel = $request->tel;
        $mail = $request->mail;
        $pay = $request->pay;
        
        /*
        //値の配列化
        $msg=[
            'user_name' => $user_name,
            'user_kana' => $user_kana,
            'post' => $post,
            'address' => $address,
            'tel' => $tel,
            'mail' => $mail,
            'pay' => $pay
        ];
        */
        
	
	//会員かゲストか判別
    if(session()->has( 'user_name')){
	
	//$user_id = 1;
	//if($user_id == 1){
	
	//会員としてログインしている場合↓
		//セッションから会員idを取得
		$user_id  = $request -> session()->get('user_id');
		
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
	    
	return view('/board_user/confirm_buy',compact('item_name','item_price','cart_num','total_price','cun','user_name','user_kana','post','address','tel','mail','pay'));
	
	}else{

	//ゲストとしてログインしている場合↓
		//セッションからゲストidを取得
		$guest_id = $request -> session()->get('guest_id');
		
		//$guest_id = 1;
		
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
	    
	return view('/board_user/confirm_buy',compact('item_name','item_price','cart_num','total_price','cun','user_name','user_kana','post','address','tel','mail','pay'));
	}
    }
    
    
    //購入内容を購入履歴テーブルに登録＆購入完了ページへ遷移
    public function buy_insert(Request $request)
    {
    
    //お客様情報の値の受け取り
        $user_name = $request->user_name;
        $user_kana = $request->user_kana;
        $post = $request->post;
        $address = $request->address;
        $tel = $request->tel;
        $mail = $request->mail;
        
        
        //DBのショッピングテーブル(購入履歴)テーブルに追加
        $purchase_st_id = shop_history_tbl::insertGetId([ 
            'customer_name' => $user_name, 
            'customer_kana' => $user_kana,
            'customer_post' => $post,
            'customer_address' => $address,
            'customer_tel' => $tel,
            'customer_mail' => $mail,
            'purchase_time_id' => now()
        ]);
        
        //echo  $purchase_st_id;
        
	    
		
		//会員かゲストか判別
        if(session()->has( 'user_name')){
		
		//$user_id = 1;
		//if($user_id == 1){
	
	//会員としてログインしている場合↓
		//セッションから会員idを取得
		$user_id  = $request -> session()->get('user_id');
		
		//カートテーブルから会員idに該当する商品idを取得
		$item_id_date = cart_tbl::select('item_id')->where('user_id',$user_id)->get();
		
		$item_id_lists = $item_id_date ->toArray();//配列化
		
		//$item_id_listsの配列の数を数える
		$cun = count($item_id_lists);
		
		//$item_id_listsを配列から文字列にする
		for($i = 0 ; $i < $cun; $i++ ){
		foreach($item_id_lists[$i] as $item_id_listss){
				$item_id_list[$i] = $item_id_listss;
			}
		}
		
		
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
		
		
		//商品idに該当する販売個数を取得
		for($i = 0 ; $i < $cun; $i++ ){
			$sale_nums[$i] = item_tbl::select('sale_num')->where('item_id',$item_id_list[$i])->get();
			foreach($sale_nums[$i] as $sale_numss){
				$sale_num[$i] = $sale_numss->sale_num;
			}
		}
		
		
		
		//販売個数のupdate
		for($i = 0 ; $i < $cun; $i++ ){
        	item_tbl::where('item_id',$item_id_list[$i])->update(['sale_num' => $sale_num[$i] + $cart_num[$i]]);
		}
		
		//var_dump($item_id_list);
		
		//DBのショッピングテーブル(詳細)テーブルに追加
		for($i = 0 ; $i < $cun; $i++ ){
		
			shop_detail_tbl::insert([ 
            	'purchase_st_id' => $purchase_st_id, 
            	'item_id' => $item_id_list[$i],
            	'purchase_num' => $cart_num[$i],
            	'item_price' => $item_price[$i]
        	]);
		}
		
		
		//合計金額の計算
	    for( $i = 0 ; $i < $cun; $i++ ){
	    	$price[$i] =  $item_price[$i] *  $cart_num[$i];
	    }
	    
	    //var_dump($price);
	    
	    $total_price = 0;
	    
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price += $price[$i];
	    }
	
	//登録完了画面へ遷移
	return view('/board_user/complete_buy',compact('item_name','item_price','cart_num','total_price','cun'));
	
	}else{

	//ゲストとしてログインしている場合↓
		//セッションからゲストidを取得
		$guest_id = $request -> session()->get('guest_id');
		
		//$guest_id = 1;
		
		//ゲストカートテーブルからゲストidに該当する商品idを取得
		$item_id_date = \DB::table('guest_cart_tbl')->select('item_id')->where('guest_id','$guest_id')->get();
		
		$item_id_lists = $item_id_date ->toArray();//配列化
		
		//$item_id_listsの配列の数を数える
		$cun = count($item_id_lists);
		
		
		//$item_id_listsを配列から文字列にする
		for($i = 0 ; $i < $cun; $i++ ){
		foreach($item_id_lists[$i] as $item_id_listss){
				$item_id_list[] = array($item_id_listss);
			}
		}
		
		
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
		
		//商品idに該当する販売個数を取得
		for($i = 0 ; $i < $cun; $i++ ){
			$sale_nums[] = item_tbl::select('sale_num')->where('item_id',$item_id_lists[$i])->get();
			
			foreach($sale_nums[$i] as $sale_num){
				$sale_num =array( $sale_num->sale_num);
			}	
		}
		//販売個数のupdate
		for($i = 0 ; $i < $cun; $i++ ){
        	item_tbl::where('item_id',$item_id_lists[$i])->update(['sale_num' => $sale_num[$i] + $cart_num[$i]]);
		}
		
		
		//DBのショッピングテーブル(詳細)テーブルに追加
		for($i = 0 ; $i < $cun; $i++ ){
			shop_detail_tbl::insert([ 
            	'purchase_st_id' => $purchase_st_id, 
            	'item_id' => $item_id_list[$i],
            	'purchase_num' => $cart_num[$i],
            	'item_price' => $item_price[$i]
        	]);
		}
		
		
		//合計金額の計算
	    for( $i = 0 ; $i < $cun; $i++ ){
	    	$price[$i] =  $item_price[$i] *  $cart_num[$i];
	    }
	    
	    //var_dump($price);
	    
	    $total_price = 0;
	    
	    for( $i = 0 ; $i < $cun; $i++ ){ 
	    $total_price += $price[$i];
	    }
	
	//登録完了画面へ遷移
	return view('/board_user/complete_buy',compact('item_name','item_price','cart_num','total_price','cun'));
	}
    }
    
}
?>
