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
	'id'=>'scholarshipholder',
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

$message_validation = Yii::t('app','Percentage to pay can\'t be gerater than 100 !');
            
?>




<div class="grid-view">
    
    <div>
        <div>
          <?php  echo Yii::t('app','Choose student'); ?>
        </div>
        <div class="row-fluid">
            <div class="span3">
     <?php
     
          $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC','join'=>'inner join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1,2) AND rh.academic_year ='.$acad_sess));
        
       
            echo $form->dropDownList($model, 'student',
            CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
            array('prompt'=>Yii::t('app','-- Please select student --'),'name'=>'student','onchange'=>'submit()','options' => array($this->student_name=>array('selected'=>true)))
            );
     ?>
            </div>
            <div class="span3">
                
                <span class="checkbox_view">
                <?php 
               
		   if($this->is_full==1)
                       { echo $form->checkBox($model,'is_full',array('onchange'=> 'submit()','checked'=>'checked','name'=>'is_full','value'=>1));
				                             
                        }elseif($this->is_full==0)
                            echo $form->checkBox($model,'is_full',array('onchange'=> 'submit()','name'=>'is_full','value'=>null));
							               
                ?>
                </span>
                <?php echo Yii::t('app','Full scholarship'); ?>
            </div>
        </div>
    </div>
   
    
    <table class="items">
        <tr>
        <th><?php echo Yii::t('app','Is Internal'); ?></th>
        <th><?php echo Yii::t('app','Sponsor'); ?></th>
        <?php if($this->is_full == 0) { ?>
        <th><?php echo Yii::t('app','Fee'); ?></th>
        <?php } ?>
        <th><?php echo Yii::t('app','Percentage Pay'); ?></th>
        </tr>
        
        <?php 
        
        $this->feesLabel = Yii::app()->session['feesLabel_scholarship'];
        
        
        for($i=0; $i<$this->number_row; $i++){ ?>
        <tr class="<?php echo evenOdd($i); ?>">
            <td>
                <span class="checkbox_view">
                <?php 
               
		   if($this->internal[$i]==1)
                       { echo $form->checkBox($model,'is_internal',array('onchange'=> 'submit()','checked'=>'checked','name'=>'internal'.$i,'value'=>1));
				                             
                        }elseif($this->internal[$i]==0)
                            echo $form->checkBox($model,'is_internal',array('onchange'=> 'submit()','name'=>'internal'.$i,'value'=>null));
							               
                ?>
                </span>
            </td>
            <td>
                <?php
                     if($this->internal[$i]==0){ 
                        echo $form->dropDownList($model, 'partner',
                        CHtml::listData(Partners::model()->findAll(),'id','name'),
                        array( 'prompt'=>Yii::t('app','-- Please select --'),'name'=>'partner'.$i)
                        );
                      }
                   elseif($this->internal[$i]==1)
                     {   
                            echo $form->textField($model,'partner_name',array('size'=>60, 'disabled'=>'disabled','value'=>$this->school_name,'name'=>'partner_name'.$i));
                            }
                
                ?>
            </td>
            <?php if($this->is_full == 0) { ?>
            <td>
                <?php 
				         $level_ =0;
									
									 if($this->student_name!='')
									  {  $level = Levels::model()-> getLevel($this->student_name,$acad_sess); //$acad_sess,pou session
								          if($level!=NULL)
										   { $level=$level->getData();
									           foreach($level as $l)
   										       $level_ = $l->id;
										   }
									   }
						
					 $criteria = new CDbCriteria(array('alias'=>'fl','join'=>'inner join fees f on(f.fee=fl.id)','condition'=>'fl.fee_label NOT LIKE("Pending balance") AND f.level='.$level_,'order'=>'fl.id'));
		
		 
                        echo $form->dropDownList($model, 'fee',
                        loadFeeNameByLevelForScholarship($level_,$acad_sess),//CHtml::listData(FeesLabel::model()->findAll($criteria),'id','fee_label'),

                        array('prompt'=>Yii::t('app','-- Please select fee --'),'name'=>'fee'.$i)
                        );
								                        
                        
								
                        ?>
            </td>
            <?php  } ?>
            <td>
                 <?php 
                 if($this->is_full == 0) 
                   { 
                 		echo $form->textField($model,'percentage_pay',array('size'=>60,'placeholder'=>Yii::t('app','Percentage').'(%)','name'=>'percentage_pay'.$i,'id'=>'percentage_pay'.$i,'onchange'=>'validatePercent("percentage_pay'.$i.'","'.$message_validation.'")')); 
                 		
                    }
                 elseif($this->is_full == 1) 
                   { 
                 	      echo $form->textField($model,'percentage_pay',array('size'=>60,'placeholder'=>Yii::t('app','Percentage').'(%)','name'=>'percentage_pay'.$i,'id'=>'percentage_pay'.$i, 'readonly'=>'true')); 
                   
                    }
                 		
                 	?>
            </td>
           
            
        </tr>      
        <?php } ?>
        
        
    </table>

 <?php 
     
     if(!isAchiveMode($acad_sess))
        {     
        
   ?>
    
    <div class="col-submit">
        <input type="hidden" name="nombre_ligne" value="<?php echo $this->number_row; ?>"/>
        <button name="btnSave"  id="btnSave" class="btn btn-warning" type="submit"><?php echo Yii::t('app','Save');  ?></button>
        <button name="btnCancel" class="btn btn-secondary" type="submit"><?php echo Yii::t('app','Cancel ');  ?></button>
    </div>
  <?php
        }
      
      ?>       
   
   
</div>


<?php $this->endWidget(); ?>

<!--  Valider le pourcentage de la bourse d'etude -->

<script type="text/javascript">
    function validatePercent(elementId,message){
        var valeur = parseFloat(document.getElementById(elementId).value);
        if(valeur > 100){
            alert(message);
            document.getElementById("btnSave").disabled = "disabled";
        }else{
             document.getElementById("btnSave").disabled = "";
        }
    }

</script>
            