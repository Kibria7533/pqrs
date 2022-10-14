<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatenotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('meeting_id');
            $table->unsignedInteger('meeting_committee_id')->nullable();
            $table->unsignedTinyInteger('is_email_enable')->nullable();
            $table->unsignedTinyInteger('is_sms_enable')->nullable();
            $table->longText('email_notification_body')->nullable();
            $table->longText('sms_notification_body')->nullable();
            $table->unsignedInteger('total_member')->nullable()->default(0);
            $table->json('member_config')->nullable();

            $table->tinyInteger('status')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
