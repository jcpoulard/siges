
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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','SIGES MailBox'); ?> 
		     
		</h2> </div>
		     
		     
      <div class="span3">
            
            <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                         echo ' <a href="javascript:history.back(1)">'.$images.'</a> ';
                           
                         

                   ?>

               </div> 
          <?php if(Yii::app()->user->profil=='Teacher'){ ?>
          <div class="span4">
              <a href="<?php echo Yii::app()->baseURL ?>/index.php/academic/mails/batchMailStudent/mn/std/from/stud/loc/inb"><i class="fa fa-user-plus"> <?php echo Yii::t('app','Maillings'); ?></i></a>
          </div>
          <?php }?>       
         
           </div>
 </div>


<div style="clear:both"></div>

<div>

<div class="row-fluid span9 right-side">
<div class="span10 right">
 <div id="dash" style="width:auto; float:left; margin-left:10px;">
		 <span class="fa fa-2y" style="font-size: 19px;">   
    <?php 
            $mail_unread = Mails::model()->getTotalUnreadMails(Yii::app()->user->userid);
			    
          $loca = '';
          if(isset($_GET['loc']))
              $loca = $_GET['loc'];     
    
          if(($loca != 'comp')&&($loca != 'sent')&&($loca != 'del')&&($loca != 'read')&&($loca != 'forward')&&($loca != 'reply'))
			  {
			  	if($mail_unread==0)
			       echo Yii::t('app','No new message');
			    elseif($mail_unread==1)
			           echo $mail_unread.' '.Yii::t('app','new message');
			        else
			           echo $mail_unread.' '.Yii::t('app','new messages');
			           
			   }
			           
			            ?></span>
    
 </div>
</div>


<div class="row span9 right">
    


<div class="span2"><div class="b_mail">
        <?php include "actionbox.php";?>
    </div>

</div>
    <div class="span10" > 
      
        <?php 
        if(isset($_GET['loc'])){
          $loc = $_GET['loc'];
          if($loc=="read"){
               include "readmail.php";
          }
          
          if($loc=="comp"){
              include "compose.php";
          }
          
          if($loc=="reply"){
              include "compose.php";
          }
          if($loc=="forward"){
              include "compose.php";
          }
          if($loc=="inb"){
              include "inbox.php";
          }
          if($loc=="sent"){
              include "inbox.php";
          }
          if($loc=="del"){
              include "inbox.php";
          }
        }
        ?>
    </div>
</div>
    </div>
</div>
</div>
<div style="clear:both"></div>

