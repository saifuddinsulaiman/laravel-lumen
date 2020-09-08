<?php

namespace App\Http\Controllers;
use App\ModelUniqueCode;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class UniqueCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ModelUniqueCode::all();
        return response($data);
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

        $uniquenumber = json_decode($request->input('uniquenumber'));

        foreach($uniquenumber as $uniquenumber)
        {   
            $uniquenumber_records[] = [
                    'uniquenumber' => $uniquenumber 
                ];
        }

        

        ModelUniqueCode::insert($uniquenumber_records);


        return response($uniquenumber );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UniqueCode  $uniqueCode
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ModelUniqueCode::where('id',$id)->get();
        return response ($data);
    }

    public function count()
    {
         
        return response (ModelUniqueCode::count());
    }

}
