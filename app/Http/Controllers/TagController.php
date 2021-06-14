<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

//この下に使うモデルを記載
use App\Models\tag_list_tbl;


class TagController extends Controller
{
    
    //簡単検索編集の処理(57行目まで)
    public function simple_search(Request $request){
        
        //空白のメッセージの作成
        $msg =[
            'add_msg'=>'',
            'delete_msg'=>''
        ];
        
        //DBからユーザーデータを取得
        $table_datas = tag_list_tbl::all(); //テーブルの全てのデータを取得
        $tables = $table_datas->toArray();//配列化
        
        //もし追加するボタンが押されたら
        if(!empty($request->add_tag)){
            
            //値の受け取り
            $add_tag = $request->add_tag;
            
            //選択したタグ名の行のtag_typeカラムの値を1にする
            tag_list_tbl::where('tag_name', $add_tag)->update(['tag_type' => 1]);
            //追加されましたの文言を表示
            $msg =[
                'add_msg'=>"$add_tag.の追加が完了しました",
                'delete_msg'=>''
            ];
        }
        
        //もし削除するボタンが押されたら
        if(!empty($request->delete_tag)){
            
            //値の受け取り
            $delete_tag = $request->delete_tag;
            
            //選択したタグ名の行のtag_typeカラムの値を0にする
            tag_list_tbl::where('tag_name', $delete_tag)->update(['tag_type' => 0]);
            //削除されましたの文言を表示
            $msg =[
                'add_msg'=>'',
                'delete_msg'=>"$delete_tag.の削除が完了しました"
            ];
        }
        
        //簡単検索編集画面へ移動
        return view('board_manager.simple_search', ['tables' => $tables],$msg);
    }
    
    
    
    
    
    
    
    
    
    
    //ここから下はバナー編集の処理です
    public function banner(Request $request){
        
        
        //空白のメッセージの作成
        $msg =[
            'error'=>'',
            'change_msg'=>''
        ];
        
        //DBからユーザーデータを取得
        $table_datas = tag_list_tbl::all(); //テーブルの全てのデータを取得
        $tables = $table_datas->toArray();//配列化
        
        //もし変更するボタンが押されたら
        if(!empty($request->banner1 && $request->banner2 && $request->banner3 && $request->banner4)){
            
            //値の受け取り
            $banner1 = $request->banner1;
            $banner2 = $request->banner2;
            $banner3 = $request->banner3;
            $banner4 = $request->banner4;
            
            
            //タグ名に被りがないか確認
            if($banner1 !== $banner2 && $banner1 !== $banner3 && $banner1 !== $banner4 &&
                $banner2 !== $banner3 && $banner2 !== $banner4 && 
                $banner3 !== $banner4){
            
                //バナーカラムの全ての値を０にする
                tag_list_tbl::where('tag_banner', '<', 5)->update(['tag_banner' => 0]);
                
                
                //選択したタグ名の行のtag_bannerのカラムの値をそれぞれ1～4にする
                tag_list_tbl::where('tag_name', $banner1)->update(['tag_banner' => 1]);
                tag_list_tbl::where('tag_name', $banner2)->update(['tag_banner' => 2]);
                tag_list_tbl::where('tag_name', $banner3)->update(['tag_banner' => 3]);
                tag_list_tbl::where('tag_name', $banner4)->update(['tag_banner' => 4]);
                
                //DBからユーザーデータを取得
                $table_datas = tag_list_tbl::all(); //テーブルの全てのデータを取得
                $tables = $table_datas->toArray();//配列化
                
                
                
                //変更が完了されましたの文言
                //削除されましたの文言を表示
                $msg =[
                    'error'=>'',
                    'change_msg'=>'変更が完了しました'
                ];
            }else{
                //タグに被りがあるエラーを表示
                $msg =[
                    'error'=>'タグに被りがあります',
                    'change_msg'=>''
                ];
                
            }
        }
        
        //バナー編集画面へ移動
        return view('board_manager.banner', ['tables' => $tables],$msg);
        
        
    }
    
    
}
?>
    
