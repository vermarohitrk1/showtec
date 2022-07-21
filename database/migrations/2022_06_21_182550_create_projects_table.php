<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            
		$table->increments("project_id")->unsigned();
		$table->string('project_type',30)->default('project');
		$table->string('project_importid',100)->nullable()->default(NULL);
		$table->datetime('project_created')->nullable()->default(NULL);
		$table->datetime('project_updated')->nullable()->default(NULL);
		$table->integer('project_clientid')->nullable()->default(NULL);
		$table->integer('project_creatorid');
		$table->integer('project_categoryid')->default('1');
		$table->string('project_title',250);
		$table->date('project_date_start')->nullable()->default(NULL);
		$table->date('project_date_due')->nullable()->default(NULL);
		$table->text('project_description')->nullable()->default(NULL);
		$table->string('project_status',50)->default('not_started');
		$table->string('project_active_state',10)->default('active');
		$table->tinyInteger('project_progress')->default('0');
		$table->decimal('project_billing_rate',10,2)->default('0.00');
        $table->string('project_billing_type',40)->default('hourly');
		$table->tinyInteger('project_billing_estimated_hours')->default('0');
		$table->decimal('project_billing_costs_estimate',10,2)->default('0.00');
		$table->string('project_progress_manually',10)->default('no');
		$table->string('clientperm_tasks_view',10)->default('yes');
		$table->string('clientperm_tasks_collaborate',40)->default('no');
		$table->string('clientperm_tasks_create',40)->default('yes');
		$table->string('clientperm_timesheets_view',40)->default('yes');
		$table->string('clientperm_expenses_view',40)->default('no');
		$table->string('assignedperm_milestone_manage',40)->default('yes');
		$table->string('assignedperm_tasks_collaborate',40)->nullable()->default(NULL);
		$table->string('project_visibility',40)->default('visible');
		$table->string('project_custom_field_1',20)->nullable()->default(NULL);
		$table->string('project_custom_field_2',20)->nullable()->default(NULL);
		$table->string('project_custom_field_3',20)->nullable()->default(NULL);
		$table->string('project_custom_field_4',20)->nullable()->default(NULL);
		$table->string('project_custom_field_5',20)->nullable()->default(NULL);
		$table->string('project_custom_field_6',20)->nullable()->default(NULL);
		$table->string('project_custom_field_7',20)->nullable()->default(NULL);
		$table->string('project_custom_field_8',20)->nullable()->default(NULL);
		$table->string('project_custom_field_9',20)->nullable()->default(NULL);
		$table->string('project_custom_field_10',20)->nullable()->default(NULL);
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
