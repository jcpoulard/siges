
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
<div class="b_mail">

<?php
if(isset($_GET['loc'])){
    $mail_type = $_GET['loc'];
    
}

?>
<div class="box box-primary">
     <div class="row-fluid mailbox-controls">
       <div class="box-header with-border">
        <h4>
       <?php 
        switch ($mail_type){
            case "inb":
                echo Yii::t('app','Inbox');
                break;
            case "sent":
                echo Yii::t('app','Sent mail');
                break;
            case "del":
                echo Yii::t('app','Trashes');
                break;
            default:
                echo Yii::t('app','Inbox');
                break;
        }
        ?>
        
        </h4>
          
		 <form method="POST">
        

  <div class="row-fluid mailbox-controls">
            

 <div class="pull-right">
<span class="btn-group">
           
                <button type="submit" name="btn_trash" class="btn btn-default btn-sm" data-toggle="tooltip" title="<?php echo Yii::t('app','Delete'); ?>">
                <i class="fa fa-trash-o"></i>
            </button>
            
           </span>
</div></div>
  
    <div class="box-body no-padding">
   
    
        </div>   
        </div>  
</div>
   </div>


 <div class="table-responsive mailbox-messages checkbox_view" style="overflow:scroll;height:400px; padding-right: 10px;">
           <?php 
           
		     		  
	$form = $this->beginWidget('CActiveForm', array(
	'id'=>'inbox-grid',
	'enableAjaxValidation'=>true,
)        );
        
         echo $this->renderPartial('_inbox', array('model'=>$model,
                                                    'form' =>$form
						));
         	     		  
	
        $this->endWidget(); 
         
            ?>
            
        </div>
        </form> 
 

</div>
