<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('savings', function (Blueprint $table) {
        //     $table->bigIncrements('id');
           
        //     $table->unsignedInteger('user_id')->index();
        //     $table->foreign('user_id')->references('id')->on('users');
        //     $table->decimal('per_day',50);
        //     $table->decimal('per_week',50);
        //     $table->decimal('per_month',50);
        //     $table->decimal('per_year',50);
        //     $table->unsignedTinyInteger('status')->default(0)->comment('0->Inactive,1->Active');
        //     $table->timestamp('created_at')->useCurrent();
        //     $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        //     $table->softDeletes()->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savings');
    }
}
