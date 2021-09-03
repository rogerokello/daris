<?php
App::uses('AppModel', 'Model');
/**
 * Dependantdetail Model
 *
 * @property Staffdetail $Staffdetail
 */
class Reportsetting extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'staffdetail_id';

	public $primaryKey = 'id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

  public $validate = array(
	    'o_level_top_space' => array(   
	      'o_level_top_space_rule-1' => array(	   
            'allowEmpty' => true,
		        'rule'	=> array('comparison', '>=', 0),
		        'message'	=> 'The top space must be a value between 0 and 100 inclusive'
        ),
        'o_level_top_space_rule-2' => array(
          'allowEmpty' => true,   
          'rule'	=> array('comparison', '<=', 100),
          'message'	=> 'The top space must be a value between 0 and 100 inclusive'
        )
      ),
      'o_level_left_space' => array(   
        'o_level_left_space_rule-1' => array(	
          'allowEmpty' => true,    
          'rule'	=> array('comparison', '>=', 0),
          'message'	=> 'The top space must be a value between 0 and 100 inclusive'
        ),
        'o_level_left_space_rule-2' => array(	 
          'allowEmpty' => true,   
          'rule'	=> array('comparison', '<=', 100),
          'message'	=> 'The top space must be a value between 0 and 100 inclusive'
        )
      ),
	    'a_level_top_space' => array(
	      'a_level_top_space_rule-1' => array(	 
          'allowEmpty' => true,   
		      'rule'	=> array('comparison', '>=', 0),
		      'message'	=> 'It must be a value between 0 and 100 inclusive'
        ),
        'a_level_top_space_rule-2' => array(	  
          'allowEmpty' => true,  
          'rule'	=> array('comparison', '<=', 100),
          'message'	=> 'It must be a value between 0 and 100 inclusive'
        )
      ),
      'a_level_left_space' => array(
        'a_level_left_space_rule-1' => array(	   
          'allowEmpty' => true, 
          'rule'	=> array('comparison', '>=', 0),
          'message'	=> 'It must be a value between 0 and 100 inclusive'
        ),
        'a_level_left_space_rule-2' => array(	
          'allowEmpty' => true,    
          'rule'	=> array('comparison', '<=', 100),
          'message'	=> 'It must be a value between 0 and 100 inclusive'
        )
      ),

  );

}
?>