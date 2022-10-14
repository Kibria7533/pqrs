<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKabuliatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kabuliats', function (Blueprint $table) {
            $table->increments('id');
            //$table->unsignedInteger('user_id')->nullable();
            $table->string('reg_no', 191)->nullable();
            $table->date('reg_date')->nullable();
            $table->string('case_no', 191)->nullable();
            $table->year('case_year')->nullable();
            $table->date('case_date')->nullable();
            $table->string('form_no')->nullable();
            $table->date('form_date')->nullable();
            $table->string('committee_name')->nullable();
            $table->date('meeting_date')->nullable();
            $table->date('ulao_proposal_date')->nullable();
            $table->date('ulao_return_date')->nullable();
            $table->string('order_no')->nullable();
            $table->date('order_date')->nullable();
            $table->date('handover_date')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedMediumInteger('status')->nullable()->default(1);
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
        Schema::dropIfExists('kabuliats');
    }
}
