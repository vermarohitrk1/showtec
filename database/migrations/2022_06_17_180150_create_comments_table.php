<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('comment_id')->unsigned();
            $table->datetime('comment_created')->nullable()->default(NULL);
            $table->datetime('comment_updated')->nullable()->default(NULL);
            $table->bigInteger('comment_creatorid');
            $table->bigInteger('comment_clientid')->nullable()->default(NULL);
            $table->text('comment_text');
            $table->string('commentresource_type',50);
            $table->bigInteger('commentresource_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
