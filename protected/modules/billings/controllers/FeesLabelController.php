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
class FeesLabelController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	public $part='feedes';
	
	public $old_feeLabel;
	public $message_default_fLabel_u = false;

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
		$model=new FeesLabel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FeesLabel']))
		{
			$model->attributes=$_POST['FeesLabel'];
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
		
		$this->old_feeLabel= $model->fee_label;
		
		if(($this->old_feeLabel=="Pending balance")||($this->old_feeLabel=="Reservation"))        
	          { $this->message_default_fLabel_u = true;
	             
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

		if(isset($_POST['FeesLabel']))
		{
			$model->attributes=$_POST['FeesLabel'];
			if($model->save())
				$this->redirect(array('index'));
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
   			 $this->message_default_fLabel_u = false;
   			 
   			 $model = $this->loadModel($id);
   			 
   			 $feeLabel= $model->fee_label;
   			 
   			 if(($feeLabel!="Pending balance")&&($feeLabel!="Reservation") )       
               {  
                 $this->loadModel($id)->delete();
                 
               }
             else
               { $this->message_default_fLabel_u=true;
                   $url=Yii::app()->request->urlReferrer;
		       	    
		       	    $explode_url= explode("?",$url);
            
   		      	    if($explode_url!=null)
		      	      $this->redirect($url.'?msguv=y');
		      	    else
		      	       $this->redirect($url.'&msguv=y');

                }

   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
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
		     if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                unset($_GET['pageSize']);
                }
            
                $model=new FeesLabel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FeesLabel']))
			$model->attributes=$_GET['FeesLabel'];
                
                // Here to export to CSV 
               		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of fees label: ')), null,false);
                            $this->exportCSV($model->search(), array(
				//'fee_label',
				'FeeLabel',
				'status',
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
           'filename' => Yii::t('app','feesLabel.csv'),
           'csvDelimiter' => ',',
           ));
}        
        

   public function ChangeDateFormat($d){
            if(($d!='')&&($d!='0000-00-00'))
              { $time = strtotime($d);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
               return $day.'/'.$month.'/'.$year; 
               }
             else
                return '00/00/0000';     
        }
  
  
  	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FeesLabel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FeesLabel']))
			$model->attributes=$_GET['FeesLabel'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FeesLabel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FeesLabel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FeesLabel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='fees-label-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
