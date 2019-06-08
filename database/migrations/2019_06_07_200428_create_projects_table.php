<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');

            // サービス名
            $table->unsignedBigInteger('service_id')->nullable();
            // URL
            $table->string('url');

            // 以下は url から og で引っ張ってくる。

            // プロジェクトタイトル
            $table->string('title');
            // URL
            $table->string('image_url');
            // 説明
            $table->text('description');

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
        Schema::dropIfExists('projects');
    }
}
