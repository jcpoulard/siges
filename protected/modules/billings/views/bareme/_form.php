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



/* @var $this BaremeController */
/* @var $model Bareme */
/* @var $form CActiveForm */


$acad=Yii::app()->session['currentId_academic_year'];

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bareme-form',
	'enableAjaxValidation'=>false,
)); 


$acad=Yii::app()->session['currentId_academic_year'];

    function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }

//if(infoGeneralConfig('nb_grid_line')!=null){
//    $number_line = infoGeneralConfig('nb_grid_line');
//}else{
    $number_line = 7; 
//}            
            
?>




<div class="grid-view">
    
  
<div  id="resp_form_siges">

        <form  id="resp_form">


         
                
    <table class="items" style="align: center; width:100%; ">
        <tr>
        <th><?php echo ''; ?></th>
        <th><?php echo Yii::t('app','Minimum value'); ?></th>
        <th><?php echo Yii::t('app','Maximum value'); ?></th>
      
        <th><?php echo Yii::t('app','Percentage'); ?></th>
        
        </tr>
        
        <?php for($i=0; $i<$number_line; $i++){ ?>
        <tr class="<?php echo evenOdd($i); ?>">
        
            <td style="text-align: center;">
               <?php echo '<b> '.Yii::t('app','Range').' '.($i+1).' </b>'; ?>
            </td>
            
            <td style="text-align: center;">
               <input style="text-align: right;" size="20" type="text" name="min<?php echo $i ?>" placeholder="<?php echo Yii::t('app','Minimum value'); ?>"/>
            </td>
            
            <td style="text-align: center;">
                <input style="text-align: right;" size="20" type="text" name="max<?php echo $i ?>" placeholder="<?php echo Yii::t('app','Maximum value'); ?>"/>
            </td>
            
            <td style="text-align: center;">
                <input style="text-align: center;" size="20" type="text" name="percent<?php echo $i ?>" placeholder="<?php echo Yii::t('app','Percentage'); ?>"/>
            </td>
            
            
            
        </tr>      
        <?php } ?>
    </table>
    
    
  <?php 
     
     if(!isAchiveMode($acad))
        {    
        
   ?>
   
    
    <div class="col-submit"> 
         <?php
         echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'btnSave','class'=>'btn btn-warning'));
         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'btnCancel','class'=>'btn btn-secondary'));
         ?>
    </div>
    
  <?php
        }
      
      ?>       
   
                       
                     </form>
              </div>


   
</div>


<?php $this->endWidget(); ?>

</div><!-- form -->