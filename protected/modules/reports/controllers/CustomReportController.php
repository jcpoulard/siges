<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CustomReportController extends Controller{
    
    public $layout='//layouts/column2';
    public $string_sql = null;
    public $attributes_name = array();
    public $query_yii = null;
    public $part = null;
    public $academic_year=null;
    public $relation_name;
	
	public $shift_id;
	public $room_id;

    
    public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','customReportStud','loadAcademicPeriod','loadCourse','loadRoomByShift','previewReport'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    
    public function actionIndex(){
        
        $model = new CustomReport; 
        $select_field = "SELECT ";
        $query_yii = "";
        if(isset($_POST['btnPreview'])){
            if(isset($_POST['available_fields']) && isset($_POST['dimension'])){
                $available_fields = $_POST['available_fields'];
                $this->attributes_name = $available_fields;
                $dimension = $_POST['dimension'];
                for($i=0; $i < count($available_fields); $i++){
                    if($i<count($available_fields)-1){
                        $query_yii .= $available_fields[$i].","; 
                        $select_field .= $available_fields[$i].",";
                    }elseif($i==count($available_fields)-1){
                        $select_field .= $available_fields[$i];
                        $query_yii .= $available_fields[$i];
                    }
                }
                
                switch($dimension){
                    case 1:
                        $select_field = $select_field." FROM persons";
                        break;
                    case 2: 
                        $select_field = $select_field." FROM grades";
                        break;
                    case 3:
                        $select_field = $select_field." FROM record_infraction";
                        break;
                    case 4:
                        $select_field = $select_field." FROM billings";
                        break;
                    default:
                        $select_field = $select_field."FROM  persons";
                        
                }
                $this->query_yii = $query_yii;
                $this->string_sql = $select_field;
            }
            
           
        }
        
       // $model=new Sellings('search');
        
        $this->render('index',array('model'=>$model));
        
    }
    
    
    
    
    
    
    
    public function actionLoadAcademicPeriod()
        {
            $data=  AcademicPeriods::model()->findAll('year=:academic_year AND is_year=0', 
                          array(':academic_year'=>(int) $_POST['academic_year']));

            $data=CHtml::listData($data,'id','name_period');
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',
                           array('value'=>$value),CHtml::encode($name),true);
            }
        }
        
        public function actionLoadCourse()
        {
            $data=  Courses::model()->findAll('room=:room_id AND academic_period=:academic_period', 
                          array(':room_id'=>(int) $_POST['room_name'],':academic_period'=>(int)$_POST['academic_year']));

            $data=CHtml::listData($data,'id','courseName');
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',
                           array('value'=>$value),CHtml::encode($name),true);
            }
        }
        
       
        
  public function actionCustomReportStud(){
        $this->part = "stud";
        $model = new CustomReport;
        $modelRptCustom = new RptCustom;
        
        if(isset($_POST['btnSave'])){
            $a_value = array();
            $a_value = $_POST;
            unset($a_value['YII_CSRF_TOKEN']);
            
            
            $titre = $a_value['report_title'];
            $academic_year = $a_value['academic_year'];
            $modelRptCustom->setAttribute('title', $titre);
            $data = json_encode($a_value);
            $modelRptCustom->setAttribute('data', $data);
            $modelRptCustom->setAttribute('categorie', "Students");
            $modelRptCustom->setAttribute('create_by', Yii::app()->user->name);
            $modelRptCustom->setAttribute('create_date', date("Y-m-d H:m:s"));
            $modelRptCustom->setAttribute('academic_year', $academic_year);
            if($modelRptCustom->save()){
                $this->redirect(array("listdetails?id=$modelRptCustom->id&part=stud&from1=rpt"));
            }
        }
        
        if(isset($_POST['btnCancel'])){
            $this->redirect(array("list?part=stud&from1=rpt"));
        }
        
        $this->render('customReportStud',array('model'=>$model));
    }
    
    public function actionList(){
        $this->part = "stud";
        $modelRptCustom = new RptCustom;
        
        if(isset($_POST['academic_year'])){
            $this->academic_year = $_POST['academic_year'];
        }
        
        $this->render('list',array('model'=>$modelRptCustom));
    }
     
    public function actionListdetails(){
        $this->part = "stud";
        $modelRptCustom = new RptCustom;
        
        $this->render('list_details',array('model'=>$modelRptCustom));
    }
    
    public function actionDelete($id){
         
       
            $model = RptCustom::model()->findByPk($id);
            $model->delete(); 
            
            $this->redirect(array('list'));
       
    }
    
    /**
     * 
     * @param type $id_level
     * @param type $id_academic_period
     * @return type
     */
