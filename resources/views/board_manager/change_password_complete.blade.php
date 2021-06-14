<!-- パスワード変更完了 -->

<html>
	<head>
		<title>パスワード変更完了</title>
		<link rel="stylesheet" href="{{ asset('css/manager_login.css') }}">
	</head>
	<body>
	
	<h1>パスワード変更が完了致しました</h1>
	
	<p>下記のリンクからログインしてください</p>
	<div>
	<form method ="get" action = "/board_manager/manager_login">
		@csrf
		<input  type="submit" value="ログインフォームへ">
	</form>
	
	</div>
	
	
	</body>
</html






