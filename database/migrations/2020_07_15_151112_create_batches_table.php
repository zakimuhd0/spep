<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch')->unique();
            $table->string('semester')->default('1');
            $table->string('m1');
            $table->string('m2');
            $table->string('m3');
            $table->string('m4');
            $table->string('m5');
            $table->string('m6');
            $table->string('m7');
            $table->string('m8');
            $table->string('m9');
            $table->string('m10');
            $table->string('m11');
            $table->string('m12');
            $table->string('m13');
            $table->string('m14');
            $table->string('m15');
            $table->string('m16');
            $table->string('m17');
            $table->string('m18');
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
        Schema::dropIfExists('batches');
    }
}
