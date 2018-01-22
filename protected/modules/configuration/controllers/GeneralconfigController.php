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



class GeneralconfigController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';

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
	

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new GeneralConfig;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GeneralConfig']))
		{
			$model->attributes=$_POST['GeneralConfig'];
			
			 if(isset($_POST['create']))
              {       
				$model->setAttribute('date_create',date('Y-m-d'));
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

	
	
	public function actionUpdate()
	{   
             if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
          
            
         if(!isset($_GET['all']))
		  {  
                $model=$this->loadModel();
              $this->performAjaxValidation($model);
		  
		       if(isset($_POST['update']))
				{   //on vient de presser le bouton
								 //reccuperer le ligne modifiee
									 
										   if(isset($_POST['GeneralConfig'])){
											
											$model->attributes=$_POST['GeneralConfig'];
												
										   $model->setAttribute('date_update',date('Y-m-d'));
                                                                                                                                                                                                                                                                		}                   
                                                                                                                                                                                                                                                                		               $pass=true;                  
                                                                                                                                                                                                                                                                 
                          //si sommaire=1,anpeche period_weight!=1   visevesa                                                                                                                                                                                                               
                                if($model->item_name=='display_period_summary')//sommaire
                                  {
                                  	   //Extract use_period_weight
						                $use_period_weight = infoGeneralConfig('use_period_weight');
						                if(($model->item_value==1)&&($use_period_weight==1))
				                           { $pass=false;
				                             Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Sorry, period weight is set to 1. Set it to 0 if you really want to display period summary.') );
				                           }
                                  	}
                                 elseif($model->item_name=='use_period_weight')//period_weight
                                    {
                                    	//Extract display_period_summary
						                $display_period_summary = infoGeneralConfig('display_period_summary');
						                if(($model->item_value==1)&&($display_period_summary==1))
				                           { $pass=false;
				                             Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Sorry, period summary is set to 1. Set it to 0 if you really want to use period weight.') );
				                           }
						                
				                
                                      }
                                                                                                                                                                                                                                                     
								
						if($pass==true)
						  {				  
						  	            if($model->save())
											 { 											   
											   
											   //CURRENCY
											 //Extract devise name and symbol 
											  $criteria_ = new CDbCriteria;
										   		$criteria_->condition='item_name=:item_name';
										   		$criteria_->params=array(':item_name'=>'currency_name_symbol',);
										   		$currency_name_symbol = GeneralConfig::model()->find($criteria_)->item_value;
											    
											    $explode_currency_name_symbol= explode("/",substr($currency_name_symbol, 0));
											    
											    $currency_name = $explode_currency_name_symbol[0];
											    $currency_symbol = $explode_currency_name_symbol[1];
											    
											     unset(Yii::app()->session['currencyName']);
											      unset(Yii::app()->session['currencySymbol']);
											      
											    Yii::app()->session['currencyName']=$currency_name;
											    Yii::app()->session['currencySymbol']=$currency_symbol;           
					        

											   
											   
											   $this->redirect(array('index'));
											 }
											 
						     }
								 
								
					
					
						
				}
				
			if(isset($_POST['cancel']))
                          {
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }
                          
                          
		  }
		elseif($_GET['all']==1)
		 {	   $model=new GeneralConfig;
			
			
			
					 
				if(isset($_POST['update']))
					{   //on vient de presser le bouton
									 //reccuperer le ligne modifiee
										 $grade=0;
								   foreach($_POST['id_config'] as $id)
									{   	   
											   if(isset($_POST['generalconfig'][$id]))
													$grade=$_POST['generalconfig'][$id];
												
											   
												$model=GeneralConfig::model()->findbyPk($id);
											   
											   $model->setAttribute('date_update',date('Y-m-d'));
											   $model->setAttribute('item_value',$grade);
											   
											   $pass=true;                  
                                                                                                                                                                                                                                                                 
                               //si sommaire=1,anpeche period_weight!=1   visevesa                                                                                                                                                                                                               
                                if($model->item_name=='display_period_summary')//sommaire
                                  {
                                  	   //Extract use_period_weight
						                $use_period_weight = infoGeneralConfig('use_period_weight');
						                if(($model->item_value==1)&&($use_period_weight==1))
				                           { $pass=false;
				                             Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Sorry, period weight is set to 1. Set it to 0 if you really want to display period summary.') );
				                           }
                                  	}
                                 elseif($model->item_name=='use_period_weight')//period_weight
                                    {
                                    	//Extract display_period_summary
						                $display_period_summary = infoGeneralConfig('display_period_summary');
						                if(($model->item_value==1)&&($display_period_summary==1))
				                           { $pass=false;
				                             Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Sorry, period summary is set to 1. Set it to 0 if you really want to use period weight.') );
				                           }
						                
				                
                                      }

										if($pass==true)
										  {
										  	  if($model->save())
												 {  
												   $model->unSetAttributes();
												   $model= new GeneralConfig;
												   
												   
												 }
												 
										  }
									 
									}
						
						 //CURRENCY
											 //Extract devise name and symbol 
											  $criteria_ = new CDbCriteria;
										   		$criteria_->condition='item_name=:item_name';
										   		$criteria_->params=array(':item_name'=>'currency_name_symbol',);
										   		$currency_name_symbol = GeneralConfig::model()->find($criteria_)->item_value;
											    
											    $explode_currency_name_symbol= explode("/",substr($currency_name_symbol, 0));
											    
											    $currency_name = $explode_currency_name_symbol[0];
											    $currency_symbol = $explode_currency_name_symbol[1];
											    
											     unset(Yii::app()->session['currencyName']);
											      unset(Yii::app()->session['currencySymbol']);
											      
											    Yii::app()->session['currencyName']=$currency_name;
											    Yii::app()->session['currencySymbol']=$currency_symbol;           
					        

						
						 $this->redirect (array('index'));
							
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

//for ajaxrequest
    public function actionUploadLogo(){
                $model = new GeneralConfig; 
                
       
				
		  if(isset($_POST['logoUpload']))
		    {
		    									
		    	  $fileName =$_FILES["image"]["name"];
	                      $uploadedfile = $_FILES['image']['tmp_name'];
		   	

		   	     
			         //saving logo
							if ($fileName)  // check if uploaded file is set or not
							  {   
							      
								  //check image extension
								    
									$filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									//only .png allowed
									if ($extension != "png")
									 {
		
										$mesage=Yii::t('app','Load a png logo extension.');
										Yii::app()->user->setFlash(Yii::t('app','UploadLogo'), $mesage);
									 }
									else
									 {   //checking the size
									       $size=filesize($_FILES['image']['tmp_name']);


											if ($size > 400*1024)
											{
												$mesage=Yii::t('app','You have exceeded the size limit.');
												Yii::app()->user->setFlash(Yii::t('app','UploadLogo'), $mesage);
											}
											
											 if($extension=="png")
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefrompng($uploadedfile);

												}
												
												list($width,$height)=getimagesize($uploadedfile);


												$newwidth=140; //105;//60;
												$newheight=($height/$width)*$newwidth;
												$tmp=imagecreatetruecolor($newwidth,$newheight);


												$newwidth1=34;//25;
												$newheight1=($height/$width)*$newwidth1;
												$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

												imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

												imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


												$filename = Yii::app()->basePath.'/../css/images/school_logo.png';

												

												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);
                                        
                                        $mesage=Yii::t('app','Logo upload successfully');
                                        Yii::app()->user->setFlash(Yii::t('app','UploadLogo'), $mesage);
									 
									 }
							      
								    
							  }
							else
							  {
							  	
							  	$mesage=Yii::t('app','No file to upload, retry later.');
							  	Yii::app()->user->setFlash(Yii::t('app','UploadLogo'), $mesage);
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
	
	      
	/**
	 * Lists all models.
	 */

	
	public function actionIndex()
	{
		
            if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
            }
            $model=new GeneralConfig('search');
            $model->unsetAttributes();
            
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GeneralConfig']))
			$model->attributes=$_GET['GeneralConfig'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
             
                $model=new GeneralConfig('search');
             
                
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GeneralConfig']))
			$model->attributes=$_GET['GeneralConfig'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return GeneralConfig the loaded model
	 * @throws CHttpException
	 */
	
	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=GeneralConfig::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param GeneralConfig $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='general-config-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
