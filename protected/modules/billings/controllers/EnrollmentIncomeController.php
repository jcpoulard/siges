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

?>
<?php

class EnrollmentIncomeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $recettesItems = 3;
	 public $part; 
	 public $back_url;
	 
	 public $postulant;
	 public $idLevel;

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
	{   $this->recettesItems=3;
		
			$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 
		
		$model=new EnrollmentIncome;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EnrollmentIncome']))
		{
			$model->attributes=$_POST['EnrollmentIncome'];
			
			 $this->postulant=$model->postulant; 
			 
			 if(isset($_POST['create']))
				  { //on vient de presser le bouton
				     
						 $model->setAttribute('date_created',date('Y-m-d'));
					    
					  $model->setAttribute('academic_year',$acad_sess);
					  
					  $model->setAttribute('create_by',Yii::app()->user->name);
						
						if($model->save())
							{  $part='enrlis';
								if(isset($_GET['part']))
								 $part=$_GET['part'];
								
								Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.') );
					
								  if(isset($_GET['part'])&&($_GET['part']=='rec'))
								    $this->redirect(array('/academic/postulant/viewAdmissionDetail/id/'.$model->postulant.'/part/rec/pg/'));
								  else
								    $this->redirect(array('/academic/postulant/viewAdmissionDetail/id/'.$model->postulant.'/part/'.$part.'/pg/'));
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
	{   $this->recettesItems=3;
		
		$model=$this->loadModel($id);
		
		
		$this->postulant = $model->postulant;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EnrollmentIncome']))
		{
			$model->attributes=$_POST['EnrollmentIncome'];
			
			
			 if(isset($_POST['update']))
				  { //on vient de presser le bouton
				     
						 $model->setAttribute('date_updated',date('Y-m-d'));
					    
					  $model->setAttribute('update_by',Yii::app()->user->name);
						
						if($model->save())
							{
								$part='enrlis';
								if(isset($_GET['part']))
								 $part=$_GET['part'];
								
								Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.') );
					
								  if(isset($_GET['part'])&&($_GET['part']=='rec'))
								    $this->redirect(array('/academic/postulant/viewAdmissionDetail/id/'.$model->postulant.'/part/rec/pg/'));
								  else
								    $this->redirect(array('/academic/postulant/viewAdmissionDetail/id/'.$model->postulant.'/part/'.$part.'/pg/'));
								
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new EnrollmentIncome;
		
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 		 
					
		$this->part='bill';
			
					
		if(isset($_POST['EnrollmentIncome']['recettesItems']))
		    $this->recettesItems = $_POST['EnrollmentIncome']['recettesItems'];
		//else
	    // {
	     //	 if(isset($_GET['ri']) )
	     //	   $this->recettesItems = $_GET['ri']; 
	      // }
		
		
		   
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
			elseif($this->recettesItems==4)
		    {
		        $this->redirect(array('/billings/reservation/index?part=rec&from=b'));
		
		      }		 	
					
					
					
			       $model=new EnrollmentIncome('search('.$acad_sess.')');
					
					 if(isset($_GET['EnrollmentIncome']))
						$model->attributes=$_GET['EnrollmentIncome']; 
						  // Here to export to CSV 
					if($this->isExportRequest()){
						$this->exportCSV(array(Yii::t('app','Enrollment payment list: ')), null,false);
						$this->exportCSV($model->search($acad_sess) , array(
								'FullName',
								'applyLevel.level_name',
								'Amount',
								'PaymentDate',
								
								'')); 
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
		$model=new EnrollmentIncome('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EnrollmentIncome']))
			$model->attributes=$_GET['EnrollmentIncome'];

		$this->render('admin',array(
			'model'=>$model,
		));
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


	//************************  loadLevel ******************************/
	public function loadAllLevel()
	{    
	    $modelLevel= new Levels();
		
		 
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

//************************  loadPostulantByCriteria ******************************/
	public function loadPostulantByCriteria($criteria)
	{    $code= array();
		   
		    $postulant=Postulant::model()->findAll($criteria);
            
			
		    if(isset($postulant))
			 {  
			    foreach($postulant as $post){
			        $code[$post->id]= $post->first_name." ".$post->last_name."(".$post->id.")";
		           
		           }
			 }
		   
		return $code;
         
	}
	
	



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EnrollmentIncome the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EnrollmentIncome::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EnrollmentIncome $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='enrollment-income-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

		
// Behavior the create Export to CSV 
public function behaviors() 
   {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','postulant.csv'),
	            'csvDelimiter' => ',',
	            ));
	}

	
	
	
}
