<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_companies', function (Blueprint $table) {
            //  $table->id();
              $table->bigInteger('user_id')->unsigned();
              $table->bigInteger('company_id')->unsigned(); 
              $table->string('designation')->nullable();
              $table->string('department')->nullable();
           //FOREIGN KEY CONSTRAINTS
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
  
           //SETTING THE PRIMARY KEYS
             $table->primary(['user_id','company_id']);
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
        Schema::dropIfExists('users_companies');
    }
}
