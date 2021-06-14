<!DOCTYPE html>
<html>
	<head>
		<title>商品情報編集</title>
		<!-- ヘッダー呼び出し -->
		<!-- Styles -->
        <style>
		</style>
		<h1>商品情報編集</h1>
		@isset($msg)
		<font color="red">{{$msg}}</font>
		@endisset
		</head>
		<body>
		<h2>商品の追加</h2>
		<li>人数や時間の表記に幅がなく、一つの値しかない場合(例:30分程度、30分～等)には、最低と最高の両方に同じ値を入力してください。</li>
		<form method="post" action="./item_info_insert">
			@csrf
			@error('item_name')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>商品名:<br>
			<input type="text" name="item_name" value = "{{old('item_name')}}" placeholder="全角"></p>
			@error('item_price')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>商品価格:<br>
			<input type="number" name="item_price" value = "{{old('item_price')}}" placeholder="半角数字"></p>
			@error('age')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p>対象年齢:<br>
			<input type="number" name="age" value = "{{old('age')}}" placeholder="半角数字"></p>
			@error('player_min')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>最小プレイ人数:<br>
			<input type="number" name="player_min" value = "{{old('player_min')}}" placeholder="半角数字"></p>
			@error('player_max')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>最大プレイ人数:<br>
			<input type="number" name="player_max" value = "{{old('player_max')}}" placeholder="半角数字"></p>
			@error('time_min')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>最小プレイ時間:<br>
			<input type="number" name="time_min" value = "{{old('time_min')}}" placeholder="半角数字"></p>
			@error('time_max')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>最大プレイ時間:<br>
			<input type="number" name="time_max" value = "{{old('time_max')}}" placeholder="半角数字"></p>
			@error('length')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>縦:<br>
			<input type="number" name="length" value = "{{old('length')}}" placeholder="半角数字"></p>
			@error('width')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>横:<br>
			<input type="number" name="width" value = "{{old('width')}}" placeholder="半角数字"></p>
			@error('hight')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>高さ:<br>
			<input type="number" name="hight" value = "{{old('hight')}}" placeholder="半角数字"></p>
			<p>商品説明:<br>
			<textarea rows="5" clos="30" name="item_description">{{old('item_description')}}</textarea></p>
			<p><input type="submit" value="商品追加" id=item_info_edit></p>
			</form>
		</body>
		<body>
			<h2>商品の削除</h2>
			<form method="post" action="./item_info_delete">
			@csrf
			<p>商品id・商品名:<br>
			<select name="delete_item" >
	 			@foreach($item_lists as $item_list)
					<option value="{{$item_list['item_id']}}">{{$item_list['item_id']}}:{{$item_list['item_name']}}</option>
				@endforeach
			</select></p>
			<p><input type="submit" value="商品削除" id=item_info_edit></p>
			</form>
		</body>
		
		<body>
		<h2>商品情報の編集</h2>
		
		<form method="post" action="./item_info_edit_appoint">
			@csrf
			<p>商品id・商品名:<br>
			<select name="edit_item" >
	 			@foreach($item_lists as $item_list)
					<option value="{{$item_list['item_id']}}">{{$item_list['item_id']}}:{{$item_list['item_name']}}</option>
				@endforeach
			</select></p>
			<p><input type="submit" value="商品id指定" id=item_info_edit></p>
			</form>
		@isset($item_info)
		<li>人数や時間の表記に幅がなく、一つの値しかない場合(例:30分程度、30分～等)には、最低と最高の両方に同じ値を入力してください。</li>
		<form method="post" action="./item_info_edit">
			@csrf
			商品id:{{$item_info[0]['item_id']}}<br>
			@error('item_name')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>商品名:<br>
			<input type="text" name="item_name"  value = "{{$item_info[0]['item_name']}}"  placeholder="全角"></p>
			@error('item_price')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>商品価格:<br>
			<input type="number" name="item_price" value = "{{$item_info[0]['item_price']}}" placeholder="半角数字"></p>
			@error('age')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p>対象年齢:<br>
			<input type="number" name="age" value = "{{$item_info[0]['age']}}" placeholder="半角数字"></p>
			@error('player_min')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>最小プレイ人数:<br>
			<input type="number" name="player_min" value = "{{$item_info[0]['player_num_min']}}" placeholder="半角数字"></p>
			@error('player_max')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>最大プレイ人数:<br>
			<input type="number" name="player_max" value = "{{$item_info[0]['player_num_max']}}" placeholder="半角数字"></p>
			@error('time_min')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>最小プレイ時間:<br>
			<input type="number" name="time_min" value = "{{$item_info[0]['player_time_min']}}" placeholder="半角数字"></p>
			@error('time_max')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>最大プレイ時間:<br>
			<input type="number" name="time_max" value = "{{$item_info[0]['player_time_max']}}" placeholder="半角数字"></p>
			@error('length')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>縦:<br>
			<input type="number" name="length" value = "{{$item_info[0]['length']}}" placeholder="半角数字"></p>
			@error('width')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>横:<br>
			<input type="number" name="width" value = "{{$item_info[0]['width']}}" placeholder="半角数字"></p>
			@error('hight')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p><font color="red">必須</font>高さ:<br>
			<input type="number" name="hight" value = "{{$item_info[0]['hight']}}" placeholder="半角数字"></p>
			<p>商品説明:<br>
			<textarea rows="5" clos="30" name="item_description">{{$item_info[0]['item_description']}}</textarea></p>
			<input type="hidden" name="edit_item" value = "{{$item_info[0]['item_id']}}" >
			<p><input type="submit" value="変更" id=item_info_edit></p>
			</form>
			@endisset
		</body>
		<body>
			<h2>商品タグ編集</h2>
			<form method="post" action="./item_tag_edit_appoint">
			@csrf
			<p>商品id・商品名:<br>
			<select name="tag_edit_item" >
	 			@foreach($item_lists as $item_list)
					<option value="{{$item_list['item_id']}}">{{$item_list['item_id']}}:{{$item_list['item_name']}}</option>
				@endforeach
			</select></p>
			<p><input type="submit" value="商品id指定" id=item_info_edit></p>
			</form>
			@isset($item_tag_info)
				商品id:{{$item_tag_info[0]['item_id']}}
				商品にタグを追加
				<form method="post" action="./item_tag_add">
				@csrf
				<p>タグ名:<br>
				<select name="item_tag_add" >
		 			@foreach($not_used_tags as $add_tag)
						<option value="{{$add_tag['tag_id']}}">{{$add_tag['tag_id']}}:{{$add_tag['tag_name']}}</option>
					@endforeach
				</select></p>
				<input type="hidden" name="tag_add_item_id" value = "{{$item_tag_info[0]['item_id']}}" >
				<p><input type="submit" value="追加" id=item_info_edit></p>
				</form>
					
				
				商品からタグを削除
				<br>
				@if(count($item_tag_info)==1)
					現在つけられているタグ
					<br>
					{{$item_tag_info[0]['tag_id']}}:{{$item_tag_info[0]['tag_name']}}
					<br>
					<font color="red">これ以上タグを減らせません。</font>
				@else
					<form method="post" action="./item_tag_delete">
					@csrf
					<p>タグ名:<br>
					<select name="item_tag_delete" >
			 			@foreach($item_tag_info as $delete_tag)
							<option value="{{$delete_tag['tag_id']}}">{{$delete_tag['tag_id']}}:{{$delete_tag['tag_name']}}</option>
						@endforeach
					</select></p>
					<input type="hidden" name="tag_delete_item_id" value = "{{$item_tag_info[0]['item_id']}}" >
					<p><input type="submit" value="削除" id=item_info_edit></p>
					</form>
				@endif
			@endisset
		</body>
		<body>
			<h2>新しいタグの登録</h2>
			<form method="post" action="./tag_add">
			@csrf
			<p>タグ名:<br>
			<input type="text" name="add_tag_name"></p>
			<p><input type="submit" value="登録" id=item_info_edit></p>
			</form>
		</body>
		<body>
			<h2>タグの削除</h2>
			<form method="post" action="./tag_delete">
			@csrf
			<p>タグ名:<br>
			<select name="tag_delete" >
	 			@foreach($not_used_tags_delete as $delete_tag)
					<option value="{{$delete_tag['tag_id']}}">{{$delete_tag['tag_id']}}:{{$delete_tag['tag_name']}}</option>
				@endforeach
			</select></p>
			<p><input type="submit" value="削除" id=item_info_edit></p>
			</form>
		</body>