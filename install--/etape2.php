<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
     <title>Assistant installation SIGES: Cr&eacute;ation connexion base donn&eacute;es</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
     <link href="css/bootstrap.css" rel="stylesheet">
     <link href="css/bootstrap-theme.min.css" rel="stylesheet">
	 <link href="css/install.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
</head>
<body>
    
    <?php
       
            if(isset($_POST['btnContinue'])){
                
                $_SESSION["acceptLicence"] = TRUE;
              //  header('Location: etape2.php');
            }
        
       ?>  
   

      <div class="container-fluid">      
      <div class="row">
        
 <div class="alert-info">
	 <img src="css/logo.png"  alt="SIGES"> 
	 <span style="float: right; margin: 10px; font-weight: bold;"> Assistant d'installation de SIGES</span>   
	    
	</div>      


		<div class="">
	          
	              
          
          <div>
          
      </div>      
      
<div class="row"  style=" margin: 25px 0;" >
    <div class="col-md-3">
        <div class="row-fluid">
            <p></p>
        </div>
        
        <div class="row-fluid">
            <div class="panel-group">
                <div class="panel panel-info">
                  <div class="panel-heading">Statut de l'installation</div>
                  <div class="panel-body">
                      <i class='glyphicon glyphicon-check'></i><span> Acceptation de la licence <span class="badge"  style="float: right;">1</span></span><br>
                      <i class='glyphicon glyphicon-check'></i><span> Connexion base de donn&eacute;es <span class="badge" style="float: right;">2</span></span><br>
                      <i class='glyphicon glyphicon-ban-circle'></i><span> Finalisation installation <span class="badge" style="float: right;">3</span></sapn>
                  </div>
                </div>

                
              </div>
        </div>
    </div>


       <?php if(isset($_SESSION["acceptLicence"])) { ?>  
    <div class="col-md-6"style="padding: 12px;">
             
     <div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="66.66"
  aria-valuemin="0" aria-valuemax="100" style="width:66.66%">
    <span class="sr-only">66.66% Complete</span>
    </div>
  </div>
   <h4 class="alert-info1">Cr&eacute;ation connexion base donn&eacute;es</h4>

         <!-- finalisation.php -->
        <form data-toggle="validator" role="form" action="finalisation.php" method="POST" id="install">
                  <div class="form-group">
                    <label for="hostname">Adresse du serveur</label>
                    <input class="form-control" type="text" id="hostname" name="hostname" value="localhost" required/>
                  </div>
                 
                 <div class="form-group">
                    <label for="dbusername">Nom utilisateur base de donnees</label>
                    <input class="form-control" type="text" id="dbusername" name="dbusername" value="root" required/>
                  </div>
                 
                 <div class="form-group">
                    <label for="dbpassword">Password utilisateur base de donnees</label>
                    <input class="form-control" type="password" id="dbpassword" name="dbpassword"/>
                  </div>
                 
                 <div class="form-group">
                    <label for="dbname">Nom de la base de donnees</label>
                    <input class="form-control" type="text" id="dbname" name="dbname" required/>
                  </div>
                 
                 <div class="checkbox">
                    <label><input type="checkbox" value="1" name="includeTestData">Inclure des donn&eacute;es de test pour d&eacute;marrer rapidement</label>
                </div>
                 
                 
            <input type="submit" class="btn btn-primary" disabled name="btnEtape2" data-toggle="modal" data-target="#myModal" value="Installer" />
             </form>
        
              <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Installation en cours ...</h4>
        </div>
        <div class="modal-body">
          <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar"
              aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                
              </div>
           </div>
        </div>
          <div class="modal-footer">
              Patientez un instant, l'installation peut prendre quelques minutes...
          </div>
      </div>
      
    </div>
  </div>
             
          
    
    </div>
      
      
      
     <?php } else { echo "Imposible de continuer l'installation"; }?>   
    <div class="col-md-3">
        
    </div>
      
   

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.2.0.min.js"></script>
  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
        //alert("UTE");
         $(document).ready(function (){
            
            validate();
            
            $('#hostname, #dbusername, #dbname').change(validate);
     });

        function validate(){
            if ($('#hostname').val().length   >   0   &&
                $('#dbusername').val().length  >   0   &&
                $('#dbname').val().length    >   0) {
                $("input[type=submit]").prop("disabled", false);
            }
           else {
               $("input[type=submit]").prop("disabled", true);
            }
       
    }
     </script>
  </body>
</html>
