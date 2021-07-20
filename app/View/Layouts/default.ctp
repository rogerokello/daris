<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'SGIS: St. Gracious Information System');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php 
	    echo $this->Html->script(array('jquery','webcam'));

	?>
	<script type="text/javascript">
	//<![CDATA[
$(document).ready(function (e) {
  $(function() {
    $("#StudentPicturepath").change(function() {
      //$("#message").empty();

      var file = this.files[0];
      if(!((this.files[0].type.match('image/jpeg')) || (this.files[0].type.match('image/png')) || (this.files[0].type.match('image/gif')) || (this.files[0].type.match('image/jpg'))|| (this.files[0].type.match('image/pjpg'))|| (this.files[0].type.match('image/x-png'))))
      {
	  $("#StudentPicturepath").val(null);
	  $("#StudentPicture").val(null);
	  if($('#shayhowe').attr('src') != "/daris/img/studentpics/person.png"){
	      $('#shayhowe').attr('src', "/daris/img/studentpics/person.png");
	  }
	  alert(document.getElementById('StaffdetailPicturepath').files[0].size);
	  //alert("Select Valid Image file type, The only types allowed are jpeg,png and gif formats");
      }else{
      
	//here I CHECK if the FILE SIZE is bigger than 200 KB (numbers below are in bytes)
        if (!(this.files[0].size > 204800))
        {
           //show an alert to the user
           alert("Allowed file size exceeded. (Max. 200 Kilobytes)");

           //reset file upload control
           $("#StudentPicturepath").val(null);
        }else{
	      var reader = new FileReader();
	      reader.onload = imageIsLoaded;
	      reader.readAsDataURL(this.files[0]);
	 }

      }
    });
    
    $("#StaffdetailPicturepath").change(function() {
      //$("#message").empty();

      var file = this.files[0];
      if(!((this.files[0].type.match('image/jpeg')) || 
	  (this.files[0].type.match('image/png')) ||
	  (this.files[0].type.match('image/gif')) || 
	  (this.files[0].type.match('image/jpg'))|| 
	  (this.files[0].type.match('image/pjpg'))|| 
	  (this.files[0].type.match('image/x-png'))
	))
      {
	  $("#StaffdetailPicturepath").val(null);
	  $("#StaffdetailPicturepath").val(null);
	  if($('#shayhowe').attr('src') != "/daris/img/staffpics/person.png"){
	      $('#shayhowe').attr('src', "/daris/img/staffpics/person.png");
	  }
	  alert("Select Valid Image file type, The only types allowed are jpeg,png and gif formats");
      }else{
	      var reader = new FileReader();
	      reader.onload = imageIsLoaded;
	      reader.readAsDataURL(this.files[0]);	  

      }
    });    
    
  });
  
  function imageIsLoaded(e) {
    $('#shayhowe').attr('src', e.target.result);
    //$('#shayhowe').attr('width','250px');
    $('#shayhowe').attr('height', '230px');
    var data_uri = e.target.result;
    var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
    
    if ($('#StudentPicture').length > 0) {
	  // exists.
	  document.getElementById('StudentPicture').value = raw_image_data;
    }
    
    if ($('#StaffdetailPicture').length > 0) {
	  // exists.
	  document.getElementById('StaffdetailPicture').value = raw_image_data; 
    }
    
    //document.getElementById('StudentPicture').value = raw_image_data;
    //document.getElementById('StaffdetailPicture').value = raw_image_data;    
  };

});
	//]]>
	</script>
	

	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		//echo $this->Html->meta('icon');
		echo $this->Html->meta('favicon.ico','img/favicon.ico',array('type' => 'icon'));
		echo $this->Html->css('cake.generic');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

