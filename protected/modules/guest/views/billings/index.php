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

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad=Yii::app()->session['currentId_academic_year'];
 $acad_name=Yii::app()->session['currentName_academic_year'];


$condition = '';

?>


		
<div id="dash">
		<div class="span3"><h2>
 <?php echo Yii::t('app','My Transactions'); ?> </h2> </div>
      <div class="span3">
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                           // build the link in Yii standard
                 echo CHtml::link($images,array('/guest/fees/index')); 
               ?>
  </div>  


</div>
</div>
 
<div style="clear:both"></div>	

		
		<?php 
	    	 $userName='';
		     $group_name='';
		     
		       if(isset(Yii::app()->user->name))
		           $userName=Yii::app()->user->name;
	
	if(isset(Yii::app()->user->groupid))
	   {    
	      $groupid=Yii::app()->user->groupid;
	      $group=Groups::model()->findByPk($groupid);
			
					                    
			
		  $group_name=$group->group_name;
	   }	
	   
	   
	   
if($group_name=='Parent')
	{	
			  	
	?>
	<div style="margin-bottom:80px;">
	<?php 	
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	//'enableAjaxValidation'=>true,
)); 


			  	
		?>	
		    <!--evaluation-->
			<div class="left" style="margin-right:5px;">
			<label for="student"><?php echo Yii::t('app','Child'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
	 <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	//'enableAjaxValidation'=>true,
)); 

					
					         $modelPerson= new Persons();
							    if(isset($this->student_id))
							       echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()')); 
						           }					      
				
					    		$this->endWidget(); 				
					   ?>
				</div>
		<?php		
				
	     $this->endWidget();    		         	
		    ?>
		    </div>
		    

	<?php    }
		       elseif($group_name=='Student')
		         {
		         	?>
	<div style="margin-bottom:0px;">
	<?php 	
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	//'enableAjaxValidation'=>true,
)); 

	         	
		         	$user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
		         	    
	     	    
		         	  $this->endWidget();    		         	
		    ?>
		    </div>
		    <?php
		        
		         }
		       
	     ?>	
			
				

<div style="clear:both"></div>


   
   <!--  ************************** payment receipt *************************    -->
   
<div id="payment_receipt" >
       

<div class="grid-view">

	<?php
	
		//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                                                                                //Extract school address
				   								$school_address = infoGeneralConfig('school_address');
                                                                                                //Extract  email address 
                                                $school_email_address = infoGeneralConfig('school_email_address');
                                                                                                //Extract Phone Number
                                                $school_phone_number = infoGeneralConfig('school_phone_number');


	//get level for this student
								$level=0;
								$modelLevel=$this->getLevelByStudentId($this->student_id,$acad);
								if($modelLevel!=null)
								 {
								 	$level=$modelLevel->id;
								 	
								   }
								
									
?>
	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
       
<?php
   
$levelName='';
         if($this->student_id!='')
           {  if($this->getLevelByStudentId($this->student_id,$acad)!=null)
                 $levelName=$this->getLevelByStudentId($this->student_id,$acad)->level_name;
                 
           }
         
         $student=$this->getStudent($this->student_id);
         
		 

?>  

 <div style="width:90%;">
            <label id="resp_form" style="width:100%;">
  
       

      <?php
         				             
           echo '<div id="rpaie" style="float:left; padding:10px; border:1px solid #EDF1F6; width:98%; ">
                  <div class="info"> <b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' <br/>Tel.: '.$school_phone_number.'<br/>E-mail: '.$school_email_address.'<br/></div> 
                  
                  <br/>
                  
                  <div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Payment receipt'), pa_daksan() )).'</b></div> '; 
			
			echo '<br/>
			
			    <div class="info" >
			      <div style="float:left;">'.Yii::t('app','Name').':  '.$student.' </div>
			     
			           <div style="margin-left:62%;">'.Yii::t('app','Level').': '.$levelName.'</div> 
			           
			      
			         <br/><div style="margin-left:62%;">'.Yii::t('app','Academic year').' '.$acad_name.' </div>   ';
			         
			         					  
					  						                
			           	
				if($this->student_id!='')
				   $dataPro = Billings::model()->searchByStudentId($condition,$this->student_id,$acad);
				else
				    $dataPro = Billings::model()->searchByStudentId($condition,0,$acad);

 
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
	   </label>
    </div> 

<br/>
                 
                            <div class="col-submit">
 
                                
                                <?php  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                       
									       
									       echo '<a  class="btn btn-success col-4" style="margin-left:10px; " onclick="printDiv(\'rpaie\')">'. Yii::t('app','Print').'</a>';
									       
									     
									     echo '<br/>';
									               
                                                                                
                                         
                                              
                                          

                                ?>
     
                            
                  </div><!-- /.table-responsive -->
                  
<?php
 
?>

                  
                </form>
              </div>



</div>



</div>



<script type="text/javascript">
    
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

