<!-- 簡単検索編集 -->
<html>
	<head>
		<title>簡単検索編集</title>
		<link rel="stylesheet" href="{{ asset('css/manager_home.css') }}">
	</head>
	
	<body>
		<p>管理画面</p>
		@include('board_manager.sidebar')
		<h1>簡単検索編集</h1>
		
		<div class="all">
		<form method ="post" action = "/board_manager/simple_search">
		@csrf
			<p>簡単検索に追加したいタグを選んでください</p>
			<p class="left">
        		<select name="add_tag">
        			@foreach ($tables as $table)
    					<option value="{{$table['tag_name']}}">{{$table['tag_name']}}</option>
    				@endforeach
    			</select>
    			<button type="submit">追加する</button>
			</p>
		</form>
		
		<!-- 追加されたことを表示する文言 -->
		<p>{{$add_msg}}</p>
		
		<form method ="post" action = "/board_manager/simple_search">
		@csrf
		<p>簡単検索から削除したいタグを選んでください</p>
		<p class="left">
    		<select name="delete_tag">
        			@foreach ($tables as $table)
    					<option value="{{$table['tag_name']}}">{{$table['tag_name']}}</option>
    				@endforeach
    			</select>
    		<button type="submit">削除する</button>
		</p>
		</form>
		
		<!-- 削除されたことを表示する文言 -->
		<p>{{$delete_msg}}</p>
		
		
		</div>
		
	</body>
</html>
