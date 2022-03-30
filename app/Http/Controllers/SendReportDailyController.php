<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendReportDailyController extends Controller
{
    public function index(){
        
        $spv = \App\User::where('roles','SUPERVISOR')
                ->where('status','ACTIVE')
                ->get();
        foreach($spv as $k => $s){
            $email_spv = $s->email;
            $sales = \App\Spv_sales::where('spv_id',$s->id)->get();
            $emailDetail = '';
            
            foreach($sales as $key => $sls){
                $order = $this->getOrder($sls->sls_id);
                $salesName = $sls->sales->name;
                $emailDetail .= '<b>'.$salesName.'</b>
                                <br>
                                <table border="1"
                                    style="border-collapse: collapse;
                                    border: 1px solid #E3E3E3;
                                    margin-bottom: 20px;">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Toko</th>
                                            <th>Jumlah Order (Dus)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    if($order){
                                        foreach($order as $odr){
                                        $tbody = '<tr>
                                                <td>'.$odr->created_at.'</td>
                                                <td>'.$odr->customers->store_name.'</td>
                                                <td>'.$odr->totalQuantity.'</td>
                                                <td>'.$odr->status.'</td>
                                            </tr>';
                                        }
                                    }else{
                                        $tbody = '<tr>
                                                <td colspan="4">Tidak ada kunjungan</td>
                                            </tr>';
                                    }
                                    $closeTbody = '</tbody>
                                </table>';
                $emailDetail .= $tbody.$closeTbody;
            }
            \Mail::send([], [], function ($message) use ($emailDetail,$email_spv) {
                $message->to($email_spv)
                ->subject('Daily Order')
                ->setBody($emailDetail, 'text/html');
                });
        }
    }

    function getOrder($slsId){
        $date_now = date('Y-m-d');
        $order = \App\Order::where('user_id',$slsId)
                ->whereNotNull('customer_id')
                ->whereDate('created_at',$date_now)
                ->orderBy('created_at','ASC')->get();
        
        return $order;
    }

}
