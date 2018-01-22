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

class InfractionTypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $back_url;

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
		$model=new InfractionType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InfractionType']))
		{
			$model->attributes=$_POST['InfractionType'];
			
			if(isset($_POST['create']))
			  {
			  	 if($model->save())
					$this->redirect(array('index'));
					
			   }
			  
			  if(isset($_POST['cancel']))
                          {
                              //$this->redirect(array($this->back_url));
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

		if(isset($_POST['InfractionType']))
		{
			$model->attributes=$_POST['InfractionType'];
			
			if(isset($_POST['update']))
			  {
			  	if($model->save())
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
				$this->redirect(array('admin'));
			
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
	 * Lists all models.
	 */
        /*
	
        

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
            if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
		$model=new InfractionType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['InfractionType']))
			$model->attributes=$_GET['InfractionType'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=InfractionType::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='infraction-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        public function actionMassAddingInfractionType(){
            $model = new InfractionType;
            
            $number_line = infoGeneralConfig('nb_grid_line');
            
            $name = array(); 
            $description = array(); 
            $deductible_value = array();
            $error_report = False;
            $j = 0;
            $infractionType = array();
            
            if(isset($_POST['btnSave'])){
                for($i=0;$i<$number_line;$i++){
                    if((isset($_POST['name'.$i]) && $_POST['name'.$i]!="") && isset($_POST['description'.$i]) && isset($_POST['deductible_value'.$i])){
                       
                       $name[$i] = $_POST['name'.$i];
                       $description[$i] = $_POST['description'.$i];
                       $deductible_value[$i] = $_POST['deductible_value'.$i];
                       
                       $model->setAttribute('name', $name[$i]);
                       $model->setAttribute('description', $description[$i]);
                       $model->setAttribute('deductible_value', $deductible_value[$i]);
                       
                       if($model->save()){
                           
                       }
                       else{
                           $error_report = True;
                           $infractionType[$j] = $name[$i];
                           $j++;
                       }
                        
                    }
                    $model->unsetAttributes(); 
                    $model = new InfractionType; 
                }
                
                if($error_report){
                    $liste_infraction = "";
                  for($i=0; $i<count($infractionType); $i++){
                      $liste_infraction .= $infractionType[$i].'<br/>';
                  }
                    $message=Yii::t('app',"At least {name} error(s) occured when you saved infraction type !<br/> The following infraction type were about to be duplicate :<br/><b> {infractionType}</b>",array('{name}'=>$j,'{infractionType}'=>$liste_infraction));
                    Yii::app()->user->setFlash(Yii::t('app','Error'), $message);
                
                }else{
                  $this->redirect(array('index'));
                }
            }
            
            if(isset($_POST['btnCancel'])){
                $this->redirect(array('index'));
            }
            
             
             
             $this->render('gridcreate',array(
			'model'=>$model,
		));
        }
}
