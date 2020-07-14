<?php

class Controller_Restore extends Controller_Template {
    
    /**
     * @var  View  page template
     */
    public $template = 'restore';

    public function action_index() {
        
        $user = ORM::factory('User', array('restore_token' => $this->request->param('token')));
        
        if (!$user->loaded()) {
            throw HTTP_Exception::factory(400, 'Invalid Token');
        }    
            
        if ($user->restore_token_expires_at <= time()) {
            $user->restore_token            = NULL;
            $user->restore_token_expires_at = 0;
            $user->update();
            throw HTTP_Exception::factory(403, 'Token expired');
        }
        
        if ($this->request->method() === HTTP_Request::POST) {
                    
            $validation = $user->get_password_validation($this->request->post())
                        ->rule('password_confirm', 'matches', array(':validation', ':field', 'password'))
                        ->label('password_confirm', 'Password Confirmation')
                        ;

            if ($validation->check()) {
                $user->password = $this->request->post('password');
                $user->restore_token            = NULL;
                $user->restore_token_expires_at = 0;
                $user->update();
                $this->redirect(URL::base(TRUE));
            }
            else {
                $errors = $validation->errors('orm_validation/user/_external');
                $this->template->errors = $errors;
            }
        }
        
        $this->template->expires = $user->restore_token_expires_at;
        
    }
}