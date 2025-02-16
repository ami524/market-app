<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('brand');
            $table->integer('price');
            $table->string('description');
            $table->string('item_image')->nullable();
            $table->enum('item_condition', ['good', 'so so', 'bad', 'so bad'])->default('good');
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->timestamps();

                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

                $table->boolean('is_sold')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');

        Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('is_sold');
        });
    }
}
