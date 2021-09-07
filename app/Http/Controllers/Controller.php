<?php

namespace App\Http\Controllers;

ini_set('max_execution_time','30000');
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Style_Border;
use DateTime;
use Session;
use App\BankwideTrialbalance;
use App\BranchCodes;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function DateFormat($date)
    {
        $formatted_date = \PHPExcel_Style_NumberFormat::toFormattedString($date,'YYYY-MM-DD');
        return $formatted_date;
    }

    public function tb (Request $request)
    {
        $excel = new \PHPExcel();
        
        $excel = \PHPExcel_IOFactory::load($request->file('file'));
        
        DB::table('bankwide_trialbalances')->delete();
        $excel->setActiveSheetIndex(0);
        $excel = $excel->getActiveSheet();
        $column_identifier = array("A", "B", "C", "D", "E", "F", "G", "H","I");
        $row = $excel->getHighestRow();
        //dd($row);
            
            for ($i=2; $i <= $row; $i++) { 
                $table = new BankwideTrialbalance();
                $table->class = $excel->getCell($column_identifier[0].$i)->getValue();
                $table->date = $this->DateFormat($excel->getCell($column_identifier[1].$i)->getValue());
                $table->curr_code = $excel->getCell($column_identifier[2].$i)->getValue();
                $table->bra_code = $excel->getCell($column_identifier[3].$i)->getValue();
                $table->branch_name = $excel->getCell($column_identifier[4].$i)->getValue();
                $table->state = $excel->getCell($column_identifier[5].$i)->getValue();
                $table->led_code = $excel->getCell($column_identifier[6].$i)->getValue();
                $table->description = $excel->getCell($column_identifier[7].$i)->getValue();
                $table->amount = $excel->getCell($column_identifier[8].$i)->getValue();
                $table->save();
            }
            return redirect()->back()->with('success', 'Upload of Trial Balance was Successful');   
    }

    public function sb (Request $request)
    {
        $excel = new \PHPExcel();
        $excel = \PHPExcel_IOFactory::load($request->file('file'));
        
        DB::table('branch_codes')->delete();
        $excel->setActiveSheetIndex(0);
        $excel = $excel->getActiveSheet();
        $column_identifier = array("A", "B");
        $row = $excel->getHighestRow();
        //dd($row);
            
            for ($i=2; $i <= $row; $i++) { 
                $table = new BranchCodes();
                $table->state = $excel->getCell($column_identifier[0].$i)->getValue();
                $table->bra_code = $excel->getCell($column_identifier[1].$i)->getValue();
                $table->save();
            }
        return view('welcomme')->with('message',$row.'rows of data was successfully uploaded!');

    }

    public function export (Request $request)
    {
        $excel = new \PHPExcel();
        
        $state = $request->state;
        $table = new BranchCodes();
        $bra_codes = $table->where('state',$state)->get();
        //dd($state);
        $sheet = 0;
        $table = new BankwideTrialbalance();
            // $data = $table->sum('amount');
            // dd($data);
        //$bra_num = count($bra_codes);
        
        foreach ($bra_codes as $bra_code) {
            $excel->createSheet();
            $excel->setActiveSheetIndex($sheet);
            $table = new BankwideTrialbalance();
            
            $data = $table->where('bra_code', $bra_code->bra_code)->orderBy('class', 'asc')->get();
            
            $excel->getActiveSheet()->setTitle($bra_code->bra_code);
            $i = 2;
            foreach ($data as $data) {
                if ($data->class == "ASSET" || $data->class == "EXPENSE") {
                    $excel->getActiveSheet()
                    ->setCellvalue('A'.$i, $data->class)
                    ->setCellvalue('B'.$i, date('m/d/Y', strtotime($data->date)))
                    ->setCellvalue('C'.$i, $data->curr_code)
                    ->setCellvalue('D'.$i, $data->bra_code)
                    ->setCellvalue('E'.$i, $data->branch_name)
                    ->setCellvalue('F'.$i, $data->state)
                    ->setCellvalue('G'.$i, $data->led_code)
                    ->setCellvalue('H'.$i, $data->description)
                    ->setCellvalue('I'.$i, $data->amount);
    
                    $i++;    
                }
            }

            $excel->getActiveSheet()
            ->setCellvalue('A1', 'CLASS')
            ->setCellvalue('B1', 'ACCT_DATE')
            ->setCellvalue('C1', 'CUR_CODE')
            ->setCellvalue('D1', 'BRA_CODE')
            ->setCellvalue('E1', 'BRANCH_NAME')
            ->setCellvalue('F1', 'STATE')
            ->setCellvalue('G1', 'LED_CODE')
            ->setCellvalue('H1', 'DESCRIPTION')
            ->setCellvalue('I1', 'AMOUNT');

            $excel->getActiveSheet()
                ->getStyle('A1:I1')->applyFromArray(
                    array(
                        'font'=>array(
                            'bold'=>true,
                            'size'=>11,
                        )
                    )
                );

            $asset = $i+2;
            $excel->getActiveSheet()->setCellvalue('I'.$asset, '=SUM(I2:I'.$i.')');


            
            $data = $table->where('bra_code', $bra_code->bra_code)->orderBy('class', 'asc')->get();
            $j = $start = $i+6;
            $k = $j -1;
            $excel->getActiveSheet()
            ->setCellvalue('A'.$k, 'CLASS')
            ->setCellvalue('B'.$k, 'ACCT_DATE')
            ->setCellvalue('C'.$k, 'CUR_CODE')
            ->setCellvalue('D'.$k, 'BRA_CODE')
            ->setCellvalue('E'.$k, 'BRANCH_NAME')
            ->setCellvalue('F'.$k, 'STATE')
            ->setCellvalue('G'.$k, 'LED_CODE')
            ->setCellvalue('H'.$k, 'DESCRIPTION')
            ->setCellvalue('I'.$k, 'AMOUNT');
            
            $excel->getActiveSheet()
            ->getStyle('A'.$k.':I'.$k)->applyFromArray(
                array(
                    'font'=>array(
                        'bold'=>true,
                        'size'=>11,
                    )
                )
            );
            foreach ($data as $data) {
                
                if ($data->class == "INCOME" || $data->class == "LIABILITY") {
                    $excel->getActiveSheet()
                    ->setCellvalue('A'.$j, $data->class)
                    ->setCellvalue('B'.$j, date('m/d/Y', strtotime($data->date)))
                    ->setCellvalue('C'.$j, $data->curr_code)
                    ->setCellvalue('D'.$j, $data->bra_code)
                    ->setCellvalue('E'.$j, $data->branch_name)
                    ->setCellvalue('F'.$j, $data->state)
                    ->setCellvalue('G'.$j, $data->led_code)
                    ->setCellvalue('H'.$j, $data->description)
                    ->setCellvalue('I'.$j, $data->amount);
    
                    $j++;    
                }
            }
            
            $liability = $j+2;
            $excel->getActiveSheet()->setCellvalue('I'.$liability, '=SUM(I'.$start.':I'.$j.')');
            $sum = $j+4; 
            
            $excel->getActiveSheet()->setCellvalue('I'.$sum, '=I'.$asset.'+I'.$liability);
            
            $sheet++;

            //GENERAL FORMATTING
        $excel->getActiveSheet()
        ->getStyle('I'.$liability.':I'.$sum)->applyFromArray(
            array(
                'font'=>array(
                    'bold'=>true,
                )
            )
        );

        $excel->getActiveSheet()
        ->getStyle('A1:I1')->applyFromArray(
            array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            )
        );

        $excel->getActiveSheet()
        ->getStyle('A'.$k.':I'.$k)->applyFromArray(
            array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            )
        );

        $excel->getActiveSheet()
        ->getStyle('I'.$asset)->applyFromArray(
            array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            )
        );

        $excel->getActiveSheet()
        ->getStyle('I'.$liability)->applyFromArray(
            array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            )
        );

        $excel->getActiveSheet()
        ->getStyle('I'.$sum)->applyFromArray(
            array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                    )
                )
            )
        );

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth('9');
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth('13');
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth('13');
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth('13');
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth('9');
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth('10');
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth('40');
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth('17');

        $excel->getActiveSheet()->getStyle('I2:I'.$sum)->getNumberFormat()->setFormatCode('#,##0.00');
        
            
        }

        //REMOVE THE EXTRA WORKSHEET CREATED.
        $sheetCount = $excel->getSheetCount();
        $lastSheet = $sheetCount - 1;
        $excel->removeSheetByIndex($lastSheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= "'.$state.'".xlsx"');
        header('Cache-Control: max-age=0');
        //ob_end_clean();
        $file = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $file->setPreCalculateFormulas(true);
        $file->save('php://output');
        $excel->removeSheetByIndex(0);
    }
}
