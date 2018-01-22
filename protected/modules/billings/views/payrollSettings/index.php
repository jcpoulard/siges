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


/* @var $this PayrollSettingsController */
/* @var $dataProvider CActiveDataProvider */

  $acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year']; 

$template = '';


Yii::app()->clientScript->registerScript('search_('.$acad.')', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#payroll-settings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Manage Payroll Settings'); ?>
              
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
                 echo CHtml::link($images,array('/billings/payrollSettings/create/part/pay/from/stud')); 
               ?>
   </div>

 <?php
        }
      
      ?>       
   
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/billings/index/part/pay/from/stud')); 
               ?>
  </div>  


  </div>

</div>


<div style="clear:both"></div>



<br/>


    <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>



<div class="b_m">


<div class="grid-view">




<div  class="search-form">
<?php 
      
    $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
 
      
<?php 

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'payroll-settings-grid',
	'dataProvider'=>$model->search_($acad),
	'showTableOnEmpty'=>true,
	'mergeColumns'=>array('person.fullName'),
	
	'columns'=>array(
		

array('name'=>'person.fullName',
			'header'=>Yii::t('app','Full name'),
                        'type' => 'raw',
			'value'=>'$data->person->fullName', 
                    ),
     
  		array('header' =>Yii::t('app','Amount'), 
					            'value'=>'$data->Amount',
					             ),
  		'AnHour',
  		
  		array('header' =>Yii::t('app','Number Of Hour'), 
					            'value'=>'$data->NumberHour',
					             ),
					             
					             
  		array('header' =>Yii::t('app','Gross salary'), 
					            'value'=>'$data->GrossSalaryInd',
					             ),
					             
        array('name'=>'as',
			
			'value'=>'$data->AsValue',
			  ),

		
		array('name' =>'date_created',
						       'header' =>Yii::t('app','Date Created'), 
					            'value'=>'$data->DateCreated', 
					             ),
		'created_by',
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
                             'onchange'=>"$.fn.yiiGridView.update('payroll-settings-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             
                             
		),
		
		
		
	),
)); 

   
    // Export to CSV 
  $content=$model->search_($acad)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));





?>



</div>