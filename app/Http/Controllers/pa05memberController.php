<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class pa05memberController extends Controller
{
    //Thêm sửa xóa thành viên tham gia PA05

	//Liệt kê danh sách thành viên
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

            if ($pa05role=='pm'){
                $members = DB::table('pa05_member')
                ->leftjoin('sys_account','pa05_member.member_id','sys_account.userid')
                ->leftjoin('sys_department','sys_account.sys_department_id','sys_department.id')
                ->leftjoin('sys_unit','sys_department.sys_unit_id','sys_unit.id')
                ->select(
                    'pa05_member.id as id',
                    'pa05_member.member_id as memberid',
                    'pa05_member.role as role',
                    'sys_account.fullname as fullname',
                    'sys_department.description as department',
                    'sys_unit.description as unit'
                )
                ->get();

                return view('user.pa05.member.list',compact('sessionuser','systemconfig','pa05role','contract_role','members'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Show form thêm thành viên
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

            if ($pa05role=='pm'){

                //Bỏ những user trong bảng member
                $exists = DB::table('pa05_member')
                ->pluck('member_id');
                
                $accounts = DB::table('sys_account')
                ->leftjoin('sys_department','sys_account.sys_department_id','sys_department.id')
                ->leftjoin('sys_unit','sys_department.sys_unit_id','sys_unit.id')
                ->wherenotin('userid',$exists)
                ->select(
                    'sys_account.userid as userid',
                    'sys_account.username as username',
                    'sys_account.fullname as fullname',
                    'sys_department.description as department',
                    'sys_unit.description as unit'
                )
                ->get();
                return view('user.pa05.member.create',compact('sessionuser','systemconfig','pa05role','contract_role','accounts'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Submit thêm user vào member
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

            if ($pa05role=='pm'){
                if (isset($_POST['selecteduser'])){
                    DB::table('pa05_member')
                    ->insert(
                        [
                            'member_id' => $_POST['selecteduser'],
                            'role' => Request('role')
                        ]
                    ); 
                }
                $url = url('/'). '/user/pa05/member/list';
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Sửa role của member
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

            if ($pa05role=='pm'){

                $member = DB::table('pa05_member')
                ->leftjoin('sys_account','sys_account.userid','pa05_member.member_id')
                ->where('pa05_member.id','=',$id)
                ->first();

                return view('user.pa05.member.edit',compact('sessionuser','systemconfig','pa05role','contract_role','member'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //submit edit
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

            if ($pa05role=='pm'){

                DB::table('pa05_member')
                ->where('id',$id)
                ->update(
                    [
                        'role' => Request('role')
                    ]
                );

                $url = url('/'). '/user/pa05/member/list';
                return redirect($url);

            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Remove member
    public function remove($id){
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

            if ($pa05role=='pm'){

                DB::table('pa05_member')
                ->where('id',$id)
                ->delete();

                $url = url('/'). '/user/pa05/member/list';
                return redirect($url);

            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }
}
