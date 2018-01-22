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
/* @var $this ExamenMenfpController */
/* @var $model ExamenMenfp */
/* @var $form CActiveForm */
?>




<?php 
   
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 





    function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }



            
?>



  

<div class="grid-view">
     <div  id="resp_form_siges"  style=" margin-top:-20px;" >

        <form  id="resp_form">
     
            <div class="col-3">
                <label id="resp_form">
     <?php
          //echo Yii::t('app','Choose level'); 
         
        
       
            echo $form->dropDownList($model, 'level',
            CHtml::listData(Levels::model()->findAll(),'id','level_name'),
            array('prompt'=>Yii::t('app','-- Please select level --'),'name'=>'level','onchange'=>'submit()','options' => array($this->idLevel=>array('selected'=>true)))
            );
     ?>
             </label>
          </div>
          
    
 <div style="width:100%; margin-top:-20px;" >     
    <table class="items">
        <tr>
	        <th><?php echo Yii::t('app','Subject'); ?></th>
	        <th><?php echo Yii::t('app','Weight'); ?></th>
        
        </tr>
        
        <?php 
        
               
        for($i=0; $i<$this->number_row; $i++){ ?>
        <tr class="<?php echo evenOdd($i); ?>">
           
            <td>
                <?php
                    
                        echo $form->dropDownList($model, 'subject',
                        CHtml::listData(Subjects::model()->findAll(),'id','subject_name'),
                        array( 'prompt'=>Yii::t('app','-- Please select --'),'name'=>'subject'.$i) );
                      
                
                ?>
            </td>
            
            <td>
            <?php
                 echo $form->textField($model,'weight',array('size'=>60, 'name'=>'weight'.$i));
                 ?>          
            </td>
                       
            
        </tr>      
               
        <?php 
        
              }
        ?>
    </table>
 </div>

 
  <?php 
     
     if(!isAchiveMode($acad_sess))
        {     
          if($this->number_row!=0)
            {
   ?>
    
    <div class="col-submit">
        <input type="hidden" name="nombre_ligne" value="<?php echo $this->number_row; ?>"/>
       <?php 
          echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'btnSave', 'id'=>'btnSave', 'class'=>'btn btn-warning'));
                                            
           echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'btnCancel','class'=>'btn btn-secondary'));
                                              
        ?> 
    </div>
  <?php
              }
        }
      
      ?>       
   
   </form>
  </div>
</div>
    
  

