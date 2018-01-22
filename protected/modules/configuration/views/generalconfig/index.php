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
/* @var $this GeneralconfigController */
/* @var $model GeneralConfig */

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
$acad_sess=acad_sess();    
$acad=Yii::app()->session['currentId_academic_year']; 

$template ='';



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#general-config-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="dash">
   <div class="span3"><h2>
         <?php echo Yii::t('app','Manage General Config'); ?>
    
    </h2> </div>
    
     <div class="span3">
        
        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{update}';    
        ?>
     
    
        <div class="span4">
             
             
                  <?php

                 $images = '<i class="fa fa-camera" >&nbsp;'.Yii::t('app','Upload school logo').'</i>';
                           // build the link in Yii standard
               
              echo  CHtml::ajaxLink($images,array('uploadLogo'),array( 'success'=>'js:function(data){ $("#logoUploadDialog").dialog("open");
                                                                                   document.getElementById("logo_upload").innerHTML=data;
																							        }',),
																	array('style'=>'text-decoration:none;',)   );
               
                 ?>
        </div> 

         <div class="span4">
                  <?php

                 $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('generalconfig/update','all'=>1,'from'=>'edit')); 

               ?>
         </div> 
           
      <?php
                 }
      
      ?>       

           
           
               <div class="span4">
              <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/configuration/academicperiods/index')); 
                                ?>
           </div>
   </div>

</div>



<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>



	
<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->
<!--	<div class="span3"></div> -->

<div class="clear"></div>



<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('groupgridview.GroupGridView', array(
	'id'=>'general-config-grid',
	'dataProvider'=>$model->search(),
	'selectableRows' => 2,
	'showTableOnEmpty'=>'true',
	'mergeColumns'=>'category',
	'columns'=>array(
		
		
                array('name'=>'name', 'header'=>Yii::t('app','Name'),'htmlOptions'=>array('width'=>'200px'),),
		array('name'=>'item_value','htmlOptions'=>array('width'=>'200px')),
		'description',
                'english_comment',
         
         
         array(
			'class'=>'CButtonColumn',
			'template'=>$template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                           
                            ),
                       
		),   
            ),
            
)); 


$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'logoUploadDialog',
                'options'=>array(
                    'title'=>Yii::t('app','Upload Logo'),
                    'autoOpen'=>false,
					'modal'=>'true',
                    'width'=>'34%',
                                   ),
                ));
	
 
 
 echo "<div id='logo_upload'></div>";
 
  $this->endWidget('zii.widgets.jui.CJuiDialog');

?>

