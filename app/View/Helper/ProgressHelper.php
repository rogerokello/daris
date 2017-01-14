<?php
App::uses('AppHelper', 'View/Helper');

class ProgressHelper extends AppHelper{
    public function bar($value){
	$width = round($value / 100, 2) * 100;
	return sprintf(
	    '<divclass="progress-container">
		<divclass="progress-bar"style="width:%s%%"></div>
	     </div>', $width);
    }
}

?>