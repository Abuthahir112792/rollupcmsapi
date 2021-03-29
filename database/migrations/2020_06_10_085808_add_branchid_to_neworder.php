<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchidToNeworder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('neworder', function (Blueprint $table) {
            $table->string('branch_id')->after('status');
        });

        DB::table('neworder')->insert([
                'status' => 'False',
                'branch_id' => '1',
            ]);
        DB::table('neworder')->insert([
                'status' => 'False',
                'branch_id' => '2',
            ]);
        DB::table('neworder')->insert([
                'status' => 'False',
                'branch_id' => '3',
            ]);
        DB::table('neworder')->insert([
                'status' => 'False',
                'branch_id' => '4',
            ]);
        DB::table('neworder')->insert([
                'status' => 'False',
                'branch_id' => '5',
            ]);
        DB::table('neworder')->insert([
                'status' => 'False',
                'branch_id' => '6',
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('neworder', function (Blueprint $table) {
            //
        });
    }
}
