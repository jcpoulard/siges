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




class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_model;
	
	 public $back_url='';


	
	public $old_userName;
	public $old_userId;
	public $group_id;
	
	public $sortOption;
	public $person_;
    public $room;
	
	public $old_password = '';
	
	public $success=false;
	
	public $message_default_user_u = false;
	public $message_default_user_v = false;
	public $message_default_user = false;
	public $warning_message_for_master = false;
	
	
        public $message_global;
        
        
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
		$acad=Yii::app()->session['currentId_academic_year'];
		
		$this->message_default_user_v = false;
		
		 $model=$this->loadModel();
		 $active=$model->active;
		 $userName= $model->username;

	   if(isset($_POST['apply']))
		 { //on vient de presser le bouton 
		   
	        

      if(($model->id!=1)&&($model->id!=2))//if(($userName!="admin")&&($userName!="master_user")) //specific users
		  {   
		    if(($active==1)&&(!isset($_POST['active'])))// disable requested
		      {
		      	 
		      	 $profil=""; 
	      $path="";
		  
		
		 //update "active" to 0 and reset password to "password" in Users table
		 //$user=new User;
             
             $profil= $model->profil;
          
	           $password="password";
	            
	            $command0 = Yii::app()->db->createCommand();
	             $command0->update('users', array(
												'password'=>md5($password),'date_updated'=>date('Y-m-d'),'active'=>0,'update_by'=>Yii::app()->user->name
											), 'id=:ID', array(':ID'=>$model->id));
	             
	             	                            
			         
	
				 //update "active" in Persons table
				 if($model->is_parent==0)  //c n'est pas 1 parent                
		           {  
		           	 $modelPerson= Persons::model()->findByPk($model->person_id);
		           	  
		           	  $command = Yii::app()->db->createCommand();
				 
		           	
			      	
			      	    $command->update('persons', array(
												'active'=>0,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name
											), 'id=:ID', array(':ID'=>$modelPerson->id));
	             			      											
					   
			    
			       
		           }
		           
			     
			      $this->redirect(array('disableusers'));
		          		      	
		       } //fen disable request
		  
		    elseif(($active==0)&&(isset($_POST['active'])&&($_POST['active']==1))) // enable requested
		      {  
		      	 $profil=""; 
	             $path="";
		  
             $profil= $model->profil;
        
	           $password="password";
	            
	            $command0 = Yii::app()->db->createCommand();
	             $command0->update('users', array(
												'password'=>md5($password),'date_updated'=>date('Y-m-d'),'active'=>1,'update_by'=>Yii::app()->user->name
											), 'id=:ID', array(':ID'=>$model->id));
	             
	             	                            
			         
	
				 //update "active" in Persons table
				 if($model->is_parent==0)  //c n'est pas 1 parent                
		           {  
		           	 $modelPerson= Persons::model()->findByPk($model->person_id);
		           	  
		           	  $command = Yii::app()->db->createCommand();
				 
			      	
			      	    $command->update('persons', array(
												'active'=>1,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name
											), 'id=:ID', array(':ID'=>$modelPerson->id));
	             			      											
			    
			       
		           }
		           
			      
			      $this->redirect(array('disableusers'));

		       }
		    }//fen entediksyon user master_user
		   else
            {   $this->message_default_user_v = true;
		        // $this->redirect(array('index'));
                  	
             }

	   
	    }//fen isset($_POST['apply'])
	    

		
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
		$user=new User;
                $person = new Persons;
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['User']))
		{
                       
                            $user->attributes=$_POST['User'];
                            
                            $person->attributes=$_POST['Persons'];
                             
                             $full_name=$person->first_name.' '.$person->last_name;
                             
                             
                    $this->group_id = $user->group_id;
                          
                       if(isset($_POST['create']))
                          {
                            
                            
					               $user->setAttribute('password',$user->new_password);
					               $user->setAttribute('full_name',$full_name);
				                   $user->active = 1;
		                            $user->create_by = Yii::app()->user->name;
		                            $user->setAttribute('date_created',date('Y-m-d'));
		                            $user->setAttribute('date_updated',date('Y-m-d'));
		                            if($user->save())
						               $this->redirect(array('view','id'=>$user->id));
						               
				                  
                          }
                          
                        if(isset($_POST['cancel']))
                          {
                             
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }
                        
			
		}

		$this->render('create',array(
			'user'=>$user,
                        'person'=>$person,
                       
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	
	public function actionUpdate()
                
	{     $this->message_default_user_u = false;
			$this->message_default_user = false; 
			$this->warning_message_for_master = false; 
			
			
                
               
		$model=$this->loadModel();
		
		$this->old_userName= $model->username;
		$this->old_userId= $model->id;
		$this->group_id = $model->group_id;
		$this->old_password = $model->password;
		
         
         if(Yii::app()->user->userid!=2)
	      {  if(($model->id==2))      
	          { $this->message_default_user = true;
	             
	              $url=Yii::app()->request->urlReferrer;
	              
	              $explode_url= explode("?",substr($url,0));
	   		      	    if(isset($explode_url[1]))
			      	      {  
			      	      	$this->redirect(Yii::app()->request->urlReferrer.'&msguv=y');
			      	      	  
	                        }
			      	     else
			      	       $this->redirect($url.'?msguv=y');
			      	       
			      	       
	            }
	            
	       
          }
        else//if(Yii::app()->user->name=='master_user'), show a wning msg
           {
           	  if($this->old_userId==2)
           	       $this->warning_message_for_master = true;
           	
           	}                       
		
		
		// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);
		
			if(isset($_POST['User']))
			{
                    // $model->attributes=$_POST['User'];
                    
                    $this->group_id = $_POST['User']['group_id'];//$model->group_id;  
                    
                    $model->setAttribute('group_id',$this->group_id);
                   
                     
             if(isset($_POST['update']))
				{
						
                    $mod= new User;
                   
                   $mod->attributes=$_POST['User'];
	           	    
	           	    
	           	   		              
				          if(Yii::app()->user->userid!=2)
	      		            {    
				              if(($this->old_userId!=2))        
			                    {   	        								            
						            if(($mod->new_password!='')&&($mod->password_repeat!=''))
						              {  
						                 $model->attributes=$_POST['User'];
						                 $model->setAttribute('username',$this->old_userName);
						                 $model->setAttribute('password',$mod->new_password);
						                 //$model->setAttribute('group_id',$this->group_id);
						                 $model->setAttribute('profil',$mod->profil);
						                 
						                  if($model->save() )
											$this->redirect(array('view','id'=>$model->id));
			
			
						              
						              }
						            else
						               {  $command_user = Yii::app()->db->createCommand();
										  $command_user->update('users', array(
																'username'=>$this->old_userName,
																'group_id'=>$this->group_id,
																'profil'=>$mod->profil,
																				
																			), 'id=:ID', array(':ID'=>$model->id ));
																			
														 $this->redirect(array('view','id'=>$model->id));
						               }
						       

				                 
				                  }
				               else
			                     {   $this->message_default_user_u = true;
					               			                  	
			                  	   }
		                  	   
	      		              }
	      		            else//if(Yii::app()->user->userid==2),
				      		   {
				      		   	    	            
						            if(($mod->new_password!='')&&($mod->password_repeat!=''))
						              {  
						                 $model->setAttribute('username',$this->old_userName);
						                 $model->setAttribute('password',$mod->new_password);
						                 //$model->setAttribute('group_id',$this->group_id);
						                 $model->setAttribute('profil',$mod->profil);
						                 
						                  if($model->save() )
											$this->redirect(array('view','id'=>$model->id));
			
			
						              
						              }
						            else
						               {  $command_user = Yii::app()->db->createCommand();
										  $command_user->update('users', array(
																'username'=>$this->old_userName,
																'group_id'=>$this->group_id,
																'profil'=>$mod->profil,
																				
																			), 'id=:ID', array(':ID'=>$model->id ));
																			
														 $this->redirect(array('view','id'=>$model->id));
						               }
						       

				                 
						        				      		   	
				      		   	}//END Yii::app()->user-
			
		                  	   
		                
     
                 }
                 
                 if(isset($_POST['cancel']))
                          {
                              //$this->redirect(array($this->back_url));
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }

                 	
	         }
                
                    
	$this->render('update',array(
		'model'=>$model,
	));
}
	

public function actionUpdateUser()
        {
            $es = new EditableSaver('User');  //'User' is name of model to be updated
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
   			 
		
			$model=$this->loadModel();
	        
	        $userName= $model->username;
	        
	        $userID= $model->id;

            if(($userID!=2)&&($userID!=2))  //specific users      
               {  
                 $this->loadModel()->delete();
                 
               }
             

                    if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
			
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
        
        public function actionChangePassword(){
           //$id=$_GET['id'];
             
                    $user=$this->loadModel();
                    $this->performAjaxValidation($user);
                   
                    if(isset($_POST['update']))
                    {
                       // $mod= new User;
                   
	           	       $user->attributes=$_POST['User'];
	           	       $new_pass=$user->new_password;
	                 
	                 if(($user->new_password!='')&&($user->password_repeat!=''))
		                  $user->setAttribute('password',$new_pass);
		                  
		                    
		                    if($user->save())
		                      { $this->success = true;
		                        
		                        
		                      }
		               
                    }
    
  $this->render('changePassword',array(
		'model'=>$user,
	));  
        }
        
	public function actionIndex()
	{
		 if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			} 
		$this->person_='';
			
	 
	   if(isset($_POST['User']['sortOption']))
	     { $this->sortOption = $_POST['User']['sortOption'];
	         Yii::app()->session['user_sortOption']=$this->sortOption;
	     }
	     
	   
	  	           	
	           	
	
	   if(isset($_POST['User']['person_']))
	     {$this->person_ = $_POST['User']['person_'];
	         Yii::app()->session['user_person']=$this->person_;
	     }
	     
	     if(isset($_POST['User']['room']))
	      {   $this->room = $_POST['User']['room'];		
			   Yii::app()->session['user_room']=$this->room;
	        }
			
		$this->room = Yii::app()->session['user_room'];
		$this->person_ = Yii::app()->session['user_person'];	
	  $this->sortOption = Yii::app()->session['user_sortOption'];
			
  	
		if( ($this->sortOption==0) )	
		  {
		  	   Yii::app()->session['user_room']=null;
				Yii::app()->session['user_person']=null;	
	 			 Yii::app()->session['user_sortOption']=null;
	 			 
	              $this->room = '';
					$this->person_ = '';	
				  $this->sortOption = '';
				  
				  	$model=new User('search');
				  
					  $model->unsetAttributes();
					  if(isset($_GET['User']))
						{  
							$model->attributes=$_GET['User'];
						   
						}
						
		      $dataProvider = $model->search();
			     $array_sa = array(
									'full_name',
									'username',
									'group0.group_name');
									
									
		    }
		elseif($this->sortOption==1)	
		  { 
		  	if( ($this->person_!='')||($this->room!='') ) 	 
		  	  { 
		  	     
			     $model=new User('searchByCategorie('.$this->person_.','.$this->room.')');
				      $dataProvider = $model->searchByCategorie($this->person_,$this->room);
				     
					  $model->unsetAttributes();
					  if(isset($_GET['User']))
						{  
							$model->attributes=$_GET['User'];
						   
						}
						
				      if($this->person_==1)
				        {
				        	$array_sa = array(
											'full_name',
											'username',
											'group0.group_name');
				        	}
				       elseif($this->person_==0)
				          {
				          	$array_sa = array(
											'full_name',
											'username',
											//'profil0.profil_name',
											'group0.group_name');
				          	}
				          	
			  	    } 
			  	  else
			  	     {
			  	   Yii::app()->session['user_room']=null;
					Yii::app()->session['user_person']=null;	
		 			
		 			 
		              $this->room = '';
						$this->person_ = 0; //eleves	
					 
					  
			
					  $model=new User('searchByCategorie('.$this->person_.','.$this->room.')');
					  
					  $model->unsetAttributes();
					  if(isset($_GET['User']))
						{  
							$model->attributes=$_GET['User'];
						   
						}
						
				      $dataProvider = $model->searchByCategorie($this->person_,$this->room);
				     $array_sa = array(
										'full_name',
										'username',
										'group0.group_name');
										
										
			    }
		  	  
		   }
			
	
		
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of user: ')), null,false);
			
			 $this->exportCSV($dataProvider, $array_sa);
			                             
		}

        
		$this->render('index',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
		
   
     
	}
	
	
public function actionDisableusers()
	{
		$model=new User('searchDisableUsers');
		
		 if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			} 
	
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of disable user: ')), null,false);
			
			$this->exportCSV($model->searchDisableUsers(), array(
					'full_name',
					'username',
					'profilUser')); 
		}

		$this->render('disableusers',array(
			'model'=>$model,
		));
	}

	
	//************************  loadGroups() ******************************/
	public function loadGroups()
	{    	     $acad=Yii::app()->session['currentId_academic_year']; 
		$result ='';
		
		$groupid=Yii::app()->user->groupid;
		$group=Groups::model()->findByPk($groupid);
		
		
		$group_name=$group->group_name;
		
		if($group_name=='Administrateur systeme')
			$result = Yii::app()->db->createCommand("select id, group_name from groups where group_name not in('Direction','Economat','Economat ADM')"); 
		else 
		 $result = Yii::app()->db->createCommand("select id, group_name from groups");
       
	   $res    = $result->query();
	    

           $code= array();
		   
		    $code[null]= Yii::t('app','-- Select --');
		    foreach($res as $r){
			   
			    if(Yii::app()->user->userid==2)
			     { 
			     	$id=$r['id'];
			        $code[$id]= $r['group_name'];
			      }
			    else
			      {  
				      	$id=$r['id'];
				      	if($r['group_name']!='Developer')
				          $code[$id]= $r['group_name'];
			      	}
		           
		      }
		   
		return $code;
         
	}

  public function searchProfilByGroupID($groupID)
     {
     	
     	$acad=Yii::app()->session['currentId_academic_year']; 
		 
		  $id_profil ='';
          $modelGroup=Groups::model()->findByPk($groupID);
        
		    if(isset($modelGroup))
			 $id_profil = $modelGroup->belongs_to_profil;
			
				
		$modelProfil=Profil::model()->findByPk($id_profil);	
			
			$code= array();
				
			if(isset($modelProfil))
			  $code[$modelProfil->id]= $modelProfil->profil_name;
			      
			  

			  return $code;
     }

