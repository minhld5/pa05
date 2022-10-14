<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class groupController extends Controller
{
    //Thêm, sửa, xóa nhóm sản phẩm

    //Liệt kê danh sách các nhóm
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

            if ($pa05role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){
                	$groupes = DB::table('general_group')
		            ->orderby('order')
		            ->get();
                    return view('user.general.group.list',compact('systemconfig','sessionuser','pa05role','contract_role','groupes'));
                }else{
                	//Không có quyền xem danh sách
                    Session()->flush();
                    return redirect('/');
                }
            }

        }           
    }

    //Hiển thị form thêm mới nhóm sản phẩm
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

            if ($pa05role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){
                	$groupes = DB::table('general_group')
		            ->orderby('order')
		            ->get();
                    return view('user.general.group.create',compact('systemconfig','sessionuser','pa05role','contract_role'));
                }else{
                	//Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
            /////////////////////////////////////////
        }           
    }

    //Submit tạo nhóm sản phẩm
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

            if ($pa05role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

                if ($pa05role=='pm' || $pa05role=='edit'){
                	DB::table('general_group')         
		            ->insert([
		            	'order' => Request('order'),
		                'name' => Request('name'),
		                'description' => Request('description'),
		                'display_label' => Request('display_label')
		            ]);

		            $url = url('/'). '/user/general/group/list';
		            return redirect($url);
                }else{
                	//Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
            /////////////////////////////////////////
        }           
    }

    //Hiển thị form chỉnh sửa nhóm sản phẩm
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

                if ($pa05role=='pm' || $pa05role=='edit'){
                	$group = DB::table('general_group')
		            ->where('id',$id)
		            ->first();
                    return view('user.general.group.edit',compact('systemconfig','sessionuser','pa05role','contract_role','group'));
                }else{
                	//Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
            /////////////////////////////////////////
        }           
    }

    //Submit cập nhật nhóm sản phẩm
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

                if ($pa05role=='pm' || $pa05role=='edit'){
                	DB::table('general_group')  
                	->where('id',$id)       
		            ->update([
		            	'order' => Request('order'),
		                'name' => Request('name'),
		                'description' => Request('description'),
		                'display_label' => Request('display_label')
		            ]);

		            $url = url('/'). '/user/general/group/list';
		            return redirect($url);
                }else{
                	//Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
            /////////////////////////////////////////
        }           
    }

    //Xóa nhóm sản phẩm
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
                if ($pa05role=='pm' || $pa05role=='edit'){
                	
                	//Lấy danh sách subgroup thuộc group muốn xóa
		            $tmp = DB::table('general_sub_group')
		            ->where('general_group_id', $id)
		            ->pluck('id');

		            if (!is_Null($tmp)){
		                foreach ($tmp as $item) {
		                    //Lấy sản phẩm thuộc sub
		                    $products = DB::table('general_product')
		                    ->where('general_sub_group_id',$item)
		                    ->get();

		                    if (!is_null($products)){
		                        foreach ($products as $product) {
		                            DB::table('general_product_price')
		                            ->where('general_product_id',$product->id)
		                            ->delete();
		                        }
		                    }

		                    //Xóa sản phẩm có subcategoryid trùng với item
		                    DB::table('general_product')
		                    ->where('general_sub_group_id', $item)
		                    ->delete();
		                }
		            }

		            //Xóa sub group có categoryid trùng
		            DB::table('general_sub_group')
		            ->where('general_group_id', $id)
		            ->delete();

		            //Xóa group
		            DB::table('general_group')
		            ->where('id', $id)
		            ->delete();

		            $url = url('/'). '/user/general/group/list';
		            return redirect($url);
                }else{
                	//Không có quyền
                    Session()->flush();
                    return redirect('/');
                }
            }
            /////////////////////////////////////////
        }           
    }
}
