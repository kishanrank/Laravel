<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_id')->unsigned()->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('info');
            $table->text('content'); 
            $table->integer('category_id');
            $table->string('featured');
            $table->boolean('published')->default(0);
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamp('published_at')->default(NULL)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
