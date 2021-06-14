<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        //ショッピングテーブル(購入履歴)
        Schema::create('shop_history_tbl', function (Blueprint $table) {
            $table->increments('purchase_st_id');
            $table->text('customer_name');
            $table->text('customer_kana');
            $table->text('customer_address');
            $table->text('customer_post');
            $table->text('customer_tel');
            $table->text('customer_mail');
            $table->dateTime('purchase_time_id');
        });
        
        //会員テーブル
        Schema::create('user_tbl', function (Blueprint $table) {
            $table->increments('user_id');
            $table->text('user_name');
            $table->text('user_kana');
            $table->text('post');
            $table->text('address');
            $table->text('tel');
            $table->text('mail');
            $table->text('passwd');
            $table->unique('passwd')->name('passwd');
        });
        
        //商品テーブル
        Schema::create('item_tbl', function (Blueprint $table) {
            $table->increments('item_id');
            $table->text('item_name');
            $table->integer('item_price');
            $table->text('item_description');
            $table->integer('sale_num');
            $table->integer('age')->nullable();
            $table->integer('player_num_min');
            $table->integer('player_num_max');
            $table->integer('player_time_min');
            $table->integer('player_time_max')->nullable();
            $table->integer('length');
            $table->integer('width');
            $table->integer('hight');
        });
        
        //カートテーブル
         Schema::create('cart_tbl', function (Blueprint $table) {
            $table->increments('cart_id');
            $table->integer('user_id');
            $table->integer('item_id');
            $table->integer('cart_num');
        });
        
         //ショッピングテーブル(詳細)
         Schema::create('shop_detail_tbl', function (Blueprint $table) {
            $table->increments('shop_id');
            $table->integer('purchase_st_id');
            $table->integer('item_id');
            $table->integer('purchase_num');
            $table->integer('item_price');
        });
        
         //商品付属タグテーブル
         Schema::create('tag_tbl', function (Blueprint $table) {
            $table->increments('tag_item_id');
            $table->integer('item_id');
            $table->integer('tag_id');
            $table->text('tag_name');
        });
        
         //タグ一覧テーブル
         Schema::create('tag_list_tbl', function (Blueprint $table) {
            $table->increments('tag_id');
            $table->text('tag_name');
            $table->integer('tag_type');
            $table->integer('tag_banner');
            $table->unique('tag_name')->name('tag_name');
        });
        
         //管理者テーブル
         Schema::create('admin_tbl', function (Blueprint $table) {
            $table->text('admin_id');
            $table->text('admin_pass');
        });
        
         //ゲストテーブル
         Schema::create('guest_tbl', function (Blueprint $table) {
             $table->increments('guest_id');
             $table->integer('time');
        });
         
         //ゲストカートテーブル
         Schema::create('guest_cart_tbl', function (Blueprint $table) {
             $table->increments('guest_cart_id');
             $table->integer('guest_id');
             $table->integer('item_id');
             $table->integer('guest_cart_num');
         });
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_models');
    }
}