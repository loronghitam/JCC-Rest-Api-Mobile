<?php

namespace App\Http\Controllers;

use App\Chat;
use Exception;
use App\RoomChat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ChatController extends Controller
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
            'Daftar Pesan',
            Chat::where('receiver_id', auth()->user()->id)->get()
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
        // dd($request->all());
        // dd($room_id);
        try {
            $roomId = Str::uuid();
            $data = Chat::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'room_id' => $roomId,
            ])->roomChat()->create([
                'room_id' => $roomId
            ]);

            return apiResponse(
                200,
                'Success',
                'Kirim Pesan',
                $data
            );
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        try {
            // dd($chat->room_id);
            $data = Chat::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $chat->sender_id,
                'message' => $request->message,
                'room_id' => $chat->room_id,
            ])->roomChat()->create([
                'room_id' => $chat->room_id
            ]);

            return apiResponse(
                200,
                'Success',
                'Balas Pesan Berhasil',
                $data
            );
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        dd('belum di pikin soalnya gampang');
    }
}
