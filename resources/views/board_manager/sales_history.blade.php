<!-- 販売履歴 -->
<html>
	<head>
		<title>販売履歴</title>
		<link rel="stylesheet" href="{{ asset('css/manager_home.css') }}">
	</head>
	
	<body>
		<p>管理画面</p>
		@include('board_manager.sidebar')
		<h2>販売履歴</h2>
		
		<!-- 販売履歴を表で表示 -->
		<section class="table-wrap">
			<table class="table" border="1" >
				<tr>
					<th width="200">id</th>
					<th width="200">同時購入id</th>
					<th width="200">商品名</th>
					<th width="200">購入個数</th>
					<th width="200">商品単価</th>
					<th width="200">氏名</th>
					<th width="200">フリガナ</th>
					<th width="200">住所</th>
					<th width="200">郵便番号</th>
					<th width="200">電話番号</th>
					<th width="200">メールアドレス</th>
					<th width="200">購入時間</th>
				</tr>
				
				@foreach ($datas as $data)
				<tr>
					<td width="200">{{$data['shop_id']}}</td>
					<td width="200">{{$data['purchase_st_id']}}</td>
					<td width="200">{{$data['item_name']}}</td>
					<td width="200">{{$data['purchase_num']}}</td>
					<td width="200">{{$data['item_price']}}</td>
					<td width="200">{{$data['customer_name']}}</td>
					<td width="200">{{$data['customer_kana']}}</td>
					<td width="200">{{$data['customer_address']}}</td>
					<td width="200">{{$data['customer_post']}}</td>
					<td width="200">{{$data['customer_tel']}}</td>
					<td width="200">{{$data['customer_mail']}}</td>
					<td width="200">{{$data['purchase_time_id']}}</td>
				</tr>
				@endforeach
			</table>
		</section>
	</body>
</html>
