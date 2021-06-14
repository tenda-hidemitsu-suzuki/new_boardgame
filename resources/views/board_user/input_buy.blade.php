<!DOCTYPE html>
<html>
  <head>
    <title>情報入力</title>
    <style>
    </style>
  </head>
  <body>
    <h1>お客様情報の入力</h1>
    
    
    <!-- お客様情報入力欄 -->
    <form method="post"action="/board_user/confirm_buy">
    @csrf
    
    @php
    //$data = session('user_name');
    $data = 1;
    @endphp
    
    		@error('user_name')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
      
            
            @if(isset($data))
			<font color="red">必須</font>お名前
			<input type="text" name="user_name"  value = "{{$user_name}}" placeholder="全角で入力してください"><br>
			
			@else
			<font color="red">必須</font>お名前
			<input type="text" name="user_name"  value = "{{old('user_name')}}" placeholder="全角で入力してください"><br>
			@endif
			
			
			@error('user_kana')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
            
            @if(isset($data))
			<font color="red">必須</font>フリガナ
			<input type="text" name="user_kana" value = "{{$user_kana}}"placeholder="全角カナで入力してください"><br>
			
			@else
			<font color="red">必須</font>フリガナ
			<input type="text" name="user_kana" value = "{{old('user_kana')}}"placeholder="全角カナで入力してください"><br>
			@endif
			
			
			@error('post')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
            
            @if(isset($data))
            <p>ハイフンを入れずに入力してください</p>
			<font color="red">必須</font>郵便番号　〒
			<input type="text" name="post" maxlength="7" value = "{{$post}}"placeholder="半角数字7桁で入力してください"><br>
			
			@else
			<p>ハイフンを入れずに入力してください</p>
			<font color="red">必須</font>郵便番号　〒
			<input type="text" name="post" maxlength="7" value = "{{old('post')}}"placeholder="半角数字7桁で入力してください"><br>
			@endif
			
			
			@error('address')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
            
            @if(isset($data))
			<font color="red">必須</font>住所
			<input type="text" name="address" value = "{{$address}}"><br>
			
			@else
			<font color="red">必須</font>住所
			<input type="text" name="address" value = "{{old('address')}}"><br>
			@endif
			
			
			@error('tel')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
            
            @if(isset($data))
            <p>ハイフンを入れずに入力してください</p>
			<font color="red">必須</font>電話番号
			<input type="text" name="tel" minlength="10" maxlength="11" value = "{{$tel}}" placeholder="半角数字10～11桁で入力してください"><br>
			
			@else
			<p>ハイフンを入れずに入力してください</p>
			<font color="red">必須</font>電話番号
			<input type="text" name="tel" minlength="10" maxlength="11" value = "{{old('tel')}}" placeholder="半角数字10～11桁で入力してください"><br>
			@endif
			
			
			@error('mail')
                <tr><th>エラー</th>
                <td>{{$message}}</td></tr><br>
            @enderror
            
            @if(isset($data))
			<font color="red">必須</font>メールアドレス
			<input type="text" name="mail" value = "{{$mail}}"placeholder="半角6～20文字で入力してください"><br>
			
			@else
			<font color="red">必須</font>メールアドレス
			<input type="text" name="mail" value = "{{old('mail')}}"placeholder="半角6～20文字で入力してください"><br>
			@endif
			
    		
    		<p>お支払方法：<input type="radio" value="コンビニ支払い" name="pay"checked>コンビニ支払い
    		<input type="radio" value="代引き" name="pay">代引き</p><br>
	
    <input type="submit" value="次へ進む"><br>
    </form>
    
  </body>
</html>
