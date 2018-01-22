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




class MailsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
      
       public $groupemail; 
       public $roomemail; 
       public $back_url='';
       public $mail_id;
       public $message_;
       public $sender_;
       public $subject_; 
       public $teacher_id;
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
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','batchemail','mailbox','batchMailStudent'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
        
        
        public function actionBatchMailStudent(){
                 $model = new Mails;
                 $acad=Yii::app()->session['currentId_academic_year'];
                 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
                 $pers=$pers->getData();
                 foreach($pers as $p){
                                $this->teacher_id = $p->id;
                                }
            if(isset($_POST['Mails']))
		{
                
                
              
            $model_teacher = Persons::model()->findByPk($this->teacher_id);
            
            if($model_teacher->email!=null && $model_teacher->email!=''){
                    if(isset($_POST['Mails']['group_email'])){
                        $this->groupemail = $_POST['Mails']['group_email'];
                        if(isset($_POST['create'])){
                            $subject_email = $_POST['Mails']['subject'];
                            $text_email = $_POST['Mails']['message'];
                            $string_sql = "SELECT p.id, p.email, p.last_name, p.first_name FROM persons p join room_has_person rh on (p.id = rh.students) where rh.room = $this->groupemail and rh.academic_year = $acad and p.email is not null";    
                            $student_data = Persons::model()->findAllBySql($string_sql); 
                        foreach($student_data as $sd){
                            if($sd->email!=''){
                                 $model->setAttribute('sender', $model_teacher->email);
                                 $model->setAttribute('receivers', $sd->email);
                                 $model->setAttribute('subject', $subject_email);
                                 $model->setAttribute('message', $text_email);
                                 $model->setAttribute('is_read', 0);
                                 $model->setAttribute('is_delete', 0); 
                                 $model->setAttribute('id_sender',$model_teacher->id);
                                 $model->setAttribute('is_my_send',$model_teacher->id);
                                 $model->setAttribute('sender_name',$model_teacher->fullName);
                                 if($model->save()){
                                       // Prepare le mail : Le nom et l'entete 
                                $name='=?UTF-8?B?'.base64_encode($model_teacher->first_name.' '.$model_teacher->last_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_email).'?=';
				$headers="From: $name <{$model_teacher->email}>\r\n".
					"Reply-To: {$model_teacher->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail 
                                       
				mail($sd->email,$subject,$text_email,$headers);
                                // Redirection vers la page d'ou l'on vient
                                    
                                 }
                            }
                            
                            $model->unSetAttributes();
                            $model= new Mails();
                        }
                        Yii::app()->user->setFlash(Yii::t('app','Success'), Yii::t('app',"Email successfully sent to this class!")); 
                    }
                
                    }  
                    
               }
                else{
                Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app',"You don't have an email setup, please update your personal info with a valid email address!"));
                $this->redirect(Yii::app()->baseUrl."/index.php/academic/persons/viewForUpdate?id=$this->teacher_id&from=user");
                }
                
        }
                
                
                
            
            $this->render('createbatchmailstudent',array(
			'model'=>$model,
                        
		));
        }
        
        public function actionBatchemail(){
            $temwen = 0;
            $model = new Mails;
            $email_string=null;
            $gc = GeneralConfig::model()->findAll();
                $email = null;
                $school_name = null;
                foreach($gc as $c){
                    if($c->item_name == "school_email_address"){
                        $email = $c->item_value;
                    }
                    if($c->item_name == "school_name"){
                        $school_name = $c->item_value;
                    }
                    
                    
                }
           
                if(isset($_POST['Mails']))
		{
                    if(isset($_POST['Mails']['group_email'])){
                        $this->groupemail = $_POST['Mails']['group_email'];
                    }
                    
                    $people_ = Persons::model()->findAll();
                    $sql_contact_stud = "SELECT c.person, c.email, c.contact_name, p.last_name, p.is_student from  contact_info c Inner join persons p on (c.person = p.id) where p.is_student = 1";
                    $person_reponsable = ContactInfo::model()->findAllBySQL($sql_contact_stud);
                    $acad=Yii::app()->session['currentId_academic_year']; 
                   
                    
            
            
                if(isset($_POST['create'])){
                    
                // Send mail to all students (Broadcast student) 
                // Al active student during the current academic year will receive the mail
                if($this->groupemail==7){
                
                $subject_email = $_POST['Mails']['subject'];
                $text_email = $_POST['Mails']['message'];
                
                
                //Debut de la transaction 
                
            
                foreach($people_ as $st){
                    $transaction = Yii::app()->db->beginTransaction();
                  try { 
                   
                    if(($st->active==1 || $st->active == 2) && $st->is_student == 1 ){
                        if($st->email != null && $st->email != ""){
                         
                       
                        $email_string = $st->email; // Add all email to become a string
                        
                         $model->setAttribute('sender', $email);
                         $model->setAttribute('receivers', $email_string);
                         $model->setAttribute('subject', $subject_email);
                         $model->setAttribute('message', $text_email);
                         $model->setAttribute('is_read', 0);
                         $model->setAttribute('is_delete', 0);
                         
			if($model->save()) {
                            
                                // Prepare le mail : Le nom et l'entete 
                            $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_email).'?=';
				$headers="From: $name <{$email}>\r\n".
					"Reply-To: {$email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail 
                                       
				mail($email_string,$subject_email,$text_email,$headers);
                                // Redirection vers la page d'ou l'on vient
                                
                        }
                        
                        }
                    }
                    $transaction->commit();
                    }//
            catch (CDbException $e) { // Exception
                $temwen=1;
              
                $transaction->rollBack();
                // other actions to perform on fail (redirect, alert, etc.)
            } 
                    
                    $model->unSetAttributes();
                    $model= new Mails();
                }
            
                Yii::app()->user->setFlash(Yii::t('app','Batch'), Yii::t('app','Email send successfully to all active student!'));
                $this->redirect(array('/academic/mails/batchemail?from=stud'));
                                   
                }
                // Send email to all Employees who have a title save in the DB 
                
                if($this->groupemail==1){
                
                $subject_email = $_POST['Mails']['subject'];
                $text_email = $_POST['Mails']['message'];
                
                $temwen = 0;
                foreach($people_ as $emp){
                    
                 
                   
                    if(($emp->active==1 || $emp->active == 2) && $emp->titles!=null){
                        if($emp->email != null && $emp->email != ""){
                         
                       
                        $email_string = $emp->email; // Add all email to become a string
                        
                         $model->setAttribute('sender', $email);
                         $model->setAttribute('receivers', $email_string);
                         $model->setAttribute('subject', $subject_email);
                         $model->setAttribute('message', $text_email);
                         $model->setAttribute('is_read', 0);
                         $model->setAttribute('is_delete', 0);
                         
			if($model->save()) {
                            
                                // Prepare le mal : Le nom et l'entete 
                            $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_email).'?=';
				$headers="From: $name <{$email}>\r\n".
					"Reply-To: {$email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($email_string,$subject_email,$text_email,$headers);
                                // Redirection vers la page d'ou l'on vient
                                
                        }
                        
                        }
                    }
                    $model->unSetAttributes();
                    $model= new Mails();
                }
                Yii::app()->user->setFlash(Yii::t('app','Batch'), Yii::t('app','Email send successfully to all employees!'));
                $this->redirect(array('/academic/mails/batchemail?from=stud'));
                                   
                }
                // Les profs 
                if($this->groupemail==2){ 
                
                $subject_email = $_POST['Mails']['subject'];
                $text_email = $_POST['Mails']['message'];
                
                $temwen = 0;
                foreach($people_ as $prof){
                   
                 
                    
                    if(($prof->active==1 || $prof->active == 2) && $prof->courses!=null){
                        if($prof->email != null && $prof->email != ""){
                         
                       
                        $email_string = $prof->email; // Add all email to become a string
                        
                         $model->setAttribute('sender', $email);
                         $model->setAttribute('receivers', $email_string);
                         $model->setAttribute('subject', $subject_email);
                         $model->setAttribute('message', $text_email);
                         $model->setAttribute('is_read', 0);
                         $model->setAttribute('is_delete', 0);
                         
			if($model->save()) {
                            
                                // Prepare le mal : Le nom et l'entete 
                            $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_email).'?=';
				$headers="From: $name <{$email}>\r\n".
					"Reply-To: {$email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($email_string,$subject_email,$text_email,$headers);
                                // Redirection vers la page d'ou l'on vient
                                
                        }
                        
                        }
                    }
                    $model->unSetAttributes();
                    $model= new Mails();
                }
                Yii::app()->user->setFlash(Yii::t('app','Batch'), Yii::t('app','Email send successfully to all teachers!'));
                $this->redirect(array('/academic/mails/batchemail?from=stud'));
                                   
                }
                // Send emails to : Students, employees and teachers
                 if($this->groupemail==5){
                
                $subject_email = $_POST['Mails']['subject'];
                $text_email = $_POST['Mails']['message'];
                
                $temwen = 0;
                foreach($people_ as $pers){
                   
                 
                   
                    if(($pers->active==1 || $pers->active == 2)){
                        if($pers->email != null && $pers->email != ""){
                         
                       
                        $email_string = $pers->email; // Add all email to become a string
                        
                         $model->setAttribute('sender', $email);
                         $model->setAttribute('receivers', $email_string);
                         $model->setAttribute('subject', $subject_email);
                         $model->setAttribute('message', $text_email);
                         $model->setAttribute('is_read', 0);
                         $model->setAttribute('is_delete', 0);
                         
			if($model->save()) {
                            
                                // Prepare le mal : Le nom et l'entete 
                            $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_email).'?=';
				$headers="From: $name <{$email}>\r\n".
					"Reply-To: {$email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($email_string,$subject_email,$text_email,$headers);
                                // Redirection vers la page d'ou l'on vient
                                
                        }
                        
                        }
                    }
                    $model->unSetAttributes();
                    $model= new Mails();
                }
                Yii::app()->user->setFlash(Yii::t('app','Batch'), Yii::t('app','Email send successfully to all school persons!'));
                $this->redirect(array('/academic/mails/batchemail?from=stud'));
                                   
                }
                
                // Broadcast personne responsable 
                    if($this->groupemail==6){
                
                $subject_email = $_POST['Mails']['subject'];
                $text_email = $_POST['Mails']['message'];
                
                $temwen = 0;
                foreach($person_reponsable as $persr){
                    
                   
                   
                        if($persr->email != null && $persr->email != ""){
                         
                       
                        $email_string = $persr->email; // Add all email to become a string
                        
                         $model->setAttribute('sender', $email);
                         $model->setAttribute('receivers', $email_string);
                         $model->setAttribute('subject', $subject_email);
                         $model->setAttribute('message', $text_email);
                         $model->setAttribute('is_read', 0);
                         $model->setAttribute('is_delete', 0);
                         
			if($model->save()) {
                            
                                // Prepare le mal : Le nom et l'entete 
                            $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_email).'?=';
				$headers="From: $name <{$email}>\r\n".
					"Reply-To: {$email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($email_string,$subject_email,$text_email,$headers);
                                // Redirection vers la page d'ou l'on vient
                                
                        }
                        
                        }
                    
                    $model->unSetAttributes();
                    $model= new Mails();
                }
                Yii::app()->user->setFlash(Yii::t('app','Batch'), Yii::t('app','Email send successfully to all students contatct!'));
                $this->redirect(array('/academic/mails/batchemail?from=stud'));
                                   
                }
                // Send email to all students for specific rooms 
                    if($this->groupemail==3){
                        
                        if(isset($_POST['Mails']['room_email'])){
                        $this->roomemail = $_POST['Mails']['room_email'];
                        }
                        $sql_room_st = "SELECT p.id, p.email, p.active, p.is_student, r.students, r.room, r.academic_year  FROM persons p inner join room_has_person r on (r.students = p.id) where r.room =".$this->roomemail." AND r.academic_year = ".$acad."";
                        $stud_email_ = Persons::model()->findAllBySql($sql_room_st);
                
                $subject_email = $_POST['Mails']['subject'];
                $text_email = $_POST['Mails']['message'];
                
                
                foreach($stud_email_ as $stud_){
                    
                    
                    if(($stud_->active==1 || $stud_->active == 2) && $stud_->is_student == 1 ){
                        if($stud_->email != null && $stud_->email != ""){
                         
                       
                        $email_string = $stud_->email; // Add all email to become a string
                        
                         $model->setAttribute('sender', $email);
                         $model->setAttribute('receivers', $email_string);
                         $model->setAttribute('subject', $subject_email);
                         $model->setAttribute('message', $text_email);
                         $model->setAttribute('is_read', 0);
                         $model->setAttribute('is_delete', 0);
                         
			if($model->save()) {
                            
                                // Prepare le mal : Le nom et l'entete 
                            $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_email).'?=';
				$headers="From: $name <{$email}>\r\n".
					"Reply-To: {$email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($email_string,$subject_email,$text_email,$headers);
                                // Redirection vers la page d'ou l'on vient
                                
                        }
                        
                        }
                    }
                    
                    $model->unSetAttributes();
                    $model= new Mails();
                }
                Yii::app()->user->setFlash(Yii::t('app','Batch'), Yii::t('app','Email send successfully to the students of this room !'));
                $this->redirect(array('/academic/mails/batchemail?from=stud'));
                                   
                } 
                
                // Send to all parents by rooms 
                            if($this->groupemail==4){
                        
                        if(isset($_POST['Mails']['room_email'])){
                        $this->roomemail = $_POST['Mails']['room_email'];
                        }
                        $sql_room_parent = "SELECT c.person, c.email, c.contact_name, p.last_name, p.is_student, r.room from  contact_info c Inner join persons p on (c.person = p.id) Inner Join room_has_person r on (r.students = p.id) where p.is_student = 1 AND r.room =".$this->roomemail;
                        $parent_email_ = ContactInfo::model()->findAllBySql($sql_room_parent);
                
                $subject_email = $_POST['Mails']['subject'];
                $text_email = $_POST['Mails']['message'];
                
                
                foreach($parent_email_ as $parent_){
                    
                    
                    
                        if($parent_->email != null && $parent_->email != ""){
                         
                       
                        $email_string = $parent_->email; // Add all email to become a string
                        
                         $model->setAttribute('sender', $email);
                         $model->setAttribute('receivers', $email_string);
                         $model->setAttribute('subject', $subject_email);
                         $model->setAttribute('message', $text_email);
                         $model->setAttribute('is_read', 0);
                         $model->setAttribute('is_delete', 0);
                         
			if($model->save()) {
                            
                                // Prepare le mal : Le nom et l'entete 
                            $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_email).'?=';
				$headers="From: $name <{$email}>\r\n".
					"Reply-To: {$email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($email_string,$subject_email,$text_email,$headers);
                                // Redirection vers la page d'ou l'on vient
                                
                        }
                        
                        }
                    
                    
                    $model->unSetAttributes();
                    $model= new Mails();
                }
                Yii::app()->user->setFlash(Yii::t('app','Batch'), Yii::t('app','Email send successfully to the parents of this room !'));
                $this->redirect(array('/academic/mails/batchemail?from=stud'));
                                   
                }
                
                
            }       
        }
            
            $this->render('createbatchemail',array(
			'model'=>$model,
                        
		));
        }

        
        public function actionMailbox(){
            $model = new Mails;
           
            $ok=false;
            $loc_;
            if(isset($_POST['btn_trash'])){
                
                if(isset($_POST['chk'])) {
                 
                       foreach($_POST['chk'] as $mail)
                         {  
                            $this->mail_id = $mail;
                            $model =  Mails::model()->findbyPk($this->mail_id);
                            if(isset($_GET['loc'])&&$_GET['loc']=='del'){
                                $model->setAttribute('is_delete',2);
                                $loc_= "del";
                            }
                            if(isset($_GET['loc'])&&$_GET['loc']=='inb'){
                                $model->setAttribute('is_delete',1);
                                $loc_ = "inb";
                                }
                            if(isset($_GET['loc'])&&$_GET['loc']=='sent'){
                                $model->setAttribute('is_delete',1);
                                $loc_ = "sent";
                                }
                            if($model->save()){
                               $model->unSetAttributes();
                               $model = new Mails;
                               $ok=true;
                            }
                         }
                     if($ok){
                   Yii::app()->user->setFlash(Yii::t('app','Trashes'), Yii::t('app','Mails delete with success! '));
                 
                   $this->redirect(array("/academic/mails/mailbox/mn/std/from/stud/?loc=$loc_"));
                   
               }     
                      }
              }
               
             if(isset($_POST['trash_readmail'])){
                  if(isset($_GET['id'])){
                   
                    $this->mail_id = $_GET['id'];
                    $model =  Mails::model()->findbyPk($this->mail_id);
                    if(isset($_GET['from1'])&&$_GET['from1']=='inb'){
                    $model->setAttribute('is_delete',1);
                    if($model->save()){
                        Yii::app()->user->setFlash(Yii::t('app','Trashes'), Yii::t('app','This Mail is delete with success! '));
                        $this->redirect(array("/academic/mails/mailbox/mn/std/from/stud/?loc=inb")); 
                    }
                    }
                    if(isset($_GET['from1'])&&$_GET['from1']=='sent'){
                    $model->setAttribute('is_delete',1);
                    if($model->save()){
                        Yii::app()->user->setFlash(Yii::t('app','Trashes'), Yii::t('app','This Mail is delete with success! '));
                        $this->redirect(array("/academic/mails/mailbox/mn/std/from/stud/?loc=sent")); 
                    }
                    }
                    
                    if(isset($_GET['from1'])&&$_GET['from1']=='del'){
                    $model->setAttribute('is_delete',1);
                    if($model->save()){
                        Yii::app()->user->setFlash(Yii::t('app','Trashes'), Yii::t('app','This Mail was complete delete from trashes! '));
                        $this->redirect(array("/academic/mails/mailbox/mn/std/from/stud/?loc=del")); 
                    }
                  }
                  
             }
         }
         //Compose an email to send to one or more person 
         
         if(isset($_GET['loc']) && $_GET['loc'] == 'comp'){
         if(isset($_POST['Mails'])){ // Verifie que POST['Mails']
             if(isset($_POST['create'])){
                 
                $model = new Mails; 
                 // Take the user id in table users 
                $user_id = Yii::app()->user->userid;
                // Get the id person 
                $person_ = Persons::model()->getIdPersonByUserID($user_id)->getData();
                $sender_mail; 
                $sender_name; 
                $id_sender;
                
            foreach ($person_ as $p){
                $sender_mail = $p->email;
                $sender_name = $p->first_name.' '.$p->last_name;
                $id_sender = $p->id;
            }
            $model->attributes=$_POST['Mails'];
            $receiv_mail = $_POST['Mails']['receivers'];
            $message_mail = $_POST['Mails']['message'];
            $subject_mail = $_POST['Mails']['subject'];
            $receiv_tab = explode(",", $receiv_mail);
           
            
            foreach($receiv_tab as $r){
               
            $model->setAttribute('receivers', $r);    
            $model->setAttribute('sender', $sender_mail);
            $model->setAttribute('sender_name', $sender_name);
            $model->setAttribute('is_read', 0);
            $model->setAttribute('id_sender', $id_sender);
            $model->setAttribute('is_delete', 0);
            $model->setAttribute('is_my_send', $id_sender);
            
            if($model->save()){
          
            $name='=?UTF-8?B?'.base64_encode($sender_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($subject_mail).'?=';
				$headers="From: $name <{$sender_mail}>\r\n".
					"Reply-To: {$sender_mail}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($r,$subject,$message_mail,$headers);
           
            }
          
                                
                    $model->unSetAttributes();
                    $model= new Mails();                 
            }
                Yii::app()->user->setFlash(Yii::t('app','SentMail'), Yii::t('app','Email envoye avec success'));
                $this->redirect(array("/academic/mails/mailbox/mn/std/from/stud/?loc=inb"));
                                  
             }
         } // Fin verification Post['Mails']
         }
         
          // End Compose email 
         
         // Reply and email 
          if(isset($_GET['loc']) && $_GET['loc'] == 'reply'){
              if(isset($_GET['idmail'])){
                  $mail_id = $_GET['idmail'];
              
                  $emails =  Mails::model()->findAll();
                  foreach($emails as $e){
                if($e->id == $mail_id){
                    $this->sender_ = $e->sender;
                    $this->subject_ = Yii::t('app','Reply: ').$e->subject;
                    $this->message_ = Yii::t('app','------------<br/>').$e->message;
                }
              }
              }
              
         if(isset($_POST['Mails'])){ // Verifie que POST['Mails']
             if(isset($_POST['create'])){
                 
                $model = new Mails; 
                 // Take the user id in table users 
                $user_id = Yii::app()->user->userid;
                // Get the id person 
                $person_ = Persons::model()->getIdPersonByUserID($user_id)->getData();
                $sender_mail; 
                $sender_name; 
                $id_sender;
                
            foreach ($person_ as $p){
                $sender_mail = $p->email;
                $sender_name = $p->first_name.' '.$p->last_name;
                $id_sender = $p->id;
            }
            $model->attributes=$_POST['Mails'];
            $receiv_mail = $_POST['Mails']['receivers'];
            $receiv_tab = explode(",", $receiv_mail);
            
            for($i=0;$i<count($receiv_tab);$i++){
            $model->setAttribute('receivers', $receiv_tab[$i]);    
            $model->setAttribute('sender', $sender_mail);
            $model->setAttribute('sender_name', $sender_name);
            $model->setAttribute('is_read', 0);
            $model->setAttribute('id_sender', $id_sender);
            $model->setAttribute('is_delete', 0);
            $model->setAttribute('is_my_send', $id_sender);
            
            if($model->save()){
            
            $name='=?UTF-8?B?'.base64_encode($sender_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$sender_mail}>\r\n".
					"Reply-To: {$sender_mail}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($receiv_tab[$i],$subject,$model->message,$headers);
            }
           // $i++;
            }
                Yii::app()->user->setFlash(Yii::t('app','SentMail'), Yii::t('app','Email envoye avec success'));
                $this->redirect(array("/academic/mails/mailbox/mn/std/from/stud/?loc=inb"));
                                  
             }
         } // Fin verification Post['Mails']
         }
         // Fin reply 
         
         // Debut Forward 
         if(isset($_GET['loc']) && $_GET['loc'] == 'forward'){
              if(isset($_GET['idmail'])){
                  $mail_id = $_GET['idmail'];
              
                  $emails =  Mails::model()->findAll();
                  foreach($emails as $e){
                if($e->id == $mail_id){
                    
                    $this->subject_ = Yii::t('app','Forward: ').$e->subject;
                    $this->message_ = Yii::t('app','------------<br/>').$e->message;
                }
              }
              }
              
         if(isset($_POST['Mails'])){ // Verifie que POST['Mails']
             if(isset($_POST['create'])){
                 
                $model = new Mails; 
                 // Take the user id in table users 
                $user_id = Yii::app()->user->userid;
                // Get the id person 
                $person_ = Persons::model()->getIdPersonByUserID($user_id)->getData();
                $sender_mail; 
                $sender_name; 
                $id_sender;
                
            foreach ($person_ as $p){
                $sender_mail = $p->email;
                $sender_name = $p->first_name.' '.$p->last_name;
                $id_sender = $p->id;
            }
            $model->attributes=$_POST['Mails'];
            $receiv_mail = $_POST['Mails']['receivers'];
            $receiv_tab = explode(",", $receiv_mail);
            //if
            //$i=0;
            for($i=0;$i<count($receiv_tab);$i++){
            $model->setAttribute('receivers', $receiv_tab[$i]);    
            $model->setAttribute('sender', $sender_mail);
            $model->setAttribute('sender_name', $sender_name);
            $model->setAttribute('is_read', 0);
            $model->setAttribute('id_sender', $id_sender);
            $model->setAttribute('is_delete', 0);
            $model->setAttribute('is_my_send', $id_sender);
            
            if($model->save()){
            
            $name='=?UTF-8?B?'.base64_encode($sender_name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$sender_mail}>\r\n".
					"Reply-To: {$sender_mail}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($receiv_tab[$i],$subject,$model->message,$headers);
            }
           // $i++;
            }
                Yii::app()->user->setFlash(Yii::t('app','SentMail'), Yii::t('app','Email envoye avec success'));
                $this->redirect(array("/academic/mails/mailbox/mn/std/from/stud/?loc=inb"));
                                  
             }
         } // Fin verification Post['Mails']
         }
         // Fin forward 
         
        
         
            
            $this->render('mailbox',array(
                    'model'=>$model,
            ));
        
        }
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Mails;
                $modelP = new Persons;
                $modelC = new ContactInfo;
                $id = $_GET['stud'];
                $model_c = $modelC->model()->findByPk($id);
                $model_p = $modelP->model()->findByPk($id);
                $gc = GeneralConfig::model()->findAll();
                $email = null;
                $school_name = null;
                $email_alt = null;
                $school_name_alt = null;
                $email_sender = null;
                
                
                $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
                 $pers=$pers->getData();
                 foreach($pers as $p){
                                $id_sender = $p->person->id;
                                $sender_email = $p->person->email;
                                $sender_fullname = $p->person->fullName;
                                }
                /**
                 * Ce bloc verifie si l'utilisateur connecte a un email enregistre dans la base de donnes
                 * Si oui, il envoi le mail avec son email
                 * Si non, il l'envoi avec le mail de l'ecole.
                 */
                foreach($gc as $c){
                    if($c->item_name == "school_email_address"){
                        $email_alt = $c->item_value;
                    }
                    if($c->item_name == "school_name"){
                        $school_name_alt = $c->item_value;
                    }
                    
                }
                
               
                    if($model_p->email!=null){
                        $email = $model_p->email;
                        $school_name = Yii::app()->user->fullname;
                    }
                    else{
                        $email = $email_alt;
                        $school_name = $school_name_alt;
                    }
                if(Yii::app()->user->email!=""){
                    $email = Yii::app()->user->email;
                }
                    
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mails']))
		{
                    $groupid=Yii::app()->user->groupid;
                    $group=Groups::model()->findByPk($groupid);
                    $group_name=$group->group_name;
			
                    if($group_name=="Parent"){
                            
                            
                        $id_user = Yii::app()->user->userid;
                        $id_person = User::model()->findByPk($id_user)->person_id;

                        $contact = ContactInfo::model()->findAllBySql("Select id, email, contact_name FROM contact_info where person = $id_person");
                        $id_contact = null;
                        $email=null;
                        $full_name = null;
                        foreach($contact as $c){
                            $id_contact = $c->id;
                            $email = $c->email;
                            $full_name = $c->contact_name;
                        }
                        $email_prof = Persons::model()->findByPk($id)->email;
                        $model->attributes=$_POST['Mails'];
                       // $model->sender = $email;
                        $model->setAttribute('sender', $email);
                        $model->setAttribute('id_sender', $id_contact);
                        $model->setAttribute('receivers', $email_prof);
                        $model->setAttribute('sender_name',$full_name);
                        $model->is_read = 0;
                        $model->is_delete = 0;
                        $model->is_my_send = $id_contact;
                            
                        }else{
                    
                    
                    
                        $model->attributes=$_POST['Mails'];
                      
                        
                        
                        $model->setAttribute('sender', $sender_email);
                        $model->setAttribute('id_sender', $id_sender);
                        
                        
                        if(isset($_GET['de']) && $_GET['de']=='ci'){
                            $model->setAttribute('receivers', $model_c->email);
                           
                        }else{
                          $model->setAttribute('receivers', $model_p->email);   
                        
                        }
                        $model->sender_name = $sender_fullname;
                        $model->is_read = 0;
                        $model->is_delete = 0;
                        $model->is_my_send = $id_sender;
                        
                       
                        }
                        
			if($model->save()) {
                            
                                // Prepare le mail : Le nom et l'entete 
                            $name='=?UTF-8?B?'.base64_encode($sender_fullname).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$sender_email}>\r\n".
					"Reply-To: {$sender_email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";
                                // Envoi le mail        
				mail($model->receivers,$subject,$model->message,$headers);
                                // Redirection vers la page d'ou l'on vient
                                Yii::app()->user->setFlash(Yii::t('app','Mail'), Yii::t('app','Email send successfully !'));
                                
                                if(!isset($_GET['afich'])&&!isset($_GET['de'])){
				
                                    if(isset($_GET['isstud']) && $_GET['isstud']==1){
                                    $this->redirect(array('/academic/persons/viewForReport','id'=>$id,'pg'=>'lr','pi'=>'no','isstud'=>1,'from'=>'stud'));
                                    }
                                    elseif(isset($_GET['isstud']) && $_GET['isstud']==0){
                                        $this->redirect(array('/academic/persons/viewForReport','id'=>$id,'isstud'=>0,'from'=>'teach'));
                                    }
                                    
                                    elseif(isset ($_GET['mod'])){
                                        $this->redirect(array('/guest/courses/index'));
                                    }
                                    
                                    else{
                                        $this->redirect(array('/academic/persons/viewForReport','id'=>$id,'from'=>'emp'));
                                    }
                                
                                }
                                elseif (isset ($_GET['afich'])) {
                                if($_GET['afich']=='lists'){
                                   
                                    $this->redirect(array('/academic/persons/listForReport','from'=>'stud','isstud'=>1,'mn'=>'std'));
                                }
                                if($_GET['afich']=='liste'){
                                   
                                    $this->redirect(array('/academic/persons/listForReport','from'=>'emp','mn'=>'emp'));
                                }
                                if($_GET['afich']=='listt'){
                                   
                                    $this->redirect(array('/academic/persons/listForReport','from'=>'teach','isstud'=>0,'mn'=>'teach'));
                                }
                            }
                            elseif(isset($_GET['de'])){
                                if($_GET['from']=='stud'){
                                    $this->redirect(array('/academic/contactinfo/index','from'=>'stud','mn'=>'std'));
                                }
                                if($_GET['from']=='emp'){
                                    $this->redirect(array('/academic/contactinfo/index','from'=>'emp','mn'=>'std'));
                                }
                                if($_GET['from']=='teach'){
                                    $this->redirect(array('/academic/contactinfo/index','from'=>'teach','mn'=>'std'));
                                }
                                
                                
                            }
                           
                            
		}
             }    
		$this->render('create',array(
			'model'=>$model,
                        'modelP'=>$model_p,
                        'modelC'=>$model_c,
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

		if(isset($_POST['Mails']))
		{
			$model->attributes=$_POST['Mails'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Mails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Mails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mails']))
			$model->attributes=$_GET['Mails'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Mails the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Mails::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Mails $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mails-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        //************************  loadRoomByIdTeacher($id_teacher,$acad) ******************************/
	public function loadRoomByIdTeacher($id_teacher,$acad)
	{    

	
		$modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'r.id,room_name',
                                     'join'=>'left join courses c on(c.room=r.id)',
                                     'condition'=>'c.academic_period IN(select ap.id from academicperiods ap where (ap.id='.$acad.' OR ap.year='.$acad.') ) AND c.teacher='.$id_teacher,
                                     'order'=>'r.room_name ASC',
                               ));
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  
			    foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
        
}
