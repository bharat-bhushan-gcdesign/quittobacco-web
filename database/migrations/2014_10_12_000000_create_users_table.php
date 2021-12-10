<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('code',config('constants.code_length'))->index()->unique();
            $table->string('name',75)->index();
            $table->string('password',60)->nullable();
            $table->string('email',75)->index()->unique();
            $table->string('mobile',75)->index()->unique();
            $table->date('date_of_birth')->nullable();
            $table->integer('otp')->nullable();
            
            $table->unsignedTinyInteger('gender')->nullable()->comment('1->male,2->female');

            $table->unsignedTinyInteger('role')->comment('0->super_admin,1->admin,2->customer');
            $table->unsignedTinyInteger('status')->default(0)->comment('0->default,1->verified,2->active,3->inactive,4->blocked');
            $table->string('fcm_token',75)->index();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
