<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSiteMediaToSiteMediaTable extends Migration
{
        public $set_schema_table = 'site_media';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE ".$this->set_schema_table." MODIFY COLUMN media_type ENUM('Image', 'Video', 'Logo') NOT NULL DEFAULT 'Image'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE ".$this->set_schema_table." MODIFY COLUMN media_type ENUM('Image', 'Video') NOT NULL DEFAULT 'Image'");
    }
}
