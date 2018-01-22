<?php

class CmsDocController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $part = "doc";
        public $back_url;
        public $doc;

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
		$model=new CmsDoc;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CmsDoc']))
		{
			$model->attributes=$_POST['CmsDoc'];
                        
                        
                       if(isset($_POST['create'])){
                           
                            $file_name = $_FILES['document_name']['name'];
                            $file_temp = $_FILES['document_name']['tmp_name'];
                            $filename = stripslashes($file_name);
                            $extension = $this->getExtension($filename);
                            $extension = strtolower($extension);
                            
                            $extension_array = array('pdf','doc','docx','xls','xlsx','ppt','pptx','pps','ppsx','pjg','jpeg','gif','png','txt','ods','odt','rtf'); 
                            
                            if(in_array($extension,$extension_array)){
                                $size = filesize($file_temp);
                                if($size > 5*1024*1024){
                                    $mesage=Yii::t('app','You have exceeded the size limit.');
                                    Yii::app()->user->setFlash(Yii::t('app','UploadDocument'), $mesage);
                                }else{
                                    $path_filename = Yii::app()->basePath.'/../cms_files/files/'.$filename;
                                    move_uploaded_file($file_temp, $path_filename);
                                    $model->setAttribute('document_name', $filename);
                                    $mesage=Yii::t('app','Document upload successfully');
                                    Yii::app()->user->setFlash(Yii::t('app','UploadDocument'), $mesage);
                                }
                                
                            }else{
                                $mesage=Yii::t('app','Incorrect extension.');
                                Yii::app()->user->setFlash(Yii::t('app','UploadDocument'), $mesage);
                            }
                            
                            $model->setAttribute('date_create', date('Y-m-d H:i:s'));
                            $model->setAttribute('create_by', Yii::app()->user->name);
                            if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
                            }
                            
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

		if(isset($_POST['CmsDoc'])){
		
			$model->attributes=$_POST['CmsDoc'];
                        if(isset($_POST['update'])){
                           
                            $file_name = $_FILES['document_name']['name'];
                            if($file_name){
                            $file_temp = $_FILES['document_name']['tmp_name'];
                            $filename = stripslashes($file_name);
                            $extension = $this->getExtension($filename);
                            $extension = strtolower($extension);
                            
                            $extension_array = array('pdf','doc','docx','xls','xlsx','ppt','pptx','pps','ppsx','pjg','jpeg','gif','png','txt','ods','odt','rtf'); 
                            
                            if(in_array($extension,$extension_array)){
                                $size = filesize($file_temp);
                                if($size > 5*1024*1024){
                                    $mesage=Yii::t('app','You have exceeded the size limit.');
                                    Yii::app()->user->setFlash(Yii::t('app','UploadDocument'), $mesage);
                                }else{
                                    $path_filename = Yii::app()->basePath.'/../cms_files/files/'.$filename;
                                    move_uploaded_file($file_temp, $path_filename);
                                    $model->setAttribute('document_name', $filename);
                                    $mesage=Yii::t('app','Document upload successfully');
                                    Yii::app()->user->setFlash(Yii::t('app','UploadDocument'), $mesage);
                                }
                                
                            }else{
                                $mesage=Yii::t('app','Incorrect extension.');
                                Yii::app()->user->setFlash(Yii::t('app','UploadDocument'), $mesage);
                            }
                        
                            $model->setAttribute('date_update', date('Y-m-d H:i:s'));
                            $model->setAttribute('update_by', Yii::app()->user->name);
                            if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
                            }
                            
                        }
                        else{
                          $model->setAttribute('date_update', date('Y-m-d H:i:s'));
                            $model->setAttribute('update_by', Yii::app()->user->name);
                            if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
                            }
                      }
                      }
			//if($model->save())
			//	$this->redirect(array('view','id'=>$model->id));
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
		$model = new CmsDoc;
                $this->doc = $this->loadModel($id)->document_name;
                $string = Yii::app()->basePath;
                $address_base = str_replace("protected", "", $string);
                shell_exec('rm -rf "'.$address_base.'cms_files/files/'.$this->doc.'"');
                $this->loadModel($id)->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                $this->render('index',array(
			'model'=>$model,
                        
		));
	}

	/**
	 * Lists all models.
	 */
        /*
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CmsDoc');
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
             if (isset($_GET['pageSize'])) {
                        Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                        unset($_GET['pageSize']);
                        }
		$model=new CmsDoc('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CmsDoc']))
			$model->attributes=$_GET['CmsDoc'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CmsDoc the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CmsDoc::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CmsDoc $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cms-doc-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        public function getExtension($str) {
            $i = strrpos($str,".");
            if (!$i) { return ""; }
            $l = strlen($str) - $i;
            $ext = substr($str,$i+1,$l);
            return $ext;
        }
}
