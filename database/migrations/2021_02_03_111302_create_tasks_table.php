<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('status');
            $table->timestamps();

<<<<<<< HEAD
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
=======
            $table->foreign('user_id')->references('id')->on('users');
>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
