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



    function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
            
?>




<div class="grid-view">

<div  id="resp_form_siges">

        <form  id="resp_form">

 
    
    <table class="items" style="width:100%; ">
        <tr>
        <th><?php echo ''; ?></th>
        <th><?php echo Yii::t('app','Minimum value'); ?></th>
        <th><?php echo Yii::t('app','Maximum value'); ?></th>
      
        <th><?php echo Yii::t('app','Percentage'); ?></th>
        
        </tr>
        
        <?php 
              //get the current bareme
              //return an array  
                $bareme = Bareme::model()->getBaremeInUse();
        
           if($bareme!=null)
             { $i =0;
                foreach($bareme as $bar_){ ?>
        <tr class="">
            
            <td style="text-align: center;">
               <?php echo '<b> '.Yii::t('app','Range').' '.($i+1).' </b>';
                      echo '<input name="range['.$bar_['id'].']" type="hidden" value="'.$bar_['id'].'" />';
                   ?>
            </td>
            
            <td style="text-align: center;">
               <input style="text-align: right;"  size="20" type="text" name="min<?php echo $bar_['id']; ?>" value="<?php echo $bar_['min_value']; ?>"/>
            </td>
            
            <td style="text-align: center;">
                <input style="text-align: right;"  size="20" type="text" name="max<?php echo $bar_['id']; ?>" value="<?php echo $bar_['max_value']; ?>"/>
            </td>
            
            <td style="text-align: center;">
                <input style="text-align: center;"  size="20" type="text" name="percent<?php echo $bar_['id']; ?>" value="<?php echo $bar_['percentage']; ?>"/>
            </td>
            
            
            
        </tr>      
        <?php  $i++; }  
                          } ?>
    </table>
    
 <?php 
     
     if(!isAchiveMode($acad))
        {    
        
   ?>
      <div class="col-submit"> 
         <?php
          echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
         
         ?>
    </div>

  <?php
        }
      
      ?>       
   
    
                       
                     </form>
              </div>
 
</div>

</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

