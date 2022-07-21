<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomfieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customfields', function (Blueprint $table) {
            $table->increments('customfields_id')->unsigned();
		    $table->datetime('customfields_created');
            $table->datetime('customfields_updated');
            $table->string('customfields_type',50)->nullable()->default('NULL');
            $table->string('customfields_name',250)->nullable()->default('NULL');
            $table->string('customfields_title',250)->nullable()->default('NULL');
            $table->string('customfields_required',5)->default('no');
            $table->string('customfields_show_client_page',100)->nullable()->default('NULL');
            $table->string('customfields_show_project_page',100)->nullable()->default('NULL');
            $table->string('customfields_show_task_summary',100)->nullable()->default('NULL');
            $table->string('customfields_show_lead_summary',100)->nullable()->default('NULL');
            $table->string('customfields_show_invoice',100)->nullable()->default('NULL');
            $table->string('customfields_status',50)->default('disabled');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customfields');
    }
}
