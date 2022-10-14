<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class subgroupController extends Controller
{
    //Thêm, sửa, xóa sub group

    //Liệt kê danh sách các sub group
    public function list($general_group_id){
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

                $group = DB::table('general_group')
                ->where('id', $general_group_id)
                ->first();

                $sub_groupes = DB::table('general_sub_group')
                ->where('general_group_id', $general_group_id)
                ->orderby('order')
                ->get();
                return view('user.general.sub_group.list',compact('systemconfig','sessionuser','pa05role','contract_role','sub_groupes','group'));
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }

        }           
    }

    //Hiển thị form thêm mới sub group
    public function create($general_group_id){
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

                $group = DB::table('general_group')
                ->where('id', $general_group_id)
                ->first();

                return view('user.general.sub_group.create',compact('systemconfig','sessionuser','pa05role','contract_role','group'));
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }

        }           
    }

    //Submit thêm mới sub group
    public function create_submit($general_group_id){
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

                DB::table('general_sub_group')
                ->insert(
                    [
                        'general_group_id' => $general_group_id,
                        'order' => Request('order'),
                        'name' => Request('name'),
                        'description' => Request('description'),
                        'display_label' => Request('display_label')
                    ]
                );

                $url = url('/'). '/user/general/sub_group/list/' . $general_group_id;
                return redirect($url);
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }

        }           
    }

    //Hiển thị form sửa sub group
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

                $sub_group = DB::table('general_sub_group')
                ->where('id', $id)
                ->first();
                return view('user.general.sub_group.edit',compact('systemconfig','sessionuser','pa05role','contract_role','sub_group'));
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }

        }           
    }

    //Submit form cập nhật sub group
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

            if ($pa05role=='pm' || $pa05role=='edit'){

                DB::table('general_sub_group')
                ->where('id',$id)
                ->update(
                    [
                        'order' => Request('order'),
                        'name' => Request('name'),
                        'description' => Request('description'),
                        'display_label' => Request('display_label')
                    ]
                );

                $general_group_id = DB::table('general_sub_group')
                ->where('id',$id)
                ->first()
                ->general_group_id;

                $url = url('/'). '/user/general/sub_group/list/' . $general_group_id;
                return redirect($url);
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }

        }           
    }

    //Xóa sub group
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

            if ($pa05role=='pm' || $pa05role=='edit'){

                $general_group_id = DB::table('general_sub_group')
                ->where('id',$id)
                ->first()
                ->general_group_id;

                $products = DB::table('general_product')
                ->where('general_sub_group_id',$id)
                ->get();

                if (!is_null($products)){
                    foreach ($products as $product) {
                        DB::table('general_product_price')
                        ->where('general_product_id',$product->id)
                        ->delete();
                    }
                }

                //Xóa sản phẩm thuộc sub category này
                DB::table('general_product')
                ->where('general_sub_group_id', $id)
                ->delete();

                //Xóa sub category
                DB::table('general_sub_group')
                ->where('id', $id)
                ->delete();      

                $url = url('/'). '/user/general/sub_group/list/' . $general_group_id;
                return redirect($url);
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }

        }           
    }
}
