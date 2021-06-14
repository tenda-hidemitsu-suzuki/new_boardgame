<html>
	<head>
		<title>商品個別ページ</title>
	</head>
	
	<body>
	@include('board_user.header')
	
	
	
	<!-- 画像を表示する部分をここに作る -->
	@foreach ($items as $item)
	<div>
		<img class="item" src="{{ asset('img/'.$item['item_id'].'.jpg') }}">
	</div>
	
	<p>
		商品名<br>
		{{$item['item_name']}}<br>
	</p>
	
	<p>
		値段<br>
		{{$item['item_price']}}<br>
	</p>
	
	<p id="player_num">
		プレイ人数<br>
		{{$item['player_num_min']}}～{{$item['player_num_max']}}<br>
	</p>
	
	
	<p id="player_time">
		プレイ時間<br>
		{{$item['player_time_min']}}～{{$item['player_time_max']}}<br>
	</p>
	
	<p>
		対象年齢<br>
		{{$item['age']}}<br>
	</p>
	
	<p>
		ルール<br>
		{{$item['item_description']}}<br>
	</p>
	
	<p>
		サイズ<br>
		縦：{{$item['length']}}×横：{{$item['width']}}×高さ：{{$item['hight']}}<br>
	</p>
	@endforeach
	
	<!-- タグの表示を以下に行う -->
	<section>
		<div>
			タグ
    	</div>
			@foreach ($tags as $tag)
				<p>{{$tag['tag_name']}}</p>
			@endforeach
	</section>
	
	
	<!-- カートに入れるボタンを押してカートページへ遷移する -->
	<form method ="post" action = "/board_user/cart_item">
		@csrf
		<input type="hidden" name="shop_check" value="shop_check">
		<input type="hidden" name="item_id" value="{{$item_id}}">
		<input type="hidden" name="cart_num" value="1" >
		<input type="submit" value="カートに入れる">
	</form>
	
	</body>
</html>
