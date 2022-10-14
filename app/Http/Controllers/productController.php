<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class productController extends Controller
{
    //Thêm, sửa, xóa product

    //Liệt kê danh sách các product
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

            if ($pa05role=='pm' || $pa05role=='edit'){

                $groupes = DB::table('general_group')
                ->orderby('order')
                ->get();

                
                if (is_null(session('user_general_product_group')) || is_null(session('user_general_product_sub_group'))){
                    $selected_group = null;
                    $selected_sub_group = null;

                    $sub_groupes = null;
                    $products = null;
                }else{
                    $selected_group = session('user_general_product_group');
                    $selected_sub_group = session('user_general_product_sub_group');

                    $sub_groupes = DB::table('general_sub_group')
                    ->where([
                        ['general_group_id', '=', $selected_group]
                    ])
                    ->get();

                    $products = DB::table('general_product')
                    ->where([
                        ['general_sub_group_id', '=', $selected_sub_group]
                    ])
                    ->get();
                    
                }

                $contract_role = null;

                $contract_roles=DB::table('contract_member')
                ->where([
                    ['member_id', '=', session('User')]
                ])
                ->get();

                if (count($contract_roles)>0){
                   $contract_role = $contract_roles->first()->role;
                }

                return view(
                    'user.general.product.list',
                    compact(
                        'systemconfig',
                        'sessionuser',
                        'pa05role',
                        'contract_role',
                        'products',
                        'groupes',
                        'sub_groupes',
                        'selected_group',
                        'selected_sub_group'
                    )
                );
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
        }           
    }

    //Filter
    public function filter(){

        //Lưu session để chuyển về đúng group và sub group
        session(['user_general_product_group' => Request('group')]);
        if (Request('group')=='0'){
             session(['user_general_product_sub_group' => '0']);
        }else{
            session(['user_general_product_sub_group' => Request('sub_group')]);
        }
        

        $url = url('/'). '/user/general/product/list';
        return redirect($url);
    }

    //Hiện form view only
    public function view($id){
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

            $product = DB::table('general_product')
            ->leftjoin('general_sub_group','general_product.general_sub_group_id','=','general_sub_group.id')
            ->where([
                ['general_product.id', '=', $id]
            ])
            ->select(
                'general_product.id as id',
                'general_product.name as name',
                'general_product.short_description as shortdescription',
                'general_product.long_description as longdescription',
                'general_product.brand as brand',
                'general_product.model as model',
                'general_product.origin as origin',
                'general_product.thumb_image as thumbimage',
                'general_product.spec as spec',
                'general_product.refer_2517 as refer2517',
                'general_product.note as note',
                'general_sub_group.name as subcategoryname'
            )
            ->first();

            $prices = DB::table('general_product_price')
            ->where('general_product_id',$id)
            ->get();

            return view('user.general.product.view',compact('systemconfig','sessionuser','pa05role','contract_role','product','prices'));
        }           
    }

    //Hiện form thêm mới sản phẩm
    public function create($general_sub_group_id){
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
                ->where('id',$general_sub_group_id)
                ->first();

                return view('user.general.product.create',compact('systemconfig','sessionuser','pa05role','contract_role','sub_group'));
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Submit thêm sản phẩm
    public function create_submit($general_sub_group_id){
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

                /////////////////////////////////
                $currentDirectory = getcwd();
                $uploadDirectory = "/filestorage/products/thumbimages/";
                $fileName = $_FILES['thumb_image']['name'];
                $fileSize = $_FILES['thumb_image']['size'];
                $fileTmpName  = $_FILES['thumb_image']['tmp_name'];
                $fileType = $_FILES['thumb_image']['type'];
                $tmp           = explode('.', $fileName);
                $fileExtension = end($tmp);

                $id = DB::table('general_product')         
                ->insertgetid([
                    'general_sub_group_id' => $general_sub_group_id,
                    'name' => Request('name'),
                    'short_description' => Request('short_description'),
                    'long_description' => Request('long_description'),
                    'brand' => Request('brand'),
                    'model' => Request('model'),
                    'spec' => Request('spec'),
                    'origin' => Request('origin'),
                    'refer_2517' => Request('refer_2517'),
                    'note' => Request('note')
                ]);

                if ($fileName!==""){
                    DB::table('general_product')
                    ->where('id', $id)
                    ->update(
                        [
                            'thumb_image' => $id . '.' . $fileExtension

                        ]
                    );

                    $uploadPath = $currentDirectory . $uploadDirectory . $id . '.' . $fileExtension; 

                    $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
                }

                $url = url('/'). '/user/general/product/edit/' . $id;
                return redirect($url);
                ////////////////////////////////
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Hiện form edit sản phẩm
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

                $product = DB::table('general_product')
                ->leftjoin('general_sub_group','general_product.general_sub_group_id','=','general_sub_group.id')
                ->where([
                    ['general_product.id', '=', $id]
                ])
                ->select(
                    'general_product.id as id',
                    'general_product.name as name',
                    'general_product.short_description as shortdescription',
                    'general_product.long_description as longdescription',
                    'general_product.brand as brand',
                    'general_product.model as model',
                    'general_product.origin as origin',
                    'general_product.thumb_image as thumbimage',
                    'general_product.spec as spec',
                    'general_product.refer_2517 as refer2517',
                    'general_product.note as note',
                    'general_sub_group.name as subcategoryname'
                )
                ->first();

                $prices = DB::table('general_product_price')
                ->where('general_product_id',$id)
                ->get();

                return view('user.general.product.edit',compact('systemconfig','sessionuser','pa05role','contract_role','product','prices'));
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Hiện form add price cho sản phẩm
    public function price_create($general_product_id){
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

                return view('user.general.product.price_create',compact('systemconfig','sessionuser','pa05role','contract_role','general_product_id'));
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Submit add price cho sản phẩm
    public function price_create_submit($general_product_id){
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

                $price = str_replace(",", "", Request('price'));

                DB::table('general_product_price')
                ->insert(
                    [
                        'general_product_id' => $general_product_id,
                        'warranty_year' => Request('warranty_year'),
                        'price' => $price
                    ]
                );

                $url = url('/'). '/user/general/product/edit/' . $general_product_id;
                return redirect($url);
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Hiện form edit price cho sản phẩm
    public function price_edit($id){
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

                $price = DB::table('general_product_price')
                ->where('id',$id)
                ->first();

                return view('user.general.product.price_edit',compact('systemconfig','sessionuser','pa05role','contract_role','price'));
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Submit edit price cho sản phẩm
    public function price_edit_submit($id){
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

                $price = str_replace(",", "", Request('price'));

                DB::table('general_product_price')
                ->where('id',$id)
                ->update(
                    [
                        'warranty_year' => Request('warranty_year'),
                        'price' => $price
                    ]
                );

                $general_product_id = DB::table('general_product_price')
                ->where('id',$id)
                ->first()
                ->general_product_id;

                $url = url('/'). '/user/general/product/edit/' . $general_product_id;
                return redirect($url);
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Xóa price của sản phẩm
    public function price_delete($id){
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

                $general_product_id = DB::table('general_product_price')
                ->where('id',$id)
                ->first()
                ->general_product_id;   

                DB::table('general_product_price')
                ->where('id',$id)
                ->delete();
                
                $url = url('/'). '/user/general/product/edit/' . $general_product_id;
                return redirect($url);
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Submit edit product
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

                DB::table('general_product')
                ->where('id', $id)
                ->update(
                    [
                        'name' => Request('name'),
                        'short_description' => Request('short_description'),
                        'long_description' => Request('long_description'),
                        'brand' => Request('brand'),
                        'model' => Request('model'),
                        'spec' => Request('spec'),
                        'origin' => Request('origin'),
                        'refer_2517' => Request('refer_2517'),
                        'note' => Request('note')
                    ]
                );


                $currentDirectory = getcwd();
                $uploadDirectory = "/filestorage/products/thumbimages/";
                $fileName = $_FILES['thumb_image']['name'];
                $fileSize = $_FILES['thumb_image']['size'];
                $fileTmpName  = $_FILES['thumb_image']['tmp_name'];
                $fileType = $_FILES['thumb_image']['type'];
                $tmp           = explode('.', $fileName);
                $fileExtension = end($tmp);

                $uploadPath = $currentDirectory . $uploadDirectory . $id . '.' . $fileExtension; 

                if ($fileName!==""){
                    @unlink($uploadPath);
                    $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

                    DB::table('product')
                    ->where('id', $id)
                    ->update(
                        [
                            'thumb_image' => $id . '.' . $fileExtension

                        ]
                    );
                }

                $url = url('/'). '/user/general/product/list';
                return redirect($url);
            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }

    //Xóa sản phẩm
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

                $selectedproduct = DB::table('general_product')
                ->where('id', $id)
                ->first();

                DB::table('general_product')
                ->where('id', $id)
                ->delete();

                DB::table('general_product_price')
                ->where('general_product_id',$id)
                ->delete();

                $currentDirectory = getcwd();
                $uploadDirectory = "/filestorage/products/thumbimages/";
                $uploadPath = $currentDirectory . $uploadDirectory . $selectedproduct->thumb_image; 
                @unlink($uploadPath);

                $url = url('/'). '/user/general/product/list';
                return redirect($url);

            }else{
                //Không có quyền
                Session()->flush();
                return redirect('/');
            }
            /////////////////////////////////////////
        }           
    }
}
