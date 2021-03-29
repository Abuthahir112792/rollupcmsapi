<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('room_number')->nullable()->after('mobile_number');
            $table->string('house_number')->nullable()->after('room_number');
            $table->string('zone_number')->nullable()->after('house_number');
            $table->string('street_name')->nullable()->after('zone_number');
            $table->string('area_name')->nullable()->after('street_name');
            $table->string('land_mark')->nullable()->after('area_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
             
        });
    }
}
