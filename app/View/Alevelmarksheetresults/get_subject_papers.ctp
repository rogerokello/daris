<?php
  // print_r($subjectsdoneintheschool);
  foreach($subjectsdoneintheschool as $key => $value) {
    if (empty($value) == False){
      echo "<option value='$key'>Paper $value</option>";
    }
  }

?>