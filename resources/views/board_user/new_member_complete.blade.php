<html>
	<head>
		<title>会員登録完了</title>
		<link rel="stylesheet" href="{{ asset('css/regist.css') }}">
	</head>
	
	<body>
	@include('board_user.header')
	<div id="member_compliete">会員登録完了</div><br>
	<h1>会員登録が完了致しました</h1><br>
	
	<div class="center_confirm">下記のリンクからログインしてください</div>
	
	<div class="center_confirm">
    	<form method ="get" action = "/board_user/BoardUserLogin">
    	@csrf
    		<input type="submit" value="ログインフォームへ">
    	</form>
	</div>
	
	</body>
</html>
