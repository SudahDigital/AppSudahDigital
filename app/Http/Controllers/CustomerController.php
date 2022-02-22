<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;
use App\Exports\CitiesExport;
use App\Exports\CustomerExport;
use App\Exports\CustomerExportType;
use Illuminate\Http\Request;
use App\Imports\TargetCustomerImport;
use App\Exports\CustomerParetoInfo;

class CustomerController extends Controller
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
                if(Gate::allows('manage-customers')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $vendor)
    {
        if(Gate::check('isSpv')){
            $client_id = \Auth::user()->client_id;
            $spv_id = \Auth::user()->id;
            $customers = \DB::select("SELECT c.*, type_customer.name as tp_name, ct.city_name, 
                        u.id as user_id, u.name as user_name, cat_pareto.pareto_code, cd.name as cd_name
                        FROM customers c 
                        left outer join type_customer ON type_customer.id = c.cust_type 
                        left outer join cat_pareto ON cat_pareto.id = c.pareto_id
                        left join customer_discounts ON customers.pricelist_id = cd.id,
                        cities ct, users u, customer_discounts cd WHERE c.status != 'NEW' AND c.client_id = $client_id 
                        AND c.user_id = u.id AND c.city_id = ct.id AND EXISTS
                            (
                                SELECT * FROM  spv_sales
                                WHERE   spv_sales.sls_id = c.user_id
                                AND spv_sales.spv_id ='$spv_id'
                            )
                        ");
            
            //dd($customers);
            $status = $request->get('status');
            
            if($status){
                if($status == 'reg_point'){
                    $customers = \DB::select("SELECT c.*, type_customer.name as tp_name, ct.city_name, 
                    u.id as user_id, u.name as user_name, cat_pareto.pareto_code, cd.name as cd_name 
                    FROM customers c 
                    left join type_customer ON type_customer.id = c.cust_type 
                    left outer join cat_pareto ON cat_pareto.id = c.pareto_id
                    left join customer_discounts ON customers.pricelist_id = cd.id,
                    cities ct, users u, customer_discounts cd WHERE c.status != 'NEW' AND c.client_id = $client_id 
                    AND c.user_id = u.id AND c.city_id = ct.id AND c.reg_point = 'Y' AND EXISTS
                        (
                            SELECT * FROM  spv_sales
                            WHERE   spv_sales.sls_id = c.user_id
                            AND spv_sales.spv_id ='$spv_id'
                        )
                    ");
                }else{
                    $customers = \DB::select("SELECT c.*, type_customer.name as tp_name, ct.city_name, 
                    u.id as user_id, u.name as user_name, cat_pareto.pareto_code, cd.name as cd_name
                    FROM customers c 
                    left join type_customer ON type_customer.id = c.cust_type 
                    left outer join cat_pareto ON cat_pareto.id = c.pareto_id
                    left join customer_discounts ON customers.pricelist_id = cd.id,
                    cities ct, users u, customer_discounts cd WHERE c.status != 'NEW' AND c.client_id = $client_id 
                    AND c.user_id = u.id AND c.city_id = ct.id AND c.status LIKE '%$status%' AND EXISTS
                        (
                            SELECT * FROM  spv_sales
                            WHERE   spv_sales.sls_id = c.user_id
                            AND spv_sales.spv_id ='$spv_id'
                        )
                    ");
                }
                $customers = \DB::select("SELECT c.*, type_customer.name as tp_name, ct.city_name, 
                u.id as user_id, u.name as user_name, cat_pareto.pareto_code, cd.name as cd_name
                FROM customers c 
                left join type_customer ON type_customer.id = c.cust_type 
                left outer join cat_pareto ON cat_pareto.id = c.pareto_id
                left join customer_discounts ON customers.pricelist_id = cd.id,
                cities ct, users u, customer_discounts cd WHERE c.status != 'NEW' AND c.client_id = $client_id 
                AND c.user_id = u.id AND c.city_id = ct.id AND c.status LIKE '%$status%' AND EXISTS
                    (
                        SELECT * FROM  spv_sales
                        WHERE   spv_sales.sls_id = c.user_id
                        AND spv_sales.spv_id ='$spv_id'
                    )
                ");
            }
            //dd($customers);
        }
        else{
            $customers = \App\Customer::with('users')->with('cities')->with('type_cust')
            ->where('client_id','=',auth()->user()->client_id)
            ->where('status','!=','NEW')->orderBy('id','DESC')->get();//paginate(10);
            //$filterkeyword = $request->get('keyword');
            $status = $request->get('status');
            
            if($status) {
                if($status == 'reg_point'){
                    $customers = \App\Customer::with('users')->with('cities')->with('type_cust')
                    ->where('client_id','=',auth()->user()->client_id)
                    ->where('reg_point', 'Y')->orderBy('id','DESC')->get();//paginate(10);
                }else{
                    $customers = \App\Customer::with('users')->with('cities')->with('type_cust')
                    ->where('client_id','=',auth()->user()->client_id)
                    ->where('status', 'Like', "%$status")->orderBy('id','DESC')->get();//paginate(10);
                }
            }
        }
        
        return view ('customer_store.index',['customers'=>$customers,'vendor'=>$vendor]);
    }

    public function index_type(Request $request, $vendor)
    {
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $customers_type = \App\TypeCustomer::where('client_id','=',auth()->user()->client_id)
            ->get();//paginate(10);
            //$filterkeyword = $request->get('keyword');
            //$status = $request->get('status');
            return view ('customer_store.type_index',['customers_type'=>$customers_type,'vendor'=>$vendor]);
        }else{
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
    }

    public function index_pareto(Request $request, $vendor)
    {
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $pareto = \App\CatPareto::where('client_id','=',auth()->user()->client_id)
                    ->orderBy('position', 'ASC')
                    ->get();//paginate(10);
            //$filterkeyword = $request->get('keyword');
            //$status = $request->get('status');
            return view ('customer_store.pareto_index',['pareto'=>$pareto,'vendor'=>$vendor]);
        }else{
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $custPrice = \App\CustomerDiscount::where('client_id','=',auth()->user()->client_id)->get();
            $type = \App\TypeCustomer::where('client_id','=',auth()->user()->client_id)->get();
            $pareto = \App\CatPareto::where('client_id','=',auth()->user()->client_id)
                    ->orderBy('position', 'ASC')
                    ->get();
            return view('customer_store.create',
                            ['vendor'=>$vendor,
                            'type'=>$type,
                            'pareto'=>$pareto,
                            'custPrice'=>$custPrice]
                        );
        }
        else{
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }       
    }

    public function create_type($vendor)
    {
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            return view('customer_store.create_type',['vendor'=>$vendor]);
        }
        else{
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }       
    }

    public function create_pareto($vendor)
    {
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            return view('customer_store.create_pareto',['vendor'=>$vendor]);
        }
        else{
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vendor)
    {
        \Validator::make($request->all(),[
            "city" => "required",
            "user" => "required"
        ])->validate();
        $new_cust = new \App\Customer;
        $new_cust->store_code = $request->get('store_code');
        $new_cust->name = $request->get('name');
        $new_cust->email = $request->get('email');
        $new_cust->phone = $request->get('phone');
        $new_cust->phone_owner = $request->get('phone_owner');
        $new_cust->phone_store = $request->get('phone_store');
        $new_cust->store_name = $request->get('store_name');
        $new_cust->city_id = $request->get('city');
        $new_cust->address = $request->get('address');
        $pay_trm = $request->get('payment_term');

        $new_cust->pareto_id = $request->get('pareto_id');

        if($pay_trm == 'TOP'){
            $new_cust->payment_term = $request->get('pay_cust').' Days';
        }else{
            $new_cust->payment_term = $request->get('payment_term');
        }
        $new_cust->user_id = $request->get('user');
        $new_cust->client_id = $request->get('client_id');

        if($request->get('latlng') != ''){
            $latln_explode = explode(',',$request->get('latlng'));
            $lat = $latln_explode[0];
            $lng = $latln_explode[1];

            $new_cust->lat = $lat;
            $new_cust->lng = $lng;
        }
        
        
        $new_cust->cust_type = $request->get('cust_type');
        if($request->get('cust_price_type') != ''){
            $new_cust->pricelist_id = $request->get('cust_price_type');
        }
        //$new_cust->reg_point = $request->get('reg_point');
        $new_cust->save();
        if ( $new_cust->save()){
            return redirect()->route('customers.create',[$vendor])->with('status','Customer Succsessfully Created');
        }else{
            return redirect()->route('customers.create',[$vendor])->with('error','Customer Not Succsessfully Created');
        }
    }

    public function store_type(Request $request, $vendor)
    {
        
        $new_cust = new \App\TypeCustomer();
        $new_cust->name = strtoupper($request->get('name'));
        $new_cust->client_id = $request->get('client_id');
        
        $new_cust->save();
        if ( $new_cust->save()){
            return redirect()->route('type_customers.create',[$vendor])->with('status','Name for Type Customer Succsessfully Created');
        }else{
            return redirect()->route('type_ustomers.create',[$vendor])->with('error','Name for Type Customer Not Succsessfully Created');
        }
    }

    public function store_pareto(Request $request, $vendor)
    {
        
        $max_position = \App\CatPareto::where('client_id','=',$request->get('client_id'))
                      ->max('position');

        $new_cut = new \App\CatPareto();
        $new_cut->pareto_code = strtoupper($request->get('pareto_code'));
        $new_cut->client_id = $request->get('client_id');
        if($max_position == null){
            $new_cut->position = 1;
        }
        else{
            $new_cut->position = $max_position + 1;
        }
        $new_cut->save();
        if ( $new_cut->save()){
            return redirect()->route('pareto_customers.create',[$vendor])->with('status','Pareto Code Succsessfully Created');
        }else{
            return redirect()->route('pareto_customers.create',[$vendor])->with('error','Pareto Code Not Succsessfully Created');
        }
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
    public function edit($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $custPrice = \App\CustomerDiscount::where('client_id','=',auth()->user()->client_id)->get();
        $cust = \App\Customer::findOrFail($id);
        if(($cust->payment_term != null) && ($cust->payment_term != 'Cash')){
            $cust_term = 'TOP';
        }else
        if(($cust->payment_term != null) && ($cust->payment_term == 'Cash')){
            $cust_term = 'Cash';
        }else{
            $cust_term ='';
        }

        $pareto = \App\CatPareto::where('client_id','=',auth()->user()->client_id)
                    ->orderBy('position', 'ASC')
                    ->get();
        $type = \App\TypeCustomer::where('client_id','=',auth()->user()->client_id)->get();
        if(Gate::check('isSpv')){
           
            return view('customer_store.edit',['cust' => $cust,'vendor'=>$vendor,'type'=>$type]);
        }else{
            return view('customer_store.edit',
                        ['cust' => $cust,
                        'vendor'=>$vendor,
                        'cust_term'=>$cust_term,
                        'pareto'=>$pareto,
                        'type'=>$type,
                        'custPrice'=>$custPrice]
                    );
        }
        
    }

    public function edit_type($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $cust = \App\TypeCustomer::findOrFail($id);
        return view('customer_store.edit_type',['cust' => $cust,'vendor'=>$vendor]);
    }

    public function edit_pareto($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $pareto = \App\CatPareto::findOrFail($id);
        return view('customer_store.edit_pareto',['pareto' => $pareto,'vendor'=>$vendor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor,$id)
    {
        $cust =\App\Customer::findOrFail($id);
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            \Validator::make($request->all(),[
                "city" => "required",
                "user" => "required"
            ])->validate();
            $cust->store_code = $request->get('store_code');
            $cust->name = $request->get('name');
            $cust->email = $request->get('email');
            $cust->phone = $request->get('phone');
            $cust->phone_owner = $request->get('phone_owner');
            $cust->phone_store = $request->get('phone_store');
            $cust->store_name = $request->get('store_name');
            $cust->city_id = $request->get('city');
            $cust->address = $request->get('address');
            $pay_trm = $request->get('payment_term');
            $pareto_code = $request->get('pareto_id');
            if($pareto_code == 0){
                $cust->pareto_id = NULL;
            }else{
                $cust->pareto_id = $pareto_code;
            }
            
            $cust->status = $request->get('status');
            //$cust->reg_point = $request->get('reg_point');
            
            //$cust->target_store = $request->get('target_store');
            if($pay_trm == 'TOP'){
                $cust->payment_term = $request->get('pay_cust').' Days';
            }else{
                $cust->payment_term = $request->get('payment_term');
            }
            $cust->user_id = $request->get('user');

            if($request->get('latlng') != ''){
                $latln_explode = explode(',',$request->get('latlng'));
                $lat = $latln_explode[0];
                $lng = $latln_explode[1];

                $cust->lat = $lat;
                $cust->lng = $lng;
            }else{
                $cust->lat = NULL;
                $cust->lng = NULL;
            }
            
            $cust->cust_type = $request->get('cust_type');
            if($request->get('cust_price_type') != ''){
                $cust->pricelist_id = $request->get('cust_price_type');
            }
        }
        else{
            $cust->cust_type = $request->get('cust_type');
        }   
        $cust->save();
        return redirect()->route('customers.edit',[$vendor,\Crypt::encrypt($id)])->with('status','Customer Succsessfully Update');
    }

    public function update_type(Request $request, $vendor,$id)
    {
        $cust =\App\TypeCustomer::findOrFail($id);
        $cust->name = $request->get('name');
        
        $cust->save();
        return redirect()->route('type_customers.edit',[$vendor,\Crypt::encrypt($id)])->with('status','Name for Type Customer Succsessfully Update');
    }

    public function update_pareto(Request $request, $vendor,$id)
    {
        $cut =\App\CatPareto::findOrFail($id);
        $cut->pareto_code = $request->get('pareto_code');
        
        $cut->save();
        return redirect()->route('pareto_customers.edit',[$vendor,\Crypt::encrypt($id)])->with('status','Pareto Code Succsessfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $customer = \App\Customer::findOrFail($id);
        return view('customer_store.detail', ['customer' => $customer,'vendor'=>$vendor]);
    }

    public function deletePermanent($vendor,$id){

        $cust = \App\Customer::findOrFail($id);
        //dd($id);
        $order_cust = \App\Order::where('customer_id','=',"$id")->count();
        //dd($order_cust);
        if($order_cust > 0){
            return redirect()->route('customers.index',[$vendor])->with('error', 'Cannot be deleted, because this data already exists in orders');
        }
        else {
        $cust->forceDelete();
        return redirect()->route('customers.index',[$vendor])->with('status', 'Type permanently deleted!');
        }

    }

    public function deletePermanent_type($vendor,$id){

        $cust = \App\TypeCustomer::findOrFail($id);
        //dd($id);
        $order_cust = \App\Customer::where('cust_type','=',"$id")->count();
        //dd($order_cust);
        if($order_cust > 0){
            return redirect()->route('type_customers.index_type',[$vendor])->with('error', 'Cannot be deleted, because this data already exists in customers');
        }
        else {
        $cust->forceDelete();
        return redirect()->route('type_customers.index_type',[$vendor])->with('status', 'Customer type permanently deleted!');
        }

    }

    public function deletePermanent_pareto($vendor,$id){

        $cat = \App\CatPareto::findOrFail($id);
        //dd($id);
        $order_cat = \App\Customer::where('pareto_id','=',"$id")->count();
        //dd($order_cust);
        if($order_cat > 0){
            return redirect()->route('customers.index_pareto',[$vendor])->with('error', 'Cannot be deleted, because this data already exists in customers');
        }
        else {
        $cat->forceDelete();
        return redirect()->route('customers.index_pareto',[$vendor])->with('status', 'Pareto Code permanently deleted!');
        }

    }

    public function export($vendor) {
        return Excel::download( new CustomerExport(), 'Customers.xlsx') ;
    }

    public function export_type($vendor) {
        return Excel::download( new CustomerExportType(), 'CustomersType.xlsx') ;
    }

    public function exportCity($vendor) {
        return Excel::download( new CitiesExport(), 'City List.xlsx') ;
    }

    public function import($vendor){
        return view('customer_store.import_customers',['vendor'=>$vendor]);
    }

    public function import_data(Request $request, $vendor){
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();
            
        $data = Excel::import(new CustomersImport, request()->file('file'));
        if($data){
            return redirect()->route('customers.import',[$vendor])->with('status', 'File successfully upload');
        }
        
    }

    public function import_target(Request $request, $vendor){
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();

        $period = $request->get('param_period');
        $date_explode = explode('-',$period);
        $year = $date_explode[0];
        $month = $date_explode[1];
        //$type = $request->get('target_type');
        
        $data = Excel::import(new TargetCustomerImport($year,$month), request()->file('file'));
        if($data){

            return redirect()->route('customers.create_target',[$vendor,'period'=>$period])->with('status', 'File successfully upload');
        }
        
    }

    public function updateImport_target(Request $request, $vendor){
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();

        $period = $request->get('param_period');
        $date_explode = explode('-',$period);
        $year = $date_explode[0];
        $month = $date_explode[1];
        //$type = $request->get('target_type');
        $targetPeriod =  \Crypt::encrypt($period.'-01');
        $data = Excel::import(new TargetCustomerImport($year,$month), request()->file('file'));
        if($data){
            return redirect()->route('customers.edit_target',[$vendor,$targetPeriod])->with('status', 'File successfully upload');
        }
        
    }

    public function exportCustomerPareto($vendor) {
        return Excel::download( new CustomerParetoInfo(), 'CustomerPareto.xlsx') ;
    }
}
