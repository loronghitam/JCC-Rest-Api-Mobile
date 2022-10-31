<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\UserDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user =
            User::where('id', $id)
            ->first()->userDetail()->first();
        UserDetail::where('user_id', $id)->first()
            ->address()->first();
        $image = asset('assets/images/user/' . $user->gambar);
        $data = [
            $user,
            $image,
        ];
        return apiResponse(
            200,
            'success',
            'Data User',
            [User::where('id', $id)
                ->first()->userDetail()->first()],
            [UserDetail::where('user_id', $id)->first()
                ->address()->first()]

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('users')->where('users.id', $id)
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->select(
                'name',
                'email',
                'tanggal_lahir',
                'role',
                'tempat_lahir',
                'biografi',
                'no_phone',
                'aliran',
                'gambar',
                'alamat',
                'provinsi',
                'kota',
                'desa',
            )
            ->first();
        $image = asset('assets/images/user/' . $user->gambar);
        $data = [
            $user,
            $image,
        ];
        return apiResponse(
            200,
            'success',
            'Data User',
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
        // dd($id);
        try {
            $rules = [
                // 'tanggal_lahir'     => 'required',
                'tempat_lahir'      => 'required',
                'biografi'          => 'required',
                'status'            => 'required',
                'no_phone'          => 'required',
                'aliran'            => 'required',
                'gambar'            => 'required|image|mimes:jpeg,png,jpg',
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

            $user = UserDetail::where('id', $id)->update([
                'tanggal_lahir'     => now(),
                'tempat_lahir'      => $request->tempat_lahir,
                'biografi'          => $request->biografi,
                'status'            => $request->status,
                'no_phone'          => $request->no_phone,
                'aliran'            => $request->aliran,
            ]);

            if (!$request->hasFile('gambar')) {
                return apiResponse(500, 'Erorr', 'Data Bukan Image');
            };
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $uniq = Str::orderedUuid();
            $name = $uniq . '.' . $extension;
            $path = base_path('public/assets/images/user/');
            $request->file('gambar')->move($path, $name);
            UserDetail::where('user_id', $id)->update([
                'gambar' => $name,
            ]);


            return apiResponse(200, 'success', 'Data berhasil Dirubah', UserDetail::where('id', 2)->first());
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
        //
    }
}
