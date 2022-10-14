<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191);
            $table->string('meeting_no', 100)->unique();
            $table->date('meeting_date')->nullable();
            $table->tinyInteger('meeting_type')->nullable();
            $table->unsignedInteger('committee_type_id');
            $table->unsignedInteger('template_id')->nullable();
            $table->string('resolution_file', 255)->nullable();
            $table->longText('worksheet')->nullable();

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
        Schema::dropIfExists('meetings');
    }
}
