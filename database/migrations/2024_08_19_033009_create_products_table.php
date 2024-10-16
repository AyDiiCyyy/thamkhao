<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('price_old', 10, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->string('description', 500)->nullable();
            $table->text('content')->nullable();
            $table->integer('view')->default(0);
            $table->tinyInteger('hot')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->integer('order')->default(0);
            $table->string('title_seo')->nullable();
            $table->string('description_seo')->nullable();
            $table->string('keyword_seo')->nullable();
            $table->bigInteger('language_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
