<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class unitController extends Controller
{
    //Liệt kê, thêm, sửa, xóa công ty thành viên
    //Dùng cho admin

	//Liệt kê danh sách unit trên giao diện quản trị của admin
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

            $units = DB::table('sys_unit')
            ->get();

            $systemconfig = DB::table('sys_config')
            ->first();

            return view('admin.unit.list',compact('systemconfig','sessionuser','units'));
        }           
    }

    //Hiển thị form tạo mới unit
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

            return view('admin.unit.create',compact('systemconfig','sessionuser'));
        }           
    }

    //Submit tạo unit
    public function create_submit(){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            DB::table('sys_unit')         
            ->insert([
                'name' => Request('name'),
                'description' => Request('description'),
                'address' => Request('address')
            ]);

            $url = url('/'). '/admin/unit/list';
            return redirect($url);
        }           
    }

    //Hiển thị form sửa unit
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

            $unit = DB::table('sys_unit')
            ->where([
                ['id', '=', $id]
            ])
            ->first();

            return view('admin.unit.edit',compact('systemconfig','sessionuser','unit'));
        }           
    }

    //Submit edit unit
    public function edit_submit($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            DB::table('sys_unit')
            ->where('id', $id)
            ->update(
                [
                    'name' => Request('name'),
                    'description' => Request('description'),
                    'address' => Request('address')

                ]
            );

            $url = url('/'). '/admin/unit/list';
            return redirect($url);
        }           
    }

    //Xóa unit
    public function delete($id){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            //Xóa phòng ban thuộc đơn vị
            DB::table('sys_department')
            ->where('sys_unit_id', $id)
            ->delete();

            //Xóa đơn vị
            DB::table('sys_unit')
            ->where('id', $id)
            ->delete();

            $url = url('/'). '/admin/unit/list';
            return redirect($url);
        }           
    }
}
