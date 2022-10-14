<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

use App\Lib\common;

class userController extends Controller
{
    //Vào trang chủ
    public function index(){
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

            $err_msg = '';

            return view('user.dashboard',compact('sessionuser','err_msg','pa05role','contract_role'));
        }           
    }

    //logout
    public function logout(){
        Session()->flush();
        return redirect('/');
    }

    //Hiển thị trang đổi mật khẩu
    public function change_password(){
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

            $err_msg = '';
            
            return view('user.change_password',compact('sessionuser','err_msg','pa05role','contract_role'));
        }        
    }

    //Submit đổi mật khẩu
    public function change_password_submit(){
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

            $err_msg = '';
            $currentpassword = DB::table('sys_account')
            ->where([
                ['userid', '=', session('User')]
            ])->first()
            ->password;


            if (md5(Request('oldpassword'))!=$currentpassword){
                $err_msg = 'Mật khẩu hiện tại không đúng';;
                return view('user.change_password',compact('sessionuser','err_msg','pa05role','contract_role'));
            }else{
                if (Request('newpassword')!=Request('confirmpassword')){
                    $err_msg = 'Mật khẩu mới không khớp';
                    return view('user.change_password',compact('sessionuser','err_msg','pa05role','contract_role'));
                }else{
                    DB::table('sys_account')
                    ->where([
                        ['userid', '=', session('User')]
                    ])
                    ->update([
                        'password' => md5(Request('newpassword'))
                    ]);
                    $url = url('/'). '/user/home';
                    return redirect($url);
                }

            }                        
        }        
    }
    
}
