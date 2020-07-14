<?php

class Controller_Ajax extends Controller {
    
    public function before() {
        parent::before();
        
        if (!Security::check($this->request->post('_csrf'))) {
           throw HTTP_Exception::factory(400, 'Invalid token');
        }
        
        $this->response->headers('Content-Type', 'application/json; charset='.Kohana::$charset);
    }
    
    /**
     * /ajax/content method
     */
    public function action_content() {
        $this->response->body(json_encode(Model::factory('Content')->get_news()));
    }
    
    /**
     * /ajax/registration method
     */
    public function action_registration() {
        
        $response = [];
        
        $user = Model::factory('User')->values([
            'username' => $this->request->post('username'),
            'email'    => $this->request->post('email'),
            'password' => $this->request->post('password'),
        ]);
        
        try {
            $user->save(Model_User::get_password_validation($this->request->post()));
            $user->add('roles', 1);
            $response['status'] = 'Registration completed';
        }
        catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('orm_validation');
            $response['errors'] = $errors + Arr::get($errors, '_external', []);
            unset($response['errors']['_external']);
        }
        
        $this->response->body(json_encode($response));
    }
    
    /**
     *  /ajax/login method
     */
    public function action_login() {
        
        $response = [];
        
        $validation = Validation::factory($this->request->post())
            ->rule('username', 'not_empty')
            ->label('username', 'Username/Email')
            ->rule('password', 'not_empty')
            ->label('password', 'Password')
            ;
        
        if (Auth::instance()->logged_in()) {
            $response['status'] = 'You are already logged in';
        }
        elseif (!$validation->check()) {
            $response['errors'] = $validation->errors('validation');
        }
        elseif (Auth::instance()->login($this->request->post('username'), $this->request->post('password'))) {
            $response['status'] = 'Login is successful';
        } 
        else {                
            $response['status'] = 'Incorrect E-mail or password';
        }
        
        $this->response->body(json_encode($response));
    }
    
    /**
     *  /ajax/logout method
     */
    public function action_logout() {
        
        if (!Auth::instance()->logged_in()) {
            $this->response->body(json_encode(['status' => 'Can`t log out. You are not logged in yet']));
            return;
        }
        
        Auth::instance()->logout();
        $this->response->body(json_encode(['status' => 'You have been logged out at '.date('H:i:s')]));
    }
    
    /**
     * /ajax/forgot method
     */
    public function action_forgot() {
        
        $response = [];
        
        $validation = Validation::factory($this->request->post())
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->label('email', 'Email address')
            ;
        
        if (Auth::instance()->logged_in()) {
            $response['status'] = 'You are already logged in';
        }
        elseif (!$validation->check()) {
            $response['errors'] = $validation->errors('validation');
        }
        else {
            $user = ORM::factory('User', ['email' => $this->request->post('email')]);
            if ($user->loaded()) {
                $user->restore_token = $token = Model_User::create_restore_token();
                $user->restore_token_expires_at = time() + Date::MINUTE*20;
                $user->update();
                // TODO: Use a mailing service, eg. Swiftmailer etc.
                $subject = 'Restoring access';
                $message = 'Follow the link to restore access: '
                           .Route::url('restore', ['token' => $token], TRUE);
                $headers = 'From: no-reply@' . gethostname() . "\r\n" .                    
                           'X-Mailer: TestMailer/1.0';
                mail($user->email, $subject, $message, $headers);
                
                $response['status'] = 'Instructions for restoring access have been sent to the specified email address';
            }
            else {
                $response['status'] = 'User not found';
            }
        }        
                
        $this->response->body(json_encode($response));
    }
    
    /**
     * /ajax/exchangerate method
     */
    public function action_exchangerate() {
                
        $validation = Validation::factory($this->request->post())
                    ->rule('currency', 'not_empty')
                    ->rule('currency', 'alpha')
                    ->rule('currency', 'exact_length', [':value', 3])
                    ->label('currency', 'Currency code')
                    ;
        
        if (!$validation->check()) {
            $this->response->body(json_encode([
                'errors' => $validation->errors('validation'),
            ]));
            return;
        }
        
        $this->response->body(json_encode([
            'status' => Model::factory('Content')->get_currency_value($this->request->post('currency')),
        ]));
    }
    
    /**
     * /ajax/word method
     */
    public function action_word() {
        
        $response = [];
        
        $word = Model::factory('Word');
        $word->name = $this->request->post('name');
        
        try {
            $word->save();
            $response['status'] = 'The word '.$word->name.' has been added with ID: '.$word->id;
        }
        catch (ORM_Validation_Exception $e) {
            $response['errors'] = $e->errors('orm_validation');
        }
        
        $this->response->body(json_encode($response));
    }
    
    /**
     * ajax/words method
     */
    public function action_words() {
        
        $page = (int) $this->request->post('page');
        $this->response->body(json_encode(Model::factory('Word')->get_words($page)));
    }
    
    /**
     * ajax/wordstat method
     */
    public function action_wordstat() {
        $this->response->body(json_encode(Model::factory('Word')->get_popular_words()));
    }

}
