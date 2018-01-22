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
$acad_sess=acad_sess();
?>

<div style="clear:both;"></div>


<div class="form">
	
<div  id="resp_form_siges">

        <form  id="resp_form">


 <div class="col-2">
            <label id="resp_form">
    
                          <label for="Level"><?php echo Yii::t('app', 'Logo with PNG extension'); ?></label>
                          
                         <input size="60" name="image" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" type="file"/>     
                              
            </label>
        </div>

 <div class="col-submit">
       <?php 
      if(!isAchiveMode($acad_sess))
        {    
        
   ?>
          <button id="upfoto" type="submit" name="logoUpload" class="btn btn-warning"><?php echo Yii::t('app', 'Upload'); ?></button>                      
   <?php
        }
   ?>                             
</div>
        </form>
</div>
  
  

</div>
