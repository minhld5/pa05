<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class pa05yearController extends Controller
{
    
	//Thêm sửa xóa pa05_year - pa05 các tỉnh

    //List
    public function list($pa05_region_id){
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
                //Ai cũng được view miễn là thành viên
                $pa05region = DB::table('pa05_region')
                ->leftjoin('sys_region','pa05_region.sys_region_id','sys_region.id')
                ->where('pa05_region.id',$pa05_region_id)
                ->select('pa05_region.id as id', 'sys_region.name as name')
                ->first();

                $pa05years = DB::table('pa05_year')
                ->where('pa05_region_id',$pa05_region_id)
                ->get();

                return view('user.pa05.year.list',compact('sessionuser','systemconfig','pa05role','contract_role','pa05region','pa05years'));
            }
        }
    }

    //Khóa year, không cho sửa sau khi đã nộp thầu
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

            if ($pa05role=='pm'){
                //pm mới được lock

                DB::table('pa05_year')
                ->where('id', $id)
                ->update(
                    [
                        'enable' => 0
                    ]
                );

                //Lấy region để quay về
                $regionid = DB::table('pa05_year')
                ->where('id',$id)
                ->first()
                ->pa05_region_id;

                $url = url('/'). '/user/pa05/year/list/' . $regionid;
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Mở khóa
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

            if ($pa05role=='pm'){
                //pm mới được lock

                DB::table('pa05_year')
                ->where('id', $id)
                ->update(
                    [
                        'enable' => 1
                    ]
                );

                //Lấy region để quay về
                $regionid = DB::table('pa05_year')
                ->where('id',$id)
                ->first()
                ->pa05_region_id;

                $url = url('/'). '/user/pa05/year/list/' . $regionid;
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Hiển thị form thêm mới
    public function create($pa05_region_id){
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

            if ($pa05role=='pm' || $pa05role=='edit'){
                return view('user.pa05.year.create',compact('sessionuser','systemconfig','pa05role','contract_role','pa05_region_id'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Submit thêm năm vào PA05
    public function create_submit($pa05_region_id){
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

            if ($pa05role=='pm' || $pa05role=='edit'){

                $id=DB::table('pa05_year')
                ->insertgetid(
                    [
                        'pa05_region_id' => $pa05_region_id,
                        'year' => Request('year'),
                        'enable' => 1
                    ]
                );

                $url = url('/'). '/user/pa05/year/list/' . $pa05_region_id;
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Hiển thị form edit năm của PA05 tỉnh
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
                $year = DB::table('pa05_year')
                ->where('id', $id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    if ($pa05role=='pm' || $pa05role=='edit'){
                        return view('user.pa05.year.edit',compact('sessionuser','systemconfig','pa05role','contract_role','year'));
                    }else{
                        //Không có menuedit edit vì role là view, vì thế đây là chủ định nhập đường dẫn
                        //Bắt buộc quit ra đăng nhập lại
                        Session()->flush();
                        return redirect('/');
                    }
                }else{
                    //Không có menuedit do bị disable, vì thế đây là chủ định nhập đường dẫn
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }

    //Submit edit year
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
                Session()->flush();
                return redirect('/');
            }else{

                $id = Request('id');

                $year = DB::table('pa05_year')
                ->where('id', $id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    if ($pa05role=='pm' || $pa05role=='edit'){
                        //Update
                        DB::table('pa05_year')
                        ->where('id', $id)
                        ->update(
                            [
                                'year' => Request('year')
                            ]
                        );

                        $url = url('/'). '/user/pa05/year/list/' . $year->pa05_region_id;
                        return redirect($url);
                        
                    }else{
                        //Không có menuedit edit vì role là view, vì thế đây là chủ định nhập đường dẫn
                        //Bắt buộc quit ra đăng nhập lại
                        Session()->flush();
                        return redirect('/');
                    }
                }else{
                    //Không có menuedit do bị disable, vì thế đây là chủ định nhập đường dẫn
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }

    //Xóa year
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
                Session()->flush();
                return redirect('/');
            }else{

                $id = Request('id');

                $year = DB::table('pa05_year')
                ->where('id', $id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền xóa
                    if ($pa05role=='pm' || $pa05role=='edit'){
                        //Update
                        DB::table('pa05_year')
                        ->where('id', $id)
                        ->delete();

                        DB::table('pa05_year_detail')
                        ->where('pa05_year_id',$id)
                        ->delete();

                        $url = url('/'). '/user/pa05/year/list/' . $year->pa05_region_id;
                        return redirect($url);
                        
                    }else{
                        //Không có menuedit delete vì role là view, vì thế đây là chủ định nhập đường dẫn
                        //Bắt buộc quit ra đăng nhập lại
                        Session()->flush();
                        return redirect('/');
                    }
                }else{
                    //Không có menu delete do bị disable, vì thế đây là chủ định nhập đường dẫn
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }
}
