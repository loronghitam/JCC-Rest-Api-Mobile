<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
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
        return apiResponse(
            200,
            "success",
            "List Categories",
            Category::all()
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

            $data = Category::create($request->all());

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
        return apiResponse(
            400,
            'error',
            'Data Category',
            Category::find($id)->first()
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

            $data = Category::where('id', $id)->update($request->only('name', 'gambar'));

            return apiResponse(
                200,
                'success',
                'Data berhasil Dirubah',
                Category::find($id)->all()
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
