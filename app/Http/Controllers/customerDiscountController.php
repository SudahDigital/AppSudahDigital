<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustDiscProd;
use App\Exports\customerDiscountItem;


class customerDiscountController extends Controller
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
                if(Gate::allows('customer-discount')) return $next($request);;
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor){
        $cDiscounts = \App\CustomerDiscount::where('client_id','=',auth()->user()->client_id)
                    ->get();
            
        return view('customer_discount.index', ['cDiscounts'=>$cDiscounts,'vendor'=>$vendor]);
    }

    public function create($vendor, $success = null)
    {
        
        $custType = \App\TypeCustomer::where('client_id',\Auth::user()->client_id)
                    ->where('status','ACTIVE')
                    //->where('name','LIKE',"%$keyword%")
                    ->doesntHave('customerDiscount')->get();
                    
        if($success){
            return view('customer_discount.create',['custType'=>$custType,'vendor'=>$vendor])
                    ->with('status', 'Customer discount successfully created.');
        }else{
            return view('customer_discount.create',['custType'=>$custType,'vendor'=>$vendor]);
        }
        
    }

    public function store(Request $request, $vendor){
        $new_customer_discount = new \App\CustomerDiscount();
        $new_customer_discount->client_id = \Auth::user()->client_id;
        $new_customer_discount->name = $request->get('name');
        $new_customer_discount->type = $request->get('type');
        
        $new_customer_discount->status = 'INACTIVE';
        $new_customer_discount->save();
        
        //return view('customer_discount.createImport',['vendor'=>$vendor,'idDisc'=>$new_customer_discount->id]);
        return redirect()->route('cDiscount.createImport',[$vendor,\Crypt::encrypt($new_customer_discount->id)]);
    }

    public function createImport($vendor, $id)
    {
        //$idDisc = \Crypt::decrypt($id);
        return view('customer_discount.createImport',['vendor'=>$vendor,'id'=>$id]);
    }

    public function storeImport(Request $request, $vendor){
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();

        $id = $request->get('idDisc');
        
        $data = Excel::import(new CustDiscProd($id), request()->file('file'));
        
        if($data){
            
                $cDiscount = \App\CustomerDiscount::findOrFail($id);
                $cDiscount->status = 'ACTIVE';
                $cDiscount->save();
            }
        
        return back()->with('success', 'Customer discount successfully created.');
    }

    public function detail($vendor, $id){
        $get_id = \Crypt::decrypt($id);
        $cDiscounts = \App\CustomerDiscount::findOrfail($get_id);

        $custType = \App\TypeCustomer::where('client_id',\Auth::user()->client_id)
                    ->where('status','ACTIVE')
                    //->where('name','LIKE',"%$keyword%")
                    ->doesntHave('customerDiscount')->get();
        
        $details_cDiscounts = \App\CustomerDiscProd::where('cust_disc_id',$get_id)
                            ->get();

        return view('customer_discount.edit',
                    [
                        'cDiscounts'=>$cDiscounts,
                         'custType'=>$custType,
                         'vendor'=>$vendor,
                         '$details_vDiscounts'=>$details_cDiscounts,
                    ]);
    }

    public function update(Request $request, $vendor, $id){
        $customer_discount = \App\CustomerDiscount::findOrFail($id);
        $customer_discount->client_id = \Auth::user()->client_id;
        $customer_discount->name = $request->get('name');
        $customer_discount->type = $request->get('type');
        
        $customer_discount->save();

        return redirect()
                ->back()
                ->with('status', 'Discount successfully update');
    }

    public function updateItem(Request $request, $vendor){
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();

        $id = $request->get('idDisc');
        
        $data = Excel::import(new CustDiscProd($id), request()->file('file'));
        
        if($data){
            
                $cDiscount = \App\CustomerDiscount::findOrFail($id);
                $cDiscount->status = 'ACTIVE';
                $cDiscount->save();
            }
        
        return back()->with('status', 'File successfully upload.');
    }

    public function deleteItem($vendor,$itemId,$cust_disc_id){
        $item = \App\CustomerDiscProd::findOrFail($itemId);
        $item->forceDelete();
        
        $cekItem = \App\CustomerDiscProd::where('cust_disc_id',$cust_disc_id)
                ->first();
        if(!$cekItem){
            $cDiscount = \App\CustomerDiscount::findOrFail($cust_disc_id);
            $cDiscount->status = 'INACTIVE';
            $cDiscount->save();
        }
       
        return redirect()->back()->with('status', 'Item successfully deleted!');
    }

    public function itemExport($vendor, $id){
        $cDiscount = \App\CustomerDiscount::findOrFail($id);

        return Excel::download(new customerDiscountItem($id), 
              'Customer Price List '.$cDiscount->name.'.xlsx');
    }

    public function editStatus($vendor, $id, $status){
        $customer_discount = \App\CustomerDiscount::findOrFail($id);
        $customer_discount->status = $status;
        $customer_discount->save();
        return redirect()->back()->with('status', 'Status changed successfully!');
    }
}
