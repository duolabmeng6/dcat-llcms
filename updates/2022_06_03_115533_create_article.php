<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('articles')) {
            return true;
        }
        Schema::create('articles', function (Blueprint $table) {
            $table->id()->unsigned()->index();

//            $table->foreignId ('user_id');

            $table->string('title', 200)->default('')->comment('文章标题');
//            $table->string ('cover_url')->default ('')->comment ('文章封面图片');
//            $table->string ('desc', 200)->default ('')->comment ('文章摘要');
            $table->string('tags', 255)->default('')->comment('文章标签');
            $table->mediumText('content')->comment('内容');
            $table->tinyInteger('show')->default(0)->comment('是否显示');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id()->unsigned()->index();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('article_tag', function (Blueprint $table) {
            $table->bigInteger('article_id')->unsigned()->index();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

            $table->bigInteger('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

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
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('tags');
    }
}
