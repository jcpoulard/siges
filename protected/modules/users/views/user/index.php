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



/* @var $this UserController */
/* @var $model User */


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
$acad_sess=acad_sess();    
$acad=Yii::app()->session['currentId_academic_year']; 

 $template='';
 
 if(!isAchiveMode($acad_sess))
     $template='{update}';

?>


<!-- Menu of CRUD  -->
<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','Manage Users'); ?>  </h2> </div>
    <div class="span3">
           
        <div class="span4">
                  <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('../site/index')); 
                     
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



<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="clear"></div>


<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="clear"></div>
<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	//'enableAjaxValidation'=>false,
));

?>
       <div class="checkbox_view span2" >
           <label>                     
                                
                                <div class="left" style="padding-left:40px; text-align:center;">  
	                            <?php 
	                              
                                     echo $form->labelEx($model,'sortOption' ); 
                                     
		                              if($this->sortOption==1)
				                          { echo $form->checkBox($model,'sortOption',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
				                           }
						                 else
							               echo $form->checkBox($model,'sortOption',array('onchange'=> 'submit()'));
							               
                                  
                               ?>

                                </div>
             </label>                          
       </div>
<?php
    if($this->sortOption==1)
      {
?>      	
                 <div class="span2" >
                              <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Person'));
                                        
                                        if(isset($this->person_)&&($this->person_!=''))
							       echo $form->dropDownList($model,'person_',$this->loadPersons(), array('onchange'=> 'submit()','options' => array($this->person_=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'person_',$this->loadPersons(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
                            
                   <div class="span2" >
                              <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Room'));
                                        
                                        if(isset($this->room)&&($this->room!=''))
							       echo $form->dropDownList($model,'room',$this->loadRoomByPerson($this->person_), array('onchange'=> 'submit()','options' => array($this->room=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'room',$this->loadRoomByPerson($this->person_), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
 
      	
<?php      	
      	}
?>
<br/>

<?php $this->endWidget(); ?>
                            

<?php


//error message

    		//error message 
        if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_default_user=true;
           
      	 
           
                				       
			if(($this->message_default_user))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-48px; ';//-20px; ';
				      echo '">';
				      	
				      	echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';			      
			      
				     	echo '<span style="color:red;" >'.Yii::t('app','- _developer_ - cannot be either updated nor deleted.').'</span>';
					     $this->message_default_user=false;
					     echo'</td>
						    </tr>
							</table>';
									
				           echo '</div>
				           <div style="clear:both;"></div>';
			           }
							     			     	
				       
?>
<?php  

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before

$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$dataProvider,
	
	'columns'=>array(
            
                array(
                    'name' => 'username',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->username,Yii::app()->createUrl("users/user/view",array("id"=>$data->id)))',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),
		
		
		
				array(
                    'name'=>'full_name',
                    'header'=>Yii::t('app','Full name'),
                    'value'=>'$data->full_name',
                    ),
                array(
                    'name'=>'person.fullName',
                    'header'=>Yii::t('app','Student name'),
                    'value'=>'$data->person->fullName',
                    ),
                   
                    array('name'=>'profil',
			'header'=>Yii::t('app','Profil User'),
			'value'=>'$data->profil0->profil_name'),
			
                   
                    array('name'=>'group_id',
			'header'=>Yii::t('app','Group user'),
			'value'=>'$data->group0->group_name'),
                  
		
		array(
			'class'=>'CButtonColumn',
			'template'=>$template,
			   'buttons'=>array (
        
         'update'=>array(
            'label'=>'<span class="fa fa-pencil-square-o"></span>',
            'imageUrl'=>false,
            'url'=>'Yii::app()->createUrl("users/user/update?id=$data->id")',
            'options'=>array( 'title'=>Yii::t('app','Update' )),
        ),
        
    ),    
    
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('user-grid',{ data:{pageSize: $(this).val() }})",
           
                   )),
		),
	),
)); 
  $this->renderExportGridButton($gridWidget, '<span class="fa fa-arrow-right">'.Yii::t('app',' CSV').'</span>',array('class'=>'btn-info btn'));
  
?>


