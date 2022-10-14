<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class contractexpirationController extends Controller
{
    //

    //Nhắc hết hạn hợp đồng

    public function list(){
        if (session('Role')!=md5('user')){
            Session()->flush();
            return redirect('/');
        }else{

            ////////////////
            $role=new common();
            $pa05role = $role->getRole('pa05');
            $contract_role = $role->getRole('contract');
            $systemconfig = $role->getSysConfig();
            $sessionuser = $role->getCurrentSessionUser();
            //////////////

            if ($contract_role=='pm'){
            	//Chưa chọn thời gian
            	$duration = 0;

                //Lấy danh sách sản phẩm sắp hết hạn, null do chưa chọn thời gian
                $contract_goodses = null;

                //Trả về view
                return view(
                    'user.contract.expiration.list',
                    compact(
                        'sessionuser',
                        'systemconfig',
                        'pa05role',
                        'contract_role',
                        'contract_goodses',
                        'duration'
                    )
                );
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    public function list_submit(){
        if (session('Role')!=md5('user')){
            Session()->flush();
            return redirect('/');
        }else{

            ////////////////
            $role=new common();
            $pa05role = $role->getRole('pa05');
            $contract_role = $role->getRole('contract');
            $systemconfig = $role->getSysConfig();
            $sessionuser = $role->getCurrentSessionUser();
            //////////////

            if ($contract_role=='pm'){
            	//Chưa chọn thời gian
            	$duration = Request('duration');

                //Lấy danh sách sản phẩm sắp hết hạn, null do chưa chọn thời gian
                $contract_goodses = DB::table('contract_goods')
                ->leftjoin('contract_list', 'contract_goods.contract_list_id','contract_list.id')
                ->leftjoin('sys_region','contract_list.sys_region_id','sys_region.id')
                ->where('expiration_date','<=',strtotime(now()) + $duration*24*60*60 )
                ->select(
                	'contract_goods.name as name',
                	'contract_goods.expiration_date as expiration_date',
                	'contract_goods.note as note',
                	'contract_list.year as year',
                	'sys_region.name as region'
                )
                ->get();

                //Trả về view
                return view(
                    'user.contract.expiration.list',
                    compact(
                        'sessionuser',
                        'systemconfig',
                        'pa05role',
                        'contract_role',
                        'contract_goodses',
                        'duration'
                    )
                );
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }
}
