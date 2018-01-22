<?php
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cms-menu-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="dash">
   <div class="span3">
       <h2>
        <?php echo Yii::t('app','Manage menu');?>
        
    </h2> 
   </div>
    
</div>



<?php
    echo $this->renderPartial('//layouts/navBasePortal',NULL,true);	
    ?>


<?php 



$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'cms-menu-grid',
        'itemsCssClass' => 'table-bordered items',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		
            array(
                'class' => 'editable.EditableColumn',
                'name'=>'menu_label',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'editable' => array(    //editable section
                 'apply'      => '$data->is_home != 1',
                  'url'        => $this->createUrl('cmsMenu/updateMenu'),
                  'placement'  => 'right',
              )  
            ),
            
            array(
                'class' => 'editable.EditableColumn',
                'name'=>'is_publish',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'editable'=>array(
                  'type'     => 'select',
                  'apply'      => '$data->is_home != 1',
                  'url'      => $this->createUrl('cmsMenu/updateMenu'),
                  
                 'source'=>Editable::source(array(0 =>Yii::t('app','No'),  1=>Yii::t('app','Yes'))),
                  'options'  => array(    //custom display 
                     'display' => 'js: function(value, sourceData) {
                          var selected = $.grep(sourceData, function(o){ return value == o.value; }),
                              colors = {1: "green", 0: "red"};
                          $(this).text(selected[0].text).css("color", colors[value]);    
                      }'
                  ),
                 //onsave event handler 
                 'onSave' => 'js: function(e, params) {
                      console && console.log("saved value: "+params.newValue);
                 }',
                ),
            ),
            
            array(
                'class' => 'editable.EditableColumn',
                'name'=>'menu_position',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'editable'=>array(
                    'type'     => 'select',
                  'apply'      => '$data->is_home != 1',
                  'url'      => $this->createUrl('cmsMenu/updateMenu'),
                 
                 'source'=>Editable::source(array(0 =>Yii::t('app','1st'),  1=>Yii::t('app','2nd'),2=>Yii::t('app','3rd'),3=>Yii::t('app','4th'),4=>Yii::t('app','5th'),5=>Yii::t('app','6th'))),
               
                 //onsave event handler 
                 'onSave' => 'js: function(e, params) {
                      console && console.log("saved value: "+params.newValue);
                 }',
                ),
            ),
		
		'update_by',
		
		
	),
));



?>
