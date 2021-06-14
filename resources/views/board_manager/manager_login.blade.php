<!-- 管理者ログイン -->
<html>
	<head>
		<title>管理者ログイン</title>
		<link rel="stylesheet" href="{{ asset('css/manager_login.css') }}">
	</head>
	
	<body>
		<h1>ボードゲームショッピングサイト</h1>
		<h2>管理画面ログイン</h2>
		
		<div>
		<!-- ログイン入力欄 -->
		<form method ="post" action = "/board_manager/manager_login">
			@csrf
			<p>id：<input type="text" name = "manager_id"></p>
			<p>パスワード：<input type="password" name="passwd" ></p>
			<input  type="submit" value="ログイン">
		</form>
		
		<!-- パスワード変更画面へ遷移 -->
		<form method ="get" action = "/board_manager/change_password">
			@csrf
			<input  type="submit" value="パスワードの変更">
		</form>
		
		<!-- 正しく入力されない場合、エラーメッセージを表示 -->
		<p>{{$error}}</p>
		</div>
	</body>
</html>