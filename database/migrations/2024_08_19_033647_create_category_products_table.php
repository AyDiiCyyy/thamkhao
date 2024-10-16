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
        Schema::create('category_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('avatar')->nullable();
            $table->tinyInteger('order')->default(0);
            $table->bigInteger('parent_id')->default(0);
            $table->bigInteger('language_id');
            $table->string('title_seo')->nullable();
            $table->string('description_seo')->nullable();
            $table->string('keyword_seo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_products');
    }
};
