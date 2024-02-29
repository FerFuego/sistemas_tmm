<?php

namespace App\Http\Controllers;

use Excel;
use App\User;
use App\Value;
use App\Measurement;
use App\BranchOffice;
use Illuminate\Http\Request;
use PHPExcel_Worksheet_Drawing;
use Illuminate\Support\Facades\Redirect;

class ExcelController extends Controller{

	public function exportMeasurement($idu, $ids, $type, $idm){


		$user = User::findOrFail($idu);
		$meas = Measurement::findOrFail($idm);
		$branch = BranchOffice::findOrFail($meas->idbranch_office);
		$value = Value::where('idmeasurements', $idm)->get();


		if($type == 'pat'){
			Excel::create('Pat_Data', function($excel) use($value, $meas) {

			    $excel->sheet('Sheetname', function($sheet) use($value, $meas) {

					$sheet->row(1, [
						'Número de puesta a tierra',
						'Sector',
						'Descripción del lugar',
						'Valor obtenido en la medición expresado en ohm (Ω)'
					]);

					$x = 1;

					foreach($value as $index => $val) {
						$sheet->row($index+2, [
							'PAT_'.$x,
							$val->sector,
							$val->details,
							($val->equivalence) ? $val->equivalence : $val->value,
						]);
						$x++;
					}
			    });
			})->export('xls');
		}//endif

		if($type == 'continuidad'){
			Excel::create('Continuidad_Data', function($excel) use($value, $meas) {

			    $excel->sheet('Sheetname', function($sheet) use($value, $meas) {

					$sheet->row(1, [
						'Número de continuidad',
						'Sector',
						'Descripción del lugar',
						'Valor obtenido en la medición expresado en ohm (Ω)'
					]);


					$x = 1;
					foreach($value as $index => $val) {

						$total = '';
						foreach(json_decode($val->value, true) as $a){
							$total .= ((isset($a[3]) && !is_null($a[3])) ? $a[3] : $a[0]).'/';
	                    }

						$sheet->row($index+2, [
							'C_'.$x,
							$val->sector,
							$val->details,
							$total,
						]);
						$x++;
					}
			    });
			})->export('xls');
		}//endif

		if($type == 'diferencial'){
			Excel::create('Diferencial_Data', function($excel) use($value, $meas) {

			    $excel->sheet('Sheetname', function($sheet) use($value, $meas) {

					$sheet->row(1, [
						'Número de diferencial',
						'Sector',
						'Descripción del lugar',
						'Valor obtenido en la medición expresado en ms'
					]);


					$x = 1;
					foreach($value as $index => $val) {

						$total = '';
						foreach(json_decode($val->value, true) as $a){
							$total .= $a[0].'/';
	                    }

						$sheet->row($index+2, [
							'D_'.$x,
							$val->sector,
							$val->details,
							$total,
						]);
						$x++;
					}
			    });
			})->export('xls');
		}//endif

		if($type == 'termografia'){
			Excel::create('Termografia_Data', function($excel) use($value, $meas) {

			    $excel->sheet('Sheetname', function($sheet) use($value, $meas) {

			    	$sheet->setAllBorders('thin');

			    	$sheet->row(1, [
			    		'TERMOGRAFÍA INFRAROJA',
			    	])->mergeCells('A1:C1');

			    	$sheet->setHeight(array(1=>30,7=>30)); //altura de celdas

			    	$sheet->cell('A1:C1', function($cell) {
					    $cell->setValue('TERMOGRAFÍA INFRAROJA');
					    $cell->setFont(array('family'=>'Calibri','size'=>'16','bold'=>true));
					    $cell->setValignment('center');
					    $cell->setAlignment('center');
					    $cell->setBackground('#aaaaaa');
					});

					$sheet->row(2,['Empresa:'])->mergeCells('B2:D2');
					$sheet->row(3,['Fecha:'])->mergeCells('B3:D3');

					$sheet->cell('A2', function($cell) {
					    $cell->setBackground('#aaaaaa');
					});

					$sheet->cell('A3', function($cell) {
					    $cell->setBackground('#aaaaaa');
					});

		    		$objDrawing = new PHPExcel_Worksheet_Drawing();
		            $objDrawing->setPath('./images/logo-black.png'); //your image path
		            $objDrawing->setCoordinates('D1');
		            $objDrawing->setWidth('100');
		            $objDrawing->setWorksheet($sheet);

					$sheet->row(7, [
						'Analisis Nro',
						'Nº de imágen',
						'Detalle',
						'Descripción'
					]);

					$sheet->cell('A7:D7', function($cell) {
					    $cell->setValignment('center');
					    $cell->setAlignment('center');
					    $cell->setBackground('#aaaaaa');
					});

					$x = 1;

					foreach($value as $index => $v) {

                        // if(strpos($val->observation,'[')!==false){
                        //     $string=false;
                        //     foreach(json_decode($val->observation, true) as $obs){
                        //         $string .= "- ".$obs."\n";
                        //     }
                        // }else{
                        //     $string=json_decode($val->observation);
                        // }


                        if(strpos($v->recommendation,'[')!==false){
                            $string=false;
                            foreach(json_decode($v->recommendation, true) as $obs){
                                $string .= "- ".$obs."\n";
                            }
                        }else{
                            $string=json_decode($v->recommendation);
                        }
                                                
                        if($v->other){
                          $other = "- ". $v->other;
                        }else{
                        	$other = '';
                        }
                        

						$imagen = str_replace('.jpg', '', $v->image_1);
						$imagen = str_replace('.png', '', $imagen);
						$sheet->row($index+8, [
							$x,
							$imagen,
							$v->title,
							$string. " \n\r " .$other
						]);
						$x++;
					}
			    });
			})->export('xls');
		}//endif
    }

}
