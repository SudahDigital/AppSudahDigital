<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class catalogController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $param = \Route::current()->parameter('vendor');
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            if($client->client_slug == $param){
                if(session()->get('client_sess')== null){
                    \Request::session()->put('client_sess',
                    ['client_name' => $client->client_name,'client_image' => $client->client_image]);
                }
                if(Gate::allows('manage-catalog')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index($vendor){

        $catalog = \App\Catalog::where('client_id',\Auth::user()->client_id)
                    ->orderBy('position', 'ASC')
                    ->get();

        return view('catalog.index', ['catalog'=>$catalog, 'vendor'=>$vendor]);
    }

    public function create($vendor){
        return view('catalog.create',['vendor'=>$vendor]);
    }

    public function store(Request $request, $vendor){
        \Validator::make($request->all(), [
            "name" => "required",
            "type" => "required",
            "catalog_url" => "required"
        ])->validate();

        $cek_position = \App\Catalog::where('client_id','=',$request->get('client_id'))
                        ->orderBy('position', 'ASC')
                        ->get();
        //dd($max_position);
        if($cek_position){
            foreach($cek_position as $ck_p){
                $valuesPosition = \App\Catalog::findOrFail($ck_p->id);
                $valuesPosition->position = $ck_p->position+1;
                $valuesPosition->save();               
            }
        }

        $newCatalog = new \App\Catalog();
        $newCatalog->client_id = $request->get('client_id');
        $newCatalog->name = $request->get('name');
        $newCatalog->type = $request->get('type');
        $newCatalog->url = $request->get('catalog_url');
        $newCatalog->position = 1;
        
        $newCatalog->save();

        return redirect()->route('catalog.create', [$vendor])->with('status','Catalog link succesfully created');
    }

    public function edit($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $catalog_edit = \App\Catalog::findOrFail($id);
        return view('catalog.edit',['ctl_edit'=>$catalog_edit,'vendor'=>$vendor]);
    }

    public function update(Request $request, $vendor, $id)
    {   
        \Validator::make($request->all(), [
            "name" => "required",
            "type" => "required",
            "catalog_url" => "required"
        ])->validate();

        $catalog = \App\Catalog::findOrFail($id);

        $catalog->name = $request->get('name');
        $catalog->type = $request->get('type');
        $catalog->url = $request->get('catalog_url');
        $catalog->save();

        return redirect()->route('catalog.edit', [$vendor,\Crypt::encrypt($id)])
        ->with('status','Catalog link succesfully update');
    }

    public function destroy($vendor, $id){

        $catalog = \App\Catalog::findOrFail($id);
        $catalog->forceDelete();

        return redirect()->route('catalog.index',[$vendor])
            ->with('status', 'Catalog permanently deleted');

            
    }
}
