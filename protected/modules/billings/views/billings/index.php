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

   
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$template = '{view}';


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

	
?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php if($this->status_==1)
                      echo Yii::t('app','Manage Billings');
                    elseif($this->status_==0)
                       echo Yii::t('app','Manage other fees');
                    
                  ?>
              
          </h2> </div>
     
		   <div class="span3">
             
<?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{view}{update}{delete}';  
        
   ?>

     <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 
                 if($this->recettesItems==0)
                     echo CHtml::link($images,array('/billings/billings/create/part/rec/ri/0/from/stud'));
                  elseif($this->recettesItems==1)
                     echo CHtml::link($images,array('/billings/billings/create/part/rec/ri/1/from/stud'));
                   elseif($this->recettesItems==2)
                     echo CHtml::link($images,array('/billings/otherIncomes/create/part/rec/ri/2/from/stud')); 
               ?>
   </div>
   
  <?php
        }
      
      ?>       

 
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 
                 if($this->recettesItems==0)
                     echo CHtml::link($images,array('../site/index')); 
                  elseif($this->recettesItems==1)
                     echo CHtml::link($images,array('/billings/billings/index/part/rec/ri/0/from/stud'));
                   
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
	'id'=>'billings-form',
	'enableAjaxValidation'=>false,
));

?>
                           
     
      						<div class="span2" >
                                
                                <?php echo $form->errorSummary($model); ?>
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Recettes Items'));
                                        
                                        if(isset($this->recettesItems)&&($this->recettesItems!=''))
							       echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()')); 
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
     $ri = 0;
     if($this->status_ == 1)
		  $ri = 0;
		elseif($this->status_ == 0)
		  $ri = 1;
		  
     $condition ='fl.status='.$this->status_.' AND ';
       
     $month_ = 0;
      $year_ = 0;
     $current_month =0;
     $current_year =0;
     $i = 0;
     $class = "";
     
     $last_dat = ''; 
     $display = true;
 
     
     if(!isset($_GET['month_']))
       {
       	   $sql__ = 'SELECT DISTINCT date_pay FROM billings b INNER JOIN fees f ON( f.id = b.fee_period ) INNER JOIN fees_label fl ON( fl.id = f.fee ) LEFT JOIN academicperiods a ON(a.id = b.academic_year) WHERE a.id='.$acad_sess.' AND date_pay <> \'0000-00-00\' AND fl.status='.$this->status_.' ORDER BY date_pay DESC';
												
		  $command__ = Yii::app()->db->createCommand($sql__);
		  $result__ = $command__->queryAll(); 
													       	   
			if($result__!=null) 
			 { foreach($result__ as $r)
			     { $current_month = getMonth($r['date_pay']);
			      $last_dat = $r['date_pay']; 
			          break;
			     }
			  }
			else
			  $current_month = getMonth(date('Y-m-d'));
       	  // $month_display=$current_month;
       	  
       	  
       	   if(!isDateInAcademicRange($last_dat,$acad_sess))
             { $display = false;
             }

       	  
        }
     else 
       {  $current_month = $_GET['month_'];
       	  //$month_display= $_GET['month_'];
        }

 
  if($display)
    {
  
     $sql = 'SELECT DISTINCT date_pay FROM billings b INNER JOIN fees f ON( f.id = b.fee_period ) INNER JOIN fees_label fl ON( fl.id = f.fee ) LEFT JOIN academicperiods a ON(a.id = b.academic_year) WHERE a.id='.$acad_sess.'  AND date_pay <> \'0000-00-00\' AND fl.status='.$this->status_.'  ORDER BY date_pay ASC';
												
	  $command = Yii::app()->db->createCommand($sql);
	  $result = $command->queryAll(); 
												       	   
		if($result!=null) 
		 { 
		     foreach($result as $s){
			        
			       if($i==0)
			         { $i=1;
				         $month_=getMonth($s['date_pay']);
				        
				         if($month_!=$current_month)
				             $class = "";
				         else 
				            $class = "active";
				         
				         echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/billings/billings/index?month_='.$month_.'&ri='.$ri.'">';    
				            
				            echo getShortMonth(getMonth($s['date_pay'])).' '.getYear($s['date_pay']);
				         echo'</a></li>';
				         
			         
			         } 
			      elseif($month_!=getMonth($s['date_pay']))
			         {
			         	
				           $month_=getMonth($s['date_pay']);
				           if($month_!=$current_month)
				             $class = "";
				           else 
				            $class = "active";
				             
				           echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/billings/billings/index?month_='.$month_.'&ri='.$ri.'">'; 
				           
				           
				           echo getShortMonth(getMonth($s['date_pay'])).' '.getYear($s['date_pay']);
				           echo '</a></li>';
			         
			         
			          }
			          
			      }
         
     
		 }
	
    }	 
		 
?>
</ul>




<div class="grid-view">

<div  class="search-form">
<?php 



Yii::app()->clientScript->registerScript('searchByMonth('.$condition.','.$current_month.','.$acad_sess.')', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#billings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
	
	
       // echo 'oooook';
    $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
 

<?php 
        
            
function evenOdd($num)
{
($num % 2==0) ? $class = 'odd' : $class = 'even';
return $class;
}

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'billings-grid',
	'dataProvider'=>$model->searchByMonth($condition,$current_month, $acad_sess),
	'showTableOnEmpty'=>true,
	//'emptyText'=>Yii::t('app','No academic period found'),
			//'summaryText'=>Yii::t('app','View academic period from {start} to {end} (total of {count})'),
               'mergeColumns'=>array('date_pay','student0.fullName', 'fee_fname' ),//'student0.first_name', 'student0.last_name','fee_fname'),
    
        'rowCssClassExpression'=>'($data->balance>0)?"balance":evenOdd($row)',
	
	'columns'=>array(
		//'id',
		
	    array('name'=>'date_pay',
			//'header'=>Yii::t('app','Fee name'), 
			'value'=>'$data->DatePay'),
			
             
       array(
		    'name'=>'student0.fullName',
			'header'=>Yii::t('app','Student'),
                        //'type' => 'raw',
			'value'=>'$data->student0->fullName." (".$data->student0->id_number.")"',//'CHtml::link($data->student0->first_name,Yii::app()->createUrl("/billings/billings/view",array("id"=>$data->id)))',
                        'htmlOptions'=>array('width'=>'125px'),
                    ),
            	
   
             			//'student',
       		array('name'=>'fee_fname',
			'header'=>Yii::t('app','Fee name'), 
			'value'=>'$data->feePeriod->simpleFeeName'),
	
            array('header'=>Yii::t('app','Amount To Pay'),'value'=>'$data->amountToPay'),
            array('header'=>Yii::t('app', 'Amount Pay'),'value'=>'$data->amountPay'),
		
            array('header'=>Yii::t('app', 'Balance'),'value'=>'$data->balanceCurrency'),
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                         'buttons'=>array(
                         
                         'view'=>array(
				            'label'=>'<i class="fa fa-eye"></i>',
				            'imageUrl'=>false,
				            'url'=>'Yii::app()->createUrl("/billings/billings/view?id=$data->id&ri='.$this->recettesItems.'&part=rec&from=stud")',
				            'options'=>array( 'title'=>Yii::t('app','View') ),
				        ),
                         'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/billings/billings/update?id=$data->id&ri='.$this->recettesItems.'&part=rec&from=stud")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                            
                       'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('billings-grid',{ data:{pageSize: $(this).val() }})",
                             )),
		),
	 
	),
)); 

   
    // Export to CSV 
  $content=$model->searchByMonth($condition,$current_month, $acad_sess)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));

  

?>


</div>







