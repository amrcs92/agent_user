<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class UserCtrl extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');       
        $this->load->model('UserModel');
        $this->load->helper('file');
        $this->load->library('user_agent');
    }

    // home page
    public function index()
    {
        $data['browser'] = $this->agent->browser();
        $data['browser_version'] = $this->agent->version();
        $data['os'] = $this->agent->platform();
        $data['ip_address'] = $this->input->ip_address();
        date_default_timezone_set('Africa/Cairo');
        $data['last_login'] = date('y-m-d h:i:sa');
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
        
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if($this->form_validation->run())
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->UserModel->login($username, $password);
            
            if($this->UserModel->login($username, $password))
            {
                // $remember = $this->input->post('remember_me');
                // if ($remember) 
                // {
                //     // Set remember me value in session
                //     $this->session->set_userdata('remember_me', TRUE);
                // }
                $sessionData = array(
                    'user_id' => $user[0]->id,
                    'username' => $username                
                );
                $this->session->set_userdata($sessionData);

                $data['user_id'] = $user[0]->id;
                $data['ip_address'] = $this->input->ip_address();
                $data['device_type'] = $this->agent->platform();
                $data['browser_details'] = $this->agent->browser() . $this->agent->version();

                // set your timezone according your location 
                // date_default_timezone_set('your_timezone')

                date_default_timezone_set('Africa/Cairo');
                $data['last_login'] = date('y-m-d h:i:sa');

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

    public function logout()
    {
        $this->session->unset_userdata([]);
        $this->session->sess_destroy();
        redirect('UserCtrl/index');
    }

    public function forgetPass()
    {
        $this->load->view('template/header');
        $this->load->view('template/navbar');
        $this->load->view('forget_pass/index');
        $this->load->view('template/footer');
    }

    // profile page

    public function profile($userid)
    {
        $this->load->view('template/header');
        $this->load->view('template/navbar');
        $userid = $this->session->userdata('user_id');
        $userData = $this->UserModel->read($userid);
        $this->load->view('user/read', $userData[0]);
        $this->load->view('template/footer');
    }

    // edit profile page

    public function editProfile()
    {
        $this->load->view('template/header');
        $this->load->view('template/navbar');
        $userid = $this->session->userdata('user_id');
        $userData = $this->UserModel->read($userid);
        $this->load->view('user/update', $userData[0]);
        $this->load->view('template/footer');
    }

    // 

    public function updateUser($userid)
    {
        if($this->session->userdata('user_id') == $userid)
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

                $userid = $this->session->userdata('user_id');
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
    }

    public function changePassword($userid)
    {
        if($this->session->userdata('user_id') == $userid){
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
    }

    public function changeForgetPassword($userid, $token)
    {
        $this->load->view('template/header');
        $this->load->view('template/navbar');
        $this->load->view('change_forget_pass/index');
        $this->load->view('template/footer');

        $validation = array(
            array(
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Please Enter your new password'
                )
            ),
            array(
                'field' => 'same_password',
                'label' => 'Same Password',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Please Enter your new password again'
                )
            )
        );

        $this->form_validation->set_rules($validation);
        
        $newPass = $this->input->post('new_password');

        if($newPass) 
        {
            if($this->form_validation->run() == TRUE)
            {
                $data = array(
                    'password' => password_hash($newPass, PASSWORD_BCRYPT)
                );
                $this->UserModel->updatePass($userid, $data);
                $this->session->set_flashdata('password_changed', 'Password Successfully changed');
                redirect('UserCtrl/login/');
                
            }            
        }                
    }

    public function resetPass()
    {
        if(isset($_POST['email']) && !empty($_POST['email']))
        {
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|min_length[6]|max_length[50]|valid_email');
            if($this->form_validation->run() == TRUE)
            {
                $email = $this->input->post('email');
                $row = $this->UserModel->emailExist($email);
                
                $email = $this->UserModel->getEmailByUserid($row->id);

                $data = array(
                    'user_id' => $email->user_email,
                    'token' => bin2hex(random_bytes(32))
                );
                $this->UserModel->createResetToken($data);                

                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'example@gmail.com',
                    'smtp_pass' => 'xxxxxx',
                    'mailtype'  => 'html', 
                    'starttls'  => true,
                    'newline'   => "\r\n"
                );

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                // Set to, from, message, etc.
                    
                    $this->email->from('someuser@gmail.com', 'Forget password');
                    $this->email->to('example@gmail.com');
                    $this->email->subject('Forget password');
                    $this->email->message('Your password is '. $row->password);
                    $this->email->send();                
                    redirect('UserCtrl/changeForgetPassword/'.$data['user_id'].'/'.$data['token']);
            }
        }
    }

    public function deleteAccount()
    {
        if(empty($this->session->userdata('username')))
        {
            redirect('UserCtrl/login');
        } 
        else
        {
            $this->load->view('template/header');
            $this->load->view('template/navbar');
            $this->load->view('user/delete');
            $this->load->view('template/footer');
        }
    }

    public function deleteUser($userid)
    {
        if($this->session->userdata('user_id') == $userid)
        {
            $this->UserModel->remove($userid);
            $this->session->sess_destroy();
            redirect('UserCtrl/index');
        }
    }
}