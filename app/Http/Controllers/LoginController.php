<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


//この下に使うモデルを記載
use App\Models\user_tbl;
use App\Models\tag_list_tbl;
use App\Models\item_tbl;
use App\Models\tag_tbl;
use App\Models\admin_tbl;

class LoginController extends Controller
{
    //ユーザーログインフォームを最初に表示する際の処理
    public function login_form(Request $request)
    {
        //エラーメッセージの作成
        $msg =[
            'error'=>''
        ];
        require("Header_Controller_func.php");
        return view('board_user.BoardUserLogin', $msg);
    }
    
    
    
    //値を受け取って判定し、ページ遷移先を決める
    public function login_check(Request $request)
    {
        //値の受け取り
        $user_name = $request->user_name;
        $passwd = $request->passwd;
        
        //DBからユーザーデータを取得
        $table_datas = user_tbl::select('user_name', 'passwd')->get(); //会員テーブルの会員名とパスワードのデータを取得
        $datas = $table_datas->toArray();//配列化
        
        //判定
        //テーブルの中身を順番に確認する
        foreach ($datas as $data){
            //もしデータベースの内容と一致していたら
            if($user_name == $data['user_name'] && $passwd == $data['passwd']){
                //sessionにuser_nameを格納
                $request->session()->put('user_name', $user_name);
                $name   = $request->session()->get('user_name');
                
                
                
                //会員テーブルから該当する会員名の会員idを取得
                $users_datas = user_tbl::select('user_id')->where('user_name', $user_name)->get();
               //user_idを格納
                foreach($users_datas as $user_id){
                    $user_id = $user_id->$user_id;;
                }
                
                //ユーザーidをセッションに格納
                $request->session()->put('user_id', $user_id);
                $id   = $request->session()->get('user_id');
                
                //user_idの数字テスト
                echo $user_id;
                
                
                //検索条件を配列に格納(初期値を格納)
                $search_info=array('name'=>"", 'age'=>2147483647, 'player_num'=>0, 'tag_id'=>"0", 'time'=>0, 'price'=>0, 'size'=>0, 'sort'=>0, 'tag_type'=>1);
                
                //タグ一覧を配列に格納(簡単を格納)
                $tag_lists = tag_list_tbl::select('*')->where('tag_type', 1)->get()->toArray();
                
                
                //検索条件に合う情報をDBから取得(全部)
                $item_info = item_tbl::select('*')->get()->toArray();
                
                //バナータグを取得
                $banner_tag_lists = tag_list_tbl::select('*')->where('tag_banner', '>=' ,1)->get()->toArray();
                
                //商品テーブルの情報を販売個数の多い順にソートして表示
                $items = item_tbl::select('*')->orderBy('sale_num', 'DESC')->limit(3)->get()->toArray();
               
                
                
                //require("Header_Controller_func.php");
                //変数渡してview呼び出し
                return view('board_user.home_page',compact('search_info', 'tag_lists', 'item_info', 'banner_tag_lists', 'items','name'));
                

            }
        }
        
        //正しく値が入力されなかった場合の処理
        //エラーメッセージの作成
        $msg =[
            'error'=>'※会員名、もしくはパスワードが間違っています。'
        ];
        
        //require("Header_Controller_func.php");  場合に応じて突っ込む
        
        //正しく値が入力されていないのでログインフォームにもどる
        return view('board_user.BoardUserLogin', $msg);
    }
    
    
    
    
    
    
    
    
    //ここから下(158行目まで)は管理者ログインの処理です
    
    //管理者ログインフォームを最初に表示する際の処理
    public function manager_login()
    {
        //エラーメッセージの作成
        $msg =[
            'error'=>''
        ];
        
        return view('board_manager.manager_login', $msg);
    }
    
    
    //値を受け取って判定し、ページ遷移先を決める
    public function manager_check(Request $request)
    {
        //値の受け取り
        $manager_id = $request->manager_id;
        $passwd = $request->passwd;
        
        //DBから管理者データを取得
        $table_datas = admin_tbl::select('admin_id', 'admin_pass')->get(); //管理者テーブルのidとパスワードのデータを取得
        $datas = $table_datas->toArray();//配列化
        
        //テーブルの中身を順番に確認する
        foreach ($datas as $data){
            //もしデータベースの内容と一致していたら
            if($manager_id == $data['admin_id'] && $passwd == $data['admin_pass']){
                
                //sessionにmanager_idを格納
                $request->session()->put('manager_id', $manager_id);
                $name   = $request->session()->get('manager_id');
                
                //以下にホームページに遷移する際に必要な処理を記載
                //もしセッションの中身が空ならログイン画面へ強制遷移(ログインしていなければログイン画面へ自動遷移)
                if (!$request->session()->has('manager_id') ){
                    return view('board_manager.manager_login');
                }
                
                //セッションに中身があるならホーム画面へ遷移
                return view('board_manager.manager_home');
                
            }
            
            //正しく値が入力されなかった場合の処理
            //エラーメッセージの作成
            $msg =[
                'error'=>'※会員名、もしくはパスワードが間違っています。'
            ];
            
            //正しく値が入力されていないのでログインフォームにもどる
            return view('board_manager.manager_login', $msg);
            
        }
    }
    
    
    
    
    //管理者ホームを表示する際の処理ログインへ強制遷移
    public function manager_home()
    {
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        return view('board_manager.manager_home');
    }
    
    
    
    
    
    
    
    
    
    //ここから下は管理者のパスワード変更画面の処理です
    
    //パスワード変更画面を最初に表示する際の処理
    public function change_password()
    {
        //エラーメッセージの作成
        $msg =[
            'error'=>''
        ];
        return view('board_manager.change_password', $msg);
    }
    
    
    //バリデーションチェック&idと現在のパスワードが正しいものか判定
    public function pass_check(Request $request)
    {
        //バリデーションの規則を記載
        $validate_rule = [
            'new_passwd' => ['required', 'between:6,20', 'alpha_num'],
        ];
        //バリデーションの実行
        $this->validate($request, $validate_rule);
        
        //バリデーションチェックに成功した場合パスワード変更完了画面へ遷移
        //値の受け取り
        $manager_id = $request->manager_id;
        $old_passwd = $request->old_passwd;
        $new_passwd = $request->new_passwd;
        
        //DBから管理者データを取得
        $table_datas = admin_tbl::select('admin_id', 'admin_pass')->get(); //管理者テーブルのidとパスワードのデータを取得
        $datas = $table_datas->toArray();//配列化
        
        
        //テーブルの中身を順番に確認する
        foreach ($datas as $data){
            //もしデータベースの内容と一致していたら
            if($manager_id == $data['admin_id'] && $old_passwd == $data['admin_pass']){
                
                
                //パスワードを新しく更新
                admin_tbl::where('admin_id', $manager_id)->update(['admin_pass' => $new_passwd]);
                
                //パスワード変更完了画面へ遷移
                return view('board_manager.change_password_complete');
                
            }
            
            //正しく値が入力されなかった場合の処理
            //エラーメッセージの作成
            $msg =[
                'error'=>'※id、もしくはパスワードが間違っています。'
            ];
            
            //正しく値が入力されていないのでパスワード変更画面にもどる
            return view('board_manager.change_password', $msg);
            
            
            
        }
        
        
    }
    
    
    
    
}
?>







