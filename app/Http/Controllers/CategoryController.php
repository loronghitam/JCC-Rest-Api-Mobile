<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  Category::limit(5)->get(['name as nama', 'gambar']);

        return apiResponse(
            200,
            "success",
            "List Categories",
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // dd($request);
            $rules = [
                'name'     => 'required',
                'gambar'      => 'required',
            ];

            $message = [
                'name.required'    => 'Mohon isikan nama anda',
                'gambar.required'    => 'Mohon isikan gambar anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(
                    400,
                    'error',
                    'Data tidak lengkap ',
                    $validator->errors()
                );
            }
            if (!$request->hasFile('gambar')) {
                return apiResponse(500, 'Erorr', 'Data Bukan Image');
            };
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $uniq = Str::orderedUuid();
            $name = $uniq . '.' . $extension;
            $path = base_path('public/assets/images/category/');
            $request->file('gambar')->move($path, $name);

            $category = Category::create([
                'name' => $request->name,
                'gambar' => $name,
            ]);

            $gambar = asset('images/category/' . $category->gambar);
            $data = [
                $category,
                $gambar,
            ];


            return apiResponse(
                200,
                'success',
                'Data berhasil Dirubah',
                $data
            );
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id)->first(['name as nama', 'gambar']);
        $gambar = asset('assets/images/product/' . $category->gambar);

        $data  = [
            $category,
            $gambar,
        ];
        return apiResponse(
            200,
            'success',
            'Data Category',
            $data
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            $rules = [
                'name'     => 'required',
                'gambar'      => 'required',
            ];

            $message = [
                'name.required'    => 'Mohon isikan nama anda',
                'gambar.required'    => 'Mohon isikan gambar anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(
                    400,
                    'error',
                    'Data tidak lengkap ',
                    $validator->errors()
                );
            }
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $uniq = Str::orderedUuid();
            $name = $uniq . '.' . $extension;
            $path = base_path('public/assets/images/category/');
            $request->file('gambar')->move($path, $name);

            $category = Category::where('id', $id)->update([
                'name' => $request->name,
                'gambar' => $name,
            ]);

            $gambar = asset('assets/images/category/' . $name);
            $data = [
                Category::where('id', $id)->first(),
                $gambar,
            ];

            return apiResponse(
                200,
                'success',
                'Data berhasil Dirubah',
                $data
            );
        } catch (Exception $e) {
            dd($e);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return apiResponse(
            200,
            'success',
            'data berhasil di hapus',
            Category::find($id)->delete()
        );
    }
}
