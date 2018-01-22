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



$siges_structure = infoGeneralConfig('siges_structure_session');
	     
	   if($siges_structure==1)
	    {
	         $sess=Yii::app()->session['currentId_academic_session'];  
             $sess_name=Yii::app()->session['currentName_academic_session'];	
	      }

    
$acad=Yii::app()->session['currentId_academic_year']; 

 if($siges_structure==1)
 {  if( $sess=='')
        $acad_sess = 0;
    else 
		$acad_sess = $sess;
 }
 elseif($siges_structure==0)
   $acad_sess = $acad;


$acad_name=Yii::app()->session['currentName_academic_year'];
$currency_symbol = Yii::app()->session['currencySymbol'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

$modelOtherIncome = new OtherIncomes;



if(isset($_GET['from'])&&($_GET['from']=='ind'))
{
	 
?>


<div  id="resp_form_siges">

        <form  id="resp_form">

<div style="width:100%;">
<label id="resp_form" style="width:100%;">

 <div class="span6">
 		
 		<div class="activat">

<?php		
 echo '<div class="CDetailView_photo" >';
	if($model->getUsername($model->id)!=null){
                         $user_name = $model->getUsername($model->id); 
                     }else {
                         $user_name = 'N/A';
                     }	 
		 
                        
		   	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
				
                                array('name'=>'birthday','value'=>$model->birthday_),
                                'sexe',
                                array(     'header'=>Yii::t('app','Blood Group'),
		                    'name'=>Yii::t('app','Blood Group'),
		                    'value'=>$model->getBlood_group(),
		                ),  
				'adresse',
				'phone',
				'email',
               array('label'=>Yii::t('app','Birth place'),'name'=>'cities0.city_name'),
				
				array(     'header'=>Yii::t('app','Username'),
		                    'name'=>Yii::t('app','Username'), 
		                    'value'=>$user_name,
		                ), 
				'status',
				
				
					),
				));
				
		 		      
		 	echo '</div>';	      
    ?>
		   	
 		</div>
       
  </div> 
   	

			 
<div class="photo_"  >
   <div class="photo_view" style="margin-top:0px; margin-bottom:29px;">


<?php
        echo '<div  style="width:100%; text-align:center;" >';

// **********student name*************

 echo $model->fullName;

    echo '</div>';  
 if($model->image!=null)
                     
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/photo-Uploads/1/'.$model->image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
	                 
			
 ?>
 </div> 
</div> 

 
 
                             <!--  ************************** STUDENT MORE INFO *************************    -->
                             
<div class="CDetailView_photo" style=" margin-top:-15px;" >

		         
		<?php
		         $create_student_moreInfo=false;
		         
		         
		       $modelStudentOtherInfo = StudentOtherInfo::model()->find('student=:IdStudent',array(':IdStudent'=>$_GET['id'] ));
		       
		        
		      $this->widget('zii.widgets.CDetailView', array(
			'data'=>$modelStudentOtherInfo,
			'attributes'=>array(
			
			array('name'=>'school_date_entry','value'=>$modelStudentOtherInfo->schoolDateEntry),
			
			array( 'header'=>Yii::t('app','Previous school'),
                   'name'=>Yii::t('app','Previous school'),
                   'value'=>$modelStudentOtherInfo->previous_school,
                   //'htmlOptions'=>array('width'=>'200px'),
				),
		
		    array( 'header'=>Yii::t('app','Previous level name'),
                   'name'=>'previous_level',
                   'value'=>$modelStudentOtherInfo->getPreviousLevel($modelStudentOtherInfo->previous_level),
                   //'htmlOptions'=>array('width'=>'200px'),
				 ),
				 
		   array( 'header'=>Yii::t('app','Apply for level'),
                   'name'=>Yii::t('app','Apply for level'),
                   'value'=>$modelStudentOtherInfo->getPreviousLevel($modelStudentOtherInfo->apply_for_level),
                   //'htmlOptions'=>array('width'=>'200px'),
				 ),
				 
		    'health_state',
		    'father_full_name',
		    'mother_full_name',	
		    'person_liable',
		    'person_liable_phone',			
			'leaving_date'
			//array('name'=>'leaving_date','value'=>$modelStudentOtherInfo->leavingDate),
						 
					),
				));
				
				
				
	?>

</div>  </label>

</div>
 </form>
              

</div>


<?php
  }
