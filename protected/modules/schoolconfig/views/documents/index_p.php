<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		
		<style type="text/css">
			BODY,
			HTML {
				padding: 0px;
				margin: 0px;
			}
			BODY {
				font-family: Verdana, Arial, Helvetica, sans-serif;
				font-size: 11px;
				background: #EEE;
				padding: 5px;
			}
			
			H1 {
				font-family: Georgia, serif;
				font-size: 20px;
				font-weight: normal;
			}
			
			H2 {
				font-family: Georgia, serif;
				font-size: 16px;
				font-weight: normal;
				margin: 0px 0px 10px 0px;
			}
			
			.example {
				float: left;
				//margin: 2px;
			}
			
			.example2 {
				float: right;
				//margin: 2px;
				width: 78%;
				border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;
				//background: #FFF;
				
				
			}
			
			.demo {
				width: 200px;
				height: 400px;
				border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;
				background: #FFF;
				overflow: scroll;
				padding: 5px;
			}
			
		</style>
		
		<script src="jquery.js" type="text/javascript"></script>
		<script src="jquery.easing.js" type="text/javascript"></script>
		<script src="jqueryFileTree.js" type="text/javascript"></script>
		<link href="jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
      
		<input type="hidden" id="baseUrl" value="<?php echo explode("/",substr($_SERVER['REQUEST_URI'],0))[1] ?>" />
		
		  
		<!-- '../../siges/reportcard/'  -->
		
		<script type="text/javascript">
			
			$(document).ready( function() {
	
		var baseUrl=document.getElementById("baseUrl").value;
				//alert("@ "+baseUrl);
				$('#fileTreeDemo_1').fileTree({ root: '../../reportcard/', script: 'connectors/jqueryFileTree.php' }, function(file) { 
					//var str = 'test_23';
					//alert(str.substring('test_'.length));
					//window.open("siges/"+file, '_blank');
					var str_file = file.substring('../../'.length);
					//alert(file);
					$('#fileTreeDemo_2').html('<div id="pdf" style="padding:1px; width:100%; height:800px; "><object width="100%" height="100%" type="application/pdf" data="/'+baseUrl+'/'+str_file+'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV"> <p>"Viewer" sila pa ka li tip fichye sa. <br/> Ce "Viewer" ne supporte pas cette extension. <br/> This extension is not supported by the "Viewer"</p> </div>');
				});
				
				
								
			});
		</script>

	</head>
	
	<body>
	
	<div class="">
		<div class="example">
			<h2>Dossiers bulletins</h2>
			<div id="fileTreeDemo_1" class="demo"></div>
		</div>
	
		
		<div class="example2" >
			
			<div id="fileTreeDemo_2" class="" style="width:100%;"></div>
		</div>
	
	</div>	
	
				
	</body>
	
</html>