<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Address;
use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('asik');
        // DB::enableQueryLog();
        return apiResponse(
            200,
            'success',
            'Data User',
            DB::table('users')
                ->join('addresses', 'users.id', '=', 'addresses.user_id')
                ->select('name', 'email', 'role', 'no_alamat as urutan alamat', 'alamat', 'provinsi', 'kota', 'kecamatan', 'desa')
                ->get()
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
                'no_alamat' => 'required',
                'alamat'    => 'required',
                'provinsi'  => 'required',
                'kota'      => 'required',
                'desa'      => 'required',
            ];

            $message = [
                // 'tanggal_lahir.required'    => 'Mohon isikan tanggal_lahir anda',
                'no_alamat.required'    => 'Mohon isikan no_alamat anda',
                'alamat.required'    => 'Mohon isikan alamat anda',
                'provinsi.required'    => 'Mohon isikan provinsi anda',
                'kota.required'    => 'Mohon isikan kota anda',
                'desa.required'    => 'Mohon isikan desa anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }
            $user = Address::create([
                'no_alamat'      => $request->no_alamat,
                'alamat'          => $request->alamat,
                'provinsi'            => $request->provinsi,
                'kota'          => $request->kota,
                'user_id' => auth()->user()->id,
                'desa'            => $request->desa,
            ]);

            return apiResponse(
                200,
                'success',
                'Data berhasil Dirubah',
                // Address::latest()
                $user
            );
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        // dd($address->no_alamat);
        try {
            $id = auth()->user()->id;
            // dd($id);
            $rules = [
                'alamat'    => 'required',
                'provinsi'  => 'required',
                'kota'      => 'required',
                'desa'      => 'required',
            ];

            $message = [
                // 'tanggal_lahir.required'    => 'Mohon isikan tanggal_lahir anda',
                'alamat.required'    => 'Mohon isikan alamat anda',
                'provinsi.required'    => 'Mohon isikan provinsi anda',
                'kota.required'    => 'Mohon isikan kota anda',
                'desa.required'    => 'Mohon isikan desa anda',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            // if ($validator->fails()) {
            //     return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            // }
            $user = Address::where(['user_id',  $id], ['no_alamat', '=', $address])->update([
                'no_alamat'      => $request->no_alamat,
                'alamat'          => $request->alamat,
                'provinsi'            => $request->provinsi,
                'kota'          => $request->kota,
                'desa'            => $request->desa,
            ]);

            return apiResponse(200, 'success', 'Data berhasil Dirubah', Address::where('id', 2)->first());
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
