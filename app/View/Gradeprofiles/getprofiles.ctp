<?php 
	$uploadOptions = array(
	    "" => "Select a value",
	);
	
	$gradeprofilesintheschool = $uploadOptions + $gradeprofilesintheschool;
	
foreach ($gradeprofilesintheschool as $key => $value): 

?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php endforeach; ?>