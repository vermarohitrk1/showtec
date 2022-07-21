<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads_assigned', function (Blueprint $table) {
            $table->increments('leadsassigned_id')->unsigned();
            $table->bigInteger('leadsassigned_leadid')->nullable()->default(NULL);
            $table->bigInteger('leadsassigned_userid')->nullable()->default(NULL);
            $table->datetime('leadsassigned_created');
            $table->datetime('leadsassigned_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads_assigned');
    }
}
