<?php namespace Tests;

trait ResetTbl
{
    function reset_all(){

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('adresses')->truncate();
        \DB::table('users')->truncate();
        \DB::table('user_roles')->truncate();

        \DB::table('shop_marques')->truncate();
        \DB::table('shop_coupon_product')->truncate();
        \DB::table('shop_coupons')->truncate();
        \DB::table('shop_coupon_complement')->truncate();
        \DB::table('shop_coupon_complement_products')->truncate();
        \DB::table('shop_order_products')->truncate();
        \DB::table('shop_orders')->truncate();
        \DB::table('shop_product_attributes')->truncate();
        \DB::table('shop_product_marques')->truncate();
        \DB::table('shop_product_categories')->truncate();
        \DB::table('shop_product_domains')->truncate();
        \DB::table('shop_product_packs')->truncate();
        \DB::table('shop_products')->truncate();
        \DB::table('shop_rappels')->truncate();
        \DB::table('shop_stocks')->truncate();
        \DB::table('homepage_products')->truncate();
        \DB::table('transaction_references')->truncate();

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->artisan('db:seed');
    }
}
