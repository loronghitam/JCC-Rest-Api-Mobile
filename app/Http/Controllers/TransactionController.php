<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Transaction;
use App\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Transaction::where('user_id', auth()->user()->id)->get() == null) {
            // dd($data);
            return apiResponse(
                200,
                'success',
                'Daftar Transaction',
                'Belum ada transaction'
            );
        } else {
            $data = DB::table('transaction_details as transaksi')
                ->join('users', 'transaksi.user_id', '=', 'users.id')
                ->join('transactions', 'transaksi.user_id', '=', 'transactions.user_id')
                ->select('users.name', 'transactions.product_id')
                ->get();
            return apiResponse(
                200,
                'success',
                'Daftar Transaction',
                $data
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(array($request->carts));
        for ($i = 0; $i < count($request->carts); $i++) {
            $carts = $request->carts[$i];
        }
        // foreach ($request->carts as $item) {
        //     $carts[] = $item;
        // }
        // dd($carts);
        try {
            $rules = [
                'alamat'      => 'required',
                'carts'          => 'required',
                'catatan'            => 'required',
                'kurir'          => 'required',
                'pembayaran'            => 'required',
            ];

            $message = [
                'alamat.required'    => 'Mohon isikan alamat anda',
                'carts.required'    => 'Mohon isikan carts anda',
                'catatan.required'    => 'Mohon isikan catatan anda',
                'kurir.required'    => 'Mohon isikan kurir anda',
                'pembayaran.required'    => 'Mohon isikan pembayaran anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }

            DB::transaction(function () use ($request) {
                TransactionDetail::create([
                    'pembayaran' => $request->pembayaran,
                    'kurir' => $request->kurir,
                    'batas_pembayaran' => Carbon::now()->addDay(1),
                    'address_id' => $request->alamat,
                    'user_id' => auth()->user()->id,
                ]);
                for ($i = 0; $i < count($request->carts); $i++) {
                    // dd($request->carts[$i]);
                    Transaction::create([
                        'product_id' => $request->carts[$i],
                        'user_id' => auth()->user()->id,
                    ]);
                }
            });
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
