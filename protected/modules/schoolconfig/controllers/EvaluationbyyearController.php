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




class EvaluationbyyearController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	public $last_evaluation;
	
	
	
	public $error=false;


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
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


		$model=new EvaluationByYear;

		$this->performAjaxValidation($model);

		if(isset($_POST['EvaluationByYear']))
		{
                       
                        $model->attributes=$_POST['EvaluationByYear'];
             
			$model->setAttribute('date_created',date('Y-m-d'));
			$model->setAttribute('date_updated',date('Y-m-d'));
		
            	 
		    	
		            //intervalle academic year en cours
		            $academic = new AcademicPeriods;
		            $result=$academic->find(array( 'alias'=>'a',
				                           'select'=>'a.date_start, a.date_end',
				                           'condition'=>'a.id=:id_acad ',
		                                    'params'=>array(':id_acad'=>$acad_sess, ),
		                               ));
                       $its_ok=false;
                
                if(isset($_POST['create']))
                 {       
		            if(($model->evaluation_date < $result->date_end )&&($model->evaluation_date > $result->date_start ))
		            {
		                $its_ok=true;
		                $this->error=false;

		            }
		            else
		            {
		            	
		                $this->error=true;
		            }
		            
					if($its_ok)
				      {         
				      	 //tcheke sidenye evalyasyon an defini deja
				      	   $last_eval_defined = EvaluationByYear::model()->isAlreadyDefined($acad_sess); 
				      	   
				      	 if($last_eval_defined==NULL)
					      	    { 
					      	    	 if($model->save())
							            $this->redirect (array('index'));
							            
							      }
				      	   else
						     { 	 Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Last evaluation is already defined.' ));
							      	     
				              }

									
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

	public function actionUpdate()
	{
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['EvaluationByYear']))
		{
                       
                    
			$model->attributes=$_POST['EvaluationByYear'];
			$model->setAttribute('date_updated',date('Y-m-d'));
		
			   //intervalle academic year en cours
		            $academic = new AcademicPeriods;
		            $result=$academic->find(array( 'alias'=>'a',
				                           'select'=>'a.date_start, a.date_end',
				                           'condition'=>'a.id=:id_acad ',
		                                    'params'=>array(':id_acad'=>$acad_sess, ),
		                               ));
                       $its_ok=false;
		           
		        if(isset($_POST['update']))
                 { if(($model->evaluation_date < $result->date_end )&&($model->evaluation_date > $result->date_start ))
		            {
		                $its_ok=true;
		                $this->error=false;

		            }
		            else
		            {
		            	
		                $this->error=true;
		            }
		            
					if($its_ok)
				      {         
				      	//tcheke sidenye evalyasyon an defini deja
				      	   $last_eval_defined = EvaluationByYear::model()->isAlreadyDefined($acad_sess); 
				      	   
				      	 if($last_eval_defined==NULL)
					      	    { 
					      	    	 if($model->save())
							            $this->redirect (array('index'));
							            
							      }
				      	   else
						     { 	 foreach($last_eval_defined as $last_eval_def)
						      	  {
							      	   	if(($last_eval_def['id']!=$model->id)&&($model->last_evaluation==1))
							      	      	    Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Last evaluation is already defined.' ));
							      	      	else
							      	      	  {
							      	      	  	  if($model->save())
												      $this->redirect (array('index'));
												
							      	      	  	}
							      	      	
							      	      
						      	  
						      	   }
				              }
						            
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

//	

	public function actionIndex()
	{
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
                $model=new EvaluationByYear('search('.$acad_sess.')');
                $model->unsetAttributes();
		if(isset($_GET['EvaluationByYear']))
			$model->attributes=$_GET['EvaluationByYear'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
		$this->exportCSV(array(Yii::t('app','List of evaluation by period: ')), null,false);
		
		$this->exportCSV($model->search( $acad_sess), array(
		'evaluation0.evaluation_name',
		'academicYear.name_period',
		'evaluation_date',)); 
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
				$this->_model=EvaluationByYear::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='evaluation-by-year-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	// Export to CSV 
	public function behaviors() {
	   return array(
	       'exportableGrid' => array(
	           'class' => 'application.components.ExportableGridBehavior',
	           'filename' => Yii::t('app','evaluation by period.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
}
