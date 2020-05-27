<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsAndTagsArticlesInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('t_name')->nullable()->unique();
            $table->string('t_slug')->nullable();
            $table->string('t_description')->nullable();
            $table->integer('t_admin_id')->default(0)->index();
            $table->tinyInteger('t_hot')->default(0)->index();
            $table->text('t_content')->nullable();
            $table->timestamps();
        });

		Schema::create('articles_tags', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('at_tag_id')->index()->default(0);
			$table->integer('at_article_id')->index()->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('articles_tags');
    }
}
