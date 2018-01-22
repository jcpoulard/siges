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

class RecordPresenceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $back_url;
      
        public $room_atten;
        public $acad;
        public $isCheck = 0;
        public $date_atten = null;
        public $month_atten = 0;
        
        
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new RecordPresence;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RecordPresence']))
		{
			$model->attributes=$_POST['RecordPresence'];
			
			$model->setAttribute('date_created',date('Y-m-d'));
			$model->setAttribute('create_by',Yii::app()->user->name);
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		

		if(isset($_POST['RecordPresence']))
		{
			$model->attributes=$_POST['RecordPresence'];
			
			if(isset($_POST['update']))
			  {	
			  	$model->setAttribute('date_updated',date('Y-m-d'));
				$model->setAttribute('update_by',Yii::app()->user->name);
			  	
			  	if($model->save())
					$this->redirect(array('view','id'=>$model->id));
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		
		try {
   			 $this->loadModel($id)->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			       
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}



	}

	/**
	 * Lists all models.
	 */
        
	public function actionAdmin()
	{
                $model = new RecordPresence();
       
       if(isset($_POST['RecordPresence']['room_attendance']))
        { 
        	if($_POST['RecordPresence']['room_attendance']!=null)
            {
                $this->room_atten = $_POST['RecordPresence']['room_attendance'];
                         
            }
            
            $this->month_atten = 0;
            
         }
       else
         {  if(isset($_GET['room'])) 
		      {
		         $this->room_atten = $_GET['room'];
		      }
              
               if(isset($_GET['month_'])) 
			    {
			        $this->month_atten = $_GET['month_'];
			    }
           
           
           }

                
		$dataProvider=new CActiveDataProvider('RecordPresence');
                
		$this->render('admin',array(
			'dataProvider'=>$dataProvider,
                        'model'=>$model,
                        
		));
	}
         
        
        
        // Make mass presence record for room in school 
        
        public function actionRecordPresence()
        {
             $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
			 

            $model = new RecordPresence;
            $this->performAjaxValidation($model);
            $this->month_atten = $this->getMonthAttendance(date('Y-m-d'));
            
                
           
           
     if(isset($_POST['RecordPresence']))
		{
            if(isset($_POST['RecordPresence']['room_attendance'])){
                //Pour choisir une salle
                if($_POST['RecordPresence']['room_attendance']!=null){
                $this->room_atten = $_POST['RecordPresence']['room_attendance'];
                $this->date_atten = $_POST['RecordPresence']['date_record'];
                $this->acad=Yii::app()->session['currentId_academic_year'];
                $sql_room_st = "SELECT p.id, p.last_name, p.first_name, p.active, p.is_student, r.students, r.room, r.academic_year  FROM persons p inner join room_has_person r on (r.students = p.id) where r.room =".$this->room_atten." AND r.academic_year = ".$acad_sess."";
                $stud_ = Persons::model()->findAllBySql($sql_room_st);
                }
                // Quand on presse le botton 
                if(isset($_POST['create'])){
                	if($this->date_atten == null){
                		 Yii::app()->user->setFlash(Yii::t('app','DateError'), Yii::t('app','Date must have a value !'));
                		}
                	else{	
                    $exam_period_ = $model->searchCurrentExamPeriod($this->date_atten);
            
                    if($exam_period_!=null)
                        $exam_period_id = $exam_period_->id;
                    else
                        $exam_period_id = null;
                    // If date is not set 
                   
                        // do a query who take all student from the specific choosen room
                        
                        // Komansman tranzaksyon an
                        
                        // Pou chak elev ki nan yon klas
                    $transaction = Yii::app()->db->beginTransaction();
                    $model->attributes=$_POST['RecordPresence'];
                        foreach($stud_ as $s){
                            
                           // 
                            $presence_type = $_POST['RecordPresence']["presence_type"]["$s->id"];
                            
                            $comments = $_POST['RecordPresence']["comments"]["$s->id"];
                          
                            $model->setAttribute('student', $s->id);
                            $model->setAttribute('room', $this->room_atten);
                            $model->setAttribute('academic_period', $acad_sess);
                            $model->setAttribute('date_record', $this->date_atten);
                            $model->setAttribute('presence_type', $presence_type);
                            $model->setAttribute('comments', $comments);
                            $model->setAttribute('exam_period', $exam_period_id);
                            
                            $model->setAttribute('date_created',date('Y-m-d'));
							$model->setAttribute('create_by',Yii::app()->user->name);
										   
                            if($model->save());
                             // Gade si tranzaksyon an byen pase
                        
                       
                            $model->unSetAttributes();
                            $model= new RecordPresence();
                        }
                       try {
                             $transaction->commit(); 
                             Yii::app()->user->setFlash(Yii::t('app','Success'), Yii::t('app','Attendance successfully record !'));
                             $this->redirect(array("/discipline/recordPresence/admin?room=$this->room_atten&month=$this->month_atten"));
                             
                       }
                            // Si yon bagay mal pase nan tranzaksyon an 
                            catch (CDbException $e) { // Exception
                            $transaction->rollBack();
                            Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Something wrong just happen !'));
                            } 
                   
                }
                    } 
            }
                }
               
            
           
            $this->render(
                    'recordPresence', array('model'=>$model)
                    );
        }

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
            if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
		$model=new RecordPresence('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RecordPresence']))
			$model->attributes=$_GET['RecordPresence'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=RecordPresence::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='record-presence-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
          public function getDateEmail(){
           $time = strtotime($this->date_sent);
                         $month=date("n",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         $hour = date("h",$time);
                         $minutes = date("m",$time);
            return $day.'-'.  Schedules::model()->getMonth($month).'-'.$year.' '.$hour.':'.$minutes;             
        }
        
        
           /*
         * Get month from a date 
         */
        public function getMonthAttendance($date){
            $time = strtotime($date);
                         $month=date("n",$time);
                         
            return $month;
        }
        /*
         * Get day from a date 
         */
         public function getDayAttendance($date){
            $time = strtotime($date);
                         $day=date("j",$time);
                         
            return $day;
        }
        
        /*
         * Get year form a date 
         */
        public function getYearAttendance($date){
            $time = strtotime($date);
                        $year=date("Y",$time);
                         
            return $year;
        }
        
    
   /*
    * Creer une fonction prennant en parametre student, jour, mois, annee (DATE) retournant le code de presence
    */
   
   public function getPresenceCode($student, $date){
      $result =  RecordPresence::model()->findByAttributes(array('student'=>$student,'date_record'=>$date));
    
      return $result->presence_type;
   }
        
}
