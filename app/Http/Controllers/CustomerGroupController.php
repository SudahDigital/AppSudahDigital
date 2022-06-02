<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerGroupController extends Controller
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
                if(Gate::allows('customer-group')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index($vendor){
        $csGroups = \App\CustomerGroup::where('client_id',\Auth::user()->client_id)
                    ->get();
        
        return view('customer_group.index', ['csGroups'=>$csGroups, 'vendor'=>$vendor]);
    }

    public function create($vendor){
        return view('customer_group.create',['vendor'=>$vendor]);
    }

    public function store(Request $request, $vendor)
    {
        \Validator::make($request->all(), [
            "code" => "required",
            "name" => "required"
        ])->validate();

        
        $newGroups = new \App\CustomerGroup();
        $newGroups->client_id = $request->get('client_id');
        $newGroups->code = $request->get('code');
        $newGroups->name = $request->get('name');
        $newGroups->save();

        return redirect()->route('customerGroups.create',[$vendor])->with('status','Customer Groups Code Succsessfully Created');
    }

    public function edit($vendor, $id){
        $id = \Crypt::decrypt($id);
        $groups = \App\CustomerGroup::findOrFail($id);
        return view('customer_group.edit',['groups'=>$groups,'vendor'=>$vendor]);
    }

    public function update(Request $request,$vendor,$id){
        \Validator::make($request->all(), [
            "code" => "required",
            "name" => "required"
        ])->validate();

        $groups = \App\CustomerGroup::findOrFail($id);
        $groups->code = $request->get('code');
        $groups->name = $request->get('name');
        $groups->save();

        return redirect()->route('customerGroups.edit',[$vendor,\Crypt::encrypt($id)])
                ->with('status','Customer Groups Code Succsessfully Update');
    }

    public function destroy($vendor,$id){
        
        $groupCustomers = \App\Customer::where('group_id',$id)->count();
        //dd($order_cust);
        if($groupCustomers > 0){
            return redirect()->route('customerGroups.index',[$vendor])->with('error', 'Cannot be deleted, because this data already exists in customer');
        }
        else {
            $groups = \App\CustomerGroup::findOrFail($id);
            $groups->forceDelete();
            return redirect()->route('customerGroups.index',[$vendor])->with('status', 'Group code permanently deleted!');
        }
    }

}
