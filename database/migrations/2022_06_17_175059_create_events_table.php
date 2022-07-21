<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('event_id')->unsigned();
            $table->datetime('event_created')->nullable()->default(NULL);
            $table->datetime('event_updated')->nullable()->default(NULL);
            $table->bigInteger('event_creatorid');
            $table->bigInteger('event_clientid');
            $table->string('event_item',150)->nullable()->default(NULL);
            $table->bigInteger('event_item_id')->nullable()->default(NULL);
            $table->text('event_item_content')->nullable()->default(NULL);
            $table->text('event_item_content2')->nullable()->default(NULL);
            $table->text('event_item_content3')->nullable()->default(NULL);
            $table->text('event_item_content4')->nullable()->default(NULL);
            $table->string('event_item_lang',150)->nullable()->default(NULL);
            $table->string('event_item_lang_alt',150)->nullable()->default(NULL);
            $table->string('event_parent_type',150)->nullable()->default(NULL);
            $table->string('event_parent_id',150)->nullable()->default(NULL);
            $table->string('event_parent_title',150)->nullable()->default(NULL);
            $table->string('event_show_item',150)->default('yes');
            $table->string('event_show_in_timeline',150)->default('yes');
            $table->string('event_notification_category',150)->nullable()->default(NULL);
            $table->string('eventresource_type',50)->nullable()->default(NULL);    
            $table->bigInteger('eventresource_id')->nullable()->default(NULL);
    
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
