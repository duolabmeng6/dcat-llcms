<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cms_category')) {
            Schema::create('cms_category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('parent_id')->default(0);
                $table->integer('order')->default(0);
                $table->string('title', 50);
                $table->string('icon', 50)->nullable();
                $table->string('uri', 50)->nullable();
                $table->tinyInteger('show')->default(1);
                $table->string('extension', 50)->default('');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_category');

    }
}

;
