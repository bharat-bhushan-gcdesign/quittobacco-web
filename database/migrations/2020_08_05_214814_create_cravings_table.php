<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCravingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cravings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('doing_id')->index();
            $table->foreign('doing_id')->references('id')->on('doings');
            $table->unsignedBigInteger('feeling_id')->index();
            $table->foreign('feeling_id')->references('id')->on('feelings');
            $table->unsignedBigInteger('with_whom_id')->index();
            $table->foreign('with_whom_id')->references('id')->on('with_whoms');
            $table->string('location',150);
            $table->unsignedSmallInteger('rate')->default(0);
            $table->unsignedSmallInteger('tobacco_per_day')->default(0);
            $table->unsignedTinyInteger('status')->default(0)->comment('0->Inactive,1->Active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cravings');
    }
}
