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


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<script type="text/javascript">
    $(document).ready(function() {
    refreshData();
    });
               function refreshData(){
                   $.ajax({
                     url: 'user/viewOnlineUsers',
                     type:"POST",
                     data:"dataPost",
                     success: function(data){
                     document.getElementById("dataPost").innerHTML = data;//why not use $('#dataPost').html(data) if you're already using jQuery?
                        setTimeout(refreshData, 3000);//will make the next call 3 seconds after the last one has finished.
                       //render the dynamic data into html
                     }
                   });
               }

 </script>


<?php
$count_user_online = 0;
foreach(User::getOnlineUsers() as $user){
    $count_user_online++;
}

?>

<!-- Menu of CRUD  -->
<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','Online users: {number}',array('{number}'=>$count_user_online)); ?>  </h2> </div>
    <div class="span3">
           
        <div class="span4">
                  <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('../site/index')); 
                     
                   ?>
              </div>
                  
          
        </div>
</div>

<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseUser',NULL,true);	
    ?>
</div>


<div style="clear:both"></div>

<!-- Affichage en tableau des utilisateurs en ligne -->

<div class="grid-view">
   
<table class="items">
    <thead>
        
    <tr>
        <th><?php echo Yii::t('app','Users'); ?></th>
        <th><?php echo Yii::t('app','Connected from'); ?></th>
    </tr>
    </thead>
    <tbody>
<?php 
function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
            $line_number = 1;
foreach (User::getOnlineUsers() as $user) {
        
       switch($user["group_id"])
    {
        case 3: // Students 
        {
            echo '<tr class="'.evenOdd($line_number).'"><td><i class="fa fa-group text-success"></i> <a href="'.Yii::app()->baseUrl.'/index.php/users/user/view/id/'.$user["id"].'">'.$user["full_name"].' ('.$user["username"].')'
                . '</a></td><td>'.$user["last_ip"].'</td></tr>';
            $line_number++;
        }
        break;
    
        case 4: // Parent 
        {
            echo '<tr class="'.evenOdd($line_number).'"><td><i class="fa fa-phone text-success"></i> <a href="'.Yii::app()->baseUrl.'/index.php/users/user/view/id/'.$user["id"].'">'.$user["full_name"].' ('.$user["username"].')'
                . '</a></td><td>'.$user["last_ip"].'</td></tr>';
            $line_number++;
        }
        break;
    
        case 8: // Teacher 
        {
            echo '<tr class="'.evenOdd($line_number).'"><td><i class="fa fa-male text-success"></i> <a href="'.Yii::app()->baseUrl.'/index.php/users/user/view/id/'.$user["id"].'">'.$user["full_name"].' ('.$user["username"].')'
                . '</a></td><td>'.$user["last_ip"].'</td></tr>';
        $line_number++;
        }
        default: // Les autres utilisateurs 
        {
            echo '<tr class="'.evenOdd($line_number).'"><td><i class="fa fa-user text-success"></i> <a href="'.Yii::app()->baseUrl.'/index.php/users/user/view/id/'.$user["id"].'">'.$user["full_name"].' ('.$user["username"].')'
                . '</a></td><td>'.$user["last_ip"].'</td></tr>';
        $line_number++;
        }
    }
	
	
    }
?>
    </tbody>       
</table>
    
</div>    