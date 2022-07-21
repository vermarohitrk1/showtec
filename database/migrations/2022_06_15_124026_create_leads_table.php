<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('lead_id');
            $table->string('lead_importid',100)->nullable()->default(NULL);
            $table->double('lead_position', 20, 2);
            $table->datetime('lead_created')->nullable()->default(NULL);
            $table->datetime('lead_updated')->nullable()->default(NULL);
            $table->bigInteger('lead_creatorid')->nullable()->default(NULL);
            $table->bigInteger('lead_updatorid')->nullable()->default(NULL);
            $table->bigInteger('lead_categoryid')->default('3');
            $table->string('lead_firstname',100)->nullable()->default(NULL);
            $table->string('lead_lastname',100)->nullable()->default(NULL);
            $table->string('lead_email',150)->nullable()->default(NULL);
            $table->string('lead_phone',150)->nullable()->default(NULL);
            $table->string('lead_job_position',150)->nullable()->default(NULL);
            $table->string('lead_company_name',150)->nullable()->default(NULL);
            $table->string('lead_website',150)->nullable()->default(NULL);
            $table->string('lead_street',150)->nullable()->default(NULL);
            $table->string('lead_city',150)->nullable()->default(NULL);
            $table->string('lead_state',150)->nullable()->default(NULL);
            $table->string('lead_zip',150)->nullable()->default(NULL);
            $table->string('lead_country',150)->nullable()->default(NULL);
            $table->string('lead_source',150)->nullable()->default(NULL);
            $table->string('lead_title',250)->nullable()->default(NULL);
            $table->text('lead_description')->nullable()->default(NULL);
            $table->decimal('lead_value',10,2)->nullable()->default(NULL);
            $table->date('lead_last_contacted')->nullable()->default(NULL);
            $table->string('lead_converted',10)->default('no');
            $table->bigInteger('lead_converted_by_userid')->nullable()->default(NULL);
            $table->datetime('lead_converted_date')->nullable()->default(NULL);
            $table->bigInteger('lead_converted_clientid')->nullable()->default(NULL);
            $table->tinyInteger('lead_status')->default('1');
            $table->string('lead_active_state',10)->default('active');
            $table->string('lead_visibility',40)->default('visible');
            $table->string('lead_custom_field_1',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_2',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_3',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_4',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_5',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_6',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_7',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_8',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_9',100)->nullable()->default(NULL);
            $table->string('lead_custom_field_10',100)->nullable()->default(NULL);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
