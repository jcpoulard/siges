<?php
 /*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    SIGES is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SIGES.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */




// always load alternative config file for examples
//require_once('/../extensions/tcpdf/config/tcpdf_config.php');
// Include the main TCPDF library (search for installation path).
//require_once('/../extensions/tcpdf/tcpdf.php');

Yii::import('ext.tcpdf.*');



class ReportsController extends Controller
{
	
	
	
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	public $start_date;
	public $end_date;
	public $displayButton = false;
	
	public $payroll_month;
	
	
	
	
	public $part;	
	public $pathLink="";
	public $allowLink=false;
	
	    
	
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	public function accessRules()
	{
		    
		  $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
            $controller=$explode_url[3];
            //print_r($explode_url);
            $actions=$this->getRulesArray($this->module->name,$controller);
              
            if($this->getModuleName($this->module->name))
                {
		            if($actions!=null)
             			 {     return array(
				              	  	array('allow',  
					                	
					                	'actions'=> $actions,
		                                  'users'=>array(Yii::app()->user->name),
				                    	),
				              		  array('deny',  
					                 	'users'=>array('*'),
				                    ),
			                );
             			 }
             			 else
             			  return array(array('deny', 'users'=>array('*')),);
                }
                else
                {
                    return array(array('deny', 'users'=>array('*')),);
                }
             



	}

	
public function actionEtatF()
  {
        $acad=Yii::app()->session['currentId_academic_year'];
        
                $model = new Reports();
                
                $this->part = 'etatf';	
                
       $this->start_date =null;
       $this->end_date =null;
       
		       if(isset($_POST['go']))
				{
				   $this->displayButton =false;
				   
				   $this->start_date=$_POST['Reports']['start_date'];
				   $this->end_date=$_POST['Reports']['end_date'];
		          
				}
		     elseif(isset($_POST['createPDF']))
				{
	                  	 $this->start_date=$_POST['Reports']['start_date'];
		                 $this->end_date=$_POST['Reports']['end_date'];

								// create new PDF document
								$pdf = new tcpdf('L', PDF_UNIT, 'legal', true, 'UTF-8', false); // letter: 216x279 mm ; legal: 216x356;  612.000, 1008.00 ; 11.00x17.00 :279x432 mm

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								//Extract school name 
								 $school_name = infoGeneralConfig('school_name');
     						   //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
      							   //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
    					     //Extract Phone Number
                                 $school_phone_number = infoGeneralConfig('school_phone_number');				   								//									Extract Code1 Number
                                 $school_code1 = infoGeneralConfig('code1');
				   								//Extract Code2(11 digit) Number
                                 $school_code2 = infoGeneralConfig('code2');
				   								//Extract school Licence Number
                                 $school_licence_number = infoGeneralConfig('school_licence_number');
				   								//Extract school Director
                                  $school_director_name = infoGeneralConfig('school_director_name');
                                                               
                                                                                             
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app','Financial statement'));
								$pdf->SetSubject(Yii::t('app','Financial statement'));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, 27, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetMargins(10, 7,10 );
								$pdf->SetHeaderMargin(1); //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
/*
								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
*/
								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 13, '', true);

						 
	 
														                
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();

								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print
					$html = <<<EOD
 <style>
	
	div.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		font-size: 18px;
		width:100%;
		text-align: center;
		line-height:15px;
		
	}
	
  span.title {
		font-weight:bold;
	    font-family:Helvetica, sans-serif;
		font-size: 13px;
		text-align: center;
	}

	
	div.info {
		float:left;
		font-size:10pt;
		margin-top:10px;
		margin-bottom:5px;
		
	}
	
	
	
	
	tr.color1 {
		background-color:#F5F6F7; 
		
	}
	
	tr.color2 {
		background-color:#efefef; 
		
	}
	
	td.couleur1 {
		background-color:#F5F6F7; 
				
	}
	
	td.couleur2 {
		background-color:#efefef;  
		
	}
	
		
	
	tr.tr_body {
		border:1px solid #DDDDDD;
	   
	  }
	
	td.header_first{
		border-left:0px solid #FFFFFF; 
		border-bottom:0px solid #FFFFFF;
		border-top:0px solid #FFFFFF;
		
		font-weight:bold;
		width:33px;
		
		
	   }
	   
	 td.header_first1{
		border-left:2px solid #DDDDDD; 
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:123px;
		background-color:#E4E9EF;
	   }
	
	td.header_special1{
		border-right:2px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:205px;
		background-color:#E4E9EF;
		
	   }
	td.header_special2{
		border-right:2px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:270px;
		background-color:#E4E9EF;
		
	   }
	   
	td.header_special3{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:95px;
		background-color:#E4E9EF;
	   }
	   
	
	   
	 td.header{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:80px;
		background-color:#E4E9EF;
	   }
	   
	td.header_prenom{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:145px;
		background-color:#E4E9EF;
	   }

   td.header_prenom_m{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:125px;
		background-color:#E4E9EF;
	   }
	  
	td.header_sexe{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:40px;
		background-color:#E4E9EF;
	   }

     td.data {
		border:1px solid #DDDDDD; 
		border-right:2px solid #DDDDDD;
	
	  }
	  
	  td.data_sexe {
		border:1px solid #DDDDDD; 
		border-right:2px solid #DDDDDD;
	    width:40px;
	  }
	  
	td.data_last {
		border:1px solid #DDDDDD; 
		
	  }
	td.no_border{
		border:0px solid #FFFFFF;
		}
		
    td.div.pad{
    	padding-left:10px;
    	margin-left:20px;
    	}
    td.code{
    	width:280px; 
    	font-weight:bold;
    	}
    	
    span.code{
    	font-size:14px; 
    	}
    	
    span.licence{
    	font-size:14px;
    	}
    	
    td.director{
    	width:360px;  
    	font-weight:bold; 
    	}
    	
     td.space{
    	width:660px;  
    	 
    	}
    	
    td.diege_district{
    	width:200px;  
    	font-weight:bold;   
    	}
    	
    span.section{
    	font-size:18px; 
    	}
	
</style>
                                       
										
EOD;
	   //pou antet
	   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
	   $acad =Yii::app()->session['currentId_academic_year'];
	   $acad_name=Yii::app()->session['currentName_academic_year'];
	   $acad_name_ = strtr( $acad_name, pa_daksan() );
	  
	  $currency_name = Yii::app()->session['currencyName'];
      $currency_symbol = Yii::app()->session['currencySymbol']; 


     if($acad!=$current_acad->id)
         $condition = '';
      else
         $condition = 'p.active IN(1,2) AND ';
      
 
	 
