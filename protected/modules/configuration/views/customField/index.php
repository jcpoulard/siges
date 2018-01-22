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
 *//* @var $this CustomFieldController */
/* @var $model CustomField */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

$template ='';


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#custom-field-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="dash">
    <div class="span3">
        <h2>
            <?php echo Yii::t('app','Custom field for students').' / '.Yii::t('app','postulant'); ?>
		    
        </h2> 
    </div>
    
    <div class="span3">
     
         <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{update}{delete}';    
        ?>
    
        <div class="span4">
            <?php 
             $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
             echo CHtml::link($images,array('customField/create'));
            ?>
        </div>

                  
      <?php
                 }
      
      ?>       
     
        <div class="span4">
            <?php
                $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                echo CHtml::link($images,array('../..'));
            ?>
        </div>
        
    </div>
    
    
</div>


<div style="clear:both"></div>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
 $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'custom-field-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		
                //'field_label',
            array(
                    'name' => 'field_name',
                     'value'=>'$data->field_name',
                      'htmlOptions'=>array('width'=>'100px'),
                    ),
		//'field_name',
		array(
                    'name' => 'field_label',
                     'value'=>'$data->field_label',
                      'htmlOptions'=>array('width'=>'150px'),
                    ),
          
       array(
                    'name' => 'field_related_to',
                     'value'=>'$data->PersonTypeVal',
                      'htmlOptions'=>array('width'=>'250px'),
                    ),
                       
            array(
                    'name' => 'field_option',
                     'value'=>'$data->field_option',
                      'htmlOptions'=>array('width'=>'250px'),
                    ),
              
				array(
			'class'=>'CButtonColumn',
			
			'template'=>$template,
	'buttons'=>array (
        
         
        'update'=>array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            'imageUrl'=>false,
            
            'options'=>array( 'title'=>Yii::t('app','Update') ),
              ),
                               
        'delete'=> array(
            'label'=>'<i class="fa fa-trash-o"></i>',
             'imageUrl'=>false,
           
            'options'=>array('title'=>Yii::t('app','Delete' )),
        ),                       

              ),
            /*
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('contact-info-grid',{ data:{pageSize: $(this).val() }})",
            )),
            */
		),
	),
)); ?>
