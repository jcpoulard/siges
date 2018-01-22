<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-grid-add',
	'enableAjaxValidation'=>false,
));

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');




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
        <label><?php echo Yii::t('app','Choose a room'); ?></label>
        <?php
                      if($siges_structure==0)
			                $criteria = new CDbCriteria(array('order'=>'room_name',));
			            elseif($siges_structure==1)
			                $criteria = new CDbCriteria(array('alias'=>'r','join'=>'inner join room_has_person rhp on(rhp.room=r.id) ','condition'=>'rhp.academic_year='.$acad_sess, 'order'=>'room_name',));


            echo $form->dropDownList($model, 'room',
            CHtml::listData(Rooms::model()->findAll($criteria),'id','room_name'),
            array('prompt'=>Yii::t('app','-- Please select a room --'),'name'=>'room','onchange'=>'submit()','options' => array($this->room_choose=>array('selected'=>true)))
            );
        ?>
        
    </div>
    <?php if($this->room_choose!=null) { ?>
    
    <table class="items">
        <tr>
        <th><?php echo Yii::t('app','Subject'); ?></th>
        <th><?php echo Yii::t('app','Teacher'); ?></th>
      
        <th><?php echo Yii::t('app','Academic period'); ?></th>
        <th><?php echo Yii::t('app','Weight'); ?></th>
        <th><?php echo Yii::t('app','Base course'); ?></th>
        <th><?php echo Yii::t('app','Optional'); ?></th>
        </tr>
        
        <?php for($i=0; $i<$number_line; $i++){ ?>
        <tr class="<?php echo evenOdd($i); ?>">
            <td>
                <?php 
                   $criteria = new CDbCriteria(array('order'=>'subject_name',));
                    echo $form->dropDownList($model, 'subject',
                    CHtml::listData(Subjects::model()->findAll($criteria),'id','subjectName'),
                    array('prompt'=>Yii::t('app','-- Please select a subject --'),'name'=>'subject'.$i)
                    );
                 ?>   
            </td>
            <td>
                <?php 
                    $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=0 AND active IN(1, 2)'));
                    echo $form->dropDownList($model, 'teacher',
                    CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
                    array('prompt'=>Yii::t('app','-- Please select a teacher --'),'name'=>'teacher'.$i)
                    );
                ?>
            </td>
            
            <td>
                <?php
                    $criteria = new CDbCriteria(array('condition'=>'year=:acad2 OR id =:acad2','params'=>array(':acad2'=>$acad_sess),'order'=>'date_end DESC',));
                    echo $form->dropDownList($model, 'academic_period',
                      CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
                      array('prompt'=>Yii::t('app','-- Please select academic period --'),'name'=>'academic_year'.$i, 'options' => array($acad_sess=>array('selected'=>true)) )
                       );
                ?>
            </td>
            
            <td>
                <input size="20" type="text" name="weight<?php echo $i ?>" placeholder="<?php echo Yii::t('app','Weight'); ?>"/>
            </td>
            <td>
                <div class="checkbox_view"><input  id="active" type="checkbox" name="debase<?php echo $i ?>"/></div>
            </td>
            
             <td>
                <div class="checkbox_view"><input  id="active" type="checkbox" name="optional<?php echo $i ?>"/></div>
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
    
    <?php }else {
        echo Yii::t('app','Please choose a room to begin !');;
    } ?>
</div>


<?php $this->endWidget(); ?>
            