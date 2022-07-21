<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads_status', function (Blueprint $table) {
            
            $table->increments('leadstatus_id')->unsigned();
            $table->datetime('leadstatus_created')->nullable()->default(NULL);
            $table->bigInteger('leadstatus_creatorid')->nullable()->default(NULL);
            $table->datetime('leadstatus_updated')->nullable()->default(NULL);
            $table->string('leadstatus_title',200);
            $table->bigInteger('leadstatus_position');
            $table->string('leadstatus_color',100)->default('default');
            $table->string('leadstatus_system_default',10)->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads_status');
    }
}
