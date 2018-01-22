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

Yii::import('ext.tcpdf.*');



class DefaultController extends PersonsController
{
   public $layout='//layouts/column4';
   public $back_url;
   
   public $message=false;
   public $portal_position;
   
   
   
   
   
   
    

  public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','contact','admission','about','preadmission','article','archives','download'),
				'users'=>array('@'),
			),
			
		);
	}
        
   public function actionAbout(){
       $this->render('about');
   } 
   
   public function actionArticle(){
       $this->render('article');
   } 
   
   public function actionArchives(){
       $this->render('archives');
   } 
   
   public function actionDownload(){
       $this->render('download');
   } 
   
    public function actionIndex()
	{
                $this->layout='//layouts/column4';
                $this->portal_position = "index";
		$this->render('index');
	}
        
        
 public function  actionAdmission(){
        $model = new Admission;
        $modelStudentOtherInfo = new StudentOtherInfo;
        $this->layout='//layouts/column4';
        
        if(isset($_POST['btn_save'])){
            if(isset($_POST['Admission'])){
        $model->attributes=$_POST['Admission'];
        if($model->validate()){
            if(isset($_POST['Admission']['birthday'])){
                $date_naissance = $_POST['Admission']['birthday'];
            }else{
                $date_naissance = "N/A";
            }
            
            if(isset($_POST['Admission']['cities'])){
                $city = $_POST['Admission']['cities'];
            }else{
                $city = 0;
            }
            
            if(isset($_POST['Admission']['phone'])){
                $phone = $_POST['Admission']['phone'];
            }else{
                $phone = 'N/A';
            }
            
            if(isset($_POST['Admission']['email'])){
                $email = $_POST['Admission']['email'];
            }else{
                $email = 'N/A';
            }
            
            if(isset($_POST['Admission']['adresse'])){
                $adresse = $_POST['Admission']['adresse'];
            }else{
                $adresse = 'N/A';
            }
            
            if(isset($_POST['Admission']['citizenship'])){
                $citizenship = $_POST['Admission']['citizenship'];
            }else{
                $citizenship = 'N/A';
            }
            
            if(isset($_POST['Admission']['father_full_name'])){
                $father_full_name = $_POST['Admission']['father_full_name'];
            }else{
                $father_full_name = 'N/A';
            }
            
            if(isset($_POST['Admission']['mother_full_name'])){
                $mother_full_name = $_POST['Admission']['mother_full_name'];
            }else{
                $mother_full_name = 'N/A';
            }
            
            if(isset($_POST['Admission']['person_liable'])){
                $person_liable = $_POST['Admission']['person_liable'];
            }else{
                $person_liable = 'N/A';
            }
            
            if(isset($_POST['Admission']['person_liable_phone'])){
                $person_liable_phone = $_POST['Admission']['person_liable_phone'];
            }else{
                $person_liable_phone = 'N/A';
            }
            
            if(isset($_POST['Admission']['previous_school'])){
                $previous_school = $_POST['Admission']['previous_school'];
            }else{
                $previous_school = 'N/A';
            }
            
            if(isset($_POST['Admission']['admission_en'])){
                $admission_en = $_POST['Admission']['admission_en'];
            }else{
                $admission_en = 0;
            }
            
            if(isset($_POST['Admission']['comments'])){
                $comments = $_POST['Admission']['comments'];
            }else{
                $comments = 'N/A';
            }
            
            
        
       
            // create new PDF document
	$pdf = new tcpdf('L', PDF_UNIT, 'legal', true, 'UTF-8', false);
        //Take the school name
        $criteria = new CDbCriteria;
        $criteria->condition='item_name=:item_name';
        $criteria->params=array(':item_name'=>'school_name',);
        $school_name = GeneralConfig::model()->find($criteria)->item_value;
        $criteria->params=array(':item_name'=>'school_email_address',);
        $school_email = GeneralConfig::model()->find($criteria)->item_value;
        $criteria->params=array(':item_name'=>'school_address',);
        $school_address = GeneralConfig::model()->find($criteria)->item_value;
        $criteria->params=array(':item_name'=>'school_phone_number',);
        $school_phone_number = GeneralConfig::model()->find($criteria)->item_value;
        
        $pdf->SetAuthor($school_name);
        $pdf->SetTitle(Yii::t('app','Subcription form'));
        $pdf->SetSubject(Yii::t('app','Subscription form'));
        
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email\n \n\n");
        
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP,10 );
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
        }


        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 13, '', true);

         // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
        
        $html = <<<EOD
                
           <style>
   
	
                /* cellpadding */
        th, td { padding: 5px; }

        /* cellspacing */
        table { border-collapse: separate; border-spacing: 5px; } /* cellspacing="5" */
        table { border-collapse: collapse; border-spacing: 0; }   /* cellspacing="0" */

        /* valign */
        th, td { vertical-align: top; }

        /* align (center) */
        table { margin: 0 auto; }
	

            </style>
                
EOD;
        $html .='<br/><div class="title">'.strtoupper(strtr("Fiche d'inscription", pa_daksan() )).'<br/> </div>';

        $html .="<table cellpadding='20'>"
                . "<tr>"
                . "<td>Nom: </td><td>".$model->last_name."</td>"
                . "<td>Prénom: </td><td>".$model->first_name."</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Sexe: </td><td>".$model->getGenders1()."</td>"
                . "<td>Date de naissance:</td><td>".$date_naissance."</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Lieu de naissance: </td><td>".$model->getCityname($city)."</td>"
                . "<td>Téléphone: </td><td>".$phone."</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Email: </td><td>".$email."</td>"
                . "<td>Adresse: </td><td>".$adresse."</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Nationalité: </td><td>".$citizenship."</td>"
                . "<td>Nom complet du père: </td><td>".$father_full_name."</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Nom complet de la mère: </td><td>".$mother_full_name."</td>"
                . "<td>Personne responsable : </td><td>".$person_liable."</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Téléphone personne responsable: </td><td>".$person_liable_phone."</td>"
                . "<td>Etablissement précédent: </td><td>".$previous_school."</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Admission en: </td><td>".$model->getLevelname($admission_en)."</td>"
                . "<td>Commentaires: </td><td>".$comments."</td>"
                . "</tr>"
                . "</table>";
              
              
              
              $file_name = "Formulaire Inscription $model->first_name $model->last_name ".date('Y-m-d H:m:s');
              $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
              
             
              
              
               // Envoi un email la personne inscrite si le champ email a ete rempli
              if(($email!='N/A') && ($school_email != null)){
                    $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
                    $subject='=?UTF-8?B?'.base64_encode($file_name).'?=';
                    $headers="From: $name <{$school_email}>\r\n".
                            "Reply-To: {$school_email}\r\n".
                            "MIME-Version: 1.0\r\n".
                            "Content-type: text/html; charset=UTF-8";
                    // Envoi le mail a la personne inscrite
                    mail($email,$subject,$html,$headers);
              
                   // Envoi le mail l'ecole
                    mail($school_email,$subject,$html,$headers);
                    
                    Yii::app()->user->setFlash(Yii::t('app','Subscription'), Yii::t('app','Thank you for submitting your online subscription.'));
              }else{
                  $name='=?UTF-8?B?'.base64_encode($school_name).'?=';
                    $subject='=?UTF-8?B?'.base64_encode($file_name).'?=';
                    $headers="From: $name <{$school_email}>\r\n".
                            "Reply-To: {$school_email}\r\n".
                            "MIME-Version: 1.0\r\n".
                            "Content-type: text/html; charset=UTF-8";
               
                   // Envoi le mail  a l'ecole
                    mail($school_email,$subject,$html,$headers);
              }
              
              $pdf->Output($file_name.'.pdf', 'D');
              $this->redirect(Yii::app()->baseUrl); 
              
           
              
            
        
        }
        
            
        } // Fin set formulaire
            
            }
            
            if(isset($_POST['btn_cancel'])){
            	$this->redirect(Yii::app()->baseUrl.'/index.php/portal/default/index');
            	}
        
        $this->render('admission',
                array('model'=>$model,
                    'modelStudentOtherInfo'=>$modelStudentOtherInfo,
                    ));
    }


  public function actionContact()
  {
          $model = new Contact; 
            //$this->layout = "//layouts/column3";
            $this->layout='//layouts/column4';
            $this->portal_position = "contact";
                 $gc = GeneralConfig::model()->findAll();
                $email = null;
                $school_name = null;
                foreach($gc as $c)
                  {
                    if($c->item_name == "school_email_address")
                      {
                        $email = $c->item_value;
                       }
                       
                    if($c->item_name == "school_name")
                       {
                        $school_name = $c->item_value;
                       }
                    
                   }
                   
		if(isset($_POST['Contact']))
		{
			
				 $model->attributes = $_POST['Contact'];
                             if(isset($_POST['result']) && $_POST['result']==$_POST['result_hide']){    
                                 
				 if($model->validate())
					{
						$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
						$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
						$headers="From: $name <{$model->email}>\r\n".
							"Reply-To: {$model->email}\r\n".
							"MIME-Version: 1.0\r\n".
							"Content-type: text/plain; charset=UTF-8";
		
						mail($email,$subject,$model->body,$headers);
						Yii::app()->user->setFlash('contact','Merci de nous avoir contacté. Nous vous répondra dès que possible !');
						
		                               
		                   $this->redirect(array('../portal'));
					  }
                             }else{
                                 Yii::app()->user->setFlash('error','SVP valider que tu es un être humain !');
                             }	  
			 // }
		}
	
		$this->render('contact',array('model'=>$model,));
	    
	 
	}
	
	
	        
    public function actionPreadmission(){
        
        $this->render('preadmission');
    }    
        
        
}