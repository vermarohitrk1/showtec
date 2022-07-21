<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeadFieldToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            // $table->tinyInteger('role_contacts');
            // $table->tinyInteger('role_tasks')->default(0);
            // $table->string('role_tasks_scope',20)->default('own');
            // $table->tinyInteger('role_projects')->default(0);
            // $table->string('role_projects_scope',20)->default('own');
            // $table->string('role_projects_billing',20)->default('0');
            $table->tinyInteger('role_leads')->default(0);
            $table->string('role_leads_scope',20)->default('own');
            // $table->tinyInteger('role_team')->default(0);
            // $table->tinyInteger('role_tickets')->default(0);
            // $table->tinyInteger('role_knowledgebase')->default(0);
            // $table->string('role_manage_knowledgebase_categories',20)->default('no');
            // $table->tinyInteger('role_reports')->default(0);
            // $table->string('role_assign_projects',20)->default('no');
            // $table->string('role_assign_leads',20)->default('no');
            // $table->string('role_assign_tasks',20)->default('no');
            // $table->string('role_set_project_permissions',20)->default('no');
            // $table->string('role_templates_projects',20)->default('1');
    
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
}
