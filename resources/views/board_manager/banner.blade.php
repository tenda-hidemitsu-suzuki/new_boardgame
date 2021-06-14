<!-- バナー編集 -->
<html>
	<head>
		<title>バナー編集</title>
		<link rel="stylesheet" href="{{ asset('css/manager_home.css') }}">
	</head>
	
	<body>
		<p>管理画面</p>
		@include('board_manager.sidebar')
		<h2>バナー編集</h2>
		<form method ="post" action = "/board_manager/banner">
		@csrf
			<p class="middle">1:　
    		<select name="banner1">
    			@foreach ($tables as $table)
					<option value="{{$table['tag_name']}}" @if($table['tag_banner']==1) selected @endif>{{$table['tag_name']}}</option>
				@endforeach
			</select></p>
			
			<p class="middle">2:　
    		<select name="banner2">
    			@foreach ($tables as $table)
					<option value="{{$table['tag_name']}}" @if($table['tag_banner']==2) selected @endif>{{$table['tag_name']}}</option>
				@endforeach
			</select></p>
			
			<p class="middle">3:　
    		<select name="banner3">
    			@foreach ($tables as $table)
					<option value="{{$table['tag_name']}}" @if($table['tag_banner']==3) selected @endif>{{$table['tag_name']}}</option>
				@endforeach
			</select></p>
			
			
			<p class="middle">4:　
    		<select name="banner4">
    			@foreach ($tables as $table)
					<option value="{{$table['tag_name']}}" @if($table['tag_banner']==4) selected @endif>{{$table['tag_name']}}</option>
				@endforeach
			</select></p>
			
			<p class="middle" id="right"><button type="submit">変更</button></p>
		</form>
		
		<!-- 変更が完了されたことを表示する文言 -->
		<p class="middle">{{$change_msg}}</p>
		
		
		<!-- タグに被りがあることを表示する文言 -->
		<p class="middle">{{$error}}</p>
		
		
		
		
	</body>
</html>










