<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$about_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'about' AND is_publish = 1 ORDER BY id DESC LIMIT 10");
?>

<body>
           <div class="row featurette" style="margin-top: 20px;" >
        
             <?php foreach($about_ as $a) { ?>
		      
		        <div class="col-md-12">
		        
				          <h2 class="featurette-heading">  <?php echo $a->article_title; ?> </h2>
		
		     				
				         	 <p class="lead">
				             
				              <div class="comment more">
					              <?php echo $a->article_description; ?>
					              
					           </p>
		 				      </div>
				            
				            
						       <div style="text-align: right">
						         <h9><?php echo Yii::t('app','Publish at: ').$a->datePublish ?></h9>
						       </div>
				         <hr class="featurette-divider">
				
				             <?php }?>

                 <p class="pull-right" ><a href="#"> Retour <i class="fa fa-chevron-up"> </i> </a></p>
	   
				             
		          </div>
		

   				
		  </div>
</body>
       
    