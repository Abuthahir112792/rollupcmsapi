<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name');
            $table->String('address');
            $table->decimal('long', 10, 7);
            $table->decimal('lat', 10, 7);
            $table->timestamps();
        });

        DB::table('branch')->insert([
                'branch_name' => 'BranchA',
            ]);
        DB::table('branch')->insert([
                'branch_name' => 'BranchB',
            ]);
        DB::table('branch')->insert([
                'branch_name' => 'BranchC',
            ]);
        DB::table('branch')->insert([
                'branch_name' => 'BranchD',
            ]);
        DB::table('branch')->insert([
                'branch_name' => 'Admin',
            ]);
        DB::table('branch')->insert([
                'branch_name' => 'BranchE',
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch');
    }
}
