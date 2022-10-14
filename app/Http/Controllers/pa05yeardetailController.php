<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Shuchkin\SimpleXLSXGen;
use App\Lib\common;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;

class pa05yeardetailController extends Controller
{
    //Thêm sửa xóa year_detail

	//Liệt kê toàn bộ năm của PA05 1 tỉnh
    public function list($pa05_year_id){
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
                ->where('id', $pa05_year_id)
                ->first();

                $max_order_no = DB::table('pa05_year_detail')
                ->where('pa05_year_detail.pa05_year_id', $pa05_year_id)
                ->max('order_no');

                $year_details = DB::table('pa05_year_detail')
                ->leftjoin('general_product', 'pa05_year_detail.general_product_id', 'general_product.id')
                ->where('pa05_year_detail.pa05_year_id', $pa05_year_id)
                ->orderby('pa05_year_detail.no')
                ->select(
                    'pa05_year_detail.id as id',
                    'pa05_year_detail.name as name',
                    'pa05_year_detail.model as model',
                    'pa05_year_detail.brand as brand',
                    'pa05_year_detail.origin as origin',
                    'pa05_year_detail.spec as spec',
                    'pa05_year_detail.unit as unit',
                    'pa05_year_detail.unit_price as unit_price',
                    'pa05_year_detail.quantity as quantity',
                    'pa05_year_detail.sub_total as sub_total',
                    'pa05_year_detail.vat as vat',
                    'pa05_year_detail.total as total',
                    'pa05_year_detail.general_product_id as product_id',
                    'pa05_year_detail.pa05_category_detail_id as category_detail_id',
                    'pa05_year_detail.order_no as order_no',
                    'pa05_year_detail.no as no',
                    'pa05_year_detail.type as type',
                    'pa05_year_detail.pa05_year_id as pa05_year_id',
                    'general_product.name as product_name'
                )
                ->get();

                return view('user.pa05.year_detail.list',compact('sessionuser','systemconfig','pa05role','contract_role','year','year_details','max_order_no'));

            }
        }
    }

    //Hiện form tạo mới
    public function create($pa05_year_id){
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
                ->where('id', $pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền thêm
                    if ($pa05role=='pm' || $pa05role=='edit'){
                        //Lấy danh mục dùng chung
                        $pa05categories = DB::table('pa05_category')
                        ->orderby('name')
                        ->get();

                        return view('user.pa05.year_detail.create',compact('sessionuser','systemconfig','pa05role','contract_role','year','pa05categories'));
                        
                    }else{
                        //Bắt buộc quit ra đăng nhập lại
                        Session()->flush();
                        return redirect('/');
                    }
                }else{
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }

    //Hiện form chọn hạng mục từ danh mục dùng chung
    public function create_submit($pa05_year_id){
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
                ->where('id', $pa05_year_id)
                ->first();

                $pa05category = Request('pa05category');

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền thêm
                    if ($pa05role=='pm' || $pa05role=='edit'){
                        //Lấy danh mục dùng chung

                        $pa05category_details = DB::table('pa05_category_detail')
                        ->leftjoin('general_product','pa05_category_detail.general_product_id','general_product.id')
                        ->where('pa05_category_detail.pa05_category_id', $pa05category)
                        ->select(
                                'pa05_category_detail.id as id',
                                'pa05_category_detail.name as name',
                                'pa05_category_detail.type as type',
                                'pa05_category_detail.model as model',
                                'pa05_category_detail.brand as brand',
                                'pa05_category_detail.origin as origin',
                                'pa05_category_detail.spec as spec',
                                'general_product.name as product_name',
                                'general_product.id as product_id'
                            )
                        ->orderby('no')
                        ->get();

                        if (isset($_POST['selecteditem'])){
                        	$prices = DB::table('pa05_category_detail_price')
	                        ->where('pa05_category_detail_id',$_POST['selecteditem'])
	                        ->get();
                        }else{
                        	$prices = null;
                        }

                        $selecteditem = null;

                        return view('user.pa05.year_detail.create_step2',compact('sessionuser','systemconfig','pa05role','contract_role','year','prices','pa05category_details','pa05category','selecteditem'));
                        
                    }else{
                        //Bắt buộc quit ra đăng nhập lại
                        Session()->flush();
                        return redirect('/');
                    }
                }else{
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }

    //Hiện form chọn giá sau khi chọn hạng mục từ danh mục dùng chung
    public function create_step2_submit($pa05_year_id){
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
                ->where('id', $pa05_year_id)
                ->first();

                $pa05category = Request('pa05category');
                $selecteditem = Request('selecteditem');

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền thêm
                    if ($pa05role=='pm' || $pa05role=='edit'){
                    	//Xem là nhấn OK hay không
                    	if (isset($_POST['btnOK'])){
                    		//Đã chọn xong danh mục và giá//////////////////////////////////////////
                    		$category_detail = DB::table('pa05_category_detail')
                        	->where('id',Request('selecteditem'))
                        	->first();
                        	if ($category_detail->type=='hardware'){
                                $count = count(DB::table('pa05_year_detail')
                                ->where('pa05_year_id', $pa05_year_id)
                                ->get());

                                $max_order_no = DB::table('pa05_year_detail')
				                ->where('pa05_year_detail.pa05_year_id', $pa05_year_id)
				                ->max('order_no');

                        		DB::table('pa05_year_detail')
                        		->insert(
                        			[
	                        			'pa05_year_id' => $pa05_year_id,
	                        			'name' => $category_detail->name,
	                        			'model' => $category_detail->model,
	                        			'brand' => $category_detail->brand,
	                        			'origin' => $category_detail->origin,
	                        			'unit' => $category_detail->unit,
	                        			'unit_price' => Request('price'),
	                        			'general_product_id' => $category_detail->general_product_id,
	                        			'pa05_category_detail_id' => $category_detail->id,
                                        'order_no' => $max_order_no+1,
                                        'type' => $category_detail->type,
                                        'refer_2517' => $category_detail->refer_2517,
                                        'note' => $category_detail->note,
                                        'spec' => $category_detail->spec
                        			]
                        		);
                        	}else{
                        		//Nếu là software thì check xem có trùng từ năm nào không
                        		$region = DB::table('pa05_year')
                        		->where('id',$pa05_year_id)
                        		->first()
                        		->pa05_region_id;

                                $selectedname = DB::table('pa05_category_detail')
                                ->where('id',Request('selecteditem'))
                                ->first()
                                ->name;

                        		
                        		//Lấy toàn bộ danh mục có regionid = $region
                        		$exists = DB::table('pa05_year_detail')
                        		->leftjoin('pa05_year', 'pa05_year_detail.pa05_year_id', 'pa05_year.id')
                        		->leftjoin('pa05_region', 'pa05_year.pa05_region_id', 'pa05_region.id')
                        		->where('pa05_region.id',$region)
                        		->where('pa05_year_detail.name', $selectedname)
                        		->pluck('year');

                        		if (count($exists)>0){
                        			//Đã có
                        			//Hiện thông báo yes/no
                        			$pa05category_detail = DB::table('pa05_category_detail')
                        			->where('id', Request('selecteditem'))
                        			->first();

                        			$price = Request('price');

                        			return view(
                        				'user.pa05.year_detail.question_form',
                        				compact(
                        					'sessionuser',
                        					'pa05role',
                        					'pa05category_detail',
                        					'exists',
                        					'year',
                        					'price'
                        				)
                        			);

                        		}else{
                                    $count = count(DB::table('pa05_year_detail')
                                    ->where('pa05_year_id', $pa05_year_id)
                                    ->get());

                                    $max_order_no = DB::table('pa05_year_detail')
					                ->where('pa05_year_detail.pa05_year_id', $pa05_year_id)
					                ->max('order_no');

                        			DB::table('pa05_year_detail')
	                        		->insert(
	                        			[
		                        			'pa05_year_id' => $pa05_year_id,
		                        			'name' => $category_detail->name,
		                        			'model' => $category_detail->model,
		                        			'brand' => $category_detail->brand,
		                        			'origin' => $category_detail->origin,
		                        			'unit' => $category_detail->unit,
		                        			'unit_price' => Request('price'),
		                        			'general_product_id' => $category_detail->general_product_id,
		                        			'pa05_category_detail_id' => $category_detail->id,
                                            'order_no' => $max_order_no+1,
                                            'type' => $category_detail->type,
                                            'refer_2517' => $category_detail->refer_2517,
                                        	'note' => $category_detail->note,
                                        	'spec' => $category_detail->spec
	                        			]
	                        		);
                        		}

                        	}
                    		//////////////////////////////////////////////////////////////////////

                    		$url = url('/'). '/user/pa05/year_detail/list/' . $pa05_year_id;
                			return redirect($url);
                    	}else{
                    		//////////////////////////////////
                    		if (isset($_POST['selecteditem'])){
	                    		//Đã chọn sản phẩm
	                    		$pa05category_details = DB::table('pa05_category_detail')
		                        ->leftjoin('general_product','pa05_category_detail.general_product_id','general_product.id')
		                        ->where('pa05_category_detail.pa05_category_id', Request('pa05category'))
		                        ->select(
		                                'pa05_category_detail.id as id',
		                                'pa05_category_detail.name as name',
		                                'pa05_category_detail.type as type',
		                                'pa05_category_detail.model as model',
		                                'pa05_category_detail.brand as brand',
		                                'pa05_category_detail.origin as origin',
		                                'pa05_category_detail.spec as spec',
		                                'general_product.name as product_name',
		                                'general_product.id as product_id'
		                            )
		                        ->orderby('no')
		                        ->get();

		                        $prices = DB::table('pa05_category_detail_price')
		                        ->where('pa05_category_detail_id',$_POST['selecteditem'])
		                        ->orderby('warranty_year')
		                        ->get();

		                        return view('user.pa05.year_detail.create_step2',compact('sessionuser','systemconfig','pa05role','contract_role','year','pa05category_details','prices','pa05category','selecteditem'));
	                    	}else{
	                    		//Chưa chọn sản phẩm
	                    		$url = url('/'). '/user/pa05/year_detail/list/' . $pa05_year_id;
	                			return redirect($url);
	                    	}
                    		//////////////////////////////////
                    	}
                    }else{
                        //Bắt buộc quit ra đăng nhập lại
                        Session()->flush();
                        return redirect('/');
                    }
                }else{
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }

    //Submit question form
    public function question_form(){
    	$count = count(DB::table('pa05_year_detail')
        ->where('pa05_year_id', Request('yearid'))
        ->get());

        $max_order_no = DB::table('pa05_year_detail')
        ->where('pa05_year_detail.pa05_year_id', Request('yearid'))
        ->max('order_no');

        $id=DB::table('pa05_year_detail')
		->insertgetid(
			[
    			'pa05_year_id' => Request('yearid'),
    			'name' => Request('name'),
    			'model' => Request('model'),
    			'brand' => Request('brand'),
    			'origin' => Request('origin'),
    			'unit' => Request('unit'),
    			'unit_price' => Request('unitprice'),
    			'general_product_id' => Request('productid'),
    			'pa05_category_detail_id' => Request('categorydetail_id'),
                'order_no' => $max_order_no+1,
                'type' => Request('type'),
                'note' => Request('note'),
                'refer_2517' => Request('refer_2517'),
                'spec' => Request('spec')
			]
		);

        $url = url('/'). '/user/pa05/year_detail/list/' . Request('yearid');
        return redirect($url);
    }

    //Hiển thị thông tin sản phẩm
    public function product_info($productid){
        $systemconfig = DB::table('sys_config')
        ->first();

        $product = DB::table('general_product')
        ->where('id',$productid)
        ->first();

        $prices = DB::table('general_product_price')
        ->where('general_product_id',$productid)
        ->get();

        return view('user.pa05.year_detail.product_info',compact('systemconfig','product','prices'));
    }

    //Hiện form edit
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
                $id = Request('id');

                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền xóa
                    if ($pa05role=='pm' || $pa05role=='edit'){

                        //Hiện form edit
                        //VAT lấy default software = 0, hardware = 10%
                        //Các ô thay đổi tự tính lại
                        $yeardetail = DB::table("pa05_year_detail")
                        ->where('id',$id)
                        ->first();

                        return view('user.pa05.year_detail.edit',compact('sessionuser','pa05role','contract_role','year_detail'));
                        
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

    //Submit edit
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

                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                //Lấy year để check điều kiện sửa và quay lại
                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    if ($pa05role=='pm' || $pa05role=='edit'){
                        $unitprice = str_replace(",", "", Request('unit_price'));
                        $subtotal = str_replace(",", "", Request('sub_total'));
                        $total = str_replace(",", "", Request('total'));
                        DB::table('pa05_year_detail')
                        ->where('id',$id)
                        ->update(
                            [
                                'no' => Request('no'),
                                'unit' => Request('unit'),
                                'brand' => Request('brand'),
                                'model' => Request('model'),
                                'origin' => Request('origin'),
                                'spec' => Request('spec'),
                                'quantity' => Request('quantity'),
                                'unit_price' => $unitprice,
                                'sub_total' => $subtotal,
                                'vat' => Request('vat'),
                                'total' => $total,
                                'note' => Request('note'),
                                'refer_2517' => Request('refer_2517')
                            ]
                        );
                        $url = url('/'). '/user/pa05/year_detail/list/' . $year->id;
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

            if ($pa05role==''){
                //Không phải thành viên
                Session()->flush();
                return redirect('/');
            }else{

                $id = Request('id');

                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                $yeardetail = DB::table("pa05_year_detail")
                ->where('id',$id)
                ->first();

                return view('user.pa05.year_detail.view',compact('sessionuser','pa05role','contract_role','year_detail'));
            }
        }
    }

    //Hiện form thêm heading
    public function heading_create($id){
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

                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                //Lấy year để check điều kiện sửa
                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    if ($pa05role=='pm' || $pa05role=='edit'){

                        //Hiện form nhập heading
                        return view('user.pa05.year_detail.heading_create',compact('sessionuser','pa05role','contract_role','year_detail'));
                        
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

    //submit add heading
    public function heading_create_submit($id){
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

                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                //Lấy year để check điều kiện sửa
                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    if ($pa05role=='pm' || $pa05role=='edit'){

                        //Cập nhật lại order
                        DB::table('pa05_year_detail')
                        ->where([
                            ['pa05_year_id', '=', $year->id],
                            ['order_no', ">=", $year_detail->order_no]
                         ])
                        ->update(
                            [
                                'order_no' => DB::raw('order_no + 1')
                            ]
                         );

                        DB::table('pa05_year_detail')
                        ->insert(
                            [
                                'pa05_year_id' => $year->id,
                                'no' => Request('no'),
                                'name' => Request('name'),
                                'model' => '',
                                'brand' => '',
                                'origin' => '',
                                'unit' => '',
                                'unit_price' => 0,
                                'general_product_id' => 0,
                                'pa05_category_detail_id' => 0,
                                'order_no' => $year_detail->order_no,
                                'type' => "heading"
                            ]
                        );

                        $url = url('/'). '/user/pa05/year_detail/list/' . $year->id;
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

    //Hiện form sửa heading
    public function heading_edit($id){
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

                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                //Lấy year để check điều kiện sửa và quay lại
                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    if ($pa05role=='pm' || $pa05role=='edit'){

                        //Hiện form nhập heading
                        return view('user.pa05.year_detail.heading_edit',compact('sessionuser','pa05role','contract_role','year_detail','year'));
                        
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

    //Submit edit heading
    public function heading_edit_submit($id){
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

                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                //Lấy year để check điều kiện sửa và quay lại
                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    if ($pa05role=='pm' || $pa05role=='edit'){

                        DB::table('pa05_year_detail')
                        ->where([
                            ['id', '=', $id]
                         ])
                        ->update(
                            [
                                'no' => Request('no'),
                                'name' => Request('name')
                            ]
                         );

                        $url = url('/'). '/user/pa05/year_detail/list/' . $year->id;
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

    //Order up
    public function order_up($id){
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

                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                //Lấy year để check điều kiện sửa và quay lại
                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    //Tìm thằng đứng trước, order nhỏ hơn order của this 1 đơn vị (có cùng year_id)
                    //Update thằng đứng trước
                    DB::table('pa05_year_detail')
                    ->where([
                        ['pa05_year_id', '=', $year_detail->pa05_year_id],
                        ['order_no', "=", $year_detail->order_no - 1]
                     ])
                    ->update(
                        [
                            'order_no' => $year_detail->order_no
                        ]
                     );

                    //Update chính nó
                    DB::table('pa05_year_detail')
                    ->where('id',$id)
                    ->update(
                        [
                            'order_no' => DB::raw('order_no - 1')
                        ]
                     );

                    $url = url('/'). '/user/pa05/year_detail/list/' . $year_detail->pa05_year_id;
                    return redirect($url);
                }else{
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }

    //Order up
    public function order_down($id){
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
                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                //Lấy year để check điều kiện sửa và quay lại
                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền sửa
                    //Tìm thằng đứng sau, order lớn hơn order của this 1 đơn vị (có cùng year_id)
                    //Update thằng đứng trước
                    DB::table('pa05_year_detail')
                    ->where([
                        ['pa05_year_id', '=', $year_detail->pa05_year_id],
                        ['order_no', "=", $year_detail->order_no + 1]
                     ])
                    ->update(
                        [
                            'order_no' => $year_detail->order_no
                        ]
                     );

                    //Update chính nó
                    DB::table('pa05_year_detail')
                    ->where('id',$id)
                    ->update(
                        [
                            'order_no' => DB::raw('order_no + 1')
                        ]
                     );

                    $url = url('/'). '/user/pa05/year_detail/list/' . $year_detail->pa05_year_id;
                    return redirect($url);
                }else{
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }

    //Xóa
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
                $year_detail=DB::table('pa05_year_detail')
                ->where('id', $id)
                ->first();

                $year = DB::table('pa05_year')
                ->where('id', $year_detail->pa05_year_id)
                ->first();

                if ($year->enable==1){
                    //Chỉ pm và edit mới có quyền xóa
                    if ($pa05role=='pm' || $pa05role=='edit'){

                        DB::table('pa05_year_detail')
                        ->where('id',$id)
                        ->delete();

                        //Cập nhật lại order
                        DB::table('pa05_year_detail')
                        ->where([
                            ['pa05_year_id', '=', $year->id],
                            ['order_no', ">", $year_detail->order_no]
                         ])
                        ->update(
                            [
                                'order_no' => DB::raw('order_no - 1')
                            ]
                         );

                        $url = url('/'). '/user/pa05/year_detail/list/' . $year->id;
                        return redirect($url);
                        
                    }else{
                        //Bắt buộc quit ra đăng nhập lại
                        Session()->flush();
                        return redirect('/');
                    }
                }else{
                    //Bắt buộc quit ra đăng nhập lại
                    Session()->flush();
                    return redirect('/');
                }
            }
        }
    }

    //Xuất ra excel
    public function save_to_excel($id){
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

    //         	$year_details = DB::table('pa05_year_detail')
    //             ->leftjoin('general_product', 'pa05_year_detail.general_product_id', 'general_product.id')
    //             ->where('pa05_year_detail.pa05_year_id', $id)
    //             ->orderby('pa05_year_detail.order_no')
    //             ->select(
    //                 'pa05_year_detail.no as no',
    //                 'pa05_year_detail.name as name',
    //                 'pa05_year_detail.model as model',
    //                 'pa05_year_detail.brand as brand',
    //                 'pa05_year_detail.origin as origin',
    //                 'pa05_year_detail.spec as spec',
    //                 'pa05_year_detail.unit as unit',
    //                 'pa05_year_detail.unit_price as unit_price',
    //                 'pa05_year_detail.quantity as quantity',
    //                 'pa05_year_detail.sub_total as sub_total',
    //                 'pa05_year_detail.vat as vat',
    //                 'pa05_year_detail.total as total',
    //                 'pa05_year_detail.general_product_id as product_id',
    //                 'pa05_year_detail.pa05_category_detail_id as category_detail_id',
    //                 'pa05_year_detail.spec as spec',
    //                 'pa05_year_detail.type as type',
    //                 'pa05_year_detail.pa05_year_id as pa05_year_id',
    //                 'general_product.name as product_name'
    //             )
    //             ->get();

    //             $data = array(array());
    //             //Tạo heading
    //             $row = array();
			 //    $row['no'] = 'STT';
			 //    $row['name'] = 'Hạng mục';
			 //    $row['brand'] = 'Hãng/model/xuất xứ';
			 //    $row['unit'] = 'Đơn vị tính';
			 //    $row['unit_price'] = 'Đơn giá';
			 //    $row['quantity'] = 'Số lượng';
			 //    $row['sub_total'] = 'Trước VAT';
			 //    $row['vat'] = 'VAT';
			 //    $row['total'] = 'Thành tiền';
			 //    $data[] = $row;

    //             foreach($year_details as $year_detail)
				// {
				//     $row = array();
				//     $row['no'] = $year_detail->no;
				//     $row['name'] = $year_detail->name;
				//     $row['brand'] = '<wraptext>- Hãng: ' . $year_detail->brand . PHP_EOL . '- Model: ' . $year_detail->model . PHP_EOL . '- Xuất xứ: ' . $year_detail->origin .'</wraptext>';
				//     $row['unit'] = $year_detail->unit;
				//     $row['unit_price'] = $year_detail->unit_price;
				//     $row['quantity'] = $year_detail->quantity;
				//     $row['sub_total'] = $year_detail->sub_total;
				//     $row['total'] = $year_detail->total;
				//     $data[] = $row;

				//     if (!is_null($year_detail->spec)){
				//     	$spec_arr = preg_split("/\r\n|\n|\r/", $year_detail->spec);

				//     	if (count($spec_arr)>0){
				//     		foreach($spec_arr as $item){
				//     			$row = array();
				// 			    $row['no'] = '';
				// 			    $row['name'] = $item;
				// 			    $row['brand'] = '';
				// 			    $row['unit'] = '';
				// 			    $row['unit_price'] = '';
				// 			    $row['quantity'] = '';
				// 			    $row['sub_total'] = '';
				// 			    $row['total'] = '';
				// 			    $data[] = $row;
				//     		}
				//     	}
				//     }
				// }

                $year = DB::table('pa05_year')
                ->leftjoin('pa05_region','pa05_region.id','pa05_year.pa05_region_id')
                ->leftjoin('sys_region','pa05_region.sys_region_id','sys_region.id')
                ->where('pa05_year.id', $id)
                ->first();

                return (new DataExport($id))->download($year->name . '_'. $year->year . '.xlsx');

                $url = url('/'). '/user/pa05/year_detail/list/' . $id;
                return redirect($url);
            }
        }
    }
}