</head>
<body>

	<div id="container">
		<div id="header">
     <style type="text/css">
	  #drop-nav ul {list-style: none; padding: 0px; margin: 0px;}
	  #drop-nav ul li {display: block; position: relative; float:left; border: 0px solid #000}
	  #drop-nav li ul {display: none;}
	  #drop-nav ul li a {display: block; background: #003d4c; padding: 5px 10px 5px 10px; text-decoration: none; white-space: nowrap; color: #fff;}
	  #drop-nav ul li a:hover {background: #003d4c;}
	  #drop-nav li:hover > ul {display:block; position: absolute; text-decoration:none;}
	  #drop-nav li:hover li {float: none; text-decoration:none;}
	  #drop-nav li:hover a {background: #003d4c; text-decoration:none;}
	  #drop-nav li:hover li a:hover {background: #003d4c; text-decoration:none;}
	  #drop-nav li ul li {border-top: 0px;}
	  #drop-nav ul ul ul {left:90%; top: 0;}
	  
    </style>
    

    
    
    <div id="drop-nav">
	<ul>
	  <!-- <li><a href="/daris/students/">Home</a></li> -->
	  
	  <!--
	  <li><a href="#">Staff</a>
	  <ul>
	  <li><a href="/daris/staffdetails/">View all</a></li>
	  <li><a href="/daris/staffdetails/add">Add New</a></li>
	  </ul>
	  </li>
	  -->
	  
	  <!--
	  <li><a href="#">Students</a>
	      <ul>
		  <li>
		      <a href="/daris/students/">View all</a>		  
		  </li>
		  <li>
		      <a href="/daris/students/add_olevel">Add O-level</a>
		  </li>
		  <li>
		      <a href="/daris/students/add_alevel">Add A-level</a>
		  </li>
	      </ul>
	  </li>
	  <li><a href="#">Results</a>
	      <ul>
		  <li><a href="#">View O-level</a>
		      <ul>
			  <li><a href="/daris/olevelmarksheetresults/viewOlevelResults">Single Student</a>
			  </li>
			  <li><a href="#">Single Class</a>
			  </li>
		      </ul>
		  </li>
		  <li><a href="/daris/olevelmarksheetresults/entermarks">Enter O-level</a>
		  </li>
		  <li><a href="/daris/olevelmarksheetresults/upLoadData">Upload Data</a>
		  </li>
		  <li><a href="#">Edit</a>
		  </li>
		  <li><a href="#">Comment</a>
		  </li>
	      </ul>
	  </li>
	  <li><a href="#">Reports</a>
	  <ul>
	  <li><a href="/daris/Olevelreportdetails/">Class Reports</a></li>
	  <li>
	      <a href="#">Student Reports</a>
	      <ul>
		  <li><a href="#"> New</a></li>
		  <li><a href="#"> Edit</a></li>
		  <li><a href="#"> Delete</a></li>
	      </ul>
	  </li>
	  <li><a href="#">Comment</a></li>
	  <li><a href="#">Upload</a></li>
	  </ul>
	  </li>
	  <li><a href="#">Settings</a>
	  <ul>
	  <li><a href="/daris/schoolstreams/">Streams</a></li>
	  <li><a href="/daris/schooldonesubjects/">O-level Subjects</a></li>
	  <li><a href="/daris/schooldoneasubjects/">A-level Subjects</a></li>
	  <li><a href="/daris/schooldoneexams/">Examinations</a></li>
	  <li><a href="/daris/schooldoneexams/">Grading</a>
	  <ul>
	  <li><a href="/daris/gradeprofiles/">Profiles</a></li>
	  <li><a href="#">Assign profiles</a></li>
	  </ul>	  
	  </li>
	  </ul>
	  </li>
	  <li><a href="#">Users</a>
	  <ul>
	  <li><a href="/daris/users/index">View all</a></li>
	  <li><a href="/daris/users/add">Add New</a></li>
	  </ul>
	  </li>
	  <li><a href="/daris/users/logout">logout</a></li>
	</ul>
	</div>
	-->
			<h1><?php // echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php /*echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);*/
			?>
			<p>
				<?php /* echo $cakeVersion; */?>
			</p>
		</div>
		
	</div>
	<?php //echo $this->element('sql_dump'); ?>
	<?php   echo $this->Js->writeBuffer();?>
	<!-- Configure a few settings and attach camera -->
	<script language="JavaScript">
	
		$("#takeaphoto").click( 
		  function(){
		      //alert("Am in");
		      var camerastatus = $("#takeaphoto").html();
		      if(camerastatus == "Turn on camera and take photo"){
			  $("#takeaphoto").html("Take a photo");

			  setWebcam();
		      }
		      //var camerastatus = $("#takeaphoto").html();
		      if(camerastatus == "Take a photo"){
			  $("#takeaphoto").html("Take a another photo");
			  take_snapshot();
		      }

		      if(camerastatus == "Take a another photo"){
			  $("#takeaphoto").html("Take a another photo");
			  take_snapshot();
		      }
		  }
		);
	  
		function setWebcam() {
		    Webcam.set({
			    width: 320,
			    height: 240,
			    image_format: 'jpeg',
			    jpeg_quality: 90
		    });
		    if(document.getElementById('shayhowe1')){
			Webcam.attach( '#shayhowe1' );
		    }
		}

		function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				//document.getElementById('results').innerHTML = 
				//	'<h2>Here is your image:</h2>' + 
				//	'<img src="'+data_uri+'"/>';
				$('#shayhowe').attr('src', data_uri);
				//$('#shayhowe').attr('width','250px');
				$('#shayhowe').attr('height', '230px');
				var data_uri2 = data_uri;
				var raw_image_data = data_uri2.replace(/^data\:image\/\w+\;base64\,/, '');
				document.getElementById('StudentPicture').value = raw_image_data;
				document.getElementById('StaffdetailPicture').value = raw_image_data;				
			} );
		}
	</script>

	<!-- Code to handle taking the snapshot and displaying it locally -->
	<script language="JavaScript">'tabmenu'
		/*function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				//document.getElementById('results').innerHTML = 
				//	'<h2>Here is your image:</h2>' + 
				//	'<img src="'+data_uri+'"/>';
				var data_uri2 = data_uri;
				var raw_image_data = data_uri2.replace(/^data\:image\/\w+\;base64\,/, '');
				document.getElementById('StudentPicture').value = raw_image_data;
			} );
		}*/
	</script>
</body>
</html>
