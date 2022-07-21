<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_tracking', function (Blueprint $table) {
            $table->increments('eventtracking_id')->unsigned();
            $table->datetime('eventtracking_created');
            $table->datetime('eventtracking_updated');
            $table->bigInteger('eventtracking_eventid');
            $table->bigInteger('eventtracking_userid');
            $table->string('eventtracking_status',30)->default('unread');
            $table->string('eventtracking_email',50)->default('no');
            $table->string('eventtracking_source',50)->nullable()->default(NULL);
            $table->string('eventtracking_source_id',50)->nullable()->default(NULL);
            $table->string('parent_type',50)->nullable()->default(NULL);
            $table->bigInteger('parent_id')->nullable()->default(NULL);
            $table->string('resource_type',50)->nullable()->default(NULL);
            $table->bigInteger('resource_id')->nullable()->default(NULL);
    
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_tracking');
    }
}
