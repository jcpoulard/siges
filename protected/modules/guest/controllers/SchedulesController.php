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




Yii::import('ext.tcpdf.*');


class SchedulesController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $idAcademicP;
	public $idAcademicP_hold;
	public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	public $student_id;
	
	public $allowLink=false;
	public $temoin_data=false;
	public $different=false; // pou chanjman ane akademik yo		
	
	public $success=false;
		
	public $pathLink="";
	
	public $messageidAcademicP=false;
	public $messageNoSchedule=false;
	
	

	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	public function accessRules()
	{
		    
		  $explode_url= explode("/",substr($_SERVER['REQUEST_URI'], 1));
            $controller=$explode_url[3];
            //print_r($explode_url);
            $actions=$this->getRulesArray($this->module->name,$controller);
              
            if($this->getModuleName($this->module->name))
                {
		            if($actions!=null)
             			 {     return array(
				              	  	array('allow',  
					                	
					                	'actions'=> $actions,
		                                  'users'=>array(Yii::app()->user->name),
				                    	),
				              		  array('deny',  
					                 	'users'=>array('*'),
				                    ),
			                );
             			 }
             			 else
             			  return array(array('deny', 'users'=>array('*')),);
                }
                else
                {
                    return array(array('deny', 'users'=>array('*')),);
                }


	}

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

		
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

        /*
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Schedules');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
         * 
         */

	public function actionIndex()
	{    
	     $acad=Yii::app()->session['currentId_academic_year']; 
		 

        $model=new Schedules;
		$modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelacademicP = new AcademicPeriods;
		 
				$this->different=false;	
                $this->allowLink=false;				
		//$this->idAcademicP_hold=Yii::app()->session['AcademicP_sch'] ;
		
		if(isset($_POST['Persons']))
               	{      
						  
				    	
				  
		     $person=0;
           $room_id=0;     
         
              $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    //$group= $group->getData();
                    
                     //foreach($group as $g)
                          $group_name=$group->group_name;
            if($group_name=='Student')
              {
                   $user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
              }
            elseif($group_name=='Parent')	    
		      {  //get ID of selected child  
		         if(isset($_POST['Persons']))
		           {  $pers=$_POST['Persons']['id'];
		              
		               unset(Yii::app()->session['child']);
		              //set current child variable session
					   Yii::app()->session['child']=$pers;
		            	$this->student_id=$pers;	
		            		        	           
		           }
		           else
                     $this->student_id=Yii::app()->session['child'];
		        }

                   //get ID of selected child  
		       // $modelP=new Persons;
		           // $person=$_POST['Persons']['id'];
		   
		           //  $this->student_id=$person;
			       //get room ID in which this child enrolled
                $modelRoom=Rooms::model()->getRoom($this->student_id, $acad)->getData();
                
                foreach($modelRoom as $r)
                   $this->room_id=$r->id;
                   					      
                      
			             
						   
	                        $this->messageNoSchedule=false;
						 
						 
                    						  
						  if(($this->room_id!=""))
						  {  
						     
							   
						          $room=$this->getRoom($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
								//to show update link and create_pdf button only when there records for the room
								$courses=$this->getCoursesAndTimes($this->room_id,$this->idAcademicP);
								if((isset($courses))&&($courses!=null)) 
								  {  //foreach($courses as $course)
								     $this->temoin_data=true;
								     $this->messageNoSchedule=true;
								  }
								 else
									$this->messageNoSchedule=false;	
										
						     // echo '<br/><br/><br/><br/><br/><br/><br/><br/>llllllllllllllllllllllllllllllllllll'.$this->idAcademicP.'oooooooooooooooooooooooooooooooo'.Yii::app()->session['old_AcademicP_sch'];
						     
						      //$acadPeriod=$this->getAcademicPeriodeName($this->idAcademicP);
						      
						  
						  }
						 
						 
										
						  
						  
					$this->success=false;				

	             }
		       else
		         {         
							 $this->success=false;
					           $this->messageidAcademicP=false;
							   $this->messageNoSchedule=false;
		                    
		
		         }
		
                
                
                  
		
		$model=new Schedules('search');
		/*if(isset($_GET['Schedules']))
			$model->attributes=$_GET['Schedules'];
			
		
*/
		$this->render('index',array(
			'model'=>$model,
		));
	}
	

	
	
	
	public function actionViewForTeacher()
	{
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			$model=new Schedules('search');
		if(isset($_GET['Schedules']))
			$model->attributes=$_GET['Schedules'];
         
		 // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Schedules View for teacher: ')), null,false);
			//$this->exportCSV($model, array_keys($model->attributeLabels()),false, 3);
			$this->exportCSV($model->search(), array(
					'course0.courseName',
					'day',
					'time_start',
					'time_end')); 
		}
		
				
		$this->render('viewForTeacher',array(
			'model'=>$model,
		));
	}
	
	
	
	//************************  loadChildren($userName) ******************************/
	public function loadChildren($userName)
	{     
	      $acad=Yii::app()->session['currentId_academic_year']; 
		 
		 $userid = null;
		 $code= array();
          $code[null]= Yii::t('app','-- Select --');
          
          $contact=null;
          
		 if(isset(Yii::app()->user->userid))
           $userid = Yii::app()->user->userid;
                            
           $contact_ID=ContactInfo::model()->getIdContactByUserID($userid);
	       $contact_ID= $contact_ID->getData();
					                    
			     foreach($contact_ID as $c)
					{  $contact= $c->id;
                       break;					
					}
			
			if($contact!=null)       
              {
                  $modelPerson= new Persons();
					   
					  $person=$modelPerson->findAll(array('alias'=>'p',
					                             'select'=>'p.id,p.first_name, p.last_name',
					                             'join'=>'left join contact_info c on(c.person=p.id)',
												 'condition'=>'p.is_student=1 AND p.active IN(1,2) AND (c.id=:contact OR c.one_more=:contact)',
												 'params'=>array(':contact'=>$contact),
										   ));
						
						 if(isset($person)){
						     foreach($person as $child)
							    $code[$child->id]= $child->first_name.' '.$child->last_name;
						   }	   
                }
                
		   
		return $code;
		
         
	}


	public function getUserInfo()
	  {
	  	 $userid =null;
	  	 
	  	if(isset(Yii::app()->user->userid))
          {
               $userid = Yii::app()->user->userid;
           
           }
           
           
           $this->_model=User::model()->findbyPk($userid);
	  	
	  	return $this->_model;
	  	
	  	
	  	}



	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Schedules::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}
	
	
	
	
	
	//************************  academic year ******************************
	public function loadAcademicPeriod()
	{    $modelAcademicP = new AcademicPeriods;
           $code= array();
		  //we will set it at the current academic period for this version, and later set it to have past academic period too
		  
		  /*$report = new ReportCard;
			$academic=$report->searchCurrentAcademicPeriod(date('Y-m-d'));
			$code[null]= null;
		    if(isset($academic))
			 {  $code[$academic->id]= $academic->name_period;
		       
			 }
			 
			 
			 $acad=Yii::app()->session['currentId_academic_year']; 
			$acad_name=Yii::app()->session['currentName_academic_year']; 

			$code[$acad]= $acad_name;
		  */
		  $modelAcadP=$modelAcademicP->findAll(array('select'=>'id,name_period',
                                     'condition'=>'is_year=1 ', 'order'=>'name_period ASC',));
            $code[null]= null;
		    if(isset($modelAcadP))
			 {  
			     foreach($modelAcadP as $acad){
			        $code[$acad->id]= $acad->name_period;
		           
		           }
			 }
		    
			
				
			
			
		return $code;
         
	}
	
	//************************  loadCourseByRoomId ******************************
	public function loadCourseByRoomId($room_id)
	{    $modelCourse= new Courses();
           $code= array();
		   
		    $c=$modelCourse->searchCourseByRoomId($room_id);
            $courses=$c->getData();
			//$code[null]= null;
			
		    if(isset($courses))
			 {  
			    foreach($courses as $course){
			        $code[$course->id]= $course->subject_name.'('.$course->teacher_name.')';
		           
		           }
			 }
		   
		return $code;
         
	}
	
	
	//************************  loadRoomByAcademicYear ******************************
	public function loadRoomByAcademicYear($academicY)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $rooms=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'r.id,r.room_name',
                                     'join'=>'left join courses c on(c.room=r.id)',
									 'condition'=>'c.academic_period=:acad',
                                     'params'=>array(':acad'=>$academicY,),
									 'order'=>'room_name ASC',
                               ));
            $code[null]= null;
		    if(isset($rooms))
			 {  
			    foreach($rooms as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	//************************  getCoursesAndTimes($this->room_id, $idAcad) ******************************
	public function getCoursesAndTimes($room_id,$idAcad)
	{
	    /* $result= array();
		 
		  $times=Schedules::model()->searchCoursesAndTimes($room_id);
		  
		   
	      if(isset($times))
			 {  
			    /*$hres=$times->getData();//return a list of  objects
				$i=-1;
			    foreach($hres as $hre){
			        $i++;
					$result[$i]= $hre;
		             
		           }
			 */
		//  return $times;//result;
	    //   }
		 //else
		  //   return null;
		  
		  
		  
		   
		  $times=Schedules::model()->findAll(array('alias'=>'s',
									'select'=>'s.id, s.course, s.day_course, s.time_start, s.time_end',
									 'join' => 'left join courses c on (s.course=c.id)',
                                     'condition'=>'c.room=:Id AND c.academic_period=:idAcad',
                                     'params'=>array(':Id'=>$room_id, ':idAcad'=>$idAcad),
									 'order' => 's.time_start ASC',
                               ));
            
		    if(isset($times))
			 {  
			    return $times;
		      
			 }
		     else
			   return null;
		  
			 
	}
	
	//************************  getTimesForSpecificDay($this->room_id, day, $idAcad) ******************************
	public function getTimesForSpecificDay($room_id, $day, $idAcad)
	{
		  $times=Schedules::model()->searchTimesForSpecificDay($room_id, $day, $idAcad);
		  
		   
	      if(isset($times))
			 return $times;
	      else
		     return null;
	}
	
	//************************  getTimes($this->room_id, $idAcad) ******************************
	public function getTimes($room_id, $idAcad)
	{
		  $times=Schedules::model()->searchTimes($room_id, $idAcad);
		  
		   
	      if(isset($times))
			 return $times;
	      else
		     return null;
	}
	
	 // return the subject name of a course with a specific idCourse 
        public function getSubjectName($id){
		     
		     $subject=Courses::model()->getSubjectName($id);
			 
			 return $subject->getData();
		}
	
public function currentAcademicPeriod($currentDate,$room_id)
	  {    $report= new ReportCard;
	        $result=$report->currentAcademicPeriod($currentDate,$room_id);
                if($result!=null)
                    return $result->name_period;
                    else
                        return null;
	  }
	
	
	public function getAcademicPeriodeName($id)
	  {    $acad = new AcademicPeriods;
	        $result=$acad->getAcademicPeriodNameById($id);
                if($result!=null)
                    return $result->name_period;
                    else
                        return null;
	  }
	
	
 //************************  getRoom($id) ******************************
   public function getRoom($id)
	{
		$room = new Rooms;
		
		$room=Rooms::model()->findByPk($id);
        
			
		//echo $id." --- ".$room->room_name;
		    if(isset($room))
				return $room->room_name;
		
	}

//************************  getSection($id) ******************************
   public function getSection($id)
	{
		//$section = new Sections;
		$section=Sections::model()->findByPk($id);
        
			
		       if(isset($section))
				return $section->section_name;
		
	}

//************************  getShift($id) ******************************
   public function getShift($id)
	{
		//$shift = new Shifts;
		$shift=Shifts::model()->findByPk($id);
        
			
		      if(isset($shift))
				return $shift->shift_name;
		
	}

 //************************  getLevel($id) ******************************
   public function getLevel($id)
	{
		$level = new Levels;
		$level=Levels::model()->findByPk($id);
        
			
		    if(isset($level))
				return $level->level_name;
		
	}

//************************  loadShift ******************************
	public function loadShift()
	{    $modelShift= new Shifts();
           $code= array();
		   
		  $modelPersonShift=$modelShift->findAll();
            $code[null]= null;
		    foreach($modelPersonShift as $shift){
			    $code[$shift->id]= $shift->shift_name;
		           
		      }
		   
		return $code;
         
	}

//************************  loadSection ******************************
	public function loadSection()
	{    $modelSection= new Sections();
           $code= array();
		   
		  $modelPersonSection=$modelSection->findAll();
            $code[null]= null;
		    if(isset($modelPersonSection))
			 {  foreach($modelPersonSection as $section){
			        $code[$section->id]= $section->section_name;
		           
		           }
			 }
		   
		return $code;
         
	}

	//************************  loadLevel ******************************
	public function loadLevel()
	{    $modelLevel= new Levels();
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll();
            $code[null]= null;
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}

//************************  loadRoom ******************************
	public function loadRoom()
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll();
            $code[null]= null;
		    if(isset($modelPersonRoom))
			 {  foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}

	//************************  loadSectionByIdShift ******************************
	public function loadSectionByIdShift($idShift)
	{     
	      $code= array();
          $code[null]= null;
	      $modelRoom= new Rooms();
	      $section_id=$modelRoom->findAll(array('select'=>'section',
                                     'condition'=>'shift=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift),
                               ));
			if(isset($section_id))
			 {  
			    foreach($section_id as $i){			   
					  $modelSection= new Sections();
					   
					  $section=$modelSection->findAll(array('select'=>'id,section_name',
												 'condition'=>'id=:sectionID',
												 'params'=>array(':sectionID'=>$i->section),
										   ));
						
						 if(isset($section)){
						     foreach($section as $s)
							    $code[$s->id]= $s->section_name;
						   }	   
							   }						 }
		   
		return $code;
		$this->section_id=null;
         
	}
	

public function loadLevelByIdShiftSectionIdAcademicP($idShift,$section_id,$idAcademicP)
	{    
       	  $code= array();
          $code[null]= null;
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('select'=>'l.id,l.level_name','alias'=>'r',
		                             'join'=>'left join room_has_person rh on (rh.room=r.id) left join levels l on(l.id = r.level)',
                                     'condition'=>'shift=:shiftID AND section=:sectionID AND rh.academic_year=:academic_year',
                                     'params'=>array(':shiftID'=>$idShift, ':sectionID'=>$section_id,':academic_year'=>$idAcademicP),
									  'order'=>'l.level_name ASC',
                               ));
			if(isset($level_id))
			 {  
			    foreach($level_id as $i){			   
					  //$modelLevel= new Levels();
					   
					  //$level=$modelLevel->findAll(array('select'=>'id,level_name',
						//						 'condition'=>'id=:levelID',
						//						 'params'=>array(':levelID'=>$i->level),
												
						//				   ));
						
					 //if(isset($level)){
						 // foreach($level as $l)
						       $code[$i->id]= $i->level_name;
					    //}  
							   }						 
		    
						  }	
			
		return $code;
         
	}
	
	
//************************  loadRoomByIdShiftSectionLevel ******************************
	public function loadRoomByIdShiftSectionLevel($shift,$section,$idLevel)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('select'=>'id,room_name',
                                     'condition'=>'shift=:idShift AND section=:idSection AND level=:levelID ',
                                     'params'=>array(':idShift'=>$shift,':idSection'=>$section,':levelID'=>$idLevel),
                               ));
            $code[null]= null;
		    if(isset($modelPersonRoom))
			 {  
			    foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
		
	
	
			//************************  getLevelByRoomId  ******************************
	public function getLevelByRoomId($room_id,$idSection)
	{    
       	  
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('select'=>'level',
                                     'condition'=>'id=:roomID AND section=:sectionID',
                                     'params'=>array(':roomID'=>$room_id, ':sectionID'=>$idSection),
                               ));
			if(isset($level_id))
			 {  
			    foreach($level_id as $i){			   
					  $modelLevel= new Levels();
					   
					  $level=$modelLevel->findAll(array('select'=>'id,level_name',
												 'condition'=>'id=:levelID',
												 'params'=>array(':levelID'=>$i->level),
										   ));
						
					 if(isset($level)){
						  foreach($level as $l)
						  {   
						       return $l->level_name;
							}
					    
						
						}  
							   }
                							   
		    
						  }	
			
		//return $code;
         
	}
	
	
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='schedules-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	// Behavior the create Export to CSV 
	public function behaviors() {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','Schedules-View-For Teacher.csv'),
	            'csvDelimiter' => ',',
	            ));
	}
	
	
}
