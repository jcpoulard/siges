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




class BaremeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	
	public $back_url;
	public $part='brem';
	public $noCurrentBarem=false;

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
		$acad = Yii::app()->session['currentId_academic_year'];
		
		$model=new Bareme;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
         
           $number_line = infoGeneralConfig('nb_grid_line');
           $min_value = array(); 
           $max_value = array(); 
           $percent = array();
           
           $error_report = False;
           
           $last_compteur =0;
           
           $j = 0;
      
         
          if(isset($_POST['btnSave']))
            {
                   //get the last compteur
                   //return an integer   
                      $last_compteur = Bareme::model()->getLastCompteur();
                   
                   $eder_marc_poulard_prosper = $last_compteur+1;
                                 
              for($i=0;$i<$number_line;$i++)
               {
                  if((isset($_POST['min'.$i]) && $_POST['min'.$i]!="") && (isset($_POST['max'.$i]) && $_POST['max'.$i]!="")  && (isset($_POST['percent'.$i]) && $_POST['percent'.$i]!="") )
                    {
                      
                      
                      $min_value[$i] = $_POST['min'.$i]; 
                      $max_value[$i] = $_POST['max'.$i];
                      $percent[$i] = $_POST['percent'.$i]; 
                      
                      
                      $model->setAttribute('min_value', $min_value[$i]);
                      $model->setAttribute('max_value', $max_value[$i]);
                      $model->setAttribute('percentage', $percent[$i]);
                      
                      $model->setAttribute('compteur', $eder_marc_poulard_prosper);
                      
                      $model->setAttribute('date_created', date('Y-m-d H:m:s'));
                      $model->setAttribute('created_by', Yii::app()->user->name);
                      
                      if($model->save()){
                              
                         //update all records of this compteur to OLD => old_new =0
                         //$command = Yii::app()->db->createCommand();
                         //$command->update('bareme', array( 'old_new'=>0, ), 'compteur=:comp', array(':comp'=>$last_compteur));
                                   
                             $model->unsetAttributes(); 
                             $model = new Bareme; 
                                                            
                          }
                      }
                  
                  $model->unsetAttributes(); 
                  $model = new Bareme; 
                 }
              
              
              if($last_compteur >= 1)
                {                         //update all records of this compteur to OLD => old_new =0
                         $command = Yii::app()->db->createCommand();
                         $command->update('bareme', array( 'old_new'=>0, ), 'compteur=:comp', array(':comp'=>$last_compteur));
                                   
                	
                	}
                	
                $this->redirect(array('index'));
        
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
	public function actionUpdate()
	{
		$model=new Bareme;
			// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$min_value = array(); 
           $max_value = array(); 
           $percent = array();
           
           $error_report = False;
           

		//if(isset($_POST['Bareme']))
		//{
			 
		  if(isset($_POST['update']))
		   {	
			 foreach($_POST['range'] as $i)
               {
                  if((isset($_POST['min'.$i]) && $_POST['min'.$i]!="") && (isset($_POST['max'.$i]) && $_POST['max'.$i]!="")  && (isset($_POST['percent'.$i]) && $_POST['percent'.$i]!="") )
                    {
                     
                      $model = $this->loadModel($i);
                      
                      $min_value[$i] = $_POST['min'.$i]; 
                      $max_value[$i] = $_POST['max'.$i];
                      $percent[$i] = $_POST['percent'.$i]; 
                      
                     
                      
                      $model->setAttribute('min_value', $min_value[$i]);
                      $model->setAttribute('max_value', $max_value[$i]);
                      $model->setAttribute('percentage', $percent[$i]);
                      
                       if($model->save())
				         {  
				         	  $model->unsetAttributes(); 
                             $model = new Bareme; 
				              $error_report = false;
				           }
				        else
				           { $error_report = true;
				               break;
				             }
                        
                     }
                   else
                      $this->loadModel($i)->delete();                                                            
                 
                 }
                 
			if(!$error_report)
				$this->redirect(array('index'));
		     else
		       {
                  
                  $message=Yii::t('app',"ERROR");
                        Yii::app()->user->setFlash(Yii::t('app','Error'), $message);
                }
                
                
                
		    }
		    
		    
		    
		//}

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
		$model=new Bareme;
		$this->noCurrentBarem=false;
		
		$bareme = Bareme::model()->getBaremeInUse();
		if($bareme==null)
		  $this->noCurrentBarem=true;
		  
		  
		if(isset($_POST['delete']))
            {
                                     
                                 
              foreach($_POST['range'] as $range_)
               {
                   $this->loadModel($range_)->delete();                                                            
                 
                 }
              
              $this->noCurrentBarem=true;
             
           }
		
		$dataProvider=new CActiveDataProvider('Bareme');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Bareme('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bareme']))
			$model->attributes=$_GET['Bareme'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bareme the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bareme::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bareme $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bareme-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
