<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloseContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('close_contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned();
            $table->text('address');
            $table->string('name');
            $table->string('relationship');
            $table->string('duration');
            $table->string('time');
            $table->date('date');
            $table->string('longitude');
            $table->string('longitude');

            // Relationship
            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();

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
        Schema::dropIfExists('close_contacts');
    }
}
