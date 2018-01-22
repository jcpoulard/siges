<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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




class ContactInfoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';

	
	public $use_contact;
	public $add;
	public $ch_name;
	public $search_set=false;
	public $old_id=0;
	public $contact_name='';
	public $contact_relationship='';
	public $profession='';
	public $phone='';
	public $address='';
	public $email='';
	
	public $contact;
	public $contact_id;
	public $extern=false; //pou konn si c nan view apel kreyasyon an fet
	public $filledMessage=false;
	public $alreadyExist=false;
	
	public $temoin_update=false;

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
	public function actionView()
	{  
	  if(isset($_GET['id']))
		{ 
			$this->render('view',array(
			'model'=>$this->loadModel($_GET['id']),
		  ));
		  
		}
		
	}
        
   

	public function actionViewContact()
	{   $model=new ContactInfo;
		$this->render('viewcontact',array(
			'model'=>$model,
		));
	}
        
    


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$moun_ou_reprezante='';
				
		
		$model=new ContactInfo;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		 
       if(isset($_GET['stud'])&&($_GET['stud']!=""))
           { $this->extern=true;
              $moun_ou_reprezante=$_GET['stud'];
           }
       elseif(isset($_GET['emp'])&&($_GET['emp']!=""))
           { $this->extern=true;
              $moun_ou_reprezante=$_GET['emp'];
           }
          else
            $this->extern=false;
       
		if(isset($_POST['ContactInfo']))
		{  
			//$model=new ContactInfo;
			$model->attributes=$_POST['ContactInfo'];
			
				   	         
		         if(isset($_POST['ContactInfo']['use_contact']))
			         {  $this->use_contact=$_POST['ContactInfo']['use_contact'];
			             
			             if($this->use_contact==1)
			                $this->old_id=$this->contact_id;
			         }
			     
			      if(isset($_POST['ContactInfo']['add']))
			         { $this->add=$_POST['ContactInfo']['add']; 
			         
			         }   
			         
	 if(isset($_POST['ContactInfo']['contact_name'])&&($_POST['ContactInfo']['contact_name']!=''))
	      {	$this->contact_id=$_POST['ContactInfo']['contact_name'];   
			          $this->search_set=true;
			          
			    $model=ContactInfo::model()->findByPk($this->contact_id);
	         
	         Yii::app()->session['Contact_ID'] = $this->contact_id;
	        
	      }
	      
	     	
	     	 
	      	
	if(isset($_POST['create']))
		{
				$pass=false;		
			
			if(($this->add==1)&&($this->use_contact==0))
			  {  
			  	 $model=new ContactInfo;
			  	 $model->attributes=$_POST['ContactInfo'];
			  	 
			 	if(($model->contact_name!=""))
			 	   {
					 	$username=null;
						
						$explode_contact_name=explode(" ",substr($model->contact_name,0));
            
				            if(isset($explode_contact_name[1])&&($explode_contact_name[1]!=''))
				              $username= strtolower( $explode_contact_name[0]).'_'.strtolower( $explode_contact_name[1]).$model->person;
				            else
				              $username= strtolower( $explode_contact_name[0]).$model->person;
                            

						$full_name=ucwords($model->contact_name);
					 }
			       
					    $model->setAttribute('date_created',date('Y-m-d'));
					    $model->setAttribute('create_by',Yii::app()->user->name);
						
						if($model->save())
						   {  
						   	  $group=Groups::model()->getGroupIdByName("Parent");
						   	  $group=$group->getData();
						   	  if(isset($group)&&($group!=''))
						   	     {  foreach($group as $g)
						   	            {
						   	            	$group_id=$g->id;
						   	            	}
						   	     	
						   	     	}
						   	     	
						   	   $profil=Profil::model()->getProfilIdByName("Guest");
						   	  $profil=$profil->getData();
						   	  if(isset($profil)&&($profil!=''))
						   	     {  foreach($profil as $prof)
						   	            {
						   	            	$profil_id=$prof->id;
						   	            	}
						   	     	
						   	     	}
						   	 //create login account for this contact if parent
						   	if(isset($_GET['from'])&&($_GET['from']=="stud"))
						   	   {  $create_by = Yii::app()->user->name;
			                            $password = md5("password");
			                            
			                            $command10 = Yii::app()->db->createCommand();
									    $command10->insert('users', array(
										  'username'=>$username,
										  'password'=>$password,
										  'full_name'=>$full_name,
										  'active'=>1,
										  'person_id'=>$model->person,
										  'profil'=>$profil_id,
										  'group_id'=>$group_id,
										  'is_parent'=>1,
										  'create_by'=>$create_by,
										  'date_created'=>date('Y-m-d'),
										  'date_updated'=>date('Y-m-d'),
												));
						   	     }
						   	     
						   	     
						   	  $pass=true;
						   	     
					
								
							   }
							   
							   
						 
						    
					    }
					 elseif(($this->add==0)&&($this->use_contact==1))
							 { 
							 	 $model=new ContactInfo;
							 	 
							 	 $create_by = Yii::app()->user->name;
                                  
	         
	                           $this->contact_id = Yii::app()->session['Contact_ID'];
	         
	                            $model_=ContactInfo::model()->findByPk($this->contact_id);
	                            
	                             
			                    $model->attributes=$_POST['ContactInfo'];
			                    
			                    $person=$model->person;
			                    //si person pachanje pa kitel save
			                    $this->alreadyExist=false;
			                    $check=ContactInfo::model()->checkPersonEtContact($person,$model_->contact_name);
			                    if(isset($check))
			                    $check=$check->getData();
			                  	
			                    if($check==null)
			                    {
				                    $model->setAttribute('contact_name',$model_->contact_name);
				                    $model->setAttribute('one_more',$model_->id);
				                    
				                    $model->setAttribute('profession',$model_->profession);
				                    $model->setAttribute('phone',$model_->phone);
				                    $model->setAttribute('address',$model_->address);
				                    $model->setAttribute('email',$model_->email);
				                    $model->setAttribute('create_by',$create_by);
				                    $model->setAttribute('date_created',date('Y-m-d'));
				                    
				                    			                            			                    
				                   if($model->save())
				                      {
				                      	 unset(Yii::app()->session['Contact_ID']);
				                      	 
				                      	 
									   	 $pass=true;
	
	
				                       }
				                       
			                     }
			                   else
			                    {	
			                    	
			                    	$this->contact_id = Yii::app()->session['Contact_ID'];
			                    	$this->search_set=true;
			         
			                        $model=ContactInfo::model()->findByPk($this->contact_id);
			                    	  $this->alreadyExist=true;
			                    
			                    }
			                         
			                          							   
							 }
						elseif(($this->add==0)&&($this->use_contact==0))
						{
							
				                $this->filledMessage=true;
							}

			          
			          
			                           if($pass)
			                             {
			                             		   	     
										   	 if($this->extern)
										   	   {   
										   	   	  $this->extern=false; 
										   	   	  if(isset($_GET['stud']))
						                               $this->redirect(array('persons/viewForReport','id'=>$model_->person,'pg'=>'lr','isstud'=>1,'from'=>'stud'));
						                          elseif(isset($_GET['emp']))
						                             $this->redirect(array('persons/viewForReport','id'=>$model_->person,'pg'=>'lr','from'=>'emp'));
										   	   	 
										   	   }
										   	 else  //request made from the view
										   	   {   
										   	      $from='';
										   	      $isstud='';
										   	      $pers='';
										   	      
										   	      
										   	        
										   	      if(isset($_GET['from']))
										   	        {
										   	          if(isset($_GET['pers']))
										   	             {  $pers=$_GET['pers'];
											   	        	if($_GET['from']=='stud')
										   	        	       $this->redirect(array('persons/viewForReport?id='.$pers.'&isstud=1&from='.$_GET['from'])); 
										   	        	    elseif($_GET['from']=='teach')
										   	        	          $this->redirect(array('persons/viewForReport?id='.$pers.'&isstud=0&from='.$_GET['from']));
										   	        	       else
										   	        	          $this->redirect(array('persons/viewForReport?id='.$pers.'&from='.$_GET['from']));
										   	             }
										   	             elseif(!isset($_GET['pers']))
											   	             { 
											   	             	if(isset($_GET['from']))
											   	        	       $this->redirect(array('contactInfo/index?from='.$_GET['from'])); 
											   	        	   
											   	             }
										   	        	          
										   	        }
										   	      
										   	   	 
										   	    
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
	public function actionUpdate()
	{
		$model=new ContactInfo;
		
	        
		$model=$this->loadModel();
		$id_contact_lan=$model->id;
		$id_reference_lan=$model->person;
		$name_contact=$model->contact_name;
		
		
		//kiyes referans sa ye?
		$reference_lan= Persons::model()->findByPk($id_reference_lan);
		$is_parent=$reference_lan->is_student;
		
		$this->temoin_update=true;
		$username='';
		
		
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['ContactInfo']))
		{
			$model->attributes=$_POST['ContactInfo'];
			
			
			$person=$model->person;
			
			if(isset($_POST['ContactInfo']['ch_name']))
			         { $this->ch_name=$_POST['ContactInfo']['ch_name']; 
			         
			         }


			
		if(isset($_POST['update']))
		   {
			 $model_=new ContactInfo;
			  	 $model_->attributes=$_POST['ContactInfo'];
			if($this->ch_name==1)
			  {  
			  	
			  	   
			                    //si person pachanje pa kitel save
			                    $this->alreadyExist=false;
			                    $check=ContactInfo::model()->checkPersonEtContact($person,$model_->contact_name);
			                    if(isset($check))
			                    $check=$check->getData();
			                  	
			                
                              
			 	if($check==null)
	                { 
			 	   	   $model->setAttribute('contact_name',$model_->contact_name);
						$model->setAttribute('person',$id_reference_lan);
						$model->setAttribute('contact_relationship',$model_->contact_relationship);
						$model->setAttribute('one_more',0);
			            $model->setAttribute('profession',$model_->profession);
			            $model->setAttribute('phone',$model_->phone);
			            $model->setAttribute('address',$model_->address);
			            $model->setAttribute('email',$model_->email);
						$model->setAttribute('date_updated',date('Y-m-d'));
						if($model->save())
						  {	 if($is_parent==1)
						      { 
								  $explode_contact_name=explode(" ",substr($model_->contact_name,0));
		            
						            if(isset($explode_contact_name[1])&&($explode_contact_name[1]!=''))
						              $username_up= strtolower( $explode_contact_name[0]).'_'.strtolower( $explode_contact_name[1]).$id_reference_lan;
						            else
						              $username_up= strtolower( $explode_contact_name[0]).$id_reference_lan;
						              
						              
								$full_name_up=ucwords($model_->contact_name);
								
								     $user=new User;
			                            $user = User::model()->findByAttributes(array('username'=>$username_up));
			                          
			                         if($user!=null)// on fait 1 update
			                           {
			                            
			                              $command2 = Yii::app()->db->createCommand();
				                          $command2->update('users', array(
															'username'=>$username_up,'full_name'=>$full_name_up,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name
														), 'id=:ID', array(':ID'=>$user->id));
			                            }
			                          else // enter 1 new record
			                            {
			                                  // c parent
			                            	  $group=Groups::model()->getGroupIdByName("Parent");
										   	  $group=$group->getData();
										   	  if(isset($group)&&($group!=''))
										   	     {  foreach($group as $g)
										   	            {
										   	            	$group_id=$g->id;
										   	            	}
										   	     	
										   	     	}
										   	     	
										   	   $profil=Profil::model()->getProfilIdByName("Guest");
										   	  $profil=$profil->getData();
										   	  if(isset($profil)&&($profil!=''))
										   	     {  foreach($profil as $prof)
										   	            {
										   	            	$profil_id=$prof->id;
										   	            	}
										   	     	
										   	     	}
			                            	                              
			                              $create_by = Yii::app()->user->name;
				                            $password = md5("password");
				                            
				                            $command10 = Yii::app()->db->createCommand();
										    $command10->insert('users', array(
											  'username'=>$username_up,
											  'password'=>$password,
											  'full_name'=>$full_name_up,
											  'active'=>1,
											  'person_id'=>$id_reference_lan,
											  'profil'=>$profil_id,
											  'group_id'=>$group_id,
											  'is_parent'=>1,
											  'create_by'=>$create_by,
											  'date_created'=>date('Y-m-d'),
											  'date_updated'=>date('Y-m-d'),
													));
											
			                             }  
								
						         }
						      
						  	  $this->temoin_update=false;
						  	  if(isset($_GET['pers'])&&($_GET['pers']!=''))
						  	    {  if($is_parent==1)
						               {   $this->redirect(array('persons/viewForReport','id'=>$_GET['pers'],'pg'=>'lr','pi'=>'no','isstud'=>1,'from'=>$_GET['from']));
						                 }
						              elseif($is_parent==0)
						                 {
						                    $this->redirect(array('persons/viewForReport','id'=>$_GET['pers'],'pg'=>'ci','from'=>$_GET['from']));
						     
						                    }
						  	    }
						  	  else
						  	    $this->redirect(array('view','id'=>$_GET['id'],'from'=>$_GET['from']));
						  }
			 	   }
			 	 else
			       {	
			           
			         
			            $model=ContactInfo::model()->findByPk($id_contact_lan);
			            $this->alreadyExist=true;
			              echo '';      
			           }
			           
			 	     
			  }
			elseif($this->ch_name==0) 
			   {
			   	  $model->setAttribute('contact_name',$name_contact);
						$model->setAttribute('person',$id_reference_lan);
						$model->setAttribute('contact_relationship',$model_->contact_relationship);
			            $model->setAttribute('profession',$model_->profession);
			            $model->setAttribute('phone',$model_->phone);
			            $model->setAttribute('address',$model_->address);
			            $model->setAttribute('email',$model_->email);
						$model->setAttribute('date_updated',date('Y-m-d'));
						if($model->save())
						  {	 if($is_parent==1)
						      { 
								 $explode_contact_name=explode(" ",substr($model->contact_name,0));
		            
						            if(isset($explode_contact_name[1])&&($explode_contact_name[1]!=''))
						              $username_up= strtolower( $explode_contact_name[0]).'_'.strtolower( $explode_contact_name[1]).$id_reference_lan;
						            else
						              $username_up= strtolower( $explode_contact_name[0]).$id_reference_lan;
						              
								$full_name_up=ucwords($model->contact_name);
								
								     $user=new User;
			                            $user = User::model()->findByAttributes(array('username'=>$username_up));
			                          
			                         if($user!=null)// on fait 1 update
			                           {
			                            
			                              $command2 = Yii::app()->db->createCommand();
				                          $command2->update('users', array(
															'username'=>$username_up,'full_name'=>$full_name_up,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name
														), 'id=:ID', array(':ID'=>$user->id));
			                            }
			                          else // enter 1 new record
			                            {
			                                  // c parent
			                            	  $group=Groups::model()->getGroupIdByName("Parent");
										   	  $group=$group->getData();
										   	  if(isset($group)&&($group!=''))
										   	     {  foreach($group as $g)
										   	            {
										   	            	$group_id=$g->id;
										   	            	}
										   	     	
										   	     	}
										   	     	
										   	   $profil=Profil::model()->getProfilIdByName("Guest");
										   	  $profil=$profil->getData();
										   	  if(isset($profil)&&($profil!=''))
										   	     {  foreach($profil as $prof)
										   	            {
										   	            	$profil_id=$prof->id;
										   	            	}
										   	     	
										   	     	}
			                            	                              
			                              $create_by = Yii::app()->user->name;
				                            $password = md5("password");
				                            
				                            $command10 = Yii::app()->db->createCommand();
										    $command10->insert('users', array(
											  'username'=>$username_up,
											  'password'=>$password,
											  'full_name'=>$full_name_up,
											  'active'=>1,
											  'person_id'=>$id_reference_lan,
											  'profil'=>$profil_id,
											  'group_id'=>$group_id,
											  'is_parent'=>1,
											  'create_by'=>$create_by,
											  'date_created'=>date('Y-m-d'),
											  'date_updated'=>date('Y-m-d'),
													));
											
			                             }  
								
						         }
						     
						  	  $this->temoin_update=false;
						  	  if(isset($_GET['pers'])&&($_GET['pers']!=''))
						  	    {  if($is_parent==1)
						               {   $this->redirect(array('persons/viewForReport','id'=>$_GET['pers'],'pg'=>'lr','pi'=>'no','isstud'=>1,'from'=>$_GET['from']));
						                 }
						              elseif($is_parent==0)
						                 {
						                    $this->redirect(array('persons/viewForReport','id'=>$_GET['pers'],'pg'=>'ci','from'=>$_GET['from']));
						     
						                    }
						  	    }
						  	  else
						  	    $this->redirect(array('view','id'=>$model->id,'from'=>$_GET['from']));
						  }
			   	
			   	} 
			  
			  //redireksyon
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
	
	
	
	// Action pour enregistrer dans le view 
	public function actionUpdateMyContacts()
		{
			$es = new EditableSaver('ContactInfo');
			$es->update();
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
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
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

   
   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'person0.active IN(1, 2) AND ';
						        }

      

		 
		 
		 if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			} 
		
		if(isset($_GET['from']))
	      { if($_GET['from']=='stud')
				{  $dataProvider =ContactInfo::model()->searchforStudent($condition,$acad_sess); 
				   $title = Yii::t('app','Contact list for').' '.Yii::t('app','Students');
				   
				   $model=new ContactInfo('searchforStudent');
					$model->unsetAttributes();  // clear any default values
					if(isset($_GET['ContactInfo']))
						$model->attributes=$_GET['ContactInfo'];
			                
			               			                
			    }     
		     elseif($_GET['from']=='teach')
				 {   $dataProvider = ContactInfo::model()->searchforTeacher($condition,$acad_sess);           
				     $title = Yii::t('app','Contact list for').' '.Yii::t('app','Teachers');
				   
				   $model=new ContactInfo('searchforTeacher');
					$model->unsetAttributes();  // clear any default values
					if(isset($_GET['ContactInfo']))
						$model->attributes=$_GET['ContactInfo'];
				     
				}     
		     elseif($_GET['from']=='emp')
				   {  $dataProvider= ContactInfo::model()->searchforEmployee($condition,$acad_sess);
				       $title = Yii::t('app','Contact list for').' '.Yii::t('app','Employees');
				   
				   $model=new ContactInfo('searchforEmployee');
					$model->unsetAttributes();  // clear any default values
					if(isset($_GET['ContactInfo']))
						$model->attributes=$_GET['ContactInfo'];
				   	
				   	}     
		     
	      }

		
				 // Here to export to CSV 
			                if($this->isExportRequest()){
			                $this->exportCSV(array($title), null,false);
			               
			                $this->exportCSV($dataProvider, array(
			                'person0.last_name',
			                'person0.first_name',
			                'contact_name',
			                'contactRelationship.relation_name',
			                'profession',
			                'address',
			                'phone',
			                'email',)); 
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
               'filename' => Yii::t('app','contactinfo.csv'),
               'csvDelimiter' => ',',
               ));
    }

	
	public function searchPersonById($studID)
	  {
	  	$model=Persons::model()->findByPk($studID);
			
            
	  	  return $model;
	   }
	
	
	
	
  public function loadModel()
	{
		
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=ContactInfo::model()->findByPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
		
	}

	/**
	 * Performs the AJAX validation.
	 * @param ContactInfo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contact-info-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
