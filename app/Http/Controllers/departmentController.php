<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class departmentController extends Controller
{
    //
    //Liệt kê, thêm, sửa, xóa phòng ban
    //Dùng cho admin

    //Liệt kê danh sách phòng ban
    public function list($sys_unit_id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            
            ////////////////
            $role=new common();
            $systemconfig = $role->getSysConfig();
            $sessionuser = $role->getCurrentSessionUser();
            //////////////

            //Lấy danh sách phòng ban
            $departments = DB::table('sys_department')
            ->where([
                ['sys_unit_id', '=', $sys_unit_id]
            ])
            ->get();

            //Lấy thông tin công ty để hiển thị trong form nhập phòng ban
            $unit = DB::table('sys_unit')
            ->where([
                ['id', '=', $sys_unit_id]
            ])
            ->first();

            return view('admin.department.list',compact('systemconfig','sessionuser','departments','unit'));
        }           
    }

    //Hiển thị form tạo mới phòng ban
    public function create($sys_unit_id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            ////////////////
            $role=new common();
            $systemconfig = $role->getSysConfig();
            $sessionuser = $role->getCurrentSessionUser();
            //////////////

            //Lấy thông tin công ty để hiển thị trong form nhập phòng ban
            $unit = DB::table('sys_unit')
            ->where('id' , $sys_unit_id)
            ->first();

            return view('admin.department.create',compact('systemconfig','sessionuser','unit'));
        }           
    }

    //Submit tạo mới phòng ban
    public function create_submit($sys_unit_id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            DB::table('sys_department')         
            ->insert([
                'name' => Request('name'),
                'description' => Request('description'),
                'sys_unit_id' => $sys_unit_id
            ]);

            $url = url('/'). '/admin/department/list/'. $sys_unit_id;
            return redirect($url);
        }           
    }

    //Hiển thị form sửa thông tin phòng ban
    public function edit($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            ////////////////
            $role=new common();
            $systemconfig = $role->getSysConfig();
            $sessionuser = $role->getCurrentSessionUser();
            //////////////

            $department = DB::table('sys_department')
            ->where('id',$id)
            ->first();

            return view('admin.department.edit',compact('systemconfig','sessionuser','department'));
        }           
    }

    //Submit sửa thông tin phòng ban
    public function edit_submit($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            DB::table('sys_department')
            ->where('id',$id)      
            ->update([
                'name' => Request('name'),
                'description' => Request('description')
            ]);

            $unitid = DB::table('sys_department')
            ->where('id',$id)
            ->first()
            ->sys_unit_id;

            $url = url('/'). '/admin/department/list/'. $unitid;
            return redirect($url);
        }           
    }

    //Xóa phòng ban
    public function delete($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            $unitid = DB::table('sys_department')
            ->where('id',$id)
            ->first()
            ->sys_unit_id;

            DB::table('sys_department')
            ->where('id',$id)      
            ->delete();

            $url = url('/'). '/admin/department/list/'. $unitid;
            return redirect($url);
        }           
    }
}
