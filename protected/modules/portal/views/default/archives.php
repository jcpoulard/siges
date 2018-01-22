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

if(infoGeneralConfig('number_article_per_page')!=null){
    $messagesParPage = infoGeneralConfig('number_article_per_page');
}else{
    $messagesParPage = 5;
}

//$messagesParPage = 2;
$total = 0;
//$archive_value = 8;
$total_old = 0;

if(isset($_GET['archi']) && $_GET['tot']){
    $archive_value = intval($_GET['archi']); 
    $total_old = intval($_GET['tot']);
}
if(isset($_GET['menu'])){
        $menu = $_GET['menu'];
        
        $all_article = CmsArticle::model()->findAllBySql("SELECT id FROM cms_article WHERE set_position = 'main' AND is_publish = 1 AND article_menu = $menu ORDER BY id ASC LIMIT $archive_value, $total_old");
        foreach($all_article as $aa){
            $total++;
        }
        
        $nombreDePages=ceil($total/$messagesParPage);
    
 
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
        
        $about_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'main' AND is_publish = 1 AND article_menu = $menu ORDER BY id ASC LIMIT $premiereEntree, $messagesParPage");
}
?>


<body>
    <h1 class="alert-info">Archives</h1>
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
    <ul class="pagination pagination-sm">
        <li>
      <a href="<?php
      if($pageActuelle>1){
          $previous = $pageActuelle-1;
          echo Yii::app()->baseUrl."/index.php/portal/default/archives?menu=$menu&page=$previous&archi=$archive_value&tot=$total_old";
          }else{
              $previous = $pageActuelle;
              echo Yii::app()->baseUrl."/index.php/portal/default/archives?menu=$menu&page=$previous&archi=$archive_value&tot=$total_old";
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
          echo '<li><a href="'.Yii::app()->baseUrl.'/index.php/portal/default/archives?menu='.$menu.'&page='.$i.'&archi='.$archive_value.'&tot='.$total_old.'"> '.$i.' </a></li> ';
     }
}


?> 
    <li>
      <a href="<?php
            if($pageActuelle == $nombreDePages){
                $next = $pageActuelle; 
                echo Yii::app()->baseUrl."/index.php/portal/default/archives?menu=$menu&page=$next&archi=$archive_value&tot=$total_old";
            }else{
                $next = $pageActuelle+1; 
                echo Yii::app()->baseUrl."/index.php/portal/default/archives?menu=$menu&page=$next&archi=$archive_value&tot=$total_old";
            }
      ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    
    </ul>
</nav>
   

 
<!-- Fin du test du nombre de page  -->               
<?php } ?>               
               
<p class="pull-right" ><a href="#"> Retour <i class="fa fa-chevron-up"> </i> </a></p>
	   
				             
		          </div>
		

   				
		  
</body>
       
    