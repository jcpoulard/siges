
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


<div class="box box-primary">
     <div class="row-fluid mailbox-controls">
       <div class="box-header with-border">
          <h4><?php 
            if(isset($_GET['id'])){
            $idmail = $_GET['id'];
            
            }
        echo Yii::t('app','Read mail'); ?>


          </h4>
      
 	
<form method="POST">
          <div class="box-body no-padding">
                 <span class="btn-group">
           
                <button class="btn btn-default btn-sm" type="submit" name="trash_readmail">
                <i class="fa fa-trash-o"></i>
            </button>
                <a href="<?php echo Yii::app()->baseUrl ?>/index.php/academic/mails/mailbox/mn/std/from/stud/?loc=reply&idmail=<?php echo $idmail; ?>" class="btn btn-default btn-sm"  data-toggle="tooltip" title="<?php echo Yii::t('app','Reply'); ?>">
                <i class="fa fa-reply"></i>
            </a>
                <a href="<?php echo Yii::app()->baseUrl ?>/index.php/academic/mails/mailbox/mn/std/from/stud/?loc=forward&idmail=<?php echo $idmail ?>" class="btn btn-default btn-sm"  data-toggle="tooltip"  title="<?php echo Yii::t('app','Forward'); ?>">
               		 <i class="fa fa-share"></i>
	            </a>
	           </span>
		 </div>
     </div>
           
           
       
   </div>
        
        <div class="checkbox_view">
            
            <?php 
            $emails =  Mails::model()->findAll();
            if(isset($_GET['id'])){
                $idmail = $_GET['id'];
            
            $command = Yii::app()->db->createCommand();
            
            $command->update('mails', array('is_read'=>1), 'id=:idmail', array(':idmail'=>$idmail));
            
             
             foreach($emails as $e){
                if($e->id == $idmail){
               
                
	    ?>
            <div class="r_mail">
                <div class="mail_date">
                <?php echo $e->subject; ?>
            
                <div class="pull-right">
                   <?php echo Yii::t('app','Email sent : '). $e->dateEmail; ?> 
                </div>
            </div>
                
            <div class="t_mail">    
                <h6><i class="fa fa-user"></i> <?php echo "$e->sender_name ($e->sender)"; ?>  </h6>
            
                <p>
                    <?php echo $e->message; ?>
				</p>
        
            </div>
               
            <?php }} }?>
            
        </div>
        
    </div>
     </form> 
</div> 
</div>
