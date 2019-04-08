<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class UserCtrl extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form'); /* load form deault helper */
        $this->load->library('form_validation'); /* load form validation default library */
        $this->load->library('session'); /* load session default library */
        $this->load->model('UserModel'); /* load User Model custom model */
        $this->load->helper('file'); /* load file default helper */
        $this->load->library('user_agent'); /* load information about browser library */        
    }

    // home page
    public function index()
    {
        // display user browser & device infromation:
        // display browser type
        $data['browser'] = $this->agent->browser();
        // display browser version
        $data['browser_version'] = $this->agent->version();
        // display user device os
        $data['os'] = $this->agent->platform();
        // display user ip address
        $data['ip_address'] = $this->input->ip_address();
        // set time zone to africa/cairo
        date_default_timezone_set('Africa/Cairo');
        // display user loggedin/opened this page
        $data['last_login'] = date('d-m-Y h:i:s a');

        if(empty($this->session->userdata('user_id'))){
            $dataoff = $data;             
        } else{
            $data = $this->UserModel->getLoggedinUserHistory($this->session->userdata('user_id'));
        }
        $this->load->view('template/header');
        $this->load->view('template/navbar');
        $this->load->view('home/index', $data[0]??$dataoff);
        $this->load->view('template/footer');
    }

    // register form
    public function register()
    {
        if(!$this->session->userdata('user_id'))
        {
            $this->load->view('template/header');
            $this->load->view('template/navbar');
            $this->load->view('register/index');
            $this->load->view('template/footer');
        }
        else
        {
            redirect('UserCtrl/index');
        }     
    }

    // insert user data
    public function createUser()
    {      
        // user form data validation array (only required)
        $user = array(
            array(
                'field'  => 'username',
                'label'  => 'Username', 
                'rules'  => 'trim|required|is_unique[users.username]', 
                'errors' => array(
                    'required' => 'Username cannot be empty'
                )
            ),
            array(
                'field'  => 'email',
                'label'  => 'Email', 
                'rules'  => 'trim|required|valid_email|is_unique[users.email]', 
                'errors' => array(
                    'required' => 'Email cannot be empty'
                )
            ),
            array(
                'field'  => 'password',
                'label'  => 'Password', 
                'rules'  => 'trim|required|min_length[8]', 
                'errors' => array(
                    'required' => 'Password cannot be empty'
                )
            ),
            array(
                'field'  => 'company_name',
                'label'  => 'Company Name',
                'rules'  => 'trim|required|is_unique[users.company_name]',
                'errors' => array(
                    'required' => 'Company Name cannot be empty'
                )
            )
        );

        // validation form data
        $this->form_validation->set_rules($user);          
        // upload file
        $config['upload_path']          = './application/uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);
                           
        if($_FILES['company_logo']['size']!= 0)
        {
            if($this->file_check())
        	{
                if($this->upload->do_upload('company_logo')){
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData['file_name'];                    
                }  
                else
                {
                redirect('UserCtrl/register');
                return;
                }          
        	}          
        }
        if($this->form_validation->run() == true)
        {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'company_name' => $this->input->post('company_name'),
                'agent_name' => $this->input->post('agent_name') ?: null,
                'company_name' => $this->input->post('company_name'),
                'company_logo' => $uploadedFile ?: '',
                'phone' => $this->input->post('phone') ?: null,
                'mobile1' => $this->input->post('mobile1') ?: null,
                'mobile2' => $this->input->post('mobile2') ?: null,
                'address' => $this->input->post('address') ?: null,
                'postal_code' => $this->input->post('postal_code') ?: null,
                'country' => $this->input->post('country') ?: null,
                'state' => $this->input->post('state') ?: null                    
            );

            $userRegister = $this->UserModel->register($data);
            if($userRegister)
            {
                $this->session->set_flashdata('success', 'You have signed up successfully');
                redirect('UserCtrl/login');
            }
        }
        else 
        {
            redirect('UserCtrl/register');
        }                
    }

    // check file type
    public function file_check()
    {
        // if()
        $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
        $mime = get_mime_by_extension($_FILES['company_logo']['name']);
        if(isset($_FILES['company_logo']['name']) && $_FILES['company_logo']['name'] != '')
        {
            if(!in_array($mime, $allowed_mime_type_arr))
            {
                $this->session->set_flashdata('file_check', 'Couldn\'t upload your file, please select valid file format jpg/png/gif file');                            
                return false;
            }
            return true;        
        }
    }

    // login form
    public function login()
    {
        if(!$this->session->userdata('user_id')){
            $this->load->view('template/header');
            $this->load->view('template/navbar');
            $this->load->view('login/index');
            $this->load->view('template/footer');
        } else{
            redirect('UserCtrl/index');
        }
    }

    // check user data (username, password) for login & set session & track user ip
    // insert user history (user ip, os, browser details, last time loggedin, user id)
    public function getUser()
    {
        if(empty($this->session->userdata('user_id')))
        {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if($this->form_validation->run())
            {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
    
                $user = $this->UserModel->login($username, $password);
                
                if($this->UserModel->login($username, $password))
                {
                    $this->load->helper('cookie'); /* load cookie default form helper */
                    $remember = $this->input->post('remember_me');
                    
                    $usernameName = 'username';
                    $usernameValue = $username;
                    $usernameExpire = time() + (86400 * 30); 
                    $usernamePath = '/';                    
                    
                    if ($remember) 
                    {
                        setcookie($usernameName, $usernameValue, $usernameExpire, $usernamePath); // create cookie for username
                    }
                    else
                    {
                        setcookie($usernameName, '', 0, '/');                        
                    }

                    if(get_cookie('username') != null){
                        $sessionData = array(
                            'user_id' => $user[0]->id,
                            'username' => $usernameName                
                        );
    
                        $this->session->set_userdata($sessionData);
                    } else{
                        $sessionData = array(
                            'user_id' => $user[0]->id,
                            'username' => $username                
                        );
    
                        $this->session->set_userdata($sessionData);
                    }
    
                    $data['user_id'] = $user[0]->id;
                    $data['ip_address'] = $this->input->ip_address();
                    $data['device_type'] = $this->agent->platform();
                    $data['browser_details'] = $this->agent->browser() . $this->agent->version();
    
                    // set your timezone according your location 
                    // date_default_timezone_set('your_timezone')
    
                    date_default_timezone_set('Africa/Cairo');
                    $data['last_login'] = date('y-m-d H:i:s');
    
                    $this->UserModel->createUserHistory($data);
    
                    redirect('UserCtrl/index');
                } 
                else 
                {
                    $this->session->set_flashdata('error', 'Invalid Username and Password');
                    redirect('UserCtrl/login');
                }
            }
            else
            {
                $this->login();
            }
        } 
        else 
        {
            redirect('UserCtrl/index');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata([]);
        $this->session->sess_destroy();
        setcookie('username', '', 0, '/');        
        redirect('UserCtrl/index');
    }

    public function forgetPass()
    {
        if(!empty($this->session->userdata('user_id')))
        {
            redirect('UserCtrl/index');
        } 
        else
        {
            $this->load->view('template/header');
            $this->load->view('template/navbar');
            $this->load->view('reset_account/index');
            $this->load->view('template/footer');
        
        }
    }

    // profile page

    public function profile($userid=null)
    {
        if(!empty($this->session->userdata('user_id')))
        {
            $this->load->view('template/header');
            $this->load->view('template/navbar');
            $userid = $this->session->userdata('user_id');
            $userData = $this->UserModel->read($userid);
            $this->load->view('user/read', $userData[0]);
            $this->load->view('template/footer');
        } 
        else
        {
            redirect('UserCtrl/index');
        }
    }

    // edit profile page

    public function editProfile()
    {
        if(!empty($this->session->userdata('user_id')))
        {
        $this->load->view('template/header');
        $this->load->view('template/navbar');
        $userid = $this->session->userdata('user_id');
        $userData = $this->UserModel->read($userid);
        $this->load->view('user/update', $userData[0]);
        $this->load->view('template/footer');
        }
        else 
        {
            redirect('UserCtrl/index');
        }
    }

    // 

    public function updateUser($userid=null)
    {
        if(!empty($this->session->userdata('user_id')))
        {
            $user = array(
                array(
                    'field'  => 'username',
                    'label'  => 'Username', 
                    'rules'  => 'trim|required', 
                    'errors' => array(
                        'required' => 'Username cannot be empty'
                    )
                ),
                array(
                    'field'  => 'email',
                    'label'  => 'Email', 
                    'rules'  => 'trim|required|valid_email', 
                    'errors' => array(
                        'required' => 'Email cannot be empty'
                    )
                ),
                array(
                    'field'  => 'company_name',
                    'label'  => 'Company Name',
                    'rules'  => 'trim|required',
                    'errors' => array(
                        'required' => 'Company Name cannot be empty'
                    )
                ),                
            );

            // validation form data
            $this->form_validation->set_rules($user); 
            
            $config['upload_path']          = './application/uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            // $config['max_size']             = 100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            $this->load->library('upload', $config);

            $userid = $this->session->userdata('user_id');

            if($this->form_validation->run() == true)
            {

                $data = array(
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'company_name' => $this->input->post('company_name'),
                    'agent_name' => $this->input->post('agent_name') ?: null,
                    'company_name' => $this->input->post('company_name'),
                    // 'company_logo' => $uploadedFile ?: null,
                    'phone' => $this->input->post('phone') ?: null,
                    'mobile1' => $this->input->post('mobile1') ?: null,
                    'mobile2' => $this->input->post('mobile2') ?: null,
                    'address' => $this->input->post('address') ?: null,
                    'postal_code' => $this->input->post('postal_code') ?: null,
                    'country' => $this->input->post('country') ?: null,
                    'state' => $this->input->post('state') ?: null
                );
                
                if($_FILES['company_logo']['size']!= 0)
                {
                    if($this->file_check())
                    {
                        if($this->upload->do_upload('company_logo')){
                            $uploadData = $this->upload->data();
                            $data['company_logo'] = $uploadData['file_name'];                    
                        }  
                        else
                        {
                        redirect('UserCtrl/profile/'.$userid);                        
                        }          
                    }          
                }

                $userUpdated = $this->UserModel->update($userid, $data);
                if($userUpdated){
                    $this->session->set_flashdata('success', 'Profile updated successfully');
                    redirect('UserCtrl/profile/'.$userid);
                }
            }
            else 
            {
                redirect('UserCtrl/editProfile');
            }
        }
        else 
        {
            redirect('UserCtrl/index');
        }
    }

    // change password in your profile
    public function changePassword($userid=null)
    {
        if(!empty($this->session->userdata('user_id'))){
            $validation = array(
                array(
                    'field' => 'old_password',
                    'label' => 'Current Password',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'Please Enter your old password'
                    )
                ),
                array(
                    'field' => 'new_password',
                    'label' => 'New Password',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'Please Enter your new password'
                    )
                )
            );

            $this->form_validation->set_rules($validation);

            $userid = $this->session->userdata('user_id');

            $user = $this->UserModel->read($userid);
            $oldPass = $this->input->post('old_password');

            if($this->input->post('old_password')) 
            {
                if(password_verify($oldPass, $user[0]->password))
                {
                    if($this->form_validation->run() == TRUE)
                    {
                        $data = array(
                            'password' => password_hash($this->input->post('new_password'), PASSWORD_BCRYPT)
                        );
                        $this->UserModel->updatePass($userid, $data);
                        $this->session->set_flashdata('password_changed', 'Password Successfully changed');
                        redirect('UserCtrl/profile/'.$userid);
                    }
                           
                } 
                else
                {
                    $this->session->set_flashdata('wrong_old_password', 'Old password is wrong!!');

                    if($oldPass == $this->input->post('new_password'))
                    {
                        $this->session->set_flashdata('old_match_new', 'Old password matches new password');
                    } 
                    // redirect('UserCtrl/changePassword/'.$userid);
                    // return false;
                }
            }
            $this->load->view('template/header');
            $this->load->view('template/navbar');
            $this->load->view('change_password/index');        
            $this->load->view('template/footer');
        }
        else 
        {
            redirect('UserCtrl/index');
        }
    }

    //reset account & forget password 
    public function changeForgetPassword($tokenid=null, $userid=null, $token=null)
    {
        if(!empty($this->session->userdata('user_id')))
        {
            redirect('UserCtrl/index');
        }
        else{
            if($tokenid != null || $userid != null || $token != null)
            {
                $isUsedToken = $this->UserModel->getResetToken($tokenid);
                
                date_default_timezone_set('Africa/Cairo');
                
                if($isUsedToken[0]->used_token == 0 && (time() - strtotime($isUsedToken[0]->created_at) <= 1800))
                {
                    $err['token_will_expire'] = 'Token will expire after 30 minutes!!';                                    
                } else{
                    $err['token_expired'] = 'Token expired, reset you account again, redirecting after 3 seconds';
                    echo "<script> 
                        setTimeout(function(){
                            window.location.href ='".base_url()."UserCtrl/index';
                        }, 3000);      
                    </script>";            
                }
                
                $validation = array(
                    array(
                        'field' => 'new_password',
                        'label' => 'New Password',
                        'rules' => 'required|trim|matches[same_password]|min_length[8]',
                        'errors' => array(
                            'required' => 'Please Enter your new password'
                        )
                    ),
                    array(
                        'field' => 'same_password',
                        'label' => 'Same Password',
                        'rules' => 'required|trim|min_length[8]',
                        'errors' => array(
                            'required' => 'Please Enter your new password again'
                        )
                    )
                );
        
                $this->form_validation->set_rules($validation);
        
                $newPass = $this->input->post('new_password');
                $samePass = $this->input->post('same_password');
        
                if($this->form_validation->run() !== FALSE)
                {
                    $data = array(
                        'password' => password_hash($newPass, PASSWORD_BCRYPT)
                    );
                    $this->UserModel->updatePass($userid, $data);
                    $this->UserModel->updateTokenStatus($tokenid, $userid);
                    
                    redirect('UserCtrl/login/');                
                }
                else
                {
                    $this->load->view('template/header');
                    $this->load->view('template/navbar');
                    if(isset($err))
                    {
                        $this->load->view('change_forget_pass/index', $err);
                    }
                    else{
                        $this->load->view('change_forget_pass/index');
                    }
                    $this->load->view('template/footer');
                }    
            } 
            else
            {
                redirect('UserCtrl/index');
            }
        }
    }

    public function resetPass()
    {
        if(!empty($this->session->userdata('user_id')))
        {
            $this->session->set_flashdata('reset_account_failed', 'can\'t reset account while loggedin !!');
            redirect('UserCtrl/index');
        }
        else
        {
            $resetAccount = array(
                array(
                    'field' => 'email',
                    'label' => 'Email Address',
                    'rules' => 'required|trim|min_length[6]|max_length[50]|valid_email',
                    'errors' => array(
                        'required' => 'Email is required to reset the account!!',                        
                    )
                )
            );
            
            $this->form_validation->set_rules($resetAccount);

            $email = $this->input->post('email');
            $row = $this->UserModel->emailExist($email);
            if($row == null && $email != $row)
            {
                $invalidErr = array();
                $invalidErr['invalid_email'] = 'Invalid Email, Email doesn\'t exist';

                $this->load->view('template/header');
                $this->load->view('template/navbar');
                $this->load->view('reset_account/index', $invalidErr);
                $this->load->view('template/footer');                                                  
            }
            else 
            {
                if($this->form_validation->run() !== FALSE || ($email != ''))
                {                         
                    
                    $emailRow = $this->UserModel->getEmailByUserid($row->id);
                    
                    date_default_timezone_set('Africa/Cairo');
    
                    $data = array(
                        'user_id' => $row->id,
                        'token' => bin2hex(random_bytes(32)),                    
                        'created_at' => date('Y-m-d H:i:sa'),
                        'used_token' => 0
                    );
                    $tokenId = $this->UserModel->createResetToken($data);                
                    
                    $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'amrcs1992@gmail.com',
                        'smtp_pass' => 'AmrIsmailCS1992',
                        'mailtype'  => 'html', 
                        'starttls'  => true,
                        'newline'   => "\r\n"
                    );
        
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    // Set to, from, message, etc.
                        
                    $this->email->from('someuser@gmail.com', 'Forget password');
                    $this->email->to('amrcs1992@gmail.com');
                    $this->email->subject('Forget password');
                    $this->email->message("
                    <p>If you want to reset your account click on the link below</p>".
                    "<br/>".base_url()."UserCtrl/changeForgetPassword/".$tokenId."/".$data['user_id']."/".$data['token'].
                    "<p>OR click on the button below</p><br/>".
                    "<h4><a href=".base_url()."UserCtrl/changeForgetPassword/".$tokenId."/".$data['user_id']."/".$data['token']." style='padding:20px; background:#5bc0de; border-radius:5px; border-color:#46b8da; color:#fff;'>Reset account</a></h4>");
                    $this->email->send();                
        
                    $this->load->view('template/header');
                    $this->load->view('template/navbar');
                    $this->load->view('reset_account/message');
                    $this->load->view('template/footer');                
                } 
                else
                {                   
                    $this->load->view('template/header');
                    $this->load->view('template/navbar');
                    $this->load->view('reset_account/index');
                    $this->load->view('template/footer');
                }            
            }
        }
    }

    public function deleteAccount()
    {
        if(!empty($this->session->userdata('user_id')))
        {
            $this->load->view('template/header');
            $this->load->view('template/navbar');
            $this->load->view('user/delete');
            $this->load->view('template/footer');
        } 
        else
        {
            redirect('UserCtrl/login');
        }
    }

    public function deleteUser($userid)
    {
        if(!empty($this->session->userdata('user_id')))
        {
            $this->UserModel->remove($userid);
            $this->session->sess_destroy();
            redirect('UserCtrl/index');
        }
        else 
        {
            redirect('UserCtrl/index');
        }
    }
}