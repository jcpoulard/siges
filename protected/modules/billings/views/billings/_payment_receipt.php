<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is free software: you can redistribute it and/or modify
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

?>
<?php
/* @var $this BillingsController */
/* @var $model Billings */
/* @var $form CActiveForm */



    
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$acad_name=Yii::app()->session['currentName_academic_year'];
$currency_symbol = Yii::app()->session['currencySymbol'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

$modelOtherIncome = new OtherIncomes;
?>


<div class="grid-view">

	<?php
	
	//Extract school name 
								$criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'school_name',);
				   								$school_name = GeneralConfig::model()->find($criteria)->item_value;
                                                                                                //Extract school address
				   								$criteria2 = new CDbCriteria;
				   								$criteria2->condition='item_name=:item_name';
				   								$criteria2->params=array(':item_name'=>'school_address',);
												$school_address = GeneralConfig::model()->find($criteria2)->item_value;
                                                                                                //Extract  email address 
                                                                                                $criteria3 = new CDbCriteria;
				   								$criteria3->condition='item_name=:item_name';
				   								$criteria3->params=array(':item_name'=>'school_email_address',);
				   								$school_email_address = GeneralConfig::model()->find($criteria3)->item_value;
                                                                                                //Extract Phone Number
                                                                                                $criteria4 = new CDbCriteria;
				   								$criteria4->condition='item_name=:item_name';
				   								$criteria4->params=array(':item_name'=>'school_phone_number',);
				   								$school_phone_number = GeneralConfig::model()->find($criteria4)->item_value;


	//get level for this student
								$level=0;
								$modelLevel=$this->getLevelByStudentId($model->student,$acad_sess);
								if($modelLevel!=null)
								 {
								 	$level=$modelLevel->id;
								 	
								   }
								
									
?>
	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-4">
            <label id="resp_form"> 
                   <?php 
                                        
                              echo $form->labelEx($model,Yii::t('app','Rubric'));
                                        
                                 if(isset($_GET['id']))
							       {	 
								
								       
							       echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true)), 'disabled'=>'disabled')); 
							           
								           
							        }
							     else
							      {
							     	if(isset($this->recettesItems)&&($this->recettesItems!=''))
							       echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true)), 'disabled'=>'disabled')); 
							           else
								         { 
									        echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()', 'disabled'=>'disabled')); 
								           }
							     	
							     	}

                        ?>
           	</label>
        </div>

<?php
if($this->recettesItems!=1)
   {
   	
   	if(!isset($_GET['from'])||($_GET['from']!='ad'))
     {
?>
        <div class="col-4">
            <label id="resp_form"> 
                          <?php echo $form->labelEx($model,'student'); ?>
								<?php 
									
								$criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC','join'=>'left join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1,2) AND rh.academic_year ='.$acad_sess));
								
							if(isset($_GET['id']))
							 {	 
								echo $form->dropDownList($model, 'student',
								CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
								array('onchange'=> 'submit()', 'disabled'=>'disabled')
								);
							  }
							else
							  {
							  	if($this->student_id!='')
							  	 {
								  	echo $form->dropDownList($model, 'student',
									CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
									array('onchange'=> 'submit()','options' => array($this->student_id=>array('selected'=>true)) )
									);
							  	  }
							  	else
							  	  {
							  	  	echo $form->dropDownList($model, 'student',
									CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
									array('onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Please select student --'))
									);
							  	  }
								
							  	}
							  	
								 ?>
								<?php echo $form->error($model,'student'); ?>
                           </label>
        </div>

<?php
      }
      
   }
 else
   {
   	?>
   	  <div class="col-4">
            <label id="resp_form">
                    
           <?php echo $form->labelEx($modelOtherIncome,'id_income_description'); ?>
                 <?php 
                 
                        if($this->id_income_desc!='')
						  {  
							  
							  echo $form->dropDownList($modelOtherIncome, 'id_income_description',CHtml::listData(OtherIncomesDescription::model()->findAll(),'id','fullName'),array( 'options' => array($this->id_income_desc=>array('selected'=>true)), 'disabled'=>'disabled'));
										   
							}
						 else
							{   
								 echo $form->dropDownList($modelOtherIncome, 'id_income_description',CHtml::listData(OtherIncomesDescription::model()->findAll(),'id','income_description'),array(  'prompt'=>Yii::t('app','-- Search --'), 'disabled'=>''));
										  	
										  	
							 }
							 
						 ?>
						 <?php echo $form->error($modelOtherIncome,'id_income_description'); ?>
                    </label>
        </div>
<?php
   	}
   



