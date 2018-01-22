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

        
 echo '       <div class="bulletin" style="padding:0px; width:100%; height:860px;">
		  <div id="pdf" style=" padding:0px; width:100%; height:860px;">
			 <object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/filetree/index_h.php#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV" >
		  </div>
	    </div>
   ';

 ?>
 
------ 
 $('a').click(function(e) {
    e.preventDefault();  //stop the browser from following
    window.location.href = 'uploads/file.doc';
});

<a href="no-script.html">Download now!</a>

-------
$('a#someID').attr({target: '_blank', 
                    href  : 'http://localhost/directory/file.pdf'});     
                
----

<a href="path_to_file" download="proposed_file_name">Download</a>





