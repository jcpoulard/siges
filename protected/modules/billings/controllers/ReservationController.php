<?php

class ReservationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public $recettesItems = 4;
	public $back_url;
	 public $part; 
	public $student_postulant;
	
	public $message_paymentMethod=false;
	public $message_datepay=false;

	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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
			
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);


        $model=new Reservation;
		$model->postulant_or_student=0;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reservation']))
		{
			$model->postulant_or_student=$_POST['Reservation']['postulant_or_student'];
			
			$model->attributes=$_POST['Reservation'];
			
			
			 $this->student_postulant = $model->postulant_student;
			
		  if(isset($_POST['create']))
            {	
			
			    $model->setAttribute('is_student', $model->postulant_or_student);
			    $model->setAttribute('academic_year', $acad_sess);
			    
			     $model->setAttribute('create_by', Yii::app()->user->name );
				 $model->setAttribute('date_created', date('Y-m-d'));
				 
														                        
			if($model->save())
				{     $part='reserv';
								if(isset($_GET['part']))
								 $part=$_GET['part'];
								
								Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.') );
					
								  if(isset($_GET['part'])&&($_GET['part']=='rec'))
								    $this->redirect(array('/billings/reservation/view/id/'.$model->id.'/part/'.$part.'/pg/'));
								  else
								    $this->redirect(array('/billings/reservation/view/id/'.$model->id.'/part/'.$part));
							}
				
            }
            
             if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }	
            
            
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reservation']))
		{
			$model->attributes=$_POST['Reservation'];
			
			if(isset($_POST['update']))
              {
				
				$model->setAttribute('update_by', Yii::app()->user->name );
				 $model->setAttribute('date_updated', date('Y-m-d'));

				if($model->save())
					{     $part='reserv';
								if(isset($_GET['part']))
								 $part=$_GET['part'];
								
								Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.') );
					
								  if(isset($_GET['part'])&&($_GET['part']=='rec'))
								    $this->redirect(array('/billings/reservation/view/id/'.$model->id.'/part/'.$part.'/pg/'));
								  else
								    $this->redirect(array('/billings/reservation/view/id/'.$model->id.'/part/'.$part));
							}
					
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
			$acad_sess = acad_sess();
      $acad=Yii::app()->session['currentId_academic_year']; 
      
      $this->part='reserv';
      
     			
		if(isset($_POST['Reservation']['recettesItems']))
		    $this->recettesItems = $_POST['Reservation']['recettesItems'];
		    

		if(isset($_GET['pageSize'])) 
		   {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                   unset($_GET['pageSize']);
             }
        
        
      if($this->recettesItems==0)
      {         
               $condition ='fl.status=1 AND ';
               $this->redirect(array('/billings/billings/index?part=rec&from=stud'));		
         }
       elseif($this->recettesItems==1)
		    {
		        $condition ='fl.status=0 AND ';
		        $this->redirect(array('/billings/billings/index?part=rec&ri=1&from=stud'));		
		      }
		   elseif($this->recettesItems==2)
		    {
		        $this->redirect(array('/billings/otherIncomes/index?ri=2&from=b'));
		
		      }	
		     elseif($this->recettesItems==3)
		      {
		        $this->redirect(array('/billings/enrollmentIncome/index?part=rec&from=b'));
		
		       }	 
		
		      
		$model=new Reservation('search('.$acad_sess.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reservation']))
			$model->attributes=$_GET['Reservation'];

         // Here to export to CSV 
				if($this->isExportRequest()){
					$this->exportCSV(array(Yii::t('app','Reservation: ')), null,false);
		                            $this->exportCSV($model->search($acad_sess), array(
		                                'id',
						'PersonFullName',
						'IsStudent',
						'Amount',
						'paymentMethod.method_name',
						'PaymentDate',
						'comments',
						'academicperiods0.name_period',
						
						)); 
				}
 



		 $form='index';
        
        if(isset($_GET['part'])&&($_GET['part']=='rec'))
            $form='index_out';

		$this->render($form,array(
			'model'=>$model,
		));

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Reservation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reservation']))
			$model->attributes=$_GET['Reservation'];

		$this->render('admin',array(
			'model'=>$model,
		));
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
	

//************************  loadPostulantByCriteria ******************************/
	public function loadPostulantByCriteria($criteria)
	{    $code= array();
		   
		    $persons=Postulant::model()->findAll($criteria);
            
			
		    if(isset($persons))
			 {  
			    foreach($persons as $postu){
			        $code[$postu->id]= $postu->first_name." ".$postu->last_name;
		           
		           }
			 }
		   
		return $code;
         
	}

//************************  loadRecettesItems ******************************/
	public function loadRecettesItems()
	{     $code= array();
		   
		   $code[0]= Yii::t('app','Tuition fees');
		   $code[1]= Yii::t('app','Other fees');
		   $code[2]= Yii::t('app','Manage other incomes');
		   $code[3]= Yii::t('app','Enrollment fee');
		   $code[4]= Yii::t('app','Reservation');
		           
		    		   
		return $code;
         
	}




        // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','reservation.csv'),
           'csvDelimiter' => ',',
           ));
        }



/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Reservation the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Reservation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Reservation $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reservation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
