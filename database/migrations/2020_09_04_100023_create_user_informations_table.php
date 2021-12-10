<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('education_id')->index();
            $table->foreign('education_id')->references('id')->on('educations');
            $table->unsignedBigInteger('profession_id')->index();
            $table->foreign('profession_id')->references('id')->on('professions');
            $table->unsignedBigInteger('tobacco_id')->index();
            $table->foreign('tobacco_id')->references('id')->on('tobaccos');
            $table->unsignedBigInteger('tobacco_product_id')->index();
            // $table->foreign('tobacco_product_id')->references('id')->on('tobacco_products');
            $table->unsignedBigInteger('frequent_smoke_id')->index();
            $table->foreign('frequent_smoke_id')->references('id')->on('frequent_smokes');
            $table->unsignedBigInteger('first_smoking_timing_id')->index();
            $table->foreign('first_smoking_timing_id')->references('id')->on('first_smoking_timings');
            $table->unsignedTinyInteger('gender')->comment('0->Male,1->Female');
            $table->date('date_of_birth')->nullable();
            $table->unsignedTinyInteger('first_tobacco_use_age')->comment('At what age did you first use tobacco');
            $table->unsignedTinyInteger('money_spent')->comment('How much spent for tobacco per day');
            $table->unsignedTinyInteger('usage_count')->comment('How many time do you use tobacco in a day');
            $table->unsignedTinyInteger('tobacco_count')->comment('How many pieces do you use tobacco in a day');
            $table->unsignedTinyInteger('how_hard_to_quit')->comment('0->Easy,1->Not so difficult, 2-> Very Difficult');
            $table->date('quit_date')->nullable();
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
        Schema::dropIfExists('user_informations');
    }
}
