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




class ChargePaidController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url;
	
	public $depensesItems2=2;
	 public $part; 
	public $month_ =0;
	
	public $status_ = 0;
	
	public $id_charge_desc;
	
	
	public $message_paymentDate=false;

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
		 
		$acad=Yii::app()->session['currentId_academic_year'];
		
		if(isset($_POST['ChargePaid']['depensesItems']))
		  $this->depensesItems2 = $_POST['ChargePaid']['depensesItems'];
		   
		
		if($this->depensesItems2==2)
		    {
		        $this->status_ = 2;
		
		      }
		 elseif($this->depensesItems2==1)
          { 
         	 $this->status_ = 1;
         	 $this->redirect(array('/billings/payroll/create/di/1/part/pay/from/stud'));

           }
		
		$model=new ChargePaid;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ChargePaid']))
		{
			
		
			$model->attributes=$_POST['ChargePaid'];
			
		   if(isset($_POST['create']))
			  { 
				
				$model->setAttribute('academic_year',$acad);
				if($model->save())
					$this->redirect(array('index'));
			  
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['ChargePaid']))
		{
			$model->attributes=$_POST['ChargePaid'];
			
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


	
//************************  loadRecettesItems ******************************/
	public function loadDepensesItems()
	{     $code= array();
		   
		$groupid=Yii::app()->user->groupid;
        $group=Groups::model()->findByPk($groupid);
                    
        $group_name=$group->group_name;
					   
		  if($group_name=='Administrateur systeme')
		    {
		    	$code[2]= Yii::t('app','Charge');
		    }
          else
           { 
           	 $code[1]= Yii::t('app','Payroll');
		     $code[2]= Yii::t('app','Charge');
           }
		           
		    		   
		return $code;
         
	}



	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		
		if(isset($_POST['ChargePaid']['depensesItems']))
		  $this->depensesItems2 = $_POST['ChargePaid']['depensesItems'];
		   
		  
		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}

	    if($this->depensesItems2 == 2)
          {         
              $this->status_ = 2;
              
                if(!isset($_GET['month_']))
			       {
			       	   $sql__ = 'SELECT DISTINCT payment_date FROM charge_paid ';
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						     { $current_month = getMonth($r['payment_date']);
						          break;
						     }
						  }
						else
						  $current_month = getMonth(date('Y-m-d'));
			       	  // $month_display=$current_month;
			        }
			     else 
			       {  $current_month = $_GET['month_'];
			       	  //$month_display= $_GET['month_'];
			        }
           
            $model=new ChargePaid('searchByMonth('.$current_month.','.$acad.')');
		        $model->unsetAttributes();  // clear any default values
		
		
		if(isset($_GET['ChargePaid']))
			$model->attributes=$_GET['ChargePaid'];
           
                            // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Other expenses: ')), null,false);
                            $this->exportCSV($model->searchByMonth($current_month,$acad), array(
                                
				'idChargeDescription.description',
				'amount',
				'ExpenseDate',
				'comment',
				'academicYear.name_period',
		                )); 
		    }
				
         }
       elseif($this->depensesItems2==1)
         { 
         	 $this->status_ = 1;
         	 $this->redirect(array('/billings/payroll/index/di/1/from/b'));

           }
               

		
		
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ChargePaid('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ChargePaid']))
			$model->attributes=$_GET['ChargePaid'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


// Export to CSV 
        public function behaviors() {
           return array(
               'exportableGrid' => array(
                   'class' => 'application.components.ExportableGridBehavior',
                   'filename' => Yii::t('app','Expense.csv'),
                   'csvDelimiter' => ',',
                   ));
        }




	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ChargePaid the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ChargePaid::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ChargePaid $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='charge-paid-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
