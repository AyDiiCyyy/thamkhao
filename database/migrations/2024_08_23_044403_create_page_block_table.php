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
        Schema::create('page_block', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('page_id');
            $table->bigInteger('block_id');
            $table->tinyInteger('position'); // Vị trí các khối trên trang
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_block');
    }
};
