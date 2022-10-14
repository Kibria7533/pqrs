<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEightRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eight_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('register_type')->nullable();
            $table->unsignedInteger('khotian_dag_id')->nullable();
            $table->string('khotian_number', 255)->nullable();
            $table->unsignedInteger('division_bbs_code')->nullable();
            $table->unsignedInteger('district_bbs_code')->nullable();
            $table->unsignedInteger('upazila_bbs_code')->nullable();
            $table->string('jl_number',50)->nullable();
            $table->unsignedInteger('office_id')->nullable();
            $table->string('dag_number', 20)->nullable();
            $table->string('khotian_dag_area', 20)->nullable();
            $table->string('dag_khasland_area', 20)->nullable();
            $table->string('register_khasland_area', 20)->nullable();
            $table->string('remaining_khasland_area', 20)->nullable();
            $table->string('provided_khasland_area', 20)->nullable()->default(0);
            $table->longText('details')->nullable();
            $table->date('register_entry_date')->nullable();
            $table->date('visit_date')->nullable();
            $table->string('register_12_case_number', 100)->nullable();
            $table->date('register_12_distribution_date')->nullable();
            $table->longText('remark')->nullable();
            $table->unsignedMediumInteger('status')->nullable()->comment('1 => Active, 2 => Pending, 4 = > Modify, 5=> Draft');;
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
        Schema::dropIfExists('eight_registers');
    }
}
