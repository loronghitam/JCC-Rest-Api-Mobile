<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventDetialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_detials', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('alamat');
            $table->text('slug');
            $table->text('isi');
            $table->text('gambar');
            $table->date('tanggal_acara');
            $table->foreignId('event_id')->constrained();
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
        Schema::dropIfExists('event_detials');
    }
}
