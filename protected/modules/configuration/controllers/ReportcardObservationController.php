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




class ReportcardObservationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	public $section_id;
	public $all_sections=1;

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
		$model=new ReportcardObservation;
		
              

 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$previous_acad_sess=-1;

$siges_structure = infoGeneralConfig('siges_structure_session');

if($siges_structure==1)//previous
  {  $previous_acad_sess= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
     if($previous_acad_sess=='')
        $previous_acad_sess=0;
        
  }

 
  
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
       if(isset($_POST['ReportcardObservation']))
		{
			
			$model->attributes=$_POST['ReportcardObservation']; 
			
			if($this->all_sections==0)
             {
	            $model->section = $_POST['ReportcardObservation']['sections'];
				 $this->section_id=$model->section;
               }
               
			if(isset($_POST['ReportcardObservation']['all_sections']))
			  {
                        $this->all_sections = $_POST['ReportcardObservation']['all_sections'];
                    }

			
			
			
			
		if(isset($_POST['btnSave']))
		{
			//$model->attributes=$_POST['ReportcardObservation'];
                        $start_range = array();
                        $end_range = array();
                        $comment = array();
                  
                  if($this->all_sections==1)
                    {    
                       $modelSection=Sections::model()->findAll();
            
					    if(isset($modelSection))
						 {  foreach($modelSection as $section)
						      {
						          //$code[$section->id]= $section->section_name;
					               $this->section_id = $section->id;
					                                   
			                        for($i=0;$i<6;$i++)
			                          {
			                            if(isset($_POST['start_range'.$i]) && isset($_POST['end_range'.$i]) && isset($_POST['comment'.$i]))
			                              {
			                               
			                                $start_range[$i] = $_POST['start_range'.$i];
			                                
			                                $model->setAttribute('start_range', $start_range[$i]);
			                                
			                                $end_range[$i] = $_POST['end_range'.$i]; 
			                                
			                                $model->setAttribute('end_range', $end_range[$i]);
			                               
			                                $comment[$i] = $_POST['comment'.$i];
			                               
			                               $model->setAttribute('section', $this->section_id);
			                                $model->setAttribute('comment', $comment[$i]);
			                                $model->setAttribute('academic_year', $acad_sess);
			                                $model->setAttribute('create_by', Yii::app()->user->name);
			                                $model->setAttribute('create_date', date('Y-m-d H:m:s'));
			                                $model->save();
			                               }
			                            $model->unsetAttributes();
			                            $model=new ReportcardObservation;
			                           }
                        
                                }
						    }  
						   
                    }
                 elseif($this->all_sections==0)
                    {       
                    	$section_id =  $model->section;
                    	for($i=0;$i<6;$i++)
			                          {
			                            if(isset($_POST['start_range'.$i]) && isset($_POST['end_range'.$i]) && isset($_POST['comment'.$i]))
			                              {
			                               
			                                $start_range[$i] = $_POST['start_range'.$i];
			                                
			                                $model->setAttribute('start_range', $start_range[$i]);
			                                
			                                $end_range[$i] = $_POST['end_range'.$i]; 
			                                
			                                $model->setAttribute('end_range', $end_range[$i]);
			                               
			                                $comment[$i] = $_POST['comment'.$i];
			                               
			                                $model->setAttribute('section', $section_id);
			                                $model->setAttribute('comment', $comment[$i]);
			                                $model->setAttribute('academic_year', $acad_sess);
			                                $model->setAttribute('create_by', Yii::app()->user->name);
			                                $model->setAttribute('create_date', date('Y-m-d H:m:s'));
			                                $model->save();
			                               }
			                            $model->unsetAttributes();
			                            $model=new ReportcardObservation;
			                           
			                           }
                      
                      } 
                      
                      
                 $prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_reportcardObservations = ReportcardObservation::model()->search($acad_sess);
 											$all_reportcardObservations = $all_reportcardObservations->getData();
 											foreach($all_reportcardObservations as $ro)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   }
								     	 if($prosper_marc_hilaire_poulard>=1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'reportcard_observation'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$previous_acad_sess) );
								     	   	} 
     
                        
						 
                $this->redirect(array('index'));
		}
		
		
		
		}
		

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionUpdateObservation()
		{
			$es = new EditableSaver('ReportcardObservation');
                        $es->onBeforeUpdate = function($event) {
                        $event->sender->setAttribute('update_date', date('Y-m-d H:i:s'));
                        $event->sender->setAttribute('update_by', Yii::app()->user->name);
                        };
                        
			$es->update();
		}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ReportcardObservation']))
		{
			$model->attributes=$_POST['ReportcardObservation'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	*/

public function actionUpdate()
	{
        
        
        $model=new ReportcardObservation;
		
                $acad=Yii::app()->session['currentId_academic_year'];
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
       if(isset($_POST['ReportcardObservation']))
		{
			$model->attributes=$_POST['ReportcardObservation']; 
			
			 if(isset($_POST['ReportcardObservation']['all_sections']))
			  {
                        $this->all_sections = $_POST['ReportcardObservation']['all_sections'];
                    }
                    
            if($this->all_sections==0)
             {
	            if(isset($_POST['ReportcardObservation']['section']))
	               $this->section_id = $_POST['ReportcardObservation']['section'];
	               
	               $model->setAttribute('section', $this->section_id);
				 
               }
             elseif($this->all_sections==1)
                {  
                    $model = new ReportcardObservation;
                }
             

            if(isset($_POST['ReportcardObservation']['all_sections']))
			  {
                        $this->all_sections = $_POST['ReportcardObservation']['all_sections'];
                    }

			
           
    		
			
		if(isset($_POST['btnSave']))
		{
			//$model->attributes=$_POST['ReportcardObservation'];
                        $start_range = array();
                        $end_range = array();
                        $comment = array();
                  
                  if($this->all_sections==1)
                    {    
                       $modelSection=Sections::model()->findAll();
            
					    if(isset($modelSection))
						 {  foreach($modelSection as $section)
						      {
						          //$code[$section->id]= $section->section_name;
					               $this->section_id = $section->id;
					                                   
			                        for($i=0;$i<6;$i++)
			                          {
			                            if(isset($_POST['start_range'.$i]) && isset($_POST['end_range'.$i]) && isset($_POST['comment'.$i]))
			                              {
			                               
			                                $start_range[$i] = $_POST['start_range'.$i];
			                                
			                                $model->setAttribute('start_range', $start_range[$i]);
			                                
			                                $end_range[$i] = $_POST['end_range'.$i]; 
			                                
			                                $model->setAttribute('end_range', $end_range[$i]);
			                               
			                                $comment[$i] = $_POST['comment'.$i];
			                               
			                               $model->setAttribute('section', $this->section_id);
			                                $model->setAttribute('comment', $comment[$i]);
			                                $model->setAttribute('academic_year', $acad);
			                                $model->setAttribute('create_by', Yii::app()->user->name);
			                                $model->setAttribute('create_date', date('Y-m-d H:m:s'));
			                                $model->save();
			                               }
			                            $model->unsetAttributes();
			                            $model=new ReportcardObservation;
			                           }
                        
                                }
						    }  
						    
                    }
                 elseif($this->all_sections==0)
                    {       
                    	for($i=0;$i<6;$i++)
			                          {
			                            if(isset($_POST['start_range'.$i]) && isset($_POST['end_range'.$i]) && isset($_POST['comment'.$i]))
			                              {
			                               
			                                $start_range[$i] = $_POST['start_range'.$i];
			                                
			                                $model->setAttribute('start_range', $start_range[$i]);
			                                
			                                $end_range[$i] = $_POST['end_range'.$i]; 
			                                
			                                $model->setAttribute('end_range', $end_range[$i]);
			                               
			                                $comment[$i] = $_POST['comment'.$i];
			                               
			                                $model->setAttribute('section', $this->section_id);
			                                $model->setAttribute('comment', $comment[$i]);
			                                $model->setAttribute('academic_year', $acad);
			                                $model->setAttribute('create_by', Yii::app()->user->name);
			                                $model->setAttribute('create_date', date('Y-m-d H:m:s'));
			                                $model->save();
			                               }
			                            $model->unsetAttributes();
			                            $model=new ReportcardObservation;
			                           }
                      
                      }   
						 
                $this->redirect(array('index'));
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
        /*
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ReportcardObservation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
         * 
         */

	/**
	 * Manages all models.
	 */
        
	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year'];
		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		
		$model=new ReportcardObservation('search('.$acad.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ReportcardObservation']))
			$model->attributes=$_GET['ReportcardObservation'];
			
	                    // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Reportcard observation: ')), null,false);
                            $this->exportCSV($model->search($acad), array(
                               
				'section0.section_name',
				'start_range',
				'end_range',
				'comment',
				'academicYear.name_period',
		        'create_by',
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
           'filename' => Yii::t('app','reportcardObservation.csv'),
           'csvDelimiter' => ',',
           ));
        }
        


	//************************  loadSection ******************************/
public function loadSection()
	{    $modelSection= new Sections();
           $code= array();
            $code[]= Yii::t('app','-- Select --');
		   $criteria = new CDbCriteria(array('order'=>'section_name'));
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
		
		$section=Sections::model()->findByPk($id);
        
			
		       if(isset($section))
				return $section->section_name;
		
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ReportcardObservation the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ReportcardObservation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ReportcardObservation $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reportcard-observation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
