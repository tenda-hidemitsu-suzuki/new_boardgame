<!-- ログインフォーム -->

<html>
	<head>
		<title>ユーザーログイン</title>
		<link rel="stylesheet" href="{{ asset('css/login.css') }}">
	</head>
	<body>
		@include('board_user.header')
		<!-- ログイン入力欄 -->
		<form method ="post" action = "/board_user/BoardUserLogin">
			@csrf
			<p class="middle">ユーザー名：<input type="text" name = "user_name"></p>
			<p class="middle">パスワード：<input type="password" name="passwd" ></p>
			<p class="middle"><input  type="submit" value="ログイン"></p>
		</form>
		
		
		<!-- 正しく入力されない場合、エラーメッセージを表示 -->
		<p class="red" id="position">{{$error}}</p>
	</body>
</html>
