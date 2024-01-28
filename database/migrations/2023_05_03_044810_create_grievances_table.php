<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grievances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("action_id")->nullable();
            $table->unsignedBigInteger("category_id")->nullable();

            $table->string('applicant_name')->nullable();
            $table->string('applicant_mobile')->nullable();
            $table->string('applicant_email')->nullable();
            $table->string('applicant_address')->nullable();
            $table->string('applicant_district')->nullable();

            $table->text('grievance_description');
            $table->text('grievance_attachment')->nullable();

            $table->string('registration_number')->nullable();
            
            $table->string('date_of_receipt')->nullable();
            $table->string('update_date_of_receipt')->nullable();

            $table->text('nodal_attachment')->nullable();
            $table->text('final_remark')->nullable();
            $table->string('date_of_final_remark')->nullable();
            $table->string('update_date_of_final_remark')->nullable();

            $table->string('type_of_receipt')->nullable();
            $table->string('web_api')->nullable();

            $table->string('applicant_rating')->nullable(); // rating: 1-5 /5 being the best
            $table->text('applicant_feedback')->nullable();

            $table->string('days_allotted')->nullable();

            $table->unsignedBigInteger('officer_id')->nullable();
            $table->string('officer_name')->nullable();
            $table->string('officer_designation')->nullable();
            $table->string('officer_mobile')->nullable();
            $table->string('officer_email')->nullable();

            $table->boolean('sub_organization_can_close_case')->nullable();

            $table->boolean('is_appeal')->nullable();
            $table->boolean('is_transfer')->nullable();//TO MARK WEATHER THE GRIEVANCE IS TRANSFERED. IF IT IS TRUE WE NO LONGER REFERENCE TO THIS ROW
            $table->boolean('is_duplicate')->nullable(); // TO MARK IF THE GRIEVANCE IS COMING FROM ANOTHER DEPT.

            $table->string('is_seen_by_department')->nullable();
            $table->string('is_seen_by_sub_department')->nullable();
            $table->string('is_seen_by_citizen')->nullable();
            $table->string('is_seen_by_appellate')->nullable();

            $table->string('closed_by_sub_id')->nullable();


            $table->string('param1')->nullable();
            $table->string('param2')->nullable();
            $table->string('param3')->nullable();
            $table->string('param4')->nullable();
            $table->string('param5')->nullable();
            $table->text('param6')->nullable();
            $table->text('param7')->nullable();
            $table->text('param8')->nullable();
            $table->text('param9')->nullable();
            $table->text('param10')->nullable();
            
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('action_id')->references('id')->on('actions');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievances');
    }
};
