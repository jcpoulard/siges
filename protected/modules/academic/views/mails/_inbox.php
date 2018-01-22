
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

if(isset($_GET['loc'])){
    $mail_type = $_GET['loc'];
    
}

function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
            
            // Take the user id in table users 
            $user_id = Yii::app()->user->userid;
            // Get the id person 
            $person_ = Persons::model()->getIdPersonByUserID($user_id)->getData();
            
           // For each persn make a loop to take the id person 
            $person_id;
            $email_id;
            foreach($person_ as $p){
               $person_id = $p->id;
               $email_id = $p->email;
            }
            
             // Construct the data provider will all the unread email 
            switch ($mail_type){
            case "inb":
               $dataProvider =  Mails::model()->searchUnreadMail($email_id);
                break;
            case "sent":
                $dataProvider =  Mails::model()->searchSentMail($person_id);
                break;
            case "del":
                $dataProvider =  Mails::model()->searchTrashMail($person_id);
                break;
            default:
                $dataProvider =  Mails::model()->searchUnreadMail($email_id);
                break;
        }
            
                  // $dataProvider =  Mails::model()->searchUnreadMail($person_id);
           
			 
	$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'inbox-grid',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
        'emptyText'=>Yii::t('app','No email found'),
	'summaryText'=>Yii::t('app','{start} to {end} on {count}'),        
        'template'=>'{summary}{pager}{items}', // Place la numerotation de page en haut
	'selectableRows' =>2,
        'pager'=>array(
        'header'         => '',
        'firstPageLabel' => '&lt;&lt;',
        'prevPageLabel'  => '<i class="fa fa-backward"> </i>',
        'nextPageLabel'  => '<i class="fa fa-forward"> </i>',
        'lastPageLabel'  => '&gt;&gt;',
    ),
    'rowCssClassExpression'=>'($data->is_read==0)?"read_mail":evenOdd($row)',
    
	//'filter'=>$model,
    'columns'=>array(
	  //'id',
	array('class'=>'CCheckBoxColumn',   
               'id'=>'chk',
                 ),  
	array('header' =>Yii::t('app','Sender'),
	        'name'=>'sender',
                'type'=>'raw',
                'value'=>'CHtml::link($data->sender,Yii::app()->createUrl("academic/mails/mailbox/mn/std/from/stud/loc/read/from1/'.$mail_type.'",array("id"=>$data->id)))',
	        ),
	array('header' =>Yii::t('app','Mail subject'),
	        'name'=>'subject',
                'type'=>'raw',
               'value'=>'CHtml::link($data->subject,Yii::app()->createUrl("academic/mails/mailbox/mn/std/from/stud/loc/read/from1/'.$mail_type.'",array("id"=>$data->id)))',
	   
            ),
        array('header' =>Yii::t('app','Sent on'),
	         'name'=>'date_sent',
	        'value'=>'$data->dateEmail'
            ),
	
            ),
        ));
        


