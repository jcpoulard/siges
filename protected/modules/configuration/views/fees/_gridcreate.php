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
?>

<?php 

	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 



$form=$this->beginWidget('CActiveForm', array(
	'id'=>'fees-grid-add',
	'enableAjaxValidation'=>false,
));


    function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }

if(infoGeneralConfig('nb_grid_line')!=null){
    $number_line = infoGeneralConfig('nb_grid_line');
}else{
    $number_line = 6; 
}            
            
?>




<div class="grid-view">
    
    <div>
        <label><?php echo Yii::t('app','Choose a level'); ?></label>
        <?php
            $criteria = new CDbCriteria(array('alias'=>'l', 'order'=>'l.level_name ASC','join'=>'inner join level_has_person lhp on(lhp.level = l.id)', 'condition'=>'lhp.academic_year ='.$acad_sess));
            echo $form->dropDownList($model, 'level',
            CHtml::listData(Levels::model()->findAll($criteria),'id','level_name'),
            array('prompt'=>Yii::t('app','-- Please select level --'),'name'=>'level','onchange'=>'submit()','options' => array($this->class_choose=>array('selected'=>true)))
            );
        ?>
        
    </div>
    <?php if($this->class_choose!=null) { ?>
    
    <table class="items">
        <tr>
        <th><?php echo Yii::t('app','Fee Name'); ?></th>
        <th><?php echo Yii::t('app','Amount'); ?></th>
      
        <th><?php echo Yii::t('app','Date Limit Payment'); ?></th>
        <th><?php echo Yii::t('app','Description'); ?></th>
        </tr>
        
        <?php for($i=0; $i<$number_line; $i++){ ?>
        <tr class="<?php echo evenOdd($i); ?>">
            <td>
                <?php 
                    $criteria = new CDbCriteria(array('condition'=>'fee_label NOT LIKE("Pending balance")', 'order'=>'fee_label'));
		
                    echo $form->dropDownList($model, 'fee',
                    CHtml::listData(FeesLabel::model()->findAll($criteria),'id','fee_label'),

                    array('prompt'=>Yii::t('app','-- Please select fee --'),'name'=>'fee'.$i)
                    );
								
		?>
            </td>
            <td>
                <?php echo $form->textField($model,'amount',array('size'=>60,'placeholder'=>Yii::t('app','Amount'),'name'=>'amount'.$i)); ?>
                <?php echo $form->error($model,'amount'); ?>
            </td>
            
            <td>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
                     array(
                         'model'=>'$model',
                         'name'=>'date_limit_payment'.$i,
                         'language'=>'fr',
                         //'value'=>$model->date_limit_payment,
                         'htmlOptions'=>array('size'=>30,'style'=>'width:100% !important','placeholder'=>Yii::t('app','Date Limit Payment')),
                                 'options'=>array(
                                 'showButtonPanel'=>true,
                                 'changeYear'=>true,                                      
                                 'changeYear'=>true,
                                 'dateFormat'=>'yy-mm-dd',   
                                             ),
                                     )
                             );
				             ?>
                               <?php echo $form->error($model,'date_limit_payment'); ?>
            </td>
            
            <td>
                <?php echo $form->textArea($model,'description',array('rows'=>2, 'cols'=>6,'placeholder'=>Yii::t('app',' Description'),'name'=>'description'.$i)); ?>
                <?php echo $form->error($model,'description'); ?>
            </td>
            
        </tr>      
        <?php } ?>
        
        
    </table>

<?php 
     
     if(!isAchiveMode($acad_sess))
        {     
        
   ?>
    
    <div class="col-submit"> 
        <button name="btnSave" class="btn btn-warning" type="submit"><?php echo Yii::t('app','Save');  ?></button>
        <button name="btnCancel" class="btn btn-secondary" type="submit"><?php echo Yii::t('app','Cancel ');  ?></button>
    </div>
  
<?php
        }
      
      ?>       
  
    
    <?php } ?> 
</div>


<?php $this->endWidget(); ?>
            