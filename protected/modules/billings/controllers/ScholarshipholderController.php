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
class ScholarshipholderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $part = 'schhol';
	public $back_url ;
	public $is_internal;
	public $student_id;
        public $school_name = null;
        
        
        public $internal = array();
        public $feesLabel= array(); //
        public $is_full = null;
        public $number_row;
        
        public $student_name = null;

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

		
		$fee = NULL;
		
		$model=new ScholarshipHolder;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ScholarshipHolder']))
		{
			
			if(isset($_POST['ScholarshipHolder']['is_internal']))
			  {
                        $this->is_internal = $_POST['ScholarshipHolder']['is_internal'];
                        
                        if($this->is_internal == 1)
                         { 
                         	$school_name = infoGeneralConfig('school_name');
                                 	  $model->setAttribute('partner_name',$school_name);
                         	
                         	}
                 }
			
			$model->attributes=$_POST['ScholarshipHolder'];
			
			$this->student_id= $model->student;
			
			
			if(isset($_POST['create']))
             {
             	$error=0;
             	$fee = NULL;
             	
				if($this->is_internal == 1)
				  $model->setAttribute('partner', NULL);
				  
			    if(isset($_POST['ScholarshipHolder']['fee']))
			           {
                        $fee =  $_POST['ScholarshipHolder']['fee'];
                        }
			
				
				if($fee == NULL)
							   {  //fee pa ka null si gen lot bous sou lot fre deja ou si li gentan gen tranzaksyon deja 
								  $sql = "SELECT * FROM billings WHERE student=".$model->student." AND academic_year=".$acad_sess;
								  $command = Yii::app()->db->createCommand($sql);
								  $result = $command->queryAll();
								  
								  $sql_1 = "SELECT * FROM scholarship_holder WHERE student=".$model->student." AND academic_year=".$acad_sess;
								  $command_1 = Yii::app()->db->createCommand($sql_1);
								  $result_1 = $command_1->queryAll();
						   
						          if(($result==null)&&($result_1==null))
							        $model->setAttribute('fee', NULL);
								  else
									  $error=1;
							   }
							 else
							   $model->setAttribute('fee', $fee);
				
				
				  
				$duplicate_full_scholar = false;
				   
				    //return 0:false or 1:true
				    if($this->validateScholarship($this->student_id, $acad_sess)==0) //si l pa gen full bous deja
                          {
                            if($error==0)  
							  {    
							  	$bil_ = NULL;
							  	//tcheke si fre a/yo gen tranzaksyon sou li/yo deja
								  if($fee!=NULL)
								     $bil_ = Billings::model()->isFeeAlreadyUse($model->student,$fee, $acad_sess);
								  
							  if($bil_ !=NULL)
								{  
									 Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','We already have transaction(s) on this fee.'));
								}
							  else
							    {  
							  	    $percent =  $_POST['percent'];
				
									$model->setAttribute('percentage_pay', $percent);
									$model->setAttribute('academic_year', $acad_sess);
									$model->setAttribute('created_by', Yii::app()->user->name  );
								    $model->setAttribute('date_created', date('Y-m-d') );
								   
                                    $result_2=null;
	                                  
	                                  if($fee!=NULL)
	                                   {  $sql_2 = "SELECT * FROM scholarship_holder WHERE student=".$model->student." AND fee=".$fee." AND academic_year=".$acad_sess;
										  $command_2 = Yii::app()->db->createCommand($sql_2);
										  $result_2 = $command_2->queryAll();
	                                   }
						   
						          if($result_2==null)
								  {	
		                            if($model->save())
						               $this->redirect(array('index'));
								  }
							    }
							   							    
							    
							  }
				             elseif($error==1)
								 {
									 $message = Yii::t('app','This decision cannot be applied to all fees!');
								       Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
								 }  
				               
                          }else
                             {
                                $duplicate_full_scholar = true;
                             }
                             
                             
           if($duplicate_full_scholar){
                    $message = Yii::t('app','An error was occuring, probably a try to duplicate a full scholarship to a student !');
                    Yii::app()->user->setFlash(Yii::t('app','Error'), $message);
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
        
        

public function actionMassAddingScholarship()
  {
 
 	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

            $model = new ScholarshipHolder;
            $number_line = infoGeneralConfig('nb_grid_line');
            
            $sponsor = array();
            $fee = array();
            $percentage_pay = array();
            $duplicate_full_scholar = False;
            $error_report = False;
			
			$nbr_line =0;
            
            if(isset($_POST['student'])){
                $this->student_name = $_POST['student'];
            }else{
                $this->student_name = null;
            }
            
            if(isset($_POST['is_full']) && $_POST['is_full']==1)
			{
              if($this->student_name!='')		  
			    {  //tcheke si elev sa poko fe tranzakasyon menm ni lot bous pou aksepte full bous   
                      $sql = "SELECT * FROM billings WHERE student=".$this->student_name." AND academic_year=".$acad_sess;
                      $command = Yii::app()->db->createCommand($sql);
                      $result = $command->queryAll();
					  
					  $sql_1 = "SELECT * FROM scholarship_holder WHERE student=".$this->student_name." AND academic_year=".$acad_sess;
                      $command_1 = Yii::app()->db->createCommand($sql_1);
                      $result_1 = $command_1->queryAll();
					  
					  if(($result==null)&&($result_1==null))
                       {
						  $this->is_full = 1;
						  $this->number_row = 1;
						  $model->setAttribute('percentage_pay', 100);
					   }
					  else
						  {  $this->number_row = $number_line;
							  $message = Yii::t('app','He/She cannot have a full scholarship!');
                              Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
							  
						  }
				}
			   else
				   {
						$this->number_row = $number_line;
				   }
				
            }else{
                $this->is_full = 0;
                $this->number_row = $number_line;
            }
            
            for($i=0;$i<$this->number_row;$i++){
               
                $this->internal[$i]=0;
                if(isset($_POST['internal'.$i]) && $_POST['internal'.$i]==1){
                    $this->internal[$i] = 1;
                    $this->school_name = infoGeneralConfig('school_name');
                }else{
                    $this->internal[$i] = 0;
                }
              }
            
            if(isset($_POST['btnSave']))
			 {
                 //gad konbyen liy % la defini pou yo
				  for($i=0;$i<$this->number_row;$i++)
				    {  
				    	if($this->is_full == 0)
				    	  {  if(isset($_POST['percentage_pay'.$i])&&($_POST['percentage_pay'.$i]!=''))
						       $nbr_line++;
				    	  }
				    	 else
				    	    $nbr_line=1;
					 }
                
               for($j=0;$j<$this->number_row;$j++)
				{
                   //  echo '<br/><br/><br/>TEST _--------------> uuu';
                    if(isset($_POST['percentage_pay'.$j]) && $_POST['percentage_pay'.$j]!='')
					{
                       $error=0;
                       $fee[$j] = NULL;
                       
                        $model->setAttribute('student', $this->student_name);
                        
                        if(isset($_POST['partner'.$j]))
                         {
                           $sponsor[$j] = $_POST['partner'.$j];
                          }
                        
                        if(isset($_POST['fee'.$j])){
                            $fee[$j] = $_POST['fee'.$j];
                        }
                        
                        
                        $percentage_pay[$j] = $_POST['percentage_pay'.$j];
                        
                        if($this->internal[$j]==0){
                            $model->setAttribute('partner',$sponsor[$j]);
                            $model->setAttribute('is_internal', 0);
                        }else{
                            $model->setAttribute('partner',null);
                            $model->setAttribute('is_internal', 1); 
                        }
                        
                       /* if($this->is_full==1){
                            $model->setAttribute('fee',null);
                        }else{
                            $model->setAttribute('fee',$fee[$j]);
                        }
                       */ 
                        if(($fee[$j] == NULL)||($this->is_full==1))
							   {  //fee pa ka null si gen lot bous sou lot fre deja ou si li gentan gen tranzaksyon deja 
								  $sql = "SELECT * FROM billings WHERE student=".$model->student." AND academic_year=".$acad_sess;
								  $command = Yii::app()->db->createCommand($sql);
								  $result = $command->queryAll();
								  
								  $sql_1 = "SELECT * FROM scholarship_holder WHERE student=".$model->student." AND academic_year=".$acad_sess;
								  $command_1 = Yii::app()->db->createCommand($sql_1);
								  $result_1 = $command_1->queryAll();
						   
						          if(($result==null)&&($result_1==null))
							        $model->setAttribute('fee', NULL);
								  else
									  $error=1;
							   }
							 else
							   $model->setAttribute('fee', $fee[$j]);

                        //return 0:false or 1:true   
                        if($this->validateScholarship($this->student_name, $acad_sess)==0)//si l pa gen full bous deja
                          {							  
							  if($error==0)  
							  {  
							  	$bil_ = NULL;
							  	 //tcheke si fre a/yo gen tranzaksyon sou li/yo deja
								  if($fee[$j]!=NULL)
								    $bil_ = Billings::model()->isFeeAlreadyUse($model->student,$fee[$j], $acad_sess);
								  
							  if($bil_ !=NULL)
								{   $error=2;
								          
								}
							  else
							    {  
								  	$model->setAttribute('percentage_pay', $percentage_pay[$j]);
			                        $model->setAttribute('academic_year', $acad_sess);
			                        $model->setAttribute('date_created', date('Y-m-d H:m:s'));
			                        $model->setAttribute('create_by', Yii::app()->user->name);
									   
	                                  $result_2=null;
	                                  
	                                  if($fee[$j]!=NULL)
	                                   {  $sql_2 = "SELECT * FROM scholarship_holder WHERE student=".$model->student." AND fee=".$fee[$j]." AND academic_year=".$acad_sess;
											  $command_2 = Yii::app()->db->createCommand($sql_2);
											  $result_2 = $command_2->queryAll();
	                                   }
							   
							          if($result_2==null)
									  {
								  
										   if( ($this->is_full==1) || (($this->is_full==0)&&($fee[$j]!=NULL)&&($nbr_line >1)) || (($this->is_full==0)&&($nbr_line ==1)) ) 
											{  
												if($model->save()){
				 
											   }else
												 {
													$error_report = True;
												  }
											}
									  }
							    }
									  
							  }
							 elseif($error==1)
								 {
									 $message = Yii::t('app','This decision cannot be applied to all fees!');
								       Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
								 }
								 
								 
						     
								 
								  
                          }else
                             {
                                $duplicate_full_scholar = True;
                             }
                      }
                    $model->unsetAttributes();
                    $model = new ScholarshipHolder;
                }
                
                if($duplicate_full_scholar)
                  {
                    $message = Yii::t('app','An error was occuring, probably a try to duplicate a full scholarship to a student !');
                    Yii::app()->user->setFlash(Yii::t('app','Error'), $message);
                   }
                
                if($error_report)
                  {
                    $message = Yii::t('app','An error was occuring, probably a try to duplicate scholarship to a student !');
                    Yii::app()->user->setFlash(Yii::t('app','Error'), $message);
                  }
                  
                    if($nbr_line>1)  
                        $this->redirect(array('index'));
                    else
                      {
                      	     if($error==2)
                      	         Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','We already have transaction(s) on this fee.'));
                      	         
                      	     if($error==0)
                      	       $this->redirect(array('index'));
                      	}
                
            }
            
            
            $this->render('gridcreate',array('model'=>$model));
        }
        

        
   //return 0:false or 1:true        
        public function validateScholarship($student,$acad){
            $model = new ScholarshipHolder;
            $flag = 0;
            $scholar_ = $model->findAll(array('select'=>'student,fee, academic_year',
                'condition'=>'student=:std AND academic_year=:acad',
                'params'=>array(':std'=>$student,':acad'=>$acad),));
            
            if($scholar_!=null)
             {   
	                 $i=0;
	            foreach($scholar_ as $s)
	              {   $i++;
	                if($s->fee==null)
	                 {  
	                  $flag = 1;  
	                   }
	                
	              }
	               
	             if( ($i>1)&&($flag == 1) )
	                $flag = 0;
            }
            return $flag;
            
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
			$fee =NULL;
			
			$model=$this->loadModel($id);
			
		//tcheke si fre a/yo gen tranzaksyon sou li/yo deja
		  $fee_check = $model->fee;
		   $bil_ = Billings::model()->isFeeAlreadyUse($model->student,$fee_check, $acad_sess);
		  
		  if($bil_ !=NULL)
		    {   Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','This record is in used, it cannot be either updated nor deleted.'));
		        if(isset($_GET['from']))
					$this->redirect('../../../../view/id/'.$_GET['id'].'/from/v');
				else
					$this->redirect('../../index');
			}
		  else 
		    {
			
			     $this->is_internal = $model->is_internal;
			
					 if($this->is_internal == 1)
							 { 
								$school_name = infoGeneralConfig('school_name');
										  $model->setAttribute('partner_name',$school_name);
								
								}

				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);

				if(isset($_POST['ScholarshipHolder']))
				{
					if(isset($_POST['ScholarshipHolder']['is_internal']))
					  {
								$this->is_internal = $_POST['ScholarshipHolder']['is_internal'];
								
						 }

					if(isset($_POST['ScholarshipHolder']['fee']))
						$fee = $_POST['ScholarshipHolder']['fee'];
					
					   $model->attributes=$_POST['ScholarshipHolder'];
					
					  
					
						if(isset($_POST['update']))
						 {  $error=0;
						   
							if($this->is_internal == 1)
							  $model->setAttribute('partner', NULL);
							 					  
							  if($fee == NULL)
							   {  //fee pa ka null si gen lot bous sou lot fre deja ou si li gentan gen tranzaksyon deja 
								  $sql = "SELECT * FROM billings WHERE student=".$model->student." AND academic_year=".$acad_sess;
								  $command = Yii::app()->db->createCommand($sql);
								  $result = $command->queryAll();
								  
								  $sql_1 = "SELECT * FROM scholarship_holder WHERE student=".$model->student." AND academic_year=".$acad_sess;
								  $command_1 = Yii::app()->db->createCommand($sql_1);
								  $result_1 = $command_1->queryAll();
						   
						          if(($result==null)&&($result_1==null))
							        $model->setAttribute('fee', NULL);
								  else
									  $error=1;
							   }
							 else
							   $model->setAttribute('fee', $fee);
							   
							 if($error==0)  
							  {    $percent =  $_POST['percentage_pay'];
								   
									$model->setAttribute('percentage_pay', $percent);
									$model->setAttribute('updated_by', Yii::app()->user->name  );
									$model->setAttribute('date_updated', date('Y-m-d') );
								   
                                  $sql_2 = "SELECT * FROM scholarship_holder WHERE student=".$model->student." AND fee=".$fee." AND academic_year=".$acad_sess." AND id<>".$_GET['id'];
								  $command_2 = Yii::app()->db->createCommand($sql_2);
								  $result_2 = $command_2->queryAll();
						   
						          if($result_2==null)
								  {									  
									  if($model->save())
										$this->redirect(array('index'));
								  }
								  
							  }
							 elseif($error==1)
								 {
									 $message = Yii::t('app','This decision cannot be applied to all fees!');
								       Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
								 }
						
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


		$model=$this->loadModel($id);
			
		//tcheke si fre a/yo gen tranzaksyon sou li/yo deja
		  $fee_check = $model->fee;
		   $bil_ = Billings::model()->isFeeAlreadyUse($model->student,$fee_check, $acad_sess);
		  
		  if($bil_ !=NULL)
		    {   Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','This record is in used, it cannot be either updated nor deleted.'));
		       // $this->redirect('../../index');
			}
		  else 
		    {  $model->delete();

				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
				
			}
	}



	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		   
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


		
		 if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
                
        $model=new ScholarshipHolder('search_('.$acad_sess.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ScholarshipHolder']))
			$model->attributes=$_GET['ScholarshipHolder'];
			
	                    // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Scholarship holder: ')), null,false);
                            $this->exportCSV($model->search_($acad_sess), array(
                               
				//'id',
				'student0.fullName',
				'Partner',
				'Fee',
				'percentage_pay',
				'Amount',
				'IsInternal',
				'academicYear.name_period',
                )); 
		}

       $form = 'index';

       if(isset($_GET['from']))
		    $form = 'index_out';
		
		$this->render($form,array(
			'model'=>$model,
		));
	}


	public function actionIndex_exempt()
	{
		   
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


		
		 if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
                
        $model=new ScholarshipHolder('search_exemption('.$acad_sess.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ScholarshipHolder']))
			$model->attributes=$_GET['ScholarshipHolder'];
			
	                    // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Exemption list: ')), null,false);
                            $this->exportCSV($model->search_($acad_sess), array(
                               
				//'id',
				'student0.fullName',
				'Fee',
				'percentage_pay',
				'Amount',
				'IsInternal',
				'academicYear.name_period',
                )); 
		}

     
		$this->render('index_exempt',array(
			'model'=>$model,
		));
	}
	
	
public function actionExempt()
	{
		   
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
      
      $comment = Yii::t('app','This balance is exempted by {name}.',array('{name}'=> Yii::app()->user->name) ).' ('.date('Y-m-d').') ';
         
        $model=new ScholarshipHolder;
		
		//if(isset($_POST['ScholarshipHolder']['fee']))
		//				$fee = $_POST['ScholarshipHolder']['fee'];
		
		if(isset($_POST['ScholarshipHolder']))
		{
	        $model->attributes=$_POST['ScholarshipHolder'];

			$this->student_id= $model->student;
			
			if($model->comment!='')
			   $comment = $model->comment;
		
		
			if(isset($_POST['create']))
              { 
             	if(isset($_POST['chk']) )
             	  {
             	  	 foreach($_POST['chk'] as $fee_id) 
                      {  
                      	 $amount_exempted = 0;
                      	 $percentage_exempted = 100;
                      	 
                      	  $modelFee = Fees::model()->findByPk($fee_id);
                      	  
                      	  $fee_amount = $modelFee->amount;
                      	  
                      	  $amount_exempted = $modelFee->amount;
                      	 
                          $total_pay_on_fee= Fees::model()->getTotalAmountPayOnFee($this->student_id,$fee_id);
                                	
                           if($total_pay_on_fee!=0)  
                             {
                             	$amount_exempted = $fee_amount-$total_pay_on_fee;
                             	
                             	$percentage_paid = round( (($total_pay_on_fee * 100) / $fee_amount), 2);
                             	
                             	$percentage_exempted = 100 - $percentage_paid;
                             	
                             	 //met balans denye tranzaksyon an a 0, ajoute komante pou sa
                             	 //return a integer (id)
                                    $Last_transaction_id = Billings::model()->getLastTransactionIdByFeeId($this->student_id, $fee_id, $acad_sess);
                                    
                             	     $command_ = Yii::app()->db->createCommand();
								                 $command_->update('billings', array('fee_totally_paid'=>1,'balance'=>0,'comments'=>$comment ), 'id=:ID', array(':ID'=>$Last_transaction_id));
								                 
								                 
								                  
								         //met fee_totally_paid=1 pou tranzaksyon anvan yo
								           $command = Yii::app()->db->createCommand();
								                 $command->update('billings', array('fee_totally_paid'=>1 ), 'academic_year=:year AND fee_period=:fee AND student=:stud', array(':year'=>$acad_sess, ':fee'=>$fee_id, ':stud'=>$this->student_id));
                             	     
                             	      
                             	 
                             	  //retire % exempted a nan total balans li
                             	   $modelBalance=Balance::model()->findByAttributes(array('student'=>$this->student_id));
					                 $new_balance =0;
					                  if($modelBalance!=null)    
					                     {  $new_balance=$modelBalance->balance - $amount_exempted;
					                        
					                        $modelBalance->setAttribute('balance',  $new_balance);
															       	    
											$modelBalance->save();
															       	     
					                     }
                             	      
                             	      
                             	      
                             	       //ajoute l nan bousye ak komante %li pa peye a
                             	       $modelScholarshipHolder=new ScholarshipHolder;
		                                    $modelScholarshipHolder->setAttribute('student', $this->student_id);
		                                    $modelScholarshipHolder->setAttribute('partner', NULL);
		                                    $modelScholarshipHolder->setAttribute('fee', $modelFee->id);
		                                    $modelScholarshipHolder->setAttribute('is_internal', 1);
		                                    $modelScholarshipHolder->setAttribute('comment', $comment);
		                                    $modelScholarshipHolder->setAttribute('percentage_pay', $percentage_exempted);
											$modelScholarshipHolder->setAttribute('academic_year', $acad_sess);
											$modelScholarshipHolder->setAttribute('created_by', Yii::app()->user->name  );
										    $modelScholarshipHolder->setAttribute('date_created', date('Y-m-d') );
									  $modelScholarshipHolder->save();
                             	       
                             	 
                             	}
                             else
                               { // lanse reket delete liy sa nan billings
                                     $command0 = Yii::app()->db->createCommand();
	                                 $command0->delete('billings', 'student=:stud AND fee_period=:fee AND amount_pay=0 AND academic_year=:acad', array(':stud'=>$this->student_id,':fee'=>$fee_id,':acad'=>$acad_sess));
                               	    
                               	     
                               	     //retire % exempted a nan total balans li 
                               	     $modelBalance=Balance::model()->findByAttributes(array('student'=>$this->student_id));
					                  $new_balance =0;
					                  if($modelBalance!=null)    
					                     {  $new_balance=$modelBalance->balance - $amount_exempted;
					                        
					                        $modelBalance->setAttribute('balance',  $new_balance);
															       	    
											$modelBalance->save();
															       	     
					                     }
                               	     
                               	     
                               	     //ajoute l nan bousye ak komante
                               	     $modelScholarshipHolder=new ScholarshipHolder;
		                                    $modelScholarshipHolder->setAttribute('student', $this->student_id);
		                                    $modelScholarshipHolder->setAttribute('partner', NULL);
		                                    $modelScholarshipHolder->setAttribute('fee', $modelFee->id);
		                                    $modelScholarshipHolder->setAttribute('is_internal', 1);
		                                    $modelScholarshipHolder->setAttribute('comment', $comment);
		                                    $modelScholarshipHolder->setAttribute('percentage_pay', $percentage_exempted);
											$modelScholarshipHolder->setAttribute('academic_year', $acad_sess);
											$modelScholarshipHolder->setAttribute('created_by', Yii::app()->user->name  );
										    $modelScholarshipHolder->setAttribute('date_created', date('Y-m-d') );
									  $modelScholarshipHolder->save();
									  
                               	}   
                           
                           
                                
					  }
             	  	
             	  	
             	  	$this->redirect(array('index_exempt'));
             	  	
             	  }
             	             	
              }
             
           
           if(isset($_POST['cancel']))
             {
                $this->redirect(Yii::app()->request->urlReferrer);
             }
                          

		}
                      

		
		$this->render('exempt',array(
			'model'=>$model,
		));
	}




	public function loadStudentToExempt($criteria)
	{    $code= array();
		   
		    $persons=Persons::model()->findAll($criteria);
            
			
		    if(isset($persons))
			 {  
			    foreach($persons as $stud){
			        $code[$stud->id]= $stud->fullName." (".$stud->id_number.")";
		           
		           }
			 }
		   
		return $code;
         
	}

	//************************  getRoomByStudentId($id,$acad) ******************************/
	public function getRoomByStudentId($id,$acad)
	{
		$modelRoomH=new RoomHasPerson;
		
		//$acad=Yii::app()->session['currentId_academic_year']; 
		 
		$idRoom = $modelRoomH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id,':acad'=>$acad),
                               ));
		$room = new Rooms;
      if(isset($idRoom)){           
		   $result=$room->find(array('select'=>'id,room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			//foreach($room->room_name as $i)
						   

				if(isset($result))			   
					return $result;
				else
				return null;	
				
		  }
		  else
		    return null;
		
	}
	
	
//************************  getLevelByStudentId($id,$acad) ******************************/
	public function getLevelByStudentId($id, $acad)
	{
		//$acad=Yii::app()->session['currentId_academic_year']; 
		 
		$idRoom= $this->getRoomByStudentId($id, $acad);
		
	  if(isset($idRoom)){	
		$modelRoom=new Rooms;
		$idLevel = $modelRoom->find(array('select'=>'level',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$level = new Levels;
        if(isset($idLevel)){
		   $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel->level),
                               ));
                              
		       if(isset($result))
				    return $result;
			    else
				    return null;
				
		   }
		  else
		     return null;
				
		}
	  else
	      return null;
		
	}
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ScholarshipHolder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ScholarshipHolder']))
			$model->attributes=$_GET['ScholarshipHolder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}



 // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','scholarshipholder.csv'),
           'csvDelimiter' => ',',
           ));
        }



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ScholarshipHolder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ScholarshipHolder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ScholarshipHolder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='scholarship-holder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
