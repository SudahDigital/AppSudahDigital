<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class Spvcontroller extends Controller
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
                if(Gate::allows('manage-spv')) return $next($request);
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
        $users = \App\User::where('roles','=','SUPERVISOR')
        ->where('client_id','=',auth()->user()->client_id)
        ->get();//paginate(10);
        $filterkeyword = $request->get('keyword');
        $status = $request->get('status');
        if($filterkeyword){
            if($status){
                $users = \App\User::where('email','LIKE',"%$filterkeyword%")
                ->where('client_id','=',auth()->user()->client_id)
                ->where('status', 'LIKE', "%$status%")->get();
                //->paginate(10);
            }
            else{
                $users = \App\User::where('email','LIKE',"%$filterkeyword%")
                ->where('client_id','=',auth()->user()->client_id)
                ->get();//paginate(10);
            }
        }
        if($status){
            $users = \App\User::where('status', 'Like', "%$status")
            ->where('client_id','=',auth()->user()->client_id)
            ->get();//paginate(10);
        }
        return view ('users.index',['users'=>$users,'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {   
        /*$users = \App\User::where('roles','=','SALES')
                ->where('client_id','=',auth()->user()->client_id)
                ->where('status','ACTIVE')
                ->get();//paginate(10);*/
        $client_slsid = \Auth::user()->client_id;
        $users = \DB::select("SELECT * FROM users u WHERE u.status='ACTIVE' AND u.client_id = $client_slsid AND u.roles='SALES' AND NOT EXISTS
                                        (
                                            SELECT * FROM  spv_sales s
                                            WHERE /*s.status = 'ACTIVE' AND*/
                                            s.sls_id = u.id
                                        )
                                    ");
        return view('users.create',['users'=>$users,'vendor'=>$vendor]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vendor)
    {
        \Validator::make($request->all(), [
            "avatar" => "required|mimes:jpg,jpeg,png"
        ])->validate();

        $new_user = new \App\User;
        $new_user->client_id = $request->get('client_id');
        $new_user->name = $request->get('name');
        $new_user->email = $request->get('email');
        $new_user->password = \Hash::make($request->get('password'));
        //$new_user->username = $request->get('username');
        $new_user->roles = $request->get('roles');
        $new_user->address = $request->get('address');
        $new_user->phone = $request->get('phone');
        if($request->file('avatar')){
            $file = $request->file('avatar')->store('avatars','public');
        $new_user->avatar =$file;
        }
        $new_user->save();
        if($new_user->save()){
            $sls_member = $request->input('sls_id', []);
            for ($sls=0; $sls < count($sls_member); $sls++) {
                if ($sls_member[$sls] != '') {
                    $new_member = new \App\Spv_sales;
                    $new_member->spv_id = $new_user->id;
                    $new_member->sls_id = $sls_member[$sls];
                    $new_member->save();
                }
            }

            /*if($request->get('emailSenior1') != ''){
                $new_senior1 = new \App\SpvSuperiorOfc();
                $new_senior1->spv_id = $new_user->id;
                $new_senior1->email = $request->get('emailSenior1');
                $new_senior1->save();
            }

            if($request->get('emailSenior2') != ''){
                $new_senior2 = new \App\SpvSuperiorOfc();
                $new_senior2->spv_id = $new_user->id;
                $new_senior2->email = $request->get('emailSenior2');
                $new_senior2->save();
            }*/
        }
        
        if ( $new_user->save()){
            return redirect()->route('spv.create',[$vendor])->with('status','Supervisor Succsessfully Created');
        }else{
            return redirect()->route('spv.create',[$vendor])->with('error','Supervisor Not Succsessfully Created');
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
    public function edit($vendor, $id)
    {
        $id = \Crypt::decrypt($id);
        $user = \App\User::findOrFail($id);
        $client_slsid = \Auth::user()->client_id;
        $sales_list = \DB::select("SELECT * FROM users u WHERE u.status='ACTIVE' AND u.client_id = $client_slsid AND u.roles='SALES' AND NOT EXISTS
                                        (
                                            SELECT * FROM  spv_sales s
                                            WHERE   s.sls_id = u.id 
                                            /*AND s.status = 'ACTIVE'*/
                                            /*AND s.spv_id = '$id'*/
                                        )
                                    ");
        return view('users.edit',['user'=>$user,'sales_list'=>$sales_list, 'vendor'=>$vendor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor, $id)
    {
        if($request->get('save_action') == 'ADD'){
            $sls_id = $request->input('sls_id', []);
            for ($sales=0; $sales < count($sls_id); $sales++) {
                if ($sls_id[$sales] != '') {
                    $new_spvsls = new \App\Spv_sales;
                    $new_spvsls->spv_id =  $id;
                    $new_spvsls->sls_id = $sls_id[$sales];
                    $new_spvsls->save();
                }
            }
            
            return redirect()->route('spv.edit', [$vendor,\Crypt::encrypt($id)])->with('status',
            'Sales team member successfully add');
        }
        else if($request->get('save_action') == 'DELETE_ITEM')
        {
            $del_id = $request->input('del_id');
            $spvsls = \App\Spv_sales::findOrFail($del_id);
            $spvsls->delete();

            return redirect()->route('spv.edit', [$vendor,\Crypt::encrypt($id)])->with('status',
            'Sales team member successfully delete');
        }
        else{
            if($request->hasFile('avatar')){
                \Validator::make($request->all(), [
                    "avatar" => "required|mimes:jpg,jpeg,png"
                ])->validate();
            }
            $user =\App\User::findOrFail($id);
            $user->name = $request->get('name');
            $user->status = $request->get('status');
            $user->phone = $request->get('phone');
            $user->address = $request->get('address');
            if($request->file('avatar')){
                if($user->avatar && file_exists(storage_path('app/public/'.$user->avatar)))
                {
                    \Storage::delete('public/'.$user->avatar);
                }
                $file = $request->file('avatar')->store('avatars','public');
                $user->avatar =$file;
            }
            $user->save();
            if($user->save()){
                $spv= \App\Spv_sales::where('spv_id',$id)->update(['status'=>$request->get('status')]);
            }
            return redirect()->route('spv.edit', [$vendor,\Crypt::encrypt($id)])->with('status_user',
            'Supervisor successfully update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $vendor, $id)
    {   
        //$del_id = $request->input('del_id');
        $spv_target = \App\Sales_Targets::where('created_by',$id)->orWhere('updated_by',$id)->count();
        if($spv_target > 0){
            return back()->with('error','Cannot delete, Spv has sales target records');
        }
        else{
            $spv = \DB::table('spv_sales')->where('spv_id',$id)->count();
            if($spv > 0){
                $delete_spvsls = \DB::table('spv_sales')->where('spv_id',$id)->delete();
                if($delete_spvsls){
                    $user = \App\User::findOrFail($id);
                    $user->delete();
                }
            }
            
            return redirect()->route('spv.index',[$vendor])->with('status','Supervisor Successfully Delete');
        }
        
    }
}
