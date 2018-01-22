
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

?>

<?php
/* @var $this MailsController */
/* @var $model Mails */


$no_email=false;
$link='';
$to='';

?>

<?php
    
if(isset($modelP))
  {
        if($modelP->email != null && $modelP->email !="")
         {
             $no_email=false;
             
             $to=$modelP->fullName;  

           }
        elseif(!isset ($_GET['de']))
          {
            if(isset($_GET['from']) && $_GET['from']=='stud')
              {
            	$no_email=true;
            	
            	$link = '<i class="btn btn-warning">'.CHtml::link(Yii::t('app','Add email for name1',array('name1'=>$modelP->fullName)), array('persons/update','id'=>$modelP->id,'pg'=>'vrlr','isstud'=>1,'from'=>'stud')).'</i>';
	            
	            $to=$modelP->fullName;
            
              }
            
            if(isset($_GET['from']) && $_GET['from']=='teach')
              {
           		 $no_email=true;
            	
            	 $link = '<i class="btn btn-success">'.CHtml::link(Yii::t('app','Add email for name1',array('name1'=>$modelP->fullName)), array('persons/update','id'=>$modelP->id,'pg'=>'vrlr','isstud'=>0,'from'=>'teach')).'</i>';
           
                  $to=$modelP->fullName;
            
              }
            
            if(isset($_GET['from']) && $_GET['from']=='emp')
              {
            	 $no_email=true;
            	
            	 $link = '<i class="btn btn-success">'.CHtml::link(Yii::t('app','Add email for name1',array('name1'=>$modelP->fullName)), array('persons/update','id'=>$modelP->id,'pg'=>'vrlr','from'=>'emp')).'</i>';
            
                 $to=$modelP->fullName;
                 
            }
            
        }
        elseif (isset ($_GET['de']) && $modelC->email == null && $modelC->email =="" ) 
           {
                if(isset($_GET['from']) && $_GET['from']=='stud' && $_GET['de']=='ci')
                 {
                    if(isset($_GET['stud']))
                       $id_contact = $_GET['stud'];
                   
                    $no_email=true;
            	
            	    $link = '<i class="btn btn-success">'.CHtml::link(Yii::t('app','Add email for name1',array('name1'=>$modelC->contact_name)), array('contactinfo/update','id'=>$id_contact,'pg'=>'vrlr','isstud'=>1,'from'=>'stud')).'</i>';
                   
                    $to=$modelC->contact_name;
             
                }
                
                if(isset($_GET['from']) && $_GET['from']=='teach' && $_GET['de']=='ci')
                  {
                     if(isset($_GET['stud']))
                       $id_contact = $_GET['stud'];
                       
                      $no_email=true;
            	
            	      $link = '<i class="btn btn-success">'.CHtml::link(Yii::t('app','Add email for name1',array('name1'=>$modelC->contact_name)), array('contactinfo/update','id'=>$id_contact,'pg'=>'vrlr','isstud'=>0,'from'=>'teach')).'</i>';
                      
                      $to=$modelC->contact_name;
             
                  }
                  
                if(isset($_GET['from']) && $_GET['from']=='emp' && $_GET['de']=='ci')
                  {
                      if(isset($_GET['stud']))
                        $id_contact = $_GET['stud'];
                        
                     $no_email=true;
            	
            	     $link = '<i class="btn btn-success">'.CHtml::link(Yii::t('app','Add email for name1',array('name1'=>$modelC->contact_name)), array('contactinfo/update','id'=>$id_contact,'pg'=>'vrlr','from'=>'emp')).'</i>';
                  
		             $to=$modelC->contact_name;
             
                   }
                
            }
         elseif(isset($modelC))
           {
               if($modelC->email != null && $modelC->email !="")
                 {
                      $no_email=false;
            	
            	      $to=$modelC->contact_name;
        
                  }
                  
           }
           
        
            
        
   }
elseif(isset ($modelC) && $_GET['de']=='ci' && $_GET['from']=='emp')
   {
      if($modelC->email != null && $modelC->email !="")
        {
            $no_email=false;
            
            $to=$modelC->contact_name;
            
         }
        
    }
        
        
?>
 
 
 

<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Send email'); ?> 
		     
		</h2> </div>
		     
		     
      <div class="span3">
            
            <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                         echo ' <a href="'.Yii::app()->baseUrl.'/index.php/guest/courses/index">'.$images.'</a> ';
                           
                         

                   ?>

                  </div> 
                    
         
           </div>
 </div>


<div style="clear:both"></div>

<div class="b_mail">

 <?php           
            
if(!$no_email)
 {
?>

<div id="dash" style="width:auto; float:left;">
		 <span class="fa fa-2y" style="font-size: 19px;"> 
		     
            
 <?php           
            

 if(isset($modelP))
   {
        if($modelP->email != null && $modelP->email !="")           
            echo Yii::t('app','To: {name1}',array('{name1}'=>$to)); 
   }
  elseif(isset($modelC))
       {
            if(($modelC->email != null && $modelC->email !="")||($_GET['de']=='ci' && $_GET['from']=='emp'))
               echo Yii::t('app','To: {name1}',array('{name1}'=>$to));
            
               
       }
            
             
   ?>

  </span>  </div>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <br/>
    <div>
        
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>        

 <?php           
 
  }        
elseif($no_email)
 {
 	echo '<h5 class="alert alert-info">'.Yii::t('app','No email available! Imposible to send email to name1.<br/><br/> Please addEmail',array('name1'=>$to,'addEmail'=>$link)).'</h5>';
   }
        
 
 ?>
 
    </div>      
