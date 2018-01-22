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



class SubjectsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	public $is_subject_parent;
	
	

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
		$model=new Subjects;
               
               
                            
                $this->performAjaxValidation($model);

		if(isset($_POST['Subjects']))
		{
			
			     if(isset($_POST['Subjects']['is_subject_parent']))
			         { $this->is_subject_parent=$_POST['Subjects']['is_subject_parent']; 
			           
			           
			         }
			      
			
			$model->attributes=$_POST['Subjects'];
			
			if(isset($_POST['create']))
			 {
				if($this->is_subject_parent == 1)
				  {
				  	  $model->setAttribute('subject_parent',null);
				  	}
				  	
				$model->setAttribute('date_created',date('Y-m-d'));
				$model->setAttribute('date_updated',date('Y-m-d'));
			
	            
				if($model->save())
	                                //Recdirect to manage 
	                                $this->redirect (array('index'));
					
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
		
               
        $model=$this->loadModel();
                
        $this->is_subject_parent = $model->is_subject_parent;
                
		$this->performAjaxValidation($model);
           
            	            

		if(isset($_POST['Subjects']))
		{
			
			     if(isset($_POST['Subjects']['is_subject_parent']))
			         { $this->is_subject_parent=$_POST['Subjects']['is_subject_parent']; 
			           
			           
			         }
			      
			
			$model->attributes=$_POST['Subjects'];
			
			if(isset($_POST['update']))
			 {
				if($this->is_subject_parent == 1)
				  {
				  	  $model->setAttribute('subject_parent',null);
				  	}
				
				$model->setAttribute('date_updated',date('Y-m-d'));
	                        
				if($model->save())
	                            //Redirect to amdmin 
	                            $this->redirect(array('index'));
					
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
   			 
   			 
   			$model=$this->loadModel();
	        
	        $subject_id= $model->id;
	        
	         $this->loadModel()->delete();

	           			 
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			        
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}



	}



        // Update the actionAdmin() en actionIndex()
	public function actionIndex()
	{
		
                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                    }
                $model=new Subjects('search');
                $model->unsetAttributes();
                
		if(isset($_GET['Subjects']))
			$model->attributes=$_GET['Subjects'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
		$this->exportCSV(array(Yii::t('app','List of subjects: ')), null,false);
		
		$this->exportCSV($model->search(), array(
		'subject_name',
		'subjectParent.subject_name',
		'isParent',)); 
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
				$this->_model=Subjects::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='subjects-form')
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
	           'filename' => Yii::t('app','subjects.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
        
        
        public  function actionMassAddingSubjects(){
            $model = new Subjects;
            $number_line = infoGeneralConfig('nb_grid_line');
            $subject_label = array(); 
			$short_subject_label = array(); 
            $is_subject_parent = array(); 
            $parent_subject = array();
            $error_report = False;
            $subject_name = array();
			$short_subject_name = array();
            $j = 0;
            if(isset($_POST['btnSave'])){
                for($i=0; $i<$number_line;$i++){
                    if((isset($_POST['subject_label'.$i]) && $_POST['subject_label'.$i]!="")&&((isset($_POST['short_subject_label'.$i]) && $_POST['short_subject_label'.$i]!=""))){
                        //Verifie si is_subject_parent est coche
                        if(isset($_POST['is_subject_parent'])){
                            $is_subject_parent[$i] = 1;
                        }else{
                            $is_subject_parent[$i] = 0;
                        }
                        $subject_label[$i] = $_POST['subject_label'.$i];
						$short_subject_label[$i] = $_POST['short_subject_label'.$i];
                        if(isset($_POST['parent_subject'.$i]) && $_POST['parent_subject'.$i] !=""){
                             $parent_subject[$i] = $_POST['parent_subject'.$i];
                        }else{
                             $parent_subject[$i] = null;
                        }
                       
                        $model->setAttribute('subject_name', $subject_label[$i]);
						$model->setAttribute('short_subject_name', $short_subject_label[$i]);
                        $model->setAttribute('is_subject_parent', $is_subject_parent[$i]);
                        $model->setAttribute('subject_parent', $parent_subject[$i]);
                        $model->setAttribute('date_created', date('Y-m-d H:m:s'));
                        $model->setAttribute('create_by', Yii::app()->user->name);
                        if($model->save()){
                            
                        }else{
                            $error_report = True;
                            $subject_name[$j] = $subject_label[$i];
                            $j++;
                        }
                    }
                    $model->unsetAttributes(); 
                    $model = new Subjects; 
                }
                
                if($error_report){
                    $liste_subject = "";
                  for($i=0; $i<count($subject_name); $i++){
                      $liste_subject .= $subject_name[$i].'<br/>';
                  }
                  $message=Yii::t('app',"At least {name} error(s) occured when you saved subjects !<br/> The following subjects were about to be duplicated:<br/><b> {subject}</b>",array('{name}'=>$j,'{subject}'=>$liste_subject));
                 Yii::app()->user->setFlash(Yii::t('app','Error'), $message);
                }
                $this->redirect(array('index'));
            }
            
            
            $this->render('gridcreate',array('model'=>$model));
        }
	
	
	
}
