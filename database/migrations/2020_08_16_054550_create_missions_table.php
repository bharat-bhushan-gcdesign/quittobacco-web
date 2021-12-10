<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('notes',255);
            $table->date('date');
            $table->unsignedTinyInteger('last_entry')->default(0)->comment('0->Inactive,1->Active');
            $table->unsignedTinyInteger('tobacco_desire')->default(0)->comment('0->Inactive,1->Active');
            $table->unsignedTinyInteger('craving_count')->default(0)->comment('0->Inactive,1->Active');
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
        Schema::dropIfExists('missions');
    }
}
