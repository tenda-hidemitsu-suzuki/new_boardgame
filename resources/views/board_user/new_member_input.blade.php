<html>
	<head>
		<title>新規会員登録フォーム</title>
		<link rel="stylesheet" href="{{ asset('css/regist.css') }}">
	</head>
	
	<body>
		<!-- ヘッダーはまだ埋め込んでないです -->
		@include('board_user.header')
		<p class="size">新規会員登録</p><br>
		<h1>お客様情報の入力</h1>
		
		
		
		<!-- ログイン入力欄 -->
		<form method ="post" action = "/board_user/new_member_confirm">
		@csrf
		<div class="center">
		<p class="text">
            @error('user_name')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<font color="red">必須</font>お名前
			<input type="text" size="50" name="user_name"  value = "{{old('user_name')}}" placeholder="全角で入力してください"><br>
			
			
			@error('user_kana')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<font color="red">必須</font>フリガナ
			<input type="text"size="50"  name="user_kana" value = "{{old('user_kana')}}"placeholder="全角カナで入力してください"><br>
			
			
			@error('post')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<font color="red">必須</font>郵便番号　〒
			<input type="text" size="50" name="post" maxlength="7" value = "{{old('post')}}"placeholder="半角数字7桁で入力してください"><br>
			<p class="hyphen">ハイフンを入れずに入力してください</p>
			
			<p class="text">
			@error('address')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<font color="red">必須</font>住所
			<input type="text" size="50"  name="address" value = "{{old('address')}}"><br>
			
			
			@error('tel')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<font color="red">必須</font>電話番号
			<input type="text" size="50" name="tel" minlength="10" maxlength="11" value = "{{old('tel')}}" placeholder="半角数字10～11桁で入力してください"><br>
			<p class="hyphen">ハイフンを入れずに入力してください</p>
			
			<p class="text">
			@error('mail')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<font color="red">必須</font>メールアドレス
			<input type="text" size="50" name="mail" value = "{{old('mail')}}"><br>
			
			
			@error('passwd')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<font color="red">必須</font>パスワード
			<input type="password" size="50"  name="passwd" value = "{{old('passwd')}}"placeholder="半角6～20文字で入力してください"><br>
			
			
			@error('passwd_confirmation')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
			<font color="red">必須</font>パスワード(確認用)
			<input type="password" size="50" name="passwd_confirmation" placeholder="確認のためもう一度入力してください"><br>
			
			<input type="submit" value="登録内容を確認する">
		</p>
		</div>
		</form>
	
	</body>
</html>