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




class TaxesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	public $part='taxset';
	
	public $particulier;
	
	public $old_taxeDescription;
	
	public $message_default_taxe_u = false;

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
		   $acad_sess = acad_sess();
		$acad=Yii::app()->session['currentId_academic_year']; 
		
		$model=new Taxes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Taxes']))
		{
			$model->attributes=$_POST['Taxes'];
			  $model->setAttribute('academic_year', $acad);
			  
			  if(isset($_POST['Taxes']['particulier']))
			           {
                        $this->particulier = $_POST['Taxes']['particulier'];
                        
                        }
			
			if(isset($_POST['create']))
             {
				
				if($model->save())
					{
						$prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_taxes = Taxes::model()->search($acad);
 											$all_taxes = $all_taxes->getData();
 											foreach($all_taxes as $t)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   }
								     	 if($prosper_marc_hilaire_poulard==1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'taxes'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	   	} 

						$this->redirect(array('taxes/index',)); 
						
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

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->message_default_taxe_u = false;
		
		$model=$this->loadModel($id);
		
		$this->old_taxeDescription= $model->taxe_description;
		
		if(($this->old_taxeDescription=="IRI"))        
	          { $this->message_default_taxe_u = true;
	             
	              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI']; 
	              
	              $explode_url= explode("?",substr($url,0));
	   		      	    if(isset($explode_url[1]))
			      	      {  
			      	      	$this->redirect(Yii::app()->request->urlReferrer.'&msguv=y');
			      	      	  
	                     }
			      	    else
			      	       $this->redirect($url.'?msguv=y');
			      	       
			      	      	            }
	            
	       

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Taxes']))
		{
			$model->attributes=$_POST['Taxes'];
			
			if(isset($_POST['update']))
             {
				if(($this->old_taxeDescription!="IRI"))
				  { 
				         if($this->old_taxeDescription=="TMS")
				          { $model->setAttribute('taxe_description',"TMS");
				             $model->setAttribute('employeur_employe',1);
				          }
				         if($this->old_taxeDescription=="ONA")
				          {  $model->setAttribute('taxe_description',"ONA");
				             $model->setAttribute('employeur_employe',0);
				          	
				          	}
				          	
						if($model->save())
							$this->redirect(array('taxes/index',)); 
                    }
                 else
                   $this->message_default_taxe_u = true;
              
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
   			
   			 
   			  $this->message_default_taxe_u=false;
		
			$model=$this->loadModel($id);
	        
	        $taxeDesc= $model->taxe_description;
	        
	        
            if(($taxeDesc!="IRI")&&($taxeDesc!="TMS")&&($taxeDesc!="ONA"))        
               {  
                 $this->loadModel($id)->delete();
                 
               }
             else
               { $this->message_default_taxe_u=true;
                   $url=Yii::app()->request->urlReferrer;
		       	    
		       	    $explode_url= explode("?",$url);
            
   		      	    if($explode_url!=null)
		      	      $this->redirect($url.'?msguv=y');
		      	    else
		      	       $this->redirect($url.'&msguv=y');

                }
                
                
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			
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
	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year']; //current academic year
		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		
		$model=new Taxes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Taxes']))
			$model->attributes=$_GET['Taxes'];
			
				
	   	                // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Taxes')), null,false);
                            $this->exportCSV($model->search(), array(
                                
				'taxe_description',
		        'taxe_value',
                )); 
		}


		$this->render('index',array(
			'model'=>$model,
		));	
		
	}

//************************  loadEmployerEmployee() ******************************/
   public function loadEmployerEmployee()
	{
		  $code= array();
		   
		  $code[null]= Yii::t('app','-- Select --');
		  $code[0]= Yii::t('app','Employee');
          $code[1]= Yii::t('app','Employer');
		           
		       
		   
		return $code;
			
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Taxes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Taxes']))
			$model->attributes=$_GET['Taxes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

   // Export to CSV 
        public function behaviors() {
           return array(
               'exportableGrid' => array(
                   'class' => 'application.components.ExportableGridBehavior',
                   'filename' => Yii::t('app','taxes.csv'),
                   'csvDelimiter' => ',',
                   ));
        }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Taxes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Taxes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Taxes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='taxes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
