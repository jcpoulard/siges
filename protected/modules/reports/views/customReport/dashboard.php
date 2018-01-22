<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>


<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'custom-report-stud',
        'enableAjaxValidation'=>true,
        )); 
?>


<div class="row-fluid">
    <div class="span12 well">
        <div class="row-fluid">
                          <div class="span3">
                    <label>
                      <!--  <strong><?php echo Yii::t('app','Shift'); ?></strong> -->
                           
                        
                        <?php
                         $this->shift_id = Yii::app()->session['shift_dash'];
						 
                        $criteria = new CDbCriteria(array('order'=>'shift_name'));
                       
                        echo CHtml::dropDownList('shift_id',$selected_value="$this->shift_id", CHtml::listData(Shifts::model()->findAll($criteria),'id','shift_name'),
                            array(
                            'prompt'=>Yii::t('app','-- Please select shift --'),    
                            'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>CController::createUrl('customReport/loadRoomByShift'), //url to call.
                            
                            'update'=>'#room_name', //selector to update
                            
                            ))); 
                        ?>
                    </label>
                </div>
                <div class="span3">
                  <label>
                    <!--  <strong> <?php echo Yii::t('app','Choose Room'); ?></strong> -->
                        <?php
                        
						$this->room_id = Yii::app()->session['room_dash'];
							   
                        $criteria = new CDbCriteria(array('order'=>'room_name'));
                        echo CHtml::dropDownList('room_name',$selected_value="$this->room_id", $this->actionLoadRoomByShift(),// array(),
                                 array(
                            'prompt'=>Yii::t('app','-- Please select room --'),
                             'ajax'=>array(
                            'type'=>'POST', //request type
                            'url'=>CController::createUrl('customReport/previewDashboard'),
                             // array('customReport/previewDashboard'),
                               //  'type'=>'POST',
                             'update'=>'#dachbod_re', 
                                 )
                                     
                           ));
                       
                        ?>
                     </label>
                 </div>
            <div class="span3">
                <label>
                    &nbsp; &nbsp; &nbsp;
                </label>
                 <?php
                 /*
            echo CHtml::ajaxSubmitButton(
                    Yii::t('app','Show dashboard'),
                    array('customReport/previewDashboard'),
                    array(
                        'update'=>'#dachbod_re',
                        ), 
                    array('class' => "btn btn-primary",'name'=>'btnPreview')
                    );
                  * 
                  */
            ?>
            </div>
        </div> 
    </div>
</div>

 <?php $this->endWidget(); ?>