	 $start_month2 = null;
		 $end_month2 = null;
		 $start_year1 = null;
		 $start_year2 = null;
		 
		 $end_year1 = null;
		 
		 $end_date1 = null;                
		 $start_date1 = null;
		 
		 
		 
		 $column_number_part1=0;
		 $column_number_part2=0;
		 $column_number = 0;
		 $total_revenu = 0;
		 $start_month = getMonth($this->start_date);
		 $end_month = getMonth($this->end_date);
		 
		 $start_year1 = getYear($this->start_date);
		 $end_year1 = getYear($this->end_date);
		 
		 if($start_year1!=$end_year1)
		   {
		   	  $end_date1 = $start_year1.'-12-01';                
		   	  $start_date1 = $end_year1.'-01-01';
		   	                 
		   	}
		 
  
	
	
	
	//Extract school name 
								 $school_name = infoGeneralConfig('school_name');
        //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
         //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
         //Extract Phone Number
                                 $school_phone_number = infoGeneralConfig('school_phone_number');







  
              $html .='<div id="print_receipt" style="float:left;   border:1px solid #EDF1F6; width:98%; ">';
                 
                        
                            
                             $html .='<div class="info title" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Financial statement'), pa_daksan() )).'</b>  </div> '; 
			
			$html .='<br/>';
                


		 $html .='<table style="width:88%; font-size:12px; background-color:#F4F6F6;">
		           <tr>
		               <td style=" width:23%; "></td>';
		                                	
		 if($end_date1!=null)
		   {
		   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
		                 { 
		                 	$column_number_part1++;
		                 	$column_number++;
		                 	$html .='<td style=" text-align:right; background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.getShortMonth($i).'. '.substr(getYear($end_date1), 2).'</b></td>';
		                 	
		                 	} 
		       for($i= getMonth($start_date1); $i<=$end_month; $i++)
		                 { 
		                 	$column_number_part2++;
		                 	$column_number++;
		                 	$html .='<td style="text-align:right;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.getShortMonth($i).'. '.substr(getYear($start_date1), 2).'</b></td>';
		                 	
		                 	} 
		   	}
		  else
		    {
		         for($i=$start_month; $i<=$end_month; $i++)
		                 { 
		                 	$column_number++;
		                 	$html .='<td style=" text-align:right; background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.getShortMonth($i).'. '.substr(getYear($this->start_date), 2).'</b></td>';
		                 	
		                 	} 	
		      }

        if($column_number>1)
          {
          	$column_number++;
          	   $html .='<td style="text-align:right;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.Yii::t('app','Total').'</b></td>';
          	
          	}


		  $html .='  </tr>';

