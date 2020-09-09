<?php

namespace App\Http\Controllers;
use App\ModelUniqueCode;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

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
        $totalnumber = $request->input('totalnumber');

        foreach($uniquenumber as $uniquenumber)
        {   
            $uniquenumber_records[] = [
                    'uniquenumber' => $uniquenumber 
                ];
             
        }

        
        // DB::table('mynumber')->insert($uniquenumber_records);
        // try{
        //     $count = DB::table('mynumber')->insertOrIgnore($uniquenumber_records);
        //     // ModelUniqueCode::insert($uniquenumber_records);
        // } catch( QueryException $e){

        // }
        $this->insertIntoDB($uniquenumber_records, $totalnumber);
        
        

        // return response($count );
    }

    public function newUniqueNumber($balnumber)
    {   
        $c = 0;
        $b = 0;
        for ($i=0; $i < $balnumber; $i++) { 
            $c++;
            $b++; 

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomnumber[] = [ 'uniquenumber' => substr(str_shuffle($permitted_chars), 0, 6)];


            if ($c == "50000" ) {
               $this->insertIntoDB($randomnumber, $balnumber);
               $randomnumber=array();
               $c = 0;
            }

        }
        //call to API balance array
        if ($randomnumber) {
           $this->insertIntoDB($randomnumber, $balnumber);
        }
    }


    public function insertIntoDB($uniquenumber_records,$totalnumber)
    {   
        // $count = 0;
        // $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // try{
        //     $uniquenumber_records[] = [
        //             'uniquenumber' => $uniquenumber 
        //         ];
        //     $count = DB::table('mynumber')->insertOrIgnore($uniquenumber_records)->count;
        //     // ModelUniqueCode::insert($uniquenumber_records);
        // } catch( QueryException $e){
        // // }catch (QueryException $e) {
        //     // $errorCode = $e->errorInfo[1];
        //     // if($errorCode == '1062'){
        //     //     // return (print_r($e, true));
        //     //     return ("duplicate");

        //     // }
        //     // if ($this->isDuplicateEntryException($e)) 
        //     // {   
        //     //     $this->insertIntoDB(substr(str_shuffle($permitted_chars), 0, 6));
        //     //     // throw new DuplicateEntryException('Duplicate Entry');
        //     // }
        //     // throw $e;
        //     $count++;
        //     // continue;
        
        // }

        $count = DB::table('mynumber')->insertOrIgnore($uniquenumber_records);

        if ($count != $totalnumber) {
            $balnumber = $totalnumber - $count;
            $this->newUniqueNumber($balnumber );
        }
        return $count; 

    }
    public function isDuplicateEntryException(QueryException $e)
    {
        $sqlState = $e->errorInfo[0];
        $errorCode  = $e->errorInfo[1];
        if ($sqlState === "23000" && $errorCode === 1062) {
            return true;
        }
        return false;
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
