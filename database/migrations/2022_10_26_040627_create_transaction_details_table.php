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
            $table->string('no_resi')->nullable();
            $table->integer('total')->nullable();
            $table->string('kurir');
            $table->string('pembayaran'); //methode yang digunakn untuk pembayaran
            $table->string('status')->default('pending');
            $table->string('status_paket')->default('dikemas');
            $table->date('batas_pembayaran');
            // $table->foreignId('transaction_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('address_id')->constrained();
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
