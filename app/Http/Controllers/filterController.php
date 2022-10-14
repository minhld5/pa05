<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class filterController extends Controller
{
    //Thêm, sửa, xóa bộ lọc sản phẩm

    //Liệt kê danh sách các bộ lọc
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

            if ($pa05role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){

                	$groupes = DB::table('general_group')
		            ->orderby('order')
		            ->get();

		            
		            if (is_null(session('user_general_filter_group')) || is_null(session('user_general_filter_sub_group'))){
		                $selected_group = null;
		                $selected_sub_group = null;
		                $sub_groupes=null;
		                $filters=null;
		            }else{
		                $selected_group = session('user_general_filter_group');
		                $selected_sub_group = session('user_general_filter_sub_group');

		                $sub_groupes = DB::table('general_sub_group')
		                ->where([
		                    ['general_group_id', '=', $selected_group]
		                ])
		                ->get();

		                $filters = DB::table('general_filter')
		                ->where([
		                    ['general_sub_group_id', '=', $selected_sub_group]
		                ])
		                ->get();
		            }

		            return view(
		            	'user.general.filter.list',
		            	compact(
		            		'systemconfig',
		            		'sessionuser',
		            		'filters',
		            		'groupes',
		            		'sub_groupes',
		            		'selected_group',
		            		'selected_sub_group',
		            		'pa05role',
                            'contract_role'
		            	)
		            );
                }else{
                	//Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }

        }           
    }

    //Lọc
    public function list_submit(){

        //Lưu session để chuyển về đúng category và subcategory
        session(['user_general_filter_group' => Request('group')]);
        if (Request('group')=='0'){
             session(['user_general_filter_sub_group' => '0']);
        }else{
            session(['user_general_filter_sub_group' => Request('sub_group')]);
        }
        

        $url = url('/'). '/user/general/filter/list';
        return redirect($url);
    }

    //mẫu
    public function sample(){
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

            if ($pa05role==''){
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){
                	//Code here
                	//End of code
                }else{
                	//Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
        }           
    }

    //Hiện form sửa bộ lọc
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

            if ($pa05role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){
                	//Code here
                	$filter = DB::table('general_filter')
		            ->leftjoin('general_sub_group','general_filter.general_sub_group_id','=','general_sub_group.id')
		            ->where([
		                ['general_filter.id', '=', $id]
		            ])
		            ->select(
		                'general_filter.id as id',
		                'general_filter.name as name',
		                'general_filter.display_label as display_label',
		                'general_filter.type as type',
		                'general_sub_group.name as general_sub_group'
		            )
		            ->first();

		            $filter_details = DB::table('general_filter_detail')
		            ->where([
		                ['general_filter_id', '=', $id]
		            ])
		            ->get();
		            return view('user.general.filter.edit',compact('systemconfig','sessionuser','pa05role','contract_role','filter','filter_details'));
                	//End of code
                }else{
                	//Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }

        }           
    }

    //submit edit filter
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

            if ($pa05role==''){
                //Không phải thành viên
                $pa05role='';
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){
                    //Code here
                    DB::table('general_filter')
                    ->where('id', $id)
                    ->update(
                        [
                            'name' => Request('name'),
                            'display_label' => Request('display_label'),
                            'type' => Request('type')

                        ]
                    );
                    
                    $url = url('/'). '/user/general/filter/list';
                    return redirect($url);
                    //End of code
                }else{
                    //Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
        }           
    }

    //Hiển thị form tạo mới filter
    public function create($general_sub_group_id){
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

            if ($pa05role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){
                    //Code here
                    $sub_group = DB::table('general_sub_group')
                    ->where([
                        ['id', '=', $general_sub_group_id]
                    ])
                    ->first();
                    return view('user.general.filter.create',compact('systemconfig','sessionuser','pa05role','contract_role','sub_group'));
                    //End of code
                }else{
                    //Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
        }           
    }

    //Submit tạo form 2 và chuyển sang edit để thêm diều kiện
    public function create_submit($general_sub_group_id){
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

            if ($pa05role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){
                    //Code here
                    $retID = DB::table('general_filter')
                    ->insertgetid(
                        [
                            'general_sub_group_id' => $general_sub_group_id,
                            'name' => Request('name'),
                            'display_label' => Request('display_label'),
                            'type' => Request('type')
                        ]
                    );
                    
                    $url = url('/'). '/user/general/filter/edit/' . $retID;
                    return redirect($url);
                    //End of code
                }else{
                    //Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
        }           
    }

    //Xóa bộ lọc
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

            if ($pa05role==''){
                //Không phải thành viên
                $pa05role='';
                Session()->flush();
                return redirect('/');
            }else{
                $pa05role = $tmpdb->role;

                if ($pa05role=='pm' || $pa05role=='edit'){
                    //Code here
                    DB::table('general_filter')
                    ->where('id',$id)
                    ->delete();
                    
                    $url = url('/'). '/user/general/filter/list';
                    return redirect($url);
                    //End of code
                }else{
                    //Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
        }           
    }

}
