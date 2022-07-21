<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->datetime('last_seen')->nullable()->default(NULL);
            $table->string('theme',100)->default('default');
            $table->string('pref_language',200)->default('english');
            $table->string('pref_email_notifications',10)->default('yes');
            $table->string('pref_leftmenu_position',50)->default('collapsed');
            $table->string('pref_statspanel_position',50)->default('collapsed');
            $table->string('pref_filter_own_tasks',50)->default('no');
            $table->string('pref_filter_own_projects',50)->default('no');
            $table->string('pref_filter_show_archived_projects',50)->default('no');
            $table->string('pref_filter_show_archived_tasks',50)->default('no');
            $table->string('pref_filter_show_archived_leads',50)->default('no');
            $table->string('pref_filter_own_leads',50)->default('no');
            $table->string('pref_view_tasks_layout',50)->default('kanban');
            $table->string('pref_view_leads_layout',50)->default('kanban');
            $table->string('welcome_email_sent',150)->default('no');
    
    
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
        Schema::dropIfExists('user_settings');
    }
}
