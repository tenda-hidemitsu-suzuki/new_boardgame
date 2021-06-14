
{{-- ログアウトボタンが押されたらセッションを削除 --}}
@isset($_POST["logout"])
    @unset($name);
    <?php //session()->forget('user_name');?>
    <?php session()->forget('manager_id');?>
@endisset

	

	
	


<link rel="stylesheet" href="{{ asset('css/sidebar_style.css') }}">



<aside id="sub">
  <h2>Menu</h2>
  <ul>
   @csrf
    <li class="header_ul"><a class="header_id" href="{{ url('/board_manager/manager_home') }}">ホーム</a></li>
    <li class="header_ul"><a class="header_id" href="{{ url('board_manager/item_edit') }}">商品情報の編集</a></li>
    <li class="header_ul"><a class="header_id" href="{{ url('/board_manager/simple_search') }}">簡単検索編集</a></li>
    <li class="header_ul"><a class="header_id" href="{{ url('/board_manager/banner') }}">バナーの編集</a></li>
    <li class="header_ul"><a class="header_id" href="{{ url('/board_manager/sales_history') }}">購入履歴</a></li>
    <li class="header_ul"><input  class="header_id" name="logout" type="submit" value="ログアウト"></li>

</aside>