//************************  loadPersons ******************************/
	public function loadPersons()
	{     $code= array();
		   
		   $code[0]= Yii::t('app','Students');
		   $code[1]= Yii::t('app','Student\'s contacts');
		   //$code[2]= Yii::t('app','');
		          
		    		   
		return $code;
         
	}

	
	//************************  loadRoomByPerson($person) ******************************/
	public function loadRoomByPerson($person)
	{    	 $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel()
	{
        if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findByPk($_GET['id']); 
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation()
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
   
   /**
	 * Behavior to export data from grid to excel (CSV).
	 * 
	 */
public function behaviors() {
    return array(
        'exportableGrid' => array(
            'class' => 'application.components.ExportableGridBehavior',
            'filename' => Yii::t('app','user.csv'),
            'csvDelimiter' => ',',
            ));
}

public function actionChangeActif($id){
     $id=$_GET['id'];
                    $user=$this->loadModel($id);
                    $this->performAjaxValidation($user);
                    if(isset($_POST['update']))
                    {
                        
                   
                    $_POST['User']['password_repeat']=$user->password;
                  
                    $user->active = 0;
                    $user->save();
                    $this->redirect(array('view','id'=>$user->id));
                    }
    
  $this->render('changeActif',array(
		'model'=>$user,
	));  
}

public function actionViewOnlineUsers(){
    $user = new User;
    $this->render('onlineUsers',array('model'=>$user));
}
        
        
}
