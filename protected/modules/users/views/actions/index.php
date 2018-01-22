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



$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
$acad_sess=acad_sess();    
$acad=Yii::app()->session['currentId_academic_year']; 

 $template ='{view}';  


?>


<?php

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('actions-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<div id="dash">
		<div class="span3"><h2>
<?php echo Yii::t('app','Manage actions'); ?> 

		</h2> </div>


      <div class="span3">
       <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{view}{update}{delete}';    
        ?>
             
 <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('actions/create')); 
               ?>
   </div>


      <?php
                 }
      
      ?>       
   
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/users/user/index')); 
               ?>
  </div>  


</div>
</div>


<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseUser',NULL,true);	
    ?>
</div>

<div style="clear:both"></div>


<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before

   $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'actions-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		'action_id',
		'action_name',
		'controller',
                array('name'=>'module_id',
			'header'=>Yii::t('app','Module name'),
			'value'=>'$data->module->module_name'),
		
		array(
			'class'=>'CButtonColumn',
			'template'=>$template,
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("users/actions/view?id=$data->id")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
                 ),
        
           'update'=>array(
            'label'=>'<span class="fa fa-pencil-square-o"></span>',
            'imageUrl'=>false,
            'url'=>'Yii::app()->createUrl("users/actions/update?id=$data->id")',
            'options'=>array( 'title'=>Yii::t('app','Update' )),
		        ),
		        
		     'delete'=>array(
              'label'=>'<span class="fa fa-trash-o"></span>',
              'imageUrl'=>false,
              'options'=>array('title'=>Yii::t('app','Delete')),
                ),
             
		    ), 
		    
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('actions-grid',{ data:{pageSize: $(this).val() }})",
                    )),
			
		),
	),
)); ?>
