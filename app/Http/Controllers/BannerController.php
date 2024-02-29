<?php

namespace App\Http\Controllers;

use App\User;
use App\Banner;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{
    public function index(){
    	$user = User::all();
    	$banners = Banner::all();
    	return view('banners.banners')->with('usuarios', $user)
    								->with('banners', $banners);
    }

    protected function store(Request $request){

    	$imageName1='';
        $this->validate($request, ['imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        if ($request->hasFile('imagen')) {
            $imageName1 = time().'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(base_path().'/public/images/catalog/', $imageName1);
        }

        $ban = new Banner();
        $ban->date = $request['date'];
        $ban->attr_1 = null;
        $ban->attr_2 = null;
        $ban->attr_3 = null;
        $ban->imagen = $imageName1;
        $ban->idusers = $request['user'] ;
        $ban->save();

        Flash::success("Se ha registrado correctamente el banner.");
        return Redirect::back();
    }

    protected function update(Request $request){
    	$imageName1='';
        $this->validate($request, ['imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        if ($request->hasFile('imagen')) {
            $imageName1 = time().'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(base_path().'/public/images/catalog/', $imageName1);
        }else{
        	$imageName1 = $request['imagen_old'];
        }

        $ban = Banner::findOrFail($request['idbanner']);
        $ban->date = $request['date'];
        $ban->attr_1 = null;
        $ban->attr_2 = null;
        $ban->attr_3 = null;
        $ban->imagen = $imageName1;
        $ban->idusers = $request['user'] ;
        $ban->save();

        Flash::success("Se ha modificado correctamente el banner.");
        return Redirect::back();
    }

    protected function destroy($id){
    	$obj = Banner::find($id)->delete();
    	return Redirect::back();
    }
}
