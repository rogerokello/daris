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
	  //alert("Select Valid Image file type, The only types allowed are jpeg,png and gif formats");
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
    document.getElementById('StudentPicture').value = raw_image_data;
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
				);
				*/
			?>
			<p>
				<?php /*echo $cakeVersion; */?>
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
			} );
		}
	</script>

	<!-- Code to handle taking the snapshot and displaying it locally -->
	<script language="JavaScript">
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
