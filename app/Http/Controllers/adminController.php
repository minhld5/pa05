<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Lib\git;


class adminController extends Controller
{
    //
    //Vào trang chủ
    public function index(){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            $url = url('/'). '/admin/account/list';
            return redirect($url);
        }           
    }

    //logout
    public function logout(){
        Session()->flush();
        return redirect('/');
    }

    //Hiển thị trang đổi mật khẩu
    public function change_password(){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            $sessionuser = DB::table('sys_account')
            ->where([
                ['userid', '=', session('User')]
            ])->first();

            $err_msg = '';
            
            return view('admin.change_password',compact('sessionuser','err_msg'));
        }        
    }

    //Submit đổi mật khẩu
    public function change_password_submit(){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{
            $sessionuser = DB::table('sys_account')
            ->where([
                ['userid', '=', session('User')]
            ])->first();

            $err_msg = '';
            $currentpassword = DB::table('sys_account')
            ->where([
                ['userid', '=', session('User')]
            ])->first()
            ->password;

            if (md5(Request('oldpassword'))!=$currentpassword){
                $err_msg = 'Mật khẩu hiện tại không đúng';;
                return view('admin.change_password',compact('sessionuser','err_msg'));
            }else{
                if (Request('newpassword')!=Request('confirmpassword')){
                    $err_msg = 'Mật khẩu mới không khớp';
                    return view('admin.change_password',compact('sessionuser','err_msg',));
                }else{
                    DB::table('sys_account')
                    ->where([
                        ['userid', '=', session('User')]
                    ])
                    ->update([
                        'password' => md5(Request('newpassword'))
                    ]);
                    $url = url('/'). '/admin/home';
                    return redirect($url);
                }

            }                        
        }        
    }

    //Hiển thị form cấu hình hệ thống
    public function system_config(){
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

            return view('admin.system_config',compact('systemconfig','sessionuser','systemconfig'));
        }           
    }

    //Submit chỉnh sửa cấu hình hệ thống
    public function system_config_submit(){
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
            ->update(
                [
                    'system_name' => Request('system_name'),
                    'physical_storage_location' => Request('physical_storage_location'),
                    'default_password' => Request('default_password'),
                    'ldap_host' => Request('ldap_host'),
                    'ldap_port' => Request('ldap_port'),
                    'ldap_dn' => Request('ldap_dn')
                ]
            );

            $url = url('/'). '/admin/home';
            return redirect($url);
        }           
    }

    //Pull code từ github
    public function git_pull(){
        if (session('Role')!=md5('admin')){
            Session()->flush();
            return redirect('/');
        }else{

            $git=new git();
            $git->runPull();

            $url = url('/'). '/admin/home';
            return redirect($url);
        }           
    }

    //Test git pull
    private function git_test(){

        dd('Đây vừa push lại xong');
    }

}
