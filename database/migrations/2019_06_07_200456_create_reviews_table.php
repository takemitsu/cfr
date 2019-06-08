<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');

            // サービスID
            $table->unsignedBigInteger('service_id')->nullable();
            // プロジェクトID
            $table->unsignedBigInteger('project_id')->nullable();

            // レビュワーニックネーム
            $table->string('nickname');

            // 評価

            $table->unsignedTinyInteger('score_product'); // 商品
            $table->unsignedTinyInteger('score_vendor'); // 実行者
            $table->unsignedTinyInteger('score_retry'); // また買いたい
            $table->unsignedTinyInteger('score_total'); // 総合

            // 商品名
            $table->string('product_name')->nullable();
            // コメント
            $table->text('comment')->nullable();

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
        Schema::dropIfExists('reviews');
    }
}
