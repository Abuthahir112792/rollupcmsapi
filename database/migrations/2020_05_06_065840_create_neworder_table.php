<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeworderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neworder', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->timestamps();
        });

        /*DB::table('neworder')->insert([
                'status' => 'False',
            ]);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('neworder');
    }
}
