<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('log_id')->unsigned();
            $table->string('log_uniqueid',100)->nullable()->default(NULL);
            $table->datetime('log_created');
            $table->datetime('log_updated');
            $table->bigInteger('log_creatorid')->nullable()->default(NULL);
            $table->text('log_text')->nullable()->default(NULL);
            $table->string('log_text_type',20)->default('text');
            $table->string('log_data_1',250)->nullable()->default(NULL);
            $table->string('log_data_2',250)->nullable()->default(NULL);
            $table->string('log_data_3',250)->nullable()->default(NULL);
            $table->text('log_payload')->nullable()->default(NULL);
            $table->string('logresource_type',60)->nullable()->default(NULL);
            $table->bigInteger('logresource_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('logs');
    }
}