public function getPassingGrade($id_level, $id_academic_period)
	{
		$criteria = new CDbCriteria;
		$criteria->condition='level_or_course=0 AND level=:idLevel AND academic_period=:idAcademicLevel';
		$criteria->params=array(':idLevel'=>$id_level,':idAcademicLevel'=>$id_academic_period);
		$pass_grade = PassingGrades::model()->find($criteria);
	 
	  if(isset($pass_grade))
	  return $pass_grade->minimum_passing; 
	  else 
	    return null;
	}    
        
   /**
    * 
    * @param type $acad
    * @param type $id_room
    * @param type $id_period
    * @return type
    */ 
        
public function getRoomSizeByExam($room_id, $evaluation){
    $room_size = 0;
    $sql_string = "SELECT distinct g.student, g.evaluation from grades g INNER JOIN courses c ON (g.course = c.id) INNER JOIN rooms r ON (c.room = r.id) WHERE g.evaluation = $evaluation and r.id = $room_id";
    $data = Grades::model()->findAllBySql($sql_string);
    foreach($data as $d){
        $room_size++;
    }
    
    return $room_size; 
}

   /**
    * 
    * @param type $acad
    * @param type $id_room
    * @param type $id_period
    * @return type
    */ 
        
public function getRoomSize($room_id,$acad){
    $room_size = 0;
    $sql_string = "SELECT rhp.id FROM room_has_person rhp INNER JOIN persons p ON (rhp.students = p.id) WHERE rhp.room = $room_id and rhp.academic_year = $acad AND p.active IN (1,2)";
    $data = RoomHasPerson::model()->findAllBySql($sql_string);
    foreach($data as $d){
        $room_size++;
    }
    
    return $room_size; 
}


