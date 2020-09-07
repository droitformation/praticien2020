<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArretsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrets', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->longText('content')->nullable();;
            $table->timestamp('published_at')->nullable();
            $table->string('slug');
            $table->string('guid')->nullable();
            $table->string('status')->default('brouillon');
            $table->string('lang')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrets');
    }
}
