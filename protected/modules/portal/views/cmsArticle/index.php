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
 *//* @var $this CmsArticleController */
/* @var $model CmsArticle */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cms-article-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage school web site');
?>

<div id="dash">
   <div class="span3"><h2>
        <?php echo Yii::t('app','Manage school web site');?>
        
   </h2> </div>
    
    <div class="span3">
        <div class="span4">
            <?php
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('cmsArticle/create')); 
            ?>
        </div>
        
        <div class="span4">
             
             
                  <?php

                 $images = '<i class="fa fa-camera" >&nbsp;'.Yii::t('app','Manage carrousel').'</i>';
                           // build the link in Yii standard
               
              echo  CHtml::ajaxLink($images,array('uploadLogo'),array( 'success'=>'js:function(data){ $("#logoUploadDialog").dialog("open");
                                                                                   document.getElementById("logo_upload").innerHTML=data;
																							        }',),
																	array('style'=>'text-decoration:none;',)   );
               
                 ?>
        </div> 
        
        <div class="span4">
            <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                     echo CHtml::link($images,array('/portal/cmsArticle/index')); 

                    ?>
        </div>
    </div>
</div>

<div class="clear"></div>

<?php
    echo $this->renderPartial('//layouts/navBasePortal',NULL,true);	
?>




<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 

if(infoGeneralConfig('number_article_per_page')!=null){
        $messagesParPage = infoGeneralConfig('number_article_per_page');
        $order = array();
        for($i=0; $i < $messagesParPage; $i++){
            $j = $i+1;
            $order[$i] = Yii::t('app','Rank {name}',array('{name}'=>$j));
       
        }
}
 
 
    
   // print_r($order);

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'cms-article-grid',
	'dataProvider'=>$model->search(),
	'itemsCssClass' => 'table-bordered items',
	'columns'=>array(
		
		
            array(
                    'name' => 'article_title',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->article_title,Yii::app()->createUrl("portal/cmsArticle/update",array("id"=>$data->id)))',
                   
                     ),
            'articleMenu.menu_label',
		
		'create_by',
            array(
                'class' => 'editable.EditableColumn',
                'header'=>Yii::t('app','Article rank'),
                'name'=>'rank_article',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'editable'=>array(
                  'type'     => 'select',
                 // 'apply'      => '$data->is_rand != null',
                  'url'      => $this->createUrl('cmsArticle/updateArticle'),
                  
                 'source'=>Editable::source($order),
                  'options'  => array(    //custom display 
                     
                  ),
                 //onsave event handler 
                 'onSave' => 'js: function(e, params) {
                      console && console.log("saved value: "+params.newValue);
                 }',
                ),
            ),
            
             array(
                'class' => 'editable.EditableColumn',
                'name'=>'is_publish',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'editable'=>array(
                  'type'     => 'select',
                 // 'apply'      => '$data->is_rand != null',
                  'url'      => $this->createUrl('cmsArticle/updateArticle'),
                  
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
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
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
                        'onchange'=>"$.fn.yiiGridView.update('cms-article-grid',{ data:{pageSize: $(this).val() }})",
                    )),
                        
		),
	),
)); 

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'logoUploadDialog',
                'options'=>array(
                    'title'=>Yii::t('app','Upload image for carrousel'),
                    'autoOpen'=>false,
					'modal'=>'true',
                    'width'=>'34%',
                                   ),
                ));
	
 
 
 echo "<div id='logo_upload'></div>";
 
  $this->endWidget('zii.widgets.jui.CJuiDialog');



?>
