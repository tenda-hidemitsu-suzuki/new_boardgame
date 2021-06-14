<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

//この下に使うモデルを記載
use App\Models\user_tbl;
use App\Models\item_tbl;
use App\Models\tag_tbl;
//商品周りのコントローラー
class ItemController extends Controller
{
    //
    public function item_indicates(Request $request)
    {
        
        
            //セッションに格納されている会員IDorゲストIDを取得する
            

            
            
            //商品情報を表示する処理
            //値の受け取り
            
            $item_id = $request->item_id;
            
            //DBの商品テーブルから該当する商品IDのデータを取得
            $item_datas = item_tbl::where('item_id', $item_id)->get();
            $items = $item_datas->toArray();//配列化
            
            
            //DBの商品付属タグテーブルから該当する商品IDのデータを取得
            $tag_datas = tag_tbl::select('tag_name')->where('item_id', $item_id)->get();
            $tags = $tag_datas->toArray();//配列化
            
            $user_id   = $request->session()->get('user_id');
            
            echo "$user_id";
            
            require("Header_Controller_func.php");
            $user_id   = $request->session()->get('user_id');
            
            echo "$user_id";
            
            
            //商品情報と付属タグをviewに引き渡す
            return view('board_user.item_individual',['items' => $items, 'tags' => $tags],compact('name', 'item_id'));
            
            
        
    }
    

}
?>
