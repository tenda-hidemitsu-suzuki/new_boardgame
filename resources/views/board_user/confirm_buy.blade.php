<!DOCTYPE html>
<html>
	<head>
		<title>購入確認画面</title>
	</head>
	
	<body>
	
	<h1>内容のご確認</h1>
	<h2>購入内容にお間違いが無いかご確認ください。</h2>
	
	<p>商品名     値段     個数<br></p>
	<p>
	@for($i = 0 ; $i < $cun; $i++ )
    {{$item_name[$i]}}
    {{$item_price[$i]}}
    {{$cart_num[$i]}}<br>
	@endfor
	</p>
	
	<p>合計：￥{{$total_price}}円<br></p>
	
	
	<h2>お客様情報にお間違いが無いかご確認ください。</h2>
	<p>お名前:{{$user_name}}</p> <br>
	<p>フリガナ:{{$user_kana}}</p> <br>
	<p>郵便番号：〒{{$post}}</p> <br>
	<p>住所:{{$address}}</p> <br>
	<p>電話番号:{{$tel}}</p> <br>
	<p>メールアドレス:{{$mail}}</p> <br>
	<p>お支払方法:{{$pay}}</p> <br>
	
	
	<!-- 戻るボタンの生成 -->
	<form method ="get" action = "/board_user/input_buy">
	@csrf
		<input type="submit" value="戻る">
	</form>
	
	<!-- 購入を確定するボタンの生成 -->
	<form method ="post" action = "/board_user/complete_buy">
	@csrf
		<input type="hidden" name="user_name" value ="{{$user_name}}">
		<input type="hidden" name="user_kana" value ="{{$user_kana}}">
		<input type="hidden" name="post" value ="{{$post}}">
		<input type="hidden" name="address" value ="{{$address}}">
		<input type="hidden" name="tel" value ="{{$tel}}">
		<input type="hidden" name="mail" value ="{{$mail}}">
		<input type="hidden" name="pay" value ="{{$pay}}">
	
	<input type="submit" value="購入を確定する">
	</form>
	
	</body>
</html>
