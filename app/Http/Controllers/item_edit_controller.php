<?php
namespace App\Http\Controllers;

// この下に使うモデルを記載
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\board_model;
use App\Models\tag_list_tbl;
use App\Models\item_tbl;
use App\Models\tag_tbl;

// この下に使うバリデーションルールを記載
use App\Rules\name_full;

// コントローラー
class item_edit_controller extends Controller
{

    // ヘッダーからきたときのメソッド
    public function header()
    {

        // 商品選択できるように用意
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        // ログインしていなかったらログインページへ
        if (! session()->has('manager_id')) {

            // エラーメッセージの作成
            $msg = [
                'error' => ''
            ];
            return view('board_manager.manager_login', $msg);
        }

        return view('board_manager.item_edit', compact('item_lists', 'not_used_tags_delete'));
    }

    // 商品追加
    public function item_info_insert(Request $request)
    {

        // バリデーションの規則を記載
        $validate_rule = [
            'item_name' => [
                'required',
                new name_full()
            ],
            'item_price' => [
                'required',
                'numeric'
            ],
            'age' => [
                'required',
                'numeric'
            ],
            'player_min' => [
                'required',
                'numeric'
            ],
            'player_max' => [
                'required',
                'numeric'
            ],
            'time_min' => [
                'required',
                'numeric'
            ],
            'time_max' => [
                'required',
                'numeric'
            ],
            'length' => [
                'required',
                'numeric'
            ],
            'width' => [
                'required',
                'numeric'
            ],
            'hight' => [
                'required',
                'numeric'
            ]
        ];
        // バリデーションの実行
        $this->validate($request, $validate_rule);

        // 値の受け取り
        $item_name = $request->item_name;
        $item_price = $request->item_price;
        $age = $request->age;
        $player_min = $request->player_min;
        $player_max = $request->player_max;
        $time_min = $request->time_min;
        $time_max = $request->time_max;
        $length = $request->length;
        $width = $request->width;
        $hight = $request->hight;
        $item_description = $request->item_description;

        // DBに追加しつつ、与えられたidを取得
        $item_id = item_tbl::insertGetId([
            'item_name' => $item_name,
            'item_price' => $item_price,
            'item_description' => $item_description,
            'sale_num' => 0,
            'age' => $age,
            'player_num_min' => $player_min,
            'player_num_max' => $player_max,
            'player_time_min' => $time_min,
            'player_time_max' => $time_max,
            'length' => $length,
            'width' => $width,
            'hight' => $hight
        ]);
        // 新登場タグを自動でつける新登場が6になっているかは常に確認
        tag_tbl::insert([
            'item_id' => $item_id,
            'tag_id' => 6,
            'tag_name' => "新登場"
        ]);

        /*
        $msg = [
            'msg' => "商品を追加しました"
        ];
        */
        
        $msg = "商品を追加しました";
        
        // 商品の一覧を見る用
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        // ログインしていなかったらログインページへ
        if (! session()->has('manager_id')) {

            // エラーメッセージの作成
            $msg = [
                'error' => ''
            ];
            return view('board_manager.manager_login', $msg);
        }
        return view('board_manager.item_edit', compact('msg', 'item_lists', 'not_used_tags_delete'));
    }

    // 削除メソッド
    public function item_info_delete(Request $request)
    {
        // 指定idを取得
        $delete_item = $request->delete_item;
        // 削除
        item_tbl::where('item_id', $delete_item)->delete();
        // 削除後のリストを取得
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();
        // メッセージ作成
        $msg = "商品を削除しました";

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        
        
        
        
        //ログインしていなかったらログインページへ
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        
        return view('board_manager.item_edit', compact('item_lists', 'msg', 'not_used_tags_delete'));
    }

    // 編集する商品情報のidが指定されたとき
    public function item_info_edit_appoint(Request $request)
    {
        // 指定のidを取得
        $edit_item = $request->edit_item;
        // 変更前の情報を取得
        $item_info = item_tbl::select('*')->where('item_id', $edit_item)
            ->get()
            ->toArray();
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();
        // メッセージ作成
        $msg = "商品を指定しました。商品情報を変更してください。";

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        //ログインしていなかったらログインページへ
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        
        return view('board_manager.item_edit', compact('item_lists', 'msg', 'item_info', 'not_used_tags_delete'));
    }

    // 商品情報の編集
    public function item_info_edit(Request $request)
    {
        $item_name = $request->item_name;
        $item_price = $request->item_price;
        $age = $request->age;
        $player_min = $request->player_min;
        $player_max = $request->player_max;
        $time_min = $request->time_min;
        $time_max = $request->time_max;
        $length = $request->length;
        $width = $request->width;
        $hight = $request->hight;
        $item_description = $request->item_description;

        $param = [
            'item_name' => $item_name,
            'item_price' => $item_price,
            'item_description' => $item_description,
            'age' => $age,
            'player_num_min' => $player_min,
            'player_num_max' => $player_max,
            'player_time_min' => $time_min,
            'player_time_max' => $time_max,
            'length' => $length,
            'width' => $width,
            'hight' => $hight
        ];

        // 指定のidを取得
        $edit_item = $request->edit_item;
        // 情報をアップデート

        item_tbl::where('item_id', $edit_item)->update($param);
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();
        // メッセージ作成
        $msg = "商品情報を変更しました";

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        
        
        //ログインしていなかったらログインページへ
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        
        return view('board_manager.item_edit', compact('item_lists', 'msg', 'not_used_tags_delete'));
    }

