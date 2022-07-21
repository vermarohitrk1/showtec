<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {

		$table->increments('attachment_id')->unsigned();
		$table->string('attachment_uniqiueid',100);
		$table->datetime('attachment_created')->nullable()->default(NULL);
		$table->datetime('attachment_updated')->nullable()->default(NULL);
		$table->bigInteger('attachment_creatorid');
		$table->bigInteger('attachment_clientid')->nullable()->default(NULL);
		$table->string('attachment_directory',100);
		$table->string('attachment_filename',250);
		$table->string('attachment_extension',20)->nullable()->default(NULL);
		$table->string('attachment_type',20)->nullable()->default(NULL);
		$table->string('attachment_size',30)->nullable()->default(NULL);
		$table->string('attachment_thumbname',250)->nullable()->default(NULL);
		$table->string('attachmentresource_type',50);
		$table->bigInteger('attachmentresource_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}