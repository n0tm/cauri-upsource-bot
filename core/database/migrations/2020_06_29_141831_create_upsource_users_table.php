<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpsourceUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upsource_users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            /**
             * @todo: Проект не должен быть привязан к конкретному пользователю,
	         * так как он может разрабатывать на двух проектах,
	         * но так как нормальная практика в компании говорит о том,
	         * что каждый сотрудник нанимается в один отдел и работает над одним проектом
	         * то пока будет так, возможно в следующий раз надо будет это исправить
             **/
            $table->string('project_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('upsource_users');
    }
}
