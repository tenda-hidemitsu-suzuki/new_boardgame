<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>カート</title>
    <style>
    </style>
  </head>
  <body>
    <h1>ショッピングカート</h1>
    
    
    <p>商品内容     数量     削除   <br></p>
    
    
    @for($i = 0 ; $i < $cun; $i++ )
    {{$item_name[$i]}}<br>
    {{$item_price[$i]}}
    {{$cart_num[$i]}}
    
    
    	<form method="post"action="/board_user/cart">
    	@csrf
    	<input type="hidden" name="add" value="add" >
    	<input type="hidden" name="item_name" value="{{$item_name[$i]}}" >
    	<input type="hidden" name="cart_num" value="{{$cart_num[$i]}}" >
		<input type="submit" value="+" >
		</form>
    
    	<form method="post"action="/board_user/cart">
    	@csrf
    	<input type="hidden" name="sub" value="sub" >
    	<input type="hidden" name="item_name" value="{{$item_name[$i]}}" >
    	<input type="hidden" name="cart_num" value="{{$cart_num[$i]}}" >
		<input type="submit" value="-" >
		</form>
	
		<form method="post"action="/board_user/cart">
		@csrf
		<input type="hidden" name="del" value="del" >
		<input type="hidden" name="item_name" value="{{$item_name[$i]}}" >
		<input type="hidden" name="cart_num" value="{{$cart_num[$i]}}" >
		<input type="submit" value="削除" ><br> 
    	</form>
	@endfor
    
    
    <p>合計：￥{{$total_price}}円<br></p>
    
    
    <form method="post"action="/board_user/input_buy">
    @csrf
    <input type="submit" value="レジに進む"><br>
    </form>
    
    <form method="get"action="/board_user/home_page">
    @csrf
    <input type="submit" value="お買い物を続ける"><br>
    </form>
	
	
  </body>
</html>
