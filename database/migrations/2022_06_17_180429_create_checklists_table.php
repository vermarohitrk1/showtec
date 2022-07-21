<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->increments('checklist_id')->unsigned();
            $table->bigInteger('checklist_position');
            $table->datetime('checklist_created');
            $table->datetime('checklist_updated');
            $table->bigInteger('checklist_creatorid');
            $table->bigInteger('checklist_clientid')->nullable()->default(NULL);
            $table->text('checklist_text');
            $table->string('checklist_status',250)->default('pending');
            $table->string('checklistresource_type',50);
            $table->bigInteger('checklistresource_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklists');
    }
}
