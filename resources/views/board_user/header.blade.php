
@isset($_POST["logout"])
    @unset($name)
    <?php session()->forget('user_name');?>
    <?php session()->forget('user_id');?>
@endisset

	
	
	
	
<header>
	
	<link rel="stylesheet" href="{{ asset('css/header_style.css') }}">

	<h1 id = "site-title">ボードゲームショップ</h1>

	<nav class="pc-nav">
        <ul id="header_ul">
        
        	
        
            <li class="header_ul"><a class="header_id" href="{{ url('/board_user/home_page') }}">ホーム</a></li>
            <li class="header_ul"><a class="header_id" href="{{ url('/board_user/item_list') }}">商品一覧</a></li>
            <li class="header_ul"><a class="header_id" href="{{ url('/board_user/cart') }}">カート</a></li>
            <li class="header_ul"><a class="header_id" href="{{ url('/board_user/ranking') }}">ランキング</a></li>
            
            @if((isset($name)))
            	<form method ="post" action = "{{ url('/board_user/BoardUserLogin') }}">
            		@csrf
            		
	            	<li class="header_ul"><input  class="header_id" name="logout" type="submit" value="ログアウト"></li>
	            </form>
	            <li class="header_ul"><a class="header_id" > {{$name}}さんこんにちは </a></li>
        	@else
				<li class="header_ul"><a class="header_id" href="{{ url('/board_user/BoardUserLogin') }}">ログイン</a></li>
	            <li class="header_ul"><a class="header_id" href="{{ url('/board_user/new_member_input') }}">新規会員登録</a></li>
			@endif
			
			


        </ul>
    </nav>
</header>

