<?php

namespace App\Http\Controllers;

use Exception;
use App\Product;
use App\ProductDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if (request()->search == null) {
            $data = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->join('product_details', 'products.id', '=', 'product_details.product_id')
                ->select(
                    'products.nama',
                    'tahun_pembuatan',
                    'deskripsi',
                    'dimensi',
                    'media',
                    'product_details.gambar as product_gambar',
                    'harga',
                    'status',
                    'status_barang',
                    'kondisi',
                    'categories.name as category',
                    'categories.gambar as category_gambar'
                )
                ->limit(5)
                ->get();
        } else {
            $data = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->join('product_details', 'products.id', '=', 'product_details.product_id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->where(
                    'categories.name',
                    'like',
                    '%' . request()->search . '%',
                )
                ->orWhere(
                    'users.name',
                    'like',
                    '%' . request()->search . '%',
                )
                ->select(
                    'users.name as pembuat',
                    'products.nama as nama_lukisan',
                    'tahun_pembuatan',
                    'deskripsi',
                    'dimensi',
                    'media',
                    'product_details.gambar as product_gambar',
                    'harga',
                    'status',
                    'status_barang',
                    'kondisi',
                    'categories.name as category',
                    'categories.gambar as category_gambar'
                )
                ->limit(5)
                ->get();
        }
        // dd(auth()->user()->role);
        return apiResponse(
            200,
            'success',
            'List Products / List Prodicts with category',
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
                'harga' => 'required',
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
                'harga.required'    => 'Mohon isikan harga anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }

            if (!$request->hasFile('gambar')) {
                return apiResponse(500, 'Erorr', 'Data Bukan Image');
            };

            $extension = $request->file('gambar')->getClientOriginalExtension();
            $uniq = Str::orderedUuid();
            $name = $uniq . '.' . $extension;
            $path = base_path('public/assets/images/product/');
            $request->file('gambar')->move($path, $name);

            $product = Product::create([
                'nama' => $request->nama,
                'tahun_pembuatan' => $request->tahun_pembuatan,
                'category_id' => $request->category_id,
                'user_id' => auth()->user()->id,
            ])->productDetails()->create(
                [
                    'tahun_pembuatan' => $request->tahun_pembuatan,
                    'status' => $request->status,
                    'category_id' => $request->category_id,
                    'aliran' => $request->aliran,
                    'deskripsi' => $request->deskripsi,
                    'tahun_pembuatan' => $request->tahun_pembuatan,
                    'harga' => $request->harga,
                    'dimensi' => $request->dimensi,
                    'media' => $request->media,
                    'status' => $request->status,
                    'status_barang' => $request->status_barang,
                    'kondisi' => $request->kondisi,
                    'gambar' => $name
                ]
            );

            $gambar = asset('assets/images/product/' . $name);

            $data  = [
                $product,
                $gambar,
            ];
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
        $product = DB::table('products')
            ->where('products.id', $product->id)
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->select('nama', 'tahun_pembuatan', 'category_id', 'deskripsi', 'dimensi', 'media', 'status', 'gambar', 'harga', 'status', 'status_barang', 'kondisi')
            ->first();

        // dd($product->gambar);
        $gambar =  asset('assets/images/product/' . $product->gambar);

        $data = [
            $product,
            $gambar,
        ];

        return apiResponse(
            200,
            'success',
            'Product : ' . $product->nama,
            $data
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
        // dd($product);
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
                'harga' => 'required',
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
                'harga.required'    => 'Mohon isikan harga anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }

            if (!$request->hasFile('gambar')) {
                return apiResponse(500, 'Erorr', 'Data Bukan Image');
            };

            $extension = $request->file('gambar')->getClientOriginalExtension();
            $uniq = Str::orderedUuid();
            $name = $uniq . '.' . $extension;
            $path = base_path('public/assets/images/product/');
            $request->file('gambar')->move($path, $name);
            // dd($request);
            Product::where('id', $product->id)->update([
                'nama'              => $request->nama,
                'tahun_pembuatan'   => $request->tahun_pembuatan,
                'category_id'       => $request->category_id,
            ]);
            // dd($data);
            $baru = Product::find($product->id);
            $baru->productDetails()->update(
                [
                    'deskripsi'     => $request->deskripsi,
                    'dimensi'       => $request->dimensi,
                    'media'         => $request->media,
                    'status'        => $request->status,
                    'gambar'        => $name,
                    'harga'         => $request->harga,
                    'status'        => $request->status,
                    'status_barang' => $request->status_barang,
                    'kondisi'       => $request->kondisi,
                ]
            );

            $product =  DB::table('products')
                ->where('products.id', $product->id)
                ->join('product_details', 'products.id', '=', 'product_details.product_id')
                ->select('nama', 'tahun_pembuatan', 'category_id', 'deskripsi', 'dimensi', 'media', 'status', 'gambar', 'harga', 'status', 'status_barang', 'kondisi')
                ->first();

            $gambar =  asset('public/assets/images/product/') . '/' . $name;

            $data = [
                $product,
                $gambar
            ];


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
