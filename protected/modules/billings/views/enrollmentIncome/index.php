<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
/* @var $this EnrollmentIncomeController */
/* @var $model EnrollmentIncome */

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

$template = '';
$from='';
if(isset($_GET['from']))
    $from = $_GET['from'];
    
$part='bill';

if(isset($_GET['part']))
{
	$part=$_GET['part'];
	}


$currency_symbol = Yii::app()->session['currencySymbol'];
$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#enrollment-income-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<div id="dash">
   <div class="span3"><h2>
         <?php echo Yii::t('app','Manage Postulants'); ?>
         
   </h2> </div>
   
   
     <div class="span3">
   
<?php 
     $template='';
     if(!isAchiveMode($acad_sess))
        {    $template = '{update}{delete}';  
        
   ?>

   
         <div class="span4">
                  <?php

                $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('enrollmentIncome/create/part/bill/from/'.$from));
               ?>
        </div>
         
           
  <?php
        }
      
      ?>       
     
      
        <div class="span4">
              <?php

                  $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/academic/postulant/viewListAdmission/part/enrlis/from/'.$from)); 
                 
                  
               ?>
         </div>
   </div>

</div>

<div style="clear:both"></div>


<br/>


    <?php
    echo $this->renderPartial('//layouts/navBaseEnrollment',NULL,true);	
    ?>





<div class="grid-view">



<div class="search-form" >
<?php  	  
	  $this->renderPartial('_search',array(
'model'=>$model,
)); 


?>
</div>



<?php 
     $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
       $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'enrollment-income-grid',
	'dataProvider'=>$model->search($acad_sess),
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		
array('name'=>'postulant',
			'header'=>Yii::t('app','Postulant'), 
			'type' => 'raw',
                    'value'=>'CHtml::link($data->FullName,Yii::app()->createUrl("/academic/postulant/viewAdmissionDetail",array("id"=>$data->postulant,"part"=>"bill","pg"=>"")))',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),	
                     		
		array('name'=>'apply_level',
			'header'=>Yii::t('app','Apply for level'), 
			'type' => 'raw',
                    'value'=>'CHtml::link($data->applyLevel->level_name,Yii::app()->createUrl("/academic/postulant/viewAdmissionDetail",array("id"=>$data->postulant,"part"=>"bill","pg"=>"")))',
                    
                     ),
			
		array('name'=>'amount',
			'header'=>Yii::t('app','Amount Pay'), 
			'value'=>'$data->Amount'),
			
		array('name'=>'payment_date',
			'header'=>Yii::t('app','Payment date'), 
			'value'=>'$data->PaymentDate'),
			
		
		
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/billings/enrollmentIncome/update?id=$data->id&part=bill&from='.$from.'")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                         'onchange'=>"$.fn.yiiGridView.update('enrollment-income-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 


 $content=$model->search($acad_sess)->getData();
	        if((isset($content))&&($content!=null)) 
			   {  
			   	   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
			   	   
			   }
        
?>

</div>

