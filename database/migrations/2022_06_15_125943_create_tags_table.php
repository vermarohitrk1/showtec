<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {

		$table->increments('tag_id');
		$table->datetime('tag_created')->nullable()->default(NULL);
		$table->datetime('tag_updated')->nullable()->default(NULL);
		$table->bigInteger('tag_creatorid')->nullable()->default(NULL);
		$table->string('tag_title',100);
		$table->string('tag_visibility',50)->default('user');
		$table->string('tagresource_type',50);
		$table->bigInteger('tagresource_id');

        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
}