<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DatamigrationController extends Controller
{
	public $layout='//layouts/column2';
        public $data = array();
        public $file_name = null;
        public $room = null;
        
        public $nombre_ligne=1;
        public $temoin = False;
        
        public $part;
        
        
        public function filters()
	{
		return array(
			'accessControl', 
		);
	}
        
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
        
        public function actionIndex(){
            $this->part = 'std';
            $model = new Datamigration;
            $acad=Yii::app()->session['currentId_academic_year'];
            $group_id = $model->getGroupIdByName("Student");
            $profil_id = $model->getProfilIdByName("Guest");
            $error_report = False;
            
            if(isset($_POST['btnUpload'])){
                // Procedure pour charger le fichier csv et le mettre dans un folder sur le serveur 
                    $this->file_name = $_FILES['input_csv']['name'];
                    
                    if($this->file_name){
                        $filename = stripslashes($_FILES['input_csv']['name']);
                        $extension = $this->getExtension($filename);
                        $extension = strtolower($extension);
                        if($extension!="csv"){
                             Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','The file {filename} is not a csv extension',array('{filename}'=>$filename)));
                        }else{
                            $size = filesize($_FILES['input_csv']['tmp_name']);
                            if($size > 1024*1024){
                                Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','The file {filename} excess the limit size of 1MB (current size {size}MB)',array('{filename}'=>$filename,'{size}'=>$size/(1024*1024))));
                            }else{
                                $filename = Yii::app()->basePath.'/../tmp_csv/'.$this->file_name;
                                $file_tmp = $_FILES['input_csv']['tmp_name'];
                                move_uploaded_file($file_tmp, $filename);
                                $this->temoin = True;
                            }
                           
                        }
                    }
               
            }
            
            if(isset($_POST['btnFinish'])){
                if(isset($_POST['room']) && $_POST['room']!=""){
                    $room = $_POST['room'];
                    $level = Rooms::model()->findByPk($room)->level;
                    $room_name = Rooms::model()->findByPk($room)->room_name;
                    $roomhasperson = new RoomHasPerson; 
                    $levelhasperson = new LevelHasPerson;
                    $user = new User;
                    $person = new Persons;
                    $date_formate = array();
                    
                    $row = 1;
                   
                  // Prendre le nombre de ligne dans le tableau a partir de la variable cache 
                    $nombre_ligne = $_POST['nombre_ligne'];
                            
                                 $num = $nombre_ligne-1;
                                    // Effectue un boucle sur chaque element du tableau HTML pour enregistrer dans la base de donnees 
                                    for ($c=0; $c < $num; $c++) {
                                        $row++;
                                        // Traitement pour la sauvegarde dans la table persons
                                        // Traitement de la date de naissance
                                        if(isset($_POST['birthday'.$row])&&$_POST['birthday'.$row]!=""){
                                            $date_formate = explode('-',$_POST['birthday'.$row]);
											
											if(!isset($date_formate[2]))
												$date_formate = explode('/',$_POST['birthday'.$row]);
											
                                            if(count($date_formate)<4){
                                                $date_s = $date_formate[2].'-'.$date_formate[1].'-'.$date_formate[0];
                                            }else{
                                                $date_s = "000-00-00";
                                            }
                                        }else{
                                            $date_s = null;
                                        }
                                        // Verifie si gender n'est pas set et le donner valeur par defaut 0
                                        if(!isset($_POST['gender'.$row])){
                                            $gender = 0;
                                        }else{
                                            $gender = $_POST['gender'.$row];
                                        }
                                        
                                        if(!isset($_POST['code'.$row])){
                                            $code = null;
                                        }else{
                                            $code = $_POST['code'.$row];
                                        }
                                        $last_name = $_POST['last_name'.$row]; 
                                        $first_name = $_POST['first_name'.$row];
                                        //first_name
                                            $explode_firstname=explode(" ",substr($first_name,0));

                                                       if(isset($explode_firstname[1])&&($explode_firstname[1]!=''))
                                            { 
                                                   $cf = strtoupper(  substr(strtr($explode_firstname[0],pa_daksan() ), 0,1).substr(strtr($explode_firstname[1],pa_daksan() ), 0,1)  );

                                            }
                                            else
                                            {  $cf = strtoupper( substr(strtr($explode_firstname[0],pa_daksan() ), 0,2)  );

                                            }
                                        //last_name
                                        $explode_lastname=explode(" ",substr($last_name,0));

                                                   if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
                                        { 
                                               $cl = strtoupper(  substr(strtr($explode_lastname[0],pa_daksan() ), 0,1).substr(strtr($explode_lastname[1],pa_daksan() ), 0,1) );

                                        }
                                        else
                                        {  $cl = strtoupper( substr(strtr( $explode_lastname[0],pa_daksan() ), 0,2)  );

                                        }    
                                        
                                       // Enregistrer les eleves
                                       $person->setAttribute('last_name', $_POST['last_name'.$row]);
                                       $person->setAttribute('first_name', $_POST['first_name'.$row]);
                                       $person->setAttribute('gender', $gender);
                                       $person->setAttribute('birthday', $date_s);
                                       $person->setAttribute('id_number', $code);
                                       $person->setAttribute('is_student', 1);
                                       $person->setAttribute('active', 1);
                                       $person->setAttribute('create_by', 'siges_migration_tool');
                                       
                                       if($person->save()){
                                           //Affecte les elves dans une classe
                                           $code_ = $cf.$cl.$person->id;
                                           $person->setAttribute('id_number', $code_);
                                           $person->save(); 
                                           $levelhasperson->setAttribute('level',$level);
                                           $levelhasperson->setAttribute('students',$person->id);
                                           $levelhasperson->setAttribute('academic_year',$acad);
                                           $levelhasperson->setAttribute('date_created',date('Y-m-d'));
                                           $levelhasperson->setAttribute('create_by','siges_migration_tool');
                                           $levelhasperson->save(); 
                                           
                                           //Affecter les eleves a une salle
                                           $roomhasperson->setAttribute('room', $room);
                                           $roomhasperson->setAttribute('students', $person->id);
                                           $roomhasperson->setAttribute('academic_year', $acad);
                                           $roomhasperson->setAttribute('date_created',date('Y-m-d'));
                                           $roomhasperson->setAttribute('create_by','siges_migration_tool');
                                           $roomhasperson->save();
                                           
                                           // Creation de nom d'utilisateur pour les eleves migres
                                           $username = $model->createUsername($person->last_name, $person->id);
                                           $full_name = ucwords($person->first_name.' '.$person->last_name);
                                           //$password = md5("password");
                                           $user->setAttribute('username', $username);
                                           $user->setAttribute('password', $code_);
                                           $user->setAttribute('person_id',$person->id);
                                           $user->setAttribute('active', 1);
                                           $user->setAttribute('full_name', $full_name);
                                           $user->setAttribute('profil', $profil_id);
                                           $user->setAttribute('group_id', $group_id);
                                           $user->setAttribute('is_parent', 0);
                                           $user->setAttribute('create_by', 'siges_migration_tool');
                                           $user->setAttribute('date_created', date('Y-m-d H:m:s'));
                                           $user->save();
                                           
                                       }else{
                                           $error_report = True;
                                       }
                                       $person->unsetAttributes();
                                       $person = new Persons;
                                       $levelhasperson->unsetAttributes();
                                       $levelhasperson = new LevelHasPerson;
                                       $roomhasperson->unsetAttributes();
                                       $roomhasperson = new RoomHasPerson;
                                       $user->unsetAttributes();
                                       $user = new User;
                                       
                                    }
                                    
                                    
                                    if($error_report){
                                        Yii::app()->user->setFlash(Yii::t('app','Error'),Yii::t('app','An error was occuring during the migration process ! Please review your csv file !'));
                                    }else{
                                    
                                        // Recuperer le nom du fichier csv a partir d'un champ chache 
                                        $filename = $_POST['file_name'];

                                        $string = Yii::app()->basePath;
                                        $address_base = str_replace("protected", "", $string);
                                       // Supprimer le fichier CSV (Marche sur MACOS et Linux seulement... mais la non supression du fichier n'empeche pas a l'operation de continuer) 
                                        shell_exec('rm -rf "'.$address_base.'tmp_csv/'.$filename.'"');
                                        Yii::app()->user->setFlash(Yii::t('app','Confirm'), Yii::t('app','Migration terminate with success !<br/>{nbStudent} Students saved in the room of {room}',array('{nbStudent}'=>$num,'{room}'=>$room_name)));
                                    }
                            }
                            
                            else{
                                Yii::app()->user->setFlash(Yii::t('app','Error'),Yii::t('app','Please choose a room to continue!'));
                            }
                        
                   
            }
            
           
            
            $this->render('index',
                    array('model'=>$model,'data'=>$this->data,'room'=>$this->room));
        }
        
        
        public function actionEmployees(){
            $this->part = 'emp';
            $model = new Datamigration;
            $group_id = $model->getGroupIdByName("Default Group");
            $profil_id = $model->getProfilIdByName("Guest");
           // $personhastitles = new PersonsHasTitles;
            $acad=Yii::app()->session['currentId_academic_year']; 
            
            if(isset($_POST['btnUpload'])){
                // Procedure pour charger le fichier csv et le mettre dans un folder sur le serveur 
                    $this->file_name = $_FILES['input_csv']['name'];
                    
                    if($this->file_name){
                        $filename = stripslashes($_FILES['input_csv']['name']);
                        $extension = $this->getExtension($filename);
                        $extension = strtolower($extension);
                        if($extension!="csv"){
                             Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','The file {filename} is not a csv extension',array('{filename}'=>$filename)));
                        }else{
                            $size = filesize($_FILES['input_csv']['tmp_name']);
                            if($size > 1024*1024){
                                Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','The file {filename} excess th limit size of 1 MB (current size {size}MB)',array('{filename}'=>$filename,'{size}'=>$size/(1024*1024))));
                            }else{
                                $filename = Yii::app()->basePath.'/../tmp_csv/'.$this->file_name;
                                $file_tmp = $_FILES['input_csv']['tmp_name'];
                                move_uploaded_file($file_tmp, $filename);
                                $this->temoin = True;
                            }
                           
                        }
                    }
               
            }
            
             if(isset($_POST['btnFinish'])){
                
                    
                    $person = new Persons;
                    $user = new User;
                    $date_formate = array();
                    
                    $row = 1;
                   
                  // Prendre le nombre de ligne dans le tableau a partir de la variable cache 
                    $nombre_ligne = $_POST['nombre_ligne'];
                            
                                 $num = $nombre_ligne-1;
                                    // Effectue un boucle sur chaque element du tableau HTML pour enregistrer dans la base de donnees 
                                    for ($c=0; $c < $num; $c++) {
                                        $row++;
                                        // Traitement pour la sauvegarde dans la table persons
                                        // Traitement de la date de naissance
                                        if(isset($_POST['birthday'.$row])){
                                            $date_formate = explode('-',$_POST['birthday'.$row]);
											
											if(!isset($date_formate[2]))
												$date_formate = explode('/',$_POST['birthday'.$row]);
											
                                            if(count($date_formate)<4){
                                                $date_s = $date_formate[2].'-'.$date_formate[1].'-'.$date_formate[0];
                                            }else{
                                                $date_s = "000-00-00";
                                            }
                                        }else{
                                            $date_s = null;
                                        }
                                        // Verifie si gender n'est pas set et le donner valeur par defaut 0
                                        if(!isset($_POST['gender'.$row])){
                                            $gender = 0;
                                        }else{
                                            $gender = $_POST['gender'.$row];
                                        }
                                       // Enregistrer les eleves
                                       $person->setAttribute('last_name', $_POST['last_name'.$row]);
                                       $person->setAttribute('first_name', $_POST['first_name'.$row]);
                                       $person->setAttribute('gender', $gender);
                                       $person->setAttribute('birthday', $date_s);
                                       $person->setAttribute('is_student', 0);
                                       $person->setAttribute('active', 1);
                                       $person->setAttribute('create_by', 'siges_migration_tool');
                                       
                                       if($person->save()){
                                           // Creation de nom d'utilisateur pour les eleves migres
                                           $username = $model->createUsername($person->last_name, $person->id);
                                           $full_name = ucwords($person->first_name.' '.$person->last_name);
                                           //$password = md5("password");
                                           $user->setAttribute('username', $username);
                                           $user->setAttribute('password', 'password');
                                           $user->setAttribute('person_id',$person->id);
                                           $user->setAttribute('active', 1);
                                           $user->setAttribute('full_name', $full_name);
                                           $user->setAttribute('profil', $profil_id);
                                           $user->setAttribute('group_id', $group_id);
                                           $user->setAttribute('is_parent', 0);
                                           $user->setAttribute('create_by', 'siges_migration_tool');
                                           $user->setAttribute('date_created', date('Y-m-d H:m:s'));
                                           $user->save();
                                           
                                           
                                           /*
                                         if(isset($_POST['title'.$row]) && $_POST['title'.$row]!=""){
                                             $personhastitles->setAttribute('persons_id', $person->id);
                                             $personhastitles->setAttribute('titles_id', $_POST['title'.$row]);
                                             $personhastitles->setAttribute('academic_year', $acad);
                                             $personhastitles->save();
                                             $personhastitles->unsetAttributes();
                                             $personhastitles = new PersonsHasTitles;
                                         } 
                                            * 
                                            */ 
                                           
                                       }
                                       $person->unsetAttributes();
                                       $person = new Persons;
                                       $user->unsetAttributes();
                                       $user = new User;
                                       
                                       
                                    }
                                    // Recuperer le nom du fichier csv a partir d'un champ chache 
                                    $filename = $_POST['file_name'];

                                    $string = Yii::app()->basePath;
                                    $address_base = str_replace("protected", "", $string);
                                   // Supprimer le fichier CSV (Marche sur MACOS et Linux seulement... mais la non supression du fichier n'empech pas a l'operation de continuer) 
                                    shell_exec('rm -rf "'.$address_base.'tmp_csv/'.$filename.'"');
                                    Yii::app()->user->setFlash(Yii::t('app','Confirm'), Yii::t('app','Successfully saved {nbEmployee} Employees !',array('{nbEmployee}'=>$num)));     
                
            }
            
            
            $this->render('employees',array('model'=>$model));
            
        }
        
 public function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
    }
        

        
}