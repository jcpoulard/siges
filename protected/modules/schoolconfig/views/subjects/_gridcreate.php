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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fees-grid-add',
	'enableAjaxValidation'=>false,
));

$acad=Yii::app()->session['currentId_academic_year'];

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
    
    
   
    
    <table class="items">
        <tr>
        <th><?php echo Yii::t('app','Subject Name'); ?></th>
		 <th><?php echo Yii::t('app','Short Subject Name'); ?></th>
        <th><?php echo Yii::t('app','Is Subject Parent'); ?></th>
      
        <th><?php echo Yii::t('app','Parent Subjects'); ?></th>
       
        </tr>
        
        <?php for($i=0; $i<$number_line; $i++){ ?>
        <tr class="<?php echo evenOdd($i); ?>">
            <td>
                <input type="text"  size="60" name="subject_label<?php echo $i; ?>" placeholder="<?php echo Yii::t('app','Subject Name'); ?>" />
            </td>
			<td>
                <input type="text"  size="60" name="short_subject_label<?php echo $i; ?>" placeholder="<?php echo Yii::t('app','Short Subject Name'); ?>" />
            </td>
            <td>
                <div class="checkbox_view"><input  id="active" type="checkbox" name="is_subject_parent<?php echo $i ?>"/></div>
            </td>
            
            <td>
                <?php 
			
                        $criteria = new CDbCriteria(array('order'=>'subject_name','condition'=>'is_subject_parent=1'));

                        echo $form->dropDownList($model, 'subject_parent',
                        CHtml::listData(Subjects::model()->findAll($criteria),'id','subject_name'),
                        array('prompt'=>Yii::t('app','-- Please select subject --'),'name'=>'parent_subject'.$i)
                        );
                 ?>
            </td>
            
           
            
        </tr>      
        <?php } ?>
        
        
    </table>
    
    <div class="col-submit"> 
 <?php 
               if(!isAchiveMode($acad_sess))
                 {       
        ?>
              
        <button name="btnSave" class="btn btn-warning" type="submit"><?php echo Yii::t('app','Save');  ?></button>
    <?php
                 }
      
      ?>        
        <button name="btnCancel" class="btn btn-secondary" type="submit"><?php echo Yii::t('app','Cancel ');  ?></button>
    </div>
    
   
</div>


<?php $this->endWidget(); ?>
            