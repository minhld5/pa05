<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class contractlistController extends Controller
{
    //Thêm sửa xóa hợp đồng

    //Liệt kê danh sách hợp đồng
    //Role: pm, edit, view
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

            if ($contract_role=='pm'||$contract_role=='edit'||$contract_role=='view'){
                //Lấy danh sách năm chứa hợp đồng để filter
                $years = DB::table('contract_list')
                ->distinct()
                ->get(['year']);

                //Lấy year đã pick
                $selected_year = session('user_contract_year');

                //Lấy danh sách hợp đồng
                $contract_lists = DB::table('contract_list')
                ->leftjoin('sys_account','contract_list.pm_id','sys_account.userid')
                ->leftjoin('sys_region','contract_list.sys_region_id','sys_region.id')
                ->where('year',$selected_year)
                ->select(
                    'contract_list.id as id',
                    'contract_list.overall_status as overall_status',
                    'contract_list.due_date as due_date',
                    'contract_list.delivery_schedule as delivery_schedule',
                    'contract_list.handover_list as handover_list',
                    'contract_list.implementation as implementation',
                    'contract_list.training as training',
                    'contract_list.employee as employee',
                    'contract_list.total_value as total_value',
                    'contract_list.year as year',
                    'contract_list.no as no',
                    'contract_list.pm_id as pm_id',
                    'contract_list.note as note',
                    'contract_list.is_lock as is_lock',
                    'contract_list.pa05_year_id as pa05_year_id',
                    'sys_account.fullname as pm_fullname',
                    'sys_region.name as region'
                )
                ->get();
                
                //Trả về view
                return view(
                    'user.contract.list.list',
                    compact(
                        'sessionuser',
                        'systemconfig',
                        'pa05role',
                        'contract_role',
                        'contract_lists',
                        'years',
                        'selected_year'
                    )
                );
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Filter
    public function list_submit(){
        session(['user_contract_year' => Request('year')]);        
        $url = url('/'). '/user/contract/list/list';
        return redirect($url);
    }

    //Hiện form tạo mới hợp đồng
    public function create(){


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

                //Lấy danh sách địa phương
                $regions = DB::table('sys_region')
                ->get();

                //Lấy danh sách user để gán PM (Chỉ lấy user là member của contract)
                $pms = DB::table('contract_member')
                ->leftjoin('sys_account','contract_member.member_id','sys_account.userid')
                ->select(
                    'sys_account.userid as userid',
                    'sys_account.fullname as fullname'
                )
                ->get();

                //Trả về view
                return view(
                    'user.contract.list.create',
                    compact(
                        'sessionuser',
                        'systemconfig',
                        'pa05role',
                        'contract_role',
                        'regions',
                        'pms'
                    )
                );
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Submit tạo mới hợp đồng
    public function create_submit(){


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

                $total_value = ( str_replace(",", "", Request('total_value'))==''? 0 : str_replace(",", "", Request('total_value')) );

                DB::table('contract_list')
                ->insert(
                    [
                        'sys_region_id' => Request('region'),
                        'no' => Request('no'),
                        'year' => Request('year'),
                        'pm_id' =>Request('pm'),
                        'total_value' => $total_value,
                        'employee' => Request('employee'),
                        'note' => Request('note'),
                        'due_date' => strtotime(Request('due_date')) + 7*60*60,
                        'overall_status' => Request('overall_status'),
                        'delivery_schedule' => Request('delivery_schedule'),
                        'handover_list' => Request('handover_list'),
                        'implementation' => Request('implementation'),
                        'training' => Request('training'),
                        'is_lock' => 0
                    ]
                );

                $url = url('/'). '/user/contract/list/list';
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Hiện form sửa hợp đồng
    public function edit($id){


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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và pm_id là current user mới hiện form edit, nếu không bắt login lại do chủ định gõ đường dẫn chứ không nhấn từ link

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.id as id',
                	'contract_list.overall_status as overall_status',
                	'contract_list.due_date as due_date',
                	'contract_list.delivery_schedule as delivery_schedule',
                	'contract_list.handover_list as handover_list',
                	'contract_list.implementation as implementation',
                	'contract_list.training as training',
                	'contract_list.employee as employee',
                	'contract_list.total_value as total_value',
                	'contract_list.year as year',
                	'contract_list.no as no',
                	'contract_list.pm_id as pm_id',
                	'contract_list.note as note',
                	'contract_list.is_lock as is_lock',
                	'contract_list.sys_region_id as sys_region_id',
                	
                )
                ->first();


                if ($contract_list->is_lock==0 && $contract_list->pm_id==$sessionuser->userid){

                    //Lấy danh sách địa phương
                    $regions = DB::table('sys_region')
                    ->get();

                    //Lấy danh sách user để gán PM (Chỉ lấy user là member của contract)
                    $pms = DB::table('contract_member')
                    ->leftjoin('sys_account','contract_member.member_id','sys_account.userid')
                    ->select(
                    	'sys_account.userid as userid',
                    	'sys_account.fullname as fullname'
                    )
                    ->get();

                    //Trả về view
                    return view(
                    	'user.contract.list.edit',
                    	compact(
                    		'sessionuser',
                    		'systemconfig',
                    		'pa05role',
                    		'contract_role',
                    		'regions',
                    		'pms',
                    		'contract_list'
                    	)
                    );
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //submit sửa hợp đồng
    public function edit_submit($id){


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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và pm_id là current user mới hiện form edit, nếu không bắt login lại do chủ định gõ đường dẫn chứ không nhấn từ link

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock'
                )
                ->first();

                if ($contract_list->is_lock==0 && $contract_list->pm_id==$sessionuser->userid){

                    $total_value = ( str_replace(",", "", Request('total_value'))==''? 0 : str_replace(",", "", Request('total_value')) );

                	DB::table('contract_list')
                	->where('id',$id)
                	->update(
                		[
                			'sys_region_id' => Request('region'),
                			'no' => Request('no'),
                			'year' => Request('year'),
                			'pm_id' =>Request('pm'),
                			'total_value' => $total_value,
                			'employee' => Request('employee'),
                			'note' => Request('note'),
                			'due_date' => strtotime(Request('due_date')) + 7*60*60,
                			'overall_status' => Request('overall_status'),
                			'delivery_schedule' => Request('delivery_schedule'),
                			'handover_list' => Request('handover_list'),
                			'implementation' => Request('implementation'),
                			'training' => Request('training')
                		]
                	);

                    $url = url('/'). '/user/contract/list/list';
        			return redirect($url);
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //Xóa hợp đồng
    public function delete($id){

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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và pm_id là current user mới hiện form edit, nếu không bắt login lại do chủ định gõ đường dẫn chứ không nhấn từ link

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock'
                )
                ->first();

                if ($contract_list->is_lock==0 && $contract_list->pm_id==$sessionuser->userid){

                	DB::table('contract_list')
                	->where('id',$id)
                	->delete();

                    $url = url('/'). '/user/contract/list/list';
        			return redirect($url);
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //Lock
    public function lock($id){

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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và pm_id là current user mới hiện form edit, nếu không bắt login lại do chủ định gõ đường dẫn chứ không nhấn từ link

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock'
                )
                ->first();

                if ($contract_list->pm_id==$sessionuser->userid){

                	DB::table('contract_list')
                	->where('id',$id)
                	->update(
                		[
                			'is_lock' => 1
                		]
                	);

                    $url = url('/'). '/user/contract/list/list';
        			return redirect($url);
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //unLock
    public function unlock($id){

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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và pm_id là current user mới hiện form edit, nếu không bắt login lại do chủ định gõ đường dẫn chứ không nhấn từ link

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock'
                )
                ->first();

                if ($contract_list->pm_id==$sessionuser->userid){

                	DB::table('contract_list')
                	->where('id',$id)
                	->update(
                		[
                			'is_lock' => 0
                		]
                	);

                    $url = url('/'). '/user/contract/list/list';
        			return redirect($url);
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //Hiển thị chi tiết hợp đồng
    public function detail($id,$tab){

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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.id as id',
                	'contract_list.overall_status as overall_status',
                	'contract_list.due_date as due_date',
                	'contract_list.delivery_schedule as delivery_schedule',
                	'contract_list.handover_list as handover_list',
                	'contract_list.implementation as implementation',
                	'contract_list.training as training',
                	'contract_list.employee as employee',
                	'contract_list.total_value as total_value',
                	'contract_list.year as year',
                	'contract_list.no as no',
                	'contract_list.pm_id as pm_id',
                	'contract_list.note as note',
                	'contract_list.is_lock as is_lock',
                	'contract_list.pa05_year_id as pa05_year_id',
                	'contract_list.sys_region_id as sys_region_id'
                )
                ->first();

               	//Lấy danh sách địa phương
                $regions = DB::table('sys_region')
                ->get();

                //Lấy danh sách user để gán PM (Chỉ lấy user là member của contract)
                $pms = DB::table('contract_member')
                ->leftjoin('sys_account','contract_member.member_id','sys_account.userid')
                ->select(
                	'sys_account.userid as userid',
                	'sys_account.fullname as fullname'
                )
                ->get();

                //Lấy giá trị hiển thị chi tiết sản phẩm ở tab hàng hóa
                $display = session('user_contract_display');

                //Lấy hàng hóa đã chọn cho hợp đồng
                $contract_goodses = DB::table('contract_goods')
                ->where('contract_list_id',$id)
                ->get();

                //Trả về view
                return view(
                	'user.contract.list.detail',
                	compact(
                		'sessionuser',
                		'systemconfig',
                		'pa05role',
                		'contract_role',
                		'regions',
                		'pms',
                		'contract_list',
                		'contract_goodses',
                		'tab',
                		'display'
                	)
                );
            }
        }
    }

    //submit detail
    public function detail_submit($id){


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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{


            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và session user là pm hoặc edit mới cho submit

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock'
                )
                ->first();

                if ( ($contract_list->is_lock==0) && in_array($contract_role,array("pm", "edit")) ){
                	//Xem nhấn OK ở tab nào

                	if (isset($_POST['btnOverviewOK'])){
                		//Tab Overview
                		$total_value = ( str_replace(",", "", Request('total_value'))==''? 0 : str_replace(",", "", Request('total_value')) );

	                	DB::table('contract_list')
	                	->where('id',$id)
	                	->update(
	                		[
	                			'sys_region_id' => Request('region'),
	                			'no' => Request('no'),
	                			'year' => Request('year'),
	                			'pm_id' =>Request('pm'),
	                			'total_value' => $total_value,
	                			'employee' => Request('employee'),
	                			'note' => Request('note'),
	                			'due_date' => strtotime(Request('due_date')) + 7*60*60
	                		]
	                	);

	                	$url = url('/'). '/user/contract/list/detail/' . $id . '/overview';
        				return redirect($url);
                	}elseif (isset($_POST['btnProgressOK'])){
                		//Tab Progress
	                	DB::table('contract_list')
	                	->where('id',$id)
	                	->update(
	                		[
	                			'overall_status' => Request('overall_status'),
	                			'delivery_schedule' => Request('delivery_schedule'),
	                			'handover_list' => Request('implementation'),
	                			'implementation' =>Request('pm'),
	                			'training' => Request('training')
	                		]
	                	);

	                	$url = url('/'). '/user/contract/list/detail/' . $id . '/progress';
        				return redirect($url);
                	}else{
                		session(['user_contract_display' => Request('display')]); 

                		$url = url('/'). '/user/contract/list/detail/' . $id . '/goods';
        				return redirect($url);
                	}
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //Reset id danh mục pa05 link sang hợp đồng
    public function reset_year($id){


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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{


            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và session user là pm hoặc edit mới cho submit

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.id as id',
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock',
                	'contract_list.sys_region_id as sys_region_id'
                )
                ->first();

                //Chỉ pm của hợp đồng mới được quyền reset
                if ( ($contract_list->is_lock==0) && ($contract_list->pm_id==$sessionuser->userid) ){

                	//Lấy danh mục PA05 cùng tỉnh
                	$pa05_years = DB::table('pa05_year')
                	->leftjoin('pa05_region', 'pa05_year.pa05_region_id','pa05_region.id')
                	->leftjoin('sys_region','pa05_region.sys_region_id','sys_region.id')
                	->where('pa05_region.sys_region_id',$contract_list->sys_region_id)
                	->select(
                		'pa05_year.id as id',
                		'pa05_year.year as year'
                	)
                	->get();

                	return view(
	                	'user.contract.list.reset_year',
	                	compact(
	                		'sessionuser',
	                		'systemconfig',
	                		'pa05role',
	                		'contract_role',
	                		'contract_list',
	                		'pa05_years'
	                	)
	                );
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //submit reset year
    public function reset_year_submit($id){

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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	//Lấy hợp đồng ra để so sánh

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$id)
                ->select(
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock',
                	'contract_list.id as id'
                )
                ->first();

                if ($contract_list->is_lock==0 && $contract_list->pm_id==$sessionuser->userid){

                	DB::table('contract_list')
                	->where('id',$id)
                	->update(
                		[
                			'pa05_year_id' => Request('pa05_year')
                		]
                	);

                	//Lấy danh sách item của pa05 year
                	$year_details = DB::table('pa05_year_detail')
                	->where ('pa05_year_id',Request('pa05_year'))
                	->get();

                	//Xóa contract goods theo contract id
                	DB::table('contract_goods')
                	->where('contract_list_id',$contract_list->id)
                	->delete();

                	if (!is_null($year_details)){
                		foreach($year_details as $year_detail){
                			DB::table('contract_goods')
                			->insert(
                				[
                					'contract_list_id' => $contract_list->id,
                					'name' => $year_detail->name,
                					'no' => $year_detail->no,
                					'order_no' => $year_detail->order_no,
                					'spec' => $year_detail->spec,
                					'quantity' => $year_detail->quantity,
                					'type' => $year_detail->type,
                					'status' => '',
                					'note' => ''
                				]
                			);
                		}
                	}

                    $url = url('/'). '/user/contract/list/detail/' . $id . '/goods';
        			return redirect($url);
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //Hiện form note
    public function note($id){


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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và pm_id là current user mới hiện form edit, nếu không bắt login lại do chủ định gõ đường dẫn chứ không nhấn từ link

            	$contract_goods = DB::table('contract_goods')
            	->where('id',$id)
            	->first();

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$contract_goods->contract_list_id)
                ->select(
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock',
                	'contract_list.id as id'
                )
                ->first();

                if ($contract_list->is_lock==0 && ($contract_role=='pm'||$contract_role=='edit')){

                    //Trả về view
                    return view(
                    	'user.contract.list.note',
                    	compact(
                    		'sessionuser',
                    		'systemconfig',
                    		'pa05role',
                    		'contract_role',
                    		'contract_list',
                    		'contract_goods'
                    	)
                    );
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

    //Submit note
    public function note_submit($id){


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

            if ($contract_role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

            	//Lấy hợp đồng ra để so sánh
            	//Trạng thái is_lock = 0 và pm_id là current user mới hiện form edit, nếu không bắt login lại do chủ định gõ đường dẫn chứ không nhấn từ link

            	$contract_goods = DB::table('contract_goods')
            	->where('id',$id)
            	->first();

            	$contract_list = DB::table('contract_list')
                ->where('contract_list.id',$contract_goods->contract_list_id)
                ->select(
                	'contract_list.pm_id as pm_id',
                	'contract_list.is_lock as is_lock',
                	'contract_list.id as id'
                )
                ->first();

                if ($contract_list->is_lock==0 && ($contract_role=='pm'||$contract_role=='edit')){

                    if (is_null(Request('expiration_date'))){
                        $expiration_date = null;
                    }else{
                        $expiration_date = strtotime(Request('expiration_date')) + 7*60*60;
                    }

                	DB::table('contract_goods')
                	->where('id',$id)
                	->update(
                		[
                			'status' => Request('status'),
                			'note' => Request('note'),
                            'expiration_date' => $expiration_date
                		]
                	);

                    $url = url('/'). '/user/contract/list/detail/' . $contract_list->id . '/goods';
        			return redirect($url);
                }else{
                    Session()->flush();
                    return redirect('/');
                }

            }
        }
    }

}
