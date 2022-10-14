<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class pa05regionController extends Controller
{
    //Thêm, sửa, xóa region cho PM

    //Hiển thị danh sách PA05 các tỉnh
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

            if($pa05role==''){
                Session()->flush();
                return redirect('/');
            }else{
                $pa05regions = DB::table('pa05_region')
                ->leftjoin('sys_region','pa05_region.sys_region_id','sys_region.id')
                ->select('pa05_region.id as id', 'sys_region.name as name')
                ->get();

                return view('user.pa05.region.list',compact('sessionuser','systemconfig','pa05role','contract_role','pa05regions'));
            }
        }
    }

    //Hiển thị form nhập thêm PA05 tỉnh
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

            if ($pa05role=='pm' || $pa05role=='edit'){
                //Lấy tỉnh đã có
                $exists = DB::table('pa05_region')
                ->pluck('sys_region_id');

                //Lấy tỉnh chưa có
                $regions = DB::table('sys_region')
                ->wherenotin('id',$exists)
                ->get();
                return view('user.pa05.region.create',compact('sessionuser','systemconfig','pa05role','contract_role','regions'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Submit tạo PA05 tỉnh
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

            if ($pa05role=='pm' || $pa05role=='edit'){

                //Insert DB
                $id = DB::table('pa05_region')
                ->insertgetid(
                    [
                        'sys_region_id' => Request('region')
                    ]
                );

                $url = url('/'). '/user/pa05/region/list';
                return redirect($url);

            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Hiện form sửa PA05 tỉnh
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

            if ($pa05role=='pm' || $pa05role=='edit'){

                $pa05region = DB::table('pa05_region')
                ->where('id',$id)
                ->first();

                 $regions = DB::table('sys_region')
                //->where('id','!=',$id)
                ->get();

                return view('user.pa05.region.edit',compact('sessionuser','systemconfig','pa05role','contract_role','pa05region','regions'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Submit sửa PA05 tỉnh
    public function edit_submit(){
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

                //Update DB
                DB::table('pa05_region')
                ->where('id', Request('id'))
                ->update(
                    [
                        'sys_region_id' => Request('region')
                    ]
                );

                $url = url('/'). '/user/pa05/region/list';
                return redirect($url);

            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Xóa region
    public function delete(){
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

                $id=Request('id');
                
                //Lấy danh sách year để xóa chi tiết của year
                $years = DB::table('pa05_year')
                ->where('pa05_region_id',$id)
                ->pluck('id');

                //Xóa detail
                $detail = DB::table('pa05_year_detail')
                ->wherein('pa05_year_id',$years)
                ->delete();

                //xóa year
                $year = DB::table('pa05_year')
                ->where('pa05_region_id',$id)
                ->delete();

                //xóa region
                DB::table('pa05_region')
                ->where('id', $id)
                ->delete();


                $url = url('/'). '/user/pa05/region/list';
                return redirect($url);

            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }
}
