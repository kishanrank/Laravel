<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminProfileTable extends Migration
{

    public function up()
    {
        Schema::create('admin_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_id')->unsigned()->index();
            $table->string('avatar')->nullable();
            $table->text('about')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('twitter')->nullable()->default(null);
            $table->string('instagram')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('admin_profile');
    }
}
