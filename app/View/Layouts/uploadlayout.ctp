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
	    echo $this->Html->script(array('jquery'));

	?>
	<script type="text/javascript">
	//<![CDATA[
$(document).ready(function (e) {
  $(function() {
    $("#uploadedfile").change(function() {
      //$("#message").empty();

      var file = this.files[0];
      if(!(this.files[0].type.match('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')))
      {
	  $("#uploadedfile").val(null);
	  
	  alert("Please select a valid Excel file, The only type allowed is the Excel 2007 - Excel 2010 format");
      }
    });
 
  });
 });
 
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
	  #drop-nav ul ul ul {left:95%; top: 0;}
	  
    </style>
    <div id="drop-nav">
	<ul>
	  <!-- <li><a href="/daris/students/">Home</a></li> -->
	  
	  <!--
	  <li><a href="#">Staff</a>
	  <ul>
	  <li><a href="/daris/staffdetails/">View all</a></li>
	  <
	  li><a href="/daris/staffdetails/add">Add New</a></li>
	  </ul>
	  </li>
	  -->
	  
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
	  <li><a href="/daris/Olevelreportdetails/">O-level Academic Results</a></li>
	  <!--
	  <li>
	      <a href="#">Student Reports</a>
	      <ul>
		  <li><a href="#"> New</a></li><!-- Add a new student report to the collection of reports 
		  <li><a href="#"> Edit</a></li><!-- Edit a student report from a collection of reports 
		  <li><a href="#"> Delete</a></li><!-- Delete a student report from a collection of reports 
	      </ul>
	  </li>
	  
	  <li><a href="#">Comment</a></li> -->
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
				<?php /*echo $cakeVersion;*/ ?>
			</p>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
	<?php   echo $this->Js->writeBuffer();?>


</body>
</html>
