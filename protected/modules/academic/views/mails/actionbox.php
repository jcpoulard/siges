
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
//style="border: 1px solid red"
?>

    
    
    <div class="box box-solid " style="display: block;">
        

<div class="box-body no-padding" style="display: block;">
            <ul class="nav nav-pills nav-stacked">

		 <li class="active">
		<a href="<?php echo Yii::app()->baseUrl ?>/index.php/academic/mails/mailbox/mn/std/from/stud/?loc=comp"> <?php echo Yii::t('app','Compose'); ?>
		</a>
			</li>
        
                <li>
                  
                    <a href="<?php echo Yii::app()->baseUrl ?>/index.php/academic/mails/mailbox/mn/std/from/stud/?loc=inb">
                         <i class="fa fa-inbox fa-2x"></i> 
                        <?php
                             $mail_unread = Mails::model()->getTotalUnreadMails(Yii::app()->user->userid);
                             echo Yii::t('app','Inbox: {number}', array('{number}'=>$mail_unread));
                        ?>
                   </a>
                </li> 
                <li>
                    <a href="<?php echo Yii::app()->baseUrl ?>/index.php/academic/mails/mailbox/mn/std/from/stud/?loc=sent">
                        <i class="fa fa-envelope-o fa-2x"></i>
                        <?php echo Yii::t('app','Sent'); ?>
                        
                    </a>
                </li> 
                <li>
                    <a href="<?php echo Yii::app()->baseUrl ?>/index.php/academic/mails/mailbox/mn/std/from/stud?loc=del">
                        <i class="fa fa-trash-o fa-2x"></i>
                        <?php echo Yii::t('app','Trashes'); ?>
                        
                    </a>
                </li> 
            </ul>
        </div>
   
</div>

