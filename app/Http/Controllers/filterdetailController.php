<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class filterdetailController extends Controller
{
    //Thêm, sửa, xóa filter detail
    
	//Thêm từ java script không cần form
    public function create($filter_id, $content){
        if (session('Role')!=md5('user')){
            Session()->flush();
            return redirect('/');
        }else{
            //Insert vào db
            DB::table('general_filter_detail')         
            ->insert([
                'general_filter_id' => $filter_id,
                'name' => $content
            ]);
            //redirect

            $url = url('/'). '/user/general/filter/edit/'. $filter_id;
            return redirect($url);
        }
    }

    //Chọn product cho bộ lọc
    public function select_product($id){
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

            //Lấy filter id
            $general_filter_id = DB::table('general_filter_detail')
            ->where('id',$id)
            ->first()
            ->general_filter_id;

            $filter = DB::table('general_filter')
            ->leftjoin('general_sub_group','general_filter.general_sub_group_id','=','general_sub_group.id')
            ->where([
                ['general_filter.id', '=', $general_filter_id]
            ])
            ->select(
                'general_filter.id as id',
                'general_filter.name as name',
                'general_filter.display_label as display_label',
                'general_filter.type as type',
                'general_sub_group.name as general_sub_group_name',
                'general_sub_group.id as general_sub_group_id'
            )
            ->first();

            $filter_detail = DB::table('general_filter_detail')
            ->where('id',$id)
            ->first();

            $selected_products = DB::table('general_filter_detail_product')
            ->join('general_product','general_filter_detail_product.general_product_id','general_product.id')
            ->where('general_filter_detail_product.general_filter_detail_id', $id)
            ->select('general_product.id as id', 'general_product.name as name')
            ->get();

            
            if (count($selected_products)==0){
                $available_products = DB::table('general_product')
                ->where([
                    ['general_sub_group_id', '=', $filter->general_sub_group_id]
                ])
                ->get();
            }else{
                $tmp = [];
                foreach ($selected_products as $p) {
                    array_push($tmp, $p->id);
                }

                $available_products = DB::table('general_product')
                ->wherenotin('id',$tmp)
                ->where([
                    //['filterdetailid', '=', $filterdetailid]
                    ['general_sub_group_id' , '=', $filter->general_sub_group_id]
                ])
                ->get();
            }
            

            return view(
            	'user.general.filter_detail.select_product',
            	compact(
            		'systemconfig',
            		'sessionuser',
            		'pa05role',
                    'contract_role',
            		'filter',
            		'selected_products',
            		'available_products',
            		'id',
            		'filter_detail'
            	)
            );
        }
    }

    //Submit chọn sản phẩm cho bộ lọc
    public function select_product_submit($id){
        if (session('Role')!=md5('user')){
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


            DB::table('general_filter_detail_product')
            ->where([
                ['general_filter_detail_id', '=', $id]
            ])
            ->delete();

            if (isset($_POST['selected_product'])){
                //dd($_POST['selectedproduct']);
                foreach ($_POST['selected_product'] as $productid) {
                    DB::table('general_filter_detail_product')         
                    ->insert([
                        'general_filter_detail_id' => $id,
                        'general_product_id' => $productid
                    ]);
                }
            }

            $filter_id = DB::table('general_filter_detail')
            ->where('id',$id)
            ->first()
            ->general_filter_id;

            $url = url('/'). '/user/general/filter/edit/'. $filter_id;
            return redirect($url);
        }           
    }

    //Xóa điều kiện lọc
    public function delete($id){
        if (session('Role')!=md5('user')){
            Session()->flush();
            return redirect('/');
        }else{

        	$filter_id = DB::table('general_filter_detail')
            ->where('id',$id)
            ->first()
            ->general_filter_id;

            //Xoa san phẩm trong filterdetail_product
            DB::table('general_filter_detail_product')         
            ->where([
                ['general_filter_detail_id', '=', $id]
            ])
            ->delete();

            DB::table('general_filter_detail')         
            ->where([
                ['id', '=', $id]
            ])
            ->delete();

            //redirect

            $url = url('/'). '/user/general/filter/edit/'. $filter_id;
            return redirect($url);
        }
    }
}
