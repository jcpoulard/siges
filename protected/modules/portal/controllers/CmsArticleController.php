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
class CmsArticleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $back_url;
        public $position_id = "main";
        public $part = "pot";
        public $article_menu; 
        

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
		$model=new CmsArticle;

		// Uncomment the following line if AJAX validation is needed
		
                $_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
                $_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/cms_files/"; // URL for the uploads folder
                $_SESSION['KCFINDER']['uploadDir'] = Yii::app()->basePath."/../cms_files/"; // path to the uploads folder
                if(isset($_POST['CmsArticle']['set_position'])){
                    $this->position_id = $_POST['CmsArticle']['set_position'];
                }
                
                 if(isset($_POST['CmsArticle']['article_menu'])){
                    $this->article_menu = $_POST['CmsArticle']['article_menu'];
                }
                
                
		if(isset($_POST['CmsArticle']))
		{
			$model->attributes=$_POST['CmsArticle'];
                        $model->setAttribute('is_publish', 1);
                        $model->setAttribute('date_create',date('Y-m-d H:m:s'));
                        $model->setAttribute('create_by', Yii::app()->user->name);
                        $model->setAttribute('article_menu', $this->article_menu);
                        if(isset($_POST['create']))
                            if($model->save())
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		
                
                
                if(isset($_POST['CmsArticle']['set_position'])){
                    $this->position_id = $_POST['CmsArticle']['set_position'];
                }
                
                if(isset($_POST['CmsArticle']['article_menu'])){
                    $this->article_menu = $_POST['CmsArticle']['article_menu'];
                }
                

		if(isset($_POST['CmsArticle']))
		{
                    if(isset($_GET['id'])){
                        $this->position_id = $_POST['CmsArticle']['set_position'];
                     }
			$model->setAttribute('last_update', date('Y-m-d'));
                        $model->attributes=$_POST['CmsArticle'];
                        $model->setAttribute('article_menu', $this->article_menu);
                         if(isset($_POST['update'])){
                            if($model->save())
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
            if (isset($_GET['pageSize'])) {
                        Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                        unset($_GET['pageSize']);
                        }
		$model=new CmsArticle('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CmsArticle']))
			$model->attributes=$_GET['CmsArticle'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CmsArticle the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CmsArticle::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CmsArticle $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cms-article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        //for ajaxrequest
    public function actionUploadLogo(){
                $model = new CmsArticle; 
                
       
				
		  if(isset($_POST['logoUpload']))
		    {
		    	$file_image = array();
                        $image_tmp = array();
                        
                        $file_image[0] = $_FILES["image1"]["name"];
                        $image_tmp[0] = $_FILES['image1']['tmp_name'];

                        $file_image[1] = $_FILES["image2"]["name"];
                        $image_tmp[1] = $_FILES['image2']['tmp_name'];

                        $file_image[2] = $_FILES["image3"]["name"];
                        $image_tmp[2] = $_FILES['image3']['tmp_name'];
                           
                        $j=1;
                        for($i=0;$i<count($file_image);$i++){
                            $filename = stripslashes($file_image[$i]);
                            $extension = $this->getExtension($filename);
                            $extension = strtolower($extension);
                            
                             if($extension=="jpg" || $extension=="jpeg"){
                                 $size=filesize($image_tmp[$i]);
                                 $filename = Yii::app()->basePath.'/../cms_files/images/banners/image'.$j.'.'.$extension;
                                 if ($size > 4*1024*1024)
                                {
                                $mesage=Yii::t('app','You have exceeded the size limit.');
                                Yii::app()->user->setFlash(Yii::t('app','UploadImage'), $mesage);
                                }else{
                                move_uploaded_file($image_tmp[$i], $filename);
                                $mesage=Yii::t('app','Image upload successfully');
                                Yii::app()->user->setFlash(Yii::t('app','UploadImage'), $mesage);
                                }
                                 
                             }else{
                                 $mesage=Yii::t('app','Load a jpeg or jpg logo extension.');
                                Yii::app()->user->setFlash(Yii::t('app','UploadImage'), $mesage);
                             }
                            $j++;
                        }
                        
    		                
		             }
                
                
	    	
                    
          
           if(Yii::app()->request->isAjaxRequest) 
		     { 
			   $this->renderPartial('uploadLogo',array(
					'model'=>$model),false,true);
			 }
			else
			  { 
			   					
					$this->render('index',array(
									'model'=>$model,
								));

			 }

            
        }
        
        
        public function getExtension($str) {
            $i = strrpos($str,".");
            if (!$i) { return ""; }
            $l = strlen($str) - $i;
            $ext = substr($str,$i+1,$l);
            return $ext;
        }
        
    
    public function actionUpdateArticle()
		{
			$es = new EditableSaver('CmsArticle');
                        $es->onBeforeUpdate = function($event) {
                        $event->sender->setAttribute('last_update', date('Y-m-d H:i:s'));
                        
                        };
                        
			$es->update();
		}
        
        
}
