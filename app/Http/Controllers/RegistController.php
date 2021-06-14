<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

//この下に使うモデルを記載
use App\Models\user_tbl;

//この下に使うバリデーションルールを記載
use App\Rules\name_full;
use App\Rules\name_kana;
use App\Rules\double_check;

class RegistController extends Controller
{
    //会員登録フォームを最初に表示させるクラスを作成
    public function index(){
        require("Header_Controller_func.php");
        return view('board_user/new_member_input');
    }
    
    
    //バリデーションを実行してうまくいけば会員登録確認画面へ遷移
    public function regist_check(Request $request)
    {
        //バリデーションの規則を記載
        $validate_rule = [
            'user_name' => ['required', new name_full],
            'user_kana' => ['required', new name_full, new name_kana],
            'post' => ['required', 'digits:7', 'numeric'],
            'address' => ['required'],
            'tel' => ['required', 'digits_between:10,11', 'numeric'],
            'mail' => ['required', 'email'],
            'passwd' => ['required', 'between:6,20', 'alpha_num'],
            'passwd_confirmation' => ['required', new double_check($request['passwd'])]
        ];
        //バリデーションの実行
        $this->validate($request, $validate_rule);
        
        
        //バリデーションチェックに成功した場合会員登録確認画面へ遷移
        //値の受け取り
        $user_name = $request->user_name;
        $user_kana = $request->user_kana;
        $post = $request->post;
        $address = $request->address;
        $tel = $request->tel;
        $mail = $request->mail;
        $passwd = $request->passwd;
        
        //値の配列化
        $msg=[
            'user_name' => $user_name,
            'user_kana' => $user_kana,
            'post' => $post,
            'address' => $address,
            'tel' => $tel,
            'mail' => $mail,
            'passwd' => $passwd
        ];
        
        //値を登録確認画面へ返す
        require("Header_Controller_func.php");
        return view ('board_user.new_member_confirm', $msg);
        
    }
    
    
    //会員情報を会員テーブルに登録&会員登録完了ページへ遷移
    public function user_insert(Request $request)
    {
        //値の受け取り
        $user_name = $request->user_name;
        $user_kana = $request->user_kana;
        $post = $request->post;
        $address = $request->address;
        $tel = $request->tel;
        $mail = $request->mail;
        $passwd = $request->passwd;
        
        
        //DBに追加
        user_tbl::insert([ 
            'user_name' => $user_name, 
            'user_kana' => $user_kana,
            'post' => $post,
            'address' => $address,
            'tel' => $tel,
            'mail' => $mail,
            'passwd' => $passwd
        ]);
        
        //登録完了画面へ遷移
        require("Header_Controller_func.php");
        return view ('board_user.new_member_complete');
    }
    
}
?>
