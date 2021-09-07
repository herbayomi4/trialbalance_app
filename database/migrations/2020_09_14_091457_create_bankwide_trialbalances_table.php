<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankwideTrialbalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankwide_trialbalances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class');
            $table->date('date');
            $table->string('curr_code');
            $table->string('bra_code');
            $table->string('branch_name');
            $table->string('state');
            $table->string('led_code');
            $table->string('description');
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bankwide_trialbalances');
    }
}
