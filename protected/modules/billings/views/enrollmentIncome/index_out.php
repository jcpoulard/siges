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
/* @var $this BillingsController */
/* @var $model Billings */

   
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$template = '{view}';


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

	
?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php   echo Yii::t('app','Manage enrollment fee');
                    
                  ?>
              
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
                  echo CHtml::link($images,array('/billings/enrollmentIncome/create/part/rec/')); 
               ?>
   </div>
   
  <?php
        }
      
      ?>       

 
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 
                 echo CHtml::link($images,array('/billings/billings/index/part/rec/from/stud'));
                   
               ?>
  </div>  


  </div>

</div>



<div style="clear:both"></div>






<div class="b_m">


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        

<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'billings-form',
	'enableAjaxValidation'=>false,
));

?>
                           
     
      						<div class="span2" >
                                
                                <?php echo $form->errorSummary($model); ?>
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Recettes Items'));
                                        
                                        if(isset($this->recettesItems)&&($this->recettesItems!=''))
							       echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
  
<?php $this->endWidget(); ?>
                   
        </div>
    </div>


<div style="clear:both"></div>


<br/>



<ul class="nav nav-tabs nav-justified">  </ul>





<div class="grid-view">



<div class="search-form" >
<?php
      $this->renderPartial('_search',array(
'model'=>$model,
)); ?>
</div>



<?php 
     $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'enrollment-income-grid',
	'dataProvider'=>$model->search($acad_sess),
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		array('name'=>'postulant',
			'header'=>Yii::t('app','Postulant'), 
			'type' => 'raw',
                    'value'=>'CHtml::link($data->FullName,Yii::app()->createUrl("/academic/postulant/viewAdmissionDetail",array("id"=>$data->postulant,"part"=>"rec","pg"=>"")))',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),	
                     		
		array('name'=>'apply_level',
			'header'=>Yii::t('app','Apply for level'), 
			'type' => 'raw',
                    'value'=>'CHtml::link($data->applyLevel->level_name,Yii::app()->createUrl("/academic/postulant/viewAdmissionDetail",array("id"=>$data->postulant,"part"=>"rec","pg"=>"")))',
                    
                     ),

			
		array('name'=>'amount',
			'header'=>Yii::t('app','Amount Pay'), 
			'value'=>'$data->Amount'),
			
		array('name'=>'payment_date',
			'header'=>Yii::t('app','Payment date'), 
			'value'=>'$data->PaymentDate'),
			
		
		
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/billings/enrollmentIncome/update?id=$data->id&part=rec")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                         'onchange'=>"$.fn.yiiGridView.update('enrollment-income-grid',{ data:{pageSize: $(this).val() }})",
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






