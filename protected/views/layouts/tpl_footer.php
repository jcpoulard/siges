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

?>


<?php
$count_user_online = 0;
$string_tool_tip = "";
foreach(User::getOnlineUsers() as $user){
    $count_user_online++;
     switch($user["group_id"])
    {
        case 3: // Students 
        {
           $string_tool_tip .= "<i class='fa fa-group text-success'></i> ".$user["full_name"]." (".$user["username"].")<br/>";
                
            
        }
        break;
    
        case 4: // Parent 
        {
            $string_tool_tip .= "<i class='fa fa-phone text-success'></i> ".$user["full_name"]." (".$user["username"].")<br/>";
           
        }
        break;
    
        case 8: // Teacher 
        {
            $string_tool_tip .= "<i class='fa fa-male text-success'></i> ".$user["full_name"]." (".$user["username"].")<br/>";
         
        }
        default: // Les autres utilisateurs 
        {
            $string_tool_tip .= "<i class='fa fa-user text-success'></i> ".$user["full_name"]." (".$user["username"].")<br/>";
            
           
        }
    }
    
}



?>
	<footer>
        <div class="subnav navbar navbar-fixed-bottom">
            <div class="navbar-inner">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span3">
                            
                        </div>
                     <div class="span6">
                         
                      <?php 
                        echo Yii::t('app','Powered by ').'<a href="http://www.logipam.com" target="_new">LOGIPAM</a>. &copy; '.Yii::t('app','All rights reserved.');  
                      ?>   
                      <br/>
                    </small>
                     </div>
                        
                        <div class="span3" style="text-align:right;"> 
                           <?php  if(isset(Yii::app()->user->profil) && Yii::app()->user->profil=="Admin"){ ?> 
                            <a style="color: #EE642E" href="<?php echo Yii::app()->baseUrl.'/index.php/users/user/viewOnlineUsers' ?>"><i class="fa fa-user text-success"></i><?php echo Yii::t('app',' {count} user(s) online', array('{count}'=>$count_user_online)) ?></a>
                           <?php  } ?> 
                        </div>
                    </div>
                   
                     
                    
                </div>
                
               
       
            </div>
        </div>      
	</footer>


<script type="text/javascript">
    $(document).ready(function(){
        $('a[data-toggle=tooltip]').tooltip();
        
        
    });
  </script>

 <?php
    /**
     *  POU PI TA
     * <div class="span3"> 
                           <?php  if(isset(Yii::app()->user->profil) && Yii::app()->user->profil=="Admin"){ ?> 
                            <a data-toggle="tooltip" data-html="true" title="<div class='row-fluid'><?php echo $string_tool_tip; ?></div>"   href="<?php echo Yii::app()->baseUrl.'/index.php/users/user/viewOnlineUsers' ?>"><i class="fa fa-circle text-success"></i><?php echo Yii::t('app',' {count} users online in SIGES', array('{count}'=>$count_user_online)) ?></a>
                           <?php  } ?> 
                        </div>
     * 
     */

 ?>
  