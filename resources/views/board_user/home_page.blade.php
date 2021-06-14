<!DOCTYPE html>
<html>
	<head>
		<title>ホーム</title>
		<!-- ヘッダー呼び出し -->
		<!-- Styles -->
        <style>
		</style>
		<h1>ホーム</h1>
		</head>
		<!-- 検索機能 -->
		<body class=search>
		@include('board_user.header')
			<h2>検索機能</h2>
			{{-- 初期値は基本的には"設定しない"に設定。POSTで送られていたならばその項目を初期値に設定 --}}
			{{-- postで送られた検索条件は$search_infoに配列として格納されている --}}
			{{-- タグの内容(id,タグ名)は$tag_listsに格納されている。簡単タグかどうかは選別された状態で --}}
			<form method="post" action="./item_list">
			@csrf
			<p>タイトル:<br>
			<input type="text" name="search_name" @if(isset($search_info['name'])) value={{$search_info['name']}} @endif></p>
			<p>対象年齢:<br>
			<select name="age" >
				<option value=2147483647 @if($search_info['age']==0) selected @endif>設定しない</option>
	 			@for($forAge=0; $forAge<20; $forAge++)
					<option value={{$forAge}} @if($search_info['age']==$forAge) selected @endif>{{$forAge}}</option>
				@endfor
			</select></p>
			
			<p>人数:<br>
			<select name="player_num" >
					<option value=0 @if($search_info['player_num']==0) selected @endif>設定しない</option>
	 			@for($i=1; $i<10; $i++)
					<option value={{$i}} @if($search_info['player_num']==$i) selected @endif>{{$i}}</option>;
				@endfor
			</select></p>
			
			<p>タグ:<br>
			<select name="tag" >
				{{-- $search_info['tag_id']にはidが入っている --}}
				<option value=0 @if($search_info['tag_id']==0) selected @endif>設定しない</option>
	 			@foreach($tag_lists as $tag_list)
					<option value={{$tag_list['tag_id']}} @if($search_info['tag_id']==$tag_list['tag_id']) selected @endif>{{$tag_list['tag_name']}}</option>
				@endforeach
			</select></p>
			
			<p>時間:<br>
			<select name="time">
			<option value=0 @if($search_info['time']==0) selected @endif>設定しない</option>
			<option value=1 @if($search_info['time']==1) selected @endif>0～10分</option>
			<option value=2 @if($search_info['time']==2) selected @endif>10～30分</option>
			<option value=3 @if($search_info['time']==3) selected @endif>30～60分</option>
			<option value=4 @if($search_info['time']==4) selected @endif>60分～</option>
			</select></p>
			<p>値段:<br>
			<select name="price">
			<option value=0 @if($search_info['price']==0) selected @endif>設定しない</option>
			<option value=1 @if($search_info['price']==1) selected @endif>0～1000円</option>
			<option value=2 @if($search_info['price']==2) selected @endif>1000～3000円</option>
			<option value=3 @if($search_info['price']==3) selected @endif>3000～5000円</option>
			<option value=4 @if($search_info['price']==4) selected @endif>5000～10000円</option>
			<option value=4 @if($search_info['price']==5) selected @endif>10000円～</option>
			</select></p>
			<p>持ち運びやすさ<p>
			<select name="size">
			<option value=0 @if($search_info['size']==0) selected @endif>設定しない</option>
			<option value=1 @if($search_info['size']==1) selected @endif>持ち運びやすい</option>
			</select>
			<p>ソート:<br>
			<select name="sort">
			<option value=0 @if($search_info['sort']==0) selected @endif>人気順</option>
			<option value=1 @if($search_info['sort']==1) selected @endif>安い順</option>
			</select></p>
			<input type="hidden" name="tag_type" value={{$search_info['tag_type']}}>
			<p><input type="submit" value="検索" id=search_button></p>
			</form>
			{{-- タグ選択肢を変更し、ページ遷移 --}}
			@if($search_info['tag_type']==1)
			<form method="get" action="./item_list_all_tag">
			@csrf
			<input type="submit" value="タグの選択肢を増やす">
			@else
			<form method="get" action="./item_list">
			@csrf
			<input type="submit" value="タグの選択肢を減らす">
			@endif
			</form>
			{{-- ページ遷移し、コントローラーで初期値を格納し、検索条件をクリア --}}
			<form method="get" action="./item_list">
			<p><input type="submit" value="条件クリア" id=search_button></p>
			</form>
		</body>
		<body>
			<h2>バナー</h2>
			@foreach($banner_tag_lists as $banner_tag_list)
				<form method="POST" action="./banner" >
	    		@csrf
  				<input type="hidden" name="tag_id" value={{$banner_tag_list['tag_id']}}>
  				<input type="submit" value={{$banner_tag_list['tag_name']}}>
  				</form>
			@endforeach
		</body>
		<body>
			<h2>ランキング</h2>
			<table>

			<!-- 3位までのランキングを表示 -->
				<?php $rank=1; ?>
				@foreach($items as $item)
					<div>
						{{ $rank }}位 <!--順位-->
						<img src="{{ asset('img/'.$item['item_id'].'.jpg') }}"> <!--商品画像-->
						{{$item['item_name']}} <!--商品名-->
						{{$item['item_price']}} <!--商品価格-->
						円　
						販売数:
						{{$item['sale_num']}} <!--販売個数-->
					</div>
					
					<?php $rank++; ?>
				@endforeach
				
				
			</table>

		</body>