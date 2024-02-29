<?php

namespace App\Http\Controllers;

use App\File;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{
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
        $archivo='';
        if ($request->hasFile('file')) {
            $archivo = time().'.'.$request->file('file')->getClientOriginalExtension();
            $request->file('file')->move(base_path().'/files/certificates/', $archivo);
        }else{
            Flash::Error("El archivo excede el máximo de 2Mb");
            return redirect()->back();
        }

        $f = new File();
        $f->date = date('Y-m-j');
        $f->name = $request['certificado'];
        $f->file = $archivo;
        $f->measurements_id = $request['id'];
        $f->save();

        Flash::success("Se ha registrado el archivo.");
        return redirect()->back();
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
        $adj = File::findOrFail($id);
        if(\File::exists(base_path().'/public/files/certificates/' . $adj->file)){
            \File::delete(base_path().'/public/files/certificates/' . $adj->file);
        }

        $adj->delete();
        
        return Redirect::back();
    }
}
