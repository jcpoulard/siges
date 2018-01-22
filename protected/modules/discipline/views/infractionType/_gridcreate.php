<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'infraction-type-grid-add',
	'enableAjaxValidation'=>false,
));

$acad_sess = acad_sess();
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
        <th><?php echo Yii::t('app','Infraction type'); ?></th>
        <th><?php echo Yii::t('app','Deductible Value'); ?></th>
      
        <th><?php echo Yii::t('app','Description'); ?></th>
        
        </tr>
        
        <?php for($i=0; $i<$number_line; $i++){ ?>
        <tr class="<?php echo evenOdd($i); ?>">
            <td>
                <input type="text" name="name<?php echo $i ?>" placeholder="<?php echo Yii::t('app','Infraction type'); ?>">
            </td>
            <td>
                <input type="text" name="deductible_value<?php echo $i ?>" placeholder="<?php echo Yii::t('app','Deductible Value'); ?>">
            </td>
            
            <td>
                <input type="textarea" name="description<?php echo $i ?>" placeholder="<?php echo Yii::t('app','Description'); ?>">
            </td>
            
        </tr>      
        <?php } ?>
    </table>
    

        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='';    
        ?>

    <div class="col-submit"> 
        <button name="btnSave" class="btn btn-warning" type="submit"><?php echo Yii::t('app','Save');  ?></button>
        <button name="btnCancel" class="btn btn-secondary" type="submit"><?php echo Yii::t('app','Cancel ');  ?></button>
    </div>
       <?php
                 }
      
      ?>       

   
    
</div>


<?php $this->endWidget(); ?>
            