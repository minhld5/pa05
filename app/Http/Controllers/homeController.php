<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class homeController extends Controller
{
    //
    //vào trang chủ
    public function index(){

        //Kiểm tra xem đã login chưa
        //Nếu chưa thì redirect sang trang đăng nhập
        $systemconfig = DB::table('sys_config')
        ->first();
        switch (session('Role')) {
                case md5('admin'): //Quản trị hệ thống
                    return redirect("/admin/home");
                    break;
                case md5('user'): //Nhân viên
                    return redirect("/user/home");
                    break;
                default:
                    $err_msg = ''; //Chưa có session, về trang login
                    
                    return view('login',compact('err_msg','systemconfig'));
                    break;
        }
    }

    //login
    public function doLogin(){
        $systemconfig = DB::table('sys_config')
        ->first();

    	$username = Request('username');
        $username = str_replace('\'','',$username);
        $username = str_replace('=','',$username);
        $username = str_replace(' or ','',$username);

        $user = DB::table('sys_account')
        ->leftJoin('sys_role', 'sys_account.sys_role_id', '=', 'sys_role.id')
        ->where([
            ['sys_account.is_enable', '=', 1],
            ['sys_account.username', '=', $username]
        ])
        ->select(
            'sys_account.userid as userid',
            'sys_account.username as username',
            'sys_account.is_ldap as isldap',
            'sys_account.is_enable as isenable',
            'sys_account.password as password',
            'sys_account.email as email',
            'sys_role.name as rolename'
        )
        ->first();


        if(Request('username')==''||Request('password')==''){
            $err_msg = 'Lỗi: Chưa nhập username hoặc password';
            return view('login',compact('err_msg','systemconfig'));
            die();
        }

        if (empty($user)){
            $err_msg = 'Lỗi: User không tồn tại';
            return view('login',compact('err_msg','systemconfig'));
        }else{

            //Check xem user là local hay ldap, field isldap = 0 hoặc 1

            if($user->isldap==0){
                //local user
                $password = md5(Request('password'));
                if ($user->password == $password){
                    //session(['AppID' => strlen($user->userid).$user->userid.md5($user->userid)]);
                    session(['User' => $user->userid]);
                    session(['Role' => md5($user->rolename)]);
                    
                    //echo session('AppID');
                    switch ($user->rolename) {
                        case 'admin':
                        return redirect("/admin/home");
                        break;
                    case 'user':
                        return redirect("/user/home");
                        break;
                    default:
                        break;
                    }

                }else{
                    $err_msg = 'Lỗi: Sai password';
                    return view('login',compact('err_msg','systemconfig'));
                }

            }else{
                //ldap user

                $cfg = DB::table('sys_config')->first();
                $ds = ldap_connect($cfg->ldap_host);
                $login = @ldap_bind( $ds, $user->email, Request('password'));

                if ($login){
                    session(['User' => $user->userid]);
                    session(['Role' => md5($user->rolename)]);
                    //echo session('AppID');
                    switch ($user->rolename) {
                        case 'admin':
                        return redirect("/admin/home");
                        break;
                    default:
                        return redirect("/user/home");
                        break;
                    }
                }else{
                    $err_msg = 'Lỗi: Sai thông tin user/password';
                    return view('login',compact('err_msg','systemconfig'));
                }

                
                //////////////////////////////////////////////////////
            }
        }
    	
    }

}
