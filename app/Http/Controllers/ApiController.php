<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');


        $user = [
            'email' => $email,
            'password' => $password
        ];

        if (Auth::attempt($user)) {

                $response = array(
                    'pesan' => "Berhasil");
                return response()->json(array('user' => $response), 201);
            }
            else{
                $response = [
                    'pesan' => "2",
                ];

                return response()->json(array('user' => $response));
            }
    }








    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $nama = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        //check email apakah sudah ada di database
        $checkEmail = DB::table('users')
            ->where('email', $email)
            ->count();


        if($checkEmail > 0 ){
            $pesan = array(['pesan' => "Email Sudah Ada"]);
            return response()->json(array('pesan' => $pesan), 200);
        }



        User::create([
            'name' => $nama,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $pesan = array(['pesan' => "Berhasil Register"]);
        return response()->json(array('pesan' => $pesan), 200);


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
        //tambahkan field yang ingin di update dengan request
        $updateUser = DB::table('users')
            ->where('id', $id)
            ->update([
                'email' => $request->get('email'),
                'name'  => $request->get('name')
            ]);

        $pesan = array(['pesan' => "Berhasil Register"]);
        return response()->json(array('pesan' => $pesan), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteUser = DB::table('users')
            ->where('id', $id)->delete();

        $pesan = array(['pesan' => "Berhasil Register"]);
        return response()->json(array('pesan' => $pesan), 200);
    }
}
