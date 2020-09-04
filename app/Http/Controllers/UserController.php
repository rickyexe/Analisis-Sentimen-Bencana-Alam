<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show semua data user
        $user = DB::table('users')
            ->get();

        return view('user', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            //create sudah termasuk dalam register controller
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->first();

        return view('edit_user', compact('user'));
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
        $this->validate($request, [
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($id),
            ],
            'name' => 'required',
        ]);


        //tambahkan field yang ingin di update dengan request
        $updateUser = DB::table('users')
            ->where('id', $id)
            ->update([
                'email' => $request->get('email'),
                'name'  => $request->get('name')
            ]);


        return redirect('user');
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


        return redirect()->back();
    }
}
