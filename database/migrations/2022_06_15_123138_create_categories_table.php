<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id');
            $table->datetime('category_created')->nullable()->default(NULL);
            $table->datetime('category_updated')->nullable()->default(NULL);
            $table->bigInteger('category_creatorid')->nullable()->default(NULL);
            $table->bigInteger('parent_category')->default(0);
            $table->string('category_name',150)->nullable()->default(NULL);
            $table->string('category_description',150)->nullable()->default(NULL);
            $table->string('category_system_default',20)->default('no');
            $table->string('category_visibility',20)->default('everyone');
            $table->string('category_icon',100)->default('sl-icon-docs');
            $table->string('category_color',20)->default('#3751FF');
            $table->string('category_type',50);
            $table->string('category_slug',250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