<div id="dachbod_re" >
	
	<?php 
	if(!Yii::app()->request->isAjaxRequest)
		{
			 $acad=Yii::app()->session['currentId_academic_year'];
     $customReport = new CustomReport; 
	 
	 $this->room_id = Yii::app()->session['room_dash'];
	 if($this->room_id=='')
	   $this->room_id = 0;
	 $level_id = 0;
	 $room_name = '';
	 
	 if(Rooms::model()->findByPk($this->room_id)!=null)
       { $level_id = Rooms::model()->findByPk($this->room_id)->level;
       
	     if(Rooms::model()->findByPk($this->room_id)->short_room_name!=null)
	     {
	         $room_name = Rooms::model()->findByPk($this->room_id)->short_room_name; 
	     }else{
	        $room_name = Rooms::model()->findByPk($this->room_id)->room_name;
	     }
	     
       }
     $passing_grade = $this->getPassingGrade($level_id, $acad);
    
     $string_sql = "SELECT p.id, p.last_name, p.image, p.first_name, p.gender, r.room_name   FROM `persons` p
                    INNER JOIN room_has_person rh ON (rh.students = p.id)
                    INNER JOIN rooms  r ON  (rh.room = r.id )
                    WHERE rh.academic_year = $acad AND  r.id = $this->room_id AND p.active IN (1,2)
                    ORDER BY p.last_name";
     $data = Persons::model()->findAllBySql($string_sql);
     
     
 $string_sql_periode = "SELECT distinct g.evaluation, a.id as idantite_peryod, a.name_period FROM grades g INNER JOIN evaluation_by_year eby ON (g.evaluation = eby.id) INNER JOIN academicperiods a ON (eby.academic_year = a.id) INNER JOIN evaluations e ON (eby.evaluation = e.id) where e.academic_year = $acad ORDER BY a.name_period";
 
 // Construction des periodes d'examen    
 
 $data_periode = Grades::model()->findAllBySql($string_sql_periode);
 $array_period = array(); 
 $array_effectif = array();
 $array_success = array();
 $array_fail = array();
 $array_success_rate = array();
 $array_fail_rate = array();
 $j = 0;

 if($data_periode !=null)
 { 
 foreach($data_periode as $ap){
     $array_period[$j] = $ap->name_period;
     $array_effectif[$j] = $this->getRoomSizeByExam($this->room_id, $ap->evaluation);
     $array_success[$j] = $this->getSuccesSizeByExam($this->room_id, $ap->evaluation,$acad);
     $array_fail[$j] = $array_effectif[$j]-$array_success[$j];
     $j++;
 }
 }
 
 $count_tardy = $customReport->getAttendanceCountByRoom($this->room_id, $acad, array(3,4));
 $count_tardy_f = $customReport->getAttendanceCountByRoomBySex($this->room_id, $acad, array(3,4),1);
 $count_tardy_m = $customReport->getAttendanceCountByRoomBySex($this->room_id, $acad, array(3,4),0);
 $count_absence = $customReport->getAttendanceCountByRoom($this->room_id, $acad, array(1,2)); 
 $count_absence_f = $customReport->getAttendanceCountByRoomBySex($this->room_id, $acad, array(1,2),1);
 $count_absence_m = $customReport->getAttendanceCountByRoomBySex($this->room_id, $acad, array(1,2),0);
 $count_infraction = $customReport->getInfractionCountByRoom($this->room_id, $acad);
 
 $expected_amount =  $customReport->getExpectedAmountByRoom($this->room_id, $acad);
 $total_pay = $customReport->getAmountPayByRoom($this->room_id, $acad);
 $total_balance = $expected_amount - $total_pay; 
 
 $count_stud_no_debt = $customReport->getCountStudentForPay($this->room_id, $acad, 1);
 $count_stud_with_debt = $customReport->getCountStudentForPay($this->room_id, $acad, 2);
 $count_stud_never_pay = $this->getZeroPayStud($this->room_id, $acad);//$customReport->getCountStudentForPay($this->room_id, $acad, 3);
$data_other_infraction = $this->getMostFrequentInfraction($this->room_id, $acad);

 $list_period = join($array_period, "','");
 $list_effectif  = join($array_effectif,",");
 $list_success = join($array_success,",");
 $list_fail = join($array_fail,",");

     $this->renderPartial('_dashboard',array(
         'data'=>$data,
         'room_id'=>$this->room_id,
         'acad'=>$acad,
         'data_periode'=>$data_periode,
         'passing_grade'=>$passing_grade,
         'room_name'=>$room_name,
         'acad'=>$acad,
         'list_period'=>$list_period,
         'list_effectif'=>$list_effectif,
         'list_success'=>$list_success,
         'list_fail'=>$list_fail,
         'count_tardy'=>$count_tardy,
         'count_absence'=>$count_absence,
         'count_infraction'=>$count_infraction,
         'data_other_infraction'=>$data_other_infraction,
         'count_tardy_f'=>$count_tardy_f,
         'count_tardy_m'=>$count_tardy_m,
         'count_absence_f'=>$count_absence_f,
         'count_absence_m'=>$count_absence_m,
         
         'expected_amount'=>$expected_amount,
         'total_pay'=>$total_pay,
         'total_balance'=>$total_balance,
         'count_stud_no_debt'=>$count_stud_no_debt,
         'count_stud_with_debt'=>$count_stud_with_debt,
         'count_stud_never_pay'=>$count_stud_never_pay,
      
     ));
			
		}
   ?>
</div>


