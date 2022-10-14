<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Lib\common;

class pa05categorydetailController extends Controller
{
    //Thêm sửa xóa chi tiết của danh mục dùng chung

	//Hiển thị danh sách chi tiết của một danh mục dùng chung
    public function list($category_id){
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

            	$category = DB::table('pa05_category')
            	->where('id', $category_id)
	            ->first();

	            $category_details = DB::table('pa05_category_detail')
            	->where('pa05_category_id', $category_id)
            	->orderby('no')
	            ->get();

            	return view('user.pa05.category_detail.list',compact('sessionuser','systemconfig','pa05role','contract_role','category','category_details'));
            }else{
            	Session()->flush();
        		return redirect('/');
            }
        }
    }

    //Hiển thị form thêm mới
    public function create($category_id){
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

	            //Lấy thông tin product group đã pick
	            $selected_group = null;
		        $selected_group = Request('group');

		        $selected_sub_group = null;
		        $selected_sub_group = Request('sub_group');

	            //Lấy danh sách product category và subcategory
	            $groupes = DB::table('general_group')
		        ->orderby('order')
		        ->get();

		        $sub_groupes = DB::table('general_sub_group')
		        ->where('general_sub_group.general_group_id', $selected_group)
		        ->orderby('order')
		        ->get();

		        $brands = null;
		        $filters = null;
		        $filter_details = null;
		        $brands = null;
		        $posts = null;
		        $selected_brand = null;
		        $products = null;

		        //

            	return view(
            		'user.pa05.category_detail.create',
            		compact(
            			'sessionuser',
            			'systemconfig',
            			'pa05role',
            			'groupes',
            			'sub_groupes',
            			'selected_group',
            			'selected_sub_group',
            			'filters',
            			'filter_details',
            			'brands',
            			'selected_brand',
            			'posts',
            			'products',
            			'category_id'
            		)
            	);
            }else{
            	Session()->flush();
        		return redirect('/');
            }
        }
    }

    //Submit create
    public function create_submit($category_id){
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

	            //Check xem có nhấn OK không
	            if (isset($_POST['btnOK'])){
	            	//Update danh mục

	            	if (isset($_POST['product'])){
	            		$product_id = $_POST['product'];
	            		$retID = DB::table('pa05_category_detail')
			            ->insertgetid(
			            	[
			            		'no' => Request('no'),
			            		'name' => Request('name'),
			            		'type' => Request('type'),
			            		'spec' => Request('spec'),
			            		'model' => Request('model'),
			            		'brand' => Request('brand'),
			            		'origin' => Request('origin'),
			            		'unit' => Request('unit'),
			            		'general_product_id' => $product_id,
			            		'pa05_category_id' => $category_id,
                                'note' => Request('note'),
                                'refer_2517' => Request('refer_2517')
			            	]
			            );

			            //Có chọn sản phẩm nên sẽ clone luôn giá sản phẩm vào bảng price của danh mục
                        $prices = DB::table('general_product_price')
                        ->where('general_product_id',$product_id)
                        ->get();

                        if (!is_null($prices)){
                            DB::table('pa05_category_detail_price')
                            ->where('pa05_category_detail_id', $retID)
                            ->delete();

                            foreach($prices as $price){
                                DB::table('pa05_category_detail_price')
                                ->insert(
                                    [
                                        'pa05_category_detail_id' => $retID,
                                        'warranty_year' => $price->warranty_year,
                                        'price' => $price->price
                                    ]
                                );
                            }
                        }

	            	}else{
	            		$product_id = null;

	            		DB::table('pa05_category_detail')
			            ->insertgetid(
			            	[
			            		'no' => Request('no'),
			            		'name' => Request('name'),
			            		'type' => Request('type'),
			            		'spec' => Request('spec'),
			            		'model' => Request('model'),
			            		'brand' => Request('brand'),
			            		'origin' => Request('origin'),
			            		'unit' => Request('unit'),
			            		'pa05_category_id' => $category_id,
                                'note' => Request('note'),
                                'refer_2517' => Request('refer_2517')
			            	]
			            );
	            	}

		            $url = url('/'). '/user/pa05/category_detail/list/'. $category_id;
        			return redirect($url);

	            }elseif (isset($_POST['btnCancel'])){

	            }else{
	            	//Không nhấn nút

		            //Lấy thông tin product group đã pick
		            $selected_group = null;
			        $selected_group = Request('group');

			        $selected_sub_group = null;
			        $selected_sub_group = Request('sub_group');

			        $selected_brand = null;
			        $selected_brand = Request('brands');

		            //Lấy danh sách product group
		            $groupes = DB::table('general_group')
			        ->orderby('order')
			        ->get();

			        $sub_groupes = DB::table('general_sub_group')
			        ->where('general_group_id', $selected_group)
			        ->orderby('order')
			        ->get();

			        //Lấy điều kiện lọc
			        $filters = DB::table('general_filter')
					->where([
			            ['general_sub_group_id', '=', $selected_sub_group]
			        ])
					->get();
			    	
			    	$filter_details = DB::table('general_filter_detail')
			    	->get();

			    	//Lấy hãng
			    	$brands =DB::table('general_product')
					->where([
			           ['general_sub_group_id', '=', $selected_sub_group]
			       	])
			       	->distinct()
					->get('brand');

					$posts = $_POST;

					/////////////////////Kiểm tra filter để lấy product
			        $conditionOr = [];
			        $conditionAnd = [];

			        if ( !is_null($_POST) ){
			        	foreach ($_POST as $key => $value){
				        	if (is_array($value)){
				        		foreach ($value as $v) {
				        			if (str_starts_with($key,'option')){
										array_push(
										    $conditionOr,
										    "(general_filter_detail_id = ". $v . ")"
										);
						        	}
				        		}
				        	}else{
				        		if (str_starts_with($key,'radio')){
					          		array_push(
									    $conditionAnd,
									    "(general_filter_detail_id = ". $value . ")"
									);

					         	}
				        	}
				        }

			            $temp_condition = "
			            	SELECT DISTINCT general_product.id, general_product.name, general_product.brand, general_product.spec, general_product.thumb_image 
			            	FROM general_product LEFT JOIN general_filter_detail_product ON general_product.id = general_filter_detail_product.general_product_id 
			            	WHERE (
			            		(general_product.general_sub_group_id = ". $selected_sub_group. ") 
			            		AND 
			            		(general_product.brand like '%" . $selected_brand . "%')
			            	)
			            ";
			            
			            $condition = "
			            	SELECT p.id, p.name, p.spec, p.brand, p.thumb_image 
			            	FROM general_product p INNER JOIN (". $temp_condition .") AS namecheck ON p.id = namecheck.id
			            ";

				        $found = 0;

				        if (count($conditionOr)>0){		  
				        	// generate name
			                $name = "namecheck";
			                $name_index = 1;
			                do {
			                    $tmp_name = $name . $name_index . " ";
			                    $name_index += 1;
			                }
			                while (str_contains($condition, $tmp_name));
			                $name = $tmp_name;
			                
			                $tmp = $temp_condition . " and (";     
					        foreach ($conditionOr as $item) {
					        	 $tmp = $tmp . $item . " or ";
					        }
					        //$condition = $condition . " ";

					        $tmp = substr($tmp, 0, strlen($tmp)-3);
					        $tmp = $tmp . ") ";

			                $condition = $condition . " INNER JOIN (" . $tmp . ") AS " . $name . " ON p.id = " . $name . ".id";

					        $found = 1;

					    }

					    if (count($conditionAnd)>0){
					    	 	        
					        foreach ($conditionAnd as $item) {
			                    // generate name
			                    $name = "namecheck";
			                    $name_index = 1;
			                    do {
			                        $tmp_name = $name . $name_index . " ";
			                        $name_index += 1;
			                    }
			                    while (str_contains($condition, $tmp_name));
			                    $name = $tmp_name;

			                    $tmp = $temp_condition . " AND (";
					        	$tmp = $tmp . $item . " and ";

			                    $tmp = substr($tmp, 0, strlen($tmp)-4);
			                    $tmp = $tmp . ") ";

			                    $condition = $condition . " INNER JOIN (" . $tmp . ") AS " . $name . " ON p.id = " . $name . ".id";
					        }
					        
					        $found = 1;

					    }

					    if ($found == 0){
					    	//Không có điều kiện filter cả and lẫn or xảy ra, lấy theo category và brand đã chọn
					    	//$posts = null;

					    	$products =DB::table('general_product')
							->where([
					           ['general_sub_group_id', '=', $selected_sub_group],
					           ['brand','like', '%' .$selected_brand. '%']
					       	])
							->get();
					    }else{
					    	//$posts = $_POST;
					    	$products = DB::select($condition);
					    }

					    $posts = $_POST;
			        }else{

			        	$posts = null;

			        	$products =DB::table('general_product')
						->where([
				           ['general_sub_group_id', '=', $selected_sub_group],
				           ['brand','like', '%' .$selectedbrand. '%']
				       	])
						->get();
			        }
			        /////////////////////////////////////////////////////

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
                		'user.pa05.category_detail.create',
                		compact(
                			'sessionuser',
                			'systemconfig',
                			'pa05role',
                			'contract_role',
                			'groupes',
                			'sub_groupes',
                			'selected_group',
                			'selected_sub_group',
                			'filters',
                			'filter_details',
                			'brands',
                			'selected_brand',
                			'posts',
                			'products',
                			'category_id'
                		)
                	);
	            	//Kết thúc không nhấn nút
	            }
	            //
            }else{
            	Session()->flush();
        		return redirect('/');
            }
        }
    }

    //Hiển thị form cập nhật
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

	            $category_detail = DB::table('pa05_category_detail')
	            ->leftjoin('general_product','pa05_category_detail.general_product_id','=','general_product.id')
            	->where('pa05_category_detail.id', $id)
            	->select(
            		'general_product.name as product_name',
            		'pa05_category_detail.no as no',
            		'pa05_category_detail.name as name',
            		'pa05_category_detail.type as type',
            		'pa05_category_detail.model as model',
            		'pa05_category_detail.brand as brand',
            		'pa05_category_detail.origin as origin',
            		'pa05_category_detail.spec as spec',
            		'pa05_category_detail.unit as unit',
            		'pa05_category_detail.id as id',
                    'pa05_category_detail.refer_2517 as refer_2517',
                    'pa05_category_detail.note as note',
            		'pa05_category_detail.pa05_category_id as categoryid'
            	)
	            ->first();

	            //Lấy thông tin product group đã pick
	            $selected_group = null;
		        $selected_group = Request('group');

		        $selected_sub_group = null;
		        $selected_sub_group = Request('sub_group');

	            //Lấy danh sách product group và suub group
	            $groupes = DB::table('general_group')
		        ->orderby('order')
		        ->get();

		        $sub_groupes = DB::table('general_sub_group')
		        ->where('general_group_id', $selected_group)
		        ->orderby('order')
		        ->get();

		        $brands = null;
		        $filters = null;
		        $filter_details = null;
		        $brands = null;
		        $posts = null;
		        $selected_brand = null;
		        $products = null;

		        //

            	return view(
            		'user.pa05.category_detail.edit',
            		compact(
            			'sessionuser',
            			'systemconfig',
            			'pa05role',
            			'contract_role',
            			'category_detail',
            			'groupes',
            			'sub_groupes',
            			'selected_group',
            			'selected_sub_group',
            			'filters',
            			'filter_details',
            			'brands',
            			'selected_brand',
            			'posts',
            			'products'
            		)
            	);
            }else{
            	Session()->flush();
        		return redirect('/');
            }
        }
    }

    //Submit create
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

	            //Check xem có nhấn OK không
	            if (isset($_POST['btnOK'])){
	            	//Update danh mục

	            	if (isset($_POST['product'])){
	            		$product_id = $_POST['product'];
	            		DB::table('pa05_category_detail')
	            		->where('id',$id)
			            ->update(
			            	[
			            		'no' => Request('no'),
			            		'name' => Request('name'),
			            		'type' => Request('type'),
			            		'spec' => Request('spec'),
			            		'model' => Request('model'),
			            		'brand' => Request('brand'),
			            		'origin' => Request('origin'),
			            		'unit' => Request('unit'),
			            		'general_product_id' => $product_id,  ///////////// <---- Khác nhau chỗ này
                                'note' => Request('note'),
                                'refer_2517' => Request('refer_2517')
			            	]
			            );

			            //Có chọn sản phẩm nên sẽ clone luôn giá sản phẩm vào bảng price của danh mục
                        $prices = DB::table('general_product_price')
                        ->where('general_product_id',$product_id)
                        ->get();

                        if (!is_null($prices)){
                            DB::table('pa05_category_detail_price')
                            ->where('pa05_category_detail_id', $id)
                            ->delete();

                            foreach($prices as $price){
                                DB::table('pa05_category_detail_price')
                                ->insert(
                                    [
                                        'pa05_category_detail_id' => $id,
                                        'warranty_year' => $price->warranty_year,
                                        'price' => $price->price
                                    ]
                                );
                            }
                        }

	            	}else{
	            		$product_id = null;
	            		//Chỉ cập nhật nội dung không cập nhật sản phẩm link đến
	            		DB::table('pa05_category_detail')
	            		->where('id',$id)
			            ->update(
			            	[
			            		'no' => Request('no'),
			            		'name' => Request('name'),
			            		'type' => Request('type'),
			            		'spec' => Request('spec'),
			            		'model' => Request('model'),
			            		'brand' => Request('brand'),
			            		'origin' => Request('origin'),
			            		'unit' => Request('unit'),
                                'note' => Request('note'),
                                'refer_2517' => Request('refer_2517')
			            	]
			            );
	            	}

	            	$category_id = DB::table('pa05_category_detail')
	            	->where('id',$id)
	            	->first()
	            	->pa05_category_id;

		            $url = url('/'). '/user/pa05/category_detail/list/'. $category_id;
        			return redirect($url);

	            }elseif (isset($_POST['btnCancel'])){

	            }else{
	            	//Không nhấn nút

		            //Lấy thông tin product group đã pick
		            $selected_group = null;
			        $selected_group = Request('group');

			        $selected_sub_group = null;
			        $selected_sub_group = Request('sub_group');

			        $selected_brand = null;
			        $selected_brand = Request('brands');

		            //Lấy danh sách product group
		            $groupes = DB::table('general_group')
			        ->orderby('order')
			        ->get();

			        $sub_groupes = DB::table('general_sub_group')
			        ->where('general_group_id', $selected_group)
			        ->orderby('order')
			        ->get();

			        //Lấy điều kiện lọc
			        $filters = DB::table('general_filter')
					->where([
			            ['general_sub_group_id', '=', $selected_sub_group]
			        ])
					->get();
			    	
			    	$filter_details = DB::table('general_filter_detail')
			    	->get();

			    	//Lấy hãng
			    	$brands =DB::table('general_product')
					->where([
			           ['general_sub_group_id', '=', $selected_sub_group]
			       	])
			       	->distinct()
					->get('brand');

					$category_detail = DB::table('pa05_category_detail')
		            ->leftjoin('general_product','pa05_category_detail.general_product_id','=','general_product.id')
                	->where('pa05_category_detail.id', $id)
                	->select(
                		'general_product.name as product_name',
                		'pa05_category_detail.no as no',
                		'pa05_category_detail.name as name',
                		'pa05_category_detail.type as type',
                		'pa05_category_detail.model as model',
                		'pa05_category_detail.brand as brand',
                		'pa05_category_detail.origin as origin',
                		'pa05_category_detail.spec as spec',
                		'pa05_category_detail.unit as unit',
                		'pa05_category_detail.id as id',
                        'pa05_category_detail.refer_2517 as refer_2517',
                        'pa05_category_detail.note as note',
                		'pa05_category_detail.pa05_category_id as categoryid'
                	)
		            ->first();

					$posts = $_POST;

					/////////////////////Kiểm tra filter để lấy product
			        $conditionOr = [];
			        $conditionAnd = [];

			        if ( !is_null($_POST) ){
			        	foreach ($_POST as $key => $value){
				        	if (is_array($value)){
				        		foreach ($value as $v) {
				        			if (str_starts_with($key,'option')){
										array_push(
										    $conditionOr,
										    "(general_filter_detail_id = ". $v . ")"
										);
						        	}
				        		}
				        	}else{
				        		if (str_starts_with($key,'radio')){
					          		array_push(
									    $conditionAnd,
									    "(general_filter_detail_id = ". $value . ")"
									);

					         	}
				        	}
				        }

			            $temp_condition = "
			            	SELECT DISTINCT general_product.id, general_product.name, general_product.brand, general_product.spec, general_product.thumb_image 
			            	FROM general_product LEFT JOIN general_filter_detail_product ON general_product.id = general_filter_detail_product.general_product_id 
			            	WHERE (
			            		(general_product.general_sub_group_id = ". $selected_sub_group. ") 
			            		AND 
			            		(general_product.brand like '%" . $selected_brand . "%')
			            	)
			            ";
			            
			            $condition = "
			            	SELECT p.id, p.name, p.spec, p.brand, p.thumb_image 
			            	FROM general_product p INNER JOIN (". $temp_condition .") AS namecheck ON p.id = namecheck.id
			            ";

				        $found = 0;

				        if (count($conditionOr)>0){		  
				        	// generate name
			                $name = "namecheck";
			                $name_index = 1;
			                do {
			                    $tmp_name = $name . $name_index . " ";
			                    $name_index += 1;
			                }
			                while (str_contains($condition, $tmp_name));
			                $name = $tmp_name;
			                
			                $tmp = $temp_condition . " and (";     
					        foreach ($conditionOr as $item) {
					        	 $tmp = $tmp . $item . " or ";
					        }
					        //$condition = $condition . " ";

					        $tmp = substr($tmp, 0, strlen($tmp)-3);
					        $tmp = $tmp . ") ";

			                $condition = $condition . " INNER JOIN (" . $tmp . ") AS " . $name . " ON p.id = " . $name . ".id";

					        $found = 1;

					    }

					    if (count($conditionAnd)>0){
					    	 	        
					        foreach ($conditionAnd as $item) {
			                    // generate name
			                    $name = "namecheck";
			                    $name_index = 1;
			                    do {
			                        $tmp_name = $name . $name_index . " ";
			                        $name_index += 1;
			                    }
			                    while (str_contains($condition, $tmp_name));
			                    $name = $tmp_name;

			                    $tmp = $temp_condition . " AND (";
					        	$tmp = $tmp . $item . " and ";

			                    $tmp = substr($tmp, 0, strlen($tmp)-4);
			                    $tmp = $tmp . ") ";

			                    $condition = $condition . " INNER JOIN (" . $tmp . ") AS " . $name . " ON p.id = " . $name . ".id";
					        }
					        
					        $found = 1;

					    }

					    if ($found == 0){
					    	//Không có điều kiện filter cả and lẫn or xảy ra, lấy theo category và brand đã chọn
					    	//$posts = null;

					    	$products =DB::table('general_product')
							->where([
					           ['general_sub_group_id', '=', $selected_sub_group],
					           ['brand','like', '%' .$selected_brand. '%']
					       	])
							->get();
					    }else{
					    	//$posts = $_POST;
					    	$products = DB::select($condition);
					    }

					    $posts = $_POST;
			        }else{

			        	$posts = null;

			        	$products =DB::table('general_product')
						->where([
				           ['general_sub_group_id', '=', $selected_sub_group],
				           ['brand','like', '%' .$selectedbrand. '%']
				       	])
						->get();
			        }
			        /////////////////////////////////////////////////////

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
                		'user.pa05.category_detail.edit',
                		compact(
                			'sessionuser',
                			'systemconfig',
                			'pa05role',
                			'contract_role',
                			'groupes',
                			'sub_groupes',
                			'selected_group',
                			'selected_sub_group',
                			'filters',
                			'filter_details',
                			'brands',
                			'selected_brand',
                			'posts',
                			'products',
                			'category_detail'
                		)
                	);
	            	//Kết thúc không nhấn nút
	            }
	            //
            }else{
            	Session()->flush();
        		return redirect('/');
            }
        }
    }

    //Liệt kê giá của một danh mục dùng chung
    public function price_list($category_detail_id){
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

                $category_detail = DB::table('pa05_category_detail')
                ->leftjoin('general_product','pa05_category_detail.general_product_id','=','general_product.id')
                ->where('pa05_category_detail.id', $category_detail_id)
                ->select(
                    'general_product.name as product_name',
                    'pa05_category_detail.name as name',
                    'pa05_category_detail.model as model',
                    'pa05_category_detail.brand as brand',
                    'pa05_category_detail.origin as origin',
                    'pa05_category_detail.spec as spec',
                    'pa05_category_detail.unit as unit',
                    'pa05_category_detail.refer_2517 as refer_2517',
                    'pa05_category_detail.note as note',
                    'pa05_category_detail.id as id',
                    'pa05_category_detail.pa05_category_id as category_id'
                )
                ->first();

                $prices = DB::table('pa05_category_detail_price')
                ->where('pa05_category_detail_id',$category_detail_id)
                ->get();

                return view('user.pa05.category_detail.price_list',compact('sessionuser','systemconfig','pa05role','contract_role','category_detail','prices'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Hiển thị form nhập thêm giá
    public function price_create($category_detail_id){
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
                return view('user.pa05.category_detail.price_create',compact('sessionuser','systemconfig','pa05role','contract_role','category_detail_id'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Submit thêm giá cho danh mục dùng chung
    public function price_create_submit($category_detail_id){
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

                $idforlog=DB::table('pa05_category_detail_price')
                ->insertgetid(
                    [
                        'pa05_category_detail_id' => $category_detail_id,
                        'warranty_year' => Request('warranty_year'),
                        'price' => $price
                    ]
                );

                $url = url('/'). '/user/pa05/category_detail/price_list/'. $category_detail_id;
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Reset lại giá từ giá sản phẩm
    public function price_reset($category_detail_id){
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

                $productid = DB::table('pa05_category_detail')
                ->where('id',$category_detail_id)
                ->first()
                ->general_product_id;

                $prices = DB::table('general_product_price')
                ->where('general_product_id',$productid)
                ->get();

                if (!is_null($prices)){

                    DB::table('pa05_category_detail_price')
                    ->where('pa05_category_detail_id', $category_detail_id)
                    ->delete();

                    foreach($prices as $price){
                        DB::table('pa05_category_detail_price')
                        ->insert(
                            [
                                'pa05_category_detail_id' => $category_detail_id,
                                'warranty_year' => $price->warranty_year,
                                'price' => $price->price
                            ]
                        );
                    }

                }

                $url = url('/'). '/user/pa05/category_detail/price_list/'. $category_detail_id;
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Hiện form sửa giá cho danh mục dùng chung
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
                $price = DB::table('pa05_category_detail_price')
                ->where('id',$id)
                ->first();

                return view('user.pa05.category_detail.price_edit',compact('sessionuser','systemconfig','pa05role','contract_role','price'));
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Submit sửa giá tiền của danh mục dùng chung
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

                DB::table('pa05_category_detail_price')
                ->where('id',$id)
                ->update(
                    [
                        'warranty_year' => Request('warranty_year'),
                        'price' => $price
                    ]
                );

                $categoryid = DB::table('pa05_category_detail_price')
                ->where('id',$id)
                ->first()
                ->pa05_category_detail_id;

                $url = url('/'). '/user/pa05/category_detail/price_list/'. $categoryid;
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Xóa giá
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

                $categoryid = DB::table('pa05_category_detail_price')
                ->where('id',$id)
                ->first()
                ->pa05_category_detail_id;

                DB::table('pa05_category_detail_price')
                ->where('id',$id)
                ->delete();


                $url = url('/'). '/user/pa05/category_detail/price_list/'. $categoryid;
                return redirect($url);
            }else{
                Session()->flush();
                return redirect('/');
            }
        }
    }

    //Xem chi tiết 1 hạng mục thuộc danh mục dùng chung
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

            if ($pa05role=='pm' || $pa05role=='edit'){

	            $category_detail = DB::table('pa05_category_detail')
	            ->leftjoin('general_product','pa05_category_detail.general_product_id','=','general_product.id')
            	->where('pa05_category_detail.id', $id)
            	->select(
            		'general_product.name as product_name',
            		'pa05_category_detail.name as name',
            		'pa05_category_detail.model as model',
            		'pa05_category_detail.brand as brand',
            		'pa05_category_detail.origin as origin',
            		'pa05_category_detail.spec as spec',
            		'pa05_category_detail.unit as unit',
            		'pa05_category_detail.note as note',
                    'pa05_category_detail.refer_2517 as refer_2517',
            		'pa05_category_detail.id as id',
            		'pa05_category_detail.pa05_category_id as category_id'
            	)
	            ->first();

                $prices = DB::table('pa05_category_detail_price')
                ->where('pa05_category_detail_id',$id)
                ->get();

            	return view('user.pa05.category_detail.view',compact('sessionuser','systemconfig','pa05role','contract_role','category_detail','prices'));
            }else{
            	Session()->flush();
        		return redirect('/');
            }
        }
    }

    //Xóa hạng mục của danh mục dùng chung
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
            	//Lấy category id để quay lại
            	$categoryid = DB::table('pa05_category_detail')
	            ->where([
	                ['id', '=', $id]
	            ])
	            ->first()
	            ->pa05_category_id;

            	//Xóa
                DB::table('pa05_category_detail_price')
                ->where('pa05_category_detail_id',$id)
                ->delete();

            	DB::table('pa05_category_detail')
	            ->where([
	                ['id', '=', $id]
	            ])
	            ->delete();

            	//Quay lại
            	$url = url('/'). '/user/pa05/category_detail/list/'. $categoryid;
        		return redirect($url);

	        }else{
	        	Session()->flush();
        		return redirect('/');
	        }
 		}
 	}
}
