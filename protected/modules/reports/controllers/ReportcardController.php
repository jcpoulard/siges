<?php
 /*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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




// always load alternative config file for examples
//require_once('/../extensions/tcpdf/config/tcpdf_config.php');
// Include the main TCPDF library (search for installation path).
//require_once('/../extensions/tcpdf/tcpdf.php');

Yii::import('ext.tcpdf.*');
 


class ReportcardController extends Controller
{
	
	
	
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	
	
	//generale report - class average
	public $class_average;
	public $progress_student_class;
	public $progress_subject_period;
	public $repartition_grade_subject;
	public $course_id_rpt;
	public $room_id_subject_period;
	public $room_id_student_class;
	public $course_id_grade_subject;
	public $room_id_grade_subject;
	public $eval_id_grade_subject;
	
	public $eval_id_class_average;
	public $shift_id_rpt;
	public $section_id_rpt;
		
	
	public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	
	public $temoin_update=0;
	public $temoin_list;
	public $old;
	
	public $student_id;
	public $course_id;
	public $evaluation_id;
	public $evaluationDate;
        public $tot_stud;
        
    public $reportcard_category_id =2; //tous les bulletins
		
   	/** public variable for Discipline Report **/
        public $room_dis; 
        public $period_dis;
        
  
	public $total_admit; //end year decision
	public $total_fail; //end year decision
	public $comment= array(); //end year decision
	public $comment2= array(); //end year decision, failed stud
	public $data_EYD; //end year decision
	public $data_EYD2; //end year decision, failed stud
	public $data_EYD3;
	public $t_comment; //end year decision
	public $t_comment2; //end year decision, failed stud
	public $messageDecisionDone=false; //end year decision
	public $lastReportcardNotSet=false;//end year decision
	public $messageNoCheck=0; //end year decision
	public $messageNoStud=false; //end year decision
	public $messageNoPassingGradeSet=false; //end year decision
	public $isCheck=0; //end year decision
	public $isCheck2=0; //end year decision, failed stud
	
	
	public $messageEvaluationNotSet=false;//P. A
	public $messageNoStudChecked=false;//P. A
	public $messageWrongPeriodChoosen=false;//P. A
	
	
	public $summary=false;
	
	public $final_period=false;
	
	public $extern=false;
	
	public $nb_subject= array();
	
	public $rpt_section_id;
	
	public $message=false;
	
	public $messageView=false; 
	
	public $success=false; 
	
	public $allowLink=false;
	
	public $messageEvaluation_id=false;
	
	public $messageEvaluation_id_admit=false;
        
        public $noStud = 0;
	
	public $pathLink="";
	
		    
	
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	public function accessRules()
	{
		    
		  $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
            $controller=$explode_url[3];
           
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


      /**
         * Rapport sur la discipline 
         * 
         */
        public function actionDisciplineReport(){
            $discipline = new RecordPresence; 
            $academicPeriod = new AcademicPeriods;
            $infraction = new RecordInfraction;
            
            if(isset($_POST['AcademicPeriods']['name_period'])){
                $this->period_dis = $_POST['AcademicPeriods']['name_period']; 
            }
            
            if(isset($_POST['RecordPresence']['room_attendance'])){
                $this->room_dis = $_POST['RecordPresence']['room_attendance']; 
            }
            
            $this->render('disciplineReport',array(
                'model'=>$discipline,
                'model2'=>$academicPeriod,
                'infraction'=>$infraction,
            ));
        }


public function actionYearMigrationCheck()
{
	$acad_sess = acad_sess();
    $acad=Yii::app()->session['currentId_academic_year']; 
  $siges_structure = infoGeneralConfig('siges_structure_session');

$previous_acad_sess=0;
if($siges_structure==1)//previous
    $previous_acad_sess= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
    
  
    $currency_symbol = Yii::app()->session['currencySymbol'];
    $currency_name = Yii::app()->session['currencyName'];

     $model=new YearMigrationCheck;
     
     
     //load model ki konsene ane akademik sa
       if($siges_structure==0)
            $model_YearMigrationCheck = YearMigrationCheck::model()->findByAttributes(array('academic_year'=>$acad_sess));
       elseif($siges_structure==1)//previous
           $model_YearMigrationCheck = YearMigrationCheck::model()->findByAttributes(array('academic_year'=>$previous_acad_sess));
        
        
        if(isset($_POST['create']))
	     {
	     	
	     	             //_________________________________  period ___________________________//
	     	               //add period for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->period==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
	     	               	//load tout period ane pase yo
	     	               	 $command1_= Yii::app()->db->createCommand('SELECT name_period,weight,checked,date_start,date_end FROM academicperiods where is_year=0 and year='.$previous_year ); 
	
	                           $data_1 = $command1_->queryAll();
    
							try {
								      $pass=1;
								      $one_save_record=0;
								      
								 if(($data_1!=null))
								  {    
								    foreach($data_1 as $d)
								     {
						    	         $model1=new AcademicPeriods;
									      $model1->setAttribute('name_period',$d['name_period']);
									      $model1->setAttribute('weight',$d['weight']);
									      $model1->setAttribute('checked',$d['checked']);
									      $model1->setAttribute('is_year',0);
									      $model1->setAttribute('previous_academic_year',0);
									      $model1->setAttribute('date_start',date("Y-m-d", strtotime($d['date_start']." + 1 year")));
									      $model1->setAttribute('date_end',date("Y-m-d", strtotime($d['date_end']." + 1 year")));
									      $model1->setAttribute('year',$acad_sess);
									      $model1->setAttribute('date_created',date('Y-m-d'));
					                      $model1->setAttribute('create_by','SIGES');
									      
									      
									     if($model1->save())
									     {
									     	$one_save_record=1;
									     }
									   else
									     $pass=0;
									     
								     
								     }
								     
								  }
								     
								     if(($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								      else
								        $transaction ->rollback();
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	   $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'period'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	} 
		                      	
                            }
                            
                        }    
	     	         
	     	         

                       //_________________________________ postulant ___________________________//  session too
	     	               //add postulant for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->postulant==0)
                          {   
	     	               	$automatic_code = infoGeneralConfig('automatic_code');
	     	               	
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
	     	               	
	     	                $command8_= Yii::app()->db->createCommand('SELECT id, first_name, last_name, gender,blood_group,birthday,cities,phone,adresse,health_state,person_liable,person_liable_phone,person_liable_adresse,person_liable_relation,apply_for_level,previous_level,previous_school,school_date_entry FROM postulant where status=1 and academic_year='.$previous_year ); 
	
	                           $data_8 = $command8_->queryAll();
	                           
	                         
	                         try {
								      $pass=1;
								      $one_save_record=0;
								 
								 if(($data_8!=null))
								  {   
								    foreach($data_8 as $d)
								     {
								     	$object_id= $d['id'];
								     	
						    	         $model1=new Persons;
									      $model1->setAttribute('first_name',$d['first_name']);
									      $model1->setAttribute('last_name',$d['last_name']);
									      $model1->setAttribute('gender',$d['gender']);
									      $model1->setAttribute('blood_group',$d['blood_group']);
									      $model1->setAttribute('birthday',$d['birthday']);
									      $model1->setAttribute('is_student',1);
									      $model1->setAttribute('adresse',$d['adresse']);
									      $model1->setAttribute('phone',$d['phone']);
									      $model1->setAttribute('cities',$d['cities']);
									      $model1->setAttribute('active',2);
									      $model1->setAttribute('date_created',date('Y-m-d'));
					                      $model1->setAttribute('create_by','SIGES');
									      
									      
									     if($model1->save())
									     {
									     	$one_save_record=1;
								     		//update id postulan nan tab reservation an avan delete
								     		$command_11 = Yii::app()->db->createCommand();
								                 $command_11->update('reservation', array('postulant_student'=>$model1->id, 'is_student'=>1 ), 'postulant_student=:ID', array(':ID'=>$d['id'],));
								     		
								     		
								     		//delete postulan sa nan tab postulan
								     		$modelPostulant = Postulant::model()->findByPk($d['id'])->delete();
								     		//$modelPostulant->delete();
								     		
								     		
									     	//code automatic
										     if($automatic_code ==1)
											   { $cf='';
										         $cl='';
												 
					                               //first_name							
												$explode_firstname=explode(" ",substr($model1->first_name,0));
					            
									            if(isset($explode_firstname[1])&&($explode_firstname[1]!=''))
												 { 
											        $cf = strtoupper(  substr(strtr($explode_firstname[0],pa_daksan() ), 0,1).substr(strtr($explode_firstname[1],pa_daksan() ), 0,1)  );
												   
												 }
												else
												 {  $cf = strtoupper( substr(strtr($explode_firstname[0],pa_daksan() ), 0,2)  );
											    
												 }
					
												 //last_name							
												$explode_lastname=explode(" ",substr($model1->last_name,0));
					            
									            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
												 { 
											        $cl = strtoupper(  substr(strtr($explode_lastname[0],pa_daksan() ), 0,1).substr(strtr($explode_lastname[1],pa_daksan() ), 0,1) );
												   
												 }
												else
												 {  $cl = strtoupper( substr(strtr( $explode_lastname[0],pa_daksan() ), 0,2)  );
											    
												 }
												 
												  $code_ = $cf.$cl.$model1->id;
												
												  
												  $command = Yii::app()->db->createCommand();
						                          $command->update('persons', array( 'id_number'=>$code_ ), 'id=:ID', array(':ID'=>$model1->id));
								  	
					
											   }
											   
											   
											   //champs personalisables (custom_field_data)
											   //update object_id 
											   
											    $command11 = Yii::app()->db->createCommand();
						                          $command11->update('custom_field_data', array( 'object_id'=>$model1->id ), 'object_id=:ID', array(':ID'=>$object_id));
						                       
						                       //setup user
							                       
							                        $group=Groups::model()->getGroupIdByName("Student");
												   	  $group=$group->getData();
												   	  if(isset($group)&&($group!=''))
												   	     {  foreach($group as $g)
												   	            {
												   	            	$group_id=$g->id;
												   	            	}
												   	     	
												   	     	}
												   	     	
												   	   $profil=Profil::model()->getProfilIdByName("Guest");
												   	  $profil=$profil->getData();
												   	  if(isset($profil)&&($profil!=''))
												   	     {  foreach($profil as $prof)
												   	            {
												   	            	$profil_id=$prof->id;
												   	            	}
												   	     	
												   	     	}
                            	                                
                            	                                
                            	                     $explode_lastname=explode(" ",substr($model1->last_name,0));
            
										            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
										              $username= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname[1]), pa_daksan() ).$model1->id;
										            else
										              $username= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).$model1->id;
						                            
						                            $full_name = ucwords($model1->first_name.' '.$model1->last_name);
						                            $create_by = 'SIGES';
						                            $password = md5("password");
						                            
						                            $command12 = Yii::app()->db->createCommand();
												    $command12->insert('users', array(
													  'username'=>$username,
													  'password'=>$password,
													  'full_name'=>$full_name,
													  'active'=>1,
													  'person_id'=>$model1->id,
													  'profil'=>$profil_id,
													  'group_id'=>$group_id,
													  'is_parent'=>0,
													  'create_by'=>$create_by,
													  'date_created'=>date('Y-m-d'),
													  
															));           
                            	                                
                            	                    $pers=$model1->id;
							                    $model1->unSetAttributes();            
                            	                                
                            	                                
                            	              //level entry
                            	              		
						                      $modelLevel = new LevelHasPerson;
						                      
						                      $modelLevel->setAttribute('level',$d['apply_for_level']);
						                      $modelLevel->setAttribute('students',$pers);
						                      $modelLevel->setAttribute('academic_year',$acad_sess);
											  $modelLevel->setAttribute('date_created',date('Y-m-d'));
											  $modelLevel->setAttribute('create_by','SIGES');
													  
												  
												if($modelLevel->save())
                                                 {
                                                 	$modelStudentOtherInfo = new StudentOtherInfo;
                                                 	
                                                 	$modelStudentOtherInfo->setAttribute('student',$pers);
													$modelStudentOtherInfo->setAttribute('school_date_entry',$d['school_date_entry']);
													$modelStudentOtherInfo->setAttribute('previous_school',$d['previous_school']);
													$modelStudentOtherInfo->setAttribute('previous_level',$d['previous_level']);
													$modelStudentOtherInfo->setAttribute('apply_for_level',$d['apply_for_level']);
													$modelStudentOtherInfo->setAttribute('health_state',$d['health_state']); 
													$modelStudentOtherInfo->setAttribute('person_liable',$d['person_liable']); 
													$modelStudentOtherInfo->setAttribute('person_liable_phone',$d['person_liable_phone']);
													$modelStudentOtherInfo->setAttribute('date_created',date('Y-m-d'));
											        $modelStudentOtherInfo->setAttribute('create_by','SIGES');
													
													
													if($modelStudentOtherInfo->save())
													 {
													 	$modelContactInfo = new ContactInfo;
                                                 	
	                                                 	$modelContactInfo->setAttribute('person',$pers);
														$modelContactInfo->setAttribute('contact_name',$d['person_liable']);
														$modelContactInfo->setAttribute('contact_relationship',$d['person_liable_relation']);
														$modelContactInfo->setAttribute('phone',$d['person_liable_phone']);
														$modelContactInfo->setAttribute('address',$d['person_liable_adresse']);
														$modelContactInfo->setAttribute('date_created',date('Y-m-d'));
												        $modelContactInfo->setAttribute('create_by','SIGES');
														
														
														$modelContactInfo->save();
													
													 	}
													else
                                                      $pass=0;

                                                 	
                                                 	
                                                 	
                                                 	}
                                                else
                                                   $pass=0;
   
						                         
											    
									     }
									   else
									     $pass=0;
									     
								     
								     }
								     
								  }  
	                           
	                           									
                             if( ($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								      else
								         $transaction ->rollback();
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	   if($siges_structure==1)//previous
		                      	     $acad_sess = $previous_acad_sess;
		                      	     
		                      	     $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'postulant'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	}
									
									
						     	               	
	     	               	
                          }
                          
                          
                     }
	     	            	

                       //_________________________________  student ___________________________//  session too
	     	               //add student for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->student==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
	     	               	

						          	 //applying end_year_decision by moving students to level up ...
						            
							        $command7= Yii::app()->db->createCommand(
												"SELECT student, is_move_to_next_year, current_level, next_level FROM decision_finale WHERE academic_year=".$previous_year.' AND checked=0');
												//$command7->bindValue(':acad',$previous_year);//;
												$data_7 = $command7->queryAll();
							try {
								    $pass=1;
								    $one_save_record=0;
								      
								if(($data_7!=null))
								  {   
								    foreach($data_7 as $line)
									  { 
									     if($line['is_move_to_next_year']==1)
										   {  if($line['next_level']!=null)
										        {
										        	
											   	   //gad si moun sa t gentan nan klas pou ane sa
											/*	 $command_7= Yii::app()->db->createCommand(
												"SELECT  id, students FROM level_has_person WHERE students=:stud AND academic_year=:acad");
												 $command_7->bindValue(':stud',$line['student']);
												 $command_7->bindValue(':acad',$acad_sess);
												 $result_ = $command_7->queryAll();
												*/
											$modelLevel=LevelHasPerson::model()->find('students=:IdStudent AND academic_year=:acad',array(':IdStudent'=>$line['student'],':acad'=>$acad_sess));	 
											
												 if(isset($modelLevel)&&($modelLevel!=null))
								                   {   
								                     //li pa ka update, delete li kreye yon nouvo
								                              
								                              $date_created =$modelLevel->date_created ;
								                              $create_by =$modelLevel->create_by;
								                              $modelLevel_= LevelHasPerson::model()->findbyPk($modelLevel->id);
								                           //   Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.').'<br/>'.Yii::t('app','You can download all reportcards at once by using the appropriate button below.').$modelLevel->id);
								                              if(! $modelLevel_->delete() )
								                                print_r($modelLevel_->getErrors());
								                                
								                              $modelLevel_->level= $line['next_level'];
								                              $modelLevel_->date_updated=date('Y-m-d');
								                              $modelLevel_->update_by= Yii::app()->user->name;
								                              
																$modelLevel_->update(array('level','date_updated','update_by',));

								                            /*  
								                              $modLevel= new LevelHasPerson;//::model()->findbyPk($modelLevel->id);
						      
								                              $modLevel->setAttribute('level', $line['next_level']);
								                              $modLevel->setAttribute('students', $line['student']);
								                              $modLevel->setAttribute('academic_year', $acad_sess);
								                              $modLevel->setAttribute('date_created', $date_created );
								                              $modLevel->setAttribute('create_by', $create_by);
								                              $modLevel->setAttribute('date_updated', date('Y-m-d') );
								                              $modLevel->setAttribute('update_by', Yii::app()->user->name);
								                             
								                              if( $modLevel->save() )
								                                 Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.').'<br/>'.Yii::t('app','You can download all reportcards at once by using the appropriate button below.').$modLevel->id);
								                                
								                             */	
															//update decision_finale li
															$decision = Yii::app()->db->createCommand();
												            $decision->update('decision_finale', array('checked'=>1,), 'student=:ID AND academic_year=:acad', array(':ID'=>$line['student'],':acad'=>$previous_year));
														$command_decision->execute();
		//print_r('<br/><br/><br/>*************************************************'.$modelLevel_person->level.'************'.$ok['id'].'************'.$line['student'].'******'.$acad_sess.'********'.$line['next_level']);														
								                        //  }
								                         //else
								                            // $pass=0;
								                     //}
								                   }
								                 else
								                   {
											   	     
											   	     //add new record in LevelHasPerson
												          $modelSuccess=new LevelHasPerson;
													      $modelSuccess->setAttribute('level',$line['next_level']);
													      $modelSuccess->setAttribute('students',$line['student']);
													      $modelSuccess->setAttribute('academic_year',$acad_sess);
													      $modelSuccess->setAttribute('date_created',date('Y-m-d'));
									                      $modelSuccess->setAttribute('create_by','SIGES');											         
												        														
						 					         
											         if($modelSuccess->save())
													     {
													     	$one_save_record=1;
													     	
													     	//all persons with status=1 will have status=2
													         $command_person = Yii::app()->db->createCommand();
										                     $command_person->update('persons', array(
																		'active'=>1,'update_by'=>Yii::app()->user->name
																), 'id=:ID', array(':ID'=>$line['student']));
																
														    //update decision_finale li
															$command_decision = Yii::app()->db->createCommand();
												                     $command_decision->update('decision_finale', array(
																				'checked'=>1,
																			), 'student=:ID AND academic_year=:acad', array(':ID'=>$line['student'],':acad'=>$previous_year));
																			
													     }
													   else
													     $pass=0;

								                   }
								                   
										         }
																						
										      }
											 elseif($line['is_move_to_next_year']==0)
										        { 
										   
										          if($line['next_level']!=null)
												    {
														 //gad si moun sa t gentan nan klas pou ane sa
											/*	 $command_7= Yii::app()->db->createCommand(
												"SELECT  id, students FROM level_has_person WHERE students=:stud AND academic_year=:acad");
												 $command_7->bindValue(':stud',$line['student']);
												 $command_7->bindValue(':acad',$acad_sess);
												 $result_ = $command_7->queryAll();
												*/
											$modelLevel=LevelHasPerson::model()->find('students=:IdStudent AND academic_year=:acad',array(':IdStudent'=>$line['student'],':acad'=>$acad_sess));	 
											
												 if(isset($modelLevel)&&($modelLevel!=null))
								                   {   
								                     //li pa ka update, delete li kreye yon nouvo
								                              
								                              $date_created =$modelLevel->date_created ;
								                              $create_by =$modelLevel->create_by;
								                              $modelLevel_= LevelHasPerson::model()->findbyPk($modelLevel->id);
								                           //   Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.').'<br/>'.Yii::t('app','You can download all reportcards at once by using the appropriate button below.').$modelLevel->id);
								                             // if(! $modelLevel_->delete() )
								                              //  print_r($modelLevel_->getErrors());
								                                
								                               $modelLevel_->level= $line['next_level'];
								                              $modelLevel_->date_updated=date('Y-m-d');
								                              $modelLevel_->update_by= Yii::app()->user->name;
								                              
																$modelLevel_->update(array('level','date_updated','update_by',)); 
								                             
								                     /*         $modLevel= new LevelHasPerson;//::model()->findbyPk($modelLevel->id);
						      
								                              $modLevel->setAttribute('level', $line['next_level']);
								                              $modLevel->setAttribute('students', $line['student']);
								                              $modLevel->setAttribute('academic_year', $acad_sess);
								                              $modLevel->setAttribute('date_created', $date_created );
								                              $modLevel->setAttribute('create_by', $create_by);
								                              $modLevel->setAttribute('date_updated', date('Y-m-d') );
								                              $modLevel->setAttribute('update_by', Yii::app()->user->name);
								                          */   
								                             // if( $modLevel->save() )
								                               //  Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.').'<br/>'.Yii::t('app','You can download all reportcards at once by using the appropriate button below.').$modLevel->id);
								                                
																
																//$sql = "UPDATE level_has_person SET level = :level  WHERE id = :id";

//$command333 = Yii::app()->db->createCommand($sql);
//$command333->execute(array(':level'=>$line['next_level'], ':id' => $ok['id']));

//print_r('<br/><br/><br/>*************************************************************************'.$line['student'].'******'.$acad_sess.'********'.$line['next_level']);																
																//update decision_finale li
															$command_decision = Yii::app()->db->createCommand();
												                     $command_decision->update('decision_finale', array(
																				'checked'=>1,
																			), array('and','student=:ID', 'academic_year=:acad'), array(':ID'=>$line['student'],':acad'=>$previous_year));
																
								                         
								                   }
								                 else
								                   {
   	 //add new record in LevelHasPerson
													         $modelFail=new LevelHasPerson;
														      $modelFail->setAttribute('level',$line['next_level']);
														      $modelFail->setAttribute('students',$line['student']);
														      $modelFail->setAttribute('academic_year',$acad_sess);
														      $modelFail->setAttribute('date_created',date('Y-m-d'));
										                      $modelFail->setAttribute('create_by','SIGES');											         
													        
															
														    
															  if($modelFail->save())
															     {
															     	$one_save_record=1;
															     	
															     	//all persons with status=1 will have status=2
															         $command_person1 = Yii::app()->db->createCommand();
												                     $command_person1->update('persons', array(
																				'active'=>1,'update_by'=>Yii::app()->user->name
																			), 'id=:ID', array(':ID'=>$line['student']));
																			
																	//update decision_finale li
															$command_decision = Yii::app()->db->createCommand();
												                     $command_decision->update('decision_finale', array(
																				'checked'=>1,
																			), 'student=:ID AND academic_year=:acad', array(':ID'=>$line['student'],':acad'=>$previous_year));
																					
															     }
															   else
															     $pass=0;
															     
								                     }
								                   
													     
												    }
			 
											      }
										   
										  									     									     
									     
									     										   
									    }
								  
								       }
									
									
									 if( ($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								       else
								          $transaction ->rollback();
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	  if($siges_structure==1)//previous
		                      	     $acad_sess = $previous_acad_sess;
		                      	  
		                      	   $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'student'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	}
									
								
	     	               	
                          }
                          
                      }
                      
                      
                      
                      
                      
                      
                      
                      //_________________________________  course ___________________________//
	     	               //add course for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->course==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
	     	               	//load tout period ane pase yo
	     	               	 $command6_= Yii::app()->db->createCommand('SELECT subject,teacher,room,weight,debase,optional FROM courses where old_new=1 and academic_period='.$previous_year ); 
	
	                           $data_6 = $command6_->queryAll();
    
							try {
								      $pass=1;
								      $one_save_record=0;
								      
								  if(($data_6!=null))
								  {   
								    foreach($data_6 as $d)
								     {
						    	         $model1=new Courses;
									      $model1->setAttribute('subject',$d['subject']);
									      $model1->setAttribute('teacher',$d['teacher']);
									      $model1->setAttribute('room',$d['room']);
									      $model1->setAttribute('weight',$d['weight']);
									      $model1->setAttribute('debase',$d['debase']);
									      $model1->setAttribute('optional',$d['optional']);
									      $model1->setAttribute('old_new',1);
									      $model1->setAttribute('academic_period',$acad_sess);
									      $model1->setAttribute('date_created',date('Y-m-d'));
					                      $model1->setAttribute('create_by','SIGES');
									      
									      
									     if($model1->save())
									     {
									     	$one_save_record=1;
									     }
									   else
									     $pass=0;
									     
								     
								     }
								     
								  }
								  
								     if( ($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								       else
								         $transaction ->rollback(); 
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	   $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'course'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	} 
		                      	
                            }
                            
                        }    
	     	         


                      //_________________________________  evaluation ___________________________//
	     	               //add evaluation for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->evaluation==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad);
	     	               	//load tout period ane pase yo
	     	               	 $command5_= Yii::app()->db->createCommand('SELECT evaluation_name,weight FROM evaluations where academic_year='.$previous_year ); 
	
	                           $data_5 = $command5_->queryAll();
    
							try {
								      $pass=1;
								      $one_save_record=0;
								      
								 if(($data_5!=null))
								  {   
								     foreach($data_5 as $d)
								     {
						    	         $model1=new Evaluations;
									      $model1->setAttribute('evaluation_name',$d['evaluation_name']);
									      $model1->setAttribute('weight',$d['weight']);
									      $model1->setAttribute('academic_year',$acad);
									      $model1->setAttribute('date_created',date('Y-m-d'));
					                      $model1->setAttribute('create_by','SIGES');
									      
									      
									     if($model1->save())
									     {
									     	$one_save_record=1;
									     }
									   else
									     $pass=0;
									     
								     
								     }
								     
								  }
								     if( ($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								       else
								          $transaction ->rollback();
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	   $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'evaluation'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	} 
		                      	
                            }
                            
                        }    
	     	         

 

                      //_________________________________  passing_grade ___________________________//  session too
	     	               //add passing_grade for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->passing_grade==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	if($siges_structure==1)//previous
	     	               	    $acad = $acad_sess;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad);
	     	               	//load tout period ane pase yo
	     	               	 $command4_= Yii::app()->db->createCommand('SELECT level,course,minimum_passing,level_or_course FROM passing_grades where academic_period='.$previous_year ); 
	
	                           $data_4 = $command4_->queryAll();
    
							try {
								      $pass=1;
								      $one_save_record=0;
								      
								 if(($data_4!=null))
								  {   
								      foreach($data_4 as $d)
								     {
						    	         $model1=new PassingGrades;
									      $model1->setAttribute('level',$d['level']);
									      $model1->setAttribute('course',$d['course']);
									      $model1->setAttribute('minimum_passing',$d['minimum_passing']);
									      $model1->setAttribute('level_or_course',$d['level_or_course']);
									      $model1->setAttribute('academic_period',$acad);
									      $model1->setAttribute('date_created',date('Y-m-d'));
					                      $model1->setAttribute('create_by','SIGES');
									      
									      
									     if($model1->save())
									     {
									     	$one_save_record=1;
									     }
									   else
									     $pass=0;
									     
								     
								     }
								     
								  }
								     
								     if( ($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								      else
								        $transaction ->rollback();
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	  if($siges_structure==1)//previous
		                      	     $acad_sess = $previous_acad_sess;
		                      	     
		                      	      $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'passing_grade'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	} 
		                      	
                            }
                            
                        }    
	     	         

 

                      //_________________________________  reportcard_observation ___________________________//  session too
	     	               //add reportcard_observation for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->reportcard_observation==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	if($siges_structure==1)//previous
	     	               	   $acad = $acad_sess;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad);
	     	               	//load tout period ane pase yo
	     	               	 $command3_= Yii::app()->db->createCommand('SELECT section,start_range,end_range, comment FROM reportcard_observation where academic_year='.$previous_year ); 
	
	                           $data_3 = $command3_->queryAll();
    
							try {
								      $pass=1;
								      $one_save_record=0;
								      
								 if(($data_3!=null))
								  {   
								    foreach($data_3 as $d)
								     {
						    	         $model1=new ReportcardObservation;
									      $model1->setAttribute('section',$d['section']);
									      $model1->setAttribute('start_range',$d['start_range']);
									      $model1->setAttribute('end_range',$d['end_range']);
									      $model1->setAttribute('comment',$d['comment']);
									      $model1->setAttribute('academic_year',$acad_sess);
									      $model1->setAttribute('create_date',date('Y-m-d'));
					                      $model1->setAttribute('create_by','SIGES');
									      
									      
									     if($model1->save())
									     {
									     	$one_save_record=1;
									     }
									   else
									     $pass=0;
									     
								     
								     }
								     
								  }
								     
								     if( ($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								      else
								        $transaction ->rollback();
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	  if($siges_structure==1)//previous
		                      	     $acad_sess = $previous_acad_sess;
		                      	     
		                      	      $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'reportcard_observation'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	} 
		                      	
                            }
                            
                        }    
	     	         




                      //_________________________________  fees ___________________________//
	     	               //add fees for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->fees==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad);
	     	               	//load tout period ane pase yo
	     	               	 $command2_= Yii::app()->db->createCommand('SELECT f.level, f.fee, f.amount, f.devise, f.date_limit_payment, f.checked, f.description FROM fees f inner join fees_label fl on(fl.id=f.fee) where fl.fee_label NOT LIKE("Pending balance") AND f.academic_period='.$previous_year ); 
	
	                           $data_2 = $command2_->queryAll();
    
							try {
								      $pass=1;
								      $one_save_record=0;
								      
								 if(($data_2!=null))
								  {   
								    foreach($data_2 as $d)
								     {
						    	         $model1=new Fees;
									      $model1->setAttribute('level',$d['level']);
									      $model1->setAttribute('fee',$d['fee']);
									      $model1->setAttribute('amount',$d['amount']);
									      $model1->setAttribute('devise',$d['devise']);
									      $model1->setAttribute('date_limit_payment',date("Y-m-d", strtotime($d['date_limit_payment']." + 1 year")));
									      $model1->setAttribute('checked',0);
									      $model1->setAttribute('description',$d['description']);
									      $model1->setAttribute('academic_period',$acad);
									      $model1->setAttribute('date_create',date('Y-m-d'));
					                      $model1->setAttribute('create_by','SIGES');
									      
									      
									     if($model1->save())
									     {
									     	$one_save_record=1;
									     }
									   else
									     $pass=0;
									     
								     
								     }
								     
								  }
								     
								     if( ($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								      else
								         $transaction ->rollback();
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	   $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'fees'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	} 
		                      	
                            }
                            
                        }    
	     	         


	     	         
	     	            //_________________________________  tax ___________________________//
	     	               //add taxes for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->taxes==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;

							try {
								    $model1=new Taxes;
								      $model1->setAttribute('taxe_description','IRI');
								      $model1->setAttribute('employeur_employe',0);
								      $model1->setAttribute('taxe_value',0);
								      $model1->setAttribute('particulier',0);
								      $model1->academic_year=$acad_sess;
								      
								     if($model1->save())
								     {
								     
								      $model2=new Taxes;
								      $model2->setAttribute('taxe_description','TMS');
								      $model2->setAttribute('employeur_employe',1);
								      $model2->setAttribute('taxe_value',1);
								      $model2->setAttribute('particulier',0);
								      $model2->setAttribute('academic_year',$acad_sess);
								      
								       if($model2->save())
								        { 
								     
									      $model3=new Taxes;
									      $model3->setAttribute('taxe_description','ONA');
									      $model3->setAttribute('employeur_employe',0);
									      $model3->setAttribute('taxe_value',6);
									      $model3->setAttribute('particulier',0);
									      $model3->setAttribute('academic_year',$acad_sess);
								      
										   if($model3->save())
										    {
								     
										      $model4=new Taxes;
										      $model4->setAttribute('taxe_description','ONA');
										      $model4->setAttribute('employeur_employe',1);
										      $model4->setAttribute('taxe_value',6);
										      $model4->setAttribute('particulier',0);
										      $model4->setAttribute('academic_year',$acad_sess);
										      
										     if($model4->save())
								              {
								     
											     $model5=new Taxes;
											      $model5->setAttribute('taxe_description','CAS');
											      $model5->setAttribute('employeur_employe',0);
											      $model5->setAttribute('taxe_value',1);
											      $model5->setAttribute('particulier',0);
											      $model5->setAttribute('academic_year',$acad_sess);
											      
											     if($model5->save())
								                  {
								     
												     $model6=new Taxes;
												      $model6->setAttribute('taxe_description','FDU');
												      $model6->setAttribute('employeur_employe',0);
												      $model6->setAttribute('taxe_value',1);
												      $model6->setAttribute('particulier',0);
												      $model6->setAttribute('academic_year',$acad_sess);
												      
												     if($model6->save())
								                        {
								                        	$transaction ->commit();
								                        	$status=1;
								                        }
								                      else
								                        $transaction ->rollback();
								                  }
								                 else
								                    $transaction ->rollback();
								               }
								              else
								                 $transaction ->rollback(); 
										    }
										   else
								             $transaction ->rollback(); 
								        }
								       else
								         $transaction ->rollback(); 
								     }
								    else
								       $transaction ->rollback();
								 
							     
							} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							}
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	   $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'taxes'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	}
		                      	
                          }
                          
                     }
	                      	
	                						        
				
	     	
	     	             //_________________________________  pending_balance ___________________________//  session too
	     	               //add period for the new acad
	     	            
	     	        if(isset($model_YearMigrationCheck)&&($model_YearMigrationCheck!=null))
                     {  
                     	 if($model_YearMigrationCheck->pending_balance==0)
                          {   
	     	               	$transaction = Yii::app()->db->beginTransaction();
	     	               	$status=0;
	     	               	
	     	               	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
	     	               	//load tout period ane pase yo
	     	               	 $command9_= Yii::app()->db->createCommand('SELECT student,balance FROM balance where balance>0' ); 
	
	                           $data_9 = $command9_->queryAll();
    
							try {
								      $pass=1;
								      $one_save_record=0;
								      
								      $level_array[]=null;
								      
								       $model11=new Fees;
								      
								 if(($data_9!=null))
								  {    
								    foreach($data_9 as $d)
								     {
						    	         $modelBalance=new PendingBalance;
									      $modelBalance->setAttribute('student',$d['student']);
									      $modelBalance->setAttribute('balance',$d['balance']);
									      $modelBalance->setAttribute('is_paid',0);
									      $modelBalance->setAttribute('academic_year',$previous_year);
									      $modelBalance->setAttribute('date_created',date('Y-m-d'));
					                      
									     if($modelBalance->save())
									     {
									     	$one_save_record=1;
									     	
									     	//jwenn nan ki klas elev la ye, tou kreye fee PENDING BALANCE pou klas la
									     	$level= Persons::model()->getLevelIdByStudentId($d['student'],$acad_sess);
									     	
									     	if(in_array($level,$level_array,false))
									     	 { 
									     	 	 $model_feesLabel = FeesLabel::model()->findByAttributes(array('fee_label'=>'Pending balance'));
									     	 	
									     	 	//kreye fee pending-balance pou klas la
									     	 	 
											      $model11->setAttribute('level',$level);
											      $model11->setAttribute('fee',$model_feesLabel->id);//pou labael "pending balance" lan
											      $model11->setAttribute('amount',0);
											      $model11->setAttribute('date_limit_payment',date("Y-m-d", strtotime(date('Y-m-d')." - 1 year")));
											      $model11->setAttribute('checked',1);//dat limit pase epi checked=1 pou l pa double montan nan tab balance lan
											      $model11->setAttribute('academic_period',$acad_sess);
											      $model11->setAttribute('date_create',date('Y-m-d'));
							                      $model11->setAttribute('create_by','SIGES');
											      
											      
											     if($model11->save())
													{  
														$level_array[]=$level;
														 $model11=new Fees;
													}
												 else
									                $pass=0;
									     	 	
									     	 }
									     	 
									     }
									   else
									     $pass=0;
									     
								     
								     }
								     
								  }
								     
								     if( ($pass==1)&&($one_save_record==1) )
								       {
								       	  $transaction ->commit();
								       	  $status=1;
								       	}
								      else
								        $transaction ->rollback();
								     
								} catch (Exception $error) {
							     $transaction ->rollback();
							     throw $error;
							     }
	
		                    //verifye si etap sa reyisi  
		                     if($status==1)
		                      {
		                      	  if($siges_structure==1)//previous
		                      	     $acad_sess = $previous_acad_sess;
		                      	     
		                      	      $command_yearMigrationCheck = Yii::app()->db->createCommand();
									    $command_yearMigrationCheck->update('year_migration_check', array(
																	'pending_balance'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
		                      	$status=0;
		                      	
		                      	} 
		                      	
                            }
                            
                        }
                       
                      //  ____________________     ______________________________	//			
				
				
				$this->redirect(array('yearMigrationCheck'));					
	     } 
	   
	   $this->render('_year_migration_check',array(
			'model'=>$model,
		));  
	     
  }

public function actionCreate()
	 {  
		$model=new ReportCard;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelCourse=new Courses;
		$modelEvaluation= new EvaluationByYear;
		$modelGrade=new Grades;
		
		$reportCard = 'documents/reportcard';
		
		//$this->reportcard_category_id =2; //tous les bulletins
		
		//Extract reportcard_structure (1:One evaluation by Period OR 2:Many evaluations in ONE Period)
         $reportcard_structure = infoGeneralConfig('reportcard_structure');
         
         $siges_structure=infoGeneralConfig('siges_structure_session'); 
         
         $this->final_period=false;
         
        
		
		$this->performAjaxValidation($model);
        
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
   
		
		  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }

         $reportcard_category = '';
      


				 
		
		if(isset($_POST['Shifts']))
               	{  
				
				//on n'a pas presser le bouton, il fo load apropriate rooms
					      $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
	                      Yii::app()->session['Shifts'] = $this->idShift;
                      
				     

								  
						   $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   Yii::app()->session['Sections'] = $this->section_id;
					     						
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   Yii::app()->session['LevelHasPerson'] = $this->idLevel;
						   
						  
						   
						   $modelEvaluation->attributes=$_POST['EvaluationByYear'];
						   $this->evaluation_id=$modelEvaluation->evaluation; 
						   Yii::app()->session['EvaluationByYear'] = $this->evaluation_id;
					
					     if(isset($_POST['Rooms']))
	                      {   $modelRoom->attributes=$_POST['Rooms'];
							   $this->room_id=$modelRoom->room_name;
							  
							  
	                      }
	                    else
	                      {
	                      	   if(isset($_GET['roo']))
	                      	      $this->room_id=$_GET['roo'];
	                      	
	                      	}

					 
            
					 //  $this->reportcard_category_id=$_POST['ReportCard']['reportcard_category'];
						   
						   
                          if((isset($this->room_id))&&($this->room_id!=""))
			                { if((isset($this->evaluation_id))&&($this->evaluation_id!=""))
			                   {    $room=$this->getRoomName($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id);
                               $acadPeriod_for_this_room = $this->getAcademicPeriodName_($acad_sess,$this->room_id);
                              
                              $name_acadPeriod_for_this_room=null;           
                              if(isset($acadPeriod_for_this_room))//!=null)
                               {       
                                 $name_acadPeriod_for_this_room=$acadPeriod_for_this_room->name_period;
                               }    
                                     //retire tout aksan yo    
                                         
		                                 $room1 = str_replace('/', '_', $room);
		                                 $room = strtr( $room1, pa_daksan() );
		                                 
		                                 $level1 = str_replace('/', '_', $level);
		                                 $level = strtr( $level1, pa_daksan() );
		                                 
		                                 $section1 = str_replace('/', '_', $section);
		                                 $section = strtr( $section1, pa_daksan() );
		                                 
		                                 $shift = strtr( $shift, pa_daksan() );
		                                 
		                                 $evaluationPeriod1 = str_replace('/', '_', $evaluationPeriod);
		                                 $evaluationPeriod = strtr( $evaluationPeriod1, pa_daksan() );
		                                 
		                                 $name_acadPeriod_for_this_room1 = str_replace('/', '_', $name_acadPeriod_for_this_room);
		                                 $name_acadPeriod_for_this_room = strtr( $name_acadPeriod_for_this_room1, pa_daksan() );
                                        
                                         
                                        
                                         
                                         
                                         
                                      $period_acad_id11111 = 0;
                            $period_exam_name11111 = null;
                            $eval_date = null;
			                $acad_year =0;
						// To find period name in in evaluation by year 
                                                                
                                                               $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name1 = str_replace('/', '_', $r->name_period);
																	$period_exam_name11111= strtr( $period_exam_name1, pa_daksan() );
																   $period_acad_id11111 = $r->id;
																   $eval_date = $r->evaluation_date;
															       $acad_year = $r->academic_year;
																   }
															 }
                                  // end of code 

							if($name_acadPeriod_for_this_room!=null)
                               {  
   									
									 $base = '';
								
								if($siges_structure==1)	
									$base = '/'.Yii::app()->session['currentName_academic_year'];
							    elseif($siges_structure==0)	
							         $base = '';
									
 	
								//   <!-- As we change SECTION TO NIVEAU, we should test $section and/or 'Fondamental' -->
								$path=$reportCard.$base.'/'.$name_acadPeriod_for_this_room.'/'.$shift.'/'.$section.'/'.$level.'/'.$room;
								$path1=$reportCard.$base.'/'.$name_acadPeriod_for_this_room.'/'.$shift.'/Primaire/'.$level.'/'.$room;
	                            
                               
                                 /*     
                                     switch($this->reportcard_category_id)
								      {
								      	case 0: //sans retenue
								      	        $reportcard_category = '_sr';
								      	        
								      	        break;
								      	      
								      	case 1: //avec retenue
								      	        $reportcard_category = '_ar';
								      	        
								      	        break;
								      	
								      	default: $reportcard_category = '';
								      	           break;
								        }
 
                                      */
             
                                    if($reportcard_structure==1) //One evaluation by Period
                                      {
                                      	 if($siges_structure==0)
                                      	   { //if(file_exists(Yii::app()->basePath.'/../'.$path.'/'.$room.'_'.$period_exam_name11111.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf')) // if pdf file exist, allowlink to print it 
									         if(file_exists(Yii::app()->basePath.'/../'.$path)) // if pdf file exist, allowlink to print it 
									         {
									            //$this->pathLink='/'.$path.'/'.$room.'_'.$period_exam_name11111.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf';
												 $this->allowLink=true;
												
									          }
									        //elseif(file_exists(Yii::app()->basePath.'/../'.$path1.'/'.$room.'_'.$period_exam_name11111.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf')) // if pdf file exist, allowlink to print it
									        elseif(file_exists(Yii::app()->basePath.'/../'.$path1)) // if pdf file exist, allowlink to print it
									          {
									            //$this->pathLink='/'.$path1.'/'.$room.'_'.$period_exam_name11111.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf';
												 $this->allowLink=true;
												
									          } 
									      
                                           }
									     elseif($siges_structure==1)
									        {  
									        	//if(file_exists(Yii::app()->basePath.'/../'.$path.'/'.$room.'_'.$evaluationPeriod.'_'.$period_exam_name11111.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf')) // if pdf file exist, allowlink to print it 
												 if(file_exists(Yii::app()->basePath.'/../'.$path)) // if pdf file exist, allowlink to print it 
												 {
													//$this->pathLink='/'.$path.'/'.$room.'_'.$evaluationPeriod.'_'.$period_exam_name11111.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf';
													 $this->allowLink=true;
													
												  }
												//elseif(file_exists(Yii::app()->basePath.'/../'.$path1.'/'.$room.'_'.$evaluationPeriod.'_'.$period_exam_name11111.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf')) // if pdf file exist, allowlink to print it
												elseif(file_exists(Yii::app()->basePath.'/../'.$path1)) // if pdf file exist, allowlink to print it
												  {
													//$this->pathLink='/'.$path1.'/'.$room.'_'.$evaluationPeriod.'_'.$period_exam_name11111.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf';
													 $this->allowLink=true;
													
												  } 
									          
									        }   
                                      	}
                                     elseif($reportcard_structure==2)  //Many evaluations in ONE Period
                                        {
                                        	if($siges_structure==0)
                                        	  {  //if(file_exists(Yii::app()->basePath.'/../'.$path.'/'.$room.'_'.$period_exam_name11111.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf')) // if pdf file exist, allowlink to print it 
									             if(file_exists(Yii::app()->basePath.'/../'.$path)) // if pdf file exist, allowlink to print it 
									               {
											           // $this->pathLink='/'.$path.'/'.$room.'_'.$period_exam_name11111.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf';
														 $this->allowLink=true;
														
											          }
											//elseif(file_exists(Yii::app()->basePath.'/../'.$path1.'/'.$room.'_'.$period_exam_name11111.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf')) // if pdf file exist, allowlink to print it
											elseif(file_exists(Yii::app()->basePath.'/../'.$path1)) // if pdf file exist, allowlink to print it
											          {
											            //$this->pathLink='/'.$path1.'/'.$room.'_'.$period_exam_name11111.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf';
														 $this->allowLink=true;
														
											          } 
									          
									         }
									     elseif($siges_structure==1)
									        {  
									        	//if(file_exists(Yii::app()->basePath.'/../'.$path.'/'.$room.'_'.$evaluationPeriod.'_'.$period_exam_name11111.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf')) // if pdf file exist, allowlink to print it 
									            if(file_exists(Yii::app()->basePath.'/../'.$path)) // if pdf file exist, allowlink to print it 
									               {
											            //$this->pathLink='/'.$path.'/'.$room.'_'.$evaluationPeriod.'_'.$period_exam_name11111.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf';
														 $this->allowLink=true;
														
											          }
											//elseif(file_exists(Yii::app()->basePath.'/../'.$path1.'/'.$room.'_'.$evaluationPeriod.'_'.$period_exam_name11111.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf')) // if pdf file exist, allowlink to print it
											elseif(file_exists(Yii::app()->basePath.'/../'.$path1)) // if pdf file exist, allowlink to print it
											          {
											           // $this->pathLink='/'.$path1.'/'.$room.'_'.$evaluationPeriod.'_'.$period_exam_name11111.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room.$reportcard_category.'.pdf';
														 $this->allowLink=true;
														
											          }
											          
									        	} 
									          
                                          }           
														
							         
									                                             
                                   $this->noStud = 1; //people enrolled this room pour cette annee academic
                                   }
                                 else //$acadPeriod==null, no people enrolled this room
                                   $this->noStud = 0;
					        }
					      else //display a message to ask for fill in evalvuationPeriod 
							 {
						         $this->messageEvaluation_id=true;
						      }
					
					 }//end if((isset($this->room_id))&&($this->room_id!=""))
						
						   
	             }				   
				else //$_POST['Shifts'] not set
				  {
				   	if(Yii::app()->session['EvaluationByYear'] =='')
	                  {	//return an id(number)
			            $lastPeriod4 = $this->getLastEvaluationInGrade();
			            $this->evaluation_id = $lastPeriod4;
						Yii::app()->session['EvaluationByYear'] = $this->evaluation_id;
	                  }
	                 else
						$this->evaluation_id = Yii::app()->session['EvaluationByYear'];
						
				   
						
				   $this->idShift=null;
                   $this->section_id=null;
				   $this->idLevel=null;
				   $this->room_id=null;
				   $this->course_id=null;
				   $this->student_id=null;
				   
				   $this->allowLink=false;
				   $this->messageEvaluation_id=false;
                                   $this->noStud = 0; 
				     }
		
			 if(isset($_POST['create']))
				 { //on vient de presser le bouton create
				 	 $pastp = null;//array(); //pou denye evalyasyon nan chak peryod pase
				 	 $past_period = null; //pou evalyasyon ki pase deja nan yon peryod
				 	 $compter_p=1; //on compte deja the current period
				 	 $last_eval_=false; //par defaut, ce n;est pas la derniere evaluation pour cette periode
                     $eval_date=null;
                     
                     $pass=true;
                     
				 	 $pastEval = new Evaluations();
				 	 $modEY = new EvaluationByYear;
				 	 
				 	 if($reportcard_structure==1) //One evaluation by Period
                       {
                            //getting past evaluation period
						  if(isset($_POST['Evaluations']))//&&($_POST['Evaluations'])) 
						     {	
					 			foreach($_POST['Evaluations'] as $r)
									{  if($r!=null)
									      $pastp = $r;
									        
									 }
									     
						     } 
						               	
                         }
                      elseif($reportcard_structure==2)  //Many evaluations in ONE Period
                        {
                             //getting past evaluation period
						  if(isset($_POST['EvaluationByYear'][1])&& !empty($_POST['EvaluationByYear'][1])) 
						     {	
			 	
						     	//$modEY = $_POST['chk_peval_id'];
					 			foreach($_POST['EvaluationByYear'][1] as $r)
									{  if($r!=null)
									      $pastp = $r;
									        
									 }
									     
						     }
									           	
                           } 
					
					
					    $last_eval_period = EvaluationByYear::model()->findByPk($this->evaluation_id);
         
				         if($last_eval_period->last_evaluation==1)
				           { 
				           	  $this->final_period=true; 
				           
				              //Extract use_period_weight 
							   $use_period_weight = infoGeneralConfig('use_period_weight');
							   
							   if($use_period_weight==1)
							    {
							    	//tcheke somme tout period yo
							    	 $sum_weight = sumPeriodWeight($pastp,$last_eval_period->id);
							    	
							    	 if( ($sum_weight!=100) && ($sum_weight!= -1) )
							    	   $pass=false;
							    	 
							     }
							     
							     
				            }
				           else
				           { $last_eval_date = EvaluationByYear::model()->getLastEvaluationDate($acad_sess);
				              if($last_eval_date!=null)
				                {
				                	foreach($last_eval_date as $last_eval_date__)
				                	{
					                	if($last_eval_date__['evaluation_date']==$last_eval_period->evaluation_date)
					                	 {$this->final_period=true;
					                	 	
					                	 	//Extract use_period_weight 
											   $use_period_weight = infoGeneralConfig('use_period_weight');
											   
											   if($use_period_weight==1)
											    {
											    	//tcheke somme tout period yo
											    	 $sum_weight = sumPeriodWeight($pastp,$last_eval_period->id);
											    	
											    	 if( ($sum_weight!=100) && ($sum_weight!= -1) )
											    	   $pass=false;
								    	 
								                  }
					                	 	
					                	  }
				                	 }
				                  }
				           
				            }
				 	
						 //Extract school name 
							$school_name = infoGeneralConfig('school_name');
                        //Extract school address
				   			$school_address = infoGeneralConfig('school_address');
                        //Extract  email address 
                           $school_email_address = infoGeneralConfig('school_email_address');
                        //Extract Phone Number
                            $school_phone_number = infoGeneralConfig('school_phone_number');
				   								
	                                                               
                       //reccuperer la ligne selectionnee()
	                 //il fo avoir toutes les lignes selectionnees  
 	                 $stud_array= array();
					 
					 if(isset(Yii::app()->session['stud_to_enable_reportcar'])) 
					   $stud_array=Yii::app()->session['stud_to_enable_reportcar'];
				   
				   
				   
				   if($pass==true)
				     {
				   
				   
					    if(isset($_POST['chk']) || ($stud_array!=null))  {

						   	     						
							     //on retourne l'ID de l'eleve
								// Ne pas eliminer les commentaires dans la generation des fichiers PDF, posible utilisation ulterieure par d'autres programmeurs		
							     
								
								// create new PDF document
								$pdf = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app',"Report Card"));
								$pdf->SetSubject(Yii::t('app',"Report Card"));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								
								//$pdf->SetHeaderData(PDF_HEADER_LOGO_REPORTCARD, PDF_HEADER_LOGO_REPORTCARD_WIDTH, "", ""); //CNR
								$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								//$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);      //CNR
								$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, 5); // PDF_MARGIN_BOTTOM

								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 12, '', true);
								
			
									
										
										
										//calculate position
										  $position = Grades::model()->searchForPosition($condition,$this->evaluation_id, $this->idShift, $this->section_id, $this->idLevel, $this->room_id);
											$old_maxValue=0;
											$old_place=0;
											$position_to_placecode= array();
											$position_to_placecode[null][null]= null;
										   $j = 1;
										   $compteur = 0;
										  if(isset($position))
										    {
											  $r=$position->getData();
														
												foreach($r as $pos)
												  {
												    $position_to_placecode[$compteur][0]= $pos->student ;
													if($pos->max_grade===$old_maxValue)
													   $position_to_placecode[$compteur][1]= $old_place;
													else
													  { $position_to_placecode[$compteur][1]= $j;
														   $old_place=$j;
													   }
													   
												  $compteur++;
												  $old_maxValue=$pos->max_grade;
												  $j=$j+1; 	
												  
												 }
										     }
										   
							$tot = $compteur;//-1;
																
							$period_acad_id = 0;
                            $period_exam_name = null;
	
						
                                  $last_eval_date=null;
							          $acad_year=0;
							          $array_past_period = array();
							          
							      
							      //$STUDENT=array();
                                 
									 
									 
                                    
                                      $this->tot_stud=$tot;

									  
                          
						  if(isset($_POST['chk']))
						   {
                              foreach($_POST['chk'] as $val) {
								  $array_past_period= array();
								  $place=0;
								    $k=0;
									 $tot_grade=0;
									$temoin_has_note=false;
								   $max_grade=0;
								   
									$this->student_id=$val;
							
							 //check if all grades are validated for this stud		
								$all_validated=$this->if_all_grades_validated($this->student_id,$this->evaluation_id);
								
								    $shiftName=$this->getShiftByStudentId($this->student_id)->shift_name;
									$sectionName=$this->getSectionByStudentId($this->student_id)->section_name;
									$levelName=$this->getLevelByStudentId($this->student_id)->level_name;
									$roomName=$this->getRoomByStudentId($this->student_id)->room_name;
								
									$acadPeriod_for_this_room=$this->getAcademicPeriodName_($acad_sess,$this->getRoomByStudentId($this->student_id)->id);
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id); 
							 
							  
							       if($reportcard_structure==2)  //Many evaluations in ONE Period
                                        {
                                        	 //eske se denye evalyasyon nan peryod sa a?
							         
							            //find date of the current evaluation
									        $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
											   if(isset($result))
												 {  $result=$result->getData();//return a list of  objects
													 foreach($result as $r)
													   { 
															$eval_date = $r->evaluation_date;
															$acad_year = $r->academic_year;	   
														 }
													}
							          
							           $result_last=EvaluationByYear::model()->getLastEvaluationForAPeriod($acad_year, $acad_sess);
							             if(($result_last!=null))
											{  foreach($result_last as $r)
												 { $last_eval_date= $r["evaluation_date"];
													 break;			   
											        }
		        
											  }
									 //all past evaluations ASC order in athis period
									  $result_past=EvaluationByYear::model()->getPastEvaluationInAPeriod($acad_year, $acad_sess);
							             if(($result_last!=null))
											{  
												  foreach($result_past as $r)
												 {  if($r["id"]!= $this->evaluation_id)
												      $array_past_period[] = $r["id"];
												      
												      
											        }
											  }  
													
									       if($last_eval_date == $eval_date)
									          $last_eval_ = true; 
							          //si wi, jwenn ID lot evalyasyon ki pase nan peryod sa deja
							             if($last_eval_) 
							               { 
							               	 $past_period = $array_past_period;
							               	  }
							           
							          

                                          }
							  
							  if($all_validated)
								{	     

                                                   
								  if(isset($this->student_id)&&($this->student_id!=''))
								   {  
								   	  //$STUDENT[]=$this->student_id;
								     // To find period name in in evaluation by year 
                                                                
                                                               $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
                                                               // end of code 
								     
							        $student=$this->getStudent($this->student_id);
							        $room=$this->getRoomName($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
										   //[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
										   $dataProvider=$this->loadSubject($this->room_id,$this->idLevel);
										   
										 for($jj = 0; $jj<$tot; $jj++)
									       {
                                                       
										     if($position_to_placecode[$jj][0]===$this->student_id)
										           {
                                                         $place = $position_to_placecode[$jj][1]; 
                                                                                                               
                                                    }
                                                    			                                
                                              }
								                
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();
$general_average=0;
								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print

                                  if($reportcard_structure==1) //One evaluation by Period
									  {
										  $pdf->writeHTML($this->htmlReportcard1($dataProvider,$tot_grade,$student,$pastp,$k,$place,$max_grade,$acad_sess,$temoin_has_note,$evaluationPeriod,$period_exam_name,$level,$room,$section,$shift,$acadPeriod_for_this_room->name_period,$tot), true, false, true, false, '');
									                                       	
									   }
									elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									   {
									       $pdf->writeHTML($this->htmlReportcard2($dataProvider,$tot_grade,$student,$pastp,$k,$place,$max_grade,$acad_sess,$temoin_has_note,$evaluationPeriod,$period_exam_name,$level,$room,$section,$shift,$acadPeriod_for_this_room->name_period,$tot,	$eval_date, $last_eval_, $past_period), true, false, true, false, '');
									                                        	
									     }    
                                      
                                      

	                              
	                             	                            
	                             }// end of if $this->student_id set
	                            
	                          
						    
						    }// end of if($all_validated)
						    
						    
						    
						    
						    
						    
						    
								
                         }// end of chak elev	

					}
				  elseif($stud_array!=null)  
				   {
					   foreach($stud_array as $val) {
						   
						   $array_past_period= array();
								  
								  $place=0;
								    $k=0;
									 $tot_grade=0;
									$temoin_has_note=false;
								   $max_grade=0;
								   
									$this->student_id=$val;
							
							 //check if all grades are validated for this stud		
								$all_validated=$this->if_all_grades_validated($this->student_id,$this->evaluation_id);
								
								    $shiftName=$this->getShiftByStudentId($this->student_id)->shift_name;
									$sectionName=$this->getSectionByStudentId($this->student_id)->section_name;
									$levelName=$this->getLevelByStudentId($this->student_id)->level_name;
									$roomName=$this->getRoomByStudentId($this->student_id)->room_name;
								
									$acadPeriod_for_this_room=$this->getAcademicPeriodName_($acad_sess,$this->getRoomByStudentId($this->student_id)->id);
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id); 
							 
							  
							       if($reportcard_structure==2)  //Many evaluations in ONE Period
                                        {
                                        	 //eske se denye evalyasyon nan peryod sa a?
							         
							            //find date of the current evaluation
									        $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
											   if(isset($result))
												 {  $result=$result->getData();//return a list of  objects
													 foreach($result as $r)
													   { 
															$eval_date = $r->evaluation_date;
															$acad_year = $r->academic_year;	   
														 }
													}
							          
							           $result_last=EvaluationByYear::model()->getLastEvaluationForAPeriod($acad_year, $acad_sess);
							             if(($result_last!=null))
											{  foreach($result_last as $r)
												 { $last_eval_date= $r["evaluation_date"];
													 break;			   
											        }
		        
											  }
									 //all past evaluations ASC order in athis period
									  $result_past=EvaluationByYear::model()->getPastEvaluationInAPeriod($acad_year, $acad_sess);
							             if(($result_last!=null))
											{  
												  foreach($result_past as $r)
												 {  if($r["id"]!= $this->evaluation_id)
												      $array_past_period[] = $r["id"];
												      
												      
											        }
											  }  
													
									       if($last_eval_date == $eval_date)
									          $last_eval_ = true; 
							          //si wi, jwenn ID lot evalyasyon ki pase nan peryod sa deja
							             if($last_eval_) 
							               { 
							               	 $past_period = $array_past_period;
							               	  }
							           
							          

                                          }
							  
							  if($all_validated)
								{	     

                                                   
								  if(isset($this->student_id)&&($this->student_id!=''))
								   {  
								   	  //$STUDENT[]=$this->student_id;
								// To find period name in in evaluation by year 
                                                                
                                                               $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
                                                               // end of code 
								     
							        $student=$this->getStudent($this->student_id);
							        $room=$this->getRoomName($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
										   //[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
										   $dataProvider=$this->loadSubject($this->room_id,$this->idLevel);
										   
										 for($jj = 0; $jj<$tot; $jj++)
									       {
                                                       
										     if($position_to_placecode[$jj][0]===$this->student_id)
										           {
                                                         $place = $position_to_placecode[$jj][1]; 
                                                                                                               
                                                    }
                                                    			                                
                                              }
								                
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();
$general_average=0;
								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print

                                  if($reportcard_structure==1) //One evaluation by Period
									  {
										  $pdf->writeHTML($this->htmlReportcard1($dataProvider,$tot_grade,$student,$pastp,$k,$place,$max_grade,$acad_sess,$temoin_has_note,$evaluationPeriod,$period_exam_name,$level,$room,$section,$shift,$acadPeriod_for_this_room->name_period,$tot), true, false, true, false, '');
									                                       	
									   }
									elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									   {
									       $pdf->writeHTML($this->htmlReportcard2($dataProvider,$tot_grade,$student,$pastp,$k,$place,$max_grade,$acad_sess,$temoin_has_note,$evaluationPeriod,$period_exam_name,$level,$room,$section,$shift,$acadPeriod_for_this_room->name_period,$tot,	$eval_date, $last_eval_, $past_period), true, false, true, false, '');
									                                        	
									     }    
                                      
                                      

	                              
	                             	                            
	                             }// end of if $this->student_id set
	                            
	                          
						    
						    }// end of if($all_validated)
						    
						    
								
                         }// end of chak elev	
					   
					   
					   
				     }



					
					       												   
                   //___________________________________________________________________//    
                       
                                              
                       if($all_validated)
                         {
                    				
                    				//retire tout aksan yo    
                                         
		                                 $room1 = str_replace('/', '_', $room);
		                                 $room_ = strtr( $room1, pa_daksan() );
		                                 
		                                 $level1 = str_replace('/', '_', $level);
		                                 $level_ = strtr( $level1, pa_daksan() );
		                                 
		                                 $section1 = str_replace('/', '_', $section);
		                                 $section_ = strtr( $section1, pa_daksan() );
		                                 
		                                 $shift_ = strtr( $shift, pa_daksan() );
		                                 
		                                 $evaluationPeriod1 = str_replace('/', '_', $evaluationPeriod);
		                                 $evaluationPeriod_ = strtr( $evaluationPeriod1, pa_daksan() );
		                                 
		                                 $name_acadPeriod_for_this_room1 = str_replace('/', '_', $name_acadPeriod_for_this_room);
		                                 $name_acadPeriod_for_this_room_ = strtr( $name_acadPeriod_for_this_room1, pa_daksan() );
                                        
                                         $period_exam_name1 = str_replace('/', '_', $period_exam_name);
		                                 $period_exam_name_ = strtr( $period_exam_name1, pa_daksan() );
		                                 
		                                 
				
				               $base = '';
								/*   
									if (!file_exists(Yii::app()->basePath.'/../'.$reportCard))  //si reportCard n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.$reportCard);
								
								if($siges_structure==1)	
									$base = '/'.Yii::app()->session['currentName_academic_year'];
							    elseif($siges_structure==0)	
							         $base = '';
									
								 if($siges_structure==1)
									{
									   if(!file_exists(Yii::app()->basePath.'/../'.$reportCard.$base))    //reportCard existe.si acadPeriod n'existe pas, on le cree 
										 mkdir(Yii::app()->basePath.'/../'.$reportCard.$base);
										
										}
										
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_))    //reportCard existe.si acadPeriod n'existe pas, on le cree 
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_);
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_))    //acadPeriod existe.si shiftName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_);
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_))    //shiftName existe.si sectionName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_);
									  
                                    if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_))    //sectionName existe.si levelName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_); 
										 
									                                       	
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_.'/'.$room_))    //levelName existe.si roomName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_.'/'.$room_);
									//if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$acadPeriod_for_this_room->name_period.'/'.$shiftName.'/'.$sectionName.'/'.$levelName.'/'.$roomName.'/'.$evalvuationPeriod_))    //roomName existe.si evalvuationPeriod n'existe pas, on le cree  
									//	 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$acadPeriod_for_this_room->name_period.'/'.$shiftName.'/'.$sectionName.'/'.$levelName.'/'.$roomName.'/'.$evalvuationPeriod_);
									
								
								
								$path=$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_.'/'.$room_;
								*/
	
	                         /*
	                            switch($this->reportcard_category_id)
								      {
								      	case 0: //sans retenue
								      	        $reportcard_category = '_sr';
								      	        
								      	        break;
								      	      
								      	case 1: //avec retenue
								      	        $reportcard_category = '_ar';
								      	        
								      	        break;
								      	
								      	default: $reportcard_category = '';
								      	           break;
								        }
                                */
                                
                           $this->success=true;
								//	 $this->allowLink=true;
									      
                                      
							if($reportcard_structure==1) //One evaluation by Period
							  {   
							  
							     if($siges_structure==0)
							       {
								      $pdf->Output($room_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
								      //$pdf->Output($path.'/'.$room_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
								      
								      //$this->pathLink='/'.$path.'/'.$room_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf';
								      
							       }
							     elseif($siges_structure==1)
							       {
							       	   
							       	   $pdf->Output($room_.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
								      //$pdf->Output($path.'/'.$room_.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
								      
								      //$this->pathLink='/'.$path.'/'.$room_.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf';

							       	  
							       	  }
							      
							      
							      
							      
							                                    	
							   }
							elseif($reportcard_structure==2)  //Many evaluations in ONE Period
							   {
							      if($siges_structure==0)
							       { 
							       	  $pdf->Output($room_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
							          //$pdf->Output($path.'/'.$room_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
							       
							          //$this->pathLink='/'.$path.'/'.$room_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf';
							          
							        }
							      elseif($siges_structure==1)
							       {
							       	   
							       	   $pdf->Output($room_.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
							          //$pdf->Output($path.'/'.$room_.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
							       
							          //$this->pathLink='/'.$path.'/'.$room_.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf';
							       	  
							       	  }
							                                      	
							     } 	 
								
                                  /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/

								//============================================================+
								// END OF FILE
								//============================================================+		
		
								
					
								  //  Yii::app()->session['stud_to_enable_reportcar']=$STUDENT;
								    
								    
								
                              }//end(2) if(all_validated) 	
							
							
		           						 
							} 
						 else
						   {
						     		
							 $this->message=true;
							 
						  }
						  
				     } 
				   else
				     {  //$sum_weight = sumPeriodWeight($pastp,$);
				     	Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Sum period weight must equal 100.' ));
				     	
				     	}
						
			          
		     }
			elseif(isset($_POST['enableguestview']))
			 {
			 	$stud_array=array();
				$STUDENT=array();
			 	 $pastp = null;//array(); //pou denye evalyasyon nan chak peryod pase
				 	 $past_period = null; //pou evalyasyon ki pase deja nan yon peryod
				 	 $compter_p=1; //on compte deja the current period
				 	 $last_eval_=false; //par defaut, ce n;est pas la derniere evaluation pour cette periode
                     $eval_date=null;
                     
                     $pass=true;
                     
				 	 $pastEval = new Evaluations();
				 	 $modEY = new EvaluationByYear;
				 	 
				 	 if($reportcard_structure==1) //One evaluation by Period
                       {
                            //getting past evaluation period
						  if(isset($_POST['Evaluations']))//&&($_POST['Evaluations'])) 
						     {	
					 			foreach($_POST['Evaluations'] as $r)
									{  if($r!=null)
									      $pastp = $r;
									        
									 }
									     
						     } 
						               	
                         }
                      elseif($reportcard_structure==2)  //Many evaluations in ONE Period
                        {
                             //getting past evaluation period
						  if(isset($_POST['EvaluationByYear'][1])&& !empty($_POST['EvaluationByYear'][1])) 
						     {	
			 	
						     	//$modEY = $_POST['chk_peval_id'];
					 			foreach($_POST['EvaluationByYear'][1] as $r)
									{  if($r!=null)
									      $pastp = $r;
									        
									 }
									     
						     }
									           	
                           } 
					
					               
                     

					   
					   

			 	 if(isset($_POST['chk'])) 
			 	   { foreach($_POST['chk'] as $val) 
			 	       { $stud_array[]=$val;
					      $STUDENT[]=$val;
					     
			 	       
			 	       }
			 	   }
			 	 else
			 	   {   $this->message=true;
			           /*
							if((isset($this->room_id))&&($this->room_id!=""))
							 { if((isset($this->evaluation_id))&&($this->evaluation_id!=""))
								 {   
									if(isset(Yii::app()->session['stud_to_enable_reportcar'])) 
									 {$stud_array=Yii::app()->session['stud_to_enable_reportcar'];
									 }
								 
								 }
							   
							   
							 }
						   else //display a message to ask for fill in evalvuationPeriod 
								 {
									 $this->messageEvaluation_id=true;
								  }
					     */

                          
					 	    
			 	   	 }
			 	
			 	if($stud_array !=null)
			 	  {          
			         
					    $last_eval_period = EvaluationByYear::model()->findByPk($this->evaluation_id);
         
				         if($last_eval_period->last_evaluation==1)
				           { 
				           	  $this->final_period=true; 
				           
				              //Extract use_period_weight 
							   $use_period_weight = infoGeneralConfig('use_period_weight');
							   
							   if($use_period_weight==1)
							    {
							    	//tcheke somme tout period yo
							    	 $sum_weight = sumPeriodWeight($pastp,$last_eval_period->id);
							    	
							    	 if( ($sum_weight!=100) && ($sum_weight!= -1) )
							    	   $pass=false;
							    	 
							     }
							     
							     
				            }
				           else
				           { $last_eval_date = EvaluationByYear::model()->getLastEvaluationDate($acad_sess);
				              if($last_eval_date!=null)
				                {
				                	foreach($last_eval_date as $last_eval_date__)
				                	{
					                	if($last_eval_date__['evaluation_date']==$last_eval_period->evaluation_date)
					                	 {$this->final_period=true;
					                	 	
					                	 	//Extract use_period_weight 
											   $use_period_weight = infoGeneralConfig('use_period_weight');
											   
											   if($use_period_weight==1)
											    {
											    	//tcheke somme tout period yo
											    	 $sum_weight = sumPeriodWeight($pastp,$last_eval_period->id);
											    	
											    	 if( ($sum_weight!=100) && ($sum_weight!= -1) )
											    	   $pass=false;
								    	 
								                  }
					                	 	
					                	  }
				                	 }
				                  }
				           
				            }
				 	
						                  
          
                    Yii::app()->session['stud_to_enable_reportcar']=$STUDENT;
					
						//Extract school name 
							$school_name = infoGeneralConfig('school_name');
                        //Extract school address
				   			$school_address = infoGeneralConfig('school_address');
                        //Extract  email address 
                           $school_email_address = infoGeneralConfig('school_email_address');
                        //Extract Phone Number
                            $school_phone_number = infoGeneralConfig('school_phone_number');
                            
                                        
                       //reccuperer la ligne selectionnee()
	                 //il fo avoir toutes les lignes selectionnees  
 	                            
                     
				   
				   if($pass==true)
				     {
				   
				   			
										//calculate position
										  $position = Grades::model()->searchForPosition($condition,$this->evaluation_id, $this->idShift, $this->section_id, $this->idLevel, $this->room_id);
											$old_maxValue=0;
											$old_place=0;
											$position_to_placecode= array();
											$position_to_placecode[null][null]= null;
										   $j = 1;
										   $compteur = 0;
										  if(isset($position))
										    {
											  $r=$position->getData();
														
												foreach($r as $pos)
												  {
												    $position_to_placecode[$compteur][0]= $pos->student ;
													if($pos->max_grade===$old_maxValue)
													   $position_to_placecode[$compteur][1]= $old_place;
													else
													  { $position_to_placecode[$compteur][1]= $j;
														   $old_place=$j;
													   }
													   
												  $compteur++;
												  $old_maxValue=$pos->max_grade;
												  $j=$j+1; 	
												  
												 }
										     }
										   
							$tot = $compteur;//-1;
																
							$period_acad_id = 0;
                            $period_exam_name = null;
	
						
                             $last_eval_date=null;
							          $acad_year=0;
							          $array_past_period = array();
							          
							          
							          
                                    
                                      $this->tot_stud=$tot;
                                      
     
                              foreach($stud_array as $val) {
								  
								  $array_past_period= array();
								  
								  $place=0;
									 
									 $k=0;
									 $tot_grade=0;
									$temoin_has_note=false;
									  $max_grade=0;
									  
									$this->student_id=$val;
							
							 //check if all grades are validated for this stud		
								$all_validated=$this->if_all_grades_validated($this->student_id,$this->evaluation_id);
								
								    $shiftName=$this->getShiftByStudentId($this->student_id)->shift_name;
									$sectionName=$this->getSectionByStudentId($this->student_id)->section_name;
									$levelName=$this->getLevelByStudentId($this->student_id)->level_name;
									$roomName=$this->getRoomByStudentId($this->student_id)->room_name;
									$acadPeriod_for_this_room=$this->getAcademicPeriodName_($acad_sess,$this->getRoomByStudentId($this->student_id)->id);
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id); 
							 
							    if($reportcard_structure==2)  //Many evaluations in ONE Period
							     {
							          //eske se denye evalyasyon nan peryod sa a?
							          
							            //find date of the current evaluation
									        $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
											   if(isset($result))
												 {  $result=$result->getData();//return a list of  objects
													 foreach($result as $r)
													   { 
															$eval_date = $r->evaluation_date;
															$acad_year = $r->academic_year;	   
														 }
													}
							          
							           $result_last=EvaluationByYear::model()->getLastEvaluationForAPeriod($acad_year, $acad_sess);
							             if(($result_last!=null))
											{  foreach($result_last as $r)
												 { $last_eval_date= $r["evaluation_date"];
													 break;			   
											        }
		        
											  }
									 //all past evaluations ASC order in athis period
									  $result_past=EvaluationByYear::model()->getPastEvaluationInAPeriod($acad_year, $acad_sess);
							             if(($result_last!=null))
											{  
												  foreach($result_past as $r)
												 {  if($r["id"]!= $this->evaluation_id)
												      $array_past_period[] = $r["id"];
											        }
											  }  
													
									       if($last_eval_date == $eval_date)
									          $last_eval_ = true; 
							          //si wi, jwenn ID lot evalyasyon ki pase nan peryod sa deja
							             if($last_eval_) 
							               { 
							               	 $past_period = $array_past_period;
							               	  }
							           
                              	
							       } 
							  
							  
							  if($all_validated)
								{	     

                                                   
								  if(isset($this->student_id))
								   {
								// To find period name in in evaluation by year 
                                                                
                                                               $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
                                                               // end of code 
								     
							        $student=$this->getStudent($this->student_id);
							        $room=$this->getRoomName($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
										   //[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
										   $dataProvider=$this->loadSubject($this->room_id,$this->idLevel);
										   
										 for($jj = 0; $jj<$tot; $jj++)
									       {
                                                       
										     if($position_to_placecode[$jj][0]===$this->student_id)
										           {
                                                         $place = $position_to_placecode[$jj][1]; 
                                                                                                               
                                                    }
                                                    			                                
                                              }
				      
                                              
								
								// create new PDF document
								$pdf_one_stud = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf_one_stud->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf_one_stud->SetAuthor($school_name);
								$pdf_one_stud->SetTitle(Yii::t('app',"Report Card"));
								$pdf_one_stud->SetSubject(Yii::t('app',"Report Card"));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								
								//$pdf_one_stud->SetHeaderData(PDF_HEADER_LOGO_REPORTCARD, PDF_HEADER_LOGO_REPORTCARD_WIDTH, "", ""); //CNR
								$pdf_one_stud->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								//$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf_one_stud->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf_one_stud->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
								//$pdf_one_stud->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);   //CNR
								$pdf_one_stud->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf_one_stud->SetHeaderMargin(PDF_MARGIN_HEADER);
								//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf_one_stud->SetAutoPageBreak(TRUE, 5);// PDF_MARGIN_BOTTOM

								// set image scale factor
								$pdf_one_stud->setImageScale(PDF_IMAGE_SCALE_RATIO);

								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf_one_stud->setLanguageArray($l);
								}

								
								// set default font subsetting mode
								$pdf_one_stud->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf_one_stud->SetFont('helvetica', '', 12, '', true);
                            
                                 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf_one_stud->AddPage();
$general_average=0;
								// set text shadow effect
								//$pdf_one_stud->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print

                                 
                                  if($reportcard_structure==1) //One evaluation by Period
									  {
									     $pdf_one_stud->writeHTML($this->htmlReportcard1($dataProvider,$tot_grade,$student,$pastp,$k,$place,$max_grade,$acad_sess,$temoin_has_note,$evaluationPeriod,$period_exam_name,$level,$room,$section,$shift,$acadPeriod_for_this_room->name_period,$tot), true, false, true, false, '');
									                                      	
									   }
									elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									   {
									        $pdf_one_stud->writeHTML($this->htmlReportcard2($dataProvider,$tot_grade,$student,$pastp,$k,$place,$max_grade,$acad_sess,$temoin_has_note,$evaluationPeriod,$period_exam_name,$level,$room,$section,$shift,$acadPeriod_for_this_room->name_period,$tot,$eval_date,$last_eval_, $past_period), true, false, true, false, '');
									                                        	
									     }   
                                      
                               
		                     
		                      
		                                 $student_= strtr( $student, pa_daksan() );
		                                 
		                                 $room1 = str_replace('/', '_', $room);
		                                 $room_ = strtr( $room1, pa_daksan() );
		                                 
		                                 $level1 = str_replace('/', '_', $level);
		                                 $level_ = strtr( $level1, pa_daksan() );
		                                 
		                                 $section1 = str_replace('/', '_', $section);
		                                 $section_ = strtr( $section1, pa_daksan() );
		                                 
		                                 $shift_ = strtr( $shift, pa_daksan() );
		                                 
		                                 $evaluationPeriod1 = str_replace('/', '_', $evaluationPeriod);
		                                 $evaluationPeriod_ = strtr( $evaluationPeriod1, pa_daksan() );
		                                 
		                                 $name_acadPeriod_for_this_room1 = str_replace('/', '_', $name_acadPeriod_for_this_room);
		                                 $name_acadPeriod_for_this_room_ = strtr( $name_acadPeriod_for_this_room1, pa_daksan() );
                                        
                                         $period_exam_name1 = str_replace('/', '_', $period_exam_name);
		                                 $period_exam_name_ = strtr( $period_exam_name1, pa_daksan() );
								
								$base = '';
								
								if($siges_structure==1)	
									$base = '/'.Yii::app()->session['currentName_academic_year'];
							    elseif($siges_structure==0)	
							         $base = '';
									
								 
								
								if($siges_structure==1)
									{
									   if(!file_exists(Yii::app()->basePath.'/../'.$reportCard.$base))    //reportCard existe.si acadPeriod n'existe pas, on le cree 
										 mkdir(Yii::app()->basePath.'/../'.$reportCard.$base);
										
										}
										
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_))    //reportCard existe.si acadPeriod n'existe pas, on le cree 
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_);
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_))    //acadPeriod existe.si shiftName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_);
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_))    //shiftName existe.si sectionName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_);
									  
                                    if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_))    //sectionName existe.si levelName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_); 
										 
									                                       	
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_.'/'.$room_))    //levelName existe.si roomName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_.'/'.$room_);
									/**/
									//if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$acadPeriod_for_this_room->name_period.'/'.$shiftName.'/'.$sectionName.'/'.$levelName.'/'.$roomName.'/'.$evalvuationPeriod_))    //roomName existe.si evalvuationPeriod n'existe pas, on le cree  
									//	 mkdir(Yii::app()->basePath . '/../'.$reportCard.$base.'/'.$acadPeriod_for_this_room->name_period.'/'.$shiftName.'/'.$sectionName.'/'.$levelName.'/'.$roomName.'/'.$evalvuationPeriod_);
									
								
								
								 $path_=$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_.'/'.$room_;
									 
								
								if($reportcard_structure==1) //One evaluation by Period
								  {
								       if($siges_structure==0)
								           $pdf_one_stud->Output($path_.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf', 'F');
								       elseif($siges_structure==1)
								          $pdf_one_stud->Output($path_.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf', 'F');
								       
								      $this->allowLink=true;
                                      
									  Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.').'<br/>'.Yii::t('app','You can download all reportcards at once by using the appropriate button below.'));									  
								                                      	
								   }
								elseif($reportcard_structure==2)  //Many evaluations in ONE Period
								   {
								       
								       if($siges_structure==0)
								            $pdf_one_stud->Output($path_.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf', 'F');
								       elseif($siges_structure==1)
								            $pdf_one_stud->Output($path_.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf', 'F');
								               
                                              $this->allowLink=true;	
												
											Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.').'<br/>'.Yii::t('app','You can download all reportcards at once by using the appropriate button below.'));
								     }
								
								
								
                                  
		 
                
	                             	                            
	                             }// end of if $this->student_id set
	                            
	                          
						    
						    }// end of if($all_validated)
						    
						    
						    
						    
						    
						    
						    
								
                    }// end of chak elev		
					    
			      
			      }
				   else
				     {  //$sum_weight = sumPeriodWeight($pastp,$);
				     	Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Sum period weight must equal 100.' ));
				     	
				     	}

			      
			      
			      }
			     else //no checked stud
			       {
			       	  $this->message=true;
			       	  }   
			       	  
			       	  
			       	  
			   }
			elseif(isset($_POST['view']))
			  {    //on vient de presser le bouton view
						 //reccuperer la ligne selectionnee()
					
				     $pastp = null;//array(); //pou denye evalyasyon nan chak peryod pase
				 	 $past_period = null; //pou evalyasyon ki pase deja nan yon peryod
				 	 $compter_p=1; //on compte deja the current period
				 	 $last_eval_=false; //par defaut, ce n;est pas la derniere evaluation pour cette periode
                     $eval_date=null;
                     $pass=true;
                     
				 	$pastEval = new Evaluations();
					$modEY = new EvaluationByYear;
						  
					if($reportcard_structure==1) //One evaluation by Period
					  {
					     if(isset($_POST['chk'])) 
					      {
						    if(isset($_POST['Evaluations']))//&&($_POST['Evaluations'])) 
						     {
						        	
					 			foreach($_POST['Evaluations'] as $r)
									{  if($r!=null)
									     { foreach($r as $id_eval_by_period)
									        {   if($pastp!=null)
									                $pastp = $pastp.',';
									             $pastp = $pastp.$id_eval_by_period;
									             
									        }
									     }
									}
									  
						     }
						      
						     foreach($_POST['chk'] as $val) 
						       {
									$this->student_id=$val;
									
							     //on retourne l'ID de l'eleve
								$this->redirect(array('reportcard/report?from=stud&pg=lr&pp='.$pastp.'&stud='.$this->student_id.'&shi='.$this->idShift.'&tot='.$this->tot_stud.'&sec='.$this->section_id.'&lev='.$this->idLevel.'&roo='.$this->room_id.'&ev='.$this->evaluation_id));		
							   
							    }//end foreach
							
						  }
						else //$_POST['chk'] not set
						   {
						      $this->messageView=true;
						      	
						   }
						   
						                                  	
					   }
					elseif($reportcard_structure==2) //(IMA) //Many evaluations in ONE Period
					   {
					        //getting past evaluation period
						  if(isset($_POST['EvaluationByYear'][1])&& !empty($_POST['EvaluationByYear'][1])) 
						     {	
			 	
						     	
					 			foreach($_POST['EvaluationByYear'][1] as $r)
									{  if($r!=null)
									      $pastp = $r;
									        
									 }
									     
						     }
											     
				 	
				 $last_eval_period = EvaluationByYear::model()->findByPk($this->evaluation_id);
         
		           if($last_eval_period->last_evaluation==1)
				      { 
				      	 $this->final_period=true; 
				           
				              //Extract use_period_weight 
							   $use_period_weight = infoGeneralConfig('use_period_weight');
							   
							   if($use_period_weight==1)
							    {
							    	//tcheke somme tout period yo
							    	 $sum_weight = sumPeriodWeight($pastp,$last_eval_period->id);
							    	
							    	 if( ($sum_weight!=100) && ($sum_weight!= -1) )
							    	   $pass=false;
							    	 
							     }
							     
							     
				          }
				          else
				           { $last_eval_date = EvaluationByYear::model()->getLastEvaluationDate($acad_sess);
				              if($last_eval_date!=null)
				                {  
				                	foreach($last_eval_date as $last_eval_date__)
				                	{
					                	if($last_eval_date__['evaluation_date']==$last_eval_period->evaluation_date)
					                	 {
					                	 	$this->final_period=true;
					                	 	//Extract use_period_weight 
											   $use_period_weight = infoGeneralConfig('use_period_weight');
											   
											   if($use_period_weight==1)
											    {
											    	//tcheke somme tout period yo
											    	 $sum_weight = sumPeriodWeight($pastp,$last_eval_period->id);
											    	
											    	 if( ($sum_weight!=100) && ($sum_weight!= -1) )
											    	   $pass=false;
								    	 
								                  }
					                	 	
					                	  }
				                	  }
				                  }
				           
				            }
						
						  //Extract school name 
							$school_name = infoGeneralConfig('school_name');
                        //Extract school address
				   			$school_address = infoGeneralConfig('school_address');
                        //Extract  email address 
                           $school_email_address = infoGeneralConfig('school_email_address');
                        //Extract Phone Number
                            $school_phone_number = infoGeneralConfig('school_phone_number');
                                                               
                       //reccuperer la ligne selectionnee()
	                 //il fo avoir toutes les lignes selectionnees  
 	
 	           if($pass==true)
 	             {
 	             	
					    if(isset($_POST['chk'])) {
						   	     						
							     //on retourne l'ID de l'eleve
								//$this->redirect(array('reportcard/report?stud='.$this->student_id.'&shi='.$this->idShift.'&tot='.$this->tot_stud.'&sec='.$this->section_id.'&lev='.$this->idLevel.'&roo='.$this->room_id.'&ev='.$this->evaluation_id));		
							     
								
								// create new PDF document
								$pdf = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app',"Report Card"));
								$pdf->SetSubject(Yii::t('app',"Report Card"));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, 21, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 12, '', true);
								
								
							//$pdf->startPageGroup();
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								//$pdf->AddPage();
								
			
								$banm_pase=0;	
							$period_acad_id = 0;
                            $period_exam_name = null;
	
						
                                  $STUDENT=array();
                                  $place=0;
									
									 $k=0;
									 $tot=1;
									 $tot_grade=0;
									$temoin_has_note=false;
                                    
                                      $this->tot_stud=$tot;

									  $max_grade=0;
     
                       
                         foreach($_POST['chk'] as $val) {
							 $array_past_period= array();
								  
									$this->student_id=$val;
							 $k=0;
							 $student='';
							
							 //check if all grades are validated for this stud		
								 $all_validated=$this->if_all_grades_validated($this->student_id,$this->evaluation_id);
								
								    $shiftName=$this->getShiftByStudentId($this->student_id)->shift_name;
									$sectionName=$this->getSectionByStudentId($this->student_id)->section_name;
									$levelName=$this->getLevelByStudentId($this->student_id)->level_name;
									$roomName=$this->getRoomByStudentId($this->student_id)->room_name;
									$acadPeriod_for_this_room=$this->getAcademicPeriodName_($acad_sess,$this->getRoomByStudentId($this->student_id)->id);
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id); 
							 
							          //eske se denye evalyasyon nan peryod sa a?
							          $last_eval_date=null;
							          $acad_year=0;
							          $array_past_period = array();
							            //find date of the current evaluation
									        $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
											   if(isset($result))
												 {  $result=$result->getData();//return a list of  objects
													 foreach($result as $r)
													   { 
															$eval_date = $r->evaluation_date;
															$acad_year = $r->academic_year;	   
														 }
													}
							          
							           $result_last=EvaluationByYear::model()->getLastEvaluationForAPeriod($acad_year, $acad_sess);
							             if(($result_last!=null))
											{  foreach($result_last as $r)
												 { $last_eval_date= $r["evaluation_date"];
													 break;			   
											        }
		        
											  }
									 //all past evaluations ASC order in athis period
									  $result_past=EvaluationByYear::model()->getPastEvaluationInAPeriod($acad_year, $acad_sess);
							             if(($result_last!=null))
											{  
												  foreach($result_past as $r)
												 {  if($r["id"]!= $this->evaluation_id)
												      $array_past_period[] = $r["id"];
											        }
											  }  
													
									       if($last_eval_date == $eval_date)
									          $last_eval_ = true; 
							          //si wi, jwenn ID lot evalyasyon ki pase nan peryod sa deja
							             if($last_eval_) 
							               { 
							               	 $past_period = $array_past_period;
							               	  }
							           
				
				
				
				
							          
							  
							  
							  if($all_validated)
								{	     

                                                   
								  if(isset($this->student_id))
								   {  
								   	  $STUDENT[]=$this->student_id;
								// To find period name in in evaluation by year 
                                                                
                                                        $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
                                                               // end of code 
								     
							        $student=$this->getStudent($this->student_id);
							        $room=$this->getRoomName($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
										   //[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
										  $dataProvider=$this->loadSubject($this->room_id,$this->idLevel);
							
								// Set some content to print
     $general_average_current_period =0;
     $max_grade_discipline=0;
     $include_discipline=0;
     
                               //Extract max grade of discipline
                               $max_grade_discipline = infoGeneralConfig('note_discipline_initiale');
				   				//Extract school Director
                                $include_discipline = infoGeneralConfig('include_discipline_grade');
     
     
     
     
     
     $data_current_period =null;	      
	   $p_name_general_average = EvaluationByYear::model()-> getPeriodNameByEvaluationDATE($eval_date);
			           
		   foreach($p_name_general_average as $p_na)
			 $data_current_period = $p_na;
		
																	      
    
    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }


      
						
						
						
						
						
$text=$evaluationPeriod.' : '.$period_exam_name.'                         '.$room.' / '.$section.' / '.$shift."   \n".Yii::t('app','Academic period: ').$name_acadPeriod_for_this_room;															                
								
$pdf->SetHeaderData('', '', $school_name, $text);			 
							  	$pdf->startPageGroup();
							     $pdf->AddPage();
							
							
								
							
	
								
								
																 
$general_average=0;
							
				
						
							
							$html = <<<EOD
 <style>
	
	div.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		//color: #1e5c8c;
        font-size: 22px;
		width:100%;
		text-align: center;
	}
	
	
.info{   font-size:11px;
         //height:30px;
         margin-bottom:-390px;
         padding-left:20px;
       background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
	 }
	
	table.signature {
		width:90%;
		float:right;
		font-size:10px;
		margin-top:55px;
		margin-bottom:5px;
		
	}
	
	.place{
	  font-size:6pt;
	}
	
	td.signature1 {
		
		
	}
	
	td.signature2 {
		
		
	}
	
	td.space {
		width:30%;
		
	}
	
	
 .corps{
	
	width:100%;
	background-color: #F5F6F7;
	
	}
	
.tb {
		
		width:90%;
	    
		//loat:right;
		
		font-size:10px;
				
	}
	
 .discipline {
		width:65%; 
		margin-top:20px;
		font-size:10px;
	}

		
 .subjectheadnote {
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			width:30%;
			
			}
			
			

.subjectheadnote_white_tr{
			
			background-color:#FFFFFF; 
	
			}
						
						
 .subject{
			color:#000; 
			width:22%;
			font-size:10px; 
			height:20px;
			font-weight: normal; //bold; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;
			}
		
 .color1{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}


 .color2	{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
	
 .sommes	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes1	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes2{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			border-top: 1px solid #EE6539;
			border-radius: 5px;
			background-color:  #EFEFEF;
			border-bottom: 1px solid #ecedf4;
			
		}

 .border	{
			
			border-bottom: 1px solid #ecedf4;
		}
			
.headnote {
		//width:10%;
		
	}
	
	
.periodsommes2{
		height:20px; 
		text-align: right;
			border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}
.periodsommes{
	height:20px;
	text-align: right; 	
	border-bottom: 1px solid #ecedf4;
	}

 .period {
		//width:10%;
		text-align: center;
	border-right: 1px solid #DADADA;
	border-bottom: 2px solid #ecedf4;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	}
	
 .period_head {
		//width:10%;
		text-align: center;
	border-right: 1px solid #DADADA;
	
	}
	
.child{
		//width:10%;
		text-align: center;
	border-right: 1px solid #ecedf4;
	border-bottom: 1px solid #ecedf4;
	}
	
td.comment{
		//width:10%;
		//text-align: center;
	border-right: 1px solid #ecedf4;
	border-bottom: 1px solid #ecedf4;
	}
	
.name_identity{
		//width:10%;
		text-align: right;
		font-style: italic;
		font-size:7px;
	//border-right: 1px solid #ecedf4;
	//border-bottom: 1px solid #ecedf4;
	background-color: #FFF;
	
	}

.periodParent {
		width:10%;
		text-align: center;
		font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodsommes2_red{
		width:10%;
		text-align: center;
		border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}	
	
.periodheadnote {
		width:10%;
		font-size:9px;
	
	}

.subjectParent{
	//text-transform: uppercase; //capitalize; //|uppercase|lowercase|initial|inherit|none;
	width:22%;
	height:15px;
	font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	
			
	}
	

			
div > .subject {
		width:22%;
		 text-indent: 17px;
		 font-weight: normal; //bold; 
		
	}
	
.subject_single{
		    color:#000;
		    width:22%; 
			font-size:10px; 
			height:20px;
			font-weight:bold;
			text-indent: 0px; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;	
	}	
	
	
</style>
                                       
										
EOD;


	 
				   						
		$html .='<div class="info" > <b>'.Yii::t('app','Name: ').'</b> '.$student.'</div>';
														  
  														    
        
        $html .='<div class="corps">    <br/>'; 
  
                                                      
			 
		// debut of cases depending on past period	   

if($last_eval_)
{ //find date of the current evaluation
 $last_eval_date_for_each_period= array();
 $period_id_and_average[]= array();
 
 						          
	$result_last=EvaluationByYear::model()->getLastEvaluationForEachPeriod($acad_sess);
	 if(($result_last!=null))
	  {  foreach($result_last as $r)
		  { $last_eval_date_for_each_period[]= $r["academic_year"]; //ID academic period la
	 			  
			}
											     
		}
      
  }
                   
            
																	
$i=0;
											            
$old_parent='';
$all_eval_period= '';//array();

											            
$result_last2=EvaluationByYear::model()->getLastEvaluationForEachPeriod($acad_sess);
				if(($result_last2!=null))
				  {  foreach($result_last2 as $r)
					   { 
						
							  
							  $all_eval_period[]= $r["academic_year"]; 
							  
							 			   
						}
					}
					

	
					
	$moy=null;
    						            
while(isset($dataProvider[$k][0]))
	{
		$_grade=0;														  
		if($i==2)
		  $i=0;
		if($i==0)
		  $class="color1";
		 elseif($i==1)
		   $class="color2";
																				  
																//$line=
if($dataProvider[$k][3]!=null)
  {  
  	  $parent_name ='';
  	  $grade_total=0;
  	  $weight_total=0;

  	  
  	  $subject_parent_name = Subjects::model()->getSubjectNameBySubjectID($dataProvider[$k][3]);
  	  $subject_parent_name = $subject_parent_name->getData();
  	  
  	  $class_child="subject";
  	  
  	    foreach($subject_parent_name as $subject_parent)
  	       $parent_name = $subject_parent;
  	  
 	   
  	    if($old_parent!= $dataProvider[$k][3]) // ON CHANGE DE MATIERE PARENTE                     
  	     {  
  	     	if($moy!=null)
  	     	  {
   //---RESULTAT FINAL POUR LA PERIODE---------------------------------------------------------   	     	  	 
  	     	  	 $html .='<tr class="'.$class.'"> <td class="child"  style="font-weight:bold;" > '.Yii::t('app', 'Result').' </td>';
  	     	  	     foreach($all_eval_period as $eval_period )
		  	           {   $data1='';
		  	               $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       
		  	           	       //colspan="'.$num_eval.'"
		  	           	      
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
		  	           	           
		  	           	           $grade= $this->getResultForReportSubjectParent($this->student_id,$old_parent, $data1["evaluation_date"],$this->room_id, $acad_sess);
		  	           	            $html .=' <td class="child" ><b> '.$grade.' </b></td>'; 
		  	           	        }
		  	           	        
		  	           	     
		  	             }
  	     	  	 
  	     	  	 $html .='</tr>';
   //---MOYENNE DE LA CLASSE POUR LA PERIODE---------------------------------------------------------   	     	  	 
  	     	  	 $html .='<tr class="'.$class.'"> <td class="child"  style="font-weight:bold;" > '.Yii::t('app', 'Class Average').' </td>';
  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {   $data1='';
		  	               $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       
		  	           	      
		  	           	      
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
		        
		  	           	          $course_average = $this->getCourseAverageForReportSubjectParent($old_parent, $data1["evaluation_date"],$this->room_id, $acad_sess);
		  	           	            $html .=' <td class="child" ><b> '.$course_average.' </b></td>'; 
		  	           	        }
		  	           	        
		  	           	     
		  	             }
  	     	  	 
  	     	  	 
  	     	  	 $html .='</tr>';
  	     	  	 
   //---COMMENTAIRE DU PROFESSEUR---------------------------------------------------------   	  	 
  	     	  	 
  	     	  	 //jwenn kantite kolonn nap genyen
  	     	  	 $kantite_kolonn=0;
  	     	  	 
  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {
		  	           	    $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $num_eval= EvaluationByYear::model()->getNumberEvaluationInAPeriod($eval_period, $acad_sess);
		  	           	         if($num_eval==null) $num_eval=1;
		  	           	         
		  	           	       $kantite_kolonn = $kantite_kolonn + $num_eval;  
		  	           	   }
		  	           	  
		
			     $html .='<tr class=""> <td class="" style="background-color:#DDDDDD;" colspan="'.($kantite_kolonn+1).'"> </td></tr>';
  	     	  	 $html .='<tr class="'.$class.'"> <td class="comment" style="text-align:center; font-weight:bold;"  colspan="'.($kantite_kolonn+1).'" > '.Yii::t('app', 'Teacher\'s comments').' </td> </tr>';
	  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {
		  	           	     $comments = '';
		  	           	    $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      $html .='<tr class="comment">  <td class="comment" style="font-weight:bold;"  > '.strtoupper(strtr($data["name_period"], pa_daksan() )).' </td> <td class="comment" colspan="'.$kantite_kolonn.'" style="" ><br/>';
		  	           	     
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       //pou chak evalyasyon ki nan peryod sa, ki komante pwof la fe pou chak kou
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
	                                
	                                
		  	           	          $comment = $this->getCoursesCommentsForEachEvalperiodBySubjectParent($this->student_id,$old_parent, $data1["id_by_year"],$this->room_id, $acad_sess);
		  	           	           
		  	           	           if($comment!='')
		  	           	             $comments = $comments.'<br/>'.$comment;  
		  	           	        }
		  	           	        
		  	           	        $html .= $comments;
		  	           	      
		  	           	      $html .='<br/></td></tr>';   
		  	           	  }
     $html .='<tr class=""> <td class="name_identity" colspan="'.($kantite_kolonn+1).'"> '.$student.'</td></tr>';
  	     	  	 $html .='</table> <br/><br/><br/>';
  	//---END TABLE-------------------------------------------------     	  	
  	     	  	$moy=null;
  	     	  	}
  	
  	
  	//----TABLE START----------------------------------------------     
  	         $html .='<table class="tb">';
  	       	     	
  	       $html .='<tr  class="'.$class.'"  > <td class="subjectParent"  > '.strtoupper(strtr($parent_name->subject_name, pa_daksan() )).'  </td>';
  	          foreach($all_eval_period as $eval_period )
  	           {
  	           	    $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $num_eval= EvaluationByYear::model()->getNumberEvaluationInAPeriod($eval_period, $acad_sess);
  	           	       if($num_eval==null) $num_eval=1;
  	           	      //colspan="'.$num_eval.'"
  	           	      $html .=' <td class="period_head" colspan="'.$num_eval.'"  style="font-weight:bold;" > '.strtoupper(strtr($data["name_period"], pa_daksan() )).' </td>';   
  	           	  }
  	  	       
  	       $html .=' </tr>';
  	       
  	       $html .='<tr class="'.$class.'"> <td class="subjectParent"> </td>';	  
  	       	
  	       	 foreach($all_eval_period as $eval_period )
  	           {   $data1='';
  	               $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
  	           	       
  	           	       //colspan="'.$num_eval.'"
  	           	      
  	           	      foreach($data_eval as $data_e )
  	           	        { $data1= $data_e;
  	           	           
  	           	            $html .=' <td class="period" > '.$data1["evaluation_name"].' </td>'; 
  	           	        }
  	           	        
  	           	     
  	             }
  	        $html .=' </tr>';	
  	     	
  	        
  	        $html .='<tr class="'.$class.'"> ';
  	       	$html .=' <td class="'.$class_child.'" > '.$dataProvider[$k][1].' </td>';
  	       	
  	       	  foreach($all_eval_period as $eval_period )
  	           {   $data1='';
  	               $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
  	           	       
  	           	       //colspan="'.$num_eval.'"
  	           	      
  	           	      foreach($data_eval as $data_e )
  	           	        { $data1= $data_e;
  	           	           $grade= Grades::model()->getGradeByStudentCourseEvaluation_id($this->student_id,$dataProvider[$k][0], $data1["evaluation_date"], $acad_sess);
  	           	            $html .=' <td class="child" > '.$grade.'/'.$dataProvider[$k][2].' </td>'; 
  	           	        }
  	           	        
  	           	     
  	             }
 
            $html .=' </tr>';         
            $moy=$dataProvider[$k][1];
  	         $old_parent = $dataProvider[$k][3];
  	       }
  	     else
  	       {
  	       	
  	        $html .='<tr class="'.$class.'"> ';
  	       	$html .=' <td class="'.$class_child.'" > '.$dataProvider[$k][1].' </td>'; 
  	       	   foreach($all_eval_period as $eval_period )
  	           {   $data1='';
  	               $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
  	           	       
  	           	       
  	           	      
  	           	      foreach($data_eval as $data_e )
  	           	        { $data1= $data_e;
  	           	           $grade= Grades::model()->getGradeByStudentCourseEvaluation_id($this->student_id,$dataProvider[$k][0], $data1["evaluation_date"], $acad_sess);
  	           	            $html .=' <td class="child" > '.$grade.'/'.$dataProvider[$k][2].' </td>'; 
  	           	        }
  	           	        
  	           	     
  	             }
 
            $html .=' </tr>';
            
            $moy=$dataProvider[$k][1];
  	       	}
  	  
  	 
     }
  else
     {
     	   $class_child="subject_single";
     	   
        if($old_parent!= $dataProvider[$k][3])
  	     {   
  	     	if($moy!=null)
  	     	  {
   //---RESULTAT FINAL POUR LA PERIODE---------------------------------------------------------   	     	  	 
  	     	  	 $html .='<tr class="'.$class.'"> <td class="child"  style="font-weight:bold;" > '.Yii::t('app', 'Result').' </td>';
  	     	  	     foreach($all_eval_period as $eval_period )
		  	           {   $data1='';
		  	               $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       
		  	           	     
		  	           	      
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
		  	           	           
		  	           	           $grade= $this->getResultForReportSubjectParent($this->student_id,$old_parent, $data1["evaluation_date"],$this->room_id, $acad_sess);
		  	           	            $html .=' <td class="child" ><b> '.$grade.' </b></td>'; 
		  	           	        }
		  	           	        
		  	           	     
		  	             }
  	     	  	 
  	     	  	 $html .='</tr>';
   //---MOYENNE DE LA CLASSE POUR LA PERIODE---------------------------------------------------------   	     	  	 
  	     	  	 $html .='<tr class="'.$class.'"> <td class="child"  style="font-weight:bold;" > '.Yii::t('app', 'Class Average').' </td>';
  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {   $data1='';
		  	               $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       
		  	           	       //colspan="'.$num_eval.'"
		  	           	      
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
		        
		  	           	          $course_average = $this->getCourseAverageForReportSubjectParent($old_parent, $data1["evaluation_date"],$this->room_id, $acad_sess);
		  	           	            $html .=' <td class="child" ><b> '.$course_average.' </b></td>'; 
		  	           	        }
		  	           	        
		  	           	     
		  	             }
  	     	  	 
  	     	  	 
  	     	  	 $html .='</tr>';
  	     	  	 
   //---COMMENTAIRE DU PROFESSEUR---------------------------------------------------------   	  	 
  	     	  	 
  	     	  	 //jwenn kantite kolonn nap genyen
  	     	  	 $kantite_kolonn=0;
  	     	  	 
  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {
		  	           	    $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $num_eval= EvaluationByYear::model()->getNumberEvaluationInAPeriod($eval_period, $acad_sess);
		  	           	         if($num_eval==null) $num_eval=1;
		  	           	         
		  	           	       $kantite_kolonn = $kantite_kolonn + $num_eval;  
		  	           	   }
		  	           	  
		
			     $html .='<tr class=""> <td class="" style="background-color:#DDDDDD;" colspan="'.($kantite_kolonn+1).'"> </td></tr>';
  	     	  	 $html .='<tr class="'.$class.'"> <td class="comment" style="text-align:center; font-weight:bold;"  colspan="'.($kantite_kolonn+1).'" > '.Yii::t('app', 'Teacher\'s comments').' </td> </tr>';
	  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {
		  	           	     $comments = '';
		  	           	    $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      $html .='<tr class="comment">  <td class="comment" style="font-weight:bold;"  > '.strtoupper(strtr($data["name_period"], pa_daksan() )).' </td> <td class="comment" colspan="'.$kantite_kolonn.'" style="" ><br/>';
		  	           	     
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       //pou chak evalyasyon ki nan peryod sa, ki komante pwof la fe pou chak kou
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
	                                
	                                
		  	           	          $comment = $this->getCoursesCommentsForEachEvalperiodBySubjectParent($this->student_id,$old_parent, $data1["id_by_year"],$this->room_id, $acad_sess);
		  	           	           
		  	           	           if($comment!='')
		  	           	             $comments = $comments.'<br/>'.$comment;  
		  	           	        }
		  	           	        
		  	           	        $html .= $comments;
		  	           	      
		  	           	      $html .='<br/></td></tr>';   
		  	           	  }
      $html .='<tr class=""> <td class="name_identity" colspan="'.($kantite_kolonn+1).'"> '.$student.'</td></tr>';
  	     	  	  $html .='</table> <br/><br/><br/>';
  	//---END TABLE-------------------------------------------------     	  	
  	     	  	$moy=null;
  	     	  	
  	          }
  	     	
  	     	
  	     	  	
 //###############   PREMYE MATYE APRE MATYE PARAN YO    ##############################// 	
  	//----TABLE START----------------------------------------------     
  	         $html .='<table class="tb">';
  	       	     	
  	       $html .='<tr  class="'.$class.'"  > <td class="subjectParent"  > '.$dataProvider[$k][1].'  </td>';
  	          foreach($all_eval_period as $eval_period )
  	           {
  	           	    $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $num_eval= EvaluationByYear::model()->getNumberEvaluationInAPeriod($eval_period, $acad_sess);
  	           	       if($num_eval==null) $num_eval=1;
  	           	      
  	           	      $html .=' <td class="period_head" colspan="'.$num_eval.'"  style="font-weight:bold;" > '.strtoupper(strtr($data["name_period"], pa_daksan() )).' </td>';   
  	           	  }
  	  	       
  	       $html .=' </tr>';
  	       
  	       $html .='<tr class="'.$class.'"> <td class="subjectParent"> </td>';	  
  	       	
  	       	 foreach($all_eval_period as $eval_period )
  	           {   $data1='';
  	               $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
  	           	       
  	           	       //colspan="'.$num_eval.'"
  	           	      
  	           	      foreach($data_eval as $data_e )
  	           	        { $data1= $data_e;
  	           	           
  	           	            $html .=' <td class="period" > '.$data1["evaluation_name"].' </td>'; 
  	           	        }
  	           	        
  	           	     
  	             }
  	        $html .=' </tr>';	
  	            
            $moy=$dataProvider[$k][1];
  	         
           $old_parent = $dataProvider[$k][3];

















           
  	     }
  	    else
  	     {   // @@@@@@@@@@@@@   A PARTIR DES NI PARENTES NI FILLES, ON UTILISE L'INDICE (K-1) POUR LA PARTIE RESULTAT   @@@@@@@@@@@@//
  	     	if($moy!=null)
  	     	  {
   //---RESULTAT FINAL POUR LA PERIODE---------------------------------------------------------   	     	  	 
  	     	  	 $html .='<tr class="'.$class.'"> <td class="child"  style="font-weight:bold;" > '.Yii::t('app', 'Result').' </td>';
  	     	  	      foreach($all_eval_period as $eval_period )
  	           {   $data1='';
  	               $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
  	           	       
  	           	      
  	           	      
  	           	      foreach($data_eval as $data_e )
  	           	        { $data1= $data_e;
  	           	           $grade= Grades::model()->getGradeByStudentCourseEvaluation_id($this->student_id,$dataProvider[($k-1)][0], $data1["evaluation_date"], $acad_sess);
  	           	            $html .=' <td class="child" > '.$grade.'/'.$dataProvider[($k-1)][2].' </td>'; 
  	           	        }
  	           	        
  	           	     
  	             }

  	     	  	 
  	     	  	 $html .='</tr>';
   //---MOYENNE DE LA CLASSE POUR LA PERIODE---------------------------------------------------------   	     	  	 
  	     	  	 $html .='<tr class="'.$class.'"> <td class="child"  style="font-weight:bold;" > '.Yii::t('app', 'Class Average').' </td>';
  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {   $data1='';
		  	               $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       
		  	           	       
		  	           	      
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
		        
		  	           	          $course_average = $this->getCourseAverageForReportSubjectSimple($dataProvider[($k-1)][0], $data1["evaluation_date"],$this->room_id, $acad_sess);
		  	           	            $html .=' <td class="child" ><b> '.$course_average.' </b></td>'; 
		  	           	        }
		  	           	        
		  	           	     
		  	             }
  	     	  	 
  	     	  	 
  	     	  	 $html .='</tr>';
  	     	  	 
   //---COMMENTAIRE DU PROFESSEUR---------------------------------------------------------   	  	 
  	     	  	 
  	     	  	 //jwenn kantite kolonn nap genyen
  	     	  	 $kantite_kolonn=0;
  	     	  	 
  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {
		  	           	    $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $num_eval= EvaluationByYear::model()->getNumberEvaluationInAPeriod($eval_period, $acad_sess);
		  	           	         if($num_eval==null) $num_eval=1;
		  	           	         
		  	           	       $kantite_kolonn = $kantite_kolonn + $num_eval;  
		  	           	   }
		  	           	  
		
			     $html .='<tr class=""> <td class="" style="background-color:#DDDDDD;" colspan="'.($kantite_kolonn+1).'"> </td></tr>';
  	     	  	 $html .='<tr class="'.$class.'"> <td class="comment" style="text-align:center; font-weight:bold;"  colspan="'.($kantite_kolonn+1).'" > '.Yii::t('app', 'Teacher\'s comments').' </td> </tr>';
	  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {
		  	           	     $comments = '';
		  	           	    $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      $html .='<tr class="comment">  <td class="comment" style="font-weight:bold;"  > '.strtoupper(strtr($data["name_period"], pa_daksan() )).' </td> <td class="comment" colspan="'.$kantite_kolonn.'" style="" ><br/>';
		  	           	     
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       //pou chak evalyasyon ki nan peryod sa, ki komante pwof la fe pou chak kou
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
	                                
	                                
		  	           	          $comment = $this->getCoursesCommentsForEachEvalperiodBySubjectSimple($this->student_id,$dataProvider[($k-1)][0], $data1["id_by_year"],$this->room_id, $acad_sess);
		  	           	           
		  	           	           if($comment!='')
		  	           	             $comments = $comments.'<br/>'.$comment;  
		  	           	        }
		  	           	        
		  	           	        $html .= $comments;
		  	           	      
		  	           	      $html .='<br/></td></tr>';   
		  	           	  }
    $html .='<tr class=""> <td class="name_identity" colspan="'.($kantite_kolonn+1).'"> '.$student.'</td></tr>';
  	     	  	  $html .='</table> <br/><br/><br/>';
  	//---END TABLE-------------------------------------------------  
  	  	     	  	$moy=null;
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	  	     	  	
  	     	  	}
  	     	
  	    //###############   TOUT RES MATYE KI VIN APRE PREMYE MATYE APRE MATYE PARAN YO    ##############################// 	
  	//----TABLE START----------------------------------------------     
  	         $html .='<table class="tb">';
  	       	     	
  	       $html .='<tr  class="'.$class.'"  > <td class="subjectParent"  > '.$dataProvider[$k][1].'  </td>';
  	          foreach($all_eval_period as $eval_period )
  	           {
  	           	    $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $num_eval= EvaluationByYear::model()->getNumberEvaluationInAPeriod($eval_period, $acad_sess);
  	           	       if($num_eval==null) $num_eval=1;
  	           	      
  	           	      $html .=' <td class="period_head" colspan="'.$num_eval.'"  style="font-weight:bold;" > '.strtoupper(strtr($data["name_period"], pa_daksan() )).' </td>';   
  	           	  }
  	  	       
  	       $html .=' </tr>';
  	       
  	       $html .='<tr class="'.$class.'"> <td class="subjectParent"> </td>';	  
  	       	
  	       	 foreach($all_eval_period as $eval_period )
  	           {   $data1='';
  	               $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
  	           	       
  	           	       //colspan="'.$num_eval.'"
  	           	      
  	           	      foreach($data_eval as $data_e )
  	           	        { $data1= $data_e;
  	           	           
  	           	            $html .=' <td class="period" > '.$data1["evaluation_name"].' </td>'; 
  	           	        }
  	           	        
  	           	     
  	             }
  	        $html .=' </tr>';	
  	            
            
                  $moy=9;
  	     }
  	    	       	   
  	     
      }			
															
			$i++;
														       						                                        
            $k=$k+1;
			
	}
														
 	  
  	     	if($moy!=null)
  	     	  {  //###############  POU DENYE MATYE KI PA MATYE PARAN    ##############################// 
   //---RESULTAT FINAL POUR LA PERIODE---------------------------------------------------------   	     	  	 
  	     	  	 $html .='<tr class="'.$class.'"> <td class="child"  style="font-weight:bold;" > '.Yii::t('app', 'Result').' </td>';
  	     	  	      foreach($all_eval_period as $eval_period )
  	           {   $data1='';
  	               $data='';
  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
  	           	    foreach($eval as $eval_ )
  	           	      $data= $eval_;
  	           	      
  	           	      //get num eval in this period
  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
  	           	       
  	           	      
  	           	      
  	           	      foreach($data_eval as $data_e )
  	           	        { $data1= $data_e;
  	           	           $grade= Grades::model()->getGradeByStudentCourseEvaluation_id($this->student_id,$dataProvider[($k-1)][0], $data1["evaluation_date"], $acad_sess);
  	           	            $html .=' <td class="child" > '.$grade.'/'.$dataProvider[($k-1)][2].' </td>'; 
  	           	        }
  	           	        
  	           	     
  	             }

  	     	  	 
  	     	  	 $html .='</tr>';
   //---MOYENNE DE LA CLASSE POUR LA PERIODE---------------------------------------------------------   	     	  	 
  	     	  	 $html .='<tr class="'.$class.'"> <td class="child"  style="font-weight:bold;" > '.Yii::t('app', 'Class Average').' </td>';
  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {   $data1='';
		  	               $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       
		  	           	       
		  	           	      
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
		        
		  	           	          $course_average = $this->getCourseAverageForReportSubjectSimple($dataProvider[($k-1)][0], $data1["evaluation_date"],$this->room_id, $acad_sess);
		  	           	            $html .=' <td class="child" ><b> '.$course_average.' </b></td>'; 
		  	           	        }
		  	           	        
		  	           	     
		  	             }
  	     	  	 
  	     	  	 
  	     	  	 $html .='</tr>';
  	     	  	 
   //---COMMENTAIRE DU PROFESSEUR---------------------------------------------------------   	  	 
  	     	  	 
  	     	  	 //jwenn kantite kolonn nap genyen
  	     	  	 $kantite_kolonn=0;
  	     	  	 
  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {
		  	           	    $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      //get num eval in this period
		  	           	       $num_eval= EvaluationByYear::model()->getNumberEvaluationInAPeriod($eval_period, $acad_sess);
		  	           	         if($num_eval==null) $num_eval=1;
		  	           	         
		  	           	       $kantite_kolonn = $kantite_kolonn + $num_eval;  
		  	           	   }
		  	           	  
		
			     $html .='<tr class=""> <td class="" style="background-color:#DDDDDD;" colspan="'.($kantite_kolonn+1).'"> </td></tr>';
  	     	  	 $html .='<tr class="'.$class.'"> <td class="comment" style="text-align:center; font-weight:bold;"  colspan="'.($kantite_kolonn+1).'" > '.Yii::t('app', 'Teacher\'s comments').' </td> </tr>';
	  	     	  	 foreach($all_eval_period as $eval_period )
		  	           {
		  	           	     $comments = '';
		  	           	    $data='';
		  	           	   $eval = EvaluationByYear::model()->getPeriodNameByPeriodID($eval_period);
		  	           	    foreach($eval as $eval_ )
		  	           	      $data= $eval_;
		  	           	      
		  	           	      $html .='<tr class="comment">  <td class="comment" style="font-weight:bold;"  > '.strtoupper(strtr($data["name_period"], pa_daksan() )).' </td> <td class="comment" colspan="'.$kantite_kolonn.'" style="" ><br/>';
		  	           	     
		  	           	      //get num eval in this period
		  	           	       $data_eval= EvaluationByYear::model()->getEvaluationDataInPeriodID($eval_period);
		  	           	       //pou chak evalyasyon ki nan peryod sa, ki komante pwof la fe pou chak kou
		  	           	      foreach($data_eval as $data_e )
		  	           	        { $data1= $data_e;
	                                
	                                
		  	           	          $comment = $this->getCoursesCommentsForEachEvalperiodBySubjectSimple($this->student_id,$dataProvider[($k-1)][0], $data1["id_by_year"],$this->room_id, $acad_sess);
		  	           	           
		  	           	           if($comment!='')
		  	           	             $comments = $comments.'<br/>'.$comment;  
		  	           	        }
		  	           	        
		  	           	        $html .= $comments;
		  	           	      
		  	           	      $html .='<br/></td></tr>';   
		  	           	  }
    $html .='<tr class=""> <td class="name_identity" colspan="'.($kantite_kolonn+1).'"> '.$student.'</td></tr>';
  	     	  	  $html .='</table> <br/><br/><br/>';
  	//---END TABLE-------------------------------------------------  
  	     	  	$moy=null;
  	     	  	
  	     	  	}
  	     	 
	     							 
                               
                                      
                                      
                                      $pdf->writeHTML($html, true, false, true, false, '');
                                      

	                              
	                             	                            
	                             }// end of if $this->student_id set
	                            
	                          
						    
						    }// end of if($all_validated)
						    
						    
                         	    
						    
						    
						    
						    
								
                    }// end of chak elev		
					       												   
                   //___________________________________________________________________//    
                       
               $pdf->Output($eval_date.'.pdf', 'D');
                                  /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/

								//============================================================+
								// END OF FILE
								//============================================================+		

					         }
					         
					 }
				   else
				     {  //$sum_weight = sumPeriodWeight($pastp,$);
				     	Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Sum period weight must equal 100.' ));
				     	
				     	}  
					    
					    
					                                          	
					     }  
					     
					   
			      
				   
			  }
			elseif(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
		
		
		$this->render('create',array(
			'model'=>$model,
		));
		
	}


 		


public function htmlReportcard1($dataProvider,$tot_grade,$student,$pastp,$k,$place,$max_grade,$acad,$temoin_has_note,$evaluationPeriod,$period_exam_name,$level,$room,$section,$shift,$name_acadPeriod_for_this_room,$tot)
	{
		$siges_structure = infoGeneralConfig('siges_structure_session');
		
		$acad_=Yii::app()->session['currentId_academic_year']; 
		
		 $this->summary = false;
		 
		
		if((isset($_POST['summary']))&&($_POST['summary']==true)) 
		    $this->summary = true;
   
    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad_!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }

      
								   								
	 $general_average_current_period =0;
     $max_grade_discipline=0;
     $include_discipline=0;
     $include_place = 1;
     $average_base =0;
     
				                               //Extract max grade of discipline
				                              $max_grade_discipline = infoGeneralConfig('note_discipline_initiale');
								   				//Extract school Director
				                               $include_discipline = infoGeneralConfig('include_discipline_grade');
				                               //Extract school Director
				                               $tardy_absence_display = infoGeneralConfig('tardy_absence_display');
				                               //Extract include_place
				                               $include_place = infoGeneralConfig('include_place');
								   				
								   				//Extract average base
				                                $average_base = infoGeneralConfig('average_base');
				                                
				                                //Extract observation line
				                                $show_observation_line = infoGeneralConfig('observation_line');
				                                
				                                //Extract student code
				                                $display_student_code = infoGeneralConfig('display_student_code');
				                                
				                                 //Extract display_administration_signature
				                                $display_administration_signature = infoGeneralConfig('display_administration_signature');
				                               
				                                //Extract display_parent_signature
				                                $display_parent_signature = infoGeneralConfig('display_parent_signature');
				                              
				                                //Extract administration_signature_text
				                                $administration_signature_text = infoGeneralConfig('administration_signature_text');
				                               
				                                //Extract parent_signature_text
				                                $parent_signature_text = infoGeneralConfig('parent_signature_text');
				                               
				                                 //Extract display_created_date
				                                $display_created_date = infoGeneralConfig('display_created_date');
				                                
				                                //Extract display_class_enroll
				                                $display_class_enroll = infoGeneralConfig('display_class_enroll');
				                               
				                                //Extract display_period_summary
				                                $display_period_summary = infoGeneralConfig('display_period_summary');
				                                
				                                //Extract use_period_weight
				                                $use_period_weight = infoGeneralConfig('use_period_weight');
				                                
				                                //Extract use_period_weight
				                                $use_period_weight = infoGeneralConfig('use_period_weight');

				     
     
     $eval_date = null;
			                   $acad_year = null;
			                    


                  //find date of the current evaluation
						$result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
							if(isset($result))
							 {  $result=$result->getData();//return a list of  objects
								 foreach($result as $r)
								   { $eval_date = $r->evaluation_date;
									  $acad_year = $r->academic_year;	   
									}
							   }
 
     
     
       $data_current_period =null;	      
	   $p_name_general_average = EvaluationByYear::model()-> getPeriodNameByEvaluationDATE($eval_date);
			           
		   foreach($p_name_general_average as $p_na)
			 $data_current_period = $p_na;
		


							
							
							$html = <<<EOD
 <style>
	
	
.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		//color: #1e5c8c;
        font-size: 16px;
		width:100%;
		text-align: center;
		
		 
	   }
	
	
.info{   font-size:10px;
      background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
	 }
		
 .corps{
	 
	width:100%;
	background-color: #F5F6F7;
	
	}

		
table.signature {
		width:90%;
		float:right;
		font-size:10px;
		margin-top:55px;
		margin-bottom:5px;
		
	}
	
.place{
	  font-size:6pt;
	}
	
	td.signature1 {
		
		
	}
	
	td.signature2 {
		
		
	}
	
	td.space {
		width:30%;
		
	}

.tb {
		
		width:100%;
	    
		//loat:right;
		
		font-size:10px;
				
	}
	
 .discipline {
		width:65%; 
		margin-top:20px;
		font-size:10px;
	}

		
 .subjectheadnote {
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			width:30%;
			
			}
			
			

.subjectheadnote_white_tr{
			
			background-color:#FFFFFF; 
	
			}
						
						
 .subject{
			color:#000; 
			font-size:10px; 
			height:20px;
			font-weight: normal; //bold; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;
			}
		
 .color1{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}


 .color2	{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
	
 .sommes	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes1	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes2{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			border-top: 1px solid #EE6539;
			border-radius: 5px;
			background-color:  #EFEFEF;
			border-bottom: 1px solid #ecedf4;
			
		}

 .border	{
			
			border-bottom: 1px solid #ecedf4;
		}
			
.headnote {
		//width:10%;
		
	}
	
	
.periodsommes2{
		height:20px; 
		text-align: right;
			border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}
.periodsommes{
	height:20px;
	text-align: right; 	
	border-bottom: 1px solid #ecedf4;
	}
 .period {
		width:10%;
		text-align: center;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodParent {
		width:10%;
		text-align: center;
		font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodsommes2_red{
		width:10%;
		text-align: center;
		border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}	
	
.periodheadnote {
		width:10%;
		font-size:9px;
	
	}

.subjectParent{
	//text-transform: uppercase; //capitalize; //|uppercase|lowercase|initial|inherit|none;
	height:15px;
	font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	
			
	}
	

			
div > .subject {
		width:30%;
		 text-indent: 10px;
		 font-weight: normal; //bold; 
		
	}
	
.subject_single{
		    color:#000; 
			font-size:10px; 
			height:20px;
			font-weight:bold;
			text-indent: 0px; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;	
	}	
		
	
	
</style>
                                       
										
EOD;
	 
				   						 
										$html .='<span class="title" >'.strtoupper(Yii::t("app","Report Card ")).'</span>
										<div class="info" >  <b>'.Yii::t('app','Name: ').'</b> '.$student.'    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>';
										  if($siges_structure==0)
											  $html .= $evaluationPeriod.' : </b>'.$period_exam_name;
										  elseif($siges_structure==1)
										      $html .= $period_exam_name.' : </b>'.$evaluationPeriod;
									
									if($display_student_code==1)
									   {   $code=''; 
									     	//return id_number, gender,is_student,nif_cin,email,phone,adresse
                                             $flashInfo= Persons::model()->getFlashInfoById($this->student_id);
                                               foreach($flashInfo as $r)
                                                 {
                                                 	$code = $r['id_number'];
                                                 	}
									   	
									   	 $html .='<br/> <b>  '.Yii::t('app', 'Id Number').': </b>'.$code;
									    }
									     
										$html .='<br/> <b>  '.Yii::t('app','Level / Room: ').'</b> '.$level.' / '.$room.'<br/>  <b>  '.Yii::t('app','Section / Shift: ').'</b> '.$section.' / '.$shift.'   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										
										if($display_class_enroll==0)
										     $html .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										     	
										
										
										$html .= '<b>'.Yii::t('app','Academic period: ').'</b> '.$name_acadPeriod_for_this_room;
										
								if($display_class_enroll==1)
										     $html .=' / <b>'.Yii::t('app','Number of students: ').'</b> '.$tot;
										
										$html .=' </div>
														    
                                                      <div class="corps">    
															<table class="tb"> 
                                                                     													  
														             <tr><td class="subjectheadnote"></td>';
														             
					
			 //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		// debut of cases depending on past period	   
			                    $eval_period='';
			                    $compter_p=1;
			                     if($pastp!=null)
				                     {  
					                   foreach($pastp as $id_past_period)
					                      {
			 	                                $compter_p++;
			 	                                //$eval_period = $this->searchPeriodName($id_past_period);
			 	                                $period=ReportCard::searchPeriodNameForReportCard($id_past_period);
			 	                                
										       if($use_period_weight==1)                 
												 $html .='<td class="periodheadnote" > <span style="font-size:8pt; text-align:center;"> <b>'.$period->name_period.'</b><br/>('.$period->weight.'%)  </span> </td>';
											   else
											     $html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$period->name_period.'</b>  </span> </td>';
																		
											}
											//for the current period
											//$eval_period=$this->searchPeriodName($this->evaluation_id);
											$period=ReportCard::searchPeriodNameForReportCard($this->evaluation_id);
											
											if($use_period_weight==1)
											  $html .='<td class="periodheadnote" > <span style="font-size:8pt; text-align:center;"> <b>'.$period->name_period.'</b><br/>('.$period->weight.'%) </span> </td>'; 
											else
											  $html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$period->name_period.'</b> </span> </td>';
											 
											//$html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$evaluationPeriod.'-'.$period_exam_name.'</b> </span> </td>';
											
								       } 
								    else  //for the current period
									{      $eval_period=$this->searchPeriodName($this->evaluation_id);
									
										$html .='<td class="periodheadnote" > <span style="font-size:8pt; text-align:center;"> <b>'.$period_exam_name.'</b> </span> </td>'; 
										 //$html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$evaluationPeriod.'</b> </span> </td>';
								    }							      
									//fin ajout  
									$compter_p=$compter_p+2; 
									
									if(($display_period_summary ==1) && ($this->summary == true) )
									 {
										$html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.Yii::t('app','Summary ').'</b> </span> </td>';
										$compter_p++;
									   }         
											$html .=' <td class="periodheadnote" >  <b>'.Yii::t('app','MAX GRADE').'</b>  </td></tr><tr class=""><td ></td></tr>																 
																	 ';
																	
											            $i=0;
											            
											              $old_parent='';
											              
											           $tot_grade_period_summary =0;
											           
											           
					                                   //[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
													   while(isset($dataProvider[$k][0]))
													     {
													     
                                                               $_grade=0;														  
														      if($i==2)
																 $i=0;
																if($i==0)
																	$class="color1";
																elseif($i==1)
																	$class="color2";

																			  
//$class_child="subject";																//$line=
																
if($dataProvider[$k][3]!=null)//[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
  {  
  	  $parent_name ='';
  	  $grade_total=0;
  	  $weight_total=0;
 	  
  	  $subject_parent_name = Subjects::model()->getSubjectNameBySubjectID($dataProvider[$k][3]);
  	  $subject_parent_name = $subject_parent_name->getData();
  	  
  	  $class_child="subject";
  	  
  	    foreach($subject_parent_name as $subject_parent)
  	       $parent_name = $subject_parent;
  	  
  	    if($old_parent!= $dataProvider[$k][3])                     
  	     {  
  	     	if($parent_name!=null)
  	     	   $html .='<tr class=""  > <td class="subjectParent" colspan="'.$compter_p.'" > '.strtoupper(strtr($parent_name->subject_name, pa_daksan() )).'  </td> </tr>';
  	     	else
  	     	   $html .='<tr class=""  > <td class="subjectParent" colspan="'.$compter_p.'" > Not Found </td> </tr>';
  	     	   
   
  	         $old_parent = $dataProvider[$k][3];
  	       }
  	  
  	    
     }
  else
     {
     	   $class_child="subject_single";
     	   
        if($old_parent!= $dataProvider[$k][3])
  	     { 
           $old_parent = $dataProvider[$k][3];
           
  	     }
  	    	       	   
  	     
      }
                                             $summary_grade = 0;
                                             $summary_grade_count = 0;
                                              
                                               
											  $html .='<tr class="'.$class.'"> <td class="'.$class_child.'"> '.$dataProvider[$k][1].'  </td>';	     
															
													 if($pastp!=null)
														   {  
															  if($dataProvider[$k][4]!=NULL)
															     $id_course = $dataProvider[$k][4];
															  else
															    $id_course = $dataProvider[$k][0];
															   
															  foreach($pastp as $id_past_period)
															    {
																		//si kou a evalye pou peryod sa
																		$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$id_past_period);         
													                   if($old_subject_evaluated)
													                      $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$id_past_period);
													                   else
													                       $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$id_past_period);

																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			          // pr creer bulletin pr ceux ki ont au moins 1 note

																			        if($grade->grade_value!=null)																					                                                {  $temoin_has_note=true;	
									
									                                              if(($display_period_summary ==1))// && ($this->summary == true) )
																						 {
																							//care about
																							$careAbout=$this->isSubjectEvaluated($id_course,$this->room_id,$id_past_period);         
													                                         if($careAbout)
																							   { $summary_grade = $summary_grade + $grade->grade_value;
																							       $summary_grade_count++;
																							     }
																							   
																						   }
																						   
																						   //les colonnes notes suivant le nbre d'etape anterieur
										                                   
																		           $html .=' <td class="period" > '.$grade->grade_value.' </td>';
														//fin...			           
														                             
																			            }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			             
																			            // $max_grade=$max_grade+$dataProvider[$k][2];
																			             
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
																			  
																			  
													  	                   } //fin isset grades
													  	                   
													  	                   
													  	                   
																	   }//fin foreach past_period
																	   //$careAbout=false;
																	   if($dataProvider[$k][4]!=NULL)
																	      {  $id_course = $dataProvider[$k][4];
																	         //si kou a evalye pou peryod sa
																				$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
															                   if($old_subject_evaluated)
															                     { $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$this->evaluation_id);
															                        $careAbout=$old_subject_evaluated; 
															                     }
															                   else
															                     {  $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
															                       $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id); 
															                     }
		
																	      }
																	  else
																	    {  $id_course = $dataProvider[$k][0];
																	        $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
																	        $careAbout=$this->isSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id); 
																	    }         
													                    if(($careAbout))//if(($careAbout)||($pastp!=null) )
													                         $max_grade=$max_grade+$dataProvider[$k][2];
																	   
																	   //Grades for the current period
																	  
																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			   
																			        if($grade->grade_value!=null)// pr creer bulletin pr ceux ki ont au moins 1 note
																					  { $temoin_has_note=true;	
									//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									                                              //les colonnes notes suivant le nbre d'etape anterieur
										                                                     
																		           if($careAbout)
																		              {  $tot_grade = $tot_grade + $grade->grade_value;
																		              
																		                 $html .=' <td class="period" > '.$grade->grade_value.' </td>';
																		                   
																		                   if(($display_period_summary ==1))// && ($this->summary == true) )
																						     {
																						     	$summary_grade = $summary_grade + $grade->grade_value;
																							       $summary_grade_count++;
																						       
																						       }
							 											              
																		                }
														//fin...			        
                                                         
																				   
																					  
																					   }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			              
																			           
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
													  	                   } //fin isset grades
																	  
                                                                   }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                               if($dataProvider[$k][4]!=NULL)
															      {  $id_course = $dataProvider[$k][4];
															         //si kou a evalye pou peryod sa
																		$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
													                   if($old_subject_evaluated)
													                     { $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$this->evaluation_id);
													                        $careAbout=$old_subject_evaluated; 
													                     }
													                   else
													                     {  $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
													                       $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id); 
													                     }

															      }
															  else
															    {  $id_course = $dataProvider[$k][0];
															        $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
															        $careAbout=$this->isSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id); 
															    }
                                                             	
                                                              
                                                              
                                                             	                
													                    if(($careAbout) )//if( ($careAbout)||($pastp!=null) )
													                         $max_grade=$max_grade+$dataProvider[$k][2];

                                                             	//Grades for the current period
																	  // $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$this->evaluation_id);
																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			   
																			        if($grade->grade_value!=null)// pr creer bulletin pr ceux ki ont au moins 1 note
																					  { $temoin_has_note=true;	
									//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									                                              //les colonnes notes suivant le nbre d'etape anterieur
										                                                    
																		           
																		               if($careAbout)
																		                 {  $tot_grade = $tot_grade + $grade->grade_value;
																		                    $html .=' <td class="period" > '.$grade->grade_value.' </td>';
																		                 
																		                      if(($display_period_summary ==1))// && ($this->summary == true) )
																						        {
																						        	$summary_grade = $summary_grade + $grade->grade_value;
																							       $summary_grade_count++;
																						           
																						           }
																		                    
																		                   }
														//fin...			
                                                       
                                                      																					   
																					   }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			             
																			             
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
													  	                   } //fin isset grades
																	  

                                                             }//fin past_period ==null
                                                             
                                           if(($display_period_summary ==1) && ($this->summary == true) )
											 {
												$tot_summary_grade = 0;
												   
												   if($summary_grade_count!= 0)
												      $tot_summary_grade = round( ($summary_grade / $summary_grade_count), 2); 
												      
												      $tot_grade_period_summary = $tot_grade_period_summary + $tot_summary_grade;  
												   
													if($tot_summary_grade!=0)
													  $html .=' <td class="period" ><b> '.$tot_summary_grade.'</b></td>';	
													else
													   $html .=' <td class="period" ><b> --- </b></td>';									     
																							   
											  }       
													
											if( ($careAbout)||($pastp!=null) )
											  $html .=' <td class="period" ><b> '.$dataProvider[$k][2].'</b></td>';
											else
											   $html .=' <td class="period" ><b></b></td>';
											
											  
									 $html .=' </tr>
												 ';              $i++;
														       						                                        
                                                               
														$k=$k+1;
										 }
														
									
      
	//check to include discipline grade
//check to include discipline grade

if($include_discipline==1)
  {    												
  	     $html .='<tr class="" > <td class="subject_single"> '.Yii::t('app','Discipline').'  </td>';                                
  	                                     
  	                                     $summary_grade_discipline_count=0;
  	                                     $summary_grade_discipline=0;
  	                                     
  	                                      if($pastp!=null)
														   {  
															  foreach($pastp as $id_past_period)
															    {   // To find period name in in evaluation by year 
                                                                    $period_acad_id =null;
			                                                        //$result=EvaluationByYear::model()->searchPeriodName($id_past_period);
			                                                        $period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;
																		
			                                                               // end of code 
																															  	                   
													  	               		$grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																		  	 
																		  	 $summary_grade_discipline_count++;
																		  	 
																		  	 $summary_grade_discipline=$grade_discipline;
																		  	 
																		//  	if(($grade_discipline==0))
																	  	//   $html .='<td class="period" > --- </td>';
																	  	// else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																	
																		  
													  	                   
																 }//fin foreach past_period
																
																 //current period
																 // To find period name in in evaluation by year 
                                                                 $period_acad_id =null;
			                                                       // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
			                                                       $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
																		
			                                                               // end of code 
																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	 $max_grade = $max_grade + $max_grade_discipline;
																	  	 $tot_grade = $tot_grade + $grade_discipline;
																	  	
																	     	$summary_grade_discipline_count++;
																		  	 
																		  	 $summary_grade_discipline=$grade_discipline;
																		  	 
																	  	//if(($grade_discipline==0))
																	  	//   $html .='<td class="period" > --- </td>';
																	  	// else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																
																	  						  	                   
																	  
                                                              }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                                 //current period
																	// To find period name in in evaluation by year 
                                                                 $period_acad_id =null;
			                                                       // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
			                                                       $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
																		
			                                                               // end of code 
																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	 $max_grade = $max_grade + $max_grade_discipline;
																	  	 $tot_grade = $tot_grade + $grade_discipline;
																	  	
																	  	 $summary_grade_discipline_count++;
																		  	 
																		  	 $summary_grade_discipline=$grade_discipline;
																	  	 
																	  	 //if(($grade_discipline==0))
																	  	 //  $html .='<td class="period" > --- </td>';
																	  	 //else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																
																	  		
                                                               }
                                                               
                                                               
                                          if(($display_period_summary ==1) && ($this->summary == true) )
											 {
												$tot_summary_grade_discipline = 0;
												   
												   if($summary_grade_discipline_count!= 0)
												      $tot_summary_grade_discipline = round( ($summary_grade_discipline / $summary_grade_discipline_count), 2);   
												   $tot_grade_period_summary = $tot_grade_period_summary + $tot_summary_grade_discipline;
												   
													if($tot_summary_grade_discipline!=0)
													  $html .=' <td class="period" ><b> '.$tot_summary_grade_discipline.'</b></td>';	
													else
													   $html .=' <td class="period" ><b> --- </b></td>';									     
																							   
											  }                        
                                                               
                                  if(($max_grade_discipline==null)||($max_grade_discipline==0))
                                     $html .=' <td class="period" ><b> --- </b></td></tr>';
                                  else
                                     $html .=' <td class="period" ><b> '.$max_grade_discipline.'</b></td></tr>';                          	 
	}
  
 
      
  $place_text=null;                     
if($place===1)		
 $place_text=$place.'<span class="place">'.Yii::t('app','st').'</span>';
                                                                                                                                        elseif($place===2)
                                                                                                                                            $place_text=$place.'<span class="place">'.Yii::t('app','nd').'</span>';
																																			elseif($place===3)
                                                                                                                                                $place_text=$place.'<span class="place">'.Yii::t('app','rd').'</span>';
                                                                                                                                               else
                                                                                                                                                 $place_text=$place.'<span class="place">'.Yii::t('app','th').'</span>'; 	          
                                                                                     
                                              $average=0;  	$general_average=0; 
						  
						  if(($average_base==10)||($average_base==100)) 
							   { if($max_grade!=0)  
							       $average=round(($tot_grade/$max_grade)*$average_base,2);
							   }
							  else			
								$average =null;	
												 
										$html .= '<tr class="subjectheadnote_white_tr"><td colspan="'.$compter_p.'"> </td></tr>';
										
										          $html .= '<tr class="sommes2"><td class="periodsommes2"><b>'.Yii::t('app','Total: ').'</b></td>';
											                    
												           if($pastp!=null)
														     {  
															    foreach($pastp as $id_past_period)
															      {
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$this->student_id);
																			if(isset($data_))
																			{
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) 
																			       {
																			 
																				     if($_data->sum!=null)
																				         $html .='<td class="periodsommes2_red"> '.$_data->sum.' </td>';
																				     else
																				         $html .='<td class="periodsommes2_red"> --- </td>';
														                            }//fin foreach _data
																				}
																				else
																			      $html .='<td class="periodsommes2_red"> --- </td>';
													  	                     } //fin isset data_
																	   }//fin foreach past period
																	  
																	  //total for the current period 
																	
																			      if($temoin_has_note)
																			           $html .='<td class="periodsommes2_red"> '.$tot_grade.' </td>';
																			       else
																			         $html .='<td class="periodsommes2_red"> --- </td>';
													  	                  
													  	                   
																	   
                                                                   }//fin past period!=null
										                         else
										                          {
										                           //total for the current period 
																
																				  if($temoin_has_note)
																			         $html .='<td class="periodsommes2_red"> '.$tot_grade.' </td>';
																			      else
																			         $html .='<td class="periodsommes2_red"> --- </td>';
													  	                  
	
										                          }
										                          
										               if(($display_period_summary ==1) && ($this->summary == true) )
												         {
												         	   
												         	    $html .='<td class="periodsommes2_red"><b> '.$tot_grade_period_summary.' </b></td>';
												         	   
												         	}            
										                          
												              $html .='<td class="periodsommes2_red"> <b>'.$max_grade.' </b></td>
												  </tr>
												  
												  <tr class="sommes"><td class="periodsommes"><b>'.Yii::t('app','Average: ').'</b></td>';
														$general_average=0; 
														
													 if($pastp!=null)
														     {  
															    foreach($pastp as $id_past_period)
															      {
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$this->student_id);
																			if(isset($data_)){
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) 
																			       {
																			         if($use_period_weight==1)
																			          {
																			          	 //jwenn peryod eval sa ye
																		  	    	   	  $p_acad = EvaluationByYear::model()->getPeriodNameByEvaluationID($id_past_period);
																		  	    	   	  
																		  	    	   	   foreach($p_acad as $p_weight)
																		  	    	   	     {  
																		  	    	   	     	if($p_weight['weight']!=null)
																		  	    	   	           $general_average = round( ($general_average + ( ($_data->average*$p_weight['weight'])/100) ), 2);
																		  	    	   	              
																		  	    	   	      }
																		  	    	   	     
																			           }
																			          else
																			            $general_average = round( ($general_average + $_data->average), 2);
																			            
																				     $html .='<td class="period"> '.$_data->average.' </td>';
														                          }//fin foreach _data 
																				}
																				else
																			      $html .='<td class="period"> --- </td>';
													  	                   } //fin isset data_
																	   }//fin foreach past period
																	  
																	  //average for the current period 
																	 
																			      	if($use_period_weight==1)
																			          {  
																						  //jwenn peryod eval sa ye
																		  	    	   	  $p_acad = EvaluationByYear::model()->getPeriodNameByEvaluationID($this->evaluation_id);
																		  	    	   	  
																		  	    	   	   foreach($p_acad as $p_weight)
																		  	    	   	     {  
																		  	    	   	     	if($p_weight['weight']!=null)
																		  	    	   	           $general_average = round( ($general_average + (($average*$p_weight['weight'])/100) ), 2);
																		  	    	   	              
																		  	    	   	      }
																		  	    	   	     
																			           }
																			          else
																			            $general_average = round( ($general_average + $average), 2);
																			            
																			      	
																			      	if($average!=0)
																			           {
																			           	 $html .='<td class="period"> '.$average.' </td>';
																			           }
																			         else 
																			           $html .='<td class="period"> --- </td>';
			 																 
													  	                    
                                                                   }//fin isset period
                                                                 else
                                                                   {
                                                                   	//average for the current period 
																	  
																			      	 if($use_period_weight==1)
																			          {  
																						  //jwenn peryod eval sa ye
																		  	    	   	  $p_acad = EvaluationByYear::model()->getPeriodNameByEvaluationID($this->evaluation_id);
																		  	    	   	  
																		  	    	   	   foreach($p_acad as $p_weight)
																		  	    	   	     {  
																		  	    	   	     	if($p_weight['weight']!=null)
																		  	    	   	           $general_average = round( ($general_average + (($average*$p_weight['weight'])/100) ), 2);
																		  	    	   	              
																		  	    	   	      }
																		  	    	   	     
																			           }
																			          else
																			            $general_average = round( ($general_average + $average), 2);
																			            
																			            
																			         
																			         if($average!=0)
																			           { 
																			               $html .='<td class="period"> '.$average.' </td>';
																			           }
																			         else
																			           $html .='<td class="period"> --- </td>';
																			     
                                                                   }
                                                                   
                                                                   
												       if(($display_period_summary ==1) && ($this->summary == true) )
												         {
												         	$general_average=round(($general_average/($compter_p-3)),2);
												         	   
												         	   $html .='<td class="period"><b> '.$general_average.' </b></td>';
												         	   
												         	}
												         	   	
												         	   						     
												               $html .='<td class="period"> </td>
												  </tr>';
			
if($include_place==1)
  { 												  
				$html .='	  <tr class="sommes1"><td class="periodsommes"><b>'.Yii::t('app','Place:').' </b></td>';
												     if($pastp!=null)
														     {  
															    foreach($pastp as $id_past_period)
															      {
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$this->student_id);
																			if(isset($data_)){
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) {
																			   
																			        $place_text1="";
																					    if($_data->place==1)								        
                                                                                          $place_text1=$_data->place.'<span class="place">'.Yii::t('app','st').'</span>';
                                                                                        elseif($_data->place==2)
                                                                                              $place_text1=$_data->place.'<span class="place">'.Yii::t('app','nd').'</span>';
																				            elseif($_data->place==3)
                                                                                                  $place_text1=$_data->place.'<span class="place">'.Yii::t('app','rd').'</span>';
                                                                                                 else
                                                                                                    $place_text1=$_data->place.'<span class="place">'.Yii::t('app','th').'</span>'; 
																									
																					   $html .='<td class="period"> '.$place_text1.' </td>';
																					  
														                          }//fin foreach _data
																				}
																				else
																			      $html .='<td class="period"> --- </td>';
													  	                   } //fin isset data_
																	   }//fin foreach period
																	   
																	   
																				if($place_text!=null)
																			           $html .='<td class="period"> '.$place_text.' </td>';
																			      else
																			           $html .='<td class="period"> --- </td>';
													  	                   
																	   
                                                                   }//fin past period!=null
                                                                else
                                                                  {   //place for the current period 
                                                                   
																			     if($place_text!=null)
																			          $html .='<td class="period"> '.$place_text.' </td>';
																			      else
																			           $html .='<td class="period"> --- </td>';
													  	                  
													  	                 
                                                                        } 
												            					  
												               $html .='<td class="period">   </td>
												  </tr>';
				 
				 
  }			 
	
	if(($display_period_summary !=1))			 
	 {
		if( ((isset($_POST['calculate_g_average']))&&($_POST['calculate_g_average']==true)) || ($use_period_weight==1) ) // make G-average								  
		   { 
					if($pastp!=null)
						{  		
							//calculate the general average
							if($use_period_weight==1)
							  $general_average=round($general_average, 2);
							else
							    $general_average=round(($general_average/($compter_p-2)),2);
							  
												  
							$html .='	<tr class="subjectheadnote_white_tr"><td colspan="'.$compter_p.'"></td></tr>
							        				  
												  
												    <tr class="sommes1"><td class="subject"><b>'.Yii::t('app','General Average:').' </b></td>'; 
												     
																																											                                          if($general_average!=null)
															      $html .='<td class="period"> '.$general_average.'</td>';
															 else
																  $html .='<td class="period"> --- </td>';
																					 
														                       
																	  												            					  
												               $html .='
												  </tr>			  
												  ';
						}

		     }
	  }   
		     
		     
		     							  

$html .= '</table>&nbsp;<span style="float:right; font-size:9px; color:#000000;text-shadow: 2px 2px 1px #FFF;">.</span>
            </div>';

if(($tardy_absence_display== 1)||($include_discipline==0))
  {
  $html .= '<table  class="discipline">
          <tr><td style="border:0px thin #F9F9F9 ;"></td>';
		   //on ajoute les colonnes suivant le nbre d'etape anterieur
			 if($pastp!=null)
				{ $compter_p=1; 
				  foreach($pastp as $id_past_period)
					{
					  $html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;"> <b>'.$this->searchPeriodName($id_past_period).'</b> </span> </td>';
					 
					  
					  		$compter_p++;										
		             }
		            
		            $html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;"> <b>'.$this->searchPeriodName($this->evaluation_id).'</b> </span> </td>'; 
		            
		              
		             
				 }
			else
			  {
			     	$html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;"> <b>'.$period_exam_name.'</b> </span> </td>'; 

			  }
	
	      
	        if(($display_period_summary ==1) && ($this->summary == true) )
			  {
					$html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;"> <b>'.Yii::t('app','Summary ').'</b> </span> </td>'; 						   		   
			  }  
	
          
         $html .=' </tr>';
	}
         
if($tardy_absence_display== 1)
     {          
          $html .='<tr><td style="border:1px solid #E4E4E4;"> <span style="font-size:9pt;"><b>'.Yii::t('app','RETARD').'</b></span></td>';//on ajoute les colonnes suivant le nbre d'etape anterieur
			
			$period_acad_id = '';
			
			  if($pastp!=null)
				{  
				  foreach($pastp as $id_past_period)
					{
						 //$result=EvaluationByYear::model()->searchPeriodName($id_past_period);
						 
						 $period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;
															
					  
						$retard = RecordPresence::model()->getTotalRetardByExam($period_acad_id, $this->student_id, $acad);
						$html .='<td style="border:1px solid #E4E4E4;"> '.$retard.' </td>';
																		
		             }
		             
		                // $result=EvaluationByYear::model()->searchPeriodName($id_past_period);
																				  
		               $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
		               
		               $retard = RecordPresence::model()->getTotalRetardByExam($period_acad_id, $this->student_id, $acad);
		               $html .='<td style="border:1px solid #E4E4E4;"> </td>';
		               
				 }
			  else
			    {
			         //  $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
						
						$period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
						
			          $retard = RecordPresence::model()->getTotalRetardByExam($period_acad_id, $this->student_id, $acad);
			          
			          $html .='<td style="border:1px solid #E4E4E4;"> '.$retard.' </td>';	
			     }
			     
			 if(($display_period_summary ==1) && ($this->summary == true) )
			  {
					$count_tardy = getTotalRetardByStudent($this->student_id,$acad); 
                       
                       $html .='<td style="border:1px solid #E4E4E4;"><b> '.$count_tardy.' </b></td>';															   
			  }  
			     
		$html .=' </tr>
		   <tr><td style="border:1px solid #E4E4E4;"><span style="font-size:9pt;"><b>'.Yii::t('app','ABSENCE').'</b></span></td>';//on ajoute les colonnes suivant le nbre d'etape anterieur
			 if($pastp!=null)
				{  
				  foreach($pastp as $id_past_period)
					{
						 //$result=EvaluationByYear::model()->searchPeriodName($id_past_period);
															
						$period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;									
					 
						$absc = RecordPresence::model()->getTotalPresenceByExam($period_acad_id, $this->student_id, $acad);
						$html .='<td style="border:1px solid #E4E4E4;"> '.$absc.' </td>';
																		
		             }
		             
		                //  $result=EvaluationByYear::model()->searchPeriodName($id_past_period);
						
						$period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
						
						$absc = RecordPresence::model()->getTotalPresenceByExam($period_acad_id, $this->student_id, $acad);
		               $html .='<td style="border:1px solid #E4E4E4;"> '.$absc.' </td>';

				 }
			   else
			     {
			         
			         //  $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
						
						$period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
						
					  $absc = RecordPresence::model()->getTotalPresenceByExam($period_acad_id, $this->student_id, $acad);
			         $html .='<td style="border:1px solid #E4E4E4;"> '.$absc.' </td>';
	
			     }
			   
			 if(($display_period_summary ==1) && ($this->summary == true) )
			  {
					$count_absence = getTotalAbsenceByStudent($this->student_id,$acad);	
                       
                       $html .='<td style="border:1px solid #E4E4E4;"><b> '.$count_absence.' </b></td>';															   
			  }  
			     
				$html .='</tr>';
 
  }
  
  
  			
//check to include discipline grade
if(($include_discipline!=2)&&($include_discipline!=1))
{
if($include_discipline==0)
  {    												
  	   $html .=' <tr><td style="border:1px solid #E4E4E4;"><span style="font-size:9pt;"><b>'.Yii::t('app','Discipline').'</b></span></td>';//on ajoute les colonnes suivant le nbre d'etape anterieur
                               
                               $konte_peryod = 0;
				               $mwayen_disiplin = 0;
				               $som_peryod = 0.00;
				               
  	                                      if($pastp!=null)
				                            {  
				                              foreach($pastp as $id_past_period)
					                            {    $period_acad_id = null;
														  //$result=EvaluationByYear::model()->searchPeriodName($id_past_period);
															
															$period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;																	  	                   
													  	                 //check to include discipline grade
																		
																		  	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																		  	 
																		  	 $konte_peryod++;
																               
																               $som_peryod +=$grade_discipline;
																		  	 
																		  																			  	 
																		  	//if(($grade_discipline==0))
																	  	   //$html .='<td style="border:1px solid #E4E4E4;" > --- </td>';
																	  	 //else
																	  	    $html .='<td style="border:1px solid #E4E4E4;" > '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																	
																		  
													  	                   
																 }//fin foreach past_period
																
																 //current period
																   $period_acad_id = null;
																  // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															
															$period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
															
																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	
																	  	$konte_peryod++;
																               
																         $som_peryod +=$grade_discipline;                                            
																	  	
																	  	//if(($grade_discipline==0))
																	  	   //$html .='<td style="border:1px solid #E4E4E4;"> --- </td>';
																	  	// else
																	  	    $html .='<td style="border:1px solid #E4E4E4;"> '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																
																	  						  	                   
																	  
                                                              }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                                 //current period
                                                                 //current period
																   $period_acad_id = null;
																   //$result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															
															$period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
															                                                                
																$grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id,  $period_acad_id);
																       $konte_peryod++;
																         
																        $som_peryod +=$grade_discipline;
								 
									  	
																	  	//if(($grade_discipline==0))
																	  	//   $html .='<td style="border:1px solid #E4E4E4;" > --- </td>';
																	  	// else
																	  	    $html .='<td style="border:1px solid #E4E4E4;" > '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																
																	  		
                                                               }
                                                               
                                  if(($display_period_summary ==1) && ($this->summary == true) )
									  {
											
											if($konte_peryod!=0)
											  $mwayen_disiplin = round( ($som_peryod/$konte_peryod), 2);
											  
						                       $html .='<td style="border:1px solid #E4E4E4;" ><b> '.$mwayen_disiplin.' / '.$max_grade_discipline.' </b></td>';															             
									  }  
           
            $html .='</tr>';                          
                                                               	 
	}

}			

if(($tardy_absence_display== 1)||($include_discipline==0))
  {				
  	$html .= '</table>';
  }
  
  
$html .= '																	 
<div class="" style="font-size:9px; font-weight:bold;" >   
<br/>';

 $section_ = $this->getSectionByStudentId($this->student_id);
 
 $observation = '( '.$period_exam_name.' ): '.observationReportcard($section_->id,$average,$acad_); //sou tout ane a
	
	 $html .= strtoupper(Yii::t('app','Notes') ).$observation;		     

if($show_observation_line== 1)    
    $html .= '<br/><br/>....................................................................................................................................................................................................................................................................';

$html .= '<br/><br/>            
<table class="signature" ><tr>';

 if(($section=="Primaire")||($section=="Fondamental"))
    { 
    	
    	if(($display_administration_signature==1) &&($display_parent_signature!=1))
		{
			 $html .= '<td class="signature1" style="width:70%;">  </td>'
                  . '<td class="signature1" style=" width:30%;">  <hr style="width:100%;" /><div style="text-align: center;">'.$administration_signature_text.'</div> </td>
                      ';
			
		 }	
		elseif($display_administration_signature==1)
    	  {  $html .= '<td class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$administration_signature_text.' </td>
                      <td class="signature1" style="width:2%;">  </td>';
                      
    	    }
			

		if($display_parent_signature==1)
    	  {  $html .= '   <td class="signature1" style=" width:30%;"> <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$parent_signature_text.' </td>';
						
    	   }
    	
    }
  elseif($section=='Secondaire')
    {  
    	
    	
    	if(($display_administration_signature==1) &&($display_parent_signature!=1))
		{
			 $html .= '<td class="signature1" style="width:70%;">  </td>'
                  . '<td class="signature1" style=" width:30%;">  <hr style="width:100%;" /><div style="text-align: center;">'.$administration_signature_text.'</div> </td>
                      ';
			
		 }	
		elseif($display_administration_signature==1)
    	  {   $html .= '<td class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$administration_signature_text.' </td>
                      <td class="signature1" style="width:2%;">  </td>';
                      
    	    }
    	    
		
		if($display_parent_signature==1)
    	  { $html .= '  <td class="signature1" style=" width:30%;"> <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$parent_signature_text.' </td>';
						
    	  }
    	  
    	  
    	  
    }
   else
    {  
    	
    	
    	if($display_administration_signature==1)
		{
			 $html .= '<td class="signature1" style="width:70%;">  </td>'
                  . '<td class="signature1" style=" width:30%;">  <hr style="width:100%;" /><div style="text-align: center;">'.$administration_signature_text.'</div> </td>
                      ';
			
		 }	
		/*if($display_administration_signature==1)
    	  {   $html .= '<td class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$administration_signature_text.' </td>
                      <td class="signature1" style="width:2%;">  </td>';
                      
    	    }
    	    */
		
		
    	  
    	  
    }

     
$html .= '</tr></table>';

if($display_created_date==1)
  $html .= ' <div style="float:right; font-weight:normal;">    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.ChangeDateFormat(date('Y-m-d')).'</div>  </div>   ';
	
		                         		                         
//******** AVERAGE BY PERIOD  ************//
 
				//save average for this period			  
						  $command = Yii::app()->db->createCommand();
						   if($temoin_has_note)//
							{//check if already exit
							  $data =  Grades::model()->checkDataAverageByPeriod($acad,$this->evaluation_id,$this->student_id);
							  $is_present=false;
							       if($data)
								     $is_present=true;
								  
                                if($is_present){// yes, update
								
								    $command->update('average_by_period', array(
											'sum'=>$tot_grade,'average'=>$average,'place'=>$place,'date_updated'=>date('Y-m-d'),
										), 'academic_year=:year AND evaluation_by_year=:period AND student=:stud', array(':year'=>$acad, ':period'=>$this->evaluation_id, ':stud'=>$this->student_id));
                                   }
								 else{// no, insert
								   $command->insert('average_by_period', array(
										'academic_year'=>$acad,
										'evaluation_by_year'=>$this->evaluation_id,
										'student'=>$this->student_id,
										'sum'=>$tot_grade,
										'average'=>$average,
										'place'=>$place,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								 
								 
							       }
							
	//******** GENERAL AVERAGE (END YEAR DECISION)  ************//
 
 //save general average for end year decision				  
	        if($this->final_period==true) // this is the last period
	          {     					 
					 $command2 = Yii::app()->db->createCommand();
					 
			   if($pastp!=null) //past evaluation period was included
				 {  
				  if( ((isset($_POST['calculate_g_average']))&&($_POST['calculate_g_average']==true)) || (($display_period_summary==1)&&($this->summary == true) ) ) // make G-average
						  {		//check if already exit
				             $result=$this->checkDataGeneralAverage($acad,$this->student_id,$general_average,$this->idLevel);
							  
							if((isset($result))&&($result!=null))
							  {  // yes, update
							       
									  $date_updated=date('Y-m-d');
							     foreach($result as $data)
				                   { 
								      $command2->update('decision_finale', array(
												'general_average'=>$general_average,'date_updated'=>$date_updated,
											), 'id=:ID', array(':ID'=>$data["id"] ));
	                                  
								     }
								   
							  }
							 else
							  { // no, insert
							        $date_created= date('Y-m-d');
							        
									$command2->insert('decision_finale', array(
									'student'=>$this->student_id,
									'academic_year'=>$acad,
									'general_average'=>$general_average,
									'current_level'=>$this->idLevel,
									'date_created'=>$date_created,
											
										));
							   }
							   
							   
							   //general_average_by_period
							    //save general average for this period
							    $period_acad_id ='';			  
						        $command3 = Yii::app()->db->createCommand();
						       //check if already exit
						       $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
								  
								  $data___=Grades::model()->checkDataGeralAverageByPeriodForReport($acad,$period_acad_id);
								  if((isset($data___))&&($data___!=null))
								  {  // yes, update
						
								    $command3->update('general_average_by_period', array(
											'general_average'=>$general_average,'date_updated'=>date('Y-m-d'),
										), 'academic_year=:year AND academic_period=:period AND student=:stud', array(':year'=>$acad, ':period'=>$period_acad_id, ':stud'=>$this->student_id));
                                   }
								 else{// no, insert
								   $command3->insert('general_average_by_period', array(
										'academic_year'=>$acad,
										'academic_period'=>$period_acad_id,
										'student'=>$this->student_id,
										'general_average'=>$general_average,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								     
								     
						      }//end making G-average
						   else  //the last period average as average of final decision
						     
						     
						     {		//check if already exit
				             $result=$this->checkDataGeneralAverage($acad,$this->student_id,$average,$this->idLevel);
							  //$is_present=false;
							if((isset($result))&&($result!=null))
							  {  // yes, update
							       
									  $date_updated=date('Y-m-d');
							     foreach($result as $data)
				                   { 
								      $command2->update('decision_finale', array(
												'general_average'=>$average,'date_updated'=>$date_updated,
											), 'id=:ID', array(':ID'=>$data["id"] ));
	                                  
								     }
								   
							  }
							 else
							  { // no, insert
							        $date_created= date('Y-m-d');
							        
									$command2->insert('decision_finale', array(
									'student'=>$this->student_id,
									'academic_year'=>$acad,
									'general_average'=>$average,
									'current_level'=>$this->idLevel,
									'date_created'=>$date_created,
											
										));
							   }
							   
							   
							   //general_average_by_period
							    //save general average for this period
							    $period_acad_id ='';			  
						        $command3 = Yii::app()->db->createCommand();
						       //check if already exit
						       $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
								  
								  $data___=Grades::model()->checkDataGeralAverageByPeriodForReport($acad,$period_acad_id);
								  if((isset($data___))&&($data___!=null))
								  {  // yes, update
						
								    $command3->update('general_average_by_period', array(
											'general_average'=>$average,'date_updated'=>date('Y-m-d'),
										), 'academic_year=:year AND academic_period=:period AND student=:stud', array(':year'=>$acad, ':period'=>$period_acad_id, ':stud'=>$this->student_id));
                                   }
								 else{// no, insert
								   $command3->insert('general_average_by_period', array(
										'academic_year'=>$acad,
										'academic_period'=>$period_acad_id,
										'student'=>$this->student_id,
										'general_average'=>$average,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								     								     
								     
						      }
						      
					      }
					   else  //no past evaluation period was included
					     {
					     	
								//check if already exit
				             $result=$this->checkDataGeneralAverage($acad,$this->student_id,$average,$this->idLevel);
							
							if((isset($result))&&($result!=null))
							  {  // yes, update
							       
									  $date_updated=date('Y-m-d');
							     foreach($result as $data)
				                   { 
								      $command2->update('decision_finale', array(
												'general_average'=>$average,'date_updated'=>$date_updated,
											), 'id=:ID', array(':ID'=>$data["id"] ));
	                                  
								     }
								   
							  }
							 else
							  { // no, insert
							        $date_created= date('Y-m-d');
							        
									$command2->insert('decision_finale', array(
									'student'=>$this->student_id,
									'academic_year'=>$acad,
									'general_average'=>$average,
									'current_level'=>$this->idLevel,
									'date_created'=>$date_created,
											
										));
							   }
							   
							   //general_average_by_period
							    //save general average for this period
							    $period_acad_id ='';			  
						        $command3 = Yii::app()->db->createCommand();
						       //check if already exit
						       $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
								 
								  $data___=Grades::model()->checkDataGeralAverageByPeriodForReport($acad,$period_acad_id);
								  if((isset($data___))&&($data___!=null))
								  {  // yes, update
						
								    $command3->update('general_average_by_period', array(
											'general_average'=>$average,'date_updated'=>date('Y-m-d'),
										), 'academic_year=:year AND academic_period=:period AND student=:stud', array(':year'=>$acad, ':period'=>$period_acad_id, ':stud'=>$this->student_id));
                                   }
								 else{// no, insert
								   $command3->insert('general_average_by_period', array(
										'academic_year'=>$acad,
										'academic_period'=>$period_acad_id,
										'student'=>$this->student_id,
										'general_average'=>$average,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								     
							   
							   
					     }	//end of no past evaluation   
							  
							  
	          }				 
					  
	      
	  
	  //***********   END   ***************//
		
		return $html;
		
		}			
	
   //end of   htmlReportcard1 
 		

public function htmlReportcard2($dataProvider,$tot_grade,$student,$pastp,$k,$place,$max_grade,$acad,$temoin_has_note,$evaluationPeriod,$period_exam_name,$level,$room,$section,$shift,$name_acadPeriod_for_this_room,$tot,$eval_date,$last_eval_, $past_period)
	{
		 $siges_structure = infoGeneralConfig('siges_structure_session');

		 $acad_=Yii::app()->session['currentId_academic_year']; 
		 $acad_name=Yii::app()->session['currentName_academic_year']; 
		 
		 $this->summary = false;
		 
		
		if((isset($_POST['summary']))&&($_POST['summary']==true)) 
		    $this->summary = true;
		
		    
      $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad_!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }



     $general_average_current_period =0;
     $max_grade_discipline=0;
     $include_discipline=0;
     $include_place = 1;
     $average_base =0;
     $show_observation_line = 0;
     
                               //Extract max grade of discipline
                                $max_grade_discipline = infoGeneralConfig('note_discipline_initiale');
				   				//Extract include_discipline_grade
                                $include_discipline = infoGeneralConfig('include_discipline_grade');
				   				//Extract include_discipline_grade
                                $tardy_absence_display = infoGeneralConfig('tardy_absence_display');
				   				//Extract include_place
                                $include_place = infoGeneralConfig('include_place');
				   				
				   				//Extract average base
                                $average_base = infoGeneralConfig('average_base');
                                
                                //Extract observation line
								$show_observation_line = infoGeneralConfig('observation_line');
								
								//Extract student code
				                $display_student_code = infoGeneralConfig('display_student_code');
				                                
				                //Extract display_administration_signature
				                $display_administration_signature = infoGeneralConfig('display_administration_signature');
				                               
				                //Extract display_parent_signature
				                $display_parent_signature = infoGeneralConfig('display_parent_signature');
				                              
				                //Extract administration_signature_text
				                $administration_signature_text = infoGeneralConfig('administration_signature_text');
				                               
				                //Extract parent_signature_text
				                $parent_signature_text = infoGeneralConfig('parent_signature_text');
				                               
				                //Extract display_created_date
				                $display_created_date = infoGeneralConfig('display_created_date');
				                
				                //Extract display_class_enroll
				                $display_class_enroll = infoGeneralConfig('display_class_enroll');
				                
				                //Extract display_period_summary
				                $display_period_summary = infoGeneralConfig('display_period_summary');
				                
				                //Extract use_period_weight
				                $use_period_weight = infoGeneralConfig('use_period_weight');
				                
				                
$final_general_average=0;
$numb_period_4_final_GA =0;
$general_avarage_for_period_ =0; //pou mwayenn jeneral evalyasyon nan 1 peryod
$general_avarage_for_period_fin = 0;//pou mwayenn jeneral peryod
$avarage_for_period_ =0;		  
$moyenne_jeneral_chak_peryod = array();
$weight_null=true;
				                

     
     $eval_date = null;
	$acad_year = null;
			                    


                  //find date of the current evaluation
						$result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
							if(isset($result))
							 {  $result=$result->getData();//return a list of  objects
								 foreach($result as $r)
								   { $eval_date = $r->evaluation_date;
									  $acad_year = $r->academic_year;	   
									}
							   }
 
    
     
     $data_current_period =null;	      
	   $p_name_general_average = EvaluationByYear::model()-> getPeriodNameByEvaluationDATE($eval_date);
			           
		   foreach($p_name_general_average as $p_na)
			 $data_current_period = $p_na;
		
																	      
    
         
					
							
							
							$html = <<<EOD
 <style>
	
.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		//color: #1e5c8c;
        font-size: 16px;
		width:100%;
		text-align: center;
		
		 
	   }
	
	
.info{   font-size:10px;
      background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
	 }
		
 .corps{
	 
	width:100%;
	background-color: #F5F6F7;
	
	}

		
table.signature {
		width:90%;
		float:right;
		font-size:10px;
		margin-top:55px;
		margin-bottom:5px;
		
	}
	
.place{
	  font-size:6pt;
	}
	
	td.signature1 {
		
		
	}
	
	td.signature2 {
		
		
	}
	
	td.space {
		width:30%;
		
	}

.tb {
		
		width:100%;
	    
		//loat:right;
		
		font-size:10px;
				
	}
	
 .discipline {
		width:65%; 
		margin-top:20px;
		font-size:10px;
	}

		
 .subjectheadnote {
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			width:30%;
			
			}
			
			

.subjectheadnote_white_tr{
			
			background-color:#FFFFFF; 
	
			}
						
						
 .subject{
			color:#000; 
			font-size:10px; 
			height:20px;
			font-weight: normal; //bold; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;
			}
		
 .color1{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}


 .color2	{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
	
 .sommes	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes1	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes2{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			border-top: 1px solid #EE6539;
			border-radius: 5px;
			background-color:  #EFEFEF;
			border-bottom: 1px solid #ecedf4;
			
		}

 .border	{
			
			border-bottom: 1px solid #ecedf4;
		}
			
.headnote {
		//width:10%;
		
	}
	
	
.periodsommes2{
		height:20px; 
		text-align: right;
			border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}
.periodsommes{
	height:20px;
	text-align: right; 	
	border-bottom: 1px solid #ecedf4;
	}
 .period {
		width:10%;
		text-align: center;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodParent {
		width:10%;
		text-align: center;
		font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodsommes2_red{
		width:10%;
		text-align: center;
		border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}	
	
.periodheadnote {
		width:10%;
		font-size:9px;
	
	}

.subjectParent{
	//text-transform: uppercase; //capitalize; //|uppercase|lowercase|initial|inherit|none;
	height:15px;
	font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	
			
	}
	

			
div > .subject {
		width:30%;
		 text-indent: 10px;
		 font-weight: normal; //bold; 
		
	}
	
.subject_single{
		    color:#000; 
			font-size:10px; 
			height:20px;
			font-weight:bold;
			text-indent: 0px; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;	
	}	
	
	
</style>
                                       
										
EOD;
	 
				   					//	$html .='<div class="title" >'.strtoupper(Yii::t("app","Report Card ")).'</div>'; 
										$html .='<span class="title" >'.strtoupper(Yii::t("app","Report Card ")).'</span>
										<div class="info" >  <b>'.Yii::t('app','Name: ').'</b> '.$student.'    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>';
										if($siges_structure==0)
											  $html .= $evaluationPeriod.' : </b>'.$period_exam_name;
										  elseif($siges_structure==1)
										      $html .= $period_exam_name.' : </b>'.$evaluationPeriod;
                                            
										
									if($display_student_code==1)
									   {   $code=''; 
									     	//return id_number, gender,is_student,nif_cin,email,phone,adresse
                                             $flashInfo= Persons::model()->getFlashInfoById($this->student_id);
                                               foreach($flashInfo as $r)
                                                 {
                                                 	$code = $r['id_number'];
                                                 	}
									   	
									   	 $html .='<br/> <b>  '.Yii::t('app', 'Id Number').': </b>'.$code;
									    }
									     
										$html .='<br/> <b>  '.Yii::t('app','Level / Room: ').'</b> '.$level.' / '.$room.'<br/>  <b>  '.Yii::t('app','Section / Shift: ').'</b> '.$section.' / '.$shift.'   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										
										if($display_class_enroll==0)
										     $html .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										     
										     
										if($siges_structure==0)
											  $html .= '<b>'.Yii::t('app','Academic period: ').'</b> '.$name_acadPeriod_for_this_room;
										  elseif($siges_structure==1)
										      $html .= '<b>'.Yii::t('app','Academic year').': </b> '.$acad_name;
           
										if($display_class_enroll==1)
										     $html .=' / <b>'.Yii::t('app','Number of students: ').'</b> '.$tot;
										
										$html .=' </div>
														    
                                                      <div class="corps">    
															<table class="tb"> 
                                                                     													  
														             <tr><td class="subjectheadnote"></td>'; 
			 //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		// debut of cases depending on past period	   
/*
if($last_eval_)
{ //find date of the current evaluation
 $last_eval_date_for_each_period= array(); //or last eval date for the session
 $period_id_and_average[]= array();
 $evaluation_id_and_average[]= array(); ///pou strikti 1
 						          
	$result_last=EvaluationByYear::model()->getLastEvaluationForEachPeriod($acad);
	 if(($result_last!=null))
	  {  foreach($result_last as $r)
		  { $last_eval_date_for_each_period[]= $r["academic_year"]; //ID academic period la
	 			  
			}
											     
		}
      
  }
	
				
				//pou epted-------DELETE LI APRE------------	
					//on ajoute les colonnes suivant le nbre d'etape anterieur
					$modelEvalution = new EvaluationByYear();
						if((isset($period)&&($period!=null)))
						  {  $period=$period->getData();//return a list of  objects
								foreach($period as $r)
								  {
									if($r->evaluation!=$this->evaluation_id)
									  { 
									  	//chache evalyasyon an
									  	$modelEBY = EvaluationByYear::model()->findByPk($r->evaluation);
									  	$last_eval_date_for_each_period[$r->evaluation] = $modelEvalution->getEvaluationName($modelEBY->evaluation);
									   	
								      }															
								   }
						   }
					//fen pou epted-------DELETE LI APRE------------        
*/					 

			                    $eval_period='';
			                    $compter_p=1;
			                     if($past_period!=null)
				                     {  
					                   foreach($past_period as $id_past_period)
					                      {
	                                          $eval=ReportCard::searchEvaluationNameForReportCard($id_past_period);
                
			 	                               $compter_p++;               
												
												if( ($eval["weight"]!=100)&&($eval["weight"]!='') )
								                   $html .='<td class="periodheadnote" > <span style="font-size:8pt;text-align:center;"> <b>'.$eval->evaluation_name.'</b><br/>('.$eval->weight.'%) </span> </td>';
								                else
								                   $html .='<td class="periodheadnote" > <span style="font-size:8pt;text-align:center;"> <b>'.$eval->evaluation_name.'</b> </span> </td>';
																		
											}
											//for the current period
										   $eval=ReportCard::searchEvaluationNameForReportCard($this->evaluation_id);
										   //$eval_period=$this->searchPeriodName($this->evaluation_id);
											
											 if( ($eval["weight"]!=100)&&($eval["weight"]!='') )
								                $html .='<td class="periodheadnote" > <span style="font-size:8pt;text-align:center;"> <b>'.$eval->evaluation_name.'</b><br/>('.$eval->weight.'%) </span> </td>';
								             else
								                $html .='<td class="periodheadnote" > <span style="font-size:8pt;text-align:center;"> <b>'.$eval->evaluation_name.'</b> </span> </td>';
											
								       }
								    else  //for the current period
									{      //$eval_period=$this->searchPeriodName($this->evaluation_id);
									      $eval=ReportCard::searchEvaluationNameForReportCard($this->evaluation_id);
									
										if( ($eval["weight"]!=100)&&($eval["weight"]!='') )
								           $html .='<td class="periodheadnote" > <span style="font-size:8pt;text-align:center;"> <b>'.$eval->evaluation_name.'</b><br/>('.$eval->weight.'%) </span> </td>';
								        else
								           $html .='<td class="periodheadnote" > <span style="font-size:8pt;text-align:center;"> <b>'.$eval->evaluation_name.'</b> </span> </td>';
								    }							      
									//fin ajout  
									$compter_p=$compter_p+2;          
											$html .=' <td class="periodheadnote" >  <b>'.Yii::t('app','MAX GRADE').'</b>  </td></tr><tr class=""><td ></td></tr>																 
																	 ';
																	
											            $i=0;
											            
											            $old_parent='';
											            
											            
					                                   //[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
													   while(isset($dataProvider[$k][0]))
													     {
													     
                                                               $_grade=0;														  
														      if($i==2)
																 $i=0;
																if($i==0)
																	$class="color1";
																elseif($i==1)
																	$class="color2";
																				  
																//$line=
																
if($dataProvider[$k][3]!=null)//[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
  {  
  	  $parent_name ='';
  	  $grade_total=0;
  	  $weight_total=0;
  	  
  	  $subject_parent_name = Subjects::model()->getSubjectNameBySubjectID($dataProvider[$k][3]);
  	  $subject_parent_name = $subject_parent_name->getData();
  	  
  	  $class_child="subject";
  	  
  	    foreach($subject_parent_name as $subject_parent)
  	       $parent_name = $subject_parent;
  	  
  	   if($old_parent!= $dataProvider[$k][3])                     
  	     {  
  	       if($parent_name!=null)
  	           $html .='<tr class=""  > <td class="subjectParent" > '.strtoupper(strtr($parent_name->subject_name, pa_daksan() )).'  </td>';
  	       else
  	           $html .='<tr class=""  > <td class="subjectParent" > Not Found </td>';
  	       
  	        
  	     if($past_period!=null)
		  {  
			foreach($past_period as $id_past_period)
			 {
			 	  $grade_total=0;
  	              $weight_total=0;
  	  
			$_total=Grades::model()->getTotalGradeWeightByPeriodForSubjectParent($dataProvider[$k][3],$this->student_id, $id_past_period);
					
					if($_total!=null)
					 { foreach($_total as $_total_) 
					    {
						  $grade_total= $_total_["grade_total"];
  	                      $weight_total= $_total_["weight_total"];
						 }//fin foreach 
					  }
					
					if($grade_total!=0)																					                                                              
					   $html .=' <td class="periodParent" > '.round($grade_total,2).' </td>';
					else
					   $html .=' <td class="periodParent" > --- </td>';
																			  
				
			 }//fin foreach past_period
				
				   //Grades for the current period
			$_total1=Grades::model()->getTotalGradeWeightByPeriodForSubjectParent($dataProvider[$k][3],$this->student_id, $this->evaluation_id);
				 
					if($_total1!=null)
					 { foreach($_total1 as $_total_) 
					    {
						  $grade_total= $_total_["grade_total"];
  	                      $weight_total= $_total_["weight_total"];
						 }//fin foreach 
					  }
					
					if($grade_total!=0)																					                                                              
					   $html .=' <td class="periodParent" > '.round($grade_total,2).' </td>';
					else
					   $html .=' <td class="periodParent" > --- </td>';
							
																	  
               }//fin past !=null
             else //if past_period null, get grades for the current period
                {          
                     //Grades for the current period
			    $_total1=Grades::model()->getTotalGradeWeightByPeriodForSubjectParent($dataProvider[$k][3],$this->student_id, $this->evaluation_id);
				 
					if($_total1!=null)
					 { foreach($_total1 as $_total_) 
					    {
						  $grade_total= $_total_["grade_total"];
  	                      $weight_total= $_total_["weight_total"];
						 }//fin foreach 
					  }
					
					if($grade_total!=0)																					                                                              
					   $html .=' <td class="periodParent" > '.round($grade_total,2).' </td>';
					else
					   $html .=' <td class="periodParent" > --- </td>';
							
													  
                  }//fin past_period ==null
                                                             
                                                  
					$html .=' <td class="periodParent" ><b> '.$weight_total.'</b></td>';
					
            
  	       
  	       $html .=' </tr>';
  	         
  	         $old_parent = $dataProvider[$k][3];
  	       }
  	  
  	    
     }
  else
     {
     	   $class_child="subject_single";
     	   
        if($old_parent!= $dataProvider[$k][3])
  	     { 
           $old_parent = $dataProvider[$k][3];
           
  	     }
  	    	       	   
  	     
      }
    
	
													$html .='<tr class="'.$class.'"> <td class="'.$class_child.'"> '.$dataProvider[$k][1].' </td>';	     
															
													 if($past_period!=null)
														   {  
															   	
																    
															  foreach($past_period as $id_past_period)
															    {
																	if($dataProvider[$k][4]!=NULL)
																     $id_course = $dataProvider[$k][4];
																  else
																    $id_course = $dataProvider[$k][0];
																		//si kou a evalye pou peryod sa
																		$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$id_past_period);         
													                   if($old_subject_evaluated)
													                      $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$id_past_period);
													                   else
													                       $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$id_past_period);

																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			          // pr creer bulletin pr ceux ki ont au moins 1 note

																			        if($grade->grade_value!=null)																					                                                {  $temoin_has_note=true;	
									//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									                                              //les colonnes notes suivant le nbre d'etape anterieur
										              
																		           $html .=' <td class="period" > '.$grade->grade_value.' </td>';
														//fin...			           
														                             
																			            }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			             
																			            // $max_grade=$max_grade+$dataProvider[$k][2];
																			             
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
																			  
																			  
													  	                   } //fin isset grades
													  	                   
													  	                
													  	                   
																	   }//fin foreach past_period
																	   //$careAbout=false;
																	   if($dataProvider[$k][4]!=NULL)
																	      {  $id_course = $dataProvider[$k][4];
																	         //si kou a evalye pou peryod sa
																				$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
															                   if($old_subject_evaluated)
															                     { $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$this->evaluation_id);
															                        $careAbout=$old_subject_evaluated; 
															                     }
															                   else
															                     {  $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
															                       $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id); 
															                       
															                     }
		
																	      }
																	  else
																	    {  $id_course = $dataProvider[$k][0];
																	        $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
																	        $careAbout=$this->isSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id); 
																	    }
                                                             	        
													                   if( ($careAbout) )//if( ($careAbout)||($pastp!=null) )
													                         $max_grade=$max_grade+$dataProvider[$k][2];
																	   
																	   //Grades for the current period
																	   
																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			   
																			        if($grade->grade_value!=null)// pr creer bulletin pr ceux ki ont au moins 1 note
																					  { $temoin_has_note=true;	
									//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									                                              //les colonnes notes suivant le nbre d'etape anterieur
										                                                    
																		           if($careAbout)
																		              { $tot_grade = $tot_grade + $grade->grade_value;
																		                $html .=' <td class="period" > '.$grade->grade_value.' </td>';
																		              }
														//fin...			        
                                                                                   //$max_grade=$max_grade+$dataProvider[$k][2];
																				   
																					  // $max_grade=$max_grade+$dataProvider[$k][2];
																					   }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			             
																			            // $max_grade=$max_grade+$dataProvider[$k][2];
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
													  	                   } //fin isset grades
													  	                   
																				  	                   
																	  
                                                                   }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                             	if($dataProvider[$k][4]!=NULL)
															      {  $id_course = $dataProvider[$k][4];
															         //si kou a evalye pou peryod sa
																		$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
													                   if($old_subject_evaluated)
													                     { $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$this->evaluation_id);
													                        $careAbout=$old_subject_evaluated; 
													                     }
													                   else
													                     {  $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
													                       $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id); 
													                       
													                     }

															      }
															  else
															    {  $id_course = $dataProvider[$k][0];
															        $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
															        $careAbout=$this->isSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id); 
															    }
                                                             	
                                                              
                                                                          
													                    if(($careAbout) )//if( ($careAbout)||($pastp!=null) )
													                         $max_grade=$max_grade+$dataProvider[$k][2];
                                                             	                 
													                   
																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			   
																			        if($grade->grade_value!=null)// pr creer bulletin pr ceux ki ont au moins 1 note
																					  { $temoin_has_note=true;	
									//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									                                              //les colonnes notes suivant le nbre d'etape anterieur
										                                                   
																		           
																		               if($careAbout)
																		                {   $tot_grade = $tot_grade + $grade->grade_value;
																		                   $html .=' <td class="period" > '.$grade->grade_value.' </td>';
																		                }
														//fin...			
                                                                                  																					   
																					   }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			             
																			             
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
													  	                   } //fin isset grades
																	  

                                                             }//fin past_period ==null
                                                             
                                                  
											if(($careAbout)||($pastp!=null) )
											  $html .=' <td class="period" ><b> '.$dataProvider[$k][2].'</b></td>';
											else
											   $html .=' <td class="period" ><b></b></td>';
											   		
											  $html .=' </tr> ';             
											  
											             $i++;
														       						                                        
                                                            
														$k=$k+1;
														
										 }
										 
				         
														
//check to include discipline grade
//check to include discipline grade
/*if($include_discipline==1)
  {    												
  	     $html .='<tr class="" > <td class="subject_single"> '.Yii::t('app','Discipline').'  </td>';                                
  	                                      if($past_period!=null)
														   {  
															  foreach($past_period as $id_past_period)
															    {    
															    	$period_acad_id = null;
															    	 $result=EvaluationByYear::model()->searchPeriodName($id_past_period);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
																															  	                   
													  	               																		  	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																		  	 
																		if(($grade_discipline==null))
																	  	   $html .='<td class="period" > --- </td>';
																	  	 else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																	
																		  
													  	                   
																 }//fin foreach past_period
																
																 //current period
																 $period_acad_id = null;
															    	 $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
																		
																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	 $max_grade = $max_grade + $max_grade_discipline;
																	  	 $tot_grade = $tot_grade + $grade_discipline;
																	  	
																	  	if(($grade_discipline==null))
																	  	   $html .='<td class="period" > --- </td>';
																	  	 else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																
																	  						  	                   
																	  
                                                              }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                                 //current period
                                                                 $period_acad_id = null;
															    	 $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }

																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	 $max_grade = $max_grade + $max_grade_discipline;
																	  	 $tot_grade = $tot_grade + $grade_discipline;
																	  	
																	  	 if(($grade_discipline==null))
																	  	   $html .='<td class="period" > --- </td>';
																	  	 else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																
																	  		
                                                               }
                                                               
                                  if(($max_grade_discipline==null)||($max_grade_discipline==0))
                                     $html .=' <td class="period" ><b> --- </b></td></tr>';
                                  else
                                     $html .=' <td class="period" ><b> '.$max_grade_discipline.'</b></td></tr>';                          	 
	}
	 
 */                                                                                     $place_text=null;                     
																					  
                                                                                                               if($place===1)		
                                                                                                                     $place_text=$place.'<span class="place">'.Yii::t('app','st').'</span>';
                                                                                                                                        elseif($place===2)
                                                                                                                                            $place_text=$place.'<span class="place">'.Yii::t('app','nd').'</span>';
																																			elseif($place===3)
                                                                                                                                                $place_text=$place.'<span class="place">'.Yii::t('app','rd').'</span>';
                                                                                                                                               else
                                                                                                                                                 $place_text=$place.'<span class="place">'.Yii::t('app','th').'</span>'; 	          
                                                                                      
                            $average=0;   $general_average=0; $avarage_for_period_fin = 0;
													
							  if(($average_base==10)||($average_base==100)) 
							   { if($max_grade!=0)  
							       $average=round(($tot_grade/$max_grade)*$average_base,2);
							     }
							   else			
								  $average =null;					
													
												
										   $html .= '<tr class="subjectheadnote_white_tr"><td colspan="'.$compter_p.'"> </td></tr>';
										
										          $html .= '<tr class="sommes2"><td class="periodsommes2"><b>'.Yii::t('app','Total: ').'</b></td>';
											                    
												           if($past_period!=null)
														     {  
															    foreach($past_period as $id_past_period)
															      {
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$this->student_id);
																			if(isset($data_))
																			{
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) 
																			       {
																			 
																				     if($_data->sum!=null)
																				         $html .='<td class="periodsommes2_red"> '.$_data->sum.' </td>';
																				     else
																				         $html .='<td class="periodsommes2_red"> --- </td>';
														                            }//fin foreach _data
																				}
																				else
																			      $html .='<td class="periodsommes2_red"> --- </td>';
													  	                     } //fin isset data_
																	   }//fin foreach past period
																	  
																	  //total for the current period 
																	
																			      if($temoin_has_note)
																			           $html .='<td class="periodsommes2_red"> '.$tot_grade.' </td>';
																			       else
																			         $html .='<td class="periodsommes2_red"> --- </td>';
													  	                  
													  	                   
																	   
                                                                   }//fin past period!=null
										                         else
										                          {
										                           //total for the current period 
																
																				  if($temoin_has_note)
																			         $html .='<td class="periodsommes2_red"> '.$tot_grade.' </td>';
																			      else
																			         $html .='<td class="periodsommes2_red"> --- </td>';
													  	                  
	
										                          }
												              $html .='<td class="periodsommes2_red"> <b>'.$max_grade.' </b></td>
												  </tr>
												  
												  <tr class="sommes"><td class="periodsommes"><b>'.Yii::t('app','Average: ').'</b></td>';
														
													$i=0;	
													 if($past_period!=null)
														     {  $i=0;
															    foreach($past_period as $id_past_period)
															      {  
																		$eval=ReportCard::searchEvaluationNameForReportCard($id_past_period);
																		
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$this->student_id);
																			if(isset($data_)){
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) 
																			       {
																			         
																				    $p_name=null;
																				    $p_name= EvaluationByYear::model()-> getPeriodNameByEvaluationID($id_past_period);
																				    
																				    foreach($p_name as $p_name_id)
																				       $p_name_ = $p_name_id;
														       
																				        
								          if( ($eval["weight"]!=100)&&($eval["weight"]!='') )
								            {
								            	$general_avarage_for_period_ = $general_avarage_for_period_ + ($_data->average*$eval["weight"]/100);
								                 $weight_null=false;
								            }
								          else
											 $general_avarage_for_period_ = $general_avarage_for_period_ + ($_data->average);						
											 	            
																					 $i++;
																				     $html .='<td class="period"> '.$_data->average.' </td>';
														                          }//fin foreach _data
																				}
																				else
																			      $html .='<td class="period"> --- </td>';
													  	                   } //fin isset data_
																	   }//fin foreach past period
																	  
																	  //average for the current period 
																	 
																			      
																			      	 $p_name=null;
																				    $p_name= EvaluationByYear::model()-> getPeriodNameByEvaluationID($this->evaluation_id);
																				    
																	$eval=ReportCard::searchEvaluationNameForReportCard($this->evaluation_id);
																				    
																				    foreach($p_name as $p_name_id)
																				       $p_name_ = $p_name_id;
																				       
																				    
										 if( ($eval["weight"]!=100)&&($eval["weight"]!='') )
								            {
								            	$general_avarage_for_period_ = $general_avarage_for_period_ + ($average*$eval["weight"]/100);
								                 $weight_null=false;
								            }
								          else
											 $general_avarage_for_period_ = $general_avarage_for_period_ + ($average);							            
	 
																				    
																			      	if($average!=0)
																			           {
																			           	 $html .='<td class="period"> '.$average.' </td>';
																			           }
																			         else
																			           $html .='<td class="period"> --- </td>';
																			 
													  	                   
                                                                   }//fin isset period
                                                                 else
                                                                   {$i=0;
                                                                   	//average for the current period 
																	  
																			      	 
																			      	  $p_name=null;
																				    $p_name= EvaluationByYear::model()-> getPeriodNameByEvaluationID($this->evaluation_id);
													$eval=ReportCard::searchEvaluationNameForReportCard($this->evaluation_id);							    
																				    foreach($p_name as $p_name_id)
																				       $p_name_ = $p_name_id;
																				       
																				    
										 if( ($eval["weight"]!=100)&&($eval["weight"]!='') )
								            {
								            	$general_avarage_for_period_ = $general_avarage_for_period_ + ($average*$eval["weight"]/100);
								                 $weight_null=false;
								            }
								          else
											 $general_avarage_for_period_ = $general_avarage_for_period_ + ($average);							            
	 

																					 
																					 																			  													         if($average!=0)
																			           { 
																			               $html .='<td class="period"> '.$average.' </td>';
																			           }
																			         else
																			           $html .='<td class="period"> --- </td>';
																			     
                                                                   }
												          						     
												               $html .='<td class="period"> </td>
												  </tr>';
if($include_place==1)
  { 												  
												$html .='  <tr class="sommes1"><td class="periodsommes"><b>'.Yii::t('app','Place:').' </b></td>';
												     if($past_period!=null)
														     {  
															    foreach($past_period as $id_past_period)
															      {
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$this->student_id);
																			if(isset($data_)){
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) {
																			   
																			        $place_text1="";
																					    if($_data->place==1)								        
                                                                                          $place_text1=$_data->place.'<span class="place">'.Yii::t('app','st').'</span>';
                                                                                        elseif($_data->place==2)
                                                                                              $place_text1=$_data->place.'<span class="place">'.Yii::t('app','nd').'</span>';
																				            elseif($_data->place==3)
                                                                                                  $place_text1=$_data->place.'<span class="place">'.Yii::t('app','rd').'</span>';
                                                                                                 else
                                                                                                    $place_text1=$_data->place.'<span class="place">'.Yii::t('app','th').'</span>'; 
																									
																					   $html .='<td class="period"> '.$place_text1.' </td>';
																					  
														                          }//fin foreach _data
																				}
																				else
																			      $html .='<td class="period"> --- </td>';
													  	                   } //fin isset data_
																	   }//fin foreach period
																	   
																	   
																				if($place_text!=null)
																			           $html .='<td class="period"> '.$place_text.' </td>';
																			      else
																			           $html .='<td class="period"> --- </td>';
													  	                   
																	   
                                                                   }//fin past period!=null
                                                                else
                                                                  {   //place for the current period 
                                                                   
																			     if($place_text!=null)
																			          $html .='<td class="period"> '.$place_text.' </td>';
																			      else
																			           $html .='<td class="period"> --- </td>';
													  	                  
													  	                 
                                                                        } 
												            					  
												               $html .='<td class="period">   </td>
												  </tr>';
  }
	

/*
		if($last_eval_) // make G-average								  
		   {
					
						//calculate the general average
							 
							  
				$eval_and_weight = Evaluations::model()->searchAllEvaluations($acad);
				$moyenne =0;
				
												  
							$html .='	<tr class="subjectheadnote_white_tr"><td colspan="'.$compter_p.'"></td></tr>';
							$html .=' <tr class="sommes1">';         				  
												  
												   
					 

         $final_weight=false;
          $final_general_average= 0;

             
               if(($siges_structure==0))
			   {
                        $html .=' <td class="subject"><b>'.Yii::t('app','General Average:').' </b></td>'; 
					
						if($weight_null==false)
						  $general_avarage_for_period_ = round($general_avarage_for_period_,2);
						elseif($weight_null==true)
						    {
						    	$nbr_eval_in_period = EvaluationByYear::model()->getNumberEvaluationInAPeriod($data_current_period["id"], $acad);
						    	
						    	if($nbr_eval_in_period!=0)
						    	  $general_avarage_for_period_ = round( ($general_avarage_for_period_/$nbr_eval_in_period),2);
						    	elseif($nbr_eval_in_period==1)
						    	    $general_avarage_for_period_ = round($general_avarage_for_period_,2);
						     
						     }
						     
					 	     
				//past g-average
				if($pastp!=null)	
				 {	
				 	foreach($pastp as $id_past_period)
					 {
					 	
					 	
					 	$eval=ReportCard::searchPeriodNameForReportCard($id_past_period);
																		
																		$data_=Grades::model()->getDataGeneralAverageByPeriod($acad,$id_past_period,$this->student_id);
																			if(($data_!=null))
																			 {
														                         foreach($data_ as $_data) 
																			       {
																			         
																				    $p_name=null;
																				    $p_name= EvaluationByYear::model()-> getPeriodNameByEvaluationID($id_past_period);
																				    
																				    foreach($p_name as $p_name_id)
																				       $p_name_ = $p_name_id;
														       
																				        
								               if(($use_period_weight==1)&&($this->final_period==true)) // this is the last period
					  	                            $html .='<td class="period"><b>'.$p_name_['name_period'].' <span style="font-size:6pt;"> ('.$eval["weight"].'%)</span> </b>'.$_data['general_average'].'</td>';
					  	                        else
					  	                            $html .='<td class="period"><b>'.$p_name_['name_period'].'   </b>'.$_data['general_average'].'</td>';

                    if($use_period_weight==1)
                    { 
	                     if(($p_name_['weight']!=100)&&($p_name_['weight']!='') )
	                       {  
	                       	  $final_general_average= $final_general_average + (($_data['general_average']*$p_name_['weight'])/100);
	                           $final_weight=true;
	                       }
	                     else
	                      $final_general_average= $final_general_average + ($_data['general_average']);
                     
                    }
                   else
                     $final_general_average= $final_general_average + ($_data['general_average']);
                     
														                          }//fin foreach _data
																				}
																				else
																			      $html .='<td class="period"> --- </td>';
												  	                   
													  	                   
					        
					        
								$numb_period_4_final_GA ++;
					   }
				
				 }
						 
				    
				
				if($general_avarage_for_period_!=null)
				  {
				  	 if(($use_period_weight==1)&&($this->final_period==true)) // this is the last period
				  	    $html .='<td class="period"><b>'.$data_current_period["name_period"].' <span style="font-size:6pt;"> ('.$data_current_period["weight"].'%)</span> </b>'.$general_avarage_for_period_.'</td>';
				  	 else
				  	     $html .='<td class="period"><b>'.$data_current_period["name_period"].'   </b>'.$general_avarage_for_period_.'</td>';
				  	 
				  	 
				  	 if($use_period_weight==1)
				  	  {
					  	 if(($data_current_period['weight']!=100)&&($data_current_period['weight']!='') )
	                        {
	                        	if($pastp==null)//pran period la a 100%
	                        	  $final_general_average= $final_general_average + (($general_avarage_for_period_*100)/100);
	                        	else
	                        	  $final_general_average= $final_general_average + (($general_avarage_for_period_*$data_current_period['weight'])/100);
	                        	
	                            $final_weight=true;	 
	                        }
	                     else
	                      $final_general_average= $final_general_average + ($general_avarage_for_period_);
				  	  }
				  	 else
				  	   $final_general_average= $final_general_average + ($general_avarage_for_period_);
				     
				   }
				else
				  { $html .='<td class="period"> --- </td>';	
				   //
				   }										       
									
					$numb_period_4_final_GA ++; 		 
				 
				 $html .='  </tr> ';
				 
				 
				
															            					  
				
																 
					
								  
					if($this->final_period==true) // this is the last period
	    				{							  
														  
						                     $html .='	<tr class="subjectheadnote_white_tr"><td colspan="'.$compter_p.'"></td></tr>
							        				  
												  
												    <tr class="sommes2"><td class="subject"><b>'.Yii::t('app','Final General Average:').' </b></td>'; 
								                         
								                           
								                       
								                       
								                       if($final_weight==false)
								                        {
								                          if($numb_period_4_final_GA!=0)
								                             $final_general_average = round( ($final_general_average/$numb_period_4_final_GA),2);
								                             
								                         }
								                        elseif($final_weight==true)
								                          {
								                          	 $final_general_average =  round( $final_general_average,2);
								                          	}
								                          
								                       
															 
														 if($final_general_average!=0)
																	    $html .='<td class="period"><b><i>'.$final_general_average.'</i></b></td>';
																	 else
																	  $html .='<td class="period"> --- </td>';	

				  												            					  
												               $html .='
												  </tr>			  
												  ';
												  
			
				            }
				           

			   }
              elseif($siges_structure==1)			
			  {
				  if($weight_null==false)
						  $general_avarage_for_period_ = round($general_avarage_for_period_,2);
						elseif($weight_null==true)
						    {
						    	$nbr_eval_in_period = EvaluationByYear::model()->getNumberEvaluationInAPeriod($data_current_period["id"], $acad);
						    	
						    	if($nbr_eval_in_period!=0)
						    	  $general_avarage_for_period_ = round( ($general_avarage_for_period_/$nbr_eval_in_period),2);
						    	elseif($nbr_eval_in_period==1)
						    	    $general_avarage_for_period_ = round($general_avarage_for_period_,2);
						     
						     }
						     
						     
				  	$html .=' <td class="subject"><b>'.Yii::t('app','General Average:').' </b>'.$general_avarage_for_period_.'</td>'; 
					
				  $html .='  </tr> ';
				 
				  
			  }			  
					   
					   
					   
					   
					   
					   
					   
					   
					   
					   
					   
					   


		     }  
*/		     

$past_period=$pastp; //bcoz c structure=2
		 			     							 

$html .= '</table>&nbsp;<span style="float:right; font-size:9px; color:#000000;text-shadow: 2px 2px 1px #FFF;">.</span>
            </div>';

if(($tardy_absence_display== 1)||($include_discipline==0))
  {				

$html .= '<table  class="discipline">
          <tr><td style="border:0px thin #F9F9F9 ;"></td>';
		   //on ajoute les colonnes suivant le nbre d'etape anterieur
			
			
			 if($past_period!=null)
				{ $compter_p=1; 
				  foreach($past_period as $id_past_period)
					{
					   
					    	$eval=ReportCard::searchPeriodNameForReportCard($id_past_period);
					    
					  $html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;text-align:center;"> <b> '.$eval->name_period.'</b> </span> </td>';
					    
					  
					  		$compter_p++;										
		             }
		            
		             
					        $eval=ReportCard::searchPeriodNameForReportCard($this->evaluation_id);
		            
		                    $html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt; text-align:center;"> <b> '.$eval->name_period.' </b> </span> </td>';

					    
		             
				 }
			else
			  {
			  	$eval=ReportCard::searchPeriodNameForReportCard($this->evaluation_id);
		            
		         $html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;text-align:center;"> <b>'.$eval->name_period.'</b> </span> </td>'; 

			  }
		 
 															   
         $html .=' </tr>';
  
  }
 
 if($tardy_absence_display== 1)
  {				
        
        $html .=  '<tr><td style="border:1px solid #E4E4E4;"> <span style="font-size:9pt;"><b>'.Yii::t('app','RETARD').'</b></span></td>';//on ajoute les colonnes suivant le nbre d'etape anterieur
			
			$period_acad_id = '';
			
			  if($past_period!=null)
				{  
				  foreach($past_period as $id_past_period)
					{
						// $result=EvaluationByYear::model()->searchPeriodName($id_past_period);
									
					    $period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;
					  
						$retard = RecordPresence::model()->getTotalRetardByExam($period_acad_id, $this->student_id, $acad);
						
						$html .='<td style="border:1px solid #E4E4E4;"> '.$retard.' </td>';
																		
		             }
		             
		                // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
											
					   $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
					  
		               $retard = RecordPresence::model()->getTotalRetardByExam($period_acad_id, $this->student_id, $acad);
		               
		               $html .='<td style="border:1px solid #E4E4E4;"> '.$retard.' </td>';
		               
				 }
			  else
			    {
			            // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
														
					   $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
					   
			          $retard = RecordPresence::model()->getTotalRetardByExam($period_acad_id, $this->student_id, $acad);
			          
			          $html .='<td style="border:1px solid #E4E4E4;"> '.$retard.' </td>';	
			     }
			     
		$html .=' </tr>
		   <tr><td style="border:1px solid #E4E4E4;"><span style="font-size:9pt;"><b>'.Yii::t('app','ABSENCE').'</b></span></td>';//on ajoute les colonnes suivant le nbre d'etape anterieur
			 if($past_period!=null)
				{  
				  foreach($past_period as $id_past_period)
					{
						 // $result=EvaluationByYear::model()->searchPeriodName($id_past_period);
															
					    $period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;
					    
						$absc = RecordPresence::model()->getTotalPresenceByExam($period_acad_id, $this->student_id, $acad);
						$html .='<td style="border:1px solid #E4E4E4;"> '.$absc.' </td>';
																		
		             }
		             
		                // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															
					    $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
					    
		               $absc = RecordPresence::model()->getTotalPresenceByExam($period_acad_id, $this->student_id, $acad);
		               $html .='<td style="border:1px solid #E4E4E4;"> '.$absc.' </td>';

				 }
			   else
			     {
			         
			           //  $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															
					  $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
					  
					  $absc = RecordPresence::model()->getTotalPresenceByExam($period_acad_id, $this->student_id, $acad);
			         $html .='<td style="border:1px solid #E4E4E4;"> '.$absc.' </td>';
	
			     }
			     
			     
				$html .='</tr>';
    }
    
    		
//check to include discipline grade
if(($include_discipline!=2)&&($include_discipline!=1))
{
if($include_discipline==0)
  {    												
  	   $html .=' <tr><td style="border:1px solid #E4E4E4;"><span style="font-size:9pt;"><b>'.Yii::t('app','Discipline').'</b></span></td>';//on ajoute les colonnes suivant le nbre d'etape anterieur
                               
  	                                      if($past_period!=null)
				                            {  
				                              foreach($past_period as $id_past_period)
					                            {
					                            	 $period_acad_id = null;
												 	 //$result=EvaluationByYear::model()->searchPeriodName($id_past_period);
															
															$period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;
																															  	                   
													  	                 //check to include discipline grade
																		
																		  	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																		  	 
																		  	if(($grade_discipline==null))
																	  	   $html .='<td style="border:1px solid #E4E4E4;" > --- </td>';
																	  	 else
																	  	    $html .='<td style="border:1px solid #E4E4E4;" > '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																	
																		  
													  	                   
																 }//fin foreach past_period
																
																 //current period
																 $period_acad_id = null;
															    	 //$result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															
															$period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;


	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	 
																	  	
																	  	if(($grade_discipline==null))
																	  	   $html .='<td style="border:1px solid #E4E4E4;"> --- </td>';
																	  	 else
																	  	    $html .='<td style="border:1px solid #E4E4E4;"> '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																
																	  						  	                   
																	  
                                                              }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                                 //current period
                                                                  $period_acad_id = null;
															    	 // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															 
															 $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;

																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id,  $period_acad_id);
	
														  	
																	  	if(($grade_discipline==null))
																	  	   $html .='<td style="border:1px solid #E4E4E4;" > --- </td>';
																	  	 else
																	  	    $html .='<td style="border:1px solid #E4E4E4;" > '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																
																	  		
                                                               }
                                                               
                                 
           
            $html .='</tr>';                          
                                                               	 
	}

}			

if(($tardy_absence_display== 1)||($include_discipline==0))
  {				
				
  	$html .= '</table>';
  	
  }
																	 
$html .= '<div class="" style="font-size:9px; font-weight:bold;" >   
<br/>';

  $section_ = $this->getSectionByStudentId($this->student_id);
 
 $observation = '( '.$period_exam_name.', '.$evaluationPeriod.' ): '.observationReportcard($section_->id,$average,$acad_); //sou tout ane a
	
	 $html .= strtoupper(Yii::t('app','Notes') ).$observation;		     

if($show_observation_line== 1)    
    $html .= '<br/><br/>....................................................................................................................................................................................................................................................................';
    
$html .= '<br/><br/>            
<table class="signature" ><tr>';
 if(($section=="Primaire")||($section=="Fondamental"))
    { 
    	
    	if(($display_administration_signature==1) &&($display_parent_signature!=1))
		{
			 $html .= '<td class="signature1" style="width:70%;">  </td>'
                  . '<td class="signature1" style=" width:30%;">  <hr style="width:100%;" /><div style="text-align: center;">'.$administration_signature_text.'</div> </td>
                      ';
			
		 }	
		elseif($display_administration_signature==1)
    	  {  $html .= '<td class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$administration_signature_text.' </td>
                      <td class="signature1" style="width:2%;">  </td>';
                      
    	    }
			

		if($display_parent_signature==1)
    	  {  $html .= '   <td class="signature1" style=" width:30%;"> <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$parent_signature_text.' </td>';
						
    	   }
    	
    }
  elseif($section=='Secondaire')
    {  
    	    	
    	if(($display_administration_signature==1) &&($display_parent_signature!=1))
		{
			 $html .= '<td class="signature1" style="width:70%;">  </td>'
                  . '<td class="signature1" style=" width:30%;">  <hr style="width:100%;" /><div style="text-align: center;">'.$administration_signature_text.'</div> </td>
                      ';
			
		 }	
		elseif($display_administration_signature==1)
    	  {   $html .= '<td class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$administration_signature_text.' </td>
                      <td class="signature1" style="width:2%;">  </td>';
                      
    	    }
    	    
		
		if($display_parent_signature==1)
    	  { $html .= '  <td class="signature1" style=" width:30%;"> <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$parent_signature_text.' </td>';
						
    	  }
    	  
    }
  else
    {  
    	    	
    	    	if($display_administration_signature==1)
		{
			 $html .= '<td class="signature1" style="width:70%;">  </td>'
                  . '<td class="signature1" style=" width:30%;">  <hr style="width:100%;" /><div style="text-align: center;">'.$administration_signature_text.'</div> </td>
                      ';
			
		 }	
		/*if($display_administration_signature==1)
    	  {   $html .= '<td class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;'.$administration_signature_text.' </td>
                      <td class="signature1" style="width:2%;">  </td>';
                      
    	    }
    	    */
    
    }
  
$html .= '</tr></table>';


if($display_created_date==1)
  $html .= ' <div style="float:right; font-weight:normal;">    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.ChangeDateFormat(date('Y-m-d')).'</div>  </div>   ';

												                         
		                         		                         
//---------- AVERAGE BY PERIOD  ----------------//
 
				//save average for this period			  
						  $command = Yii::app()->db->createCommand();
						   if($temoin_has_note)//
							{//check if already exit
							  $data =  Grades::model()->checkDataAverageByPeriod($acad,$this->evaluation_id,$this->student_id);
							  $is_present=false;
							       if($data)
								     $is_present=true;
								  
                                if($is_present){// yes, update
								
								    $command->update('average_by_period', array(
											'sum'=>$tot_grade,'average'=>$average,'place'=>$place,'date_updated'=>date('Y-m-d'),
										), 'academic_year=:year AND evaluation_by_year=:period AND student=:stud', array(':year'=>$acad, ':period'=>$this->evaluation_id, ':stud'=>$this->student_id));
                                   }
								 else{// no, insert
								   $command->insert('average_by_period', array(
										'academic_year'=>$acad,
										'evaluation_by_year'=>$this->evaluation_id,
										'student'=>$this->student_id,
										'sum'=>$tot_grade,
										'average'=>$average,
										'place'=>$place,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								 
								 
							       }
							
	//---------- GENERAL AVERAGE (END YEAR DECISION)  ---------------//
 
 //save general average for end year decision				
 
 //si 1 peryod c denye eval: $avarage_for_period_
 //si w pran kont de peryod pase: $final_general_average

//general average for each period 
 if($general_avarage_for_period_!=null)
 {
						//save general average for this period			  
						  $command22 = Yii::app()->db->createCommand();
						   
						   //check if already exit
							  
							  $data___=Grades::model()->getDataGeneralAverageByPeriod($acad,$data_current_period["id"],$this->student_id);
							  if((isset($data___))&&($data___!=null))
							  {  // yes, update
						
								    $command22->update('general_average_by_period', array(
											'general_average'=>$general_avarage_for_period_,'date_updated'=>date('Y-m-d'),
										), 'academic_year=:year AND academic_period=:period AND student=:stud', array(':year'=>$acad, ':period'=>$data_current_period["id"], ':stud'=>$this->student_id));
                                   }
								 else{// no, insert
								   $command22->insert('general_average_by_period', array(
										'academic_year'=>$acad,
										'academic_period'=>$data_current_period["id"],
										'student'=>$this->student_id,
										'general_average'=>$general_avarage_for_period_,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								 
								 
							
							   
    }
    
    
   
	        if($this->final_period==true) // this is the last period
	          {     					 
					 $command2 = Yii::app()->db->createCommand();
					 $average_decision_finale=0;
					 
					 if($final_general_average!=0)
					    $average_decision_finale=$final_general_average;
					  elseif($general_avarage_for_period_!=0)
					       $average_decision_finale=$general_avarage_for_period_;
					      else                       
					         $average_decision_finale=null;
					  					  
					  	//check if already exit
				             $result=$this->checkDataGeneralAverage($acad,$this->student_id,$average_decision_finale,$this->idLevel);
							  //$is_present=false;
							if((isset($result))&&($result!=null))
							  {  // yes, update
							       
									  $date_updated=date('Y-m-d');
							     foreach($result as $data)
				                   { 
								      $command2->update('decision_finale', array(
												'general_average'=>$average_decision_finale,'date_updated'=>$date_updated,
											), 'id=:ID', array(':ID'=>$data["id"] ));
	                                  
								     }
								   
							  }
							 else
							  { // no, insert
							        $date_created= date('Y-m-d');
							        
									$command2->insert('decision_finale', array(
									'student'=>$this->student_id,
									'academic_year'=>$acad,
									'general_average'=>$average_decision_finale,
									'current_level'=>$this->idLevel,
									'date_created'=>$date_created,
											
										));
							   }
							   
							   
					        
							  
							  
	          }				 
					  
	      
	  
	  //----------------   END   -----------------//
		
		return $html;
		
		}			

   //end of   htmlReportcard2	
	






public function actionAdmitted()
	{  
		$model=new ReportCard;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelCourse=new Courses;
		$modelEvaluation= new EvaluationByYear;
		$modelGrade=new Grades;
		
		$this->performAjaxValidation($model);
        
		
		if(isset($_POST['Shifts']))
               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
					      $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
	                      Yii::app()->session['Shifts_admit'] = $this->idShift;


								  
						   $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   Yii::app()->session['Sections_admit'] = $this->section_id;
					     						
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   Yii::app()->session['LevelHasPerson_admit'] = $this->idLevel;
						   
						   $modelRoom->attributes=$_POST['Rooms'];
						   $this->room_id=$modelRoom->room_name;
						   Yii::app()->session['Rooms_admit'] = $this->room_id;
						   
						  
						   
						   $modelEvaluation->attributes=$_POST['EvaluationByYear'];
						   $this->evaluation_id=$modelEvaluation->evaluation; 
						   Yii::app()->session['EvaluationByYear_admit'] = $this->evaluation_id;
					
           
			   if((isset($this->room_id))&&($this->room_id!=""))
                 { if((!isset($this->evaluation_id))||($this->evaluation_id==""))
                       $this->messageEvaluation_id_admit=true;
			      }
						   
	             }				   
				else {
				   $this->idShift=null;
                                   $this->section_id=null;
				   $this->idLevel=null;
				   $this->room_id=null;
				   $this->course_id=null;
				   $this->evaluation_id=null;
				   $this->student_id=null;
				   
				  $this->messageEvaluation_id_admit=false;
								
				     }
		
			 if(isset($_POST['create']))
				  { //on vient de presser le bouton
						 //reccuperer la ligne selectionnee()
						  
					   
							     //on retourne l'ID de l'eleve
								$this->redirect(array('reportcard/admitted?stud='.$this->student_id.'&shi='.$this->idShift.'&tot='.$this->tot_stud.'&sec='.$this->section_id.'&lev='.$this->idLevel.'&roo='.$this->room_id.'&ev='.$this->evaluation_id));		
							  
							  								

						
			          
		   }
		   
		   if(isset($_POST['cancel']))
                          {
                              
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }
		
		
		$this->render('admitted',array(
			'model'=>$model,
		));
		
	}

		//for ajaxrequest
public function actionViewContact()
	{  
	    $model=new ReportCard;
        
		
       // Stop jQuery from re-initialization
       Yii::app()->clientScript->scriptMap['jquery.js'] = false;
          
	      
	         
		   $this->renderPartial('viewcontact',array(
				'model'=>$model, ),false,true);
		
		
	}	
	
	
	public function actionReport()
	{   $model=new ReportCard;
         $modelEvaluationByYear = new EvaluationByYear;
		 
		  if(isset($_POST['EvaluationByYear'])){
		  	$modelEvaluationByYear->attributes=$_POST['EvaluationByYear'];
						     $this->evaluation_id=$modelEvaluationByYear->evaluation;
			              
		      
		   
		   }
		
		$this->render('report',array(
			'model'=>$model,
		));
		
	}
	
	public function actionGeneralReport()
	{    $model=new ReportCard;
	    $modelshift = new Shifts;
	    $modelSection = new Sections;
	    $modelCourse = new Courses;
	    
	    $modelEvaluation = new EvaluationByYear;
	    $modelEvaluation1 = new EvaluationByYear;
	    
	    $modelRoom1 = new Rooms;
	    $modelRoom2 = new Rooms;
	    $modelRoom3 = new Rooms;
	    
	   
	   $progress_subject_period_set=true;
	   $progress_student_class_set=true;
	   $repartition_grade_subject_set=true;
	   	  
	    if(isset($_POST['Shifts']))
              {
              	
              	$modelshift->attributes=$_POST['Shifts'];
				   $this->shift_id_rpt=$modelshift->shift_name;
					Yii::app()->session['Shifts-rpt'] = $this->shift_id_rpt;
					
					$progress_student_class_set=false;
					$progress_subject_period_set=false;
					$repartition_grade_subject_set=false;
					 
              	}
              	
		     if(isset($_POST['Sections']))
               	{  
				   $modelSection->attributes=$_POST['Sections'];
				   $this->section_id_rpt=$modelSection->section_name;
					Yii::app()->session['Sections-rpt'] = $this->section_id_rpt;
					
					$progress_student_class_set=false;
					$progress_subject_period_set=false;
					$repartition_grade_subject_set=false;

                   					
	             }				   
				

       if(isset($_POST['ReportCard']['class_average']))
			         { $this->class_average=$_POST['ReportCard']['class_average']; 
			           
			           Yii::app()->session['class_average'] = $this->class_average;
			           
			         }
			       else
	             {
	             	 $this->class_average = Yii::app()->session['class_average'];
	               }
	                
			          
	   if(isset($_POST['ReportCard']['progress_subject_period']))
			         { $this->progress_subject_period=$_POST['ReportCard']['progress_subject_period']; 
			           
			           Yii::app()->session['progress_subject_period'] =$this->progress_subject_period;
			           
			           if($this->progress_subject_period==0)
			             $progress_subject_period_set=false;
			          
			         }
			       else
	             {
	             	$this->progress_subject_period = Yii::app()->session['progress_subject_period'];
	               }
	               
	                  
	    if(isset($_POST['ReportCard']['progress_student_class']))
			         { $this->progress_student_class=$_POST['ReportCard']['progress_student_class']; 
			           
			           Yii::app()->session['progress_student_class'] =$this->progress_student_class;
			           
			           if($this->progress_student_class==0)
			             $progress_student_class_set=false;
			          
			         }
			   else
	             {
	             	$this->progress_student_class = Yii::app()->session['progress_student_class'];
	               }
	               
	                     
	     if(isset($_POST['ReportCard']['repartition_grade_subject']))
			         { $this->repartition_grade_subject=$_POST['ReportCard']['repartition_grade_subject']; 
			           
			           Yii::app()->session['repartition_grade_subject'] =$this->repartition_grade_subject;
			           
			           if($this->repartition_grade_subject==0)
			             $repartition_grade_subject_set=false;
			         
			         } 
	         else
	         {
	         	 $this->repartition_grade_subject = Yii::app()->session['repartition_grade_subject'];   
	           }
	   

	  
	   if(($this->progress_student_class==1))
	    {
			 if(isset($_POST['Rooms'][1]))
       	 	  {
       	 	  	   $modelRoom2->attributes=$_POST['Rooms'][1];
								   $this->room_id_student_class=$modelRoom2->room_name;
								   Yii::app()->session['Rooms-rpt_student_class']=$this->room_id_student_class;
								   
					$progress_student_class_set=false;
					
					
                    
					
       	 	  	}
       	 	  
              	
	   }  
	   
	   
	 if(($this->progress_subject_period==1))
	    {
			 if(isset($_POST['Rooms'][2]))
       	 	  {
       	 	  	   $modelRoom1->attributes=$_POST['Rooms'][2];
								   $this->room_id_subject_period=$modelRoom1->room_name;
								   Yii::app()->session['Rooms-rpt_subject_period']=$this->room_id_subject_period;
					
					$progress_subject_period_set=false;
					
					
							
       	 	  	}
       	 	       	 	              	
	   }
	        	
     
     if(($this->repartition_grade_subject==1))
	    {
			 if(isset($_POST['Rooms'][3]))
       	 	  {
       	 	  	   
       	 	  	   $modelRoom3->attributes=$_POST['Rooms'][3];
								   $this->room_id_grade_subject=$modelRoom3->room_name;
								   Yii::app()->session['Rooms-rpt_grade_subject']=$this->room_id_grade_subject;
			       
			       $repartition_grade_subject_set=false;
					
       	 	  }
       	 	  
			if(isset($_POST['Courses']))
       	 	  {				   
				   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id_grade_subject=$modelCourse->subject;
								   Yii::app()->session['Courses-rpt_grade_subject']=$this->course_id_grade_subject;
					               
						$repartition_grade_subject_set=false;	
       	 	  	}
       	 	  	
       	 	if(isset($_POST['EvaluationByYear'][1]))
       	 	  {
       	 	  	$modelEvaluation1->attributes=$_POST['EvaluationByYear'][1];
				   $this->eval_id_grade_subject=$modelEvaluation1->evaluation;
					Yii::app()->session['EvaluationByYear-grade-subject'] = $this->eval_id_grade_subject;
					
					$repartition_grade_subject_set=false;
       	 	  	}
       	 	else
       	 	 {
       	 	 	   //return an id(number)
		            $lastPeriod1 = $this->getLastEvaluationInGrade();
		            $this->eval_id_grade_subject = $lastPeriod1;
		            
		            Yii::app()->session['EvaluationByYear-grade-subject'] = $this->eval_id_grade_subject;

       	 	 	}

       	 	
       	 	       	 	              	
	   }
    
	
	if($this->class_average==1)
	    {
			 if(isset($_POST['EvaluationByYear']))
       	 	  {
       	 	  	$modelEvaluation->attributes=$_POST['EvaluationByYear'];
				   $this->eval_id_class_average=$modelEvaluation->evaluation;
					Yii::app()->session['EvaluationByYear-class-average'] = $this->eval_id_class_average;
				
				   if($this->eval_id_class_average=='')	
					{   
	       	 	 	   //return an id(number)
			            $lastPeriod2 = $this->getLastEvaluationInGrade();
			            $this->eval_id_class_average = $lastPeriod2;
			            
			            Yii::app()->session['EvaluationByYear-class-average'] = $this->eval_id_class_average;
	
	       	 	 	  }
					
       	 	  	}
       	 	 else
       	 	 {  
       	 	 	   //return an id(number)
		            $lastPeriod2 = $this->getLastEvaluationInGrade();
		            $this->eval_id_class_average = $lastPeriod2;
		            
		            Yii::app()->session['EvaluationByYear-class-average'] = $this->eval_id_class_average;

       	 	 	}
       	 	 
       	 	 
              	
	   } 
	   
	   if(isset($_GET['stud1'])&&($_GET['stud1']!=0)&&($progress_student_class_set))
	    { 
	       
	       $this->class_average = Yii::app()->session['class_average'];
		   $this->progress_subject_period = Yii::app()->session['progress_subject_period'];
		   $this->repartition_grade_subject = Yii::app()->session['repartition_grade_subject'];
		   
		   
		   $this->room_id_subject_period = Yii::app()->session['Rooms-rpt_subject_period'];
		   $this->room_id_grade_subject = Yii::app()->session['Rooms-rpt_grade_subject'];
		   
		   
		   $this->course_id_grade_subject = Yii::app()->session['Courses-rpt_grade_subject'];
		   $this->eval_id_grade_subject = Yii::app()->session['EvaluationByYear-grade-subject'];
	    
	     }
	     
	   if(isset($_GET['stud2'])&&($_GET['stud2']!=0)&&($progress_subject_period_set))
	    {  
	       
	       $this->class_average = Yii::app()->session['class_average'];
		   $this->progress_student_class = Yii::app()->session['progress_student_class'];
		   $this->repartition_grade_subject = Yii::app()->session['repartition_grade_subject'];
		   
		   $this->room_id_student_class = Yii::app()->session['Rooms-rpt_student_class'];
		   
		   $this->room_id_grade_subject = Yii::app()->session['Rooms-rpt_grade_subject'];
	      
	      
	       $this->course_id_grade_subject = Yii::app()->session['Courses-rpt_grade_subject'];
		   $this->eval_id_grade_subject = Yii::app()->session['EvaluationByYear-grade-subject'];
	       
	     
	     }
	     
	  if(isset($_GET['stud3'])&&($_GET['stud3']!=0)&&($repartition_grade_subject_set))
	    { 
	       
	       $this->class_average = Yii::app()->session['class_average'];
		   $this->progress_subject_period = Yii::app()->session['progress_subject_period'];
		   $this->progress_student_class = Yii::app()->session['progress_student_class'];
		   
		   $this->room_id_student_class = Yii::app()->session['Rooms-rpt_student_class'];
		   $this->room_id_subject_period = Yii::app()->session['Rooms-rpt_subject_period'];
		  
		  
		   $this->course_id_grade_subject = Yii::app()->session['Courses-rpt_grade_subject'];
		   $this->eval_id_grade_subject = Yii::app()->session['EvaluationByYear-grade-subject'];
	       
	    
	     }
	     
			     
	 		     
					 
		$this->render('generalReport',array(
			'model'=>$model,
		
	    
	    
		));
		
		
		
	}
	
	
	
	
	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['ReportCard']))
		{
			$model->attributes=$_POST['ReportCard'];
			
	     if(isset($_POST['cancel']))
          {
			$model->setAttribute('date_updated',date('Y-m-d'));
		
			if($model->save())
				$this->redirect (array('index'));
				
           }
           
           
		    if(isset($_POST['cancel']))
                          {
                             
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete()
	{
		
		
		try {
   			 $this->loadModel()->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect( array('index'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			       
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}



	}



	public function actionIndex()
	{
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new ReportCard('search');
		if(isset($_GET['ReportCard']))
			$model->attributes=$_GET['ReportCard'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
     
	     

	
	public function actionAdmin()
	{
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new ReportCard('search');
		if(isset($_GET['ReportCard']))
			$model->attributes=$_GET['ReportCard'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	        

	  	
	

	
		

public function actionEndYearDecision() 
	{  
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');
		
		$model=new ReportCard;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		
		$modelGrade=new Grades;
		
		
		$this->performAjaxValidation($model);
		
		$check =$this->isCheck; //for admitted stud
		$check2 =$this->isCheck2; //for failed stud
        
		
		if(isset($_POST['Shifts']))
               	{ 
               		 if($_POST['Shifts']!=null)//on n'a pas presser le bouton, il fo load apropriate rooms
					 {    $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
			              unset(Yii::app()->session['ShiftsAdmit']);
	                      Yii::app()->session['ShiftsAdmit'] = $this->idShift;


								  
						   $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   unset(Yii::app()->session['SectionsAdmit']);
						   Yii::app()->session['SectionsAdmit'] = $this->section_id;
					     						
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						  if($this->idLevel != Yii::app()->session['LevelHasPersonAdmit'])
						    {
						        Yii::app()->session['isPresent']=0;
						        Yii::app()->session['isPresent2']=0;
						        	Yii::app()->session['RoomsAdmit'] = 0;
						        	$this->room_id=0;
					
						      }
						    else
						      {
						      	$modelRoom->attributes=$_POST['Rooms'];
						   $this->room_id=$modelRoom->room_name;
						   

						   if($this->room_id != Yii::app()->session['RoomsAdmit'])
						    {
						        Yii::app()->session['isPresent']=0;
						        Yii::app()->session['isPresent2']=0;
						        	
						      }
						   unset(Yii::app()->session['RoomsAdmit']);
						   Yii::app()->session['RoomsAdmit'] = $this->room_id;
						      	
						      	
						      	}
						   
						   unset(Yii::app()->session['LevelHasPersonAdmit']);
						   Yii::app()->session['LevelHasPersonAdmit'] = $this->idLevel;
						   
						   
						   
						 
					      
					   
						   if((isset($this->room_id))&&($this->room_id!=0))
							 { 
									  //for admitted stud
									  if(isset($_POST['check_all']))
									   {  
										     if(isset($_POST['t_comment']))
										        $this->comment=$_POST['t_comment'];
									   
											   Yii::app()->session['comment_admit'] = $this->comment;
											   $check++;
											  if(($check % 2)==0)
												$this->isCheck=0;
											  else
												$this->isCheck=1;
												
											if(isset($_POST['t_comment2']))
										        $this->comment2=$_POST['t_comment2'];
									   
											   Yii::app()->session['comment2_admit'] = $this->comment2;

										 
										   
										   
									   }
									 
									 //for failed stud
									 if(isset($_POST['check_all2']))
									   {  
										    if(isset($_POST['t_comment2']))
										        $this->comment2=$_POST['t_comment2'];
									   
											   Yii::app()->session['comment2_admit'] = $this->comment2;
											   $check2++;
											  if(($check2 % 2)==0)
												$this->isCheck2=0;
											  else
												$this->isCheck2=1;
												
											 if(isset($_POST['t_comment']))
										        $this->comment=$_POST['t_comment'];
									   
											   Yii::app()->session['comment_admit'] = $this->comment;
										 
										   
										   
									   }
								
								
								if(isset($_POST['ReportCard']))
								    $model->mention=$_POST['ReportCard']['mention'];
								
													   
								   
							  }
							else
							 { 
								
								 Yii::app()->session['Temp_value']="";//for admitted stud
								 Yii::app()->session['Temp_value2']="";//for failed stud
								 Yii::app()->session['comment_admit']="";//for admitted stud
								 Yii::app()->session['comment2_admit']="";//for failed stud
							 }
							  
							 
				
						}
                       else	
                        {
						    
							 $this->idShift="";
                                   $this->section_id="";
							   $this->idLevel="";
							   $this->room_id="";
							   $this->student_id="";
								Yii::app()->session['Shifts_admit']="";
							  Yii::app()->session['Sections_admit']="";
							  Yii::app()->session['LevelHasPerson_admit']="";
							  Yii::app()->session['Rooms_admit']="";
							  
							  Yii::app()->session['tot_stud_end_year']=0;
							   
							  
							  $this->messageDecisionDone=false;
							  $this->$messageNoCheck=0;
							  
							  
							   $this->comment="";
							   $this->comment2="";
							   Yii::app()->session['Temp_value']="";
							   Yii::app()->session['Temp_value2']="";
								Yii::app()->session['comment_admit']="";
								Yii::app()->session['comment2_admit']="";
						}					   
	             
				 }
               else // $_POST['Shifts'] not set
                 {
				            
							 $this->idShift="";
                                                          $this->section_id="";
							   $this->idLevel="";
							   $this->room_id="";
							   $this->student_id="";
								Yii::app()->session['Shifts_admit']="";
							  Yii::app()->session['Sections_admit']="";
							  Yii::app()->session['LevelHasPerson_admit']="";
							  Yii::app()->session['Rooms_admit']="";
							
							  Yii::app()->session['tot_stud_end_year']=0;
							   
							  
							  $this->messageDecisionDone=false;
							  $this->messageNoCheck=0;
							  
							  
							   $this->comment="";
							   $this->comment2="";
							   Yii::app()->session['Temp_value']="";
							   Yii::app()->session['Temp_value2']="";
								Yii::app()->session['comment_admit']="";
								Yii::app()->session['comment2_admit']="";
								
				     }
						 
			
			if(isset($_POST['execute']))
				  {  
				    					
					//Extract use automatic mention
                                $use_automatic_mention = infoGeneralConfig('use_automatic_mention');
							  //si classe la nan ekzamen ofisyel pa bay mention otomatik
								   	  $menfp = '';
								   	  $menfp_average=0;
	   	   
			                    $model_menfp=isLevelExamenMenfp($this->idLevel,$acad_sess);
			      
							      if($model_menfp !=null)
							        $menfp = $model_menfp['id'];

                     if( (($use_automatic_mention!=1)||($menfp!='')) && ((!isset($model->mention)||($model->mention==null)) ) )
                      { //pa ekzekite
                          Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Please specify: SUCCESSED STUDENT(S) or FAILLED STUDENT(S).') );
                      }
                     else
                     {
                     	
                     	if(Yii::app()->session['isPresent']==1)
					  {  Yii::app()->session['isPresent']=0;
					    $this->comment=$_POST['t_comment'];
						Yii::app()->session['comment_admit'] = $this->comment;
				         $this->data_EYD = Yii::app()->session['Temp_value'];
					   }
					   
					if(Yii::app()->session['isPresent2']==1)   
					  {  
					  	Yii::app()->session['isPresent2']=0;
					     $this->comment2=$_POST['t_comment2'];
						 Yii::app()->session['comment2_admit'] = $this->comment2;
				         $this->data_EYD2 = Yii::app()->session['Temp_value2'];
				         
				       }
                    
					   $this->messageNoCheck=1;


					//otomatik ou pa, pati sa ap ekzekite paske li komen
					//proceed for checked students 
						if(isset($_POST['olone_check']))
						     {   $indice=0;
							     $this->messageNoCheck=2;
							     
							    foreach($_POST['olone_check'] as $position1)
					             { 
								      $data[8]=null;
                                     $i=0;
                                     
								    foreach($this->data_EYD[$position1] as $r)
								      { $data[$i]=$r;
								         $i++;
								       }
								 
																		
									     $stud=$data[0];
										 $acad_sess=$data[1];
										
									//
									if($menfp!='')//al cheche mwayen menfp elev la pou met nan desizyon final la
									 {	
									 	$menfp_average=$data[2]; // mwayen lekol la par dfo
									 	
									 	$menfp_decision = MenfpDecision::model()->checkDecisionMenfp($stud,$acad_sess);
									     
									     if( (isset($menfp_decision))&&($menfp_decision!=null) )
									      { foreach($menfp_decision as $menfp_deci)
									           $menfp_average = $menfp_deci['average']; 
									      }
									     
									     $gen_average=$menfp_average;
										 
										 //$mention=$model->mention;
										 
										 $nextLevel=null;
										 
										 if($model->mention==0)
										  { $is_move=1;
										        
										    $mention = infoGeneralConfig('success_mention');
	  
										    $model_next_l=new Levels;
											   $result=$model_next_l->getNextLevel($this->idLevel);
											   if((isset($result))&&($result!=""))
												  { $r=$result->getData();
													 foreach($r as $l)
														$nextLevel=$l->id;
												  }
												  
										      if($siges_structure==0)
										         $next_level=$nextLevel;
										      elseif($siges_structure==1)
										          $next_level=$data[6];//current level: $this->idLevel;
										   }
										 elseif($model->mention==1)
										   { $is_move=0;
										   
										     $mention = infoGeneralConfig('failure_mention');
										     
										      $next_level= $data[6];//current level: $this->idLevel
										   }
										   
										   
											  
										
									 }
									else	 
									 {	 $gen_average=$data[2];
										 
										 $mention=$data[3];
										 
										 $is_move=$data[5];
										 
										 if($siges_structure==0)
										         $next_level=$data[7];
										      elseif($siges_structure==1)
										          $next_level=$data[6];//current level: $data[7];
									 }
										 
										 
										 $comment=$this->comment[$position1];
										 
										 $current_level=$data[6];
										 
									
									 $date_created= date('Y-m-d');
									  $date_updated=date('Y-m-d');
									  
									  $create_by = Yii::app()->user->name;
									  $update_by = Yii::app()->user->name;
									  
									  $comment1_update = 0;
									  foreach($this->comment as $number1) 
									       $comment1_update++; 
									  for($p1 = $position1; $p1< $comment1_update-1; $p1++)  
									    {   
									      if(isset($this->comment[$p1+1]))
									    	{  $commentsss1=$this->comment[$p1+1]; 
									      
										        if($commentsss1=="")
										          $this->comment[$p1]=""; 
										        else
										           $this->comment[$p1]=$commentsss1 ; 
									    	}
									           
									    }
									  Yii::app()->session['comment_admit'] = $this->comment;
									
									 $command = Yii::app()->db->createCommand();
									 
									//check  record ID already stored in table decision_finale
									$is_there = $this->checkDecisionFinale($stud, $acad_sess);                                                         
								   
									if((isset($is_there))&&($is_there!=null))
									  {  //yes let's make an update
									     foreach($is_there as $result)
									       {                          
									     $command->update('decision_finale', array(
												'general_average'=>$gen_average, 'mention'=>$mention,'comments'=>$comment,'is_move_to_next_year'=>$is_move,'next_level'=>$next_level,'update_by'=>$update_by, 'date_updated'=>$date_updated,
											), 'id=:ID', array(':ID'=>$result["id"] ));
											 
									       }
									  }	
									  					   
									elseif($is_there==null) //record not exist in the table
									  {
									
										    $command->insert('decision_finale', array(
											'student'=>$data[0],
											'academic_year'=>$acad_sess,//$data[1],
											'general_average'=>$gen_average,
											'mention'=>$mention, 
											'comments'=>$comment, 
											'is_move_to_next_year'=>$is_move, 
											'current_level'=>$data[6], 
											'next_level'=>$next_level, 
											'create_by'=>$create_by,
											'update_by'=>$update_by,
											'date_created'=>$date_created, 
											'date_updated'=>$date_updated,
											
												));


									   }
									  
									   
							 }
						   
						   if($siges_structure==1)
						     {
						        //voye enfo nan year_migration_check
						              $command_0 = Yii::app()->db->createCommand();
										   	       
										   	       $command_0->insert('year_migration_check', array(
														'period'=>1,
														'postulant'=>0,
														'course'=>1,
														'evaluation'=>1,
														'passing_grade'=>0,
														'reportcard_observation'=>0,
														'fees'=>1,
														'taxes'=>1,
														'pending_balance'=>0,
														'academic_year'=>$acad_sess,
														'create_by'=>Yii::app()->user->name,
		                                                'date_created'=>date('Y-m-d'),
			 
														
													));	
						     	
						      }
						   
						} 
						  
						              			
                     }
//______________________________________             			
             			//sa a ap ekzekite sou kondisyon ke li otomatik
             			     
			   	 if( ($use_automatic_mention==1)&&($menfp=='') ) //mansyon an otomatik
			   	    {   				
						if(isset($_POST['olone_check2']))
						     {   $indice=0;
							     $this->messageNoCheck=2;
							    foreach($_POST['olone_check2'] as $position)
					             { 
								    									 
                                     $data[8]=null;
                                     $i=0;
                                     
								    foreach($this->data_EYD2[$position] as $r)
								      { $data[$i]=$r;
								         $i++;
								       }
								 
																		
									     $stud=$data[0];
										 $acad_sess=$data[1];
										 $gen_average=$data[2];
										 $mention=$data[3];
										 $comment=$this->comment2[$position];//$r[4];
										 $is_move=$data[5];
										 $current_level=$data[6];
										 $next_level=$data[7];
										  
	                          


									      
									 
									 $date_created= date('Y-m-d');
									  $date_updated=date('Y-m-d');
									  
									   $comment2_update = 0;
									  foreach($this->comment2 as $number) 
									       $comment2_update++; 
									  for($p = $position; $p< $comment2_update-1; $p++)  
									    {   
									    	$commentsss=$this->comment2[$p+1]; 
									    	
									        if($commentsss=="")
									          $this->comment2[$p]=""; 
									        else
									           $this->comment2[$p]=$commentsss ; 
									    }
									  Yii::app()->session['comment2_admit'] = $this->comment2;  
									  
									  $command2 = Yii::app()->db->createCommand();
									
									//check if record already in table
									$is_there = $this->checkDecisionFinale($stud, $acad_sess);                                                         
								   
									if((isset($is_there))&&($is_there!=null))
									  {  //yes let's make an update
									     foreach($is_there as $result)
									       {   
									       $command2->update('decision_finale', array(
												'mention'=>$mention,'comments'=>$comment,'is_move_to_next_year'=>$is_move,'next_level'=>$next_level,'update_by'=>Yii::app()->user->name,'date_updated'=>$date_updated,
											), 'id=:ID', array(':ID'=>$result["id"] ));
											
									       }
									  }						   
									elseif($is_there==null) //record not exist in the table
									  {
							              
											$command2->insert('decision_finale', array(
											'student'=>$data[0],
											'academic_year'=>$data[1],
											'general_average'=>$data[2],
											'mention'=>$data[3], 
											'comments'=>$comment, 
											'is_move_to_next_year'=>$data[5], 
											'current_level'=>$data[6], 
											'next_level'=>$data[7], 
											'create_by'=>Yii::app()->user->name,
											'update_by'=>Yii::app()->user->name,
											'date_created'=>$date_created, 
											'date_updated'=>$date_updated,
											
												));
										
										
									      
										
									   }
									   
									
					                }
							   
							   }
						
						}
						
						
					
 
					
					
                   }
                   
                 
                 if(isset($_POST['cancel']))
                          {
                              
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }
                          
                if(isset($_POST['view']))
                          {
                             $this->redirect(array('/reports/reportcard/viewDecision/from/stud' )) ;
                          }
               
               if(isset($_POST['update']))
                          {
                             $this->redirect(array('/reports/reportcard/updateEndYearDecision/sh/'.$this->idShift.'/se/'.$this->section_id.'/le/'.$this->idLevel.'/ro/'.$this->room_id.'/from/' )) ;
                          }
			 					 
		  
		
		$this->render('endYearDecision',array(
			'model'=>$model,
		));
		
	}
	
	
public function actionUpdateEndYearDecision() 
	{  
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');

$next_acad_sess= AcademicPeriods::model()->getNextAcademicYear($acad_sess);
		
		$model=new ReportCard;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		
		$modelGrade=new Grades;
		
		
		$this->performAjaxValidation($model);
		
		
		
				    /*        
							 $this->idShift="";
                                                          $this->section_id="";
							   $this->idLevel="";
							   $this->room_id="";
							   $this->student_id="";
								Yii::app()->session['Shifts_admit']="";
							  Yii::app()->session['Sections_admit']="";
							  Yii::app()->session['LevelHasPerson_admit']="";
							  Yii::app()->session['Rooms_admit']="";
							
							  Yii::app()->session['tot_stud_end_year']=0;
							   
							   Yii::app()->session['Temp_value']="";
							   Yii::app()->session['Temp_value2']="";
								Yii::app()->session['comment_admit']="";
								Yii::app()->session['comment2_admit']="";
						*/		
				    
				
				if(isset($_POST['ReportCard']['student_name']))
				  $this->student_id = $_POST['ReportCard']['student_name'];	
				  
				
		                 
		                   

		 	       
		 	     
		     $mention = null;
		            			
			if(isset($_POST['update']))
				  {  
				    if(isset($_POST['success']))
				      $mention = $_POST['success'];					
					
					
					
							  //si classe la nan ekzamen ofisyel pa bay mention otomatik
								   	  $menfp = '';
								   	  $menfp_average=0;
	   	   
			                    $model_menfp=isLevelExamenMenfp($_GET['le'],$acad_sess);
			      
							      if($model_menfp !=null)
							        $menfp = $model_menfp['id'];
							        
							        

                     if( $mention==null )
                      { //pa ekzekite
                          Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Please specify: SUCCESSED STUDENT(S) or FAILLED STUDENT(S).') );
                      }
                     else
                     {
									$average = Yii::app()->session['d_u_average'];
		               			   $success_mention = Yii::app()->session['d_u_success_mention'];
		               			    $level = Yii::app()->session['d_u_level'];	
								      							
			 						     $stud=$this->student_id;
									 
										
									//
									if($menfp!='')//al cheche mwayen menfp elev la pou met nan desizyon final la
									 {	
									 	$menfp_average=$average; // mwayen lekol la par dfo
									 	
									 	$menfp_decision = MenfpDecision::model()->checkDecisionMenfp($stud,$acad_sess);
									     
									     if( (isset($menfp_decision))&&($menfp_decision!=null) )
									      { foreach($menfp_decision as $menfp_deci)
									           $menfp_average = $menfp_deci['average']; 
									      }
									     
									     $gen_average=$menfp_average;
										 
										 //$mention=$model->mention;
										 
										 $nextLevel=null;
										 
										 if($mention==1)
										  { $is_move=1;
										        
										    $mention = infoGeneralConfig('success_mention');
	  
										    $model_next_l=new Levels;
											   $result=$model_next_l->getNextLevel($level);
											   if((isset($result))&&($result!=""))
												  { $r=$result->getData();
													 foreach($r as $l)
														$nextLevel=$l->id;
												  }
												  
										      if($siges_structure==0)
										         $next_level=$nextLevel;
										      elseif($siges_structure==1)
										          $next_level=$level;//current level: $this->idLevel;
										   }
										 elseif($mention==0)
										   { $is_move=0;
										   
										     $mention = infoGeneralConfig('failure_mention');
										     
										      $next_level= $level;//current level: $this->idLevel
										   }
										   
										   
											  
										
									 }
									else	 
									 {	 $gen_average=$average;
										 
										 $mention_=$success_mention;
										 
										 if($mention==1)
										   $is_move=1;
										 elseif($mention==0)
										    $is_move=0;
										 
										 if($siges_structure==0)
										        {  if($is_move==0)
										                 $next_level=$level;
										           elseif($is_move==1)
										              {  
										              	 $nextLevel = null;
										              
										              	   $model_next_l=new Levels;
														   $result=$model_next_l->getNextLevel($level);
														   if((isset($result))&&($result!=""))
															  { $r=$result->getData();
																 foreach($r as $l)
																	$nextLevel=$l->id;
															  }
															  
															  $next_level= $nextLevel;

										              	
										              	}
										        
										        }
										      elseif($siges_structure==1)
										          $next_level=$level;//current level: $this->data_EYD3[7];
									 }
										 
										 
										 
										 $current_level=$level;
										 
									
									 $date_updated=date('Y-m-d');
									  
									  $update_by = Yii::app()->user->name;
									  
									 
									 $command = Yii::app()->db->createCommand();
									 
									//check  record ID already stored in table decision_finale
									$is_there = $this->checkDecisionFinale($stud, $acad_sess);                                                         
								   
									if((isset($is_there))&&($is_there!=null))
									  {  //yes let's make an update
									     foreach($is_there as $result)
									       {  
									       	                        
									     $command->update('decision_finale', array(
												'general_average'=>$gen_average, 'checked'=>0,'mention'=>$mention_,'is_move_to_next_year'=>$is_move,'next_level'=>$next_level,'update_by'=>$update_by, 'date_updated'=>$date_updated,
											), 'id=:ID', array(':ID'=>$result["id"] ));
											 
											
											 					 
											 Yii::app()->user->setFlash(Yii::t('app','Success'), Yii::t('app','Operation terminated successfully.') );
											 
											 $this->student_id = null;
								 				unset(Yii::app()->session['d_u_average']);
		               			                unset(Yii::app()->session['d_u_success_mention']);

									       }
									  }	
									  					   
									elseif($is_there==null) //record not exist in the table
									  {
									
										    $command->insert('decision_finale', array(
											'student'=>$this->student_id,
											'academic_year'=>$acad_sess,//$this->data_EYD3[1],
											'general_average'=>$gen_average,
											'mention'=>$mention_, 
											'is_move_to_next_year'=>$is_move, 
											'current_level'=>$level, 
											'next_level'=>$next_level, 
											'create_by'=>$update_by,
											'update_by'=>$update_by,
											'date_created'=>$date_updated, 
											'date_updated'=>$date_updated,
											
												));
												
										
												
										 Yii::app()->user->setFlash(Yii::t('app','Success'), Yii::t('app','Operation terminated successfully.') );
												
												$this->student_id = null;
								 				unset(Yii::app()->session['d_u_average']);
		               			                unset(Yii::app()->session['d_u_success_mention']);
		               			


									   }
									  
									   
							 
						                  if($siges_structure==0)
											     {
											        //voye enfo nan year_migration_check
											              $command_0 = Yii::app()->db->createCommand();
														$command_0->update('year_migration_check', array(
																	'student'=>0, 'update_by'=>$update_by,
																), 'academic_year=:ID', array(':ID'=>$next_acad_sess ));	
											     	
											      }
									       if($siges_structure==1)
											     {
											        //voye enfo nan year_migration_check
											              $command_0 = Yii::app()->db->createCommand();
														$command_0->update('year_migration_check', array(
																	'student'=>0, 'update_by'=>$update_by,
																), 'academic_year=:ID', array(':ID'=>$acad_sess ));	
											     	
											      }


						  						   
						 
						  
						              			
                     }
					
					
                   }
                   
                 
                 if(isset($_POST['cancel']))
                          {
                              
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }
                
               
			 					 
		  
		
		$this->render('endYearDecisionUpdate',array(
			'model'=>$model,
		));
		
	}	
	
	
//return a string
public function getResultForReportSubjectParent($student_id,$subject_p,$evaluation_date,$room, $acad)
 {
 	 $tot_grade=0;
 	 $tot_weight=0;
 	 $period_id = 0;
 	 $bool=false;
 	
 	
 	 $evaluation = EvaluationByYear::model()->getPeriodNameByEvaluationDATE($evaluation_date);
 	                   
 	 foreach($evaluation as $eval)
 	   $period_id=$eval["id_by_year"];
 	   
 	
 	  $condition = 'subject0.subject_parent='.$subject_p.' AND ';
 	  $course_child = Courses::model()->searchReport($condition,$acad);
 	  $course_child=$course_child->getData();//return a list of Course objects
 	   foreach($course_child as $course)
		{	//pou chak pitit, nap gade si te gen evalyasyon pou li
 	        $result=Courses::model()->evaluatedSubject($course->id,$room,$period_id);		   
				if(isset($result))
				  {  $Course=$result->getData();//return a list of Course objects
				        
					 foreach($Course as $i)
					  {			   
						 if($i->id!=null)
						   {    $bool=true;
						       break;
						   }
						   
					   }  
				   }
			if($bool)
			  { //pran not li
			     $grade= Grades::model()->getGradeByStudentCourseEvaluation_id($student_id,$course->id, $evaluation_date, $acad);
  	               $tot_grade = $tot_grade + $grade; 
  	            //pran koyefisyan l 
  	              $weight = Courses::model()-> getCourseWeight($course->id);	        
			        $tot_weight = $tot_weight + $weight;
			        
			        $bool=false;
			   }
		
		 } 
		 
		if($tot_weight==0)
		   return '---';
		else
		   return ($tot_grade.'/'.$tot_weight);

		
 }


//return a string
public function getCourseAverageForReportSubjectParent($subject_p,$evaluation_date,$room, $acad)
 {
 	 $tot_grade=0;
 	 $tot_weight=0;
 	 $period_id = 0;
 	 $bool=false;
$compter_course = 0;
$grade_array = array();
$class_average_value = 0;
	
 	
 	 $evaluation = EvaluationByYear::model()->getPeriodNameByEvaluationDATE($evaluation_date);
 	                   
 	 foreach($evaluation as $eval)
 	   $period_id=$eval["id_by_year"];
 	   
 	 
 	  $condition = 'subject0.subject_parent='.$subject_p.' AND ';
 	  $course_child = Courses::model()->searchReport($condition,$acad);
 	  $course_child=$course_child->getData();//return a list of Course objects
 	   foreach($course_child as $course)
		{	
			$j = 0;
            $grade_array = array();
            

			//pou chak pitit, nap gade si te gen evalyasyon pou li
 	        $result=Courses::model()->evaluatedSubject($course->id,$room,$period_id);		   
				if(isset($result))
				  {  $Course=$result->getData();//return a list of Course objects
				        
					 foreach($Course as $i)
					  {			   
						 if($i->id!=null)
						   {    $bool=true;
						       break;
						   }
						   
					   }  
				   }
			if($bool)
			  { 
			  	$grade=Grades::model()->searchByRoom($course->id, $period_id);
						             
				  if(isset($grade)&&($grade!=null))
				   { 
				      $grade___=$grade->getData();//return a list of  objects
		                               
		               if($grade___!=null)
						{ 	
		           		  foreach($grade___ as $g) 
							{	
							  if($g->grade_value=='')
							    $grade_array[$j] = 0;
							  else
							    $grade_array[$j] = $g->grade_value;

       	     
							     $j++;
							}
										    
						  }
						
						$compter_course++;						                
				    }

	
	            $class_average_value = $class_average_value + round($this->average_for_array($grade_array),2);
			    
			        
			        
			        $bool=false;
			   }
		
		 } 
		 
		if($compter_course==0)
		   return '---';
		else
		   return (round($class_average_value/$compter_course,2)); 

		
 }


//return a string
public function getCourseAverageForReportSubjectSimple($course_id,$evaluation_date,$room, $acad)
 {
 	 $tot_grade=0;
 	 $tot_weight=0;
 	 $period_id = 0;
 	 $bool=false;
$compter_course = 0;
$grade_array = array();
$class_average_value = 0;
	
 	
 	 $evaluation = EvaluationByYear::model()->getPeriodNameByEvaluationDATE($evaluation_date);
 	                   
 	 foreach($evaluation as $eval)
 	   $period_id=$eval["id_by_year"];
 	   
 	 
 		
			$j = 0;
            $grade_array = array();
            

			//pou kou sa, nap gade si te gen evalyasyon pou li
 	        $result=Courses::model()->evaluatedSubject($course_id,$room,$period_id);		   
				if(isset($result))
				  {  $Course=$result->getData();//return a list of Course objects
				        
					 foreach($Course as $i)
					  {			   
						 if($i->id!=null)
						   {    $bool=true;
						       break;
						   }
						   
					   }  
				   }
			if($bool)
			  { 
			  	$grade=Grades::model()->searchByRoom($course_id, $period_id);
						             
				  if(isset($grade)&&($grade!=null))
				   { 
				      $grade___=$grade->getData();//return a list of  objects
		                               
		               if($grade___!=null)
						{ 	
		           		  foreach($grade___ as $g) 
							{	
							  if($g->grade_value=='')
							    $grade_array[$j] = 0;
							  else
							    $grade_array[$j] = $g->grade_value;

       	     
							     $j++;
							}
										    
						  }
						
						$compter_course++;						                
				    }

	
	            $class_average_value = $class_average_value + round($this->average_for_array($grade_array),2);
			    
			        
			        
			        $bool=false;
			   }
		
		  
		 
		if($compter_course==0)
		   return '---';
		else
		   return (round($class_average_value/$compter_course,2)); 

		
 }




//return a string
public function getCoursesCommentsForEachEvalperiodBySubjectParent($student_id,$subject_p, $ID_evaluation_by_year,$room, $acad)
 {
 	 
 	 $bool=false;
         $comments='';

 	   
 	
 	  $condition = 'subject0.subject_parent='.$subject_p.' AND ';
 	  $course_child = Courses::model()->searchReport($condition,$acad);
 	  $course_child=$course_child->getData();//return a list of Course objects
 	   foreach($course_child as $course)
		{	
			$j = 0;
            $grade_array = array();
            

			//pou chak pitit, nap gade si te gen evalyasyon pou li
 	        $result=Courses::model()->evaluatedSubject($course->id,$room,$ID_evaluation_by_year);		   
				if(isset($result))
				  {  $Course=$result->getData();//return a list of Course objects
				        
					 foreach($Course as $i)
					  {			   
						 if($i->id!=null)
						   {    $bool=true;
						       break;
						   }
						   
					   }  
				   }
			if($bool)
			  { 
			  	$comment=Grades::model()->getGradeComment($student_id, $course->id, $ID_evaluation_by_year, $acad);
						             
				  if($comment!=null)
				   { 
				      $comments= $comments.' / '.$comment;					                
				    }

			        $bool=false;
			   }
		
		 } 
		 
		
		return $comments;
	
 }




//return a string
public function getCoursesCommentsForEachEvalperiodBySubjectSimple($student_id,$course_id, $ID_evaluation_by_year,$room, $acad)
 {
 	 
 	 $bool=false;
$comments='';

 	   
 	 
 		$j = 0;
            $grade_array = array();
            

			//pou chak pitit, nap gade si te gen evalyasyon pou li
 	        $result=Courses::model()->evaluatedSubject($course_id,$room,$ID_evaluation_by_year);		   
				if(isset($result))
				  {  $Course=$result->getData();//return a list of Course objects
				        
					 foreach($Course as $i)
					  {			   
						 if($i->id!=null)
						   {    $bool=true;
						       break;
						   }
						   
					   }  
				   }
			if($bool)
			  { 
			  	$comment=Grades::model()->getGradeComment($student_id, $course_id, $ID_evaluation_by_year, $acad);
						             
				  if($comment!=null)
				   { 
				      $comments= $comments.' / '.$comment;					                
				    }

			        $bool=false;
			   }
		
		return $comments;
	
 }



	
public function actionViewDecision()
	{
		
//desizyon sa se pou klas la (ki vle di, pou tout sal yo net)		
		
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
			
	          $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }


      
    
	          $this->idShift=Yii::app()->session['ShiftsAdmit'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['SectionsAdmit'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	                $this->idLevel=Yii::app()->session['LevelHasPersonAdmit'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
				 
	             
					
					
					  
	           
	          if(isset($_POST['createPdf']))
				{
	                  	 
                           
								
								// create new PDF document
								$pdf = new tcpdf('L', PDF_UNIT, 'legal', true, 'UTF-8', false); // legal: 216x356 mm  612.000, 1008.00 ; 11.00x17.00 :279x432 mm
                                                                
								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                                //Extract school address
				   			    $school_address = infoGeneralConfig('school_address');
                                                //Extract  email address 
                                $school_email_address = infoGeneralConfig('school_email_address');
                                                //Extract Phone Number
                                $school_phone_number = infoGeneralConfig('school_phone_number');
				   						
                                $school_licence_number = infoGeneralConfig('school_licence_number');
				   								//Extract school Director
                                $school_director_name = infoGeneralConfig('school_director_name');
                                                               
                                                                                             
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app','End Year Decision'));
								$pdf->SetSubject(Yii::t('app','End Year Decision'));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetMargins(10, PDF_MARGIN_TOP,10 );
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
/*
								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
*/
								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 9, '', true);
								
//*******************************************/			
						 
	 
														                
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();

								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print
                                                               
					$html = <<<EOD
 <style>
	
	div.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		
        font-size: 22px;
		width:100%;
		text-align: center;
		line-height:15px;
		
	}
	
  span.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		
        font-size: 13px;
		
		text-align: center;
	}

	
	div.info {
		float:left;
		font-size:10pt;
		margin-top:10px;
		margin-bottom:5px;
		
	}
	
	
	
	
	tr.color1 {
		background-color:#F5F6F7; 
	}
	
	tr.color2 {
		background-color:#efefef; 
		
	}
	
	td.couleur1 {
		background-color:#F5F6F7; 
		
	}
	
	td.couleur2 {
		background-color:#efefef;  
		
	}
	
		
	
	tr.tr_body {
		border:1px solid #DDDDDD;
	    
	  }
	
	td.header_first{
		border-left:0px solid #FFFFFF; 
		border-bottom:0px solid #FFFFFF;
		border-top:0px solid #FFFFFF;
		
		font-weight:bold;
		width:27px;
		
		
	   }
	   
	 td.header_first1{
		border-left:2px solid #DDDDDD; 
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		
		font-weight:bold;
		width:93px;
		background-color:#E4E9EF;
	   }
	
	td.header_special1{
		border-right:2px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:145px;
		background-color:#E4E9EF;
		
	   }
	td.header_special2{
		border-right:2px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:195px;
		background-color:#E4E9EF;
		
	   }
	   
	td.header_special3{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:70px;
		background-color:#E4E9EF;
	   }
	   
	 td.header_moyenne{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:48px;
		background-color:#E4E9EF;
	   }
	   
	td.header_last{
		border-right:1px solid #DDDDDD; 
		border-top:1px solid #DDDDDD;
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:46px;
		background-color:#E4E9EF;
	   }
	   
	 td.header{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:55px;
		background-color:#E4E9EF;
	   }
	   
	td.header_prenom{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:110px;
		background-color:#E4E9EF;
	   }

   td.header_prenom_m{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:90px;
		background-color:#E4E9EF;
	   }
	  
	td.header_sexe{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:30px;
		background-color:#E4E9EF;
	   }

     td.data {
		border:1px solid #DDDDDD; 
		border-right:2px solid #DDDDDD;
	
	  }
	  
	  td.data_sexe {
		border:1px solid #DDDDDD; 
		border-right:2px solid #DDDDDD;
	    width:30px;
	  }
	  
	td.data_last {
		border:1px solid #DDDDDD; 
		
	  }
	td.no_border{
		border:0px solid #FFFFFF;
		}
		
    td.div.pad{
    	padding-left:10px;
    	margin-left:20px;
    	}
    td.code{
    	width:220px; 
    	font-weight:bold;
    	}
    	
    span.code{
    	font-size:14px; 
    	}
    	
    span.licence{
    	font-size:14px;
    	}
    	
    td.director{
    	width:360px;  
    	font-weight:bold; 
    	}
    	
    td.diege_district{
    	width:200px;  
    	font-weight:bold;   
    	}
    	
    span.section{
    	font-size:18px; 
    	}
	
</style>
                                       
										
EOD;
                                        
	   $sess_name='';
                      
                      if($siges_structure==1)
                        {  if($this->noSession)
                             {  Yii::app()->session['currentName_academic_session']=null;
                                Yii::app()->session['currentId_academic_session']=null;
                             	$sess_name=' / ';
                             }
                           else
                             $sess_name=' / '.Yii::app()->session['currentName_academic_session'];
                        }

       $acad_name=Yii::app()->session['currentName_academic_year'];
       
       
	   $level=$this->getLevel($this->idLevel);
	   $level_ = strtr( $level, pa_daksan() );
	   
	
	$html .='<br/><div class="title">'.strtoupper(strtr(Yii::t("app","End Year Decision List"), pa_daksan() )).'
	            <br/> <span class="title" >'.strtoupper(strtr(Yii::t("app","Academic Year"), pa_daksan() ).' '.$acad_name).'<br/>'.strtoupper(Yii::t("app","Level : ").$level_).' </span>
	</div>';
	
	
	$html .=' <br/><br/>
			<table class="table no-margin" style="width:100%;">
		         <tbody>
		             
		             <tr >
		               <td class="code">'.strtoupper(Yii::t("app","Code : ")).'<span class="code" > '.'</span><br/><br/>'.Yii::t("app","Licence number : ").'<span class="licence" >'.$school_licence_number.'</span></td><td class="director">'.Yii::t("app","Director : ").$school_director_name.'</td><td class="siege_district">'.Yii::t("app","Siege / District scolaire : ").'<br/><br/> <span class="section" >'.Yii::t("app","Section : ").'</span></td>            
		             </tr>
		             
		            </tbody>
		      </table>
      ';
      
      
      
      
	$html .=' <br/><br/>
	
	       <table >
         <tbody>
             <tr>
                 <td rowspan="2" class="header_first" >  </td><td rowspan="2" class="header_first1" ><div class="pad">  '.Yii::t("app","Last name").' </div></td><td rowspan="2" class="header_prenom"><div class="pad">  '.Yii::t("app","First name").' </div></td><td rowspan="2" class="header_prenom_m" ><div class="pad">  '.Yii::t("app","Mother-s First Name").' </div></td><td rowspan="2" class="header_sexe" ><div class="pad">  '.Yii::t("app","Gender").' </div></td><td colspan="2" class="header_special1"><div class="pad">  '.Yii::t("app","Birthday and place").' </div></td><td colspan="3" class="header_special2" ><div class="pad">  '.Yii::t("app","Success level").' </div></td><td rowspan="2" class="header_moyenne" ><div class="pad">'.Yii::t("app","General Average").' </div></td><td rowspan="2" class="header_last" ><div class="pad">  '.Yii::t("app","Mention").' </div></td>         
             </tr>
             <tr style="border:0px solid #DDDDDD;">
                 <td class="header" ><div class="pad">  '.Yii::t("app","Date").' </div></td><td class="header_prenom_m" ><div class="pad">  '.Yii::t("app","Place").' </div></td>
                 <td class="header_special3" ><div class="pad"> '.Yii::t("app","Identifiant").' </div></td><td class="header_special3" ><div class="pad">  '.Yii::t("app","Matricule").' </div></td><td class="header" ><div class="pad">  '.Yii::t("app","Year").' </div></td>         
             </tr>
            
             <tr style="border:0px solid #DDDDDD;">
               <td colspan="12" class="no_border"></td>            
             </tr>
             
                 ';
      
      
      
           
			
	      $sh='';
	      $se='';
	      $le='';
	      
	          
	          $this->idShift=Yii::app()->session['ShiftsAdmit'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['SectionsAdmit'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	                $this->idLevel=Yii::app()->session['LevelHasPersonAdmit'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
				  
	               
			 	 
			 $data_annee = $this->getAcademicPeriodNameL($acad_sess,$le);
			
			 $annee ='';
			 if($data_annee!=null)
                $annee =  $data_annee->name_period;
                         
	         $dataProvider = Persons::model()->searchStudentsForPdfEYD($condition,$sh,$se,$le,$acad_sess);
	        
          
          if(isset($dataProvider))
			    {  $result=$dataProvider->getData();
				      $i=0;
				      $color=0;
				      $class="";
				      
				    foreach($result as $pers)
                     {   $i++;
                     	          $sexe = 'M';
                     	          if($pers->gender==1)
                     	            $sexe = 'F';
                     	          
                     	          if($color==2)
									 $color=0;
								  if($color==0)
									$class="color1";
								  elseif($color==1)
									$class="color2";  
                     	           
                     	$html .=' <tr class="'.$class.'">
               <td class="data" ><div class="pad"> '.$i.' </div></td><td class="data" ><div class="pad"> '.$pers->last_name.' </div></td><td class="data" ><div class="pad"> '.$pers->first_name.' </div></td><td class="data" ><div class="pad">  </div></td><td class="data_sexe" ><div class="pad"> '.$sexe.' </div></td><td class="data" ><div class="pad"> '.$pers->birthday.' </div></td><td class="data" ><div class="pad"> '.$pers->city_name.' </div></td><td class="data" ><div class="pad">  </div></td><td class="data" ><div class="pad">  </div></td><td class="data" ><div class="pad"> '.$annee.' </div></td><td class="data" ><div class="pad"> '.$pers->general_average.' </div></td><td class="data_last" ><div class="pad"> '.$pers->mention.' </div></td>            
             </tr>';
                     	$color++;
                     	                     	
                     }
                     	
			    }
      
		     $html .='   </tbody>
		              </table>
		              ';
		              
		              
		            
		              
		  $html .=' <br/><br/><br/>
			<table class="table no-margin" style="width:100%; ">
		         <tbody>
		             <tr >
		               <td class="code">'.Yii::t("app","Code (11 chiffres): ").'<span class="code" > '.'</span></td><td> </td><td class="siege_district"> <span class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t("app","Signature du Directeur(trice) ").'</span></td>            
		             </tr>
		            </tbody>
		      </table>
      ';
      
      
	        $end_year_decision = 'documents/decision_final';

	            if (!file_exists(Yii::app()->basePath.'/../'.$end_year_decision))  //si reportCard n'existe pas, on le cree
					mkdir(Yii::app()->basePath.'/../'.$end_year_decision);
										 
										 
										 
                                           // $pdf->writeHTML($html, true, false, true, false, '');
		                                    // Print text using writeHTMLCell()
                                          $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
							 
								$file_name = strtr(Yii::t("app","End Year Decision List"), pa_daksan() ).'_'.$acad_name.'_'.$level_;	 
								//$file_name = strtr(Yii::t("app","End Year Decision List"), pa_daksan() ).'_'.$acad_name.'_'.$level_.'_'.$room_;	 

								$pdf->Output($end_year_decision.'/'.$file_name.'.pdf', 'D');
								
								
                                     
	     /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option 
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/
	                  	
			                   	                  	
	                  }  
				  
				  
				   
	                     
			$model=new Persons('searchStudentsForPdfEYD($condition,$sh,$se,$le,$acad_sess)');
		
		    // $model=new ReportCard;
		     
		if(isset($_GET['ReportCard']))
			$model->attributes=$_GET['ReportCard'];
         
		 // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','End Year Decision List / Level: '.$model->getLevelById($le))), null,false);
				
                 $this->exportCSV($model->searchStudentsForPdfEYD($condition,$sh,$se,$le,$acad_sess) , array(
					'last_name',
					'first_name',
					'mother_first_name',
					'sexe',
			        'birthday',
			        'cities0.city_name',
					'identifiant',
					'matricule',
					
					'general_average',
					'mention',
					            
					             )); 
                  	
			 
			 
		  }

 /*  */
		$this->render('viewDecision',array(
			'model'=>$model,
		));
	}
	
	
	
	


public function actionPaverage()
	 {  
		$model=new ReportCard;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		
		//Extract reportcard_structure (1:One evaluation by Period OR 2:Many evaluations in ONE Period)
        $reportcard_structure = infoGeneralConfig('reportcard_structure');

 
 
		$this->performAjaxValidation($model);
        
		
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];    
		
		    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     
     if($current_acad==null)
						{  $condition = '';
                              $condition1 = '';
                          }

						     else{
						     	   if($acad!=$current_acad->id)
							         {  $condition = '';
                                        $condition1 = '';
                                      }

							      else
							         { $condition = 'p.active IN(1,2) AND ';
                                        $condition1 = 'AND p.active IN(1,2) ';
                                      }
						        }


     
     
    				 
		
		  if(isset($_POST['Shifts']))
            {  
				
				//on n'a pas presser le bouton, il fo load apropriate rooms
					      $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
	                      Yii::app()->session['ShiftsPaverage'] = $this->idShift;
                      
				     
//unset(Yii::app()->session['sleep']);
								  
					     $modelSection->attributes=$_POST['Sections'];
						     $this->section_id=$modelSection->section_name;
						     Yii::app()->session['SectionsPaverage'] = $this->section_id;
						 					
						 if(isset($_POST['LevelHasPerson']))
	                      {  $modelLevel->attributes=$_POST['LevelHasPerson'];
						     $this->idLevel=$modelLevel->level;
						     Yii::app()->session['LevelHasPersonPaverage'] = $this->idLevel;
	                       }
	                    else
	                      {
	                      	   if(isset($_GET['lev']))
	                      	      $this->room_id=$_GET['lev'];
	                      	
	                      	}
						   
						
						   
	             }				   
				else //$_POST['Shifts'] not set
				  {
				   				   $this->idShift=null;
                                   $this->section_id=null;
				               $this->idLevel=null;
				   				   $this->student_id=null;
				   
				               $this->noStud = 0; 
				    }
		
			 if(isset($_POST['createPdf']))
				 { //on vient de presser le bouton create
				 	 	
				 	 $pastp = null;//array(); //pou denye evalyasyon nan chak peryod pase
				 	 $periods_id_array = array();
				 	 $eval_set=false;
				 	$this->messageEvaluationNotSet=false;
				 	$this->messageNoStudChecked=false;
				 	$this->messageWrongPeriodChoosen=false;
				 	
				 
				 
				 if($reportcard_structure==1) //One evaluation by Period
				  {
				      //One evaluation by Period	
				 		//check period set
				 	if(isset($_POST['Evaluations']))//&&($_POST['Evaluations'])) 
						     {
						        
						        	
					 			foreach($_POST['Evaluations'] as $r)
									{  if($r!=null)
									     { foreach($r as $id_eval_by_period)
									        {   									             
									        	$pastp[] = $id_eval_by_period;	//evaluation by period								             
									        	
									             $eval_set=true;
									        }
									     }
									}
									  
						     }
 	
                                	
				   }
				elseif($reportcard_structure==2)  //Many evaluations in ONE Period
				   {
				         //Many evaluations in ONE Period
				 	// $modEY = new EvaluationByYear;
					 //getting past evaluation period
						  if(isset($_POST['EvaluationByYear'])&& !empty($_POST['EvaluationByYear'])) 
						     {				 	
						     	//$modEY = $_POST['chk_peval_id'];
					 			foreach($_POST['EvaluationByYear'] as $r)
									{  if($r!=null)
									     { foreach($r as $id_eval_by_period)
									         {  $pastp[] = $id_eval_by_period;
									        
                                                   $eval_set=true;
									          }
									          
									      }
									     
									     
									 }
									     
						     }
									
				 	 	                                 	
				     } 
     
				 				 	 	
			 	 	 	
				 	 	
		if($eval_set)	 	 	
		  {	  
		      if(isset($_POST['chk']))
                   {	 	
				 	 	//coment this part if your school not base on general average
				 	 	    $generalAverage=0;$general_average = 0;$sum_average=0; $compt=0;
				 	 foreach($_POST['chk'] as $id_pers)
                       {  
			                 foreach($pastp as $id_period)
			                  {
			                  	    
			                  	    
			                  	   
			                  	  if($reportcard_structure==1) //One evaluation by Period
									  {
									      $info_average_period = ReportCard::searchStudentsForPA1($condition1,$id_pers,$id_period,$acad_sess);                                 	
									   }
									elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									   {
									      $info_average_period = ReportCard::searchStudentsForPA2($condition1,$id_pers,$id_period,$acad_sess);                               	
									     }  
									     
									     
									      
			                  	    if($info_average_period!=null)
							          {  
								        foreach($info_average_period as $info_average)
								          {
						 	                
							 	               if($reportcard_structure==1) //One evaluation by Period
												  {
												       //One evaluation by Period 
								 	                  $general_average = $info_average["general_average"];
															                       
													  $sum_average= $sum_average+$info_average["average"];
													  
                               	
												   }
												elseif($reportcard_structure==2)  //Many evaluations in ONE Period
												   {
												        //Many evaluations in ONE Period
									 	                
									 	                 $general_average = $info_average["general_average_df"]; //decision finale
															                       
														  $sum_average= $sum_average+$info_average["general_average"]; //general average by period
														  
                                	
												     } 
						 	               
						 	               											  
											  $compt++;
																			
										   }
														
								       }
								    	 		                  	    
			                  	 }
			                  	 
			                if($compt!=0)
			                 $generalAverage = round(($sum_average/$compt),2);
			                 
			               if($generalAverage!=$general_average)
			                  {  
			                  	$this->messageWrongPeriodChoosen=true;
			                  	    break;
			                  	}
			                  	
			                  	
			                  	$generalAverage =0;
			                  	$sum_average=0;
			                  	$general_average=0;
			                  	$compt=0;
			                  	 
                          }
                          
                   
                  	 	
				 	 	
				if(!$this->messageWrongPeriodChoosen) 	 	
				  { 	
				 	 	// create new PDF document
								$pdf = new tcpdf('L', PDF_UNIT, 'legal', true, 'UTF-8', false); // letter: 216x279 mm ; legal: 216x356;  612.000, 1008.00 ; 11.00x17.00 :279x432 mm

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
                                //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
                                //Extract Phone Number
                                  $school_phone_number = infoGeneralConfig('school_phone_number');
				   				//Extract Code1 Number
                                   $school_code1 = infoGeneralConfig('code1');
				   				//Extract Code2(11 digit) Number
                                   $school_code2 = infoGeneralConfig('code2');
				   				//Extract school Licence Number
                                    $school_licence_number = infoGeneralConfig('school_licence_number');
				   				//Extract school Director
                                     $school_director_name = infoGeneralConfig('school_director_name');
                                                               
                                                                                             
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app','Palmares average'));
								$pdf->SetSubject(Yii::t('app','Palmares average'));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetMargins(10, PDF_MARGIN_TOP,10 );
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
/*
								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
*/
								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 9, '', true);
								
//*******************************************/			
						 
	 
														                
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();

								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print
					$html = <<<EOD
 <style>
	
	div.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		font-size: 22px;
		width:100%;
		text-align: center;
		line-height:15px;
		
	}
	
  span.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		font-size: 13px;
		text-align: center;
	}

	
	div.info {
		float:left;
		font-size:10pt;
		margin-top:10px;
		margin-bottom:5px;
		
	}
	
	
	
	
	tr.color1 {
		background-color:#F5F6F7; 
		
	}
	
	tr.color2 {
		background-color:#efefef; 
		
	}
	
	td.couleur1 {
		background-color:#F5F6F7; 
				
	}
	
	td.couleur2 {
		background-color:#efefef;  
		
	}
	
		
	
	tr.tr_body {
		border:1px solid #DDDDDD;
	   
	  }
	
	td.header_first{
		border-left:0px solid #FFFFFF; 
		border-bottom:0px solid #FFFFFF;
		border-top:0px solid #FFFFFF;
		
		font-weight:bold;
		width:33px;
		
		
	   }
	   
	 td.header_first1{
		border-left:2px solid #DDDDDD; 
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:113px;
		background-color:#E4E9EF;
	   }
	
	td.header_special1{
		border-right:2px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:175px;
		background-color:#E4E9EF;
		
	   }
	td.header_special2{
		border-right:2px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:240px;
		background-color:#E4E9EF;
		
	   }
	   
	td.header_special3{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:85px;
		background-color:#E4E9EF;
	   }
	   
	 td.header_moyenne{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:78px;
		background-color:#E4E9EF;
	   }
	   
	td.header_last{
		border-right:1px solid #DDDDDD; 
		border-top:1px solid #DDDDDD;
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:56px;
		background-color:#E4E9EF;
	   }
	   
	 td.header{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:70px;
		background-color:#E4E9EF;
	   }
	   
	td.header_prenom{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:135px;
		background-color:#E4E9EF;
	   }

   td.header_prenom_m{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:105px;
		background-color:#E4E9EF;
	   }
	  
	td.header_sexe{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:35px;
		background-color:#E4E9EF;
	   }

     td.data {
		border:1px solid #DDDDDD; 
		border-right:2px solid #DDDDDD;
	
	  }
	  
	  td.data_sexe {
		border:1px solid #DDDDDD; 
		border-right:2px solid #DDDDDD;
	    width:35px;
	  }
	  
	td.data_last {
		border:1px solid #DDDDDD; 
		
	  }
	td.no_border{
		border:0px solid #FFFFFF;
		}
		
    td.div.pad{
    	padding-left:10px;
    	margin-left:20px;
    	}
    td.code{
    	width:220px; 
    	font-weight:bold;
    	}
    	
    span.code{
    	font-size:14px; 
    	}
    	
    span.licence{
    	font-size:14px;
    	}
    	
    td.director{
    	width:360px;  
    	font-weight:bold; 
    	}
    	
     td.space{
    	width:660px;  
    	 
    	}
    	
    td.diege_district{
    	width:200px;  
    	font-weight:bold;   
    	}
    	
    span.section{
    	font-size:18px; 
    	}
	
</style>
                                       
										
EOD;
	   $sess_name='';
	            if($siges_structure==1)
                        {  if($this->noSession)
                             {  Yii::app()->session['currentName_academic_session']=null;
                                Yii::app()->session['currentId_academic_session']=null;
                             	$sess_name=' / ';
                             }
                           else
                             $sess_name=' / '.Yii::app()->session['currentName_academic_session'];
                        }

	   
	   $acad_name=Yii::app()->session['currentName_academic_year'];
	   $acad_name_ = strtr( $acad_name.$sess_name, pa_daksan() );
	     $level=$this->getLevel($this->idLevel);
	   $level_ = strtr( $level, pa_daksan() );
	
	$html .='<br/><div class="title" >'.strtoupper(strtr(Yii::t("app","Palmares average"), pa_daksan() )).'
	            <br/> <span class="title" >'.strtoupper(strtr(Yii::t("app","Academic Year"), pa_daksan() ).' '.$acad_name).'<br/>'.strtoupper(Yii::t("app","Level : ").$level_).' </span>
	</div>';
	
	
	$html .=' <br/><br/>
			<table class="table no-margin" style="width:100%; ">
		         <tbody>
		             
		             <tr >
		               <td class="code">'.strtoupper(Yii::t("app","Code : ")).'<span class="code" > '.$school_code1.'</span><br/><br/>'.Yii::t("app","Licence number : ").'<span class="licence" >'.$school_licence_number.'</span></td><td class="director">'.Yii::t("app","Director : ").$school_director_name.'</td><td class="siege_district">'.Yii::t("app","Siege / District scolaire : ").'<br/><br/> <span class="section" >'.Yii::t("app","Section : ").'</span></td>            
		             </tr>
		             
		            </tbody>
		      </table>
      ';
      
      
  $html .=' <br/><br/>
	
	       <table class="table no-margin" style="width:100%; ">
         <tbody>
             <tr >
                 <td  class="header_first" >  </td><td  class="header_first1" ><div class="pad">  Nom </div></td><td  class="header_prenom"><div class="pad">  Pr&eacute;nom </div></td><td  class="header_sexe" ><div class="pad">  Sexe </div></td><td class="header_special3" ><div class="pad"> Identifiant </div></td><td class="header_special3" ><div class="pad"> '.Yii::t("app","Registration number").' </div></td>';
                 
                 $compter_p=0;
                
						
						foreach($pastp as $id_period)
					                      {
			 	                                $compter_p++;
			 	                                $eval_period = $this->searchPeriodName($id_period);
			 	                                
										        $html .='<td class="header_moyenne" > <div class="pad"> '.$eval_period.' </div> </td>';
																		
											}

							      
									//fin ajout  
									$compter_p=$compter_p + 6;          
	$html .=' <td class="header_moyenne" ><div class="pad"> '.Yii::t('app','General Average').' </div></td></tr><tr style="border:0px solid #DDDDDD;"><td colspan="'.$compter_p.'" class="no_border" ></td></tr>';
      
      
        
			
	      $sh='';
	      $se='';
	      $le='';
	      
         $this->idShift=Yii::app()->session['ShiftsPaverage'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['SectionsPaverage'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	                $this->idLevel=Yii::app()->session['LevelHasPersonPaverage'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
				  
	              
					  
			 $data_annee = $this->getAcademicPeriodNameL($acad_sess,$le);
			 
			 $annee ='';
			 if($data_annee!=null)
                $annee =  $data_annee->name_period;

                      
              
     	     $i=0;
		     $color=0;
		     $class="";
		     
      foreach($_POST['chk'] as $id_pers)
        {    
            $dataProvider = Persons::model()->searchStudentsByIDForGrades($condition,$id_pers);
          
            $result=$dataProvider->getData();
				      
				      
				    foreach($result as $pers)
                     {   $i++;
                     	          $sexe = 'M';
                     	          if($pers->gender==1)
                     	            $sexe = 'F';
                     	          
                     	          if($color==2)
									 $color=0;
								  if($color==0)
									$class="color1";
								  elseif($color==1)
									$class="color2";  
                     	            
                     	$html .=' <tr class="'.$class.'">
               <td class="data" ><div class="pad"> '.$i.' </div></td><td class="data" ><div class="pad"> '.$pers->last_name.' </div></td><td class="data" ><div class="pad"> '.$pers->first_name.' </div></td><td class="data_sexe" ><div class="pad"> '.$sexe.' </div></td><td class="data" ><div class="pad"> '.$pers->identifiant.' </div></td><td class="data" ><div class="pad"> '.$pers->matricule.' </div></td>';
               
                    $general_average=0;
                foreach($pastp as $id_period)
                  {
                  	    
                  	      
			                  	  if($reportcard_structure==1) //One evaluation by Period
									  {
									      $info_average_period = ReportCard::searchStudentsForPA1($condition1,$id_pers,$id_period,$acad_sess);                                 	
									   }
									elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									   {
									      $info_average_period = ReportCard::searchStudentsForPA2($condition1,$id_pers,$id_period,$acad_sess);                               	
									     }  
									     
									     
                  	    
                  	    if($info_average_period!=null)
				          {  
					        foreach($info_average_period as $info_average)
					          {
			 	                
			 	                 
								  if($reportcard_structure==1) //One evaluation by Period
									  {
									       
									        $general_average = $info_average["general_average"];
										                       
								  $html .='<td class="data" ><div class="pad"> '.$info_average["average"].' </div></td>';                              	
									   }
									elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									   {
									         
									        $general_average = $info_average["general_average_df"];
										                       
								  $html .='<td class="data" ><div class="pad"> '.$info_average["general_average"].' </div></td>';                                	
									     } 
																		
							   }
											
					       }
					     else
					       {
					       	    $general_average = 0;
										                       
								 
								  if($reportcard_structure==1) //One evaluation by Period
									  {
										                       
								  $html .='<td class="data" ><div class="pad">  '.$info_average["average"].'  </div></td>';                             	
									   }
									elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									   {
									        
										                       
								  $html .='<td class="data" ><div class="pad">  '.$info_average["general_average"].'  </div></td>';                                	
									     } 

					       	 }
                  	    
                  	}
               
                                 $html .=' <td class="data" ><div class="pad">  '.$general_average.'  </div></td>           
                         </tr>';
                     	$color++;
                     	break;
                     	}
                     	
           
        }        	
			  
                
                
      
                        
                     $html .='   </tbody>
		              </table> 
		              ';
		              
		              
		              
		  $html .=' <br/><br/><br/>
			<table class="table no-margin" style="width:100%; ">
		         <tbody>
		             <tr >
		               <td class="code">'.Yii::t("app","Code (11 chiffres): ").'<span class="code" > '.$school_code2.'</span></td><td > </td><td class="siege_district"> <span class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t("app","Signature du(de la) Directeur(trice) ").'</span></td>            
		             </tr>
		            </tbody>
		      </table>';

                              // $pdf->writeHTML($html, true, false, true, false, '');
		                                    // Print text using writeHTMLCell()
                           $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

								$pdf->Output('Palmares_average.pdf', 'D');
                                  /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/

								//============================================================+
								// END OF FILE
								//============================================================+		
		
                         
                      }//end if set chk
			       else
				    {
				    	$this->messageWrongPeriodChoosen=true;
				      }
                      
                      	
				 }//end if set chk
			    else
				    {
				    	$this->messageNoStudChecked=true;
				      }  			
		    }        
		  else
		    {
		    	$this->messageEvaluationNotSet=true;
		      }   
		     
		 }//end if set create PDF
			
			 
		
		
		
		$this->render('paverage',array(
			'model'=>$model,
		));
		
	}

	
	        
	//xxxxxxxxxxxxxxxxxx             xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

	
public function checkDecisionFinale($stud_id, $acad)
	  {
	        $command= Yii::app()->db->createCommand("SELECT * FROM decision_finale WHERE student=:studID AND academic_year=:acad");
			$command->bindValue(':studID', $stud_id);
			$command->bindValue(':acad', $acad);	
			
			$sql_result = $command->queryAll();
			
			
			   return $sql_result;
			
	  
	  }
	
	public function checkDataGeneralAverage($acad,$student,$gAverage,$level)
	  {
	        				  
			$command= Yii::app()->db->createCommand("SELECT * FROM decision_finale WHERE academic_year=:acad AND student=:student");
			$command->bindValue(':acad', $acad);	
			$command->bindValue(':student',$student );
			$sql_result = $command->queryAll();
			
			
			   return $sql_result;
			
	  
	  }
	  
	  

public function getClassAverageForReport($level,$eval, $acad)
    {  //return an array which content is: classAverage, FemaleAverage, maleAverage, Tot_female, Tot_male
	  
	  $acad_=Yii::app()->session['currentId_academic_year'];
	    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad_!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }


      


	  
	  	  
	   $modelRoom= new Rooms;
	   $result=$modelRoom->find(array('alias'=>'r',
	                                 'select'=>'r.id',
	                                 'distinct'=>true,
                                     'join'=>'left join level_has_person lh on(r.level=lh.level) ',
									 'condition'=>'lh.level=:lev AND lh.academic_year=:acad',
                                     'params'=>array(':lev'=>$level,':acad'=>$acad),
                               )); 
		$level=null;					   
		
	    $data= array();
		$nb_room=0;
		
		$tot_female=0; 
		$tot_male=0;
		
		$classTotalAverage_female=0;
		$classTotalAverage_male=0;
   		$classTotalAverage=0;
   		

		
		if(isset($result))	
           {  
   		     //average for each room
   		          		     
   		     foreach($result as $room)
   		      {
		   		   if($room!=null)
		   		    {       $nb_room++;
		   		        
		   		          $id_room=$room;
		   		          //total of student for this room
							$tot_stud=0;
							$dataProvider_studentEnrolled=Rooms::model()->getStudentsEnrolled($condition,$id_room, $acad);
								  if(isset($dataProvider_studentEnrolled))
								    {  $t=$dataProvider_studentEnrolled->getData();
									   foreach($t as $tot)
									    {
									       $tot_stud=$tot->total_stud;
									    }
									}
									
						$male=0;
						$female=0;
						$average_male=0;
						$average_female=0;	
					
							//average for this room
							$classAverage=0;
							$dataProvider_student=Persons::model()->getStudentsByRoomForGrades($condition,$id_room, $acad);
								  if(isset($dataProvider_student))
								    {  $stud=$dataProvider_student->getData();
									   foreach($stud as $student)
									     { 
									     	
									     	
									     	
										  $average =0;
										  
										  //return a model
		                                  
											$average = $this->getAverageForAStudent($student->id, $id_room, $eval, $acad);
											//return a number
											
											 $classAverage +=$average;
												
											  if($student->gender==1)
										     	 {
										     	 	  $female++;
										     	 	  $average_female+=$average;
										     	 	}
										     	elseif($student->gender==0)
										     	  {
										     	  	  $male++; 
										     	  	  $average_male+=$average;
										     	  	   
										     	  	}
											  
										  }
										  
										  
									}		
								
							
						if($tot_stud!=0)
						  	$classAverage=round(($classAverage/$tot_stud),2);
						      
						      if($female!=0)
						        $average_female=round(($average_female/$female),2);
						      
						      if($male!=0)
						        $average_male=round(($average_male/$male),2);
						      
						        $tot_female += $female; 
								$tot_male += $male;
						      
						    
							
							$classTotalAverage=$classTotalAverage + $classAverage;
							
							$classTotalAverage_female=$classTotalAverage_female + $average_female;
							
							$classTotalAverage_male=$classTotalAverage_male + $average_male;	
							
			    	 					
		   		            }
		   		        
   		        }
   		        
   		        if($nb_room > 1)
   		         {  $classTotalAverage = round(($classTotalAverage/$nb_room),2);
   		         
   		            $classTotalAverage_female=round(($classTotalAverage_female/$tot_female),2);
   		            
   		            $classTotalAverage_male=round(($classTotalAverage_male/$tot_male),2);
   		            
   		           }
   		           
   		   
   		           

			 }
		
		
				 
		  $data["class_average"]= $classTotalAverage;
		  $data["female_average"]= $classTotalAverage_female;
		  $data["male_average"]= $classTotalAverage_male;
		  $data["tot_female"]= $tot_female;
		  $data["tot_male"]= $tot_male;
		 
		  
	    return $data;
	}


public function getAverageForAStudent($student, $room, $evaluation, $acad)
    {  //return value: average
	   
      $acad_=Yii::app()->session['currentId_academic_year']; 
      
      $average_base = 0;
      //Extract average base
      $average_base = infoGeneralConfig('average_base');
    

    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
 if($current_acad==null)
						         { $condition = '';
          $condition1 = '';
        }
						     else{
						     	   


     if($acad_!=$current_acad->id)
        { $condition = '';
          $condition1 = '';
        }
      else
        { $condition = 'p.active IN(1,2) AND ';
          $condition1 = 'teacher0.active IN(1,2) AND ';
        }
    }
	    
	    
	    $average=0;
	   
		
	   $level_has_person= new LevelHasPerson;
	   $result=$level_has_person->find(array('alias'=>'lhp',
	                                 'select'=>'lhp.level',
                                     'join'=>'left join rooms r on(r.level=lhp.level) ',
									 'condition'=>'r.id=:room AND lhp.academic_year=:acad',
                                     'params'=>array(':room'=>$room,':acad'=>$acad),
                               ));
		$level=null;					   
		if(isset($result))	
           {  
   		     $level=$result->level;
			 
			 }
		
		$dataProvider_Course=Courses::model()->searchCourseByRoomId($condition1,$room, $acad);
										   
			 $k=0;
			$tot_grade=0;
                                                   
			$max_grade=0;

											           
		  if(isset($dataProvider_Course))
		   { $r=$dataProvider_Course->getData();//return a list of  objects
			foreach($r as $course) 
			 {					
				$course_id = $course->id;			
				 if($course->reference_id!='')
				   {
				   	   $course_id = $course->reference_id;
				   	 }
				   	 
				$grades=Grades::model()->searchForReportCard($condition,$student,$course->id, $evaluation);
																			  
					if(isset($grades)&&($grades!=null))
					 {
					   $r=$grades->getData();//return a list of  objects
					   foreach($r as $grade) 
						 {									       
							$tot_grade=$tot_grade+$grade->grade_value;
							$max_grade=$max_grade+$course->weight;
																																	 
																	   
						 }
																																   
					  }
					else
					 {
					 	   if($course->reference_id!='')
							   {
							   	   
							   	   $grades=Grades::model()->searchForReportCard($condition,$student,$course->reference_id, $evaluation);
																			  
									if(isset($grades)&&($grades!=null))
									 {
									   $r=$grades->getData();//return a list of  objects
									   foreach($r as $grade) 
										 {									       
											$tot_grade=$tot_grade+$grade->grade_value;
											$max_grade=$max_grade+$course->weight;
																																					 
																					   
										 }
																																				   
									  }
							   	 }
							   	 
					 	}

					
			  }
			 }
                                                                                                                
              
	if(($average_base ==10)||($average_base ==100))
		 { if($max_grade!=0)
     		 $average=round(($tot_grade/$max_grade)*$average_base,2);

		 }
	else
	   $average = null;
	   
	   
	    return $average;
	}





	  
	//xxxxxxxxxxxxxxx STUDENT  xxxxxxxxxxxxxxxxx
	    //************************  getStudent($id) ******************************/
   public function getStudent($id)
	{
		
		$student=Persons::model()->findByPk($id);
        
			
		       if(isset($student))
				return $student->first_name.' '.$student->last_name;
		
	}
	
	
	
	//xxxxxxxxxxxxxxx CITY  NAME  xxxxxxxxxxxxxxxxx
	    //************************  getCityName($city) ******************************/
   public function getCityName($city)
	{
		
		$cities=Cities::model()->findByPk($city);
        
			
		       if(isset($cities))
				return $cities->city_name;
		
	}
	
	
	//xxxxxxxxxxxxxxx  LEVEL xxxxxxxxxxxxxxxxxxx
		//************************  loadLevelByIdShiftSectionId  ******************************/
	public function loadLevelByIdShiftSectionId($idShift,$section_id)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('alias'=>'r',
	                                 'join'=>'left join levels l on(l.id=r.level)',
	                                 'select'=>'r.level',
                                     'condition'=>'r.shift=:shiftID AND l.section=:sectionID',
                                     'params'=>array(':shiftID'=>$idShift, ':sectionID'=>$section_id),
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
						       $code[$l->id]= $l->level_name;
					    }  
							   }						 
		    
						  }	
			
		return $code;
         
	}
	

		//************************  getLevelByIdShiftId  ******************************/
	public function getLevelByIdShiftId($idShift,$acad)
	{    
       	  
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('select'=>'r.level',
                                     'alias'=>'r',
                                     'distinct'=>true,
                                     'join'=>'inner join level_has_person lh on(r.level=lh.level)',
                                     'condition'=>'r.shift=:shiftID AND lh.academic_year=:acad',
                                     'params'=>array(':shiftID'=>$idShift, ':acad'=>$acad),
                               ));
                               
			if(isset($level_id)&&($level_id!=''))
			 {  
			    
			    return $level_id;
			    
			  }
			else	
			  return null;
         
	}
	

	
		//************************  getLevelByIdShiftSection  ******************************/
	public function getLevelByIdShiftSection($idShift,$section,$acad)
	{    
       	  
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('select'=>'r.level',
                                     'alias'=>'r',
                                     'distinct'=>true,
                                     'join'=>'inner join level_has_person lh on(r.level=lh.level) left join levels l on(l.id=r.level)',
                                     'condition'=>'r.shift=:shiftID AND l.section=:section AND lh.academic_year=:acad',
                                     'params'=>array(':shiftID'=>$idShift, ':section'=>$section, ':acad'=>$acad),
                               ));
                               
			if(isset($level_id)&&($level_id!=''))
			 {  
			    
			    return $level_id;
			    
			  }
			else	
			  return null;
         
	}
	

	
		//************************  getLevelByRoomId  ******************************/
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
	
	

			//************************  getInfoRoom  ******************************/
	public function getInfoRoom($room_id)
	{   //return level ID,shift ID,section ID, 
       	  
	      $modelRoom= new Rooms();
	      $level_id_shift_id_section_id=$modelRoom->findAll(array('alias'=>'r',
	                                 'join'=>'left join levels l on(l.id=r.level)',
	                                 'select'=>'r.level,r.shift,l.section',
                                     'condition'=>'r.id=:roomID ',
                                     'params'=>array(':roomID'=>$room_id),
                               ));
			
			$value =null;
			
			if(isset($level_id_shift_id_section_id))
			 {  
			    foreach($level_id_shift_id_section_id as $i)
			       {			   
					  $value= $i;
					   
					}
                							   
		    
		      }	
			
		return $value;
         
	}

	
	
	//************************  getRoomBySection($r, $s) ******************************/
   public function getRoomBySection($r, $s)
	{
		$room = new Rooms;
		$criteria = new CDbCriteria;
		$criteria->condition='id=:room AND section=:idSection';
		$criteria->params=array(':room'=>$r,':idSection'=>$s);
		$room=Rooms::model()->find($criteria);
        
			
		
		    if(isset($room))
				return $room->room_name;
		
	}
	
	
	//************************  getNumberOfSubjectByRoom  ******************************/
	public function getNumberOfSubjectByRoom($idSection)
	{    
       	  
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 


	       $code1;
		  $code2;
          
	      $modelCourse= new Courses();
		  
        
		$result=$modelCourse->searchNumberOfSubjectByRoom($idSection,$acad_sess);
				return $result;
				
				
	     
	}
	//************************  loadLevel ******************************/
	public function loadLevel()
	{    $modelLevel= new Levels();
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}
   //************************  getLevel($id) ******************************/
   public function getLevel($id)
	{
		$level = new Levels;
		$level=Levels::model()->findByPk($id);
        
			
		    if(isset($level))
				return $level->level_name;
		
	}
	
 //************************  getLevelShortName($id) ******************************/
   public function getLevelShortName($id)
	{
		$level = new Levels;
		$level=Levels::model()->findByPk($id);
        
			
		    if(isset($level))
				return $level->short_level_name;
		
	}
	
		//************************  getLevelByStudentId($id) ******************************/
	public function getLevelByStudentId($id)
	{
		$idRoom= $this->getRoomByStudentId($id);
		
		
		$model=new Rooms;
		$result=null;
		if(isset($idRoom)&&($idRoom!=''))
		 { $idLev = $model->find(array('select'=>'level',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$lev = new Levels;
            if(isset($idLev)&&($idLev!=''))
		 		{ $result=$lev->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLev->level),
                               ));
		          }
                               
		  }
		
				return $result;
		
	}
	
	//************************  getLevelIdFromPersons ******************************/
	public function getLevelIdFromPersons()
	{    
       
	   $modelLevel=new Levels;
					
			 if(isset($_POST['ReportCard']))
		        $modelLevel->attributes=$_POST['Levels'];
		           
				   $level_id=$modelLevel->level_name;
	               
				   return $level_id;
	}
	
//xxxxxxxxxxxxxxx  ROOM xxxxxxxxxxxxxxxxxxx
	
	//************************  changeRoom ******************************/
	public function changeRoom()
	{    $modelLevel= new Levels();
           $code= array();
		   
		  if(isset($_POST['ReportCard']['Levels']))
		        $idLevel->attributes=$_POST['Levels'];
		           
				   
	               
				    //return $idLevel;
         
	}
	
	//************************  loadRoomByIdSection ******************************/
	public function loadRoomByIdSection($section)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
		                             'select'=>'r.id,r.room_name',
                                     'join'=>'left join levels l on(l.id=r.level)',
                                     'condition'=>'l.section=:idSection',
                                     'params'=>array(':idSection'=>$section),
                               ));
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  
			    foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	

//************************  loadRoomByIdTeacher($id_teacher,$acad) ******************************/
	public function loadRoomByIdTeacher($id_teacher,$acad)
	{    
	
	      $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'r.id,room_name',
                                     'join'=>'left join courses c on(c.room=r.id)',//'left join room_has_person rh on (r.id = rh.room) left join courses c on(c.room=rh.room)',//
                                     'condition'=>'c.academic_period IN(select ap.id from academicperiods ap where (ap.id='.$acad.' OR ap.year='.$acad.') ) AND c.teacher='.$id_teacher,
                                     'order'=>'r.room_name ASC',
                               ));
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  
			    foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}


	
	//************************  loadRoomByIdShiftSectionLevel ******************************/
	public function loadRoomByIdShiftSectionLevel($shift,$section,$idLevel)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
		                             'join'=>'left join levels l on(l.id=r.level)',
		                             'select'=>'r.id,r.room_name',
                                     'condition'=>'r.shift=:idShift AND l.section=:idSection AND r.level=:levelID ',
                                     'params'=>array(':idShift'=>$shift,':idSection'=>$section,':levelID'=>$idLevel),
                               ));
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  
			    foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	
	//************************  loadRoom ******************************/
	public function loadRoom()
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
   //************************  getRoomName($id) ******************************/
   public function getRoomName($id)
	{
		$room = new Rooms;
		
		$room=Rooms::model()->findByPk($id);
        
			
		
		    if(isset($room))
				return $room->room_name;
		
	}
	
	
	//************************  getRoomByStudentId($id) ******************************/
	public function getRoomByStudentId($id)
	{
		 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		   
      $model=new RoomHasPerson;
		$idRoom = $model->find(array('select'=>'room',
                                     'condition'=>'students=:studID and academic_year=:acad',
                                     'params'=>array(':studID'=>$id,':acad'=>$acad_sess),
                               ));
		$room = new Rooms;
         $result=null;
       if(isset($idRoom)&&($idRoom!=''))
        { $result=$room->find(array('select'=>'id,room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
        }				   

	   

						   
				return $result;
		
	}
	
	//************************  getRoomIdFromReportCard ******************************/
	public function getRoomIdFromReportCard()
	{    
       
	   $modelRoom=new Rooms;
					
			 
		        $modelRoom->attributes=$_POST['Rooms'];
		           
				   $id=$modelRoom->room_name;
		
				   return $id;
	}
		 

	 //xxxxxxxxxxxxxxx  SHIFT xxxxxxxxxxxxxxxxxxx
	//************************  loadShift ******************************/
	public function loadShift()
	{    $modelShift= new Shifts();
           $code= array();
		   
		  $modelPersonShift=$modelShift->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    foreach($modelPersonShift as $shift){
			    $code[$shift->id]= $shift->shift_name;
		           
		      }
		   
		return $code;
         
	}
   //************************  getShift($id) ******************************/
   public function getShift($id)
	{
		
		$shift=Shifts::model()->findByPk($id);
        
			
		      if(isset($shift))
				return $shift->shift_name;
		
	}
	
	//************************  getShiftByStudentId($id) ******************************/
	public function getShiftByStudentId($id)
	{
		
		$idRoom= $this->getRoomByStudentId($id);
		
		
		$model=new Rooms;
		$result=null;
		
		if(isset($idRoom)&&($idRoom!=''))
        {   $idShift = $model->find(array('select'=>'shift',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$shift = new Shifts;
	        if(isset($idShift)&&($idShift!=''))
	        {  
             $result=$shift->find(array('select'=>'id,shift_name',
                                     'condition'=>'id=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift->shift),
                               ));
                               
               }
        }
				return $result;
		
	}
	
	//************************  getShiftIdFromPersons ******************************/
	public function getShiftIdFromPersons()
	{    
       
	   $modelShift=new Shifts;
					
			 if(isset($_POST['ReportCard']))
		        $modelShift->attributes=$_POST['Shifts'];
		           
				   $shift_id=$modelShift->shift_name;
	               
				   return $shift_id;
	}
	
	
	
	
	        //xxxxxxxxxxxxxxx  SECTION  xxxxxxxxxxxxxxxxxxx
	
	//************************  loadSectionByIdShift ******************************/
	public function loadSectionByIdShift($idShift)
	{     
	      $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $section_id=$modelRoom->findAll(array('alias'=>'r',
	                                 'select'=>'sec.id, sec.section_name',
                                     'join'=>'left join levels l on(l.id=r.level) left join sections sec on(l.section=sec.id)',
	                                 'condition'=>'r.shift=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift),
                               ));
	
	if(isset($section_id))
			 {  
			    foreach($section_id as $i)
			     {			   
					$code[$i->id]= $i->section_name;
			      }	   
			  }						 
		   
		return $code;
		$this->section_id=null;
         
	}
	
	//************************  loadSection ******************************/
	public function loadSection()
	{    $modelSection= new Sections();
           $code= array();
		   
		  $modelPersonSection=$modelSection->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonSection))
			 {  foreach($modelPersonSection as $section){
			        $code[$section->id]= $section->section_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	//************************  loadSectionForGR ******************************/
	public function loadSectionForGR()
	{    $modelSection= new Sections();
           $code= array();
		   
		  $modelPersonSection=$modelSection->findAll();
            
		    if(isset($modelPersonSection))
			 {  foreach($modelPersonSection as $section){
			        $code[$section->id]= $section->section_name;
		           
		           }
			 }
		   
		return $code;
         
	}
   //************************  getSection($id) ******************************/
   public function getSection($id)
	{
		//$section = new Sections;
		$section=Sections::model()->findByPk($id);
        
			
		       if(isset($section))
				return $section->section_name;
		
	}
	
	//************************  getSectionByStudentId($id) ******************************/
	public function getSectionByStudentId($id)
	{
		$idRoom= $this->getRoomByStudentId($id);
		
		
		$model=new Rooms;
		$result=null;
		if(isset($idRoom)&&($idRoom!=''))
		 {  $idSec = $model->find(array('alias'=>'r',
		                             'join'=>'left join levels l on(l.id=r.level)',
		                             'select'=>'l.section',
                                     'condition'=>'r.id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$sec = new Sections;
          if(isset($idSec)&&($idSec!=''))
		    {  $result=$sec->find(array('select'=>'id,section_name',
                                     'condition'=>'id=:secID',
                                     'params'=>array(':secID'=>$idSec->section),
                               ));
                               
                               
	                }
	                
	       }
		
				return $result;
		
	}
	
		
	
	//************************  getSectionIdFromPersons ******************************/
	public function getSectionIdFromPersons()
	{    
       
	   $modelSection=new Sections;
					
			 if(isset($_POST['ReportCard']))
		        $modelSection->attributes=$_POST['Sections'];
		           
				   $this->section_id=$modelSection->section_name;
	               
				   return $this->section_id;
	}
	
	
	
	//xxxxxxxxxxxxxxx  SUBJECTS xxxxxxxxxxxxxxxxxxx
		//************************  loadSubject  ******************************/
	public function loadSubject($room_id,$level_id)
	{    
       	  
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
   
   
          $code= array();
          $code[null][null]= Yii::t('app','-- Select --');
		  
		 $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseByRoom($room_id,$level_id,$acad_sess);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			            
						$k=0;
			    foreach($Course as $i){			   
					  
					  $code[$k][0]= $i->id;
					  $code[$k][1]= $i->subject_name;
					  $code[$k][2]= $i->weight;
					  $code[$k][3]= $i->subject_parent;
					  $code[$k][4]= $i->reference_id;
					  $k=$k+1;
					  
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	
	
//************************  isSubjectEvaluated($subject_id,$room,$period_id)  ******************************/	
	public function isSubjectEvaluated($course_id,$room,$period_id)
	{    
       	  
                $bool=false;
		  
		 $modelCourse= new Courses();
	       $result=$modelCourse->evaluatedSubject($course_id,$room,$period_id);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			            //$k is a counter
						$k=0;
						 
			    foreach($Course as $i){			   
					  
					  
					  if($i->id!=null)
					       $bool=true;
					  					  
				}  
			 }	 					 
		      
			
		return $bool;
         
	}


public function isOldSubjectEvaluated($course_id,$room,$period_id)
	{    
       	  
                $bool=false;
		  
		 $modelCourse= new Courses();
	       $result=$modelCourse->evaluatedOldSubject($course_id,$room,$period_id);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			            //$k is a counter
						$k=0;
						 
			    foreach($Course as $i){			   
					  
					  
					  if($i->id!=null)
					       $bool=true;
					  					  
				}  
			 }	 					 
		      
			
		return $bool;
         
	}
		
	
	//xxxxxxxxxxxxxxx  EVALUATIONS xxxxxxxxxxxxxxxxxxx
		//************************  loadEvaluation  ******************************/
	public function loadEvaluation()
	{    
       	  	  
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


	$code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=$modelEvaluation->searchIdName($acad_sess);
			
		   
			 if(isset($result))
			  {  $r=$result->getData();//return a list of  objects
			    foreach($r as $i){	
			    	$time = strtotime($i->evaluation_date);
                        $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
                        $date = $day.'/'.$month.'/'.$year; 		   
					  $code[$i->id]= $i->name_period.' / '.$i->evaluation_name.' ('.$date.')';//$i->evaluation_name.' ('.$i->evaluation_date.')';
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	
	
		//************************  loadEvaluationReportcardDone  ******************************/
	public function loadEvaluationReportcardDone()
	{    
       	  	  
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
	$code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=EvaluationByYear::model()->searchIdNameReportcardDone($acad_sess);
			
		   
			 if(isset($result))
			  { 
			    foreach($result as $i){
			    	$time = strtotime($i['evaluation_date']);
                        $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
                        $date = $day.'/'.$month.'/'.$year; 	
			    	 $code[$i['id_eval_year']]= $i['name_period'].' / '.$i['evaluation_name'].' ('.$date.')';//$i->evaluation_name.' ('.$i->evaluation_date.')';
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	
	
	//************************  getLastEvaluationInGrade  ******************************/
	public function getLastEvaluationInGrade()
	{    //return an id(number)
       	  	  
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

	$code='';
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=$modelEvaluation->searchLastEvaluationInGrade($acad_sess);
			
		   
			 if(isset($result))
			  {  $r=$result->getData();//return a list of  objects
			    foreach($r as $i){			   
					  $code= $i->id;//$i->name_period.' / '.$i->evaluation_date;//
					  
					  break; //to have only the 1st result which is the last
					
				}  
			 }	 					 
		      
			
		return $code;
         
	}

	
	//************************  getEvaluationPeriod  ******************************/
	public function getEvaluationPeriod($id)
	  {
	     $evalByYear=new EvaluationByYear();
		    $eYear=$evalByYear->findByPk($id);
        $result='';
			
		       if(isset($eYear))
			    { $evalId=$eYear->evaluation;
				    $result=Evaluations::model()->findByPk($evalId);
					
					
				 }
				return $result->evaluation_name;
	  
	  }
	
	//Method to take the passing grade from the database 
	
	public function getPassingGrade($id_level, $id_academic_period)
	{
		$criteria = new CDbCriteria;
		$criteria->condition='level=:idLevel AND academic_period=:idAcademicLevel';
		$criteria->params=array(':idLevel'=>$id_level,':idAcademicLevel'=>$id_academic_period);
		$pass_grade = PassingGrades::model()->find($criteria);
	 
	  if(isset($pass_grade))
	  return $pass_grade->minimum_passing; 
	  else 
	    return null;
	} 
	
	public function getAcademicPeriodName_($acad,$room_id)
	  {    
	        $result=ReportCard::getAcademicPeriodName($acad,$room_id);
                if($result!=null)
                    return $result;
                    else
                        return null;
	  }
	  
   public function getAcademicPeriodNameL($acad,$level_id)
	  {    
         	
	        $result=ReportCard::getAcademicPeriodNameLevel($acad,$level_id);
                
                if($result!=null){
                    return $result;
                }

	  }

   
   
    public function searchPeriodName($evaluation)
	   {
	   	    $result=ReportCard::searchPeriodNameForReportCard($evaluation);
                if($result)
                    return $result->name_period;
                    else
                        return null;
	   }
	
	
	
	//XXXXXXXXXXXXXXXXXXXXXX     SUBJECT   	XXXXXXXXXXXXXXXXX
	//************************  loadSubject by room_id in report  ******************************/
		public function loadSubjectByRoomInReport($room_id,$acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		
		  
		  
	      $modelCourse= new Courses();
	       $result=$modelCourse->searchByRoomIdInReport($room_id,$acad); 
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';//.$i->name_period;
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	
//************************  loadStudentByCriteria ******************************/
	public function loadStudentByCriteria($criteria)
	{    $code= array();
		   
		    $persons=Persons::model()->findAll($criteria);
            
			
		    if(isset($persons))
			 {  
			    foreach($persons as $stud){
			        $code[$stud->id]= $stud->fullName." (".$stud->id_number.")";
		           
		           }
			 }
		   
		return $code;
         
	}
	
//************************  getSubgetCoursesByRoomForGraph  ******************************/
		public function getCoursesByRoomForGraph($room_id,$acad)
	{    
       	  		 
	      $modelCourse= new Courses();
	       $result=$modelCourse->searchByRoomIdEvenIfNoGrades($room_id,$acad); 
		 
			
		return $result;
         
	}




	//************************  loadSubjectByTeacherRoom($room_id,$id_teacher,$acad)  ******************************/
	public function loadSubjectByTeacherRoom($room_id,$id_teacher,$acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseByTeacherRoom($room_id,$id_teacher,$acad);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';//.$i->name_period;
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	


//************************  loadReportcardCategory ******************************/
	public function loadReportcardCategory()
	{    
		$code= array();
		   
		  $code[0]= Yii::t('app','unrestrained');
		  $code[1]= Yii::t('app','with restraint');
		  $code[2]= Yii::t('app','all');
		    		   
		return $code;
         
	}


	//XXXXXXXXXXXXXXXXXXXXXXXXXXX   GENERAL REPORT	XXXXXXXXXXXXXXXXXXXXXXXXXXXXX
	public function searchStudentsBySection($sec_id)
	  {
             	  
		  $modelRoomHasPerson= new RoomHasPerson();
	      $result= $modelRoomHasPerson->searchStudents_($sec_id);
		   
		  		
		return $result;
		 
	}
	
	public function searchTeachersBySection($sec_id)
	  {	  
		  
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
	
		$teach = new Courses;
       
		$result=$teach->searchTeachersBySection($sec_id,$acad_sess);
				return $result;
		  
	}
	
	
	
	
	
	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=ReportCard::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ReportCard-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	
	
 public function if_all_grades_validated($student,$evaluation)
  {
  	   $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
    
    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }

      

  
  	      
  	      
  	       $there_is=true;
  	       
  	        $gradesInfo= Grades::model()->ifAllGradesValidated($condition,$student,$evaluation);
  	        
  	        if(isset($gradesInfo))
			  {
				 $r=$gradesInfo->getData();
														
					foreach($r as $grade)
					 {
					 	if($grade->validate==0)
					 	  $there_is=false;
					 }
					 
					 
			  }
			  else
			     $there_is=false;
			     
			     
	
	       return $there_is;
  
  
  }
	

	//************************  getStudentAverageInfo($stud,$room,$level, $shift, $section,$eval,$acad) ******************************/
	
	// return values: $tot_grade; $average; $place
 public function getStudentAverageInfo($stud,$room,$level, $shift, $section,$eval,$acad)
	{
		$acad_=Yii::app()->session['currentId_academic_year']; 
		
		$average_base=0;
		//Extract average base
        $average_base = infoGeneralConfig('average_base');
				   				
		
		  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
		    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad_!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }



		 
		 $result[null]= null;
		
			$dataProvider1=$this->loadSubject($room,$level,$acad);
										   
												   $k=0;
												   $tot_grade=0;
                                                   $place=0;
												   
                               
												   $max_grade=0;
                        $position = Grades::model()->searchForPosition($condition,$eval, $shift, $section, $level, $room);
                                            
										
										$old_maxValue=0;
											$old_place=0;
											$position_to_placecode= array();
											$position_to_placecode[null][null]= null;
										   $j = 1;
										   $compteur = 0;
										  if(isset($position))
										    {
											  $r=$position->getData();
														
												foreach($r as $pos)
												  {
												    $position_to_placecode[$compteur][0]= $pos->student ;
													if($pos->max_grade===$old_maxValue)
													   $position_to_placecode[$compteur][1]= $old_place;
													else
													  { $position_to_placecode[$compteur][1]= $j;
														   $old_place=$j;
													   }
													   
												  $compteur++;
												  $old_maxValue=$pos->max_grade;
												  $j=$j+1; 	
												  
												 }
										     }
										   
							
							                 for($jj = 0; $jj<$compteur; $jj++)
									       {
                                                       
										     if($position_to_placecode[$jj][0]===$stud)
										           {
                                                         $place = $position_to_placecode[$jj][1]; 
                                                                                                               
                                                    }
                                                    			                                
                                              }

                                    $point2Note=false;
													    while(isset($dataProvider1[$k][0])){
													      
													       $careAbout=$this->isSubjectEvaluated($dataProvider1[$k][0],$room,$eval);         
													                   
													  if($careAbout)                
													     {  //somme des coefficients des matieres
													           $max_grade=$max_grade+$dataProvider1[$k][2];
													     
													     } 
													     
													     $grades=Grades::model()->searchForReportCard($condition,$stud,$dataProvider1[$k][0], $eval);
                                                               $_grade=0;														  
														   if(isset($grades)){
														       $r=$grades->getData();//return a list of  objects
														     foreach($r as $grade) {
														       
														
														       $point2Note=false;
														         
														         if($grade->grade_value!=null)
														           {
															             $tot_grade=$tot_grade+$grade->grade_value;   //somme des notes obtenues par matieres
															          
															          
															               
														           }
														          else //pas de notes
                                                               {
                                                               	   $point2Note=true;
                                                               	}
                                                        
                                                               
															   
															   }
                                                                                                                           
                                                               }
                                                             else //pas de notes
                                                               {
                                                               	   $point2Note=true;
                                                               	}
													          	 
														$k=$k+1;
														}
														
								$average=-1;
								if($point2Note)
								   $max_grade=0;
								  
								if(($average_base ==10)||($average_base ==100))
		                          { if($max_grade!=0) 
		                                $average=round(($tot_grade/$max_grade)*$average_base,2);
		                          }
		                         else
		                           $average=null;
																			
														
								$result[0]= $tot_grade;
								$result[1]= $max_grade;
								$result[2]= $average;
								$result[3]= $place;
								
								
				return $result;

		
	}
	
	
	
	
	//************************  loadSuccessDecision ******************************/
	public function loadSuccessDecision()
	{    
		$decision = infoGeneralConfig('decision_finale_success');
				
		
		$decision_success_finale_array= explode("/",substr($decision, 0));
           
        
           $code= array();
		 $code[null]=null;// Yii::t('app','-- Select --');
		   
		    foreach($decision_success_finale_array as $decision_success_finale){
			        $code[$decision_success_finale]= $decision_success_finale;
		           
		           }
			
		   
		return $code;
        
        
      	}
      	
      	
      	//************************  loadFailureDecision ******************************/
	public function loadFailureDecision()
	{    
		$decision = infoGeneralConfig('decision_finale_failure');
				
		
		$decision_failure_finale_array= explode("/",substr($decision, 0));
           
        
           $code= array();
		 $code[null]=null;
		   
		    foreach($decision_failure_finale_array as $decision_failure_finale){
			        $code[$decision_failure_finale]= $decision_failure_finale;
		           
		           }
			
		   
		return $code;
        
        
      	}

	// Behavior the create Export to CSV 
	public function behaviors() {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','persons.csv'),
	            'csvDelimiter' => ',',
	            ));
	}





public function actionPeriodsSummary()
	 {  
		$model=new ReportCard;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelCourse=new Courses;
		$modelEvaluation= new EvaluationByYear;
		$modelGrade=new Grades;
		
		$reportCard = 'documents/reportcard';
		
		//$this->reportcard_category_id =2; //tous les bulletins
		
		//Extract reportcard_structure (1:One evaluation by Period OR 2:Many evaluations in ONE Period)
         $reportcard_structure = infoGeneralConfig('reportcard_structure');
         
         $siges_structure=infoGeneralConfig('siges_structure_session'); 
         
         $this->final_period=false;
         
        //fose pou se pou reportcard_structure=1 (1:One evaluation by Period) an li mache selman
        //ak siges_structure =0 (basic) an.
		
		$this->performAjaxValidation($model);
        
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
   
		
		  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }

         $reportcard_category = '';
      

        //return 
		$model_EvaluationByYear = EvaluationByYear::model()->findByAttributes(array('last_evaluation'=>1));
		if(isset($model_EvaluationByYear)&&($model_EvaluationByYear!=null))	            
		    {      $this->evaluation_id = $model_EvaluationByYear->id;
		    		    
		    }
		else
		   $this->evaluation_id = '';
				 
		
		if(isset($_POST['Shifts']))
               	{  
				
				//on n'a pas presser le bouton, il fo load apropriate rooms
					      $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
	                      Yii::app()->session['Shifts'] = $this->idShift;
                      
				     

								  
						   $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   Yii::app()->session['Sections'] = $this->section_id;
					     						
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   Yii::app()->session['LevelHasPerson'] = $this->idLevel;
						   
						  						   					
					     if(isset($_POST['Rooms']))
	                      {   $modelRoom->attributes=$_POST['Rooms'];
							   $this->room_id=$modelRoom->room_name;
							  
							  
	                      }
	                    else
	                      {
	                      	   if(isset($_GET['roo']))
	                      	      $this->room_id=$_GET['roo'];
	                      	
	                      	}

					 
            
					 //  $this->reportcard_category_id=$_POST['ReportCard']['reportcard_category'];
						   
						   
                          if((isset($this->room_id))&&($this->room_id!=""))
			                { if((isset($this->evaluation_id))&&($this->evaluation_id!=""))
			                   {    $room=$this->getRoomName($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id);
                               $acadPeriod_for_this_room = $this->getAcademicPeriodName_($acad_sess,$this->room_id);
                              
                              $name_acadPeriod_for_this_room=null;           
                              if(isset($acadPeriod_for_this_room))//!=null)
                               {       
                                 $name_acadPeriod_for_this_room=$acadPeriod_for_this_room->name_period;
                               }    
                                     //retire tout aksan yo    
                                         
		                                 $room1 = str_replace('/', '_', $room);
		                                 $room = strtr( $room1, pa_daksan() );
		                                 
		                                 $level1 = str_replace('/', '_', $level);
		                                 $level = strtr( $level1, pa_daksan() );
		                                 
		                                 $section1 = str_replace('/', '_', $section);
		                                 $section = strtr( $section1, pa_daksan() );
		                                 
		                                 $shift = strtr( $shift, pa_daksan() );
		                                 
		                                 $evaluationPeriod1 = str_replace('/', '_', $evaluationPeriod);
		                                 $evaluationPeriod = strtr( $evaluationPeriod1, pa_daksan() );
		                                 
		                                 $name_acadPeriod_for_this_room1 = str_replace('/', '_', $name_acadPeriod_for_this_room);
		                                 $name_acadPeriod_for_this_room = strtr( $name_acadPeriod_for_this_room1, pa_daksan() );
                                        
                                         
                                        
                                         
                                         
                                         
                                      $period_acad_id11111 = 0;
                            $period_exam_name11111 = null;
                            $eval_date = null;
			                $acad_year =0;
						// To find period name in in evaluation by year 
                                                                
                                                               $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name1 = str_replace('/', '_', $r->name_period);
																	$period_exam_name11111= strtr( $period_exam_name1, pa_daksan() );
																   $period_acad_id11111 = $r->id;
																   $eval_date = $r->evaluation_date;
															       $acad_year = $r->academic_year;
																   }
															 }
                                  // end of code 

							if($name_acadPeriod_for_this_room!=null)
                               {  								                                                 
                                   $this->noStud = 1; //people enrolled this room pour cette annee academic
                               }
                             else //$acadPeriod==null, no people enrolled this room
                                   $this->noStud = 0;
					        }
					      else //display a message to ask for fill in evalvuationPeriod 
							 {
						         $this->messageEvaluation_id=true;
						      }
					
					 }//end if((isset($this->room_id))&&($this->room_id!=""))
						
						   
	             }				   
				else //$_POST['Shifts'] not set
				  {
				   							
				   $this->idShift=null;
                   $this->section_id=null;
				   $this->idLevel=null;
				   $this->room_id=null;
				   $this->course_id=null;
				   $this->student_id=null;
				   
				   $this->allowLink=false;
				   $this->messageEvaluation_id=false;
                                   $this->noStud = 0; 
				     }
		
			 if(isset($_POST['create']))
				 { //on vient de presser le bouton create
				 	 $pastp = null;//array(); //pou denye evalyasyon nan chak peryod pase
				 	 $past_period = null; //pou evalyasyon ki pase deja nan yon peryod
				 	 $compter_p=1; //on compte deja the current period
				 	 $last_eval_=false; //par defaut, ce n;est pas la derniere evaluation pour cette periode
                     $eval_date=null;
                     
                     $pass=true;
                     
				 	 $pastEval = new Evaluations();
				 	 $modEY = new EvaluationByYear;
				 	 
				 
                            //getting past evaluation period
						  if(isset($_POST['Evaluations']))//&&($_POST['Evaluations'])) 
						     {	
					 			foreach($_POST['Evaluations'] as $r)
									{  if($r!=null)
									      $pastp = $r;
									        
									 }
									     
						     } 
						               	
                         
                         
					
					
					    $last_eval_period = EvaluationByYear::model()->findByPk($this->evaluation_id);
         
				         
				           	  $this->final_period=true; 
				           
				              //Extract use_period_weight 
							   $use_period_weight = infoGeneralConfig('use_period_weight');
							   
							   if($use_period_weight==1)
							    {
							    	//tcheke somme tout period yo
							    	 $sum_weight = sumPeriodWeight($pastp,$last_eval_period->id);
							    	
							    	 if( ($sum_weight!=100) && ($sum_weight!= -1) )
							    	   $pass=false;
							    	 
							     }
							     
							     
				            
				           
				 	
						 //Extract school name 
							$school_name = infoGeneralConfig('school_name');
                        //Extract school address
				   			$school_address = infoGeneralConfig('school_address');
                        //Extract  email address 
                           $school_email_address = infoGeneralConfig('school_email_address');
                        //Extract Phone Number
                            $school_phone_number = infoGeneralConfig('school_phone_number');
				   								
	                                                               
                     
				   if($pass==true)
				     {
				   
				   
					    if(isset($_POST['chk']) )  {

						   	     						
							     //on retourne l'ID de l'eleve
								// Ne pas eliminer les commentaires dans la generation des fichiers PDF, posible utilisation ulterieure par d'autres programmeurs		
							     
								
								// create new PDF document
								$pdf = new tcpdf("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app',"Periods Summary"));
								$pdf->SetSubject(Yii::t('app',"Periods Summary"));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								
								//$pdf->SetHeaderData(PDF_HEADER_LOGO_REPORTCARD, PDF_HEADER_LOGO_REPORTCARD_WIDTH, "", ""); //CNR
								$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								//$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);      //CNR
								$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, 5); // PDF_MARGIN_BOTTOM

								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 12, '', true);
								
			
									
										
										
										//calculate position
										  
											$old_maxValue=0;
											$old_place=0;
											$position_to_placecode= array();
											$position_to_placecode[null][null]= null;
										   $j = 1;
										   $compteur = 0;
										 
										    
										   
							$tot = $compteur;//-1;
																
							$period_acad_id = 0;
                            $period_exam_name = null;
	
						
                                  $last_eval_date=null;
							          $acad_year=0;
							          $array_past_period = array();
							          
							         
                                      $this->tot_stud=$tot;

						
                              foreach($_POST['chk'] as $val) {
								  $array_past_period= array();
								  $place=0;
								    $k=0;
									 $tot_grade=0;
									$temoin_has_note=false;
								   $max_grade=0;
								   
									$this->student_id=$val;
							
							 //check if all grades are validated for this stud		
								$all_validated=$this->if_all_grades_validated($this->student_id,$this->evaluation_id);
								
								    $shiftName=$this->getShiftByStudentId($this->student_id)->shift_name;
									$sectionName=$this->getSectionByStudentId($this->student_id)->section_name;
									$levelName=$this->getLevelByStudentId($this->student_id)->level_name;
									$roomName=$this->getRoomByStudentId($this->student_id)->room_name;
								
									$acadPeriod_for_this_room=$this->getAcademicPeriodName_($acad_sess,$this->getRoomByStudentId($this->student_id)->id);
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id); 
							       
							  
							  if($all_validated)
								{	     

                                                   
								  if(isset($this->student_id)&&($this->student_id!=''))
								   {  
								   	  
								     // To find period name in in evaluation by year 
                                                                
                                                               $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
                                                               // end of code 
								     
							        $student=$this->getStudent($this->student_id);
							        $room=$this->getRoomName($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
										   $dataProvider=$this->loadSubject($this->room_id,$this->idLevel);
										   
										        
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();
$general_average=0;
								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print

                                  if($reportcard_structure==1) //One evaluation by Period
									  {
										 
									                                       	
			
		 
		    $this->summary = true;
   
           $condition = 'p.active IN(1,2) AND ';
						        

      
								   								
	 $general_average_current_period =0;
     $max_grade_discipline=0;
     $include_discipline=0;
     $include_place = 1;
     $average_base =0;
     
				                               //Extract max grade of discipline
				                              $max_grade_discipline = infoGeneralConfig('note_discipline_initiale');
								   				//Extract school Director
				                               $include_discipline = infoGeneralConfig('include_discipline_grade');
				                               
								   				//Extract average base
				                                $average_base = infoGeneralConfig('average_base');
				                                
				                                //Extract display_period_summary
				                                $display_period_summary = infoGeneralConfig('display_period_summary');
				                                
				                                //Extract use_period_weight
				                                $use_period_weight = infoGeneralConfig('use_period_weight');
				                                
				                                

				     
     
     $eval_date = null;
			                   $acad_year = null;
			                    


                  //find date of the current evaluation
						$result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
							if(isset($result))
							 {  $result=$result->getData();//return a list of  objects
								 foreach($result as $r)
								   { $eval_date = $r->evaluation_date;
									  $acad_year = $r->academic_year;	   
									}
							   }
 
     
     
       $data_current_period =null;	      
	   $p_name_general_average = EvaluationByYear::model()-> getPeriodNameByEvaluationDATE($eval_date);
			           
		   foreach($p_name_general_average as $p_na)
			 $data_current_period = $p_na;
		


							
							
							$html = <<<EOD
 <style>
	
	
.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		//color: #1e5c8c;
        font-size: 16px;
		width:100%;
		text-align: center;
		
		 
	   }
	
	
.info{   font-size:10px;
      background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
	 }
		
 .corps{
	 
	width:100%;
	background-color: #F5F6F7;
	
	}

		
table.signature {
		width:90%;
		float:right;
		font-size:10px;
		margin-top:55px;
		margin-bottom:5px;
		
	}
	
.place{
	  font-size:6pt;
	}
	
	td.signature1 {
		
		
	}
	
	td.signature2 {
		
		
	}
	
	td.space {
		width:30%;
		
	}

.tb {
		
		width:100%;
	    
		//loat:right;
		
		font-size:10px;
				
	}
	
 .discipline {
		width:65%; 
		margin-top:20px;
		font-size:10px;
	}

		
 .subjectheadnote {
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			width:30%;
			
			}
			
			

.subjectheadnote_white_tr{
			
			background-color:#FFFFFF; 
	
			}
						
						
 .subject{
			color:#000; 
			font-size:10px; 
			height:20px;
			font-weight: normal; //bold; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;
			}
		
 .color1{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}


 .color2	{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
	
 .sommes	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes1	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes2{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			border-top: 1px solid #EE6539;
			border-radius: 5px;
			background-color:  #EFEFEF;
			border-bottom: 1px solid #ecedf4;
			
		}

 .border	{
			
			border-bottom: 1px solid #ecedf4;
		}
			
.headnote {
		//width:10%;
		
	}
	
	
.periodsommes2{
		height:20px; 
		text-align: right;
			border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}
.periodsommes{
	height:20px;
	text-align: right; 	
	border-bottom: 1px solid #ecedf4;
	}
 .period {
		width:10%;
		text-align: center;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodParent {
		width:10%;
		text-align: center;
		font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodsommes2_red{
		width:10%;
		text-align: center;
		border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}	
	
.periodheadnote {
		width:10%;
		font-size:9px;
	
	}

.subjectParent{
	//text-transform: uppercase; //capitalize; //|uppercase|lowercase|initial|inherit|none;
	height:15px;
	font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	
			
	}
	

			
div > .subject {
		width:30%;
		 text-indent: 10px;
		 font-weight: normal; //bold; 
		
	}
	
.subject_single{
		    color:#000; 
			font-size:10px; 
			height:20px;
			font-weight:bold;
			text-indent: 0px; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;	
	}	
		
	
	
</style>
                                       
										
EOD;
	 
				   						 
										$html .='<span class="title" >'.strtoupper(Yii::t("app","Periods Summary")).'
										              <br/><span style="font-size:10px;" >'.$level.' / '.$section.' / '.$shift.' / '.$name_acadPeriod_for_this_room.'</span></span><div class="info" >  <b>'.Yii::t('app','Name: ').'</b> '.$student;
										
										$html .=' </div>
														    
                                                      <div class="corps">    
															<table class="tb"> 
                                                                     													  
														             <tr><td class="subjectheadnote"></td>';
														             
					
			 //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		// debut of cases depending on past period	   
			                    $eval_period='';
			                    $compter_p=1;
			                     if($pastp!=null)
				                     {  
					                   foreach($pastp as $id_past_period)
					                      {
			 	                                $compter_p++;
			 	                                //$eval_period = $this->searchPeriodName($id_past_period);
			 	                                $period=ReportCard::searchPeriodNameForReportCard($id_past_period);
			 	                                
										       if($use_period_weight==1)                 
												 $html .='<td class="periodheadnote" > <span style="font-size:8pt; text-align:center;"> <b>'.$period->name_period.'</b><br/>('.$period->weight.'%)  </span> </td>';
											   else
											     $html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$period->name_period.'</b>  </span> </td>';
																		
											}
											//for the current period
											//$eval_period=$this->searchPeriodName($this->evaluation_id);
											$period=ReportCard::searchPeriodNameForReportCard($this->evaluation_id);
											
											if($use_period_weight==1)
											  $html .='<td class="periodheadnote" > <span style="font-size:8pt; text-align:center;"> <b>'.$period->name_period.'</b><br/>('.$period->weight.'%) </span> </td>'; 
											else
											  $html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$period->name_period.'</b> </span> </td>';
											 
											//$html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$evaluationPeriod.'-'.$period_exam_name.'</b> </span> </td>';
											
								       } 
								    else  //for the current period
									{      $eval_period=$this->searchPeriodName($this->evaluation_id);
									
										$html .='<td class="periodheadnote" > <span style="font-size:8pt; text-align:center;"> <b>'.$period_exam_name.'</b> </span> </td>'; 
										 //$html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$evaluationPeriod.'</b> </span> </td>';
								    }							      
									//fin ajout  
									$compter_p=$compter_p+2; 
									
									if(($display_period_summary ==1) && ($this->summary == true) )
									 {
										$html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.Yii::t('app','Summary ').'</b> </span> </td>';
										$compter_p++;
									   }         
											$html .=' <td class="periodheadnote" >  <b>'.Yii::t('app','MAX GRADE').'</b>  </td></tr><tr class=""><td ></td></tr>																 
																	 ';
																	
											            $i=0;
											            
											              $old_parent='';
											              
											           $tot_grade_period_summary =0;
											           
											           
					                                   //[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
													   while(isset($dataProvider[$k][0]))
													     {
													     
                                                               $_grade=0;														  
														      if($i==2)
																 $i=0;
																if($i==0)
																	$class="color1";
																elseif($i==1)
																	$class="color2";

																			  
//$class_child="subject";																//$line=
																
if($dataProvider[$k][3]!=null)//[$k][1]=id; [$k][1]=subject_name; [$k][2]=weight; [$k][3]=subject_parent; [$k][4]=reference_id;
  {  
  	  $parent_name ='';
  	  $grade_total=0;
  	  $weight_total=0;
 	  
  	  $subject_parent_name = Subjects::model()->getSubjectNameBySubjectID($dataProvider[$k][3]);
  	  $subject_parent_name = $subject_parent_name->getData();
  	  
  	  $class_child="subject";
  	  
  	    foreach($subject_parent_name as $subject_parent)
  	       $parent_name = $subject_parent;
  	  
  	    if($old_parent!= $dataProvider[$k][3])                     
  	     {  
  	     	/*if($parent_name!=null)
  	     	   $html .='<tr class=""  > <td class="subjectParent" colspan="'.$compter_p.'" > '.strtoupper(strtr($parent_name->subject_name, pa_daksan() )).'  </td> </tr>';
  	     	else
  	     	   $html .='<tr class=""  > <td class="subjectParent" colspan="'.$compter_p.'" > Not Found </td> </tr>';
  	     	   */
   
  	         $old_parent = $dataProvider[$k][3];
  	       }
  	  
  	    
     }
  else
     {
     	   $class_child="subject_single";
     	   
        if($old_parent!= $dataProvider[$k][3])
  	     { 
           $old_parent = $dataProvider[$k][3];
           
  	     }
  	    	       	   
  	     
      }
                                             $summary_grade = 0;
                                             $summary_grade_count = 0;
                                              
                                               
											  $html .='<tr class="'.$class.'"> <td class="'.$class_child.'"> '.$dataProvider[$k][1].'  </td>';	     
															
													 if($pastp!=null)
														   {  
															  if($dataProvider[$k][4]!=NULL)
															     $id_course = $dataProvider[$k][4];
															  else
															    $id_course = $dataProvider[$k][0];
															   
															  foreach($pastp as $id_past_period)
															    {
																		//si kou a evalye pou peryod sa
																		$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$id_past_period);         
													                   if($old_subject_evaluated)
													                      $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$id_past_period);
													                   else
													                       $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$id_past_period);

																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			          // pr creer bulletin pr ceux ki ont au moins 1 note

																			        if($grade->grade_value!=null)																					                                                {  $temoin_has_note=true;	
									
									                                              if(($display_period_summary ==1))// && ($this->summary == true) )
																						 {
																							//care about
																							$careAbout=$this->isSubjectEvaluated($id_course,$this->room_id,$id_past_period);         
													                                         if($careAbout)
																							   { $summary_grade = $summary_grade + $grade->grade_value;
																							       $summary_grade_count++;
																							     }
																							   
																						   }
																						   
																						   //les colonnes notes suivant le nbre d'etape anterieur
										                                   
																		           $html .=' <td class="period" > '.$grade->grade_value.' </td>';
														//fin...			           
														                             
																			            }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			             
																			            // $max_grade=$max_grade+$dataProvider[$k][2];
																			             
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
																			  
																			  
													  	                   } //fin isset grades
													  	                   
													  	                   
													  	                   
																	   }//fin foreach past_period
																	   //$careAbout=false;
																	   if($dataProvider[$k][4]!=NULL)
																	      {  $id_course = $dataProvider[$k][4];
																	         //si kou a evalye pou peryod sa
																				$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
															                   if($old_subject_evaluated)
															                     { $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$this->evaluation_id);
															                        $careAbout=$old_subject_evaluated; 
															                     }
															                   else
															                     {  $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
															                       $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id); 
															                     }
		
																	      }
																	  else
																	    {  $id_course = $dataProvider[$k][0];
																	        $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
																	        $careAbout=$this->isSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id); 
																	    }         
													                    if(($careAbout))//if(($careAbout)||($pastp!=null) )
													                         $max_grade=$max_grade+$dataProvider[$k][2];
																	   
																	   //Grades for the current period
																	  
																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			   
																			        if($grade->grade_value!=null)// pr creer bulletin pr ceux ki ont au moins 1 note
																					  { $temoin_has_note=true;	
									//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									                                              //les colonnes notes suivant le nbre d'etape anterieur
										                                                     
																		           if($careAbout)
																		              {  $tot_grade = $tot_grade + $grade->grade_value;
																		              
																		                 $html .=' <td class="period" > '.$grade->grade_value.' </td>';
																		                   
																		                   if(($display_period_summary ==1))// && ($this->summary == true) )
																						     {
																						     	$summary_grade = $summary_grade + $grade->grade_value;
																							       $summary_grade_count++;
																						       
																						       }
							 											              
																		                }
														//fin...			        
                                                         
																				   
																					  
																					   }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			              
																			           
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
													  	                   } //fin isset grades
																	  
                                                                   }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                               if($dataProvider[$k][4]!=NULL)
															      {  $id_course = $dataProvider[$k][4];
															         //si kou a evalye pou peryod sa
																		$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
													                   if($old_subject_evaluated)
													                     { $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$this->evaluation_id);
													                        $careAbout=$old_subject_evaluated; 
													                     }
													                   else
													                     {  $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
													                       $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id); 
													                     }

															      }
															  else
															    {  $id_course = $dataProvider[$k][0];
															        $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$dataProvider[$k][0],$this->evaluation_id);
															        $careAbout=$this->isSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id); 
															    }
                                                             	
                                                              
                                                              
                                                             	                
													                    if(($careAbout) )//if( ($careAbout)||($pastp!=null) )
													                         $max_grade=$max_grade+$dataProvider[$k][2];

                                                             	//Grades for the current period
																	  // $grades=Grades::model()->searchForReportCard($condition,$this->student_id,$id_course,$this->evaluation_id);
																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			   
																			        if($grade->grade_value!=null)// pr creer bulletin pr ceux ki ont au moins 1 note
																					  { $temoin_has_note=true;	
									//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
									                                              //les colonnes notes suivant le nbre d'etape anterieur
										                                                    
																		           
																		               if($careAbout)
																		                 {  $tot_grade = $tot_grade + $grade->grade_value;
																		                    $html .=' <td class="period" > '.$grade->grade_value.' </td>';
																		                 
																		                      if(($display_period_summary ==1))// && ($this->summary == true) )
																						        {
																						        	$summary_grade = $summary_grade + $grade->grade_value;
																							       $summary_grade_count++;
																						           
																						           }
																		                    
																		                   }
														//fin...			
                                                       
                                                      																					   
																					   }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			             
																			             
   															                      }//fin foreach grades
																				}
																			  else
																			  $html .=' <td class="period" > --- </td>';
													  	                   } //fin isset grades
																	  

                                                             }//fin past_period ==null
                                                             
                                           if(($display_period_summary ==1) && ($this->summary == true) )
											 {
												$tot_summary_grade = 0;
												   
												   if($summary_grade_count!= 0)
												      $tot_summary_grade = round( ($summary_grade / $summary_grade_count), 2); 
												      
												      $tot_grade_period_summary = $tot_grade_period_summary + $tot_summary_grade;  
												   
													if($tot_summary_grade!=0)
													  $html .=' <td class="period" ><b> '.$tot_summary_grade.'</b></td>';	
													else
													   $html .=' <td class="period" ><b> --- </b></td>';									     
																							   
											  }       
													
											if( ($careAbout)||($pastp!=null) )
											  $html .=' <td class="period" ><b> '.$dataProvider[$k][2].'</b></td>';
											else
											   $html .=' <td class="period" ><b></b></td>';
											
											  
									 $html .=' </tr>
												 ';              $i++;
														       						                                        
                                                               
														$k=$k+1;
										 }
														
									
      
	//check to include discipline grade
//check to include discipline grade

if($include_discipline==1)
  {    												
  	     $html .='<tr class="" > <td class="subject_single"> '.Yii::t('app','Discipline').'  </td>';                                
  	                                     
  	                                     $summary_grade_discipline_count=0;
  	                                     $summary_grade_discipline=0;
  	                                     
  	                                      if($pastp!=null)
														   {  
															  foreach($pastp as $id_past_period)
															    {   // To find period name in in evaluation by year 
                                                                    $period_acad_id =null;
			                                                        //$result=EvaluationByYear::model()->searchPeriodName($id_past_period);
			                                                        $period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;
																		
			                                                               // end of code 
																															  	                   
													  	               		$grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																		  	 
																		  	 $summary_grade_discipline_count++;
																		  	 
																		  	 $summary_grade_discipline=$grade_discipline;
																		  	 
																		//  	if(($grade_discipline==0))
																	  	//   $html .='<td class="period" > --- </td>';
																	  	// else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																	
																		  
													  	                   
																 }//fin foreach past_period
																
																 //current period
																 // To find period name in in evaluation by year 
                                                                 $period_acad_id =null;
			                                                       // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
			                                                       $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
																		
			                                                               // end of code 
																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	 $max_grade = $max_grade + $max_grade_discipline;
																	  	 $tot_grade = $tot_grade + $grade_discipline;
																	  	
																	     	$summary_grade_discipline_count++;
																		  	 
																		  	 $summary_grade_discipline=$grade_discipline;
																		  	 
																	  	//if(($grade_discipline==0))
																	  	//   $html .='<td class="period" > --- </td>';
																	  	// else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																
																	  						  	                   
																	  
                                                              }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                                 //current period
																	// To find period name in in evaluation by year 
                                                                 $period_acad_id =null;
			                                                       // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
			                                                       $period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
																		
			                                                               // end of code 
																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	 $max_grade = $max_grade + $max_grade_discipline;
																	  	 $tot_grade = $tot_grade + $grade_discipline;
																	  	
																	  	 $summary_grade_discipline_count++;
																		  	 
																		  	 $summary_grade_discipline=$grade_discipline;
																	  	 
																	  	 //if(($grade_discipline==0))
																	  	 //  $html .='<td class="period" > --- </td>';
																	  	 //else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																
																	  		
                                                               }
                                                               
                                                               
                                          if(($display_period_summary ==1) && ($this->summary == true) )
											 {
												$tot_summary_grade_discipline = 0;
												   
												   if($summary_grade_discipline_count!= 0)
												      $tot_summary_grade_discipline = round( ($summary_grade_discipline / $summary_grade_discipline_count), 2);   
												   $tot_grade_period_summary = $tot_grade_period_summary + $tot_summary_grade_discipline;
												   
													if($tot_summary_grade_discipline!=0)
													  $html .=' <td class="period" ><b> '.$tot_summary_grade_discipline.'</b></td>';	
													else
													   $html .=' <td class="period" ><b> --- </b></td>';									     
																							   
											  }                        
                                                               
                                  if(($max_grade_discipline==null)||($max_grade_discipline==0))
                                     $html .=' <td class="period" ><b> --- </b></td></tr>';
                                  else
                                     $html .=' <td class="period" ><b> '.$max_grade_discipline.'</b></td></tr>';                          	 
	}
  
 
      
  $place_text=null;                     
if($place===1)		
 $place_text=$place.'<span class="place">'.Yii::t('app','st').'</span>';
                                                                                                                                        elseif($place===2)
                                                                                                                                            $place_text=$place.'<span class="place">'.Yii::t('app','nd').'</span>';
																																			elseif($place===3)
                                                                                                                                                $place_text=$place.'<span class="place">'.Yii::t('app','rd').'</span>';
                                                                                                                                               else
                                                                                                                                                 $place_text=$place.'<span class="place">'.Yii::t('app','th').'</span>'; 	          
                                                                                     
                                              $average=0;  	$general_average=0; 
						  
						  if(($average_base==10)||($average_base==100)) 
							   { if($max_grade!=0)  
							       $average=round(($tot_grade/$max_grade)*$average_base,2);
							   }
							  else			
								$average =null;	
												 
										//$html .= '<tr class="subjectheadnote_white_tr"><td colspan="'.$compter_p.'"> </td></tr>';
										
										          $html .= '<tr class="sommes"><td class="periodsommes"><b>'.Yii::t('app','Average: ').'</b></td>';
														
														$general_average=0; 
														
													 if($pastp!=null)
														     {  
															    foreach($pastp as $id_past_period)
															      {
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$this->student_id);
																			if(isset($data_)){
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) 
																			       {
																			         if($use_period_weight==1)
																			          {
																			          	 //jwenn peryod eval sa ye
																		  	    	   	  $p_acad = EvaluationByYear::model()->getPeriodNameByEvaluationID($id_past_period);
																		  	    	   	  
																		  	    	   	   foreach($p_acad as $p_weight)
																		  	    	   	     {  
																		  	    	   	     	if($p_weight['weight']!=null)
																		  	    	   	           $general_average = round( ($general_average + ( ($_data->average*$p_weight['weight'])/100) ), 2);
																		  	    	   	              
																		  	    	   	      }
																		  	    	   	     
																			           }
																			          else
																			            $general_average = round( ($general_average + $_data->average), 2);
																			            
																				     $html .='<td class="period"> '.$_data->average.' </td>';
														                          }//fin foreach _data 
																				}
																				else
																			      $html .='<td class="period"> --- </td>';
													  	                   } //fin isset data_
																	   }//fin foreach past period
																	  
																	  //average for the current period 
																	 
																			      	if($use_period_weight==1)
																			          {  
																						  //jwenn peryod eval sa ye
																		  	    	   	  $p_acad = EvaluationByYear::model()->getPeriodNameByEvaluationID($this->evaluation_id);
																		  	    	   	  
																		  	    	   	   foreach($p_acad as $p_weight)
																		  	    	   	     {  
																		  	    	   	     	if($p_weight['weight']!=null)
																		  	    	   	           $general_average = round( ($general_average + (($average*$p_weight['weight'])/100) ), 2);
																		  	    	   	              
																		  	    	   	      }
																		  	    	   	     
																			           }
																			          else
																			            $general_average = round( ($general_average + $average), 2);
																			            
																			      	
																			      	if($average!=0)
																			           {
																			           	 $html .='<td class="period"> '.$average.' </td>';
																			           }
																			         else 
																			           $html .='<td class="period"> --- </td>';
			 																 
													  	                    
                                                                   }//fin isset period
                                                                 else
                                                                   {
                                                                   	//average for the current period 
																	  
																			      	 if($use_period_weight==1)
																			          {  
																						  //jwenn peryod eval sa ye
																		  	    	   	  $p_acad = EvaluationByYear::model()->getPeriodNameByEvaluationID($this->evaluation_id);
																		  	    	   	  
																		  	    	   	   foreach($p_acad as $p_weight)
																		  	    	   	     {  
																		  	    	   	     	if($p_weight['weight']!=null)
																		  	    	   	           $general_average = round( ($general_average + (($average*$p_weight['weight'])/100) ), 2);
																		  	    	   	              
																		  	    	   	      }
																		  	    	   	     
																			           }
																			          else
																			            $general_average = round( ($general_average + $average), 2);
																			            
																			            
																			         
																			         if($average!=0)
																			           { 
																			               $html .='<td class="period"> '.$average.' </td>';
																			           }
																			         else
																			           $html .='<td class="period"> --- </td>';
																			     
                                                                   }
                                                                   
                                                                   
												       if(($display_period_summary ==1) && ($this->summary == true) )
												         {
												         	$general_average=round(($general_average/($compter_p-3)),2);
												         	   
												         	   $html .='<td class="period"><b> '.$general_average.' </b></td>';
												         	   
												         	}
												         	   	
												         	   						     
												               $html .='<td class="period"> </td>
												  </tr>';
			

  			 
	
	if(($display_period_summary !=1))			 
	 {
		if( ((isset($_POST['calculate_g_average']))&&($_POST['calculate_g_average']==true)) || ($use_period_weight==1) ) // make G-average								  
		   { 
					if($pastp!=null)
						{  		
							//calculate the general average
							if($use_period_weight==1)
							  $general_average=round($general_average, 2);
							else
							    $general_average=round(($general_average/($compter_p-2)),2);
							  
												  
							$html .='	<tr class="subjectheadnote_white_tr"><td colspan="'.$compter_p.'"></td></tr>
							        				  
												  
												    <tr class="sommes1"><td class="subject"><b>'.Yii::t('app','General Average:').' </b></td>'; 
												     
																																											                                          if($general_average!=null)
															      $html .='<td class="period"> '.$general_average.'</td>';
															 else
																  $html .='<td class="period"> --- </td>';
																					 
														                       
																	  												            					  
												               $html .='
												  </tr>			  
												  ';
						}

		     }
	  }   
		     
		     
		     							  

$html .= '</table>
            </div>';

if(($include_discipline==0))
  {
  $html .= '<table  class="discipline">
          <tr><td style="border:0px thin #F9F9F9 ;"></td>';
		   //on ajoute les colonnes suivant le nbre d'etape anterieur
			 if($pastp!=null)
				{ $compter_p=1; 
				  foreach($pastp as $id_past_period)
					{
					  $html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;"> <b>'.$this->searchPeriodName($id_past_period).'</b> </span> </td>';
					 
					  
					  		$compter_p++;										
		             }
		            
		            $html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;"> <b>'.$this->searchPeriodName($this->evaluation_id).'</b> </span> </td>'; 
		            
		              
		             
				 }
			else
			  {
			     	$html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;"> <b>'.$period_exam_name.'</b> </span> </td>'; 

			  }
	
	      
	        if(($display_period_summary ==1) && ($this->summary == true) )
			  {
					$html .='<td style="border:1px solid #E4E4E4;"> <span style="font-size:8pt;"> <b>'.Yii::t('app','Summary ').'</b> </span> </td>'; 						   		   
			  }  
	
          
         $html .=' </tr>';
	}
         
  			
//check to include discipline grade
if(($include_discipline!=2)&&($include_discipline!=1))
{
if($include_discipline==0)
  {    												
  	   $html .=' <tr><td style="border:1px solid #E4E4E4;"><span style="font-size:9pt;"><b>'.Yii::t('app','Discipline').'</b></span></td>';//on ajoute les colonnes suivant le nbre d'etape anterieur
                               
                               $konte_peryod = 0;
				               $mwayen_disiplin = 0;
				               $som_peryod = 0.00;
				               
  	                                      if($pastp!=null)
				                            {  
				                              foreach($pastp as $id_past_period)
					                            {    $period_acad_id = null;
														  //$result=EvaluationByYear::model()->searchPeriodName($id_past_period);
															
															$period_acad_id=ReportCard::searchPeriodNameForReportCard($id_past_period)->id;																	  	                   
													  	                 //check to include discipline grade
																		
																		  	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																		  	 
																		  	 $konte_peryod++;
																               
																               $som_peryod +=$grade_discipline;
																		  	 
																		  																			  	 
																		  	//if(($grade_discipline==0))
																	  	   //$html .='<td style="border:1px solid #E4E4E4;" > --- </td>';
																	  	 //else
																	  	    $html .='<td style="border:1px solid #E4E4E4;" > '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																	
																		  
													  	                   
																 }//fin foreach past_period
																
																 //current period
																   $period_acad_id = null;
																  // $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															
															$period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
															
																	 $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																	  	
																	  	$konte_peryod++;
																               
																         $som_peryod +=$grade_discipline;                                            
																	  	
																	  	//if(($grade_discipline==0))
																	  	   //$html .='<td style="border:1px solid #E4E4E4;"> --- </td>';
																	  	// else
																	  	    $html .='<td style="border:1px solid #E4E4E4;"> '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																
																	  						  	                   
																	  
                                                              }//fin past !=null
                                                           else //if past_period null, get grades for the current period
                                                             {          
                                                                 //current period
                                                                 //current period
																   $period_acad_id = null;
																   //$result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															
															$period_acad_id=ReportCard::searchPeriodNameForReportCard($this->evaluation_id)->id;
															                                                                
																$grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id,  $period_acad_id);
																       $konte_peryod++;
																         
																        $som_peryod +=$grade_discipline;
								 
									  	
																	  	//if(($grade_discipline==0))
																	  	//   $html .='<td style="border:1px solid #E4E4E4;" > --- </td>';
																	  	// else
																	  	    $html .='<td style="border:1px solid #E4E4E4;" > '.$grade_discipline.' / '.$max_grade_discipline.' </td>';	     
																
																	  		
                                                               }
                                                               
                                  if(($display_period_summary ==1) && ($this->summary == true) )
									  {
											
											if($konte_peryod!=0)
											  $mwayen_disiplin = round( ($som_peryod/$konte_peryod), 2);
											  
						                       $html .='<td style="border:1px solid #E4E4E4;" ><b> '.$mwayen_disiplin.' / '.$max_grade_discipline.' </b></td>';															             
									  }  
           
            $html .='</tr>';                          
                                                               	 
	}

}			

if(($include_discipline==0))
  {				
  	$html .= '</table>';
  }
  

									  
							 $pdf->writeHTML($html, true, false, true, false, '');		  
									  
									   }
									
                                      
	                             	                            
	                             }// end of if $this->student_id set
	                            
	                          
						    
						    }// end of if($all_validated)
						    
						    
						    
						    
						    
						    
						    
								
                         }// end of chak elev	

					 
				   



					
					       												   
                   //___________________________________________________________________//    
                       
                                              
                       if($all_validated)
                         {
                    				
                    				//retire tout aksan yo    
                                         
		                                 $room1 = str_replace('/', '_', $room);
		                                 $room_ = strtr( $room1, pa_daksan() );
		                                 
		                                 $level1 = str_replace('/', '_', $level);
		                                 $level_ = strtr( $level1, pa_daksan() );
		                                 
		                                 $section1 = str_replace('/', '_', $section);
		                                 $section_ = strtr( $section1, pa_daksan() );
		                                 
		                                 $shift_ = strtr( $shift, pa_daksan() );
		                                 
		                                 $evaluationPeriod1 = str_replace('/', '_', $evaluationPeriod);
		                                 $evaluationPeriod_ = strtr( $evaluationPeriod1, pa_daksan() );
		                                 
		                                 $name_acadPeriod_for_this_room1 = str_replace('/', '_', $name_acadPeriod_for_this_room);
		                                 $name_acadPeriod_for_this_room_ = strtr( $name_acadPeriod_for_this_room1, pa_daksan() );
                                        
                                         $period_exam_name1 = str_replace('/', '_', $period_exam_name);
		                                 $period_exam_name_ = strtr( $period_exam_name1, pa_daksan() );
		                                 
		                                 
				
				               $base = '';
								
                           $this->success=true;
								//	 $this->allowLink=true;
									      
                                      
							if($reportcard_structure==1) //One evaluation by Period
							  {   
							     //bay option download selman
							     
							     
								      $pdf->Output($room_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.$reportcard_category.'.pdf', 'D');  
								      
							   }
							
							    	 
								
                                  /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/

								//============================================================+
								// END OF FILE
								//============================================================+		
		
								
					
								  //  Yii::app()->session['stud_to_enable_reportcar']=$STUDENT;
								    
								    
								
                              }//end(2) if(all_validated) 	
							
							
		           						 
							} 
						 else
						   {
						     		
							 $this->message=true;
							 
						  }
						  
				     } 
				   else
				     {  //$sum_weight = sumPeriodWeight($pastp,$);
				     	Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Sum period weight must equal 100.' ));
				     	
				     	}
						
			          
		     }
			
			 		  
			
		
		
		$this->render('periods_summary',array(
			'model'=>$model,
		));
		
	}



	
	
	
	
}




?>