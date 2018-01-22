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
/* @var $this PayrollController */
/* @var $dataProvider CActiveDataProvider */

  $acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year']; 

$template = '{print}';

 $this->grouppayroll=Yii::app()->session['payroll_group_payroll'];

?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Manage Runnig payroll'); ?>
              
          </h2> </div>
     
		   <div class="span3">
 
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{print}{update}{delete}';  
        
   ?>

            
 <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/payroll/create/di/1/part/pay/from/stud')); 
               ?>
   </div>
 <!--  
    <div class="span4">
             <?php
                 
              //   $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';
                           // build the link in Yii standard 
               //  echo CHtml::link($images,array('/billings/payroll/update/id//group//di/1/part/pay/from/stud' ));
	                   
              ?>
              
    </div> 
-->

<?php
        }
      
      ?>       

   
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/payroll/index/di/1/part/pay/from/stud')); 
               ?>
  </div>  


  </div>

</div>


<div style="clear:both"></div>




<div class="b_m">


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        

<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'payroll-form',
	'enableAjaxValidation'=>false,
));

?>
                           
     
      						<div class="span2" >
                                
                                <?php echo $form->errorSummary($model); ?>
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Depenses Items'));
                                        
                                        if(isset($this->depensesItems1)&&($this->depensesItems1!=''))
							       echo $form->dropDownList($model,'depensesItems',$this->loadDepensesItems(), array('onchange'=> 'submit()','options' => array($this->depensesItems1=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'depensesItems',$this->loadDepensesItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
                            
            
            
      
                     
                     
<?php $this->endWidget(); ?>
                   
        </div>
    </div>


<br/>


<ul class="nav nav-tabs nav-justified">  
<?php
      $last_dat = ''; 
     $display = true;
       
     $month_ = 0;
     $year_ =0;
     $current_month =0;
     $current_year =0;
     $i = 0;
     $class = "";
     $all='';
     
         $di = 1;
     if($this->status_ == 1)
		  $di = 1;
		elseif($this->status_ == 2)
		  $di = 2;
		  
          
       if($this->grouppayroll==1)//employee
          $all='e';
       elseif($this->grouppayroll==2)//teacher
           $all='t';
     
     if(!isset($_GET['month_']))
       {
       	   $sql__ = 'SELECT DISTINCT payroll_month,payroll_date,payment_date FROM payroll p LEFT JOIN payroll_settings ps ON(ps.id = p.id_payroll_set) LEFT JOIN academicperiods a ON(a.id = ps.academic_year) WHERE a.id='.$acad.' ORDER BY payment_date DESC';
												
		  $command__ = Yii::app()->db->createCommand($sql__);
		  $result__ = $command__->queryAll(); 
													       	   
			if($result__!=null) 
			 { foreach($result__ as $r)
			     { if(($r['payroll_month']!='')&&($r['payroll_month']!=0))  
			        { $current_month = $r['payroll_month'];
			         $current_year = getYear($r['payroll_date']);
			         $last_dat = $r['payment_date']; 
			        } 
			          break;
			          
			     }
			  }
			
			if(!isDateInAcademicRange($last_dat,$acad))
              $display = false;

       	  
        }
     else 
       {  $current_month = $_GET['month_'];
       	  $current_year = $_GET['year_'];
        }


  if($display)
    {
  
     $sql = 'SELECT DISTINCT p.id, payroll_month,payroll_date,payment_date FROM payroll p LEFT JOIN payroll_settings ps ON(ps.id = p.id_payroll_set) LEFT JOIN academicperiods a ON(a.id = ps.academic_year) WHERE a.id='.$acad.' ORDER BY payment_date ASC, payroll_date ASC';
     
												
	  $command = Yii::app()->db->createCommand($sql);
	  $result = $command->queryAll(); 
												       	   
		if($result!=null) 
		 { 
		 	$old_month = '';
		 	$new_month = '';
		 	
		     foreach($result as $s){

			    
			     $month_=$s['payroll_month'];
			      $year_=getYear($s['payroll_date']);
				        
				         if($month_!=$current_month)
				             $class = "";
				         else 
				           { if($year_!=$current_year)
				               $class = "";
				             else
				                 $class = "active";
				           
				            }
				         
				         $new_month = getShortMonth($s['payroll_month']).' '.getYear($s['payroll_date']);
				         
				         if($old_month!= $new_month)
				           {
				         echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/billings/payroll/index?month_='.$month_.'&year_='.getYear($s['payroll_date']).'&all='.$all.'&di='.$di.'&from=em">';    
				            
				             echo getShortMonth($s['payroll_month']).' '.getYear($s['payroll_date']);

				         echo'</a></li>';
				             
				              $old_month = getShortMonth($s['payroll_month']).' '.getYear($s['payroll_date']);
				           
				           }
			          
			      }
         
     
		 }
		
    } 
		 
?>
</ul>




<div class="grid-view">
<?php 

 $header='';
     $mwa='';
  $condition=''; 
  $params='';   
              
 if(isset($_GET['all']))
  {	
  	      
           if(isset($_GET['month_'])&&($_GET['month_']!=''))
               $mwa = $_GET['month_'];
           if(isset($_GET['year_'])&&($_GET['year_']!=''))
               $year = $_GET['year_'];
            
                                 
                                $condition='p.is_student=0 AND p.active IN(1, 2) AND pl.payroll_month='.$mwa.' AND ps.as IN(0,1) AND YEAR(pl.payment_date)='.$year;
                                $params=$mwa.','.$year;  
                                    
                                
                                      $header=Yii::t('app','Full name');
                                   
       }
   else
    {
    	   
             $condition='is_student=0 AND active IN(1, 2) AND pl.payroll_month='.$current_month.' AND ps.as IN(0,1) AND YEAR(pl.payment_date)='.$current_year;
                                  $params= $current_month.','.$current_year;
             $header=Yii::t('app','Full name');
               

    	
      }  
   

?>


<!-- <div  class="search-form">
<?php 
/*


Yii::app()->clientScript->registerScript('searchPersonsForShowingPayroll('.$condition.','.$acad.')', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#payroll-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


    $this->renderPartial('_search',array(
	'model'=>$model,
)); 
*/
?>
</div> --><!-- search-form -->
 



 
<?php      	
       if((isset($_GET['msguv_'])&&($_GET['msguv_']=='y'))&&(isset($_GET['all_'])&&($_GET['all_']!='')))
          {
          	 $all='';
          	 
          	 if($_GET['all_']=='t')
          	   $all=2;
          	 elseif($_GET['all_']=='e')
          	   $all=1;
          	   
          	   if(($this->grouppayroll==$all)&&($this->payroll_month==$_GET['mwa']))
          	       $this->message_UpdatePastDate=true;
          	 
          }
	
	
	        if(isset(Yii::app()->session['message_group_anyPayrollAfter']) &&(Yii::app()->session['message_group_anyPayrollAfter']==1))
	            $this->message_group_anyPayrollAfter = true;
	        else
	           $this->message_group_anyPayrollAfter = false;
	
			//error message
	    if(($this->message_UpdatePastDate)||($this->message_group_anyPayrollAfter))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-top:15px; margin-bottom:-43px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }			      
				 				   
				  if($this->message_UpdatePastDate)
				     { echo '<span style="color:red;" >'.Yii::t('app','19 days after payment date, Update Action is denied.<br/>').'</span>';
				       $this->message_UpdatePastDate=false;
				     }
				     
				  if($this->message_group_anyPayrollAfter)
				     { echo '<span style="color:red;" >'.Yii::t('app','People who have payroll already done for any month that follow this one are rejected.').'</span>';
				      
				       unset(Yii::app()->session['message_group_anyPayrollAfter']);
				     }
				     
		if(($this->message_UpdatePastDate)||($this->message_group_anyPayrollAfter))		 
			{ echo '</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';
           
                  if($this->message_group_anyPayrollAfter)
				    $this->message_group_anyPayrollAfter=false;
				      

			}
       	  	 
	       	  	$dataProvider=Payroll::model()->searchPersonsForShowingPayroll($condition,$acad);
	       	  	
	$month_=$current_month;
	$year_=$current_year;
	$di= 1;
	if(isset($_GET['month_']))
	   $month_= $_GET['month_'];
	
	if(isset($_GET['year_'])) 
	   $year_= $_GET['year_'];
	   
	 if(isset($_GET['di'])) 
	   $di= $_GET['di'];   	  	

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
  
  
   $gridWidget =  $this->widget('groupgridview.GroupGridView', array(
					    'id'=>'payroll-grid',
						'dataProvider'=>$model->searchPersonsForShowingPayroll($condition,$acad),//$dataProvider,
						'showTableOnEmpty'=>true,
	                    'mergeColumns'=>array('payment_date', $header,'payroll_month'),
						//'filter'=>$model,
					    'columns'=>array(
						
						
						array('name' =>Yii::t('app','Date'), 
						       'header' =>Yii::t('app','Date'), 
					            'value'=>'$data->PaymentDate', 
					             ),
         
                       array('name'=>$header,
					                'header'=>$header,
					                'type' => 'raw',
						        'value'=>'CHtml::link($data->first_name." ".$data->last_name,Yii::app()->createUrl("/billings/payroll/view",array("id"=>$data->id, "month_"=>'.$month_.', "year_"=>'.$year_.', "di"=>'.$di.', "from"=>"")))'
								),
					    
					    array('header' =>Yii::t('app','Gross salary'), 
					               'type' => 'raw',
					            'value'=>'CHtml::link($data->getGrossSalaryInd($data->person_id,'.$params.'),Yii::app()->createUrl("/billings/payroll/view",array("id"=>$data->id, "month_"=>'.$month_.', "year_"=>'.$year_.', "di"=>'.$di.', "from"=>"")))',
					             ),
					    
					    //'number_of_hour',
						/*	array('name'=>'number_of_hour',
							                'header'=>Yii::t('app','Number Of Hour'),
								        'value'=>'$data->NumberHour',
										),
							*/
					   /*  array('header' =>Yii::t('app','Deduction').' ('.Yii::t('app','Missing hour').')', 
					            'value'=>'$data->getMissingHourDeduction($data->person_id,$data->missing_hour)',
					             ),
					     */
					      
						//'taxe', 
						array('name'=>Yii::t('app','Taxe'),
						                'header'=>Yii::t('app','Taxe'),
							        'value'=>'$data->Taxe',
									),
									
						array('name'=>Yii::t('app','Loan(deduction)'),
						                'header'=>Yii::t('app','Loan(deduction)'),
		         'value'=>'$data->getLoanDeduction($data->person_id,$data->getGrossSalaryIndex_value($data->person_id,'.$params.'),$data->number_of_hour,0,$data->net_salary,$data->taxe)', //'$data->getLoanDeduction($data->person_id,$data->getGrossSalary($data->person_id),$data->number_of_hour,$data->missing_hour,$data->net_salary,$data->taxe)',
									),
						 			
						
						array('header' =>Yii::t('app','Net Salary'), 
					            'value'=>'$data->NetSalary',
					             ),
					             
					   
					
					    	array(
			'class'=>'CButtonColumn',
			    'template'=>$template,
                         'buttons'=>array('print'=>array('label'=>'<span class="fa fa-print"></span>',
                            'imageUrl'=>false,     
                            'url'=>'Yii::app()->createUrl("/billings/payroll/receipt?id=$data->id&part=balanc")',
                            'options'=>array('title'=>Yii::t('app','Print')),
                             
                            ),
                           'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/billings/payroll/update?id=$data->id&di='.$di.'&part=rec&from=stud")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                           'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('payroll-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             

		),          
							
					       ),
					    ));
					    
 


  
    // Export to CSV 
  $content=$model->searchPersonsForShowingPayroll($condition,$acad)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));



?>



</div>


