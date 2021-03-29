<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchidToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('branch_id')->after('role');
            $table->string('branch_user_status')->after('branch_id');
        });

        DB::table('users')->insert([
                'name' => 'my_shop',
                'status' => '1',
                'otp' => '0',
                'email' => 'my_shop@yopmail.com',
                'password' => '$2y$10$L6dCHO7XX9cCsAeCNXjFtOi/YlUQzlHotX1M8sUrXRC6.d4cHhs5K',
                'order_allow' => '1',
                'role' => 'shop_keeper',
            ]);
        DB::table('users')->insert([
                'name' => 'my_shop_branchA',
                'status' => '1',
                'otp' => '0',
                'email' => 'my_shop_branchA@yopmail.com',
                'password' => '$2y$10$L6dCHO7XX9cCsAeCNXjFtOi/YlUQzlHotX1M8sUrXRC6.d4cHhs5K',
                'order_allow' => '1',
                'role' => 'branch_user',
                'branch_id' => '1',
                'branch_user_status' => 'Active',
            ]);
        DB::table('users')->insert([
                'name' => 'my_shop_branchB',
                'status' => '1',
                'otp' => '0',
                'email' => 'my_shop_branchB@yopmail.com',
                'password' => '$2y$10$L6dCHO7XX9cCsAeCNXjFtOi/YlUQzlHotX1M8sUrXRC6.d4cHhs5K',
                'order_allow' => '1',
                'role' => 'branch_user',
                'branch_id' => '2',
                'branch_user_status' => 'Active',
            ]);
        DB::table('users')->insert([
                'name' => 'my_shop_branchC',
                'status' => '1',
                'otp' => '0',
                'email' => 'my_shop_branchC@yopmail.com',
                'password' => '$2y$10$L6dCHO7XX9cCsAeCNXjFtOi/YlUQzlHotX1M8sUrXRC6.d4cHhs5K',
                'order_allow' => '1',
                'role' => 'branch_user',
                'branch_id' => '3',
                'branch_user_status' => 'Active',
            ]);
        DB::table('users')->insert([
                'name' => 'my_shop_branchD',
                'status' => '1',
                'otp' => '0',
                'email' => 'my_shop_branchD@yopmail.com',
                'password' => '$2y$10$L6dCHO7XX9cCsAeCNXjFtOi/YlUQzlHotX1M8sUrXRC6.d4cHhs5K',
                'order_allow' => '1',
                'role' => 'branch_user',
                'branch_id' => '4',
                'branch_user_status' => 'Active',
            ]);
        DB::table('users')->insert([
                'name' => 'my_shop_branchE',
                'status' => '1',
                'otp' => '0',
                'email' => 'my_shop_branchE@yopmail.com',
                'password' => '$2y$10$L6dCHO7XX9cCsAeCNXjFtOi/YlUQzlHotX1M8sUrXRC6.d4cHhs5K',
                'order_allow' => '1',
                'role' => 'branch_user',
                'branch_id' => '6',
                'branch_user_status' => 'Active',
            ]);
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