$grand_total_revenu = array($column_number);
//initialiser $grand_total_revenu
for($i=0; $i< $column_number; $i++)
  { 
  	  $grand_total_revenu[$i] = 0;
  	}
		  
		  $html .='<tr style="font-style: italic; background-color: #F1F1F1;" ><td ><b>'.strtoupper(strtr(Yii::t('app','Income'), pa_daksan() )).'</b></td><td colspan='.$column_number.'></td></tr>'; 
		 $label_income = Reports::getIncomeLabel();
		 $html .='<tr>'; 
		   	         $html .='<td style="width:23%; border-bottom: 1px solid #ecedf4; ">'.Yii::t('app','Tuition fees').'</td>';
		   	         
		   	          if($end_date1!=null)
					   {
					   	   $col=0;
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					                 { 
					                 	
					                 	$tuition_amount = 0;
						                 	
						                 	if($i==getMonth($this->start_date))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $tuition_amount = Reports::getTotalAmountForTuitionByDateStartAndMonth($this->start_date, $i);
						                 	  	  foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;" >'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($end_date1))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByDateEndAndMonth($end_date1, $i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByMonth($i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}

					                $col++; 	
					                 	} 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					                 { 
					                 	$tuition_amount = 0;
						                 	
						                 	if($i==getMonth($start_date1))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $tuition_amount = Reports::getTotalAmountForTuitionByDateStartAndMonth($start_date1, $i);
						                 	  	  foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($this->end_date))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByDateEndAndMonth($this->end_date, $i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByMonth($i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}

					                 	$col++;
          	
					                 	} 
					   	}
					  else
					    {  
					    	$col=0;
					    	
					         for($i=$start_month; $i<=$end_month; $i++)
				                 { 
				                 	$tuition_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $tuition_amount = Reports::getTotalAmountForTuitionByDateStartAndMonth($this->start_date, $i);
				                 	  	  foreach($tuition_amount as $tuition_a)
				                 	  	    { if($tuition_a['total_amount']!='')
				                 	  	        $amount = $tuition_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByDateEndAndMonth($this->end_date, $i);
				                 	  	foreach($tuition_amount as $tuition_a)
				                 	  	    { if($tuition_a['total_amount']!='')
				                 	  	        $amount = $tuition_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByMonth($i);
				                 	  	foreach($tuition_amount as $tuition_a)
				                 	  	    { if($tuition_a['total_amount']!='')
				                 	  	        $amount = $tuition_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
				                 	
				                 	$col++;
				                 	
				                 	}

					      }

				if($column_number>1)
				   {  
				   	   $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	    $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
		   	         
		   	  $html .='</tr>';
		   	  

//ENROLLMENT
 $html .='<tr>'; 
		   	         $html .='<td style="width:23%; border-bottom: 1px solid #ecedf4; ">'.Yii::t('app','Enrollment fee').'</td>';
		   	         
		   	         $total_revenu=0;
		   	          if($end_date1!=null)
					   {
					   	   $col=0;
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					                 { 
					                 	
					                 	$enrollment_amount = 0;
						                 	
						                 	if($i==getMonth($this->start_date))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $enrollment_amount = Reports::getTotalAmountForEnrollmentByDateStartAndMonth($this->start_date, $i);
						                 	  	  foreach($enrollment_amount as $enrollment_a)
						                 	  	    { if($enrollment_a['total_amount']!='')
						                 	  	        $amount = $enrollment_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;" >'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($end_date1))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByDateEndAndMonth($end_date1, $i);
						                 	  	foreach($enrollment_amount as $enrollment_a)
						                 	  	    { if($enrollment_a['total_amount']!='')
						                 	  	        $amount = $enrollment_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByMonth($i);
						                 	  	foreach($enrollment_amount as $enrollment_a)
						                 	  	    { if($enrollment_a['total_amount']!='')
						                 	  	        $amount = $enrollment_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}

					                $col++; 	
					                 	} 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					                 { 
					                 	$enrollment_amount = 0;
						                 	
						                 	if($i==getMonth($start_date1))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $enrollment_amount = Reports::getTotalAmountForEnrollmentByDateStartAndMonth($start_date1, $i);
						                 	  	  foreach($enrollment_amount as $enrollment_a)
						                 	  	    { if($enrollment_a['total_amount']!='')
						                 	  	        $amount = $enrollment_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($this->end_date))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByDateEndAndMonth($this->end_date, $i);
						                 	  	foreach($enrollment_amount as $enrollment_a)
						                 	  	    { if($enrollment_a['total_amount']!='')
						                 	  	        $amount = $enrollment_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByMonth($i);
						                 	  	foreach($enrollment_amount as $enrollment_a)
						                 	  	    { if($enrollment_a['total_amount']!='')
						                 	  	        $amount = $enrollment_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}

					                 	$col++;
          	
					                 	} 
					   	}
					  else
					    {  
					    	$col=0;
					    	
					         for($i=$start_month; $i<=$end_month; $i++)
				                 { 
				                 	$enrollment_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $enrollment_amount = Reports::getTotalAmountForEnrollmentByDateStartAndMonth($this->start_date, $i);
				                 	  	  foreach($enrollment_amount as $enrollment_a)
				                 	  	    { if($enrollment_a['total_amount']!='')
				                 	  	        $amount = $enrollment_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByDateEndAndMonth($this->end_date, $i);
				                 	  	foreach($enrollment_amount as $enrollment_a)
				                 	  	    { if($enrollment_a['total_amount']!='')
				                 	  	        $amount = $enrollment_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByMonth($i);
				                 	  	foreach($enrollment_amount as $enrollment_a)
				                 	  	    { if($enrollment_a['total_amount']!='')
				                 	  	        $amount = $enrollment_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
				                 	
				                 	$col++;
				                 	
				                 	}

					      }

				if($column_number>1)
				   {  
				   	   $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	   $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
		   	         
		   	 $html .='</tr>';

		   	  

             $html .='<tr>'; 
		   	         $html .='<td style="border-bottom: 1px solid #ecedf4;">'.Yii::t('app','Other fees').'</td>';
		   	         
		   	         $total_revenu=0;
		   	         
		   	           if($end_date1!=null)
						   {
						   	  $col=0;
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						          {    
						                 	$tuition_amount = 0;
						                 	
						                 	if($i==getMonth($this->start_date))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $tuition_amount = Reports::getTotalAmountForOtherFeeByDateStartAndMonth($this->start_date, $i);
						                 	  	  foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($end_date1))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByDateEndAndMonth($end_date1, $i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByMonth($i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}
						               $col++;
						                 							                 	
						            } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						           { 
					                 	$tuition_amount = 0;
					                 	
					                 	if($i==getMonth($start_date1))
					                 	  {  
					                 	  	  $amount = 0;
					                 	  	  $tuition_amount = Reports::getTotalAmountForOtherFeeByDateStartAndMonth($start_date1, $i);
					                 	  	  foreach($tuition_amount as $tuition_a)
					                 	  	    { if($tuition_a['total_amount']!='')
					                 	  	        $amount = $tuition_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
					                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  
					                 	    }
					                 	 elseif($i==getMonth($this->end_date))
					                 	  {  
					                 	  	$amount = 0;
					                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByDateEndAndMonth($this->end_date, $i);
					                 	  	foreach($tuition_amount as $tuition_a)
					                 	  	    { if($tuition_a['total_amount']!='')
					                 	  	        $amount = $tuition_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
					                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  
					                 	    }
					                 	 else
					                 	  {  
					                 	  	$amount = 0;
					                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByMonth($i);
					                 	  	foreach($tuition_amount as $tuition_a)
					                 	  	    { if($tuition_a['total_amount']!='')
					                 	  	        $amount = $tuition_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
					                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  	}
					                 	
                                   $col++;
                                   
						             }
						              
						   	}
						  else
						    {
						       $col=0;
						       
						         for($i=$start_month; $i<=$end_month; $i++)
						                 { 
						                 	$tuition_amount = 0;
						                 	
						                 	if($i==getMonth($this->start_date))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $tuition_amount = Reports::getTotalAmountForOtherFeeByDateStartAndMonth($this->start_date, $i);
						                 	  	  foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($this->end_date))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByDateEndAndMonth($this->end_date, $i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByMonth($i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}
						                 $col++;	

						                 	} 	
						      }
                   	if($column_number>1)
				   {  
				   	   $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	    $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
	   	         
		   	  $html .='</tr>';
		   	  
		 foreach($label_income as $label)
		   {
		   	  $html .='<tr>'; 
		   	         $html .='<td style="border-bottom: 1px solid #ecedf4;">'.Yii::t('app',$label['category']).'</td>';
		   	         
		   	         $total_revenu=0;
		   	         
		   	          if($end_date1!=null)
					   { 
					   	   $col=0;
					   	   
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         { 
				                 	$income_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $income_amount = Reports::getTotalAmountForOtherIncomeByDateStartAndMonth($label['id'],$this->start_date, $i);
				                 	  	  foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByDateEndAndMonth($label['id'],$end_date1, $i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByMonth($label['id'],$i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 		$col++;
					           } 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          { 
				                 	$income_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $income_amount = Reports::getTotalAmountForOtherIncomeByDateStartAndMonth($label['id'],$start_date1, $i);
				                 	  	  foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByDateEndAndMonth($label['id'],$this->end_date, $i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByMonth($label['id'],$i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	
					                $col++; 	
					            } 
					   	}
					  else
					    {
					    	$col=0;
					    	
					         for($i=$start_month; $i<=$end_month; $i++)
					             {
				                 	$income_amount = 0;
				                 	
				                 	if($i== getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $income_amount = Reports::getTotalAmountForOtherIncomeByDateStartAndMonth($label['id'],$this->start_date, $i);
				                 	  	  foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByDateEndAndMonth($label['id'],$this->end_date, $i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByMonth($label['id'],$i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	     $col++;
					             } 	
					      }

                 if($column_number>1)
				   {  
				   	    $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	    $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
                     		   	         
		   	  $html .='</tr>';
		   	  
		   	  
		   	}

             $html .='<tr>'; 
		   	         $html .='<td style="border-bottom: 1px solid #ecedf4;">'.Yii::t('app','Point of sale').'</td>';
		   	         
		   	         $total_revenu=0;
		   	         
		   	         if($end_date1!=null)
					   {
					   	  $col=0;
					   	  
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         {
				                 	$sale_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $sale_amount = Reports::getTotalAmountForPOSByDateStartAndMonth($this->start_date, $i);
				                 	  	  foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByDateEndAndMonth($end_date1, $i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
				                 	  							                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByMonth($i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  	}
				                  $col++;
					             } 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          {
				                 	$sale_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $sale_amount = Reports::getTotalAmountForPOSByDateStartAndMonth($start_date1, $i);
				                 	  	  foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByDateEndAndMonth($this->end_date, $i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByMonth($i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  	}
				                 $col++;	

					            } 
					   	}
					  else
					    {
					         $col=0;
					         
					         for($i=$start_month; $i<=$end_month; $i++)
					            {
				                 	$sale_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $sale_amount = Reports::getTotalAmountForPOSByDateStartAndMonth($this->start_date, $i);
				                 	  	  foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByDateEndAndMonth($this->end_date, $i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	       // $amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByMonth($i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  	}
				                   $col++;	
					             } 	
					      }

                  	if($column_number>1)
				   {  
				   	   $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	   $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
		                 
		   	         
		   	         
		   	  $html .='</tr>';
		   	  
		 $html .='<tr>'; 
		   	         $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4;"><b>'.Yii::t('app','Total income').'</b></td>';
		   	         
		   	         for($i=0; $i< $column_number; $i++)
                          { 
		   	                  $html .='<td style="text-align:right; border-top: 2px solid #EDC1B1; border-left: 1px solid #FFFFFF;"><b>'.numberAccountingFormat($grand_total_revenu[$i]).'</b></td>';
                          }
		   	  $html .='</tr>';
		   	  
///////EXPENSES
$total_depense = 0;
$grand_total_depense = array($column_number);
//initialiser $grand_total_revenu
for($i=0; $i< $column_number; $i++)
  { 
  	  $grand_total_depense[$i] = 0;
  	}
		  


  $html .='<tr style="font-style: italic; background-color: #F1F1F1;" ><td ><b>'.strtoupper(strtr(Yii::t('app','Expenses'), pa_daksan() )).'</b></td><td colspan='.$column_number.'></td></tr>'; 
		 $label_expense = Reports::getExpenseLabel();
		  $col=0; 	  
		 foreach($label_expense as $label)
		   {
		   	  $html .='<tr>'; 
		   	         $html .='<td style="text-transform: uppercase; font-size:10px; font-weight:bold; border-bottom: 1px solid #ecedf4; ">'.Yii::t('app',$label['category']).'</td>  <td colspan='.$column_number.' style=" border-bottom: 1px solid #ecedf4; "> </td>';
		   	  $html .='</tr>';
		   	 
		   	  
		   	  if($label['id']==5) // (for staff)
		   	   {
		   	   	    //report payroll 
		   	   	    $html .='<tr>'; 
			   	         $html .='<td style="border-bottom: 1px solid #ecedf4; "><i>'.Yii::t('app','Payroll').'</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	         if($end_date1!=null)
						   {  
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
					               $payroll_amount = Reports::getTotalAmountForPayrollByDateStartAndMonth($this->start_date, $i);
					                 	  	foreach($payroll_amount as $payroll_a)
					                 	  	    { if($payroll_a['total_amount']!='')
					                 	  	        $amount = $payroll_a['total_amount'];
					                 	  	     }
					                 	  	$total_depense = $total_depense + $amount;
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
							                 	  	
					                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
						              $payroll_amount = Reports::getTotalAmountForPayrollByDateEndAndMonth($this->end_date, $i);
						                 	  	foreach($payroll_amount as $payroll_a)
						                 	  	    { if($payroll_a['total_amount']!='')
						                 	  	        $amount = $payroll_a['total_amount'];
						                 	  	     }
						                 	  	$total_depense = $total_depense + $amount;
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
								                 	  	
						                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
								            
								            $col++;     	
						            } 
						            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
				                 	  	$payroll_amount = Reports::getTotalAmountForPayrollByMonth( $i);
				                 	  	foreach($payroll_amount as $payroll_a)
				                 	  	    { if($payroll_a['total_amount']!='')
				                 	  	        $amount = $payroll_a['total_amount'];
				                 	  	     }
				                 	  	$total_depense = $total_depense + $amount;
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  $html .='</tr>';
			   	  
			   	 
		   	  
		 //ONA
		 //get ONA id 
		       
		        $ona_id = $this->getOnaID(); ////return an array(id, taxe_value)
		    if($ona_id!=null)
		       {		   	   	
		   	   	    //report ONA 
		   	   	    $html .='<tr>'; 
			   	         $html .='<td style="border-bottom: 1px solid #ecedf4; "><i>'.Yii::t('app','ONA').'( '.Yii::t('app','Employer').' )</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	         if($end_date1!=null)
						   {  
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
					               $amount = $this->getTotalAmountForONA($ona_id[0],$ona_id[1],$this->start_date,null, $i);
					                 	  	
					                 	  		$total_depense = $total_depense + $amount;
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
							                 	  	
					                 	  	$html .='<td style="text-align:right;  border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
						              $amount = $this->getTotalAmountForONA($ona_id[0],$ona_id[1],null,$this->end_date, $i);
						              		
						              		$total_depense = $total_depense + $amount;
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
								                 	  	
						                 	  	$html .='<td style="text-align:right;  border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
								            
								            $col++;     	
						            } 
				            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForONA($ona_id[0],$ona_id[1],null,null, $i);
				                 	  	
				                 	  		$total_depense = $total_depense + $amount;
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right;  border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  $html .='</tr>';
			   	  
			   	 
		   	   	
		   	   	}
		   	  
		   	 }    	   
		   
		   
		   if($label['id']==6) // (TAX)
		   	   {
		   	   	    //report TOP/TMS 
		   	   	    $html .='<tr>'; 
			   	         $html .='<td style=" border-bottom: 1px solid #ecedf4; "><i>'.Yii::t('app','TOP').'('.Yii::t('app','Tax on payroll').')</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	            if($end_date1!=null)
						   {  
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
					               $amount = $this->getTotalAmountForTMS($this->start_date,null, $i);
					                 	  	
					                 	  		$total_depense = $total_depense + $amount;
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
							                 	  	
					                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
						              $amount = $this->getTotalAmountForTMS(null,$this->end_date, $i);
						              		
						              		$total_depense = $total_depense + $amount;
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
								                 	  	
						                 	  	$html .='<td style="text-align:right;  border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
								            
								            $col++;     	
						            } 
				            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTMS(null,null, $i);
				                 	  	
				                 	  		$total_depense = $total_depense + $amount;
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right;  border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  $html .='</tr>';
			   	  
			   
		   	  
		   	 }	   
		   	 
		   	 
		   	 
		   	  
		    $description_charge = Reports::getDescriptionChargeByIdCategory($label['id']);
		   	   foreach($description_charge as $description)
		   	    {  
		   	    	 
		   	    	
			   	   $html .='<tr>'; 
			   	         $html .='<td style="  border-bottom: 1px solid #ecedf4; "><i>'.$description['description'].'</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	         if($end_date1!=null)
						   {  
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
					               $expense_amount = Reports::getTotalAmountExpenseByDescriptionAndDateStartAndMonth($description['id'],$this->start_date, $i);
					                 	  	foreach($expense_amount as $expense_a)
					                 	  	    { if($expense_a['total_amount']!='')
					                 	  	        $amount = $expense_a['total_amount'];
					                 	  	     }
					                 	  	$total_depense = $total_depense + $amount;
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
							                 	  	
					                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
						              $expense_amount = Reports::getTotalAmountExpenseByDescriptionAndDateEndAndMonth($description['id'],$this->end_date, $i);
						                 	  	foreach($expense_amount as $expense_a)
						                 	  	    { if($expense_a['total_amount']!='')
						                 	  	        $amount = $expense_a['total_amount'];
						                 	  	     }
						                 	  	$total_depense = $total_depense + $amount;
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
								                 	  	
						                 	  	$html .='<td style="text-align:right;  border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
								            
								            $col++;     	
						            } 
						            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
				                 	  	$expense_amount = Reports::getTotalAmountExpenseByDescriptionAndMonth($description['id'], $i);
				                 	  	foreach($expense_amount as $expense_a)
				                 	  	    { if($expense_a['total_amount']!='')
				                 	  	        $amount = $expense_a['total_amount'];
				                 	  	     }
				                 	  	$total_depense = $total_depense + $amount;
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
						                 	  	
				                 	  	$html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  $html .='</tr>';
			   	  
			   	 
			   	  
		   	    }   	  
		   	  
		   	  
		   	  
		   	  
		   	  
		   	  
		   	  		   	  
		     
		   	  
		   	}

             
		 $html .='<tr>'; 
		   	         $html .='<td style="text-align:right; border-bottom: 1px solid #ecedf4; "><b>'.Yii::t('app','Total expenses').'</b></td>';
		   	         
		   	         for($i=0; $i< $column_number; $i++)
                          { 
		   	                  $html .='<td style="text-align:right; border-top: 2px solid #EDC1B1; border-left: 1px solid #FFFFFF;"><b>'.numberAccountingFormat($grand_total_depense[$i]).'</b></td>';
                          }
		   	  $html .='</tr>';
		   	  
		 $html .='<tr>'; 
		   	         $html .='<td style="text-align:right; border-bottom: 0px solid #ecedf4; "><b>'.Yii::t('app','Profit(Loss)').'</b></td>';
		   	         
		   	         for($i=0; $i< $column_number; $i++)
                          { 
		   	                  if(($grand_total_revenu[0] -$grand_total_depense[0])!=0)
		   	                    $this->displayButton=true;
		   	                  
		   	                  $html .='<td style="text-align:right; border-top: 2px solid #EDC1B1; border-left: 1px solid #FFFFFF;"><b>'.numberAccountingFormat($grand_total_revenu[$i] -$grand_total_depense[$i]).'</b></td>';
                          }
		   	  $html .='</tr>'; 	 
		 
		$html .=' </table>
		<br/><br/>
	<div style="float:right; text-align: right; font-size: 6px; margin-top:140px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>	
		</div>';
		
	 
  
 	         
		                 
      

		  
      
      $file_name = strtr("Financial statement", pa_daksan() ).'_'.$acad_name_;	 
  
  
      
               
                                          $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
							 
								
								  
								$pdf->Output($file_name.'.pdf', 'D');
					
								
	                  	          /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option 
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/
	                  	
			                   	                  	
	                  }
	                else
	                  { 
	                  	
	                  	$this->displayButton =false;
	                  	
	                  	   $date_start = AcademicPeriods::model()->findByPk($acad)->date_start;
						 $year_start = date("Y",strtotime($date_start));
						
						 $default_start_date = $year_start.'-09-01'; 
		                
		                 if($this->start_date=='')
		                    $this->start_date = $default_start_date;
	                  	  
	                  	  
	                  	  $default_end_date = date('Y-m-d'); 
	                  	  $default_end_date = strtotime ( '+1 day' , strtotime ( $default_end_date ) ) ;
                          $default_end_date = date ( 'Y-m-j' , $default_end_date );

			                
			                 if($this->end_date=='')
			                    $this->end_date = $default_end_date;
	                  	
	                  	
	                  	}
		  
		$this->render('etat_f',array(
			
                        'model'=>$model,
                        
		));
	}
	

 	
  	
        
public function actionTaxreport()
   {
   	
   	     $acad=Yii::app()->session['currentId_academic_year'];
   	
            $model = new Reports(); 
            
            $this->part = 'taxrep';
            
            $this->start_date =null;
            $this->end_date =null;
            
       
       if(isset($_POST['go']))
		{
		  
                    $this->displayButton =false;
		   
		   $this->start_date=$_POST['Reports']['start_date'];
		   $this->end_date=$_POST['Reports']['end_date'];
          
		  }
		else
		  {
		  	  $this->displayButton =false;
		  	  
		  	  $date_start = AcademicPeriods::model()->findByPk($acad)->date_start;
						 $year_start = date("Y",strtotime($date_start));
						
						 $default_start_date = $year_start.'-09-01'; 
		                
		                 if($this->start_date=='')
		                    $this->start_date = $default_start_date;
		                    
		                    
		  	                $default_end_date = date('Y-m-d'); 
			                
			                 if($this->end_date=='')
			                    $this->end_date = $default_end_date;
		                    
 

		  	
		  	}
		  
		$this->render('taxreport',array(
			
                        'model'=>$model,
                        
		));
            
        }
        

public function actionFdm()
   {
   	
   	     $acad=Yii::app()->session['currentId_academic_year'];
   	     $acad_name=Yii::app()->session['currentName_academic_year'];
		$currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
  
            $this->part = 'Fdmensuelle';
            
            $model = new Reports(); 
            
           
           
            if($this->payroll_month =='')
			          {  
			          	$month_payroll=Payroll::model()->getMonthPastPayroll();
			  
			  			if($month_payroll!=null)
						 {
							 foreach($month_payroll as $p)
						       {	 
								     	//$mwa[$p['payroll_month']] = Payroll::model()->getSelectedLongMonth($p['payroll_month']);
							            $this->payroll_month = $p['payroll_month'];
							            break; 
								} 
								
						  }
				     
			          }
            
           if(isset($_POST['Reports']))
	          {  
	          	      if(isset($_POST['Reports']['payroll_month']))
		              {  
		              	$this->payroll_month = $_POST['Reports']['payroll_month'];
		              	 Yii::app()->session['reports_payroll_month'] = $this->payroll_month;
		              	
		               }
		            else
		              {
		            	 $this->payroll_month=Yii::app()->session['reports_payroll_month'];
		            	}
		            	
              
              
               if(isset($_POST['viewPDF'])) //to create PDF file
			      {
			         	
			         								//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                                                                                //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
                                                                                                //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
                                                                                                //Extract Phone Number
                                 $school_phone_number = infoGeneralConfig('school_phone_number');
                                 
                                                               
                                                                                             
										
										 
								// create new PDF document
								$pdf = new tcpdf('L', PDF_UNIT, 'Legal', true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app',"Monthly declaration sheet"));
								$pdf->SetSubject(Yii::t('app',"Monthly declaration sheet"));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								
								//$pdf->SetHeaderData(PDF_HEADER_LOGO_REPORTCARD, PDF_HEADER_LOGO_REPORTCARD_WIDTH, "", ""); //CNR
								$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								//$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);      //CNR
								$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								$pdf->SetFooterMargin(7); //PDF_MARGIN_FOOTER

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, 5); // PDF_MARGIN_BOTTOM

								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 12, '', true);
								

		
                             	 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();

								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

					
					
							$html = <<<EOD
 <style>
	
	
.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		//color: #1e5c8c;
        font-size: 16px;
		width:100%;
		text-align: center;
		
		 
	   }
	
	
.info{   font-size:15px;
       text-align: center;
      
		border-bottom: 1px solid #ECEDF2;
	 }
		
	
	
</style>
                                       
										
EOD;
	 
	 $payroll_year=Payroll::model()->getYearFromAcad($this->payroll_month, $acad);
	 $month_ = getLongMonth($this->payroll_month);
	 $condition='p.is_student=0 AND p.active IN(1, 2) ';
	 
	 $html .='<br/><div class="title">'.strtoupper(strtr(Yii::t("app","Monthly declaration sheet"), pa_daksan() )).' <br/><span class="info" >'.$month_.' '.$payroll_year.' </span></div><br/>';
										
														  
   
      $html .= '<table class="table no-margin" style="font-size:14px; width:100%; background-color:#F4F6F6;">
		           <tr>
		               <td class="" style="text-align:center; width:45px; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"><b>'.Yii::t('app','#').'</b></td> <td style="text-align:center; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"><b>'.strtoupper(strtr(Yii::t('app','Last name'), pa_daksan() )).'</b></td>  <td style="text-align:center; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"><b>'.strtoupper(strtr(Yii::t('app','First name'), pa_daksan() )).'</b></td>  <td style="text-align:center; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"><b>'.strtoupper(strtr(Yii::t('app','Gross salary'), pa_daksan() )).'</b></td>';

                  $all_taxes = Reports::getTaxesForFDM($acad);
                  
		       foreach($all_taxes as $taxe)
		        {
				   	  
			   	  if($taxe['taxe_description']=="ONA")
			   	    {
			   	    	//ONA Employe
			   	    	if($taxe['employeur_employe']==0)
			   	    	 {
			   	    	    $html .= '<td style="text-align:center; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"> <b>'.Yii::t('app','ONA').'</b></td>';// '.Yii::t('app','Employee').'</b></td>';
			   	         }
			   	      
	                  }
			   	   elseif($taxe['taxe_description']=="TMS")  //for TOP/TMS
			   	     { 
			   	     	 $html .= '<td style="text-align:center; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"> <b>'.Yii::t('app','TMS').'</b></td>';
			   	        
			   	       }
			   	     elseif($taxe['taxe_description']=="IRI")  //for impot sur le revenu
			   	     { 
			   	     	$html .= '<td style="text-align:center; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"> <b>'.Yii::t('app','IRI ').'</b></td>';
			   	         
	                  }
			   	     else
			   	       {
			   	         $html .= '<td style="text-align:center; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"> <b>'.strtoupper(strtr(Yii::t('app',$taxe['taxe_description']), pa_daksan() )).'</b></td>';
			   	        }
			   	  
			   	 }
                  
          $html .= ' <td style="text-align:center; background-color: #F1F1F1; border-left: 3px solid #FFFFFF;"><b>'.strtoupper(strtr(Yii::t('app','Net Salary'), pa_daksan() )).'</b></td></tr>'; 
                    
                 $prosper_metuschael =1;  
                $modelPersonPayroll=Payroll::model()->searchPersonsInPayrollForReports($condition,$this->payroll_month, $acad);
         
                $modelPersonPayroll = $modelPersonPayroll->getData();
		     	 if($modelPersonPayroll!=null)
		     	   {
		     	   	    foreach($modelPersonPayroll as $personPayroll_)
		     	   	     {
		     	   	        $html .= ' <tr>';
		     	   	           $html .= ' <td style="height:28px; border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; ">'.$prosper_metuschael.'</td> <td style="border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; ">'.$personPayroll_->last_name.'</td><td style="border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; ">'.$personPayroll_->first_name.'</td>';
		     	   	           $gross_salary= Payroll::model()->getGrossSalaryPerson_idMonthAcad($personPayroll_->person_id,$personPayroll_->payroll_month, $acad  );
		     	   	           
		     	   	           $html .= ' <td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; ">'.numberAccountingFormat($gross_salary).'</td>';
		     	   	           
		     	   	           $total_deduction = 0;
		     	   	           
		     	   	           foreach($all_taxes as $taxe)
						        {
								   	  
							   	  if($taxe['taxe_description']=="ONA")
							   	    {
							   	    	//ONA Employe
							   	    	if($taxe['employeur_employe']==0)
							   	    	 {
							   	    	    $deduction = 0;
							   	    	    $deduction = ( ($gross_salary * $taxe['taxe_value'])/100);
											          $total_deduction = $total_deduction + $deduction;
											          
							   	    	    $html .= '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; "> '.numberAccountingFormat($deduction).'</td>';// '.Yii::t('app','Employee').'</b></td>';
							   	         }
							   	      
					                  }
							   	   elseif($taxe['taxe_description']=="TMS")  //for TOP/TMS
							   	     { 
							   	     	 $deduction = 0;
							   	    	    $deduction = ( ($gross_salary * $taxe['taxe_value'])/100);
											          $total_deduction = $total_deduction + $deduction;
									     $html .= '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; "> '.numberAccountingFormat($deduction).'</td>';
							   	        
							   	       }
							   	     elseif($taxe['taxe_description']=="IRI")  //for impot sur le revenu
							   	     { 
							   	     	$deduction = 0;
							   	    	    //get id payroll_setting for this person
				                         $id_pay_set= PayrollSettings::model()->getIdPayrollSettingByPersonId($personPayroll_->person_id);
				                                             
				                          $total_gross_salary = Payroll::model()->getGrossSalaryPerson_idMonthAcad($personPayroll_->person_id,$personPayroll_->payroll_month, $acad  );    
							  	    	
							  	    	   $deduction = getIriDeduction($id_pay_set, $total_gross_salary);
			  	    	  
							   	    	    $total_deduction = $total_deduction + $deduction;

									     $html .= '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; "> '.numberAccountingFormat($deduction).'</td>';
							   	         
					                  }
							   	     else
							   	       {
							   	         $deduction = 0;
							   	    	    $deduction = ( ($gross_salary * $taxe['taxe_value'])/100);
											          $total_deduction = $total_deduction + $deduction;
										   $html .= '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; "> '.numberAccountingFormat($deduction).'</td>';
							   	        }
							   	  
							   	 }
		     	   	           
		     	   	            $net_salary = $gross_salary - $total_deduction;
										   $html .= '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 3px solid #FFFFFF; "> '.numberAccountingFormat($net_salary).'</td>';
		     	   	           
		     	   	        $html .= '</tr>';
		     	   	        
		     	   	        $prosper_metuschael ++;
		     	   	        
		     	   	      }
		    
		     	     } 
                    
                  
                  
                  
                 $html .= '  </table>';  
             
              
		    
                                            $pdf->writeHTML($html, true, false, true, false, '');
		                                    // Print text using writeHTMLCell()
                                          //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
                           	
                           
                            
								  $file_name = Yii::t('app','FDM');
								$pdf->Output($file_name, 'D');
	                  	          /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option 
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/
				   		
				       
				

			     }
	              
	              
	            
	            }  
       
		  
		$this->render('fdm',array(
			
                        'model'=>$model,
                        
		));
            
        }


//************************  getPastLongMonthValue()  ******************************/	
 public function getPastLongMonthValue()
	{    
         $code = array();   
         
         $payroll=Payroll::model()->getMonthPastPayroll();
		  
			
			if($payroll!=null)
			 {
				 foreach($payroll as $p)
			       {	 
					     	$code[$p['payroll_month']] = Payroll::model()->getSelectedLongMonth($p['payroll_month']);
				     
					} 
			  }
			
			  	 	
		return $code;
         
	}
	

//return an array(id, taxe_value)
public function getOnaID()
 {  
 	$acad=Yii::app()->session['currentId_academic_year']; 
 	
 	$code=array();
 	
 	$command= Yii::app()->db->createCommand('SELECT id, taxe_value FROM taxes  WHERE taxe_description like(\'ONA\') AND employeur_employe=0 AND academic_year='.$acad);
		
$sql_result = $command->queryAll();
		
		foreach($sql_result as $result)
		  { if($result['id']!='')
			  {	$code[0] = $result['id'];
				$code[1] = $result['taxe_value'];
			   }
		  }
		  
		  return $code;
 	
 	}
 	
 	
 	
public function getTotalAmountForONA($ona_id,$ona_value, $d_start,$d_end, $month)
  {
  	  $acad=Yii::app()->session['currentId_academic_year']; 
  	  
  	  $total_amount =0;
  		 
  	  if(($d_start==null)&&($d_end==null))
  	    {
  	    	$total_amount=0;
  	    	 $all_person = Reports::getPersonIdtForONAByMonth($acad, $month);
  	    	 if($all_person!=null)
				{ foreach($all_person as $person_id)
				    { 
  	    	                $amount = getDeductionTaxeForReport($person_id['person_id'],$ona_id,$month,$acad);
  
			  	    	$total_amount = $total_amount + $amount;
							
				      }
				      
				   }
				
				     
  	      }
  	    elseif($d_start!=null)
  	       {
  	       	$total_amount=0;
  	       	    $all_person = Reports::getPersonIdtForONAByDateStartAndMonth($acad, $d_start, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
  	    	 				$amount = getDeductionTaxeForReport($person_id['person_id'],$ona_id,$month,$acad);

							    $total_amount = $total_amount + $amount;
							
				      }
				      
				   }
						    
							    

  	       	 }
  	      elseif($d_end!=null)
  	       {
  	       	 $total_amount=0;
  	       	     $all_person = Reports::getPersonIdtForONAByDateEndAndMonth($acad, $d_end, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
  	    	 					$amount = getDeductionTaxeForReport($person_id['person_id'],$ona_id,$month,$acad);

							    $total_amount = $total_amount + $amount;
							
				      }
				      
				   }
				
				
  	       	 }
  	      
  	     
  	      return $total_amount;
  	      
  	}	
	
	
	
	
public function getTotalAmountForTMS($d_start,$d_end, $month)
  {
  	  $acad=Yii::app()->session['currentId_academic_year']; 
  	  
  	  $total_amount =0;
  		 
  	  if(($d_start==null)&&($d_end==null))
  	    {
  	    	 $all_person = Reports::getPersonIdtForTMSByMonth($acad, $month);
  	    	 if($all_person!=null)
				{ foreach($all_person as $person_id)
				    { 	    	 
                       $amount = Payroll::model()->getGrossSalary($person_id['person_id'])  ;    
			  	    	$total_amount = $total_amount + $amount;
								
				      }
				      
				   }
				
				     
  	      }
  	    elseif($d_start!=null)
  	       {
  	       	    $all_person = Reports::getPersonIdtForTMSByDateStartAndMonth($acad, $d_start, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
  	    	                $amount = Payroll::model()->getGrossSalary($person_id['person_id'])  ;    
			  	    	$total_amount = $total_amount + $amount;
							    
							
							
				      }
				      
				   }
						    
							    

  	       	 }
  	      elseif($d_end!=null)
  	       {
  	       	     $all_person = Reports::getPersonIdtForTMSByDateEndAndMonth($acad, $d_end, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
  	    	 
	                      $amount = Payroll::model()->getGrossSalary($person_id['person_id'])  ;    
			  	    	$total_amount = $total_amount + $amount;				    
				    		
							
				      }
				      
				   }
				
				
  	       	 }
  	      
  	     
  	     //get the % in table taxes if define
  	       $command= Yii::app()->db->createCommand('SELECT taxe_value FROM taxes  WHERE taxe_description like(\'TMS\') AND employeur_employe=1 AND academic_year='.$acad);
		
        $sql_result = $command->queryAll();
		
		$tax_v=0;
		foreach($sql_result as $result)
		  { if($result['taxe_value']!='')
			  {	$tax_v = $result['taxe_value'];
			   }
		  }

  	     
  	     $total_amount = ($total_amount*$tax_v)/100;
  	     
  	     
  	     
  	      return $total_amount;
  	      
  	}	


	
	
public function getTotalAmountForIRI($d_start,$d_end, $month)
  {
  	  $acad=Yii::app()->session['currentId_academic_year']; 
  	  
  	  $total_amount =0;
  	  
  	  
  	  $all_taxes = Reports::getTaxesForFDM($acad);
  		 
  	  if(($d_start==null)&&($d_end==null))
  	    {
  	    	 
  	    	 
  	    	 $all_person = Reports::getPersonIdtForTMSByMonth($acad, $month);
  	    	 if($all_person!=null)
				{ foreach($all_person as $person_id)
				    { 	    	 
                        $amount = 0;
                        
                         
                         //get id payroll_setting for this person
				         $total_gross_salary = Payroll::model()->getGrossSalaryPerson_idMonthAcad($person_id['person_id'],$month, $acad  );    
							  	    	
						 $amount = getIriDeduction($person_id['id_payroll_set'],$person_id['id_payroll_set2'], $total_gross_salary);
			  	    	
			  	    	  $total_amount = $total_amount + $amount;
								
				      }
				      
				   }
				
				     
  	      }
  	    elseif($d_start!=null)
  	       {
  	       	     $all_person = Reports::getPersonIdtForTMSByDateStartAndMonth($acad, $d_start, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
  	    	               $amount = 0;
                            
                         
                          //get id payroll_setting for this person
				         $total_gross_salary = Payroll::model()->getGrossSalaryPerson_idMonthAcad($person_id['person_id'],$month, $acad  );    
							  	    	
						 $amount = getIriDeduction($person_id['id_payroll_set'],$person_id['id_payroll_set2'], $total_gross_salary);
			  	    	      
			  	    	$total_amount = $total_amount + $amount;
							    
							
							
				      }
				      
				   }
						    
							    

  	       	 }
  	      elseif($d_end!=null)
  	       {
  	    	     $all_person = Reports::getPersonIdtForTMSByDateEndAndMonth($acad, $d_end, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
  	    	                 $amount = 0;
                        
                             //get id payroll_setting for this person
                          
                                                              
				         $total_gross_salary = Payroll::model()->getGrossSalaryPerson_idMonthAcad($person_id['person_id'],$month, $acad  );    
							  	    	
						 $amount = getIriDeduction($person_id['id_payroll_set'],$person_id['id_payroll_set2'], $total_gross_salary);
			  	    	      
			  	    	$total_amount = $total_amount + $amount;				    
				    		
							
				      }
				      
				   }
				
				
  	       	 }
  	      
  	     
  	  	return $total_amount;
  	      
  	}
  	
  	
  	
  	
  	

public function getTotalAmountForTaxesByDateStartAndMonth($tax_id, $tax_value, $start_date, $month)
  {
  	  $acad=Yii::app()->session['currentId_academic_year']; 
  	  
  	  $total_amount =0;
  		
  	       	    $all_person = Reports::getPersonIdtForTaxeByDateStartAndMonth($acad, $start_date, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
 	       		            $amount = 0;
 	       		            
 	       		           $amount = getDeductionTaxeForReport($person_id['person_id'],$tax_id,$month,$acad);
 	       		           
							$total_amount = $total_amount + $amount;
							
				      }
				      
				   }
						    
	  	 
  	      return $total_amount;
  	      
  	}

public function getTotalAmountForTaxesByDateEndAndMonth($tax_id, $tax_value, $end_date, $month)
  {
  	  $acad=Yii::app()->session['currentId_academic_year']; 
  	  
  	  $total_amount =0;
  		
  	       	    $all_person = Reports::getPersonIdtForTaxeByDateEndAndMonth($acad, $end_date, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
  	    	                $amount = 0;
 	       		            
 	       		           $amount = getDeductionTaxeForReport($person_id['person_id'],$tax_id,$month,$acad);
            	       	    
							$total_amount = $total_amount + $amount;
							
				      }
				      
				   }
						    
	      return $total_amount;
  	      
  	}


public function getTotalAmountForTaxesByMonth($tax_id, $tax_value,$month)
  {
  	  $acad=Yii::app()->session['currentId_academic_year']; 
  	  
  	  $total_amount =0;
  		
  	       	    $all_person = Reports::getPersonIdtForTaxeByMonth($acad, $month);
	  	    	 if($all_person!=null)
					{ foreach($all_person as $person_id)
					    { 
  	    	                 $amount = 0;
 	       		            
 	       		           $amount = getDeductionTaxeForReport($person_id['person_id'],$tax_id,$month,$acad);
            	       	  
							
							 $total_amount = $total_amount + $amount;
				      }
				      
				   }
						    
	      return $total_amount;
  	      
  	}



   

	
    	// Behavior the create Export to CSV 
	public function behaviors() {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','persons.csv'),
	            'csvDelimiter' => ',',
	            ));
	}


	//####################  VARIANCE  ###################  

  
//(note: variance function uses the average function...)
public function average_for_array($arr)
{
    if (!count($arr)) return 0;

    $sum = 0;
    for ($i = 0; $i < count($arr); $i++)
    {
        $sum += $arr[$i];
    }

    return $sum / count($arr);
}

public function variance($arr)
{
    if (!count($arr)) return 0;

    //$mean = average_for_array($arr);
    $sum = 0;
    for ($i = 0; $i < count($arr); $i++)
    {
        $sum += $arr[$i];
    }

    $mean =  $sum / count($arr);
    
    $sos = 0;    // Sum of squares
    for ($i = 0; $i < count($arr); $i++)
    {
        $sos += ($arr[$i] - $mean) * ($arr[$i] - $mean);
    }

    return $sos / (count($arr)-1);  // denominator = n-1; i.e. estimating based on sample
                                    // n-1 is also what MS Excel takes by default in the
                                    // VAR function
}

/*  echo variance(array(4,6,23,15,18)); // echoes 64.7...correct value :)
*/

 //####################  FIN VARIANCE  ###################   
 

	
	
	
	
}





?>