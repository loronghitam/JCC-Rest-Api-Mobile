<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->string('no_resi');
            $table->integer('total');
            $table->string('kurir');
            $table->string('pembayaran'); //methode yang digunakn untuk pembayaran
            $table->string('status');
            $table->string('status_paket');
            $table->date('batay_pembayaran');
            $table->foreignId('transaction_id')->constrained();
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
        Schema::dropIfExists('transaction_details');
    }
}
