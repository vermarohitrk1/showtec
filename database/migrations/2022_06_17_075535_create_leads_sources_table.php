<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads_sources', function (Blueprint $table) {
            $table->increments('leadsources_id')->unsigned();
            $table->datetime('leadsources_created');
            $table->datetime('leadsources_updated');
            $table->bigInteger('leadsources_creatorid');
            $table->string('leadsources_title',200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads_sources');
    }
}
