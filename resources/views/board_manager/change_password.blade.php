<!-- パスワード変更 -->

<html>
	<head>
		<title>パスワード変更</title>
		<link rel="stylesheet" href="{{ asset('css/manager_login.css') }}">
	</head>
	<body>
		<h1>ボードゲームショッピングサイト</h1>
		<h2>管理画面パスワード変更</h2>
		
		<!--入力欄 -->
		<form method ="post" action = "/board_manager/change_password">
			@csrf
			<p>idと現在のパスワードを入力してください</p>
		<div>
			<p>id：<input type="text" name = "manager_id"></p>
			<p>パスワード：<input type="password" name="old_passwd" ></p>
		</div>
			<p>変更後のパスワードを入力してください</p>
		<div>
			@error('new_passwd')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<p>パスワード：<input type="text" name="new_passwd" ></p>
			<input  type="submit" value="パスワードを変更">
		
		</form>
		
		
		<form method ="get" action = "/board_manager/manager_login">
			@csrf
			<input  type="submit" value="ログイン画面へ戻る">
		</form>
		</div>
		
		<!-- 正しく入力されない場合、エラーメッセージを表示 -->
		<p>{{$error}}</p>
		
		
		
	</body>
</html