else
 {
 	
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
                          <?php    $modelStudentOtherInfo = new StudentOtherInfo;
                          
                          echo $form->labelEx($modelStudentOtherInfo,'apply_for_level'); ?>
								<?php 
								
								
		                    
		                    
		                    	$modelStudentOtherInfo = StudentOtherInfo::model()->findByAttributes(array('student'=>$_GET['id']));
		                		$this->previous_level = $modelStudentOtherInfo->previous_level;
		                		
		                					
								if($this->applyLevel!='')
							    echo $form->dropDownList($modelStudentOtherInfo,'apply_for_level',$this->loadApplyLevel($this->previous_level), array('onchange'=> 'submit()','options' => array($this->applyLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelStudentOtherInfo,'apply_for_level',$this->loadApplyLevel($this->previous_level),array('onchange'=> 'submit()')); 
							  	
								 ?>
								<?php echo $form->error($modelStudentOtherInfo,'apply_for_level'); ?>
                           </label>
        </div>


<?php      	
      $this->student_id = $_GET['id'];
       
         $condition ='fl.status=1 AND ';
         
$levelName='';
$fee_cost = 0;
$student= '';


 	$apply_for_level=$this->applyLevel;
 	
 	if($this->applyLevel!='')
 	  { $modelFeeCost = Fees::model()->find(array('alias'=>'f','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'f.level='.$this->applyLevel.' and fl.status=0'));
 	  	 if($modelFeeCost!=null)
 	       $fee_cost = $modelFeeCost->amount;
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
                echo '  <div class="info"> <b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' <br/>'.Yii::t('app','Tel: ').$school_phone_number.'<br/>'.Yii::t('app','Email: ').$school_email_address.'<br/></div> 
                  
                  <br/>';
     
       
             
                        $dataPro = null;
                        
                       
                        if($this->applyLevel!='')
                         {
                            $date_end = AcademicPeriods::model()->findByPk($acad_sess)->date_end;
				            $year_end = date("Y",strtotime($date_end));
				            $string_year = $year_end.'-'.($year_end+1);
				            //echo Yii::t('app','Academic year').': '.$string_year; 
                            
                             echo '<div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Admission sheet'), pa_daksan() )).'</b> <br/> '.Yii::t('app','Academic year').' '.$string_year.' </div> '; 
			
			echo '<br/>';
                 ?>

<?php
    		//error message 
       	if($this->messageCostEmpty)		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-48px; ';//-20px; ';
				      echo '">';
				      	
				      	echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';			      
			      
			       echo '<span style="color:red;" >'.Yii::t('app','Cost cannot be empty.').' '.Yii::t('app','It must be a positif number.').'</span>';
				        $this->messageCostEmpty=false;
				        echo'</td>
					    </tr>
						</table>';
					
				           echo '</div>
				           <div style="clear:both;"></div>';
				     }
				     			     	
				  
			
			       
?>

             
      <div class="box">
        
        
        <div class="box-body grid-view" style="padding: 10px;">
            <table class="table-condensed table-responsive" style=" border: 0px solid #DEDAD5;">
                <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','No. '); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php echo Yii::t('app','AR').'-'.$this->student_id; ?></span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','School Date Entry'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStudentOtherInfo!=null)
                                                        echo ChangeDateFormat($modelStudentOtherInfo->school_date_entry); ?></span></td>
                </tr>
                <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Cost'); ?></b></td>
                    <td style="width: 25%; padding-bottom: 15px;"><span class="pull-left"><?php echo $currency_symbol;?>
                            <?php 
                                   if(isset($_GET['p'])&&($_GET['p']!='')) 
                                     $model->setAttribute('cost',$_GET['p']);
                                     
                          echo '<div class="p_input" style="float:right;"> '.$form->textField($model,'cost', array('size'=>2,'placeholder'=>Yii::t('app',''))).' </div>';
                                   
                                  
                               ?>
</span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','Apply for level'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php echo Persons::model()->getShortLevelById($this->applyLevel); ?></span></td>
                    
                </tr>
                <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Previous Level'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStudentOtherInfo!=null)
                                                        echo Persons::model()->getShortLevelById($modelStudentOtherInfo->previous_level); ?></span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','Previous School'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStudentOtherInfo!=null)
                                                        echo $modelStudentOtherInfo->previous_school; ?></span></td>
                </tr>
                <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Last Name'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                                                        echo $modelStud->last_name; ?></span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','First Name'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                                                        echo $modelStud->first_name; ?></span></td>
                 </tr>
                 <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Gender'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                                                        echo $modelStud->getGenders1(); ?></span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','Birth place'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                    														{  if($modelStud->cities0 !=null)
                                                        echo $modelStud->cities0->city_name; }?></span></td>
                 </tr>
                 
                 <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Birthday'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                                                        echo ChangeDateFormat($modelStud->birthday); ?></span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','Phone'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                                                        echo $modelStud->phone; ?></span></td>
                 </tr>
                 <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Email'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                                                        echo $modelStud->email; ?></span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','Addresse'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                                                        echo $modelStud->adresse; ?></span></td>
                 </tr>
                 
                 <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Father full name'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStudentOtherInfo!=null)
                                                        echo $modelStudentOtherInfo->father_full_name; ?></span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','Mother full name'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStudentOtherInfo!=null)
                                                        echo $modelStudentOtherInfo->mother_full_name; ?></span></td>
                 </tr>
                 
                 <tr>
                     <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Person liable'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStudentOtherInfo!=null)
                                                        echo $modelStudentOtherInfo->person_liable; ?></span></td>
                    <td style="width: 25%"><b><?php echo Yii::t('app','Person liable phone'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStudentOtherInfo!=null)
                                                        echo $modelStudentOtherInfo->person_liable_phone; ?></span></td>
                 </tr>
                 <tr>
                    <td style="width: 25%; padding-bottom: 15px;"><b><?php echo Yii::t('app','Comment').'/'.Yii::t('app','filed parts'); ?></b></td>
                    <td style="width: 25%"><span class="pull-left"><?php if($modelStud!=null)
                                                        echo $modelStud->comments; ?></span></td> 
                 </tr>
                 
                 
                 
            </table>
        </div>
        <br/><br/>
        <div class="box-footer" style="text-align: center">
            <div class="span6">
                
            <?php 
            echo '____________________________________<br/>'; 
            echo Yii::t('app','Authorized Direction member signature'); 
            
            ?>
            </div>
            <div class="span6">
            <?php 
            echo '____________________________________<br/>'; 
            echo Yii::t('app','Person liable'); 
           
            ?>
                
            </div>
            <hr/>
            <br>
        </div>
    
        <footer style="text-align: justify; font-size: 11px;" >
            <?php
                $criteria_ = new CDbCriteria;
                $criteria_->condition='item_name=:item_name';
                $criteria_->params=array(':item_name'=>'pied_fiche_ad',);
                $pied_fiche_ad = GeneralConfig::model()->find($criteria_)->item_value;
                echo $pied_fiche_ad; 
            ?>
        </footer>
        
    </div>
    
 
   
                 <?php  
                  }
                                                
                            
                            echo '<div style="float:right; text-align: right; font-size: 6px; margin-bottom:-8px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>';
?>
          </div>           
  	   </label>
    </div> 

                          <div class="col-submit">
 
                                
                                <?php  
                                       $showPrint=false;
                                       
                                         if(isset($_GET['p'])&&($_GET['p']!='')&&($_GET['p']!=0))
                                           $cost=$_GET['p'];
                                         else
                                           $cost=0;
                                           
                                         
                                         	if(($cost!='')&&($cost!=0))
                                         	  $showPrint = true;
                                         	  
                                                                               
                                     
                          if(!$showPrint)
                               echo CHtml::submitButton(Yii::t('app', 'Pay admission'),array('id'=>'payAdmission','name'=>'payAdmision','class'=>'btn btn-warning'));
                          
                                       //if($showPrint)
                                        // {     
                                ?>           
						<a  class="btn btn-success col-4" style="margin-left:10px; margin-right: 5px;" onclick="printDiv('print_receipt')" ><?php echo Yii::t('app','Print'); ?></a>
                                        <?php 
                                       //  }
                                         
                                         
                                              //back button   
                                   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
                                              
				                        if(!$showPrint)
                                              echo '  <a href="'.$explode_url[0].'php'.$this->back_url.'" style="margin-left:10px;" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                              
                                      
                                          

                                ?>
     
                                 
                  </div><!-- /.table-responsive -->
                  




                  
                </form>
              </div>

</div>


<?php
 }

 
?>


<script type="text/javascript">

$(document).ready(function(){
	validate(); 
	
	$('#Persons_cost').change(validate);
	
	
	
	});
	
	
	function validate(){
		if($('#Person_cost').val().length > 0){
			$("button[name=payAdmission]").prop("disabled",false);
			$("button[name=print]").prop("disabled",false);
			}
			else{
				$("button[name=payAdmission]").prop("disabled",true);
				$("button[name=print]").prop("disabled",true);
				}
		}
    
function printDiv(divName) {
     document.getElementById(divName).style.display = "block";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    // document.getElementById(divName).style.display = "none";
} 


</script>
