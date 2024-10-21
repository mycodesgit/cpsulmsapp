<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classfile_upload', function (Blueprint $table) {
            $table->id();
            $table->string('schlyear');
            $table->integer('semester');
            $table->string('campus');
            $table->integer('instructorID');
            $table->integer('subjectID');
            $table->string('topicname');
            $table->text('desctopicname');
            $table->text('filedocs');
            $table->integer('postedBy');
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
        Schema::dropIfExists('classfile_upload');
    }
};
