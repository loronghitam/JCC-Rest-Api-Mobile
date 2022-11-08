<?php

namespace App\Http\Controllers;

use App\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('carts')
            ->where(
                'condition',
                '=',
                '0',
            )
            ->where(
                'carts.user_id',
                '=',
                auth()->user()->id
            )
            ->join('users', 'carts.user_id', '=', 'users.id')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->join('product_details as detail', 'products.id', '=', 'detail.product_id')
            ->join('users as pelukis', 'products.user_id', '=', 'pelukis.id')
            ->join('user_details as pelukisD', 'users.id', '=', 'pelukisD.user_id')
            // ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.nama as nama_product',
                'tahun_pembuatan',
                'pelukis.name as nama_pelukis',
                // 'categories.name as category'
                'detail.harga',
                'pelukisD.gambar as gambar_pelukis',
                'pelukisD.aliran as aliran_pelukis'
            )
            ->orderBy('carts.created_at', 'desc')
            ->get();
        return apiResponse(
            200,
            'Success',
            'Daftar Cart',
            // Cart::where('user_id', auth()->user()->id,)->where('condition', 0)->with('product_id.category_id')->get()
            $data
        );
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
        if (Cart::where('product_id', $request->product_id)->where('user_id', auth()->user()->id)->first()) {
            return apiResponse(
                400,
                'error',
                'Product Sudah Terdaftar',
                DB::table('carts')->join('products', 'carts.product_id', '=', 'products.id')
                    ->select('carts.*', 'products.*')->first()
            );
        } else {
            try {
                $data = Cart::create([
                    'product_id' => $request->product_id,
                    'user_id' => auth()->user()->id,
                ]);
                return apiResponse(
                    200,
                    'success',
                    'Data Berhasil Ditambah',
                    $data
                );
            } catch (Exception $e) {
                dd($e);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        dd('ini buat delete tapi belum di bikin');
    }
}
