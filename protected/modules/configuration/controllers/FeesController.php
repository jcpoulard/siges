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



class FeesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	public $part='curren'; //public $part='feeset';
	public $class_choose = null;
	
	
	public $message_u = false;

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
		

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

		
		$model=new Fees;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Fees']))
		{
                  
			$model->attributes=$_POST['Fees'];
			
			 if(isset($_POST['create']))
              {
				$model->setAttribute('academic_period',$acad_sess);
				$model->setAttribute('date_create',date('Y-m-d'));
				if($model->save())
				  {  
				  	$prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_fees = Fees::model()->search_($acad_sess);
 											$all_fees = $all_fees->getData();
 											foreach($all_fees as $f)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   }
								     	 if($prosper_marc_hilaire_poulard==1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'fees'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	   	} 

				  	 $this->redirect(array('fees/index',)); 
				  	
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



        public function actionMassAddingFees(){
            

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

		
            $model = new Fees;
            $number_line = infoGeneralConfig('nb_grid_line');
            $fee = array();
            $amount = array();
            $date_limit_payment = array();
            $description = array();
            
            $error_report = False;
            $j = 0;
            $fee_name = array();
            
            if(isset($_POST['level'])){
               $this->class_choose = $_POST['level'];
           }else{
               $this->class_choose = null;
           }
           
           if(isset($_POST['btnSave'])){
               for($i=0;$i<$number_line;$i++){
                   
                   if((isset($_POST['fee'.$i]) && $_POST['fee'.$i]!="")&&(isset($_POST['amount'.$i]) && $_POST['amount'.$i]!="")&&(isset($_POST['date_limit_payment'.$i])&&$_POST['date_limit_payment'.$i]!="")){
                       
                       $fee[$i] = $_POST['fee'.$i];
                       $amount[$i] = $_POST['amount'.$i];
                       $date_limit_payment[$i] = $_POST['date_limit_payment'.$i];
                       $description[$i] = $_POST['description'.$i];
                       
                       $model->setAttribute('level', $this->class_choose);
                       $model->setAttribute('fee', $fee[$i]);
                       $model->setAttribute('amount', $amount[$i]);
                       $model->setAttribute('date_limit_payment', $date_limit_payment[$i]);
                       $model->setAttribute('description', $description[$i]);
                       $model->setAttribute('academic_period',$acad_sess);
                       $model->setAttribute('date_create',date('Y-m-d'));
                       $model->setAttribute('create_by', Yii::app()->user->name);
                       
                       if($model->save()){
                           
                       }else{
                           $error_report = True;
                          // $string_fee = array();
                           if(FeesLabel::model()->findByPk($fee[$i])->fee_label!=null){
                               $fee_name[$j] = FeesLabel::model()->findByPk($fee[$i])->fee_label;
                           }else{
                               $fee_name[$j] = null;
                           }
                           
                           $j++;
                       }
                       
                       $model->unsetAttributes(); 
                       $model = new Fees;
                      
                       
                      
                   }
                   
               }
               
             $prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_fees = Fees::model()->search_($acad_sess);
 											$all_fees = $all_fees->getData();
 											foreach($all_fees as $f)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   }
								     	 if($prosper_marc_hilaire_poulard==1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'fees'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	   	} 
  
               
               
               if($error_report){
                    $liste_fee = "";
                  for($i=0; $i<count($fee_name); $i++){
                      $liste_fee .= $fee_name[$i].'<br/>';
                  }
                    $message=Yii::t('app',"At least {name} error(s) occured when you saved fees !<br/> The following fees were about to be duplicate :<br/><b> {feeName}</b>",array('{name}'=>$j,'{feeName}'=>$liste_fee));
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
        
        
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

		$this->message_u = false;
		
		$model=$this->loadModel($id);
		
		$is_payment_started=  Fees::model()->isPaymentStarted($id,$acad_sess);//return TRUE if payment is already started and FALSE if not
		
		if($is_payment_started)        
	          { $this->message_u = true;
	             
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
		 $this->performAjaxValidation($model);

		if(isset($_POST['Fees']))
		{
                      
			$model->attributes=$_POST['Fees'];
			
			 if(isset($_POST['update']))
              {
				$model->setAttribute('academic_period',$acad_sess);
				$model->setAttribute('date_update',date('Y-m-d'));
				if($model->save())
					$this->redirect(array('fees/index',)); 
					
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
        
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 

        
		
		try {
   			   $this->message_u = false;
   			    $is_payment_started=  Fees::model()->isPaymentStarted($id,$acad_sess);//return TRUE if payment is already started and FALSE if not
		
					if($is_payment_started)        
				        { $this->message_u = true;
		             
				              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI']; 
				              
				              $explode_url= explode("?",substr($url,0));
				            if(isset($_GET['ajax']))
				            {
			   		      	    if(isset($explode_url[1]))
					      	      {  
					      	      	$this->redirect(Yii::app()->request->urlReferrer.'&msguv=y');
					      	      	  
			                     }
					      	    else
					      	       $this->redirect($url.'?msguv=y');
				            }
			      	       
			      	   }
			      	else
			      	  {  
			      	      $modelFee = $this->loadModel($id);
			      	      
			      	      //update balance cumulee
						  
						  //jwenn tout elev kap peye fre sa
						  $modelStud = Billings::model()->findByAttributes(array('fee_period'=>$id,'academic_year'=>$acad_sess));
						  //update tab balance lan
						  if($modelStud !=null)
						   {
						   	 foreach($modelStud as $stud)
						   	  {   
							      $modelBalance=Balance::model()->findByAttributes(array('student'=>$stud->student));
								   if($modelBalance!=null)
									 {   
									 	$balance = $modelBalance->balance - $$modelFee->amount;
									 	
									 	$modelBalance->setAttribute('balance',$balance);
									 	$modelBalance->save();
									 	
									 	unset($modelBalance);
									 	
									   }
						   	   }
						   }
	
						  $modelFee->delete();
			      	  }
			      	    
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			       
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}


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
            
                $model=new Fees('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Fees']))
			$model->attributes=$_GET['Fees'];
                
                // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of fees: ')), null,false);
                            $this->exportCSV($model->search(), array(
				'fee0.fee_label',
				'Amount',
				'level0.level_name',
				'academicPeriod.name_period',
				'devise0.devise_name',
                                'dateLimit',
				'description')); 
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
           'filename' => Yii::t('app','fees.csv'),
           'csvDelimiter' => ',',
           ));
}        
        
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Fees the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Fees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Fees $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='fees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
