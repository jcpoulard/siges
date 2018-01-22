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
        
     public $deduct_note;
     public $month_ =0;
     public $exam_period=0;
        
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
		  if(isset($_POST['RecordInfraction']['exam_period'])){
                $this->exam_period = $_POST['RecordInfraction']['exam_period'];
            }else{
                
                      $exam_p = RecordInfraction::model()->searchCurrentExamPeriod(date('Y-m-d'));
                       if(($exam_p!=NULL)&&($exam_p!=''))
                            $this->exam_period = $exam_p->id;
                
            }
            $model_d = new RecordInfraction;
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                        'model_d'=>$model_d,
                       
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
			   
     $deduct_note =0;
		
		$model=new RecordInfraction;
                $modelInfraction = new RecordPresence;
                $exam_period_ = $modelInfraction->searchCurrentExamPeriod(date('Y-m-d'));
                
                if($exam_period_!=null)
                   $exam_period_id = $exam_period_->id;
                else
                   $exam_period_id = null;
                
               
		
		 
		  

	  if(isset($_POST['RecordInfraction']))
		{
			
			$model->attributes=$_POST['RecordInfraction'];
			
			if(isset($_POST['RecordInfraction']['deduct_note']))
			   { 
			       $this->deduct_note=$_POST['RecordInfraction']['deduct_note']; 
			       
			       if($this->deduct_note == 1)
			         {
			         	$modelType=InfractionType::model()->findByPk($model->infraction_type);
		                 
		                 if($modelType!=null)
		                   {
		                   	   $deduct_note = $modelType->deductible_value;   
		                   	 }

			          }
			           
			    }

			
			
						
			if(isset($_POST['create']))
			  {
                        $model->setAttribute('value_deduction', $deduct_note);
                        $model->setAttribute('academic_period', $acad_sess);
                        $model->setAttribute('exam_period', $exam_period_id);
                        
                        $model->setAttribute('date_created',date('Y-m-d'));
						$model->setAttribute('create_by',Yii::app()->user->name);
		    	  
		    	  if($model->save())
				    $this->redirect(array('view','id'=>$model->id));
				
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
		 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

        $deduct_note = 0;
		
                $model=$this->loadModel($id);
                $modelInfraction = new RecordPresence;
               

		if(($model->value_deduction ==0)||($model->value_deduction ==''))
		   $this->deduct_note = 0;
		else
		   $this->deduct_note = 1;
		
	 if(isset($_POST['RecordInfraction']))
		{

			$model->attributes=$_POST['RecordInfraction'];
			
			if(isset($_POST['RecordInfraction']['deduct_note']))
			   { 
			       $this->deduct_note=$_POST['RecordInfraction']['deduct_note']; 
			       
			       if($this->deduct_note == 1)
			         {
			         	$modelType=InfractionType::model()->findByPk($model->infraction_type);
		                 
		                 if($modelType!=null)
		                   {
		                   	   $deduct_note = $modelType->deductible_value;   
		                   	 }

			          }
			           
			    }

			

			
           
           if(isset($_POST['update']))
		    {
	            $date_rec = $model->incident_date;
               $exam_period_ = $model->searchCurrentExamPeriod($date_rec);
               
               if($exam_period_!=null)
                  $exam_period_id = $exam_period_->id;
               else
                  $exam_period_id = null;
                
                 $model->setAttribute('value_deduction', $deduct_note);
                 $model->setAttribute('academic_period', $acad_sess);
                    $model->setAttribute('exam_period', $exam_period_id);
                    
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
          $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

         
         
            if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
		
		
		 if(!isset($_GET['month_']))
			       {
			       	   $sql__ = 'SELECT DISTINCT incident_date FROM record_infraction ORDER BY id DESC';
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						     { $current_month = getMonth($r['incident_date']);
						          break;
						     }
						  }
						else
						  $current_month = getMonth(date('Y-m-d'));
			       	  
			        }
			     else 
			       {  
                                 $current_month = $_GET['month_'];
			       	 
			        }
          
          $model=new RecordInfraction('search_('.$current_month.', '.$acad_sess.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RecordInfraction']))
			$model->attributes = $_GET['RecordInfraction'];
			
          
            // Here to export to CSV 
				if($this->isExportRequest()){
					$this->exportCSV(array(Yii::t('app','Infraction records: ')), null,false);
		                            $this->exportCSV($model->search_($current_month, $acad_sess), array(
		                                'id',
						
						'student0.fullName',
						'infractionType.name',
						'record_by',
                        'value_deduction',
                        'incidentDate',
                )); 
				}
		
		
		
		
		
                 
		$this->render('index',array(
			'model'=>$model,
		));
	}
        
        // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','recordinfraction.csv'),
           'csvDelimiter' => ',',
           ));
        }       


      
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=RecordInfraction::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='record-infraction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
