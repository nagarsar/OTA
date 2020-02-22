	<?php
			//call the onload functions here...
			updateRow();
			
			//function live linux execute command no return for this one
			function liveExecuteCommandMain($cmd)
			{
				while (@ ob_end_flush()); // end all output buffers if any
				$proc = popen("$cmd 2>&1 ; echo Exit status : $?", 'r');
				$live_output     = "";
				$complete_output = "";
				while (!feof($proc))
				{
					$live_output     = fread($proc, 4096);
					$complete_output = $complete_output . $live_output;
					@ flush();
				}
				pclose($proc);
				return array ();
			}
		 

			//fonction delete folder 
			function remove_directory($directory) {
				
				//ATTENTION, CAN CORRUPT 
				//THE ENTIRE PROJECT IF NOT RESPECTED !!!!!!!
				liveExecuteCommandMain("sudo rm -r '$directory'");

				//raffraichi la page
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';

			}
		 
			//fonction getdircontents
			function getDirContents($dir, &$results = array() ){
				$files = scandir($dir);

				foreach($files as $key => $value){
					$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
					if(!is_dir($path)) {
						$results[] = $path;
					} else if($value != "." && $value != ".." && $value!=".pioenvs") {
						getDirContents($path, $results);
						$results[] = $path;
					}
				}
				//return $results;
				return str_replace("/var/www/nathanhue.com/html/ota/sources/","",$results);;
			}
		 
		 
		 
			//Converting all the subdirectories into rows
			function updateRow(){
				
				$somePath='sources/';
				$activityNumber = 2;
							
				$subdirs = new DirectoryIterator($somePath);
				
				//Every Project will update following this pattern
				foreach ($subdirs as $fileinfo) {
					
					if ($fileinfo->isDir() && !$fileinfo->isDot()) {
						
						$folderName = $fileinfo->getFilename();
						
						$activityIdRow = "Row"      . $activityNumber;
						$activityId0 = "collapse0_" . $activityNumber;
						$activityId1 = "collapse1_" . $activityNumber;
						$activityId2 = "collapse2_" . $activityNumber;
						$activityId3 = "collapse3_" . $activityNumber;
						$activityId4 = "collapse4_" . $activityNumber;
						$activityId5 = "collapse5_" . $activityNumber;
		
						$listFileId = "list_file_id".$activityNumber;
						
						// pour afficher les entetes
						echo '<div class="panel-group" id="accordion">';
						echo '<div class="panel panel-default panel-active">';
						echo '<div class="panel-heading">';
						echo '<h4 id='.$activityIdRow.' class="panel-title">'; 
						echo '<a data-toggle="collapse" class="panel-toggle active collapsed" data-parent="#accordion" href="#'.$activityId0.'" aria-expanded="false"><i class="icon-folder"></i>  ' .$folderName.' </a> </h4></div>';
						echo '<div id="'.$activityId0.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">';
						
						//start pannel body
						echo '<div class="panel-body">';
						echo '<ul class="circled">';

						//description
						echo' <ul><i>'.file_get_contents('sources/'.$folderName.'/description.txt').'</i></ul>';
						
						//readme
						echo '<ul><a class="btn" data-toggle="collapse" data-target="#'.$activityId1.'" ><i class="icon-doc-text-inv"> README.MD</i></a></ul>'; 
						echo '<ul><div id="'.$activityId1.'" class="panel-collapse collapse" aria-expanded="false" style="">'; 
						echo '<pre>'.file_get_contents('sources/'.$folderName.'/README.md').'</pre>'; 
						echo '</div></ul>'; 
						
						//edit
						echo '<ul><a class="btn" data-toggle="collapse" data-target="#'.$activityId2.'" ><i class="icon-edit"> EDIT PROJECT </i></a></ul>'; 
						echo '<ul><div id="'.$activityId2.'" class="panel-collapse collapse" aria-expanded="false" style="">'; 
						echo '<iframe src="http://nathanhue.com/html/ota/fs.php"  height="800" scrolling="yes" style="position: relative; width: 100%;">'; 
						echo '  <p>Your browser does not support iframes.</p>'; 
						echo '</iframe>'; 
						echo '</div></ul>'; 
						
						//compile
						echo '<ul><a class="btn" data-toggle="collapse" data-target="#'.$activityId3.'" ><i class="icon-cog-alt"> COMPILE PROJECT </i></a></ul>'; 
						echo '<ul><div id="'.$activityId3.'" class="panel-collapse collapse" aria-expanded="false" style="">'; 
	
						echo '<ul><ul><button class="btn" onclick=getCompilation("'.$folderName.'"); ><i>launch compilation</i></button></ul></ul>'; 
						//echo '<ul><ul><div id="terminal" style="overflow-y:scroll; overflow-x:hidden; overflow-y:hidden;"></div></ul></ul>'; 
						echo '<ul><ul><div style="overflow-y:scroll; overflow-x:hidden; overflow-y:hidden;"><pre id="'.$folderName.'" class="prettyprint linenums" style="overflow-y:scroll; overflow-x:hidden; height:250px;"><ol class="linenums"></pre></div></ul></ul>'; 
						echo '</div></ul>'; 
						
						//download
						echo '<ul><a href="sources/'.$folderName.'/.pioenvs/teensy31/firmware.hex" download="'.$folderName.'.hex" class="btn"><i class="icon-download"> DOWNLOAD HEX FILE</i></a></ul>'; 
						
						//delete
						//echo '<ul><a class="btn btn-red"><i class="icon-cancel-1"> DELETE PROJECT</i></a></ul>'; 
						echo '<ul><button class="btn btn-red" onclick=removeElement("'.$folderName.'","'.$activityIdRow.'","'.$activityId0.'"); ><i class="icon-cancel-1"> DELETE PROJECT</i></button></ul>';
							
						//echo '<form action="" method="post"><input type="hidden" name="dir" value="'.$folderName.'" />';
						//echo '<input class="btn btn-red" type="submit" name="delete" value="Delete the project"/></form>';
						
						//stop pannel body
						echo '</ul>';
						echo '</div>';
						echo '</div>';
						echo '</div>';	

						$activityNumber++;
					}
				}
			}
			

			// Listen the POST method from DELETE button
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dir'])) {
				$dir = basename($_POST['dir']);
				if ($dir[0] != '.') {
					//echo 'remove_directory a ete trig par quele chose:'.$dir.'<br>';
					remove_directory("sources/$dir");
				}
			}
	?>