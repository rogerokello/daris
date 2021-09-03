<?php
// app/Model/User.php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
   
   public $validate = array(
        'username' => array(
            'nonBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'A username is required',
		'allowEmpty' => false
            ),
	    'between' => array( 
		'rule' => array('between', 3, 15), 
		'required' => true, 
		'message' => 'Usernames must be between 3 to 15 characters'
	    ),
	    'unique' => array(
		'rule'    => array('isUniqueUsername'),
		'message' => 'This username is already in use'
	    ),
	    'alphaNumericDashUnderscore' => array(
		 'rule'    => array('alphaNumericDashUnderscore'),
		 'message' => 'Username can only be letters, numbers and underscores'
	    ),
        ),
        
        'password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required'
            ),
	    'min_length' => array(
		'rule' => array('minLength', '6'),  
		'message' => 'Password must have a mimimum of 6 characters'
	    )
        ),
		
	'password_confirm' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Please confirm your password'
            ),
	    'equaltofield' => array(
		'rule' => array('equaltofield','password'),
		'message' => 'Both passwords must match.'
	    )
        ),
		
	'email' => array(
	    'required' => array(
		'rule' => array('email'),    
		'message' => 'Please provide a valid email address.'    
	     ),
	     'unique' => array(
		'rule'    => array('isUniqueEmail'),
		'message' => 'This email is already in use',
	     ),
	     'between' => array( 
		'rule' => array('between', 6, 60), 
		'message' => 'Emails must be between 6 to 60 characters'
	      )
	),
	
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array( 'admin','teacher')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),
	
        'password_update' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required'
            ),
	    'min_length' => array(
		'rule' => array('minLength', '6'),  
		'message' => 'Password must have a mimimum of 6 characters'
	    )
        ),
		
	'password_confirm_update' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Please confirm your password'
            ),
	    'equaltofield' => array(
		'rule' => array('equaltofield','password_update'),
		'message' => 'Both passwords must match.'
	    )
        ),
        'previous_password' => array(
            /*'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Please confirm your previous password'
            ),*/
	    'checkifsameasprevious' => array(
		  'rule' => array('checkifsameasprevious'),
		  'message' => 'Please provide the correct previous password',
	    ),
        ),
	
	/*'password_update' => array(
	     'min_length' => array(
		'rule' => array('minLength', '6'),   
		'message' => 'Password must have a mimimum of 6 characters',
		'allowEmpty' => true,
		'required' => false
	     )
        ),
        
	'password_confirm_update' => array(
	      'equaltofield' => array(
		  'rule' => array('equaltofield','password_update'),
		  'message' => 'Both passwords must match.',
		  'required' => false,
	      )
        )*/
		
   );
	
	function checkifsameasprevious($check){
	    
	    
	    $one = $check['previous_password'];
	    $passwordHasher1 = new BlowfishPasswordHasher();
	    //$one1 = $passwordHasher1->hash($one);
	    if(AuthComponent::user('role') == "admin"){
	    
		return true;
	    
	    }else{
	    
		$hashedtablepassword1 = $this->field('password',
		    array("username =" => $one)
		);
		
		/*$hashedtablepassword = $this->field('password',
		    array("username =" => $passwordHasher1->check($one,$hashedtablepassword1));*/
	    	    
		$passwordHasher = new BlowfishPasswordHasher();
		if($passwordHasher1->check($one,$hashedtablepassword1)){
	    
		    return true;
	    
		}else {
	    
		    return false;
	    
		}
	    }
	
	}
	
		/**
	 * Before isUniqueUsername
	 * @param array $options
	 * @return boolean
	 */
	function isUniqueUsername($check) {

		$username = $this->find(
			'first',
			array(
				'fields' => array(
					'User.id',
					'User.username'
				),
				'conditions' => array(
					'User.username' => $check['username']
				)
			)
		);

		if(!empty($username)){
			if($this->data[$this->alias]['id'] == $username['User']['id']){
				return true; 
			}else{
				return false; 
			}
		}else{
			return true; 
		}
    }

	/**
	 * Before isUniqueEmail
	 * @param array $options
	 * @return boolean
	 */
	function isUniqueEmail($check) {

		$email = $this->find(
			'first',
			array(
				'fields' => array(
					'User.id'
				),
				'conditions' => array(
					'User.email' => $check['email']
				)
			)
		);

		if(!empty($email)){
			if($this->data[$this->alias]['id'] == $email['User']['id']){
				return true; 
			}else{
				return false; 
			}
		}else{
			return true; 
		}
    }
	
	public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }
	
	public function equaltofield($check,$otherfield) 
    { 
        //get name of field 
        $fname = ''; 
        foreach ($check as $key => $value){ 
            $fname = $key; 
            break; 
        } 
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname]; 
    } 

	/**
	 * Before Save
	 * @param array $options
	 * @return boolean
	 */
	 public function beforeSave($options = array()) {
		// hash our password
		if (isset($this->data[$this->alias]['password'])) {
		    $passwordHasher = new BlowfishPasswordHasher();
		    $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		
		// if we get a new password, hash it
		if (isset($this->data[$this->alias]['password_update'])) {
		    $passwordHasher = new BlowfishPasswordHasher();
		    $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password_update']);
		}
	
		// fallback to our parent
		return parent::beforeSave($options);
	}

}
    
/*    public $validate = array(
	'username' => array(
	    'required' => array(
		'rule' => array('notBlank'),
		'message' => 'A username is required'
	    )
	),
	'password' => array(
	    'required' => array(
		'rule' => array('notBlank'),
		'message' => 'A password is required'
	    )
	),
	'role' => array(
	    'valid' => array(
		'rule' => array('inList', array('admin', 'author')),
		'message' => 'Please enter a valid role',
		'allowEmpty' => false
	    )
	)
    );
    
    public function beforeSave($options = array()) {
	if (isset($this->data[$this->alias]['password'])) {
	    $passwordHasher = new BlowfishPasswordHasher();
	    $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
	}
	return true;
    }
*/

?>
