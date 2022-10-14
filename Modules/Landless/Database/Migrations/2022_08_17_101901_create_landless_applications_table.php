<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandlessApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('landless_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('application_number', 100)->nullable();
            $table->string('nothi_number',100)->unique()->nullable();
            $table->string('fullname', 191);
            $table->string('mobile', 50)->nullable();
            $table->string('email', 191)->nullable();
            $table->unsignedMediumInteger('identity_type')->nullable()->comment('1 => Birth Certificate, 2 => NID, 3 = > N/A');
            $table->string('identity_number', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedMediumInteger('landless_type')->nullable();
            $table->unsignedMediumInteger('gender')->nullable()->comment('1 => Male, 2 => Female, 3 => Other');
            $table->string('father_name', 100)->nullable();
            $table->date('father_dob')->nullable();
            $table->boolean('father_is_alive')->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->date('mother_dob')->nullable();
            $table->boolean('mother_is_alive')->nullable();
            $table->string('spouse_name', 100)->nullable();
            $table->date('spouse_dob')->nullable();
            $table->string('spouse_father', 100)->nullable();
            $table->string('spouse_mother', 100)->nullable();
            $table->unsignedInteger('loc_division_bbs')->nullable();
            $table->unsignedInteger('loc_district_bbs')->nullable();
            $table->unsignedInteger('loc_upazila_bbs')->nullable();
            $table->unsignedInteger('loc_union_bbs')->nullable();
            $table->unsignedInteger('jl_number')->nullable();
            $table->string('village', 191)->nullable();
            $table->longText('family_members')->nullable();
            $table->longText('bosot_vita_details')->nullable();
            $table->longText('present_address')->nullable();
            $table->longText('gurdian_khasland_details')->nullable();
            $table->longText('nodi_vanga_family_details')->nullable();
            $table->longText('freedom_fighters_details')->nullable();
            $table->longText('khasland_details')->nullable();
            $table->string('expected_lands', 100)->nullable();
            $table->longText('references')->nullable();
            $table->date('application_received_date')->nullable();
            $table->string('receipt_number', 100)->nullable();
            $table->string('source_type', 100)->nullable();
            $table->tinyInteger('is_land_assigned')->default(0)->nullable();
            $table->tinyInteger('is_acland_approval')->default(0)->nullable();
            $table->unsignedMediumInteger('status')->nullable()->default(5);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landless_applications');
    }
}