public function getSuccesSizeByExam($room_id, $evaluation,$acad){
    $customReport = new CustomReport; 
    $room_size = 0;
    $sql_string = "SELECT distinct g.student, g.evaluation from grades g INNER JOIN courses c ON (g.course = c.id) INNER JOIN rooms r ON (c.room = r.id) where g.evaluation = $evaluation and r.id = $room_id";
    $data = Grades::model()->findAllBySql($sql_string);
    $level_id = Rooms::model()->findByPk($room_id)->level;
    $passing_grade = $this->getPassingGrade($level_id, $acad);
     
    foreach($data as $d){
        $studentAverage = $customReport->calMoyStudent($d->student, $evaluation);
        if($studentAverage >= $passing_grade){
            $room_size++;
        }
    }
    
    
    return $room_size; 
}
        




 public function actionLoadRoomByShift()
        {
            if(isset($_POST['shift_id']))
			{
			  $shift_id = (int) $_POST['shift_id'];
			$data=  Rooms::model()->findAll(array('alias'=>'r','join'=>'inner join room_has_person rh on(r.id=rh.room)','condition'=>'shift='.$shift_id ) );

            $data=CHtml::listData($data,'id','short_room_name');
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',
                           array('value'=>$value),CHtml::encode($name),true);
            }
			}
		   else
		   {
			   $this->shift_id = Yii::app()->session['shift_dash'];
										
			   $data=  Rooms::model()->findAll(array('alias'=>'r','join'=>'inner join room_has_person rh on(r.id=rh.room)','condition'=>'shift='.$this->shift_id)  );

             $data=CHtml::listData($data,'id','short_room_name');
              
			  return $data;
		   }
        }
        
		
 public function actionDashboard(){
        
        $this->layout = '//layouts/l_dashboard';
        $this->part = "stud";
        $modelRptCustom = new RptCustom;
		
		if(!Yii::app()->request->isAjaxRequest)
		{
			//default shift
									 $default_vacation_name = infoGeneralConfig('default_vacation');
										$criteria2 = new CDbCriteria;
										$criteria2->condition='shift_name=:item_name';
										$criteria2->params=array(':item_name'=>$default_vacation_name,);
										$default_vacation = Shifts::model()->find($criteria2);
										
										$this->shift_id = $default_vacation->id;
										Yii::app()->session['shift_dash'] = $this->shift_id;
										
										 $data=  Rooms::model()->findAll(array('alias'=>'r','join'=>'inner join room_has_person rh on(r.id=rh.room)','condition'=>'shift='.$this->shift_id)  );

										foreach($data as $value)
										{
											$this->room_id = $value->id;
											Yii::app()->session['room_dash'] = $this->room_id;
											
											break;
										}
										
										
										
										
		}
		
         $this->render('dashboard',array('model'=>$modelRptCustom));
    }
		
        
 public function actionPreviewDashboard(){
     $acad=Yii::app()->session['currentId_academic_year'];
     $customReport = new CustomReport; 
    
     $this->room_id = $_POST['room_name'];
	 Yii::app()->session['room_dash'] = $this->room_id;
	 
    $level_id = Rooms::model()->findByPk($this->room_id)->level;
     if(Rooms::model()->findByPk($this->room_id)->short_room_name!=null){
         $room_name = Rooms::model()->findByPk($this->room_id)->short_room_name; 
     }else{
        $room_name = Rooms::model()->findByPk($this->room_id)->room_name;
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
 
 foreach($data_periode as $ap){
     $array_period[$j] = $ap->name_period;
     $array_effectif[$j] = $this->getRoomSizeByExam($this->room_id, $ap->evaluation);
     $array_success[$j] = $this->getSuccesSizeByExam($this->room_id, $ap->evaluation,$acad);
     $array_fail[$j] = $array_effectif[$j]-$array_success[$j];
     $j++;
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
// $room_effectif = $this->getRoomSize($this->room_id, $acad);
// $count_stud_never_pay = $room_effectif - ($count_stud_no_debt+$count_stud_with_debt);//$customReport->getCountStudentForPay($this->room_id, $acad, 3);
$count_stud_never_pay = $this->getZeroPayStud($this->room_id, $acad);
 $list_period = join($array_period, "','");
 $list_effectif  = join($array_effectif,",");
 $list_success = join($array_success,",");
 $list_fail = join($array_fail,",");
 $data_other_infraction = $this->getMostFrequentInfraction($this->room_id, $acad);

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
 
 public function getMostFrequentInfraction($room, $acad){
     $string_sql = "SELECT ti.name AS nom_frequent, count(ti.name) as compter_infraction FROM record_infraction ri INNER JOIN infraction_type ti ON (ri.infraction_type = ti.id) INNER JOIN room_has_person rhp ON (ri.student = rhp.students)  WHERE rhp.room = $room AND rhp.academic_year = $acad GROUP BY ti.name ORDER BY count(ti.name) DESC LIMIT 10";
    $json_value = "";
     $color = array("#A9E65D","#FABA3C","#539DC8","#00E4C1","#F2E6E0","#EE642E","#4CAF50","#FF4242","#6E1570","#6B7015");
     $j=0;
     $data = RecordInfraction::model()->findAllBySql($string_sql);
     foreach($data as $d){
        $json_value .= '{"title": "'.substr($d->nom_frequent,0,20).'", "value": '.$d->compter_infraction.',"color": "'.$color[$j].'"},';
        $j++;
     }
    
     return $json_value; 
     
 }
 
 public function getZeroPayStud($room, $acad){
     $string_sql = "SELECT DISTINCT p.id FROM persons p INNER JOIN billings b ON (p.id = b.student) INNER JOIN room_has_person rhp ON (p.id = rhp.students) WHERE p.id NOT IN (SELECT student FROM billings  WHERE academic_year = $acad) OR p.id IN (SELECT student FROM billings WHERE academic_year = $acad GROUP BY student HAVING SUM(amount_pay) = 0) AND rhp.room = $room AND rhp.academic_year = $acad AND p.active IN (1,2)";
     $data = Persons::model()->findAllBySql($string_sql);
     $count_student = 0;
     if($data!=null){
         foreach($data as $d){
             $count_student++;
         }
     }
     
     return $count_student; 
     
 }
         
    
 // Retourne la moyenne d'un eleve par periode et pour une annee academique 
 public function getStudentGradeByPeriod($acad, $period, $student){
     $average = null;
     $sql_string = "SELECT abp.average  FROM `average_by_period` abp
                    INNER JOIN evaluation_by_year eby ON (abp.evaluation_by_year = eby.id)
                    INNER JOIN academicperiods a ON (eby.academic_year = a.id)
                    INNER JOIN room_has_person rh ON (abp.student = rh.students)
                    WHERE abp.academic_year = $acad AND a.id = $period  AND abp.student = $student ORDER BY a.name_period";
     $data = AverageByPeriod::model()->findAllBySql($sql_string);
     foreach($data as $d){
         if($d->average!=null){
             $average = $d->average; 
         }else{
             $average = 'N/A';
         }
     }
     return $average; 
 }
 

       
  /**
   * 
   * @param type $id student
   * @return an array of sutudent primary contact info 
   * 
   * 
   */    
 public function getStudentContactInfo($id){
     $string_sql = "SELECT ci.id, ci.person, ci.contact_name, ci.contact_relationship, r.relation_name, ci.profession, ci.phone, ci.address, ci.email FROM contact_info ci INNER JOIN relations r ON (ci.contact_relationship = r.id) where ci.person = $id ORDER BY ci.id ASC LIMIT 0,1";
     $data = ContactInfo::model()->findAllBySql($string_sql);
     $return_data = array(); 
     foreach($data as $rd){
         $return_data['contact_name'] = $rd->contact_name; 
         $return_data['contact_phone'] = $rd->phone;
         $return_data['address'] = $rd->address;
         $return_data['email'] = $rd->email;
         
     }
     return $return_data; 
     
 } 
 
 /**
  * 
  * @param type $id Student 
  * @param type $acad academic year 
  * @return a float value of the amount pay by a student 
  */
 public function getStudentPay($id, $acad){
     $amount_pay = 0.00;
     $tot_receive_on_fee =0;
     $old_fee =0;
     $pasedeja = [];
      
     $string_sql = "SELECT academic_year,fees.amount as montant, fee_period,fee_totally_paid, student, amount_pay FROM billings inner join fees on(fees.id=billings.fee_period) where student = $id AND amount_pay<>0 AND academic_year =$acad";
     $data = Billings::model()->findAllBySql($string_sql);
     if($data!=null){
       foreach($data as $d)
         {
             if(!in_array($d->fee_period,$pasedeja))
             {
             	if($old_fee==$d->fee_period)
             	  {  
             	  	   if($d->fee_totally_paid==1)
			               { $amount_pay+=$d->montant;
			                  $pasedeja[] = $d->fee_period;
			                  $tot_receive_on_fee =0;
			               }
			            else
			              $tot_receive_on_fee += $d->amount_pay;
             	  
             	   }
             	else
             	  {   //pou sak avan
             	  	   $old_fee = $d->fee_period;
             	       $amount_pay+=$tot_receive_on_fee;
             	       
             	       $tot_receive_on_fee=0;
             	      //pou sa kounya  
             	        if($d->fee_totally_paid==1)
			               { $amount_pay+=$d->montant;
			                  $pasedeja[] = $d->fee_period;
			               }
			            else
			              {
			               	$tot_receive_on_fee = $d->amount_pay;
			               	}
             	  	
             	  	}
             	  	
             	  	
             	}
             
             }
                
                
                
                
           }
     
     return $amount_pay;
 }
 
 public function getStudentBalance($id, $acad){
    $balance = 0.00; 
    $string_sql = "SELECT student, balance FROM balance where student = $id ";
    $data = Balance::model()->findAllBySql($string_sql);
    if($data!=null){
        foreach($data as $d){
            $balance += $d->balance; 
        }
    }
    return $balance; 
 }
 
        
       
  public function actionPreviewReport() {
        
    $a_value = array();
    $a_value = $_POST;
   
    unset($a_value['YII_CSRF_TOKEN']);
    
    if($a_value['rangereport']=="byroom"){
    $range_report = $a_value['rangereport'];  
    $titre = $a_value['report_title'];
    $academic_period = $a_value['period_id'];
    $room_name = $a_value['room_name'];
    $course_id = $a_value['course_id'];
    $value_compare = $a_value['value_compare'];
    $rptCondition = $a_value['rptCondition'];
    
   $shift_name = Shifts::model()->findByPk($a_value['shift_id'])->shift_name;
    
    $subject_name = null;
    $concat_name = array();
    $array_grade = array();
    $array_grade_f = array();
    $array_grade_m = array();
    $concat_name_f = array();
    $concat_name_m = array();
    $string_sub_title = null;
    $string_periode = null;
    $string_room = null;
    $string_acad = null;
    $coefficient = null;
    $query_condition = null; 
    $string_when_between = null;
    if($rptCondition=="between"){
        $query_condition = "BETWEEN ".$a_value['betFrom']." AND ".$a_value['betTo'];
        $string_when_between = YII::t('app','Between {betFrom} & {betTo}',array('{betFrom}'=>$a_value['betFrom'],'{betTo}'=>$a_value['betTo']));
    }else{
        $query_condition = "$rptCondition $value_compare";
        $string_when_between = "$rptCondition $value_compare";
    }
    
    /**
     * Contruction du rapport en SQL 
     */
 
    $string_sql = "SELECT g.id, p.first_name, p.last_name, p.gender, (YEAR(Now())-YEAR(p.birthday)) AS 'age',s.subject_name, a.name_period, g.grade_value, c.weight,
                r.room_name
                FROM `grades` g 
                INNER JOIN persons p ON (g.student = p.id)
                INNER JOIN courses c ON (g.course = c.id)
                INNER JOIN rooms r ON (c.room = r.id)
                INNER JOIN subjects s ON (c.subject = s.id)
                INNER JOIN evaluation_by_year eby ON (g.evaluation = eby.id)
                INNER JOIN academicperiods a ON (eby.academic_year = a.id)
                
                WHERE c.id = $course_id AND a.id = $academic_period AND g.grade_value $query_condition ORDER BY p.last_name";
    
    $data = Grades::model()->findAllBySql($string_sql);
    $i=0;
    $count_male=0;
    $count_female=0;
    // Debug option  
   // echo json_encode($a_value);
    // Construction du tableau des donnees 
    echo '<h3 id="custom_report">'.$titre.'</h3><div class="grid-view"><table class="items">'
    . '<thead><tr><th>'.Yii::t('app','#').'</th>'
            . '<th>'.Yii::t('app','Last name').'</th>'
            . '<th>'.Yii::t('app','First name').'</th>'
            . '<th>'.Yii::t('app','Gender').'</th>'
            . '<th>'.Yii::t('app','Grade').'</th>'
            . '<th>'.Yii::t('app','Weight').'</th></tr></thead>';
    foreach($data as $d){
        if($d["gender"]==0){
            $sexe_value = Yii::t('app','Male');
            $array_grade_m[$i]=$d["grade_value"];
            $concat_name_m[$i] = $d["first_name"].' '.$d["last_name"];
            $count_male++;
        }else{
            $sexe_value = Yii::t('app','Female');
            $array_grade_f[$i]=$d["grade_value"];
            $concat_name_f[$i] = $d["first_name"].' '.$d["last_name"];
            $count_female++;
        }
        $subject_name = $d["subject_name"].', '.$d["room_name"];
        
        $concat_name[$i] = $d["first_name"].' '.$d["last_name"];
        $array_grade[$i] = $d["grade_value"];
        $string_periode = $d["name_period"];
        $string_room = $d["room_name"];
        $coefficient = $d["weight"];
        $string_acad = getAcademicYearNameByPeriodId($academic_period);
        $string_sub_title = $d["subject_name"].' '.$string_room.' '.$shift_name.' , '.Yii::t('app','Grades : ').$string_when_between.'<br/> ('.$string_acad.'/'.$string_periode.')';
        
        $i++;
        echo '<tr>';
        echo '<td>'.$i.'</td>';
        echo '<td>'.$d["last_name"].'</td>';
        echo '<td>'.$d["first_name"].'</td>';
        echo '<td>'.$sexe_value.'</td>';
        echo '<td>'.$d["grade_value"].'</td>';
        echo '<td>'.$d["weight"].'</td>';
        echo '</tr>';
        
       // print_r($d);
        
    }
    echo '</table></div>';
    echo '<br/>';
    // Construction des donnees du graphe (nom des etudiants)
    // Calcul de la moyenne
    $asum_ = array_sum($array_grade);
    $acount_ = count($array_grade);
    $average_ = round($asum_/$acount_,2);
    $max_ = max($array_grade);
    $min_ = min($array_grade);
    // Calcul de l'ecrat-type (Standard deviation) 
    $standard_deviation_ = round(standard_deviation($array_grade,false),2);
    $string_student_name = join($concat_name, "','");
    $string_student_name_f = join($concat_name_f, "','");
    $string_student_name_m = join($concat_name_m, "','");
    // Notes des etudiants 
    $string_grade_value =  join($array_grade, ',');
    $string_grade_value_f =  join($array_grade_f, ',');
    $string_grade_value_m =  join($array_grade_m, ',');
    //Option de debug
  // echo $string_sql;
   echo '<br/>';
   //echo json_encode($a_value);
   //Option de debug 
   
   // Envoi les donnees via AJAX au graphe 
    $this->renderPartial('_chart', 
            array('report_title'=>$titre,
                'subject_name'=>$subject_name,
                'concat_name'=>$string_student_name,
                'concat_name_f'=>$string_student_name_f,
                'concat_name_m'=>$string_student_name_m,
                'array_grade'=>$string_grade_value,
                'array_grade_f'=>$string_grade_value_f,
                'array_grade_m'=>$string_grade_value_m,
                'sub_title'=>$string_sub_title,
                'coefficient'=>$coefficient,
                'count_male'=>$count_male,
                'count_female'=>$count_female,
                'average_'=>$average_,
                'standard_deviation_'=>$standard_deviation_,
                'max_'=>$max_,
                'min_'=>$min_,
                'range_report'=>$range_report,
                ));
    
    Yii::app()->end();

    }
    // Debut de la gestion des moyennes par periodes 
    elseif($a_value['rangereport']=="all"){
        echo json_encode($a_value);
    $range_report = $a_value['rangereport'];     
    $titre = $a_value['report_title'];
    $academic_period = $a_value['period_id'];
    $room_name = $a_value['room_name'];
   // $course_id = $a_value['course_id'];
    $value_compare = $a_value['value_compare'];
    $rptCondition = $a_value['rptCondition'];
    
   $shift_name = Shifts::model()->findByPk($a_value['shift_id'])->shift_name;
    
    $subject_name = null;
    $concat_name = array();
    $array_grade = array();
    $array_grade_f = array();
    $array_grade_m = array();
    $concat_name_f = array();
    $concat_name_m = array();
    $string_sub_title = null;
    $string_periode = null;
    $string_room = null;
    $string_acad = null;
    $coefficient = null;
    $query_condition = null; 
    $string_when_between = null;
    if($rptCondition=="between"){
        $query_condition = "BETWEEN ".$a_value['betFrom']." AND ".$a_value['betTo'];
        $string_when_between = YII::t('app','Between {betFrom} & {betTo}',array('{betFrom}'=>$a_value['betFrom'],'{betTo}'=>$a_value['betTo']));
    }else{
        $query_condition = "$rptCondition $value_compare";
        $string_when_between = "$rptCondition $value_compare";
    }
    
    /**
     * Contruction du rapport en SQL 
     */
 
    $string_sql = "SELECT  abp.student, r.room_name, r.id, a.name_period, abp.sum, abp.academic_year, abp.evaluation_by_year, abp.average, abp.place, p.last_name, p.first_name, p.gender, p.birthday  FROM `average_by_period` abp 
                   INNER JOIN persons p ON (abp.student = p.id)
                   INNER JOIN evaluation_by_year eby ON (abp.evaluation_by_year = eby.id)
                   INNER JOIN academicperiods a ON (eby.academic_year = a.id)
                   INNER JOIN room_has_person rhp ON (abp.student = rhp.students)
                   INNER JOIN rooms r ON (rhp.room = r.id)
                
                WHERE r.id = $room_name AND a.id = $academic_period AND abp.average $query_condition ORDER BY p.last_name";
    
    $data = AverageByPeriod::model()->findAllBySql($string_sql);
    $i=0;
    $count_male=0;
    $count_female=0;
    // Debug option  
   // echo json_encode($a_value);
    // Construction du tableau des donnees 
    echo '<h3 id="custom_report">'.$titre.'</h3><div class="grid-view"><table class="items">'
    . '<thead><tr><th>'.Yii::t('app','#').'</th>'
            . '<th>'.Yii::t('app','Last name').'</th>'
            . '<th>'.Yii::t('app','First name').'</th>'
            . '<th>'.Yii::t('app','Gender').'</th>'
            . '<th>'.Yii::t('app','Average').'</th>';
          //  . '<th>'.Yii::t('app','Weight').'</th></tr></thead>';
    foreach($data as $d){
        if($d["gender"]==0){
            $sexe_value = Yii::t('app','Male');
            $array_grade_m[$i]=$d["average"];
            $concat_name_m[$i] = $d["first_name"].' '.$d["last_name"];
            $count_male++;
        }else{
            $sexe_value = Yii::t('app','Female');
            $array_grade_f[$i]=$d["average"];
            $concat_name_f[$i] = $d["first_name"].' '.$d["last_name"];
            $count_female++;
        }
        $subject_name = $d["name_period"].', '.$d["room_name"];
        
        $concat_name[$i] = $d["first_name"].' '.$d["last_name"];
        $array_grade[$i] = $d["average"];
        $string_periode = $d["name_period"];
        $string_room = $d["room_name"];
       // $coefficient = $d["weight"];
        $string_acad = getAcademicYearNameByPeriodId($academic_period);
        $string_sub_title = $d["name_period"].' '.$string_room.' '.$shift_name.' , '.Yii::t('app','Average : ').$string_when_between.'<br/> ('.$string_acad.'/'.$string_periode.')';
        
        $i++;
        echo '<tr>';
        echo '<td>'.$i.'</td>';
        echo '<td>'.$d["last_name"].'</td>';
        echo '<td>'.$d["first_name"].'</td>';
        echo '<td>'.$sexe_value.'</td>';
        echo '<td>'.$d["average"].'</td>';
       // echo '<td>'.$d["weight"].'</td>';
        echo '</tr>';
        
       // print_r($d);
        
    }
    echo '</table></div>';
    echo '<br/>';
    // Construction des donnees du graphe (nom des etudiants)
    // Calcul de la moyenne
    $asum_ = array_sum($array_grade);
    $acount_ = count($array_grade);
    $average_ = round($asum_/$acount_,2);
    $max_ = max($array_grade);
    $min_ = min($array_grade);
    // Calcul de l'ecrat-type (Standard deviation) 
    $standard_deviation_ = round(standard_deviation($array_grade,false),2);
    $string_student_name = join($concat_name, "','");
    $string_student_name_f = join($concat_name_f, "','");
    $string_student_name_m = join($concat_name_m, "','");
    // Notes des etudiants 
    $string_grade_value =  join($array_grade, ',');
    $string_grade_value_f =  join($array_grade_f, ',');
    $string_grade_value_m =  join($array_grade_m, ',');
    //Option de debug
  // echo $string_sql;
   echo '<br/>';
   //echo json_encode($a_value);
   //Option de debug 
   
   // Envoi les donnees via AJAX au graphe 
    $this->renderPartial('_chart', 
            array('report_title'=>$titre,
                'subject_name'=>$subject_name,
                'concat_name'=>$string_student_name,
                'concat_name_f'=>$string_student_name_f,
                'concat_name_m'=>$string_student_name_m,
                'array_grade'=>$string_grade_value,
                'array_grade_f'=>$string_grade_value_f,
                'array_grade_m'=>$string_grade_value_m,
                'sub_title'=>$string_sub_title,
               // 'coefficient'=>$coefficient,
                'count_male'=>$count_male,
                'count_female'=>$count_female,
                'average_'=>$average_,
                'standard_deviation_'=>$standard_deviation_,
                'max_'=>$max_,
                'min_'=>$min_,
                'range_report'=>$range_report,
                ));
    
    Yii::app()->end();

        
    }
    
    
   
        }

        
        
    
    
}