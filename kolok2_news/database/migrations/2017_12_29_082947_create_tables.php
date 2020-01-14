<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->text('news_description');
            $table->string('news_link')->default('');
            $table->string('news_title')->default('');
            $table->integer('num_upvotes')->default(0);
            $table->timestamps();
        });
        
        Schema::create('news_comment', function (Blueprint $table) {
			$table->increments('id');
            $table->integer('news_id')->unsigned();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->string('username');
            $table->string('comment_text');
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
        Schema::drop('news_comment');
		Schema::drop('news');
    }
}
