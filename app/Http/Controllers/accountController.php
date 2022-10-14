<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class accountController extends Controller
{
    //Liệt kê, thêm, sửa, xóa user
    //Dùng cho admin

	//Liệt kê danh sách user trên giao diện quản trị của admin
    public function list(){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            $sessionuser = DB::table('sys_account')
            ->where([
                ['userid', '=', session('User')]
            ])
            ->first();

            $accounts = DB::table('sys_account')
            ->leftjoin('sys_role', 'sys_account.sys_role_id', '=', 'sys_role.id')
            ->leftjoin('sys_department', 'sys_account.sys_department_id', '=', 'sys_department.id')
            ->leftjoin('sys_unit','sys_department.sys_unit_id','sys_unit.id')
            ->select(
                'sys_account.userid as userid',
                'sys_account.username as username',
                'sys_account.fullname as fullname',
                'sys_account.email as email',
                'sys_account.is_ldap as isldap',
                'sys_account.is_enable as isenable',
                'sys_department.description as departmentdescription',
                'sys_unit.description as unitdescription',
                'sys_role.description as roledescription'
            )
            ->get();

            $systemconfig = DB::table('sys_config')
            ->first();

            return view('admin.account.list',compact('systemconfig','sessionuser','accounts'));
        }           
    }

    //Hiển thị form tạo mới account
    public function create(){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            $sessionuser = DB::table('sys_account')
            ->where([
                ['userid', '=', session('User')]
            ])
            ->first();

            $systemconfig = DB::table('sys_config')
            ->first();

            $selectedunit = Request('unit');

            $units = DB::table('sys_unit')
            ->get();

            $departments = null;

            $roles = DB::table('sys_role')
            ->get();


            return view(
                'admin.account.create',
                compact(
                    'systemconfig',
                    'sessionuser',
                    'roles', 
                    'units', 
                    'departments',
                    'selectedunit'
                )
            );
        }           
    }

    //Next step hoặc submit chung một hàm, nếu nhấn OK là submit tạo mới còn không là chọn unit
    public function create_submit(){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            if (isset($_POST['btnOK'])){
                DB::table('sys_account')         
                ->insert([
                    'username' => Request('username'),
                    'password' => md5(Request('password')),
                    'fullname' => Request('fullname'),
                    'sys_department_id' => Request('department'),
                    'email' => Request('email'),
                    'sys_role_id' => Request('role'),
                    'is_ldap' => Request('isldap'),
                    'is_enable' => 1
                ]);

                $url = url('/'). '/admin/account/list';
                return redirect($url);
            }else{
                //Chưa submit
                $sessionuser = DB::table('sys_account')
                ->where([
                    ['userid', '=', session('User')]
                ])
                ->first();

                $systemconfig = DB::table('sys_config')
                ->first();

                $selectedunit = Request('unit');

                $units = DB::table('sys_unit')
                ->get();

                $departments = DB::table('sys_department')
                ->where('sys_unit_id', Request('unit'))
                ->get();

                $roles = DB::table('sys_role')
                ->get();


                return view(
                    'admin.account.create',
                    compact(
                        'systemconfig',
                        'sessionuser',
                        'roles', 
                        'units', 
                        'departments',
                        'selectedunit'
                    )
                );
            }
            
        }           
    }

    //Hiện form sửa account
    public function edit($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            $sessionuser = DB::table('sys_account')
            ->where([
                ['userid', '=', session('User')]
            ])
            ->first();

            $systemconfig = DB::table('sys_config')
            ->first();

            $selectedunit = Request('unit');

            $units = DB::table('sys_unit')
            ->get();

            $user = DB::table('sys_account')
            ->leftjoin('sys_role', 'sys_account.sys_role_id', '=', 'sys_role.id')
            ->leftjoin('sys_department', 'sys_account.sys_department_id', '=', 'sys_department.id')
            ->leftjoin('sys_unit','sys_department.sys_unit_id','sys_unit.id')
            ->where('sys_account.userid', $id)
            ->select(
                'sys_account.userid as userid',
                'sys_account.username as username',
                'sys_account.fullname as fullname',
                'sys_account.email as email',
                'sys_account.is_ldap as isldap',
                'sys_account.is_enable as isenable',
                'sys_account.sys_role_id as roleid',
                'sys_unit.id as unitid',
                'sys_department.id as departmentid'
            )
            ->first();

            $departments = DB::table('sys_department')
            ->where('sys_unit_id', $user->unitid)
            ->get();

            $roles = DB::table('sys_role')
            ->get();


            return view(
                'admin.account.edit',
                compact(
                    'systemconfig',
                    'sessionuser',
                    'roles', 
                    'units', 
                    'departments',
                    'selectedunit',
                    'user'
                )
            );
        }           
    }

    //Submit edit user
    public function edit_submit($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            if (isset($_POST['btnOK'])){
                DB::table('sys_account')    
                ->where('userid',$id)     
                ->update([
                    'username' => Request('username'),
                    'fullname' => Request('fullname'),
                    'sys_department_id' => Request('department'),
                    'email' => Request('email'),
                    'sys_role_id' => Request('role'),
                    'is_ldap' => Request('isldap')
                ]);

                $url = url('/'). '/admin/account/list';
                return redirect($url);
            }else{
                //Chưa submit
                $sessionuser = DB::table('sys_account')
                ->where([
                    ['userid', '=', session('User')]
                ])
                ->first();

                $systemconfig = DB::table('sys_config')
                ->first();

                $selectedunit = Request('unit');

                $units = DB::table('sys_unit')
                ->get();

                $user = DB::table('sys_account')
                ->leftjoin('sys_role', 'sys_account.sys_role_id', '=', 'sys_role.id')
                ->leftjoin('sys_department', 'sys_account.sys_department_id', '=', 'sys_department.id')
                ->leftjoin('sys_unit','sys_department.sys_unit_id','sys_unit.id')
                ->where('sys_account.userid', $id)
                ->select(
                    'sys_account.userid as userid',
                    'sys_account.username as username',
                    'sys_account.fullname as fullname',
                    'sys_account.email as email',
                    'sys_account.is_ldap as isldap',
                    'sys_account.is_enable as isenable',
                    'sys_account.sys_role_id as roleid',
                    'sys_unit.id as unitid',
                    'sys_department.id as departmentid'
                )
                ->first();

                $departments = DB::table('sys_department')
                ->where('sys_unit_id', Request('unit'))
                ->get();

                $roles = DB::table('sys_role')
                ->get();

                return view(
                    'admin.account.edit',
                    compact(
                        'systemconfig',
                        'sessionuser',
                        'roles', 
                        'units', 
                        'departments',
                        'selectedunit',
                        'user'
                    )
                );
            }
            
        }           
    }

    //Enable user
    public function enable($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            DB::table('sys_account')
            ->where('userid', $id)
            ->update(
                [
                    'is_enable' => 1

                ]
            );

            $url = url('/'). '/admin/account/list';
            return redirect($url);
        }           
    }

    //Disable user
    public function disable($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            DB::table('sys_account')
            ->where('userid', $id)
            ->update(
                [
                    'is_enable' => 0

                ]
            );

            $url = url('/'). '/admin/account/list';
            return redirect($url);
        }           
    }

    //Reset password
    public function reset_password($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            $systemconfig = DB::table('sys_config')
            ->first();

            DB::table('sys_account')
            ->where('userid', $id)
            ->update(
                [
                    'password' => md5($systemconfig->default_password)

                ]
            );

            $url = url('/'). '/admin/account/list';
            return redirect($url);
        }           
    }

    //Xóa account
    public function delete($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            $systemconfig = DB::table('sys_config')
            ->first();

            DB::table('sys_account')
            ->where('userid', $id)
            ->delete();

            $url = url('/'). '/admin/account/list';
            return redirect($url);
        }           
    }
}
