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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('sub_department_id')->nullable();
 
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile')->nullable();

            $table->string('gender')->nullable();
            $table->string('designation')->nullable();
            $table->string('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->string('district')->nullable();
            
            $table->string('notification')->nullable();
            $table->boolean('active')->nullable();
            $table->string('last_login')->nullable();
            
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('sub_department_id')->references('id')->on('sub_departments');
            
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
           
            $table->rememberToken();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
