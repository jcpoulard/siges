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


/* @var $this LoanOfMoneyController */
/* @var $dataProvider CActiveDataProvider */

  
   
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 




?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Exemption list'); ?>
              
          </h2> </div>
     
		   <div class="span3">
       <?php
          $template = '';

           if(!isAchiveMode($acad_sess))
              {     $template = '{update}{delete}';
       ?>      
            <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                  echo CHtml::link($images,array('/billings/scholarshipholder/exempt')); 
               ?>
   </div>
   
   <?php
              }
   ?>

   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/billings/index/from/bil')); 
               ?>
  </div>  



  </div>

</div>



<div style="clear:both"></div>






<div class="b_m">

<div class="grid-view">

<?php


Yii::app()->clientScript->registerScript('search_exemption('.$acad_sess.')', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#exemption-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


?>


<div  class="search-form">
<?php 
      
    $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
 
      
<?php 

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'exemption-grid',
	'mergeColumns'=>array('student0.fullName', ),
	'dataProvider'=>$model->search_exemption($acad_sess),
	
	'columns'=>array(
		
		array('name'=>'student0.fullName',
			'header'=>Yii::t('app','Student'),
                        'type' => 'raw',
			'value'=>'CHtml::link($data->student0->fullName,Yii::app()->createUrl("/billings/billings/view",array("id"=>lastBillingTransactionID($data->student, '.$acad_sess.'),"ri"=>0,"part"=>"rec","stud"=>$data->student,"from1"=>"exem")))',           
                    ),

		array('name'=>'room_name',
			'header'=>Yii::t('app','Room Name'), 
			'value'=>'$data->student0->getRooms($data->student0->id,'.$acad_sess.')'
			),
			
		/* array('name'=>'sponsor',
			'type' => 'raw',
			'value'=>'$data->Partner',
                    ),
       */
       
       array('name'=>'fee',
			'type' => 'raw',
			'value'=>'Yii::t(\'app\',$data->Fee)',
                    ),
                                 
       
       array('name'=>Yii::t('app','Percentage exempted'),
			'type' => 'raw',
			'value'=>'$data->percentage_pay',
			
			'htmlOptions'=>array('style' => 'text-align: center;'),
			
                    ),
		
		 array('name'=>Yii::t('app','Exempted amount'),
			'type' => 'raw',
			'value'=>'numberAccountingFormat($data->getAmountForPercentage($data->percentage_pay,$data->fee,$data->student0->getLevelIdByStudentId($data->student0->id,'.$acad_sess.'),'.$acad_sess.') )',
			'htmlOptions'=>array('style' => 'text-align: right;'),
			
                    ),
		
			
		  
		
		array(
			'class'=>'CButtonColumn',
			    'template'=>'',
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
                             'onchange'=>"$.fn.yiiGridView.update('exemption-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             
		),
	),
)); 

   
    // Export to CSV 
  $content=$model->search_($acad_sess)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));





?>



</div>


