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



class ContactInfoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_model;

	public $student_id;
	public $extern=false; //pou konn si c nan view apel kreyasyon an fet
	public $filledMessage=false;
	
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
        
        public function actionViewContact()
	{
             $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                          $group_name=$group->group_name;
            
			if($group_name=='Parent')	    
		      {  //get ID of selected child  
		         if(isset($_POST['Persons']))
		           {  $pers=$_POST['Persons']['id'];
		              
		               unset(Yii::app()->session['child']);
		              //set current child variable session
					   Yii::app()->session['child']=$pers;
		            	$this->student_id=$pers;	
		            		        	           
		           }
		           else
                     $this->student_id=Yii::app()->session['child'];
		        }
				
		$model=new ContactInfo;	
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
		// $this->performAjaxValidation($model);
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
			$model->attributes=$_POST['ContactInfo'];
			
			// fonksyon pou default profil
			
			
			$username=null;
			$name_explode=explode(" ",$model->contact_name);
			foreach($name_explode as $name)
			   $username=$username.strtolower($name);
			   
			$username=$username.'.'.$model->person;
			$full_name=ucwords($model->contact_name);
			
			if(($model->contact_name!="")&&($model->phone!=""))
			 {	
			 	
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
				   	if(isset($_GET['stud'])&&($_GET['stud']!=""))
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
				   	     
				   	 if($this->extern)
				   	   {   
				   	   	  $this->extern=false; 
				   	   	  if(isset($_GET['stud']))
                               $this->redirect(array('persons/viewForReport','id'=>$model->person,'pg'=>'lr','isstud'=>1,'from'=>'stud'));
                          elseif(isset($_GET['emp']))
                             $this->redirect(array('persons/viewForReport','id'=>$model->person,'pg'=>'lr','from'=>'emp'));
				   	   	 
				   	   }
				   	 else  //request made from the view
				   	   $this->redirect(array('view','id'=>$model->id));
					
				   }
			 }
			 else
			    $this->filledMessage=true;
			 
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
		$id_reference_lan=$model->person;
		
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
			$model->setAttribute('date_updated',date('Y-m-d'));
			if($model->save())
			  {	 if($is_parent==1)
			      { $name_explode=explode(" ",$model->contact_name);
					foreach($name_explode as $name)
					   $username=$username.strtolower($name);
					   
					$username_up=$username.'.'.$id_reference_lan;
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
			  	  $this->redirect(array('view','id'=>$model->id));
			  	  
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
		$this->loadModel()->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new ContactInfo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContactInfo']))
			$model->attributes=$_GET['ContactInfo'];
                
                // Here to export to CSV 
                if($this->isExportRequest()){
                $this->exportCSV(array(Yii::t('app','List of contact info: ')), null,false);
                
                $this->exportCSV($model->search(), array(
                'person0.last_name',
                'person0.first_name',
                'contact_name',
                'contactRelationship.relation_name',
                'profession',
                'phone',
                'address',
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
			//if($model===null)
            
	  	  return $model;
	   }
	

	
//************************  loadChildren($userName) ******************************/
	public function loadChildren($userName)
	{     
	      $acad=Yii::app()->session['currentId_academic_year']; 
		 $userid = null;
		 $code= array();
          $code[null]= Yii::t('app','-- Select --');
          
          $contact=null;
          
		 if(isset(Yii::app()->user->userid))
           $userid = Yii::app()->user->userid;
                            
           $contact_ID=ContactInfo::model()->getIdContactByUserID($userid);
	       $contact_ID= $contact_ID->getData();
					                    
			     foreach($contact_ID as $c)
					{  $contact= $c->id;
                       break;					
					}
			
			if($contact!=null)       
              {
                  $modelPerson= new Persons();
					   
					  $person=$modelPerson->findAll(array('alias'=>'p',
					                             'select'=>'p.id,p.first_name, p.last_name',
					                             'join'=>'left join contact_info c on(c.person=p.id)',
												 'condition'=>'p.is_student=1 AND p.active IN(1,2) AND (c.id=:contact OR c.one_more=:contact)',
												 'params'=>array(':contact'=>$contact),
										   ));
						
						 if(isset($person)){
						     foreach($person as $child)
							    $code[$child->id]= $child->first_name.' '.$child->last_name;
						   }	   
                }
                
                   		   
		return $code;
		
         
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
	
	// Action pour enregistrer dans le view 
	public function actionUpdateParent()
		{
			$es = new EditableSaver('ContactInfo');
			$es->update();
		}
}
