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
/* @var $this MenfpDecisionController */
/* @var $dataProvider CActiveDataProvider */

	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$template = '{view}';


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

?>

<div id="dash">
          
          <div class="span3"><h2>
              <?php   echo Yii::t('app','Manage MENFP grades');
                    
                  ?>
              
          </h2> </div>
     
		   <div class="span3">
             
<?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '';  
        
   ?>

     <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                  echo CHtml::link($images,array('/academic/menfpGrades/create/part/parlis/')); 
               ?>
   </div>
   
  <?php
        }
      
      ?>       

 
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 
                 echo CHtml::link($images,array('/academic/menfpDecision/index/part/parlis/from/'));
                   
               ?>
  </div>  


  </div>

</div>



<div style="clear:both"></div>
<br/>


    <?php
    echo $this->renderPartial('//layouts/navBaseExamMenfp',NULL,true);	
    ?>



<div class="b_m">


<div class="grid-view">



<div class="search-form" >
<?php
      $this->renderPartial('_search',array(
'model'=>$model,
)); ?>
</div>



<?php 
     $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
     
$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'menfp-decision-grid',
	//'mergeColumns'=>array('student0.fullName', 'academic_period','level'),
	'dataProvider'=>$model->search($acad_sess),
	
	'columns'=>array(
		
		 array('name'=>'student0.fullName',
			'header'=>Yii::t('app','Student'),
                        'type' => 'raw',
			//'value'=>'$data->student0->fullName', 
			'value'=>'CHtml::link($data->student0->fullName,Yii::app()->createUrl("/academic/menfpGrades/view",array("id"=>$data->student, "part"=>"parlis","from1"=>"parlis")))',           
                    ),
                    
            array('name'=>'level',
			'header'=>Yii::t('app','Level'), 
			'type' => 'raw',
                    'value'=>'$data->getLevelByStudID($data->student0->id,'.$acad_sess.')',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),	
                     
       
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                        //'buttons'=>array(),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                         'onchange'=>"$.fn.yiiGridView.update('menfp-decision-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             
		),
	),
)); 

    

 $content=$model->search($acad_sess)->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
         
?>
 

</div>
</div>
