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
/* @var $this ChargePaidController */
/* @var $dataProvider CActiveDataProvider */


  $acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$template = '';

?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Other Expenses'); ?>
              
          </h2> </div>
     
		   <div class="span3">

 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{update}{delete}';  
        
   ?>


             
 <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/chargePaid/create/di/2/part/pay/from/stud')); 
               ?>
   </div>
   
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
	'id'=>'charge-paid-form',
	'enableAjaxValidation'=>false,
));

?>
                           
     
      						<div class="span2" >
                                
                                <?php echo $form->errorSummary($model); ?>
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Depenses Items'));
                                        
                                  if(isset($this->depensesItems2)&&($this->depensesItems2!=''))
							       echo $form->dropDownList($model,'depensesItems',$this->loadDepensesItems(), array('onchange'=> 'submit()','options' => array($this->depensesItems2=>array('selected'=>true)))); 
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
     
       $di = 1;
     if($this->status_ == 1)
		  $di = 1;
		elseif($this->status_ == 2)
		  $di = 2;
		  
          
     
     
     if(!isset($_GET['month_']))
       {
       	   $sql__ = 'SELECT DISTINCT payment_date FROM charge_paid cp LEFT JOIN academicperiods a ON(a.id = cp.academic_year) WHERE a.id='.$acad.' ORDER BY payment_date DESC';
												
		  $command__ = Yii::app()->db->createCommand($sql__);
		  $result__ = $command__->queryAll(); 
													       	   
			if($result__!=null) 
			 { foreach($result__ as $r)
			     { if($r['payment_date']!='0000-00-00')
			        { $current_month = getMonth($r['payment_date']);
			         $current_year = getYear($r['payment_date']);
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
 
     $sql = 'SELECT DISTINCT payment_date FROM charge_paid cp LEFT JOIN academicperiods a ON(a.id = cp.academic_year) WHERE a.id='.$acad.' ORDER BY payment_date ASC';
												
	  $command = Yii::app()->db->createCommand($sql);
	  $result = $command->queryAll(); 
												       	   
		if($result!=null) 
		 { 
		     foreach($result as $s){

			    
			     $month_=getMonth($s['payment_date']);
			      $year_=getYear($s['payment_date']);
				        
				         if($month_!=$current_month)
				             $class = "";
				         else 
				           { if($year_!=$current_year)
				               $class = "";
				             else
				                 $class = "active";
				           
				            }
				         
				         echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/billings/chargePaid/index?month_='.$month_.'&year_='.getYear($s['payment_date']).'&di='.$di.'&from=em">';    
				            
				             echo getShortMonth($month_).' '.getYear($s['payment_date']);

				         echo'</a></li>';
				    
			          
			      }
         
     
		 }
		 
    }
     
?>
</ul>




<div class="grid-view">
<?php

Yii::app()->clientScript->registerScript('searchByMonth('.$current_month.','.$acad.')', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#charge-paid-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>



 
<?php      	
   

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
  
  
   $gridWidget =  $this->widget('groupgridview.GroupGridView', array(
					    'id'=>'charge-paid-grid',
						'dataProvider'=>$model->searchByMonth($current_month, $acad),
						'showTableOnEmpty'=>true,
	                   // 'mergeColumns'=>array($header,'payroll_month'),
						//'filter'=>$model,
					    'columns'=>array(
						  'id',
							//'id_charge_description',
							array('header' =>Yii::t('app','Id Charge Description'), 
					            'value'=>'$data->idChargeDescription->description',
					             ),
							array('header' =>Yii::t('app','Amount'), 
					            'value'=>'$data->Amount',
					             ),
							
						array('header' =>Yii::t('app','Date'), 
					            'value'=>'$data->ExpenseDate',
					             ),
                         'comment',
                                                  					          
					       
					    	array(
			'class'=>'CButtonColumn',
			    'template'=>$template,
                         'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                           'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('charge-paid-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             

		),          
							
					       ),
					    ));
					    

  
    // Export to CSV 
  $content=$model->searchByMonth($current_month, $acad)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));



?>



</div>





