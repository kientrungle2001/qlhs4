<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PzkHomeController extends PzkController {
	public $masterPage = 'index';
	public $masterPosition = 'left';
	public function indexAction() {
		$this->viewGrid('customer_thap2');
	}

	public function excelAction() {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		$array = array(
			array(
				"id" => 1,
				"name" => 'Kien',
				"birthdate" => new DateTime('09/22/1986'),
				'height' => 1.75,
				'is_male' => true
			),
			array(
				"id" => 2,
				"name" => "Hang",
				"birthdate" => new DateTime('04/25/1986'),
				'height' => 1.65,
				'is_male' => false
			)
		);
		
		array_to_sheet($array, $sheet);

		$writer = new Xlsx($spreadsheet);
		$writer->save(BASE_DIR . '/cache/hello_world.xlsx');		
	}

	public function readAction() {
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load(BASE_DIR . '/cache/hello_world.xlsx');
		$sheet = $spreadsheet->getActiveSheet();
		echo '<pre>';
		print_r($sheet->toArray(null, true, true, true));
	}
}

function array_to_sheet(&$array, &$sheet) {
	
	$columns = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
	$columnIndex = 0;
	$person = $array[0];	
	foreach($person as $prop => $value) {
		$sheet->setCellValue($columns[$columnIndex] . 1, $prop);
		$sheet->getStyle($columns[$columnIndex] . 1)->getFont()->setBold(true);
		$columnIndex++;
	}

	foreach($array as $index => $person) {
		$columnIndex = 0;
		foreach($person as $prop => $value) {
			if(is_a($value, 'DateTime')) {
				$sheet->setCellValue($columns[$columnIndex] . ($index + 2),'= datevalue("'. $value->format('m/d/Y') . '")');
			} else {
				$sheet->setCellValue($columns[$columnIndex] . ($index + 2), $value);
			}
			
			$columnIndex++;
		}
	}
}