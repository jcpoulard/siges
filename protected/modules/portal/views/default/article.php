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
// number_article_per_page
// number_article_archive
if(infoGeneralConfig('number_article_per_page')!=null){
    $messagesParPage = infoGeneralConfig('number_article_per_page');
}else{
    $messagesParPage = 5;
}

if(infoGeneralConfig('number_article_archive')!=null){
    $archive_value = infoGeneralConfig('number_article_archive');
}else{
    $archive_value = 50;
}


$total = 0;

if(isset($_GET['menu'])){
        $menu = $_GET['menu'];
        $menu_label;
        $menu_ = CmsMenu::model()->findAllBySql("SELECT * FROM cms_menu WHERE id = $menu");
        foreach($menu_ as $m_){
           $menu_label = $m_->menu_label; 
        }
        
        $all_article = CmsArticle::model()->findAllBySql("SELECT id FROM cms_article WHERE set_position = 'main' AND is_publish = 1 AND article_menu = $menu ORDER BY id DESC");
        foreach($all_article as $aa){
            $total++;
        }
    if($total > $archive_value ){    
        $nombreDePages=ceil($archive_value/$messagesParPage);
    }else{
        $nombreDePages=ceil($total/$messagesParPage);
    }
 
     if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
    {
         $pageActuelle=intval($_GET['page']);

         if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
         {
              $pageActuelle=$nombreDePages;
         }
    }
    else // Sinon
    {
         $pageActuelle=1; // La page actuelle est la n°1    
    }
 
$premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
        
        $about_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'main' AND is_publish = 1 AND article_menu = $menu ORDER BY rank_article ASC, id DESC LIMIT $premiereEntree, $messagesParPage");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    


   
   
    <title><?php echo infoGeneralConfig('school_name').' - '.$menu_label; ?></title>
  



  </head>

<body>
           <div class="row featurette" style="margin-top: 20px;" >
        
             <?php foreach($about_ as $a) { ?>
		      
		        <div class="col-md-12">
		        
				          <h2 class="featurette-heading">  <?php echo $a->article_title; ?> </h2>
		
		     				<div class="comment more">
				         	 <p class="lead">
				             
				              
					              <?php echo $a->article_description; ?>
					       
                                                 
                                                 </p>
		 				</div> 	  
				            
				            
						       <div style="text-align: right">
						         <h9><?php echo Yii::t('app','Publish at: ').$a->datePublish ?></h9>
						       </div>
				         <hr class="featurette-divider">
				</div>
				             <?php }?>
               
<!-- S'il y a plusieurs page dans cette page --> 

<?php if($nombreDePages>1) { ?> 
               
<nav>  
    <ul class="paj">
        <li>
      <a href="<?php
      if($pageActuelle>1){
          $previous = $pageActuelle-1;
          echo Yii::app()->baseUrl."/index.php/portal/default/article?menu=$menu&page=$previous";
          }else{
              $previous = $pageActuelle;
              echo Yii::app()->baseUrl."/index.php/portal/default/article?menu=$menu&page=$previous";
          }   
      
      ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
<?php
    //Pour l'affichage, on centre la liste des pages
for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
{
     //On va faire notre condition
     if($i==$pageActuelle) //Si il s'agit de la page actuelle...
     {
         echo '<li class="active"><a> '.$i.' </a></li>'; 
     }	
     else //Sinon...
     {
          echo '<li><a href="'.Yii::app()->baseUrl.'/index.php/portal/default/article?menu='.$menu.'&page='.$i.'"> '.$i.' </a></li> ';
     }
}


?> 
    <li>
      <a href="<?php
            if($pageActuelle == $nombreDePages){
                $next = $pageActuelle; 
                echo Yii::app()->baseUrl."/index.php/portal/default/article?menu=$menu&page=$next";
            }else{
                $next = $pageActuelle+1; 
                echo Yii::app()->baseUrl."/index.php/portal/default/article?menu=$menu&page=$next";
            }
      ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    
    <?php
    if($total > $archive_value){
        echo '<li><a href="'.Yii::app()->baseUrl.'/index.php/portal/default/archives?menu='.$menu.'&archi='.$archive_value.'&tot='.$total.'" >Archives</a></li>';
    }
    
?>
    
    </ul>
    
</nav>
   

 
<!-- Fin du test du nombre de page  -->               
<?php } ?>               
               
<p class="pull-right" ><a href="#"> Retour <i class="fa fa-chevron-up"> </i> </a></p>
	   
				             
		          </div>
		

   				
		  
</body>
       
    