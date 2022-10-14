<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_bn',191);
            $table->string('name_en',191)->nullable();
            $table->string('org_code',100)->nullable();
            $table->unsignedMediumInteger('office_type')->nullable();
            $table->char('jurisdiction',100)->nullable();

            $table->unsignedMediumInteger('division_bbs_code')->index('offices_division_bbs_code_foreign')->nullable();
            $table->unsignedInteger('district_bbs_code')->index('offices_district_bbs_code_foreign')->nullable();
            $table->unsignedInteger('upazila_bbs_code')->index('offices_upazila_bbs_code_foreign')->nullable();
            $table->unsignedInteger('union_bbs_code')->nullable();

            $table->string('dglr_code', 100)->nullable();
            $table->tinyInteger('status')->default('1');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->datetime('deleted_at')->nullable();

            /*$table->foreign('division_bbs_code','offices_division_bbs_code_foreign')
                ->references('bbs_code')
                ->on('loc_divisions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('district_bbs_code')
                ->references('bbs_code')
                ->on('loc_districts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('upazila_bbs_code')
                ->references('bbs_code')
                ->on('loc_upazilas')
                ->onUpdate('cascade')
                ->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offices');
    }
}
