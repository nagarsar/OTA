<!DOCTYPE html>
<html lang="en" class=""><head>

<style type="text/css">.gm-style .gm-style-mtc label,.gm-style .gm-style-mtc div{font-weight:400}</style>
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<style type="text/css">.gm-style .gm-style-cc span,.gm-style .gm-style-cc a,.gm-style .gm-style-mtc div{font-size:10px}</style>
<style type="text/css">@media print {  .gm-style .gmnoprint, .gmnoprint {    display:none  }}@media screen {  .gm-style .gmnoscreen, .gmnoscreen {    display:none  }}</style>
<style type="text/css">.gm-style { font: 400 11px Roboto, Arial, sans-serif;text-decoration: none; }.gm-style img { max-width: none; }</style>
<link href="drop/css/dropzone.css" type="text/css" rel="stylesheet" />
<meta charset="utf-8">
<?php
header('X-Accel-Buffering: no'); // stop bufferize
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="style/images/favicon.png">


<title>Wireless Compiler Lab</title>

<!-- Bootstrap core CSS -->
<link href="style/css/bootstrap.min.css" rel="stylesheet">
<link href="style/css/plugins.css" rel="stylesheet">
<link href="style/css/prettify.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<link href="style/css/color/green.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Raleway:400,800,700,600,500,300" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic" rel="stylesheet" type="text/css">
<link href="style/type/fontello.css" rel="stylesheet">
<link href="style/type/budicons.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="style/js/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
<style type="text/css">.fancybox-margin{margin-right:17px;}</style><style id="fit-vids-style">.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/28/8/intl/fr_ALL/common.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/28/8/intl/fr_ALL/map.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/28/8/intl/fr_ALL/util.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/28/8/intl/fr_ALL/marker.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/28/8/intl/fr_ALL/onion.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/28/8/intl/fr_ALL/stats.js"></script><script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/28/8/intl/fr_ALL/controls.js"></script></head>
<body id="body" class="full-layout" style="overflow: visible;">
<div id="preloader" style="display: none;"><div id="status" style="display: none;"><div class="spinner"></div></div></div>
<div class="body-wrapper">




  <div class="page">
  <div class="container">


    <section>
	
    <div class="box">
	
	  <!-- Popup message -->
	  <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">     ×</button><strong>Welcome on the Wireless Compiler Lab</strong> <br>It has been built to help the user who needs a wireless solution for updating firmwares on the cortex M4 core <br> If you are interested in a compact solution do not hesitate to contact me: nathan.hue1@gmail.com<br> Enjoy ! :) </div>
      
	  <!-- Accordion begin -->
	  <div class="panel-group" id="accordion">
		<?php
			include 'row.php';
		?>
		<!--
		******************************************************************************
		COMPILATION AND DISPLAY
		******************************************************************************
		-->
		<script>
		// FUNCTION GET COMPILATION
		function getCompilation(folderName) {
			var request = new XMLHttpRequest();
			var url = "compilation.php";
			request.open("POST", url, true);
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send("folderName=" + folderName); 
			request.onreadystatechange = function() {
				//alert(folderName+","+request.responseText);
				showResponse(folderName,request.responseText);
				/*if(request.readyState == 4 && request.status == 200) {
				}*/
			}
		}

								
		// FUNCTION SHOWRESPONSE
		function showResponse(terminal,response) {
			//alert(terminal);
			var myText = document.getElementById(terminal);
			myText.innerHTML  = response ;
			myText.scrollTop = myText.scrollHeight;
			//myText.scrollTop = myText.scrollHeight - myText.clientHeight;
		} 
		
		
		
		function addElement(){
			// We remove the element from local storage
			var request = new XMLHttpRequest();
			var url = "row.php";
			request.open("POST", url, true);
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send("refresh=ok"); 
			request.onreadystatechange = function() {}
			location.reload();
		}
		
		
		// FUNCTION REMOVE_ELEMENT
		function removeElement(folderName,element0,element1) {
	
			if (confirm("Are you sure that you want to delete the projet: ["+folderName+"] ?")) {
				// We remove the html element 
				var element0 = document.getElementById(element0);
				var element1 = document.getElementById(element1);
				element0.parentNode.removeChild(element0);
				element1.parentNode.removeChild(element1);
				
				// We remove the element from local storage
				var request = new XMLHttpRequest();
				var url = "row.php";
				request.open("POST", url, true);
				request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				request.send("dir=" + folderName); 
				request.onreadystatechange = function() {}
			} else {
				// then ok...
			}
		} 
		
		</script>
		</div>
		<!-- Accordion end -->

		<!-- Accordion2 begin -->
		<div class="panel-group" id="accordion2">
		<div class="panel panel-default panel-active">
		
              <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" class="panel-toggle active collapsed" data-parent="#accordion2" href="#collapsFive" aria-expanded="false"><b class="icon-upload">  Add New project !</b></a> </h4>
              </div>
			  
              <div id="collapsFive" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">

					<!-- Dropzone Instanciation -->
					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
					<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
					<script src="drop/js/dropzone.js"></script>

					<form action="upload.php" class="dropzone" id="uploadFile" name="uploadFile" method="POST">
					  <span id="tmp-path"></span>
					</form>
					  
					<br>
					
					<form class="searchform" method="get">
						<input type="text" id="s2_name" name="s" value="Project Name" >
					</form>
					
					<br>
					
					<a id="submit_btn" class="btn" onclick=addElement(); data-toggle="collapse" data-target="#collapsFive" >Submit Your Sources</a>
						
				</div>
			  </div>
			</div>
			<!--
			******************************************************************************
			DROPZONE JAVASCRIPT AND SUBMIT BUTTON
			******************************************************************************
			-->
			<script>
			$(document).ready(function () {
				  
				Dropzone.autoDiscover = false;
				var list_files="";
				var activityId="";
				var listFileId="";
				var name = document.getElementById("s2_name");
				name.value="Project name";
				var a1 = document.createElement("a1");

				//setting this css style solving problem with new line in textContent
				a1.setAttribute('style', 'white-space: pre;');
				  

				  Dropzone.options.uploadFile = {
					init: function() {
					  this.on("success", function(file, responseText) {
						file.previewTemplate.appendChild(document.createTextNode(responseText));
					  });

					  this.on("sending", function(file) {

						list_files += file.fullPath+'\r\n';
						

						console.debug(file.fullPath+' nom chemin complet');
						var relpath = file.fullPath;
						var folder = relpath.split("/");
						console.debug(folder[0]+' nom dossier'); // folder[0] = nom du dossier 
						$("#tmp-path").html('<input type="hidden" name="path" value="'+file.fullPath+'" />')
						
						name.value = folder[0];

					  });
					}
				  };

				  var myDropzone = new Dropzone("#uploadFile", {
					  url: "upload.php"
				  });
				  
				  
				 // Initialize the activityNumber
				var activityNumber = 1;
				  
				
				
				// Select the accordion element
				var tracklistTable = document.getElementById("accordion");
				 
				// Select the submit_btn button
				/*var addButton = document.getElementById("submit_btn");				 
				// Attach handler to the button click event
				addButton.onclick = function() {
					
					myDropzone.removeAllFiles();
					addCustomElement();
			
					//location.reload();
					//myDropzone.disable();
				
					//activityId = "collapse"+activityNumber;
					//listFileId = "list_file_id"+activityNumber;

					// Add a new row to the table using the correct activityNumber
					//tracklistTable.innerHTML += '<div class="panel panel-default panel-active"><div class="panel-heading"><h4 class="panel-title"> <a data-toggle="collapse" class="panel-toggle active collapsed" data-parent="#accordion" href="#' + activityId + '" aria-expanded="false">'+name.value+'</a> </h4></div><div id="' + activityId + '" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;"><div class="panel-body"><ul class="circled"><i>'+description.value+'</i><br><a id="'+listFileId+'" href=" " target="_blank"> </a><a href="#" class="btn">Compile it !</a><br><a href="#" class="btn">Download Hexfile</a><br><a href="#" class="btn">Delete project</a></ul></div></div></div>';

					//a1.textContent = list_files;
					
					// a remplacer par un tableau de lignes
					//var newItem = document.createElement("a");
					//newItem.appendChild(a1);
					//var list = document.getElementById( listFileId );
					//list.insertBefore(a1, list.childNodes[0]);
					
					// Increment the activityNumber
					//activityNumber += 1;
				}*/

			  });
			</script>
		</div>
	  
	  
	  

	</div>
	<!-- /.box -->
	</section>
	<!-- /section -->
  </div>
  <!-- /.container -->
  </div>
  <!-- /.page -->
</div>
<!-- /.body-wrapper -->
<script src="style/js/jquery.min.js"></script>
<script src="style/js/bootstrap.min.js"></script>
<script src="style/js/jquery.themepunch.tools.min.js"></script>
<script src="style/js/classie.js"></script>
<script src="style/js/plugins.js"></script>
<script src="style/js/scripts.js"></script>
<script>
	$.backstretch(["style/images/art/bg1.jpg"]);
</script>
</body>
</html>
