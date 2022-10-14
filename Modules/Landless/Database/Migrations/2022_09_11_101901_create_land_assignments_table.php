<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('meeting_id');
            $table->unsignedInteger('landless_application_id');
            $table->unsignedInteger('eight_register_id');
            $table->unsignedInteger('division_bbs_code');
            $table->unsignedInteger('district_bbs_code');
            $table->unsignedInteger('upazila_bbs_code');
            $table->unsignedInteger('jl_number');
            $table->string('khotian_number',30);
            $table->string('dag_number',20);
            $table->string('assigned_land_area',20);
            $table->unsignedTinyInteger('assigned_land_side')->nullable();
            $table->unsignedTinyInteger('is_case_order_by_acland')->nullable();
            $table->string('case_number', 100)->nullable();
            $table->unsignedTinyInteger('is_scratch_map_created')->nullable()->default(0);
            $table->unsignedInteger('scratch_map_created_by')->nullable();
            //$table->unsignedInteger('scratch_map_status')->nullable()->comment('1=>kanungo_approval, 2=>acland_approval,10=>re_correction,11=>kanungo_reject,22=>acland_reject');
            /*$table->unsignedTinyInteger('is_scratch_map_reject_by_kanungo')->nullable()->default(0);
            $table->unsignedTinyInteger('is_scratch_map_approved_by_acland')->nullable()->default(0);*/
            $table->unsignedTinyInteger('is_jomabondi_order_by_acland')->nullable()->default(0);
            $table->unsignedTinyInteger('is_jomabondi_fill_up_by_kanungo')->nullable()->default(0);
            $table->unsignedInteger('jomabondi_created_by')->nullable();
            //$table->unsignedInteger('jomabondi_status')->nullable()->comment('1=>surveyor_approval, 2=>tofsildar_send_to_acland,3=>acland_approval,10=>re_correction,11=>surveyor_reject,33=>acland_reject');


            /*$table->unsignedTinyInteger('is_jomabondi_approved_by_surveyor')->nullable()->default(0);
            $table->unsignedTinyInteger('is_jomabondi_approved_by_tofsildar')->nullable()->default(0);
            $table->unsignedTinyInteger('is_jomabondi_approved_by_acland')->nullable()->default(0);
            $table->unsignedTinyInteger('is_approved_by_acland')->nullable()->default(0);*/
            /*$table->unsignedTinyInteger('is_approved_by_uno')->nullable()->default(0);
            $table->unsignedTinyInteger('is_approved_by_dc')->nullable()->default(0);*/
            $table->unsignedTinyInteger('is_salami_received')->nullable()->default(0);
            $table->unsignedTinyInteger('is_salami_receipt_provided')->nullable()->default(0);
            $table->unsignedTinyInteger('is_order_kabuliat')->nullable()->default(0);
            $table->longText('remark')->nullable();
            $table->unsignedMediumInteger('status')->nullable()->default(3);
            $table->unsignedMediumInteger('stage')->nullable()->default(2);
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
        Schema::dropIfExists('land_assignments');
    }
}
