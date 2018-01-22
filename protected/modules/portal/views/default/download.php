<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Debut du processus de pagination des articles du Portal 
 * 
 */

        
        $doc_ = CmsDoc::model()->findAllBySql("SELECT * from cms_doc ORDER BY id DESC");
?>

<body>
        <div class="row featurette" style="margin-top: 20px;" > 
            
            <h4 style="margin-top: 20px;">Documents à télécharger</h4>
        <div class="col-md-12">
               <div class="list-group">
                   
             <?php foreach($doc_ as $d) { ?>
               
                   <a href="<?php echo Yii::app()->baseUrl.'/cms_files/files/'.$d->document_name; ?>" class="list-group-item">
                       <h5 class="list-group-item-heading"><i class="glyphicon glyphicon-paperclip"></i>  <?php echo $d->document_title; ?></h5>
                       <p class="list-group-item-text">
                           <?php
                            echo $d->document_description;
                           ?>
                       </p>    
                      
                   </a>
               
		      
		        
                <?php }?>
               
               </div>
    
        </div>
   

              
               
<p class="pull-right" ><a href="#"> Retour <i class="fa fa-chevron-up"> </i> </a></p>
	   
				             
		        
</div>		

   				
		  
</body>
       
    