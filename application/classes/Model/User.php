<?php

class Model_User extends Model_Auth_User {
    
   
    public function labels() {
        return [
            'username'   => __('Username'),
            'email'      => __('Email'),
            'password'   => __('Password'),
        ];
    }
    
    public function rules() {
        return [
            'username' => array(
                ['not_empty'],
                ['max_length', [':value', 128]],
                [[$this, 'unique'], ['email', ':value']],
                [[$this, 'unique'], ['username', ':value']],
            ),
            'email' => [
                ['not_empty'],
                ['email'],
                ['max_length', [':value', 128]],
                [[$this, 'unique'], ['email', ':value']],
                [[$this, 'unique'], ['username', ':value']],
            ],
            'password' => [
                ['not_empty'],
            ],
        ];
    }
    
    
    public function filters() {
        return [
            'email' => [
                ['trim'],
            ],
            'password' => [
                [[Auth::instance(), 'hash']]
            ],
            'username' => [
                ['trim'],
                [function($value, $model) {                    
                    return empty($value) ? $model->email : $value;
                }, [':value', ':model']]
            ],
        ];        
    }
    
    /**
     * Password validation for plain passwords.
     *
     * @param array $values
     * @return Validation
     */
    public static function get_password_validation($values) {
        return Validation::factory($values)
            ->rule('password', 'not_empty')
            ->rule('password', 'min_length', [':value', 8])
            ->rule('password', 'regex', [':value', '/^(?=.*[\d])(?=.*[\D])\S+$/'])
            ->label('password', __('Password'))
            ;
    }
    
    /**
     * Generates a password to fit the password validation rule
     *
     * @return string
     */
    public static function generate_password() {
        
        do {
            $password = Text::random('alnum', 8);
        } while (!preg_match('/^(?=.*[\d])(?=.*[\D])\S+$/', $password));
        
        return $password;
    }
    
    /**
     * Generates restore token
     * @return type
     */
    public static function create_restore_token() {

        do {
            $token = sha1(uniqid(Text::random('alnum', 32), TRUE));
        } while (ORM::factory('User', array('restore_token' => $token))->loaded());

        return $token;
    }
    

}
