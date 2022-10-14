<?php

namespace App\Exports;

use DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataExport implements FromCollection, WithColumnFormatting, WithColumnWidths, WithStyles
{

	use Exportable;

	public function __construct(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function collection()
    {
        $year_details = DB::table('pa05_year_detail')
        ->leftjoin('general_product', 'pa05_year_detail.general_product_id', 'general_product.id')
        ->where('pa05_year_detail.pa05_year_id', $this->id)
        ->orderby('pa05_year_detail.order_no')
        ->select(
            'pa05_year_detail.no as no',
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
            'pa05_year_detail.spec as spec',
            'pa05_year_detail.type as type',
            'pa05_year_detail.pa05_year_id as pa05_year_id',
            'general_product.name as product_name'
        )
        ->get();

        $data = array(array());
        //Tạo heading
        $row = array();
	    $row['no'] = 'STT';
	    $row['name'] = 'Hạng mục';
	    $row['brand'] = 'Hãng/model/xuất xứ';
	    $row['unit'] = 'Đơn vị tính';
	    $row['unit_price'] = 'Đơn giá';
	    $row['quantity'] = 'Số lượng';
	    $row['sub_total'] = 'Trước VAT';
	    $row['vat'] = 'VAT';
	    $row['total'] = 'Thành tiền sau VAT';
	    $data[] = $row;

        foreach($year_details as $year_detail)
		{
		    if ($year_detail->type=='heading'){
		    	///////////////////////////////////
		    	$row = array();
			    $row['no'] = $year_detail->no;
			    $row['name'] = $year_detail->name;
			    $row['brand'] = '';
			    $row['unit'] = '';
			    $row['unit_price'] = '';
			    $row['quantity'] = '';
			    $row['sub_total'] = '';
			    $row['vat'] = '';
			    $row['total'] = '';
			    $data[] = $row;
		    	//////////////////////////////////
		    }else{
		    	//////////////////////////////////
		    	$row = array();
			    $row['no'] = $year_detail->no;
			    $row['name'] = $year_detail->name;
			    $row['brand'] = '- Hãng: ' . $year_detail->brand . PHP_EOL . '- Model: ' . $year_detail->model . PHP_EOL . '- Xuất xứ: ' . $year_detail->origin;
			    $row['unit'] = $year_detail->unit;
			    $row['unit_price'] = $year_detail->unit_price;
			    $row['quantity'] = $year_detail->quantity;
			    $row['sub_total'] = $year_detail->sub_total;
			    $row['vat'] = '='. $year_detail->sub_total . '*' . $year_detail->vat . '/100';
			    $row['total'] = $year_detail->total;
			    $data[] = $row;

			    if (!is_null($year_detail->spec)){
			    	$spec_arr = preg_split("/\r\n|\n|\r/", $year_detail->spec);

			    	if (count($spec_arr)>0){
			    		foreach($spec_arr as $item){
			    			$row = array();
						    $row['no'] = '';
						    $row['name'] = $item;
						    $row['brand'] = '';
						    $row['unit'] = '';
						    $row['unit_price'] = '';
						    $row['quantity'] = '';
						    $row['sub_total'] = '';
						    $row['total'] = '';
						    $row['vat'] = '';
						    $data[] = $row;
			    		}
			    	}
			    }
		    	///////////////////////////////////////
		    }
		    
		}

		return collect($data);

    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' =>  "#,##0.00_-",
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' =>  "#,##0.00_-",
            'H' =>  "#,##0.00_-",
            'I' =>  "#,##0.00_-"
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 55,     
            'C' => 45,
            'D' => 16,
            'E' => 16,
            'F' => 16,    
            'G' => 16,
            'H' => 16,
            'I' => 20
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            'A'    => ['alignment' => ['horizontal' => 'center']],
            'C'    => ['alignment' => ['wrapText' => true]],
            'E'    => ['alignment' => ['horizontal' => 'right']],
            'F'    => ['alignment' => ['horizontal' => 'center']],
            'G'    => ['alignment' => ['horizontal' => 'right']],
            'H'    => ['alignment' => ['horizontal' => 'right']],
            'I'    => ['alignment' => ['horizontal' => 'right']]
        ];
    }

}