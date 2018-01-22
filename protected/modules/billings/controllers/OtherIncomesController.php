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




class OtherIncomesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	public $id_income_desc;
	
	public $recettesItems;
	public $month_ =0;

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
		
		
		 if(isset($_POST['OtherIncomes']['recettesItems']))
			    $this->recettesItems = $_POST['OtherIncomes']['recettesItems'];
		  else
		     {
		     	 if(isset($_GET['ri']) )
		     	   $this->recettesItems = $_GET['ri']; 
		       }
	       
	     
	
     
      if($this->recettesItems==0)
		    {
		        $this->redirect(array('/billings/billings/create?stat=1&ri=0&from=b'));
		
		      }
		  elseif($this->recettesItems==1)
		      {         
		        	
				$this->redirect(array('/billings/billings/create?stat=0&ri=1&from=b'));
					                
		      }
		    elseif($this->recettesItems==3) 
		      {         
		        	
				$this->redirect(array('/billings/enrollmentIncome/create?stat=0&ri=1&from=b'));
					                
		      }
		    elseif($this->recettesItems==4)
		      {         
		        	 
				$this->redirect(array('/billings/reservation/create?part=rec&stat=0&ri=1&from=b'));
					                
		      }

      
  
	      $model=new OtherIncomes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OtherIncomes']))
		{
			$model->attributes=$_POST['OtherIncomes'];
			
			if(isset($_POST['create']))
			  {//on vient de presser le bouton
				
				if((isset($_GET['p'])&&($_GET['p']!='')&&($_GET['p_id']!=0))&&(isset($_GET['p_id'])&&($_GET['p_id']!='')&&($_GET['p_id']!=0)))
	               {
	   	                  $student= $this->getStudent($_GET['p_id']);
	   	                  $description = Yii::t('app','Admission fee for ').$student;
	   	                  
	   	                  $model->setAttribute('id_income_description',1);
	   	                  $model->setAttribute('description',$description);
	   	                  $model->setAttribute('amount',$_GET['p']);
	               }
	   	    
	   	    
				//$model->setAttribute('income_date', date('Y-m-d') );
			    $model->setAttribute('academic_year', $acad);
			    $model->setAttribute('created_by', Yii::app()->user->name  );
			    $model->setAttribute('date_created', date('Y-m-d') );
			    
				if($model->save())
					{
						if((isset($_GET['p'])&&($_GET['p']!='')&&($_GET['p_id']!=0))&&(isset($_GET['p_id'])&&($_GET['p_id']!='')&&($_GET['p_id']!=0)))
	                      {
						       $modelPerson = Persons::model()->findByPk($_GET['p_id']);
						       if(($modelPerson!=null)&&($modelPerson->paid==0))
						         {  $modelPerson->setAttribute('paid',1);
						           $modelPerson->save();
	                               }
						       $this->redirect(array('/academic/persons/viewDetailAdmission/id/'.$_GET['p_id'].'/al/'.$_GET['al'].'/p/'.$_GET['p'].'/from/ad'));
	                      }
	                   else
	                      {
	                        	$this->redirect(array('/billings/otherIncomes/index/ri/'.$this->recettesItems.'/part/rec/from/stud'));
	                      	}
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
		$acad=Yii::app()->session['currentId_academic_year'];
		
		$model=$this->loadModel($id);
		
		 if(isset($_POST['OtherIncomes']['recettesItems']))
		    $this->recettesItems = $_POST['OtherIncomes']['recettesItems'];
	  else
	     {
	     	 if(isset($_GET['ri']) )
	     	   $this->recettesItems = $_GET['ri']; 
	       }

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OtherIncomes']))
		{
						
			$model->attributes=$_POST['OtherIncomes'];
			
			if(isset($_POST['update']))
			  {//on vient de presser le bouton
				 		   
					$model->setAttribute('updated_by', Yii::app()->user->name  );
					 $model->setAttribute('date_updated', date('Y-m-d') );
					
					if($model->save())
						$this->redirect(array('/billings/otherIncomes/index/ri/'.$this->recettesItems.'/part/rec/from/stud'));
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
	public function loadRecettesItems()
	{     $code= array();
		   
		   $code[0]= Yii::t('app','Tuition fees');
		   $code[1]= Yii::t('app','Other fees');
		   $code[2]= Yii::t('app','Manage other incomes');
		   $code[3]= Yii::t('app','Enrollment fee');
		   $code[4]= Yii::t('app','Reservation');
		           
		    		   
		return $code;
         
	}

		/**
	 * Manages all models.
	 */
	public function actionIndex() //actionAdmin()
	{
		$acad=Yii::app()->session['currentId_academic_year']; //current academic year
		
		
	  if(isset($_POST['OtherIncomes']['recettesItems']))
		    $this->recettesItems = $_POST['OtherIncomes']['recettesItems'];
	  else
	     {
	     	 if(isset($_GET['ri']) )
	     	   $this->recettesItems = $_GET['ri']; 
	       }
		
	 if($this->recettesItems==0)
      {         
        	
		$this->redirect(array('/billings/billings/index','ri'=>0,'from'=>'oi'));
			                
      }
     elseif($this->recettesItems==1)
      {         
        	
		$this->redirect(array('/billings/billings/index','ri'=>1,'from'=>'oi'));
			                
      }
     elseif($this->recettesItems==2)
         {
         	$current_month = 0;
         	
         	 if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			
		$model=new OtherIncomes('search('.$acad.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OtherIncomes']))
			$model->attributes=$_GET['OtherIncomes'];
		
			 if(!isset($_GET['month_']))
		       {
		       	   $sql__ = 'SELECT DISTINCT income_date FROM other_incomes ORDER BY id DESC';
														
				  $command__ = Yii::app()->db->createCommand($sql__);
				  $result__ = $command__->queryAll(); 
															       	   
					if($result__!=null) 
					 { foreach($result__ as $r)
					     { $current_month = getMonth($r['income_date']);
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
		        
		    // Here to export to CSV 
	                if($this->isExportRequest()){
	                $this->exportCSV(array(Yii::t('app','Other incomes list: ')), null,false);
	                //$this->exportCSV($model, array_keys($model->attributeLabels()),false, 3);
	                $this->exportCSV($model->searchByMonth($current_month, $acad), array(
	                'idIncomeDescription.income_description',
					'Amount',
					//'income_date',
					'IncomeDate',
					//'academic_year',
					'created_by',
					'updated_by',)); 
	                }


         	}
            elseif($this->recettesItems==3)
		    {
		        $this->redirect(array('/billings/enrollmentIncome/index?part=rec&from=b'));
		
		      }
            elseif($this->recettesItems==4)
		    {
		        $this->redirect(array('/billings/reservation/index?part=rec&from=b'));
		
		      }


		$this->render('index',array(
			'model'=>$model,
		));
	}




	    //************************  getStudent($id) ******************************/
   public function getStudent($id)
	{
		
		$student=Persons::model()->findByPk($id);
        
			
		       if(isset($student))
				return $student->first_name.' '.$student->last_name;
		
	}
	
	
    // Export to CSV 
        public function behaviors() {
           return array(
               'exportableGrid' => array(
                   'class' => 'application.components.ExportableGridBehavior',
                   'filename' => Yii::t('app','otherIncomes.csv'),
                   'csvDelimiter' => ',',
                   ));
        }
     
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OtherIncomes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OtherIncomes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OtherIncomes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='other-incomes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	    	
	
	
	
	
	
	
	
	
}
 