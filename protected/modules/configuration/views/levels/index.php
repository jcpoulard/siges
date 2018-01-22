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
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage levels');

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$template ='';  

?>
<div id="dash">
   <div class="span3"><h2>
        <?php echo Yii::t('app','Manage levels');?>
        
   </h2> </div>
    
    <div class="span3">
     
        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{update}{delete}';    
        ?>
             
        <div class="span4">
            <?php
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('levels/create')); 
            ?>
        </div>
    
      <?php
                 }
      
      ?>       
    
        <div class="span4">
            <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                     echo CHtml::link($images,array('/configuration/academicperiods/index')); 

                    ?>
        </div>
    </div>
</div>
		
<!-- Menu of CRUD  -->


<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>



<?php

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('levels-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>
		


	
<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->
<!--	<div class="span3"></div> -->

<div class="clear"></div>


<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$gridWidget =  $this->widget('groupgridview.GroupGridView', array(
	'id'=>'levels-grid',
	'dataProvider'=>$model->search(),
        'showTableOnEmpty'=>true,
        'emptyText'=>Yii::t('app','No level found'),
        'summaryText'=>Yii::t('app','View level from {start} to {end} (total of {count})'),
        'blankDisplay'=>Yii::t('app','NO PREVIOUS LEVEL'),
        'nullDisplay'=>Yii::t('app','NO PREVIOUS LEVEL'),
        'mergeColumns' =>array('section','cycle'),
	
	'columns'=>array(
		
		
                array(
                    'name' => 'level_name',
                    
                    'value'=>'$data->level_name',
                   
                     ),
		
                array(
                    'name' => 'short_level_name',
                    
                    'value'=>'$data->short_level_name',
                    
                     ),
		
		'previousLevel.level_name',
		
		
		 array(
                    'name' => 'cycle',
                    'type' => 'raw',
                    'value'=>'$data->cycleDescription',
                    
                     ),
		
        
		 array(
                    'name' => 'section',
                    'type' => 'raw',
                    'value'=>'$data->section0->section_name',
                    
                     ),
		
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
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('levels-grid',{ data:{pageSize: $(this).val() }})",
                    )),
                        
		),
	),
)); 


 // Export to CSV 
  $content=$model->search()->getData();
 if((isset($content))&&($content!=null)) 
$this->renderExportGridButton($gridWidget, '<span class="fa fa-arrow-right">'.Yii::t('app',' CSV').'</span>',array('class'=>'btn-info btn'));
?>