    // タグを編集する商品のidが指定されたとき
    public function item_tag_edit_appoint(Request $request)
    {
        // 指定のidを取得
        $tag_edit_item = $request->tag_edit_item;
        // 使われているタグの情報を取得
        $item_tag_info = tag_tbl::select('*')->where('item_id', $tag_edit_item)
            ->get()
            ->toArray();
        // foreachで1つずつ値を取り出す
        foreach ($item_tag_info as $key => $value) {
            $tag_id[$key] = $value['tag_id'];
        }
        // array_multisortで'item_price'の列を昇順に並び替える
        array_multisort($tag_id, SORT_ASC, $item_tag_info);

        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list = tag_tbl::select('tag_id')->where('item_id', $tag_edit_item)
            ->get()
            ->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list as $result) {
            $used_tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_array)) {
            $result_id = array_diff($tag_list_array, $used_tag_list_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_array
            );
            $result_id = array_diff($tag_list_array, $copy);
            var_dump($copy);
        }

        $i = 0;
        foreach ($result_id as $id) {
            $not_used_tag = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags[$i] = $not_used_tag[0];
            $i ++;
            echo "<br>";
        }
        // 商品一覧を見る用
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        // メッセージ作成
        $msg = "商品を指定しました。タグを変更してください。";
        
        //ログインしていなかったらログインページへ
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        
        return view('board_manager.item_edit', compact('item_lists', 'msg', 'item_tag_info', 'not_used_tags', 'not_used_tags_delete'));
    }

    // 商品にタグを追加
    public function item_tag_add(Request $request)
    {

        // 値の受け取り
        $item_id = $request->tag_add_item_id;
        $tag_id = $request->item_tag_add;

        // タグ名を取得
        $tag_name = tag_list_tbl::select('tag_name')->where('tag_id', $tag_id)
            ->get()
            ->toArray();

        // DBに追加
        tag_tbl::insert([
            'item_id' => $item_id,
            'tag_id' => $tag_id,
            'tag_name' => $tag_name[0]['tag_name']
        ]);

        $msg = '商品にタグを追加しました';
        // 商品の一覧を見る用
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        //ログインしていなかったらログインページへ
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        
        return view('board_manager.item_edit', compact('msg', 'item_lists', 'not_used_tags_delete'));
    }

    // 商品からタグを削除
    public function item_tag_delete(Request $request)
    {

        // 値の受け取り
        $item_id = $request->tag_delete_item_id;
        $tag_id = $request->item_tag_delete;

        // DBから削除
        tag_tbl::where('tag_id', $tag_id)->where('item_id', $item_id)->delete();

        $msg = '商品からタグを削除しました';
        // 商品の一覧を見る用
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        //ログインしていなかったらログインページへ
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        
        
        return view('board_manager.item_edit', compact('msg', 'item_lists', 'not_used_tags_delete'));
    }

    // タグを登録
    public function tag_add(Request $request)
    {
        // 値の受け取り
        $add_tag_name = $request->add_tag_name;

        // DBに追加
        tag_list_tbl::insert([
            'tag_name' => $add_tag_name,
            'tag_type' => 0,
            'tag_banner' => 0
        ]);

        $msg = 'タグを登録しました';
        // 商品の一覧を見る用
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        //ログインしていなかったらログインページへ
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        
        return view('board_manager.item_edit', compact('msg', 'item_lists', 'not_used_tags_delete'));
    }

    // タグを削除
    public function tag_delete(Request $request)
    {
        // 指定idを取得
        $tag_delete = $request->tag_delete;
        // 削除
        tag_list_tbl::where('tag_id', $tag_delete)->delete();
        // 削除後のリストを取得
        $item_lists = item_tbl::select('*')->orderBy('item_id', 'asc')
            ->get()
            ->toArray();
        // メッセージ作成
        $msg = "タグを削除しました";

        // 使っていないタグ(削除できるタグ)を表示する用
        // すべてのタグidを取得
        $tag_list = tag_list_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($tag_list as $result) {
            $tag_list_array[$i] = $result['tag_id'];
            $i ++;
        }
        // 使われているタグidを取得
        $used_tag_list_delete = tag_tbl::select('tag_id')->get()->toArray();
        // 形を整える
        $i = 0;
        foreach ($used_tag_list_delete as $result) {
            $used_tag_list_delete_array[$i] = $result['tag_id'];
            $i ++;
        }

        // 二つの配列の差分を格納
        if (is_array($tag_list_array) && is_array($used_tag_list_delete_array)) {
            $result_id_delete = array_diff($tag_list_array, $used_tag_list_delete_array);
        } else {
            $copy = array(
                $used_tag_list_array,
                $used_tag_list_delete_array
            );
            $result_id_delete = array_diff($tag_list_array, $copy);
        }

        $i = 0;
        foreach ($result_id_delete as $id) {
            $not_used_tag_delete = tag_list_tbl::select('*')->where('tag_id', $id)
                ->get()
                ->toArray();
            $not_used_tags_delete[$i] = $not_used_tag_delete[0];
            $i ++;
            echo "<br>";
        }

        //ログインしていなかったらログインページへ
        if (!session()->has('manager_id') ){
            
            //エラーメッセージの作成
            $msg =[
                'error'=>''
            ];
            return view('board_manager.manager_login',$msg);
        }
        
        return view('board_manager.item_edit', compact('item_lists', 'msg', 'not_used_tags_delete'));
    }
}