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


$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));

?>
<?php 

function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }

    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'record-presence-form',
	'enableAjaxValidation'=>true,
)); 
 ?>

	
 
<div class="box box-info">
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <tbody>
                    <tr>
                        <td colspan="3">
                            <div style="padding:0px;">
                                <?php echo $form->errorSummary($model); ?>
                                <div class="left" style="margin-left:10px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Room'));
                                        echo $form->dropDownList($model, 'room_attendance',CHtml::listData(Rooms::model()->findAll(),'id','room_name'),array('prompt'=>Yii::t('app','-- Please select room --'),'onchange'=> 'submit()','disabled'=>false,'options' => array($this->room_atten=>array('selected'=>true))));
                                    ?>
                                </div>
                                <div class="left" style="margin-left:10px;">
                                    <?php
                                      echo $form->labelEx($model,Yii::t('app','Date to reccord attendance'));
                                       if($this->date_atten!=null)
               $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
                                                     'model'=>'$model',
                                                     'name'=>'RecordPresence[date_record]',
                                                     'language' => 'fr',  
                                                     'value'=>$this->date_atten, //$model->date_record,
                                                     'options'=>array('onSelect'=>'submit()'),
                                                     'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
                                                                         'yearRange'=>'2012:2100',    
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
                                                                        'dateFormat'=>'yy-mm-dd',
                                                                             
									 ),
								 )
							 ); 
           else
               $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
                                                     'model'=>'$model',
                                                     'name'=>'RecordPresence[date_record]',
                                                     'language' => 'fr',  
                                                     'value'=>date('Y-m-d'),//$model->date_record,
                                                     'options'=>array('onSelect'=>'submit()'),
                                                     'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
                                                                         'yearRange'=>'2012:2100',    
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
                                                                        'dateFormat'=>'yy-mm-dd',
                                                                         
									 ),
								 )
							 );
               
                                    ?>
                                </div>
                                <div class="left" style="margin-left:10px;">
                                     <?php 
                                     if($this->room_atten != null){
                                     echo $form->labelEx($model,Yii::t('app','&nbsp;'));
                                          if(!isAchiveMode($acad_sess))
                                              echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'create','class'=>'btn btn-warning'));
                                     }
                                     ?>
   
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>   
 
<div class="grid-view">
    
<table class="items">
   
    <?php
    
        if($this->room_atten!=null){
            $sql_room_st = "SELECT p.id, p.last_name, p.first_name, p.active, p.is_student, r.students, r.room, r.academic_year  FROM persons p inner join room_has_person r on (r.students = p.id) where r.room =".$this->room_atten." AND r.academic_year = ".$acad_sess."  ORDER BY p.last_name ASC";
            $stud_ = Persons::model()->findAllBySql($sql_room_st);
    ?>
    <thead>
    <tr>
        <th><?php  echo Yii::t('app','#'); ?></th>
        <th><?php  echo Yii::t('app','Last name'); ?></th>
        <th><?php  echo Yii::t('app','First name'); ?></th>
        <th><?php  echo Yii::t('app','Presence type'); ?></th> 
        <th><?php echo Yii::t('app','Comments');  ?></th>
        
    </tr>    
    </thead>
    <tbody>
        <?php 
        $line_number = 1;
        foreach($stud_ as $s){ 
            
            ?>
    <tr class="<?php echo evenOdd($line_number); ?>">
        <td><?php echo $line_number; ?></td>
        <td><?php echo $s->last_name; ?></td>
        <td><?php echo $s->first_name; ?></td>
        <td>
        <?php
       echo $form->dropDownList($model, "presence_type[$s->id]",$model->getPresenceStatus());
        ?>
        </td>
        <td><?php echo $form->textArea($model,"comments[$s->id]",array('rows'=>1, 'cols'=>8)); ?></td>
        
    </tr>  
            
        <?php 
            $line_number++; }
        ?>
    
        <?php }?>
    </tbody>
</table>

</div>
<?php $this->endWidget(); ?>
