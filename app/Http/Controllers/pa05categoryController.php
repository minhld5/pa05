<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class pa05categoryController extends Controller
{
    //Thêm sửa xóa danh mục dùng chung pa05

    //Liệt kê danh mục dùng chung
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

            if ($pa05role=='pm'||$pa05role=='edit'){
                $categories = DB::table('pa05_category')
                ->get();
                return view('user.pa05.category.list',compact('sessionuser','systemconfig','pa05role','contract_role','categories'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //THêm mới danh mục dùng chung
    public function create($content){
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
                //pm hoặc editor mới được thêm category
                $id = DB::table('pa05_category')
                ->insertgetid(
                    [
                        'name' => $content
                    ]
                );

                $url = url('/'). '/user/pa05/category/list';
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }

        }
    }

    //Sửa tên danh mục dùng chung
    public function edit($id,$content){
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
                //pm hoặc editor mới được sửa danh mục dùng chung

                DB::table('pa05_category')
                ->where('id', $id)
                ->update(
                    [
                        'name' => $content
                    ]
                );
                $url = url('/'). '/user/pa05/category/list';
                return redirect($url);
            }else{
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Xóa danh mục dùng chung
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
                //pm mới được xóa category

                //Xóa price của danh mục
                //Lấy category_detail
                $details = DB::table('pa05_category_detail')
                ->where('pa05_category_id', $id) 
                ->get();

                if (!is_null($details)){
                    foreach($details as $detail){
                        DB::table('pa05_category_detail_price')
                        ->where('pa05_category_detail_id',$detail->id)
                        ->delete();
                    }
                }

                DB::table('pa05_category_detail')
                ->where('pa05_category_id', $id)
                ->delete();

                DB::table('pa05_category')
                ->where('id', $id)
                ->delete();

                $url = url('/'). '/user/pa05/category/list';
                return redirect($url);
            }else{
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Generate từ danh mục khác
    public function generate($id){
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

                $categories = DB::table('pa05_category')
                ->where('id','!=',$id)
                ->get();

                return view('user.pa05.category.generate',compact('sessionuser','systemconfig','pa05role','contract_role','categories','id'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    public function generate_submit($id){
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
                $destid = $id;
                $srcid = Request('category');
                //Xóa dữ liệu đang có là dữ liệu dest
                DB::table('pa05_category_detail')
                ->where([
                    ['pa05_category_id', '=', $destid]
                ])
                ->delete();

                DB::table('pa05_category_detail_price')
                ->where('pa05_category_detail_id',$destid)
                ->delete();

                //Copy dữ liệu src sang dest
                $tmpdata = DB::table('pa05_category_detail')
                ->where([
                    ['pa05_category_id', '=', $srcid]
                ])
                ->get();

                if ( (!is_null($tmpdata)) && (count($tmpdata)>0) ){
                    foreach ($tmpdata as $row) {
                        # code...

                        $getid=DB::table('pa05_category_detail')
                        ->insertgetid(
                            [
                                'no' => $row->no,
                                'pa05_category_id' => $destid,
                                'name' => $row->name,
                                'type' => $row->type,
                                'model' => $row->model,
                                'brand' => $row->brand,
                                'origin' => $row->origin,
                                'spec' => $row->spec,
                                'unit' => $row->unit,
                                'note' => $row->note,
                                'refer_2517' => $row->refer_2517,
                                'general_product_id' => $row->general_product_id
                            ]
                        );

                        //Clone price
                        $prices = DB::table('pa05_category_detail_price')
                        ->where('pa05_category_detail_id',$row->id)
                        ->get();

                        if (!is_null($prices)){
                            foreach($prices as $price){
                                DB::table('pa05_category_detail_price')
                                ->insert(
                                    [
                                        'pa05_category_detail_id' => $getid,
                                        'warranty_year' => $price->warranty_year,
                                        'price' => $price->price
                                    ]
                                );
                            }
                        }

                    }
                }

                $url = url('/'). '/user/pa05/category_detail/list/'. $destid;
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }
}
