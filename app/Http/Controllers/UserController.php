<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
            'success',
            'Data User',
            [User::where('id', 2)->first()
                ->userDetail()->first()],
            [UserDetail::where('user_id', 2)->first()
                ->address()->first()],
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
        try {
            // dd($request);
            $rules = [
                // 'tanggal_lahir'     => 'required',
                'tempat_lahir'      => 'required',
                'biografi'          => 'required',
                'status'            => 'required',
                'no_phone'          => 'required',
                'aliran'            => 'required',
                'gambar'            => 'required',
            ];

            $message = [
                // 'tanggal_lahir.required'    => 'Mohon isikan tanggal_lahir anda',
                'tempat_lahir.required'    => 'Mohon isikan tempat_lahir anda',
                'biografi.required'    => 'Mohon isikan biografi anda',
                'status.required'    => 'Mohon isikan status anda',
                'no_phone.required'    => 'Mohon isikan no_phone anda',
                'aliran.required'    => 'Mohon isikan aliran anda',
                'gambar.required'    => 'Mohon isikan gambar anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }

            $user = UserDetail::where('id', 2)->update([
                'tanggal_lahir'     => now(),
                'tempat_lahir'      => $request->tempat_lahir,
                'biografi'          => $request->biografi,
                'status'            => $request->status,
                'no_phone'          => $request->no_phone,
                'aliran'            => $request->aliran,
                'gambar'            => $request->gambar,
            ]);

            return apiResponse(200, 'success', 'Data berhasil Dirubah', UserDetail::where('id', 2)->first());
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
