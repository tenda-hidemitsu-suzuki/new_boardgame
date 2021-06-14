
<?php 


//この下に使うモデルを記載
use App\Models\user_tbl;
use App\Models\guest_tbl;

	
   	    //session_start();
   	    
   	    
   	    
   	    //ユーザーIDを取得
   		//$input_user_id = $request->session()->get('user_id');
   		//$input_user_id = 1;
   		
   		//ユーザー名を取得
   		//$input_user_name = $request->session()->get('user_name');
   		
        $user_name = '';
        $name   = session('user_name');
        $id = session('user_id');
        
   		//ユーザ名がない状態でサイトにアクセスしたらゲスト用のIDを発行
        if(!session()->has('user_id')){
   		    
   		    //$sql = guest_tbl::insert([ 'time' => 1 ]);
   		    //$stmt = $pdo->prepare($sql);
   		    //$pdo->beginTransaction();
   		    
   		    $id = DB::table('guest_tbl')->insertGetId(
   		    [ 'time' => 1 ]
   		    );
   		    
   		    session(['user_id' => $id]);
   		    
   		//ログインページから入力されたらデータベースと参照
   		}else{
   		    //取得したユーザIDをデータベースの会員IDと参照
   		    //$user_id = DB::select('select user_id from user_tbl where user_id = $input_user_id');
   		    $id = user_tbl::select('user_id')->where('user_name', $name)->get();
   		    
   		    //取得したユーザIDをデータベースの会員名と参照
   		    //$user_name = DB::select('select user_name from user_tbl where user_id = $input_user_id');
   		    $user_name = user_tbl::select('user_name')->where('user_name', $name)->get();
   		    //$user_id = 1;
   		    
   		}
   		
   		
   		//変数
   		$variable = [
   		    'id' => $id,  //ユーザーID
   		    'user_name' => $user_name,  //動作検証用
   		    'user_id2' => session('user_id'), //動作検証用
   		    'name' => $name //ユーザ名
   		];
   	
		//return view('board_user.header',$variable);

	
	
	
	



