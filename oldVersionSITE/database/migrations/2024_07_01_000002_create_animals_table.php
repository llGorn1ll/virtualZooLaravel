<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('species');
            $table->string('name');
            $table->integer('age');
            $table->text('description');
            $table->string('image');
            $table->unsignedBigInteger('cage_id');
            $table->foreign('cage_id')->references('id')->on('cages')->onDelete('cascade')->onUpdate('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}; 