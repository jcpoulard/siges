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

     <body>
    <?php
             
             function createDataBase($h, $u, $p,$db){
                 
                $servername = $h;
                $uname = $u;
                $pass = $p;
                $test=FALSE; 
                // Create connection
                $conn = new mysqli($servername, $uname, $pass);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 

                // Create database
                $sql = "CREATE DATABASE $db DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci";
                if ($conn->query($sql) === TRUE) {
                    $test = TRUE;
                } else {
                    $test = FALSE; 
                    
                }

                $conn->close();
                return $test; 
             }
             
             function uploadDbFile($h, $u, $p, $db, $file){
                 set_time_limit(600);
                 ini_set('memory_limit','32M');
                 $test_complete = FALSE;
                 // Connect to MySQL server
                 $conn = new mysqli($h,$u,$p);
                 // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                //$sql = "USE $db";
                $conn->select_db($db);
                
                  //  mysql_connect($h, $u, $p) or die('Error connecting to MySQL server: ' . mysql_error());
                 // Select database
                 //   mysql_select_db($db) or die('Error selecting MySQL database: ' . mysql_error());

                 // Temporary variable, used to store current query
                $templine = '';
                // Read in entire file
                $lines = file($file);
                // Loop through each line
                foreach ($lines as $line)
                {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;

                // Add this line to the current segment
                $templine .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';')
                {
                    // Perform the query
                    if($conn->query($templine)==TRUE){
                        $test_complete = TRUE;
                        
                    }else{
                        echo $conn->error;
                    }
                    
                   // mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                    // Reset temp variable to empty
                    $templine = '';
                }
                }
                $conn->close();
                 $_SESSION['message3'] = "Données du fichier <b>$file</b> transféré avec succès vers la base <b>$db</b> !<br/>";
                 return $test_complete;
             }
             
             if(isset($_POST['hostname']) && isset($_POST['dbusername']) && isset($_POST['dbpassword']) && isset($_POST['dbname'])){
                 if(isset($_POST['btnEtape2'])){
                     $_SESSION['hostname'] = $_POST['hostname'];
                     $_SESSION["dbusername"] = $_POST["dbusername"];
                     $_SESSION["dbpassword"] = $_POST["dbpassword"];
                     $_SESSION["dbname"] = $_POST["dbname"];
                     if(isset($_POST['includeTestData']) && $_POST['includeTestData'] == 1){
                         $_SESSION['includeTestData'] = 1;
                     }else{
                         $_SESSION['includeTestData'] = 0;
                     }
                     
                    $hostname = $_SESSION['hostname'];
                    $username = $_SESSION['dbusername'];
                    $password = $_SESSION['dbpassword'];
                    $dbname = $_SESSION['dbname'];
                    $_SESSION['message1'] = "Récupération des données de l'instalation terminée avec succès !<br/>";
                    if(createDataBase($hostname, $username, $password, $dbname)){
                       
                        $_SESSION['message2'] = "Base de données <b>$dbname</b> crée avec succès ! <br/>";
                        if($_SESSION['includeTestData']==1){
                            $file = "db/siges_test.sql";
                        }else{
                            $file = "db/siges_blank.sql";
                        }
                        if(uploadDbFile($hostname, $username, $password, $dbname, $file)){
                    $siges_db_config = '../protected/config/db.php'; // Modifier le nom du fichier 
                    $fh = fopen($siges_db_config, 'w') or die("Impossible d'ouvir un fichier");
                    $stringData = "<?php \n return array('connectionString'=>'mysql:host=$hostname;dbname=$dbname',\n'emulatePrepare'=>true,\n'username'=>'$username',\n'password'=>'$password',\n'charset'=>'utf8'); \n?>";
                    fwrite($fh, $stringData);
                    fclose($fh);
                    $_SESSION['message4'] = "Fichier de configuration de SIGES crée avec succès à l'adresse : <b>$siges_db_config</b> <br/>";
                    // creation d'un fichier pour certifier que le l'installation a reussi
                    $test_file = '../install.siges';
                    $file_open = fopen($test_file,'w');
                    $value_ = "1";
                    fwrite($file_open,$value_);
                    fclose($file_open);
                        }else{ echo 'Erreur de chargement fichier !';}
                    }else{
                        echo 'Impossible de créer la base de données.';
                    }
                     
                 }
                 
             }
             
             
             function getBaseUrl() 
                {
                    // output: /myproject/index.php
                    $currentPath = $_SERVER['PHP_SELF']; 

                    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
                    $pathInfo = pathinfo($currentPath); 

                    // output: localhost
                    $hostName = $_SERVER['HTTP_HOST']; 

                    // output: http://
                    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
                    
                    $take_path = explode("/", $pathInfo['dirname']);    
                    // return: http://localhost/myproject/
                    if(count($take_path)>1){
                        $url = $protocol.$hostName.'/'.$take_path[1]."/";
                    }else{
                        $url = $protocol.$hostName.$pathInfo['dirname']."/";
                    }
                    return $url;
            }
             
            
            
            // echo $_SESSION['includeTestData'];
             ?>


<div class="container-fluid">      
      <div class="row">
        
 <div class="alert-info">
	 <img src="css/logo.png"  alt="SIGES"> 
	 <span style="float: right; margin: 10px; font-weight: bold;"> Assistant d'installation de SIGES</span>   
	    
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
                       <i class='glyphicon glyphicon-check'></i><span> Finalisation installation <span class="badge" style="float: right;">3</span></sapn>
                  </div>
                </div>

                
              </div>
        </div>
    </div>

    <div class="col-md-6"  style="padding: 12px;">
          
     <div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="100"
  aria-valuemin="0" aria-valuemax="100" style="width:100%">
    <span class="sr-only">100% Complete</span>
    </div>
  </div>
    
<h3 class="alert-info1">Installation de SIGES Termin&eacute;e</h3>
     
       <div class="alert alert-warning">
           <strong><i class="glyphicon glyphicon-alert"></i></strong>
           SIGES a &eacute;t&eacute; install&eacute; avec succès !<br/>
           Les informations de connexion :<br/>
           <b>Nom d'utilisateur : </b> admin<br/>
           <b>Mot de passe: </b>admin<br/>
           Cliquez sur Terminer pour connecter &agrave; SIGES
       </div> 
        <h3 class="alert-info1"> Rapport de l'installation</h3>

      <div class="alert alert-success">
          <strong><i class="glyphicon glyphicon-camera"></i></strong> <?php echo $_SESSION["message1"]; ?>
          <br/>
          <strong><i class="glyphicon glyphicon-floppy-save"></i></strong> <?php echo $_SESSION["message2"]; ?>
          <br/>
          <strong><i class="glyphicon glyphicon-upload"></i></strong> <?php echo $_SESSION["message3"]; ?>
          <br/>
          <strong><i class="glyphicon glyphicon-pencil"></i></strong> <?php echo $_SESSION["message4"]; ?>
      </div>  
        
       
        
        <a href="<?php echo getBaseUrl(); ?>" class="btn btn-success">Terminer</a> 
         
       
    
    </div>
    
    <div class="col-md-3">
        
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>