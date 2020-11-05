<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->id();
          $table->string('first_name');
          $table->string('surname');
          $table->string('email')->unique();
          $table->timestamp('email_verified_at')->nullable();
          $table->string('password');
          $table->rememberToken();

          $table->string('phone_number')->nullable();
          $table->string('mobile_number')->nullable();
          $table->string('calendar_color', 7);
          $table->date('dob')->nullable();
          $table->string('gender', 10)->nullable();
          $table->string('home_address')->nullable();

          $table->decimal('hourly_rate_standard');
          $table->decimal('hourly_rate_overtime');

          $table->string('job_role');
          $table->bigInteger('manager')->nullable();

          $table->unsignedBigInteger('created_by')->nullable();
          $table->unsignedBigInteger('updated_by')->nullable();
          $table->unsignedBigInteger('deleted_by')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::table('users', function (Blueprint $table) {
          $table->foreign('created_by')->references('id')->on('users');
          $table->foreign('updated_by')->references('id')->on('users');
          $table->foreign('deleted_by')->references('id')->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
