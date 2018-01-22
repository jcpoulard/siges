<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];
 $template =''; 
?>
    
<div id="dash">
          
          <div class="span3"><h2> <?php echo Yii::t('app','Manage announcements'); ?> </h2> </div>
     
		   <div class="span3">
             
        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{update}{delete}';    
        ?>
          		
            <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/schoolconfig/announcements/create')); 

                   ?>

              </div>    
  


      <?php
                 }
      
      ?>       

     <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/academic/persons/viewListAdmission/isstud/1/pg/lr/mn/std'));
                     $this->back_url='/academic/persons/viewListAdmission/isstud/1/pg/lr/mn/std';



                   ?>

            </div> 



       </div>
 </div>



<div style="clear:both"></div>



<?php


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('announcements-grid', {
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
</div>




<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'announcements-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		
		
		array(
                    'name' => 'title',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->title,Yii::app()->createUrl("/schoolconfig/announcements/view",array("id"=>$data->id)))',
                   
                     ),
		
		'create_by',
		
		array(
			'class'=>'CButtonColumn',
                        'template'=> $template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),

							'view'=>array('label'=>'<span class="fa fa-eye"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','View')),
                                
                            ),
                            ),

                    'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                        'onchange'=>"$.fn.yiiGridView.update('announcements-grid',{ data:{pageSize: $(this).val() }})",
                        )),
		),
	),
)); ?>
