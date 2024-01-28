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
        Schema::create('grievance_movements', function (Blueprint $table) {
           $table->id();

            $table->unsignedBigInteger('grievance_id');
            $table->unsignedBigInteger('action_id')->nullable();

            $table->string('grievance_classification')->nullable();
            $table->string('nature_of_grievance')->nullable();

            $table->unsignedBigInteger('officer_id')->nullable();
            $table->string('officer_name')->nullable();
            $table->string('officer_designation')->nullable();
            $table->string('officer_mobile')->nullable();
            $table->string('officer_email')->nullable();

            $table->integer('from_id')->nullable();
            $table->string('from_type')->nullable();

            $table->integer('to_id')->nullable();
            $table->string('to_type')->nullable();

            $table->text('remark')->nullable();
            $table->text('reason')->nullable();
 
            $table->string('action_taken_by')->nullable();
            $table->integer('action_taken_by_id')->nullable();
            
            $table->string('date_of_action')->nullable();
            $table->string('update_date_of_action')->nullable();

            $table->string('status')->nullable();

            $table->boolean('case_can_be_close')->nullable();
            $table->boolean('is_mark_close')->default(false)->nullable();

            $table->string('appeal_number')->nullable();
            $table->text('nodal_attachment')->nullable();
            $table->string('is_opened')->nullable();
            $table->string('is_seen_by_department')->nullable();
            $table->string('is_seen_by_sub_department')->nullable();
            $table->string('sub_department_owner')->nullable();

            $table->boolean('is_duplicate')->nullable(); // TO MARK IF THE GRIEVANCE IS COMING FROM ANOTHER DEPT.

            $table->integer('maximum_days')->nullable();
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

            $table->foreign('grievance_id')->references('id')->on('grievances');
            $table->foreign('action_id')->references('id')->on('actions');

            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievance_movements');
    }
};
