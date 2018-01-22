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




class CalendarController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	


    public $back_url='';
 

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
		 if (@$_GET['asModal']==true)
        {
            $this->renderPartial('view',
                array('model'=>$this->loadModel($id)),false,true
            );
        }
        else{ $this->render('view',array(
					'model'=>$this->loadModel($id),
				));
				
         }
         
	}
	
	
	public function actionViewForIndex($id)
	{
		 if (@$_GET['asModal']==true)
        {
            $this->renderPartial('viewForIndex',
                array('model'=>$this->loadModel($id)),false,true
            );
        }
        else{ $this->render('viewForIndex',array(
					'model'=>$this->loadModel($id),
				));
				
         }
         
	}
	
	
	
	
	public function actionCreate()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		
		$model=new Calendar;
		//$modelAcad=new AcademicPeriods;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Calendar']))
		{
			$model->attributes=$_POST['Calendar'];
			
			
			if(isset($_POST['create']))
		     { 
		     	if(isset($_POST['color']))
		         {  $color=$_POST['color'];
		           $model->setAttribute('color',$color);
		           
		         }
              
               $model->setAttribute('start_time',NULL); 
               $model->setAttribute('end_time',NULL);
                
               $model->setAttribute('academic_year',$acad);  
              
              
               if($model->save())
				$this->redirect(array('view','id'=>$model->id));
				
		     }
		    		     
		}
		
		 
		     if(isset($_POST['cancel']))
                {
                   
                     $this->redirect(Yii::app()->request->urlReferrer);
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
		$acad=Yii::app()->session['currentId_academic_year']; 
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Calendar']))
		{
			$model->attributes=$_POST['Calendar'];
			
			
           	if(isset($_POST['update']))
		     {  
		     	if(isset($_POST['color']))
		         {  $color=$_POST['color'];
		           $model->setAttribute('color',$color);
		          }  
		          
		         $model->setAttribute('academic_year',$acad);  
		          
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
					
		     }
		     
		}
		
		   if(isset($_POST['cancel']))
                          {
                              
                              $this->redirect(Yii::app()->request->urlReferrer);
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			
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
	public function actionIndex()
	{
		
		
		$acad=Yii::app()->session['currentId_academic_year'];
                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                    }
                $model=new Calendar('search');
                $model->unsetAttributes();

		if(isset($_GET['Calendar']))
			$model->attributes=$_GET['Calendar'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of events: ')), null,false);
                            $this->exportCSV($model->search($acad), array(
				
				'academicYear.name_period',
				'weight')); 
		}
		

		$this->render('index',array(
			'model'=>$model,
		));

		
		
	}
	
	
  public function actionCalendarEvents()
    {       
        
       $acad=Yii::app()->session['currentId_academic_year']; //current academic year

  
        
        $items = array();
        $model=Calendar::model()->findAll();
                                    
          
                                                                    
        foreach ($model as $value) {
            $items[]=array(
                
                'id'=>$value->id,
                'title'=>$value->c_title,
                'start'=>$value->start_date,
                'end'=>date('Y-m-d', strtotime('+1 day', strtotime($value->end_date))),
                'color'=>'#'.$value->color,
                
            );
            
           
         }
        
      
        echo CJSON::encode($items);
        Yii::app()->end();
    }
         

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Calendar('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Calendar']))
			$model->attributes=$_GET['Calendar'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Calendar the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Calendar::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Calendar $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='calendar-form')
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
	           'filename' => Yii::t('app','rooms.csv'),
	           'csvDelimiter' => ',',
	           ));
	}

	
	
}
