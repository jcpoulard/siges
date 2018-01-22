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
    <title>Assistant installation SIGES</title>

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

    <?php 
    
    $value_licence = "© 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
  
    This file is part of SIGES.

    SIGES is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    SIGES is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SIGES.  If not, see <http://www.gnu.org/licenses/>.";
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
                      <i class='glyphicon glyphicon-ban-circle'></i><span> Connexion base de donn&eacute;es <span class="badge" style="float: right;">2</span></span><br>
                      <i class='glyphicon glyphicon-ban-circle'></i><span> Finalisation installation <span class="badge" style="float: right;">3</span></sapn>
                  </div>
                </div>

                
              </div>
        </div>
    </div>

    <div class="col-md-6"  style="padding: 12px;">
        
     <div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="33.33"
  aria-valuemin="0" aria-valuemax="100" style="width:33.33%">
    <span class="sr-only">33.33% Complete</span>
    </div>
  </div>
         
        <form role="form" action="etape2.php" method="POST">
                  <div class="form-group">
                    <label for="comment">Condition d'utilisation de SIGES</label>
                    <textarea class="form-control" rows="15" id="comment" name="licence"><?php echo $value_licence; ?></textarea>
                </div>
                 
                 <div class="checkbox">
                     <label><input type="checkbox" value="0" name="acceptLicence" onchange="document.getElementById('btnContinue').disabled = !this.checked;" >J'accepte les conditions d'utilisation de la licence</label>
                </div>
                 
                 
            <button type="submit" class="btn btn-primary" id="btnContinue" name="btnContinue" disabled="true">Continuer</button>
             </form>
             
    </div>


    
   <div class="col-md-3">
        <div class="row-fluid">
            





                </div>

                
              </div>
        </div>
    </div>





        
</div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>