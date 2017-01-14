<?php
//print_r($marksgrading);
/*
foreach ($marksgrading as $key1){
 foreach($key1 as $key2){
     echo $key2['lowestvalue']."<br/>";
 }
}
*/
    if ( $results2 != null && $results3 != null ){
	
	$subject_names = array_keys($results2);
	
	$exam_names = array_keys($results2[$subject_names[0]]);
    }
    
?>


<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">View Student Results</legend>

<table>
    <tr>
    <th></th>
    <?php
	$number_of_exams_selected = 0;
	foreach ( $exam_names as $examname ) {
	
	    echo "<th>{$examname}</th>";
	    $number_of_exams_selected++;
	
	}	
    ?>
    <?php
	if ( $number_of_exams_selected == 1 ){
	
	    echo "<th>Final Mark</th>";
	
	}else {
	
	    echo "<th>Average Mark</th>";
    
	}
    ?>
    <th>Grade</th>
    </tr>
    <?php
	$sum_of_marks = 0;
	$number_of_exams_counter = 0;
	$average_mark = -1;
	foreach ($results2 as $subject_name => $exams_selected) {
	
	    $sum_of_marks = 0;
	    $number_of_exams_counter = 0;
	    $average_mark = 0;
	    echo "<tr>";
	    
		echo "<td><strong>{$subject_name}</strong></td>";
		
		foreach ($exams_selected as $exam_selected) {
		
		    echo "<td>{$exam_selected}</td>";
		    
		    if ($exam_selected != null) {
			$sum_of_marks = $sum_of_marks + $exam_selected;
			$number_of_exams_counter++;
		    }		    
		
		}
		if ( $number_of_exams_counter != 0) {
		    
		    $average_mark = ($sum_of_marks)/($number_of_exams_counter);
		    echo "<td>".$average_mark."</td>";
		    
		} else {
		
		    echo "<td></td>";
		
		}
		
		if ( ($number_of_exams_counter != 0) && ($average_mark != null) ){
		    $matchfound = 0;
		    $award = -1;
		    foreach ($marksgrading as $key1){
			foreach($key1 as $key2){
			    //echo $key2['lowestvalue']."<br/>";
			    if(($average_mark >= $key2['lowestvalue']) 
					      &&
				($average_mark < $key2['highestvalue'])
			      ){
			      
				  $matchfound = 1;
				  $award = $key2['award'];
				  break;
				  break;
			      }
			}
		    }
		    
		    if ($matchfound == 1) {
		    
			echo "<td>".$award."</td>";
		    
		    }else {
		    
			echo "<td></td>";
		    
		    }
		    
		
		}else {
		
		    echo "<td></td>";
		
		}
	    echo "</tr>";
	
	}
    
    ?>
</table>

</fieldset> 
<?php
    
?>
