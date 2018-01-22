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



	<?php
	
	  echo $form->errorSummary($model);	     
?>
   
      
   <div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form">
                          
					<?php echo $form->labelEx($model,'level'); ?>
                         
                              <?php echo $form->dropDownList($model, 'level',
            CHtml::listData(Levels::model()->findAll(),'id','level_name'),
            array('prompt'=>Yii::t('app','-- Please select level --'),'name'=>'level','onchange'=>'submit()','options' => array($this->idLevel=>array('selected'=>true)))
            );
             ?>
                              <?php echo $form->error($model,'level'); ?>
            </label>
        </div>

  
<?php
       if(($this->idLevel!='')||($model->level!=''))
         {
 ?>
  
           
 <div class="col-3">
            <label id="resp_form">    
                   
                     <?php echo $form->labelEx($model,'subject'); ?>
                        
                              <?php 
                               
                              echo $form->dropDownList($model, 'subject',
                        CHtml::listData(Subjects::model()->findAll(),'id','subject_name'),
                        array( 'prompt'=>Yii::t('app','-- Please select --')) );

 ?>
                              <?php echo $form->error($model,'subject'); ?>
            </label>
        </div>
  
                            
        <div class="col-3">
            <label id="resp_form">    
                          
                     <?php echo $form->labelEx($model,'weight'); ?>    
                          
                              <?php echo $form->textField($model, 'weight',array('size'=>60,'placeholder'=>Yii::t('app','Weight'))); ?>
                              <?php echo $form->error($model,'weight'); ?>
            </label>
        </div>
                          
      

              
                <div class="col-submit">
                                
                                <?php 
                                           if(!isAchiveMode($acad_sess))
                                               echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                         
                                          
                                ?>
                                
                </div>
                
  <?php
  
         }
  ?>              
                
        </form>
   </div>
<!-- END OF TEST -->     
        




