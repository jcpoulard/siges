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




class BalanceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	
	public $part='balanc';
	public $room_id;
	public $fee_id;
	
   

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
		$model=new Balance;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Balance']))
		{
			$model->attributes=$_POST['Balance'];
			
			 if(isset($_POST['create']))
              {
                          	
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Balance']))
		{
			$model->attributes=$_POST['Balance'];
			
			 if(isset($_POST['update']))
               {
				if($model->save())
					$this->redirect(array('balance','part'=>'balanc'));
					
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
		$dataProvider=new CActiveDataProvider('Balance');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Balance('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Balance']))
			$model->attributes=$_GET['Balance'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	 public function actionBalance()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
  		$acad_name=Yii::app()->session['currentName_academic_year'];
  		
		
		$modelRoom = new Rooms;
		$modelFee = new Fees;
		
		 
		   if(isset($_POST['Rooms']))
 			     {  $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['RoomsBalance']=$this->room_id; 
 			  
 			       }
 			else
 			  {
 			  	  if(Yii::app()->session['RoomsBalance']!='')
 			  	     $this->room_id = Yii::app()->session['RoomsBalance']; 
 			  	}
         
          if(isset($_POST['Fees']['fee_name']))
 			     { 
								   $this->fee_id=$_POST['Fees']['fee_name'];
								   Yii::app()->session['FeesBalance']=$this->fee_id; 
 			       }
 			else
 			  {
 			  	  if(Yii::app()->session['FeesBalance']!='')
 			  	     $this->fee_id = Yii::app()->session['FeesBalance']; 
 			  	}
			/**/	
			

        if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		
		if($this->room_id=='')
		  {
				$model=new Balance('search');
				$model->unsetAttributes();  // clear any default values
				if(isset($_GET['Balance']))
					$model->attributes=$_GET['Balance'];
		         
		                   // Here to export to CSV 
				if($this->isExportRequest()){
					$this->exportCSV(array(Yii::t('app','Balance: ')), null,false);
		                            $this->exportCSV($model->search(), array(
		                               
						'student0.last_name',
						'student0.first_name',
					    'balance',
						'date_created')); 
						}
						
		      }
		   elseif(($this->room_id!=''))
			  {   
			  	  if($this->fee_id=='')
				    {					  
						   $model=new Balance('searchByRoomFee('.$this->room_id.',NULL)');
						   $model->unsetAttributes();  // clear any default values
						   if(isset($_GET['Balance']))
					           $model->attributes=$_GET['Balance'];
						   
					   
								   // Here to export to CSV 
						if($this->isExportRequest()){
							$this->exportCSV(array(Yii::t('app','Balance: ')), null,false);
											$this->exportCSV($model->searchByRoomFee($this->room_id,NULL), array(
											   
								'student0.last_name',
								'student0.first_name',
								'balance',
								'date_created')); 
								}
					}
				   elseif(($this->fee_id!=''))
				   {
					    $model=new Balance('searchByRoomFee('.$this->room_id.','.$this->fee_id.')');
						   $model->unsetAttributes();  // clear any default values
						    if(isset($_GET['Balance']))
					           $model->attributes=$_GET['Balance'];
						   
								   // Here to export to CSV 
						if($this->isExportRequest()){
							$this->exportCSV(array(Yii::t('app','Balance: ')), null,false);
											$this->exportCSV($model->searchByRoomFee($this->room_id,$this->fee_id), array(
											   
								'student0.last_name',
								'student0.first_name',
								'balance',
								'date_created')); 
								}
				   }
				  /* */

			    }
		     
					
						


		$this->render('balance',array(
			'model'=>$model,
		));
	}


	
	//************************  loadRoom ******************************/
	public function loadRoom($acad)
	{    $modelRoom= new Rooms();
           $code= array();
		     
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'*',
                                     'join'=>'left join room_has_person rh on(rh.room=r.id)',
									 'condition'=>'rh.academic_year=:acad ',
                                     'params'=>array(':acad'=>$acad,),
									 'order'=>'r.room_name',
                               ));
            $code[null]= Yii::t('app','-- Select room --');
		    if(isset($modelPersonRoom))
			 {  foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}

	
	

	//************************  loadFee ******************************/
	public function loadFee($room,$acad)
	{   
		     
		  $modelFee=Fees::model()->findAll(array('alias'=>'f',
									 'select'=>'fl.fee_label, f.id as id',
                                     'join'=>'inner join fees_label fl on(fl.id=f.fee) inner join levels l on(l.id=f.level) inner join rooms r on(l.id=r.level)',
									 'condition'=>'f.academic_period=:acad AND r.id=:room ',
                                     'params'=>array(':acad'=>$acad,':room'=>$room),
									 'order'=>'f.date_limit_payment ASC',
                               ));
            $code[null]= Yii::t('app','-- Select a fee --');
		    if(isset($modelFee))
			 {  foreach($modelFee as $fee){
			        $code[$fee->id]= $fee->fee_label;
		           
		           }
			 }
		   
		return $code;
         
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Balance the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Balance::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Balance $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='balance-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	
	
	
		// Behavior the create Export to CSV 
	public function behaviors() {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','balance.csv'),
	            'csvDelimiter' => ',',
	            ));
	}

	
	
	
	
	
	
	
	
	
	
	
}
