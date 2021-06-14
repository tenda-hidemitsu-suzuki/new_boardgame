<html>
	<head>
		<title>購入完了画面</title>
	</head>
	
	<body>
	<h1>ご購入いただきありがとうございます！</h1><br>
	
	<p>購入した商品     値段     個数<br></p>
	
	@for($i = 0 ; $i < $cun; $i++ )
    {{$item_name[$i]}}
    {{$item_price[$i]}}
    {{$cart_num[$i]}}<br>
	@endfor

	



	<p>合計：￥{{$total_price}}円<br></p>
	
	<form method ="get" action = "/board_user/home_page">
	@csrf
		<input type="submit" value="ホームへ戻る">
	</form>
	
	
	</body>
</html>
