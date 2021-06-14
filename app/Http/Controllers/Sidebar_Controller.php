<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use Illuminate\Support\Facades\DB;

class Sidebar_Controller extends Controller
{


	//サイドバー
   	public function sidebar(Request $request){
   	   
   	
		return view('board_manager.sidebar');

	}
	
	
	//サイドバーのテスト用
   	public function side_test(){
   	    $variable = [
   	        'name' => session('user_name'), //動作検証用
   	        'id' => session('user_id') //動作検証用
   	    ];
   	    
   	    
   	    //require("Header_Controller_func.php");
		return view('board_manager.test_sidebar',$variable);

	}
	
	public function side_test_post(Request $reauest){

	    return view('board_user.test');
	    
	}
	
	
	//サイドバーのテスト用2
	public function side_test2(){
	    
	    //require("Header_Controller_func.php");
	    return view('board_user.test2');
	    
	}



}

