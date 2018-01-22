<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$admin_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'admission' AND is_publish = 1 ORDER BY id DESC LIMIT 10");
$default_text =Yii::t('app',"Termes et condition pour l'inscription a l'ecole.<br/>Les eleves doivent....");
?>

<div class="row-fluid" style=" width: 100%; margin: 50px auto  10px;" >
    
    <div class="col-md-2">
        
    </div>
    
     <div class="col-md-8">
        <?php
        if($admin_!=null){
        foreach($admin_ as $a){
            if($a->article_title!=""){
                echo $a->article_description; 
            }
            
        }
        }else{
            echo $default_text;
        }
        
        ?>
         <br/><br/><br/><br/><br/><br/><br/>
         <span class="glyphicon glyphicon-info-sign" style="text-align:left; color:red;" ></span>
             <a href="<?php echo Yii::app()->baseUrl?>/index.php/portal/default/admission">Remplir formulaire admission</a>
         
    </div>
    
     <div class="col-md-2">
        
    </div>
    
</div>

