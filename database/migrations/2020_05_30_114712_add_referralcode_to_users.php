<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferralcodeToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('member_referral')->default(0)->nullable()->after('order_allow');
        });
        /*DB::table('users')->insert([
                'name' => 'my_shop',
                'status' => '1',
                'otp' => '0',
                'email' => 'my_shop@yopmail.com',
                'password' => '$2y$10$L6dCHO7XX9cCsAeCNXjFtOi/YlUQzlHotX1M8sUrXRC6.d4cHhs5K',
                'order_allow' => '1',
                'role' => 'shop_keeper',
            ]);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
