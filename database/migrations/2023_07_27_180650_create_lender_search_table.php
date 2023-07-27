<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lender_search', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedBigInteger('amortization_id')->nullable();
            $table->unsignedBigInteger('challenges_id')->nullable();
            $table->unsignedBigInteger('credit_score_id')->nullable();
            $table->unsignedBigInteger('immig_status_id')->nullable();
            $table->unsignedBigInteger('income_doc_id')->nullable();
            $table->unsignedBigInteger('loan_id')->nullable();
            $table->unsignedBigInteger('occupancy_id')->nullable();
            $table->unsignedBigInteger('product_type_id')->nullable();
            $table->unsignedBigInteger('property_type_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->boolean('our_client')->default(true);
            $table->boolean('is_active')->default(true);
            $table->string('cb', 255)->nullable();
            $table->timestamp('cd')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('ub', 255)->nullable();
            $table->timestamp('ud')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('amortization_id')->references('id')->on('amortization');
            $table->foreign('challenges_id')->references('id')->on('challenges');
            $table->foreign('credit_score_id')->references('id')->on('credit_score');
            $table->foreign('immig_status_id')->references('id')->on('immig_status');
            $table->foreign('income_doc_id')->references('id')->on('income_doc');
            $table->foreign('loan_id')->references('id')->on('loan');
            $table->foreign('occupancy_id')->references('id')->on('occupancy');
            $table->foreign('product_type_id')->references('id')->on('product_type');
            $table->foreign('property_type_id')->references('id')->on('property_type');
            $table->foreign('state_id')->references('id')->on('state');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lender_search');
    }
};
