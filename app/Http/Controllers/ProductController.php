<?php

namespace App\Http\Controllers;

use Exception;
use App\Product;
use App\ProductDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->user()->role);
        return apiResponse(
            200,
            'success',
            'List Products / List Prodicts with category',
            Product::with('category_id')->with('productDetails')->get()
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
        // dd('product');
        try {
            // dd($request);
            $rules = [
                'nama' => 'required',
                'tahun_pembuatan'    => 'required',
                'category_id'  => 'required',
                'deskripsi'      => 'required',
                'dimensi'      => 'required',
                'media' => 'required',
                'gambar'      => 'required',
                'status' => 'required',
                'status_barang'      => 'required',
                'kondisi' => 'required',
            ];

            $message = [
                'nama.required'    => 'Mohon isikan nama anda',
                'tahun_pembuatan.required'    => 'Mohon isikan tahun_pembuatan anda',
                'category_id.required'    => 'Mohon isikan category_id anda',
                'deskripsi.required'    => 'Mohon isikan deskripsi anda',
                'dimensi.required'    => 'Mohon isikan dimensi anda',
                'media.required'    => 'Mohon isikan media anda',
                'gambar.required'    => 'Mohon isikan gambar anda',
                'status.required'    => 'Mohon isikan status anda',
                'status_barang.required'    => 'Mohon isikan status_barang anda',
                'kondisi.required'    => 'Mohon isikan kondis anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }
            // dd('asik');

            $data = Product::create(
                $request->all()
            )->productDetails()->create($request->only(
                [
                    'nama, tahun_pembuatan, status, category_id,
            aliran, deskripsi, tahun_pembuatan'
                ]
            ));

            if (!$request->hasFile('gambar')) {
                return apiResponse(500, 'Erorr', 'Data Bukan Image');
            };
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $uniq = Str::orderedUuid();
            $name = $uniq . '.' . $extension;
            $path = base_path('public/assets/images/user/');
            $request->file('gambar')->move($path, $name);
            ProductDetail::where('product_id', $this->id)->insert([
                'gambar' => $name,
            ]);
            return apiResponse(
                200,
                'success',
                'Data berhasil di tambah',
                $data
            );
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return apiResponse(
            200,
            'success',
            'Product : ' . $product->name,
            Product::with('category_id')->with('productDetails')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
