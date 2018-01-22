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

class RecordInfractionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $back_url;
        private $_model;
        public $person_id;
        
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
	public function actionView()
	{
            $model = new RecordInfraction;
            $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
            $pers=$pers->getData();
            foreach($pers as $p)
            $this->person_id =$p->person_id; 
		$this->render('view',array(
			'model'=>$model,//$this->loadModel(),
		));
                
                
	}
        
        public function actionViewParent()
	{
            $model = new RecordInfraction;
            
            
             if(isset($_POST['Persons']))
		           {  $pers=$_POST['Persons']['id'];
		              
		               unset(Yii::app()->session['child']);
		              //set current child variable session
					   Yii::app()->session['child']=$pers;
		            	$this->person_id=$pers;	
		            		        	           
		           }
		           else
                     $this->person_id=Yii::app()->session['child'];
            
            
		$this->render('viewParent',array(
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new RecordInfraction;
                $modelInfraction = new RecordPresence;
                $exam_period_ = $modelInfraction->searchCurrentExamPeriod(date('Y-m-d'));
                
                if($exam_period_!=null)
                   $exam_period_id = $exam_period_->id;
                else
                   $exam_period_id = null;
                
                $acad = Yii::app()->session['currentId_academic_year'];
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RecordInfraction']))
		{
			$model->attributes=$_POST['RecordInfraction'];
                        $model->setAttribute('academic_period', $acad);
                        $model->setAttribute('exam_period', $exam_period_id);
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
		$acad = Yii::app()->session['currentId_academic_year'];
                $model=$this->loadModel($id);
                $modelInfraction = new RecordPresence;
               // $exam_period_ = $modelInfraction->searchCurrentExamPeriod(date('Y-m-d'));
               // $exam_period_id = $exam_period_->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RecordInfraction']))
		{
			$model->attributes=$_POST['RecordInfraction'];
                        $model->setAttribute('academic_period', $acad);
                        
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
			        //header("HTTP/1.0 400 Relation Restriction");
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}



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
		$model=new RecordInfraction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RecordInfraction']))
			$model->attributes = $_GET['RecordInfraction'];
                 
		$this->render('index',array(
			'model'=>$model,
		));
	}
        
        

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=  RecordInfraction::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='record-infraction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
