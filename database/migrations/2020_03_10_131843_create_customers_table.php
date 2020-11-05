<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->boolean('prospect')->default(1);
            $table->string('type');
            $table->string('label');
            $table->unsignedBigInteger('account_manager_id')->nullable();
            $table->unsignedBigInteger('parent_company_id')->nullable();
            $table->string('general_contact_number');
            $table->string('general_email_address');
            $table->unsignedBigInteger('referral_source_id')->nullable();
            $table->string('status');

            $table->string('company_name')->nullable();
            $table->string('company_number')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_manager_id')->references('id')->on('users');
            $table->foreign('referral_source_id')->references('id')->on('referral_sources');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('parent_company_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
