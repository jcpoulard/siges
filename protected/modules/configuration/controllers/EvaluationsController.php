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



class EvaluationsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';

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
		 $acad=Yii::app()->session['currentId_academic_year']; 
		 $acad_sess = acad_sess();
		 
		 $model=new Evaluations;
		
                 $this->performAjaxValidation($model);

		if(isset($_POST['Evaluations']))
		{
			$model->attributes=$_POST['Evaluations'];
			
			 if(isset($_POST['create']))
              {
				 
				 
				 //return -1,0,1 ou total-weight 
                 $check = evaluationWeightCheck(0);
                  
                 $pass=true;
                  
        if($check!=-1)
         {            
			if( ($check==0)||($check==1) )
			  {
			  	if($check==0)
			  	  { 
			  	  	 $model->setAttribute('weight','');
			  	      Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Weight will set to NULL as the other(s).' ));  
			  	   }
			  	else
			  	  {
			  	  	 $model->setAttribute('weight',100);
			  	  	 Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Weight will set to 100 as the other(s).' ));
			  	   }
			  	  
			   }
			 else
			   {	
			   	   	
			        if($check >=100)
			          { Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Total sum of evaluation weight already achieved 100.' ));
			              $pass=false;
			           }
			        else
			           {  $new_weight = $check + $model->weight;
			           	    
			           	     if($new_weight>100)
			                   { Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Total sum of evaluation weight can\'t be over 100.' ));
			                      $pass=false;
			                   }
			                      
			            }
	            
			   }
           
           }
				 
				 
				if($pass==true) 
				  {  $model->setAttribute('academic_year',$acad);   //sou tout ane akademik lan
					 $model->setAttribute('date_created',date('Y-m-d'));
					  $model->setAttribute('date_updated',date('Y-m-d'));
				
		
					if($model->save())
					  {
					            $prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_evaluations = Evaluations::model()->searchAllEvaluations($acad);
 											
 											foreach($all_evaluations as $e)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   }
								     	 if($prosper_marc_hilaire_poulard==1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'evaluation'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	   	} 
								     	   	
					     $this->redirect (array('index'));
					   
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
		$model=$this->loadModel();
		
		$old_weight = $model->weight;

		$this->performAjaxValidation($model);

		if(isset($_POST['Evaluations']))
		{
			$model->attributes=$_POST['Evaluations'];
			
			 if(isset($_POST['update']))
              {
								 
				 //return -1,0,1 ou total-weight
                 $check = evaluationWeightCheck($old_weight);
                 
                 $pass=true;
                  
                if($check!=-1)
                 {  
					if( ($check==0)||($check==1) )
					  {
						 if($old_weight!=0)
						  {
						   	if($check==0)
						  	  { 
						  	  	 $model->setAttribute('weight','');
						  	      Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Weight will set to NULL as the others.' ));  
						  	   }
						  	else
						  	  {
						  	  	 $model->setAttribute('weight',100);
						  	  	 Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Weight will set to 100 as the others.' ));
						  	   }
						  }
						  
					   }
					 else
					   {	
					   	   	
					        if($check >=100)
					          { Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Total evaluation weight already achived 100.' ));
					              $pass=false;
					           }
					        else
					           {  $new_weight = $check + $model->weight;
					           	    
					           	     if($new_weight>100)
					                   { Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Total evaluation weight can\'t be over 100.' ));
					                      $pass=false;
					                   }
					                      
					            }
			            
					   }
  
                     }
				
				  if($pass==true) 
				    {  $model->setAttribute('date_updated',date('Y-m-d'));
				
						if($model->save())
							$this->redirect (array('index'));
							
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

	

public function actionIndex()
	{
		
                if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                unset($_GET['pageSize']);
                }
            $model=new Evaluations('search');
            $model->unsetAttributes();
                
		if(isset($_GET['Evaluations']))
			$model->attributes=$_GET['Evaluations'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of evaluation: ')), null,false);
			
			$this->exportCSV($model->search(), array(
				'evaluation_name',)); 
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
				$this->_model=Evaluations::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='evaluations-form')
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
	           'filename' => Yii::t('app','evaluations.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
}
