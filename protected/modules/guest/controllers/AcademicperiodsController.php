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



class AcademicperiodsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	
	public $message=false;

       
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

	public function actionCreate()
	{
		$model=new AcademicPeriods;

		$this->performAjaxValidation($model);

		if(isset($_POST['AcademicPeriods']))
		{
			$model->attributes=$_POST['AcademicPeriods'];
		     $model->setAttribute('date_created',date('Y-m-d'));
			 $model->setAttribute('date_updated',date('Y-m-d'));
			 $model->year = $_POST['AcademicPeriods']['year'];
			 
			 //get the more recent academic year
			   //get  date_end of the last academic year
                            $lastAcadDate=$model->lastAcademicYear();
							 $result=$lastAcadDate->getData();
							 
							  $greater_date=null;
							   $greater_date_id=0;
							 foreach($result as $r)
							   {  if($greater_date<$r->date_end)
								   { $greater_date=$r->date_end;
									$greater_date_id=$r->id;
									}
							   }
					
					 
			if($model->save())
				{ //check if the new academic_year is next to the past one
				   if($model->is_year==1) //to b sur that is a new academic year
				    {  if(substr($greater_date,0,4)==substr($model->date_start,0,4))  //new year must follow old one
				          { //applying end_year_decision by moving students to level up ...
				            //get the more recent academic year
					        
					        $command= Yii::app()->db->createCommand(
										"SELECT student, is_move_to_next_year, current_level, next_level FROM decision_finale WHERE academic_year=:acad");
											$command->bindValue(':acad', $greater_date_id);
											$sql_result = $command->queryAll();
								foreach($sql_result as $line)
								  { 
								     if($line['is_move_to_next_year']==1)
									  {  //add new record in LevelHasPerson
									     $command_level_has_person= Yii::app()->db->createCommand(
										"INSERT INTO level_has_person(level,students,academic_year) VALUES (:level,:stud,:acad)");
											$command_level_has_person->bindValue(':level', $line['next_level']);
											$command_level_has_person->bindValue(':stud', $line['student']);
											$command_level_has_person->bindValue(':acad', $model->id);
											$sql_result = $command_level_has_person->execute();
																				
								      }
									 elseif($line['is_move_to_next_year']==0)
								        { //add new record in LevelHasPerson
									      $command_level_has_person1= Yii::app()->db->createCommand(
										 "INSERT INTO level_has_person(level,students,academic_year) VALUES (:level,:stud,:acad)");
											$command_level_has_person1->bindValue(':level', $line['current_level']);
											$command_level_has_person1->bindValue(':stud', $line['student']);
											$command_level_has_person1->bindValue(':acad', $model->id);
											$sql_result = $command_level_has_person1->execute();
													
										}
										
								    }
									
					       }
				     }
				  if((isset($_GET['from']))&&($_GET['from']=='gol'))
                    { 
					   $this->message=false;
					   //set current academic variable session
					   Yii::app()->session['currentId_academic_year']=$model->id;
					   Yii::app()->session['currentName_academic_year']=$model->name_period;
					   
					  
					     $this->redirect (array('index'));
					 }
                  else					
				    $this->redirect (array('index'));
				
				  
				
				}
			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['AcademicPeriods']))
		{
			$model->attributes=$_POST['AcademicPeriods'];
			$model->setAttribute('date_updated',date('Y-m-d'));
			$model->year = $_POST['AcademicPeriods']['year'];
                        $model->update_by = Yii::app()->user->name;
		
			if($model->save())
				$this->redirect (array('index'));
				
		}

		$this->render('update',array(
			'model'=>$model,
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
	
*/

	public function actionIndex()
	{
            if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
            $model=new AcademicPeriods('search');
            $model->unsetAttributes();
		if(isset($_GET['AcademicPeriods']))
			$model->attributes=$_GET['AcademicPeriods'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of academic periods: ')), null,false);
			
			$this->exportCSV($model->search(), array(
					'name_period',
					'date_start',
					'date_end',
					'is_year',
					'year0.name_period')); 
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=AcademicPeriods::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='academic-periods-form')
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
	            'filename' => Yii::t('app','academic period.csv'),
	            'csvDelimiter' => ',',
	            ));
	}
}
