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

<div style="clear:both;"></div>


<div class="form">
	
<div  id="resp_form_siges">

        <form  id="resp_form">


 <div class="col-2">
            <label id="resp_form">
    
                          <label for="Level"><?php echo Yii::t('app', 'Image 1'); ?></label>
                          
                         <input size="60" name="image1" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" type="file"/>     
                              
            </label>
    
                <label id="resp_form">
    
                          <label for="Level"><?php echo Yii::t('app', 'Image 2'); ?></label>
                          
                         <input size="60" name="image2" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" type="file"/>     
                              
            </label>
      
            <label id="resp_form">
    
                          <label for="Level"><?php echo Yii::t('app', 'Image 3'); ?></label>
                          
                         <input size="60" name="image3" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" type="file"/>     
                              
            </label>
    
        </div>
<!-- class="col-submit" btn btn-warning -->
 <div class="col-submit">
     <button id="upfoto" type="submit" name="logoUpload" class="btn btn-warning"><?php echo Yii::t('app', 'Upload'); ?></button>          
                               
    </div>
        </form>
</div>
  
  

</div>
