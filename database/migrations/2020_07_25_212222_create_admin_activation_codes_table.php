<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminActivationCodesTable extends Migration
{

    public function up()
    {
        Schema::create('admin_activation_codes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_id')->unsigned()->index();
            $table->string('code');
            $table->timestamps();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('admin_activation_codes');
    }
}