if($this->recettesItems!=1)
   {
        
         $condition ='fl.status=1 AND ';
         
$levelName='';
$fee_cost = 0;
$student= '';

if(!isset($_GET['from'])||($_GET['from']!='ad'))
 {
 	if($this->student_id!='')
       {    $levelName=$this->getLevelByStudentId($this->student_id,$acad_sess)->level_name;
       
         }
           
   }	
	

$modelStud = new Persons;
$modelStudentOtherInfo = new StudentOtherInfo;

 	  
     $modelStud = Persons::model()->findByPk($this->student_id); 
  
 
     $modelStudentOtherInfo = StudentOtherInfo::model()->findByAttributes(array('student'=>$this->student_id)); 
  
       
      $student=$this->getStudent($this->student_id);
         

		 

?>  

 <div style="width:90%;">
            <label id="resp_form" style="width:100%;">
  
              <div id="print_receipt" style="float:left; padding:10px; border:1px solid #EDF1F6; width:98%; ">
                 
          <?php 
                echo '  <div id="header" style="display:none; ">
                 
                  <div class="info">'.headerLogo().' <b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' &nbsp; / &nbsp; '.Yii::t('app','Tel: ').$school_phone_number.' &nbsp; / &nbsp; '.Yii::t('app','Email: ').$school_email_address.'<br/></div> 
                  
                  <br/> 
                  
                  
                  ';
     
       
             
                        $dataPro = null;
                        
                     if(!isset($_GET['from'])||($_GET['from']!='ad'))
                      { 
   ?>                
  
       

      <?php
         				             
           echo '
                  
                  <div class="info" style="text-align:center; margin-top:-9px; margin-bottom:-15px;  "> <b>'.strtoupper(strtr(Yii::t('app','Payment receipt'), $this->pa_daksan )).'</b></div> <br/>  </div>'; 
			
			echo '
			
			    <div class="info" >
			      <div style="float:left;">'.Yii::t('app','Name').':  '.$student.' </div>
			     
			           <div style="margin-left:62%;">'.Yii::t('app','Level').': '.$levelName.'</div> 
			           
			      
			         <br/><div style="margin-left:62%;">'.Yii::t('app','Academic year').' '.$acad_name.' </div>   ';
			         
			         					  
					  						                
			           	
				if($this->student_id!='')
				   $dataPro = Billings::model()->searchByStudentId($condition,$this->student_id,$acad_sess);
				else
				    $dataPro = Billings::model()->searchByStudentId($condition,0,$acad_sess);

 
         echo '<br/><div style="margin-left:1%;"> 
			         				<table class="" style="width:99%; background-color: #E5F1F4; color: #1E65A4; -webkit-border-top-left-radius: 5px;-webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
									   <tr>
									   
									   <td style="text-align:center; font-weight: bold;"> '.Yii::t('app','No.').' </td>
									       <td style="text-align:center; font-weight: bold;">'.Yii::t('app','Rubric').' </td>
									       <td style="text-align:center; font-weight: bold; "> '.Yii::t('app','Expected amount').'</td>
									       <td style="text-align:center; font-weight: bold; "> '.Yii::t('app', 'Received amount').'</td>
									       <td style="text-align:center; font-weight: bold; "> '.Yii::t('app', 'Remain to pay').'</td>
									       <td style="text-align:center; font-weight: bold; "> '.Yii::t('app','Date Pay').'</td>
									       
									       
									    </tr>';

 	
						           	  if($dataPro->getData()!= null)  
						           	    { 
						           	    	$result = $dataPro->getData();			           	    	
						           	    	$i=0;
						           	    	foreach($result as $r)
											     { 
											     	
											     	echo '<tr>
												           <td style="text-align:center;"> '.$r->id.'  </td>
														   <td style="text-align:center; ">'.$r->feePeriod->simpleFeeName.' </td>
														   <td style="text-align:center; "> '.$r->amountToPay.'</td>
														   <td style="text-align:center;"> '.$r->amountPay.'  </td>
														   <td style="text-align:center; ">'.$r->balanceCurrency.' </td>
														   <td style="text-align:center; "> '.$r->DatePay.'</td>
														  </tr>';
			
														     
													  
												    }
														  
												 
								              
							           	      } 
							              
							             echo '  </table> 
						                    </div>';
				                          
				             
							         
			               
		echo '	    <br/>
			      <div style="text-indent: 200px; font-weight: bold; font-style: italic;"> &nbsp;&nbsp;&nbsp;'.Yii::t('app','Authorized signature').'</div><br/><br/>
			         
			       </div>
			      
			     </div>';
										
	   ?>
   
<?php  
                  }
                            
                            
?>
          </div>           
  	   </label>
    </div> 

                          <div class="col-submit">
 
                                
                                <?php  
                                       $showPrint=false;
                                       
                                       if(!isset($_GET['from'])||($_GET['from']!='ad'))
                                        {
                                          	 if($dataPro->getData()!=null)
                                          	    $showPrint = true;
                                          	    
                                          	}
                                       
                                       
                                       if($showPrint)
                                         {
                                           ?>
						<a  class="btn btn-success col-4" style="margin-left:10px; margin-right: 5px;" onclick="printDiv('print_receipt')"><?php echo Yii::t('app','Print'); ?></a>
                                        <?php 
                                         }
                                         
                                         
                                              //back button   
                                   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo '  <a href="'.$explode_url[0].'php'.$this->back_url.'" style="margin-left:10px;" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                              
                                      
                                          

                                ?>
     
                                 
                  </div><!-- /.table-responsive -->
                  
<?php
   }
  else
   {
   	  				             
           echo '<div id="header" style="display:none; ">
                 
                  <div class="info"> <b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' &nbsp; / &nbsp; '.Yii::t('app','Tel: ').$school_phone_number.' &nbsp; / &nbsp; '.Yii::t('app','Email: ').$school_email_address.'<br/></div> 
                  
                  <br/> 
                  
                  <div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Payment receipt'), pa_daksan() )).'</b></div>
                  <br/>
                  </div> '; 

   	
   }
?>

                  
                </form>
              </div>



</div>






<script type="text/javascript">
    
function printDiv(divName) {
     document.getElementById("header").style.display = "block";
     document.getElementById(divName).style.display = "block";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
     document.getElementById("header").style.display = "none";
} 


</script>
