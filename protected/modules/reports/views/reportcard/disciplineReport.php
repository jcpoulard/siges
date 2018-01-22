<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>

<div id="dash">
    <div class="span3">
        <h2>
        <?php echo Yii::t('app','Discipline report'); ?>
        </h2>
    </div>
    
    <div class="span3">
         
           
               <div class="span4">
              <?php

                  $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/reports/reportcard/generalreport?from1=rpt')); 
                 ?>
          </div>
   </div>
</div>

<?php

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'report-discipline-form',
	'enableAjaxValidation'=>true,
));

?>

<div style="clear:both"></div>

<div class="b_m">
    
    <div class="row"> 
     
      <div class="span12" > 
         
                                
            <?php echo $form->errorSummary($model); ?>
              
              <div class="row-fluid span12">
                  <div class="span6">
                    <?php 
                        $criteria_ = new CDbCriteria;
                        $criteria_->condition='is_year=0 AND year=:year ';
                        $criteria_->params=array(':year'=>$acad_sess,);
		
                        echo $form->labelEx($model2,Yii::t('app','Name Period'));
                        echo $form->dropDownList($model2, 'name_period',CHtml::listData(AcademicPeriods::model()->findAll($criteria_),'id','name_period'),array('prompt'=>Yii::t('app','-- Please select --'),'disabled'=>false,'options' => array($this->period_dis=>array('selected'=>true))));
                    ?>
                  </div>
                  <div class="span6">
                    <?php 

                        echo $form->labelEx($model,Yii::t('app','Room'));
                        echo $form->dropDownList($model, 'room_attendance',CHtml::listData(Rooms::model()->findAll(),'id','room_name'),array('onchange'=> 'submit()','prompt'=>Yii::t('app','-- Please select room --'),'disabled'=>false,'options' => array($this->room_dis=>array('selected'=>true))));
                    ?>
                  </div>
            </div>
                                
         
                     
        </div>
    </div>
    
    <?php 
    function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
            $line_number=1;
    $studentModel = new Persons;
    if(isset($_POST['RecordPresence']['room_attendance']) && isset($_POST['AcademicPeriods']['name_period'])){
        $dataStudent = $studentModel->searchStudentsByRoomForGrades($this->room_dis,$acad_sess)->getData(); 
    
    ?>
    <div>
        
        <div class="grid-view">
            <table class="items">
                <thead>
                    <tr>
                        <th>
                            <?php echo Yii::t('app','Student name'); ?>
                        </th>
                        
                        <th>
                            <?php echo Yii::t('app','Grade'); ?>
                        </th>
                        
                        <th>
                            <?php echo Yii::t('app','Total absence'); ?>
                        </th>
                        
                        <th>
                            <?php echo Yii::t('app','Total tardy'); ?>
                        </th>
                        
                        <th>
                            <?php echo Yii::t('app','Total infraction'); ?>
                        </th>
                    </tr>
                </thead> 
              
                
                
                <div class="span2 photo_view">
    


    
</div>
              
                
                <?php foreach($dataStudent as $ds){
                    echo '<tr class="'.evenOdd($line_number).'">';
                    
                    echo '<td>';
                   
                    echo '<span rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-html="true" data-title="">'.$ds->fullName.'</span>';
                
                    echo '</td>';
                   
                    echo '<td>';
                    echo $infraction->getDisciplineGradeByExamPeriod($ds->id, $this->period_dis);
                    echo '</td>';
                    
                    echo '<td>';
                    echo $model->getTotalPresenceByExam($this->period_dis, $ds->id, $acad_sess);              
                    echo '</td>';
                    
                    echo '<td>';
                    echo $model->getTotalRetardByExam($this->period_dis, $ds->id, $acad_sess);
                    echo '</td>';
                    
                    echo '<td>';
                    echo $infraction->numberOfInfraction($ds->id, $this->period_dis);
                    echo '</td>';
                   
                    echo '</tr>';
                    $line_number++; 
                }?>
               
            </table>
            
            <script>
                $('[rel="tooltip"]').tooltip();
            </script>
        </div>
        
    </div>
    <?php }?>
    
</div>

<?php $this->endWidget(); ?>