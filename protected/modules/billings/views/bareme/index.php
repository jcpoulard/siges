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
/* @var $dataProvider CActiveDataProvider */

$acad=Yii::app()->session['currentId_academic_year']; 




$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

?>


<!-- Menu of CRUD  -->
<div id="dash">
          
          <div class="span3"><h2>
<?php echo Yii::t('app', 'Manage bareme');?> 
</h2> </div> 
     
		   <div class="span3">
 
  <?php
    if(!isAchiveMode($acad))
       {
 ?>            	      
	      <div class="span4">				
                  <?php   $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('/billings/bareme/create')); 
                   ?>
                  </div>
               
          <?php  if(!$this->noCurrentBarem){  ?>        
                   <div class="span4">				
                  <?php   $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('/billings/bareme/update')); 
                   ?>
                  </div>

           <?php }  ?>        
                
  <?php
        }
      
      ?>       
               
                <div class="span4">
                      <?php
				
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                     echo CHtml::link($images,array('/billings/taxes/index?part=payset')); 
                   ?>
                  </div>   


        </div>          
                           
</div>



<div style="clear:both"></div>




<br/>


    <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>


<div class="b_m">

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
               <input style="text-align: right;" disabled="disabled" size="20" type="text" name="min<?php echo $bar_['id']; ?>" value="<?php echo numberAccountingFormat($bar_['min_value']); ?>"/>
            </td>
            
            <td style="text-align: center;">
                <input style="text-align: right;" disabled="disabled" size="20" type="text" name="max<?php echo $bar_['id']; ?>" value="<?php echo numberAccountingFormat($bar_['max_value']); ?>"/>
            </td>
            
            <td style="text-align: center;">
                <input style="text-align: center;" disabled="disabled" size="20" type="text" name="percent<?php echo $bar_['id']; ?>" value="<?php echo $bar_['percentage'].'%'; ?>"/>
            </td>
            
            
            
        </tr>      
        <?php  $i++; }   } ?>
    </table>
 
 <?php
    if(!isAchiveMode($acad))
       {
 ?>   
     <div class="col-submit"> 
         <?php
        
         if(!$this->noCurrentBarem)
         	echo CHtml::submitButton(Yii::t('app', 'Delete'),array('name'=>'delete','class'=>'btn btn-warning'));
         
         ?>
    </div>
    
 <?php
        }
      
      ?>       
    
                       
                     </form>
              </div>
 
</div>

</div></div>

<?php $this->endWidget(); ?>

</div><!-- form -->

