<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category_id')->unsigned();
            $table->bigInteger('quantity')->default(0);
            $table->string('serial_number',100);
            $table->bigInteger('sold')->default(0);
            $table->bigInteger('spoiled')->default(0);
            $table->bigInteger('total')->default(0);
            $table->string('invoice_number',50)->nullable();
            $table->string('remark')->nullable();
            $table->boolean('highlighted')->default(0);
            $table->text('freight_dimensions');
            $table->datetime('next_booked_date_from')->nullable();
            $table->datetime('next_booked_date_to')->nullable();
            $table->bigInteger('creatorId');

            //FOREIGN KEY CONSTRAINTS
           $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');

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
        Schema::dropIfExists('inventories');
    }
}
