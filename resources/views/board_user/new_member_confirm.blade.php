
<html>
	<head>
		<title>新規会員確認画面</title>
		<link rel="stylesheet" href="{{ asset('css/regist.css') }}">
	</head>
	
	<body>
	@include('board_user.header')
	<h1>確認画面</h1>
	<h2>入力にお間違いが無いか確認してください</h2>
	
	
	<p class="center_confirm">お名前:{{$user_name}}</p> 
	<p class="center_confirm">フリガナ:{{$user_kana}}</p> 
	<p class="center_confirm">郵便番号：〒{{$post}}</p>
	<p class="center_confirm">住所:{{$address}}</p>
	<p class="center_confirm">電話番号:{{$tel}}</p> 
	<p class="center_confirm">メールアドレス:{{$mail}}</p>
	<p class="center_confirm">パスワード:{{$passwd}}</p> 
	
	
	<!-- 戻るボタンの生成 -->
	<div class="center_confirm">
    	<form method ="get" action = "/board_user/new_member_input">
    		<input type="submit" value="戻る">
    	</form>
	</div>
	<!-- この内容で登録するボタンの生成 -->
	<div class="center_confirm">
    	<form method ="post" action = "/board_user/new_member_complete">
    	@csrf
    		<input type="hidden" name="user_name" value ="{{$user_name}}">
    		<input type="hidden" name="user_kana" value ="{{$user_kana}}">
    		<input type="hidden" name="post" value ="{{$post}}">
    		<input type="hidden" name="address" value ="{{$address}}">
    		<input type="hidden" name="tel" value ="{{$tel}}">
    		<input type="hidden" name="mail" value ="{{$mail}}">
    		<input type="hidden" name="passwd" value ="{{$passwd}}">
    		<input type="submit" value="この内容で登録する">
    	</form>
	</div>
	
	
	
	</body>
</html>
