<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('device_token')->nullable();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->tinyInteger('role_id')->nullable();
            $table->enum('status',['active', 'inactive'])->default('active');
            $table->string('type')->nullable();
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->string('designation')->nullable();
            $table->tinyInteger('creatorid')->default(0);
            $table->enum('dashboard_access',['yes', 'no'])->default('yes');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
