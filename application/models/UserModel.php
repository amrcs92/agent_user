<?php 

class UserModel extends CI_Model 
{
    // check username & password matches in db to login
    function login($username, $password)
    {        
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $rowPass = $query->result()[0]->password;
        if($query->num_rows() == 1)
            if(password_verify($password, $rowPass)){
            {
                return $query->result();
            }
        }        
        return false;                
    }

    // check if email exist
    public function emailExist($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if($query->num_rows() == 1)
        {
            return $query->result()[0];            
        } 
        else
        {
            return false;
        }
    }

    // create reset token record for reset password
    public function createResetToken($data)
    {
        $this->db->insert('reset_token', $data);
    }

    // create user history
    public function createUserHistory($data){
        $this->db->insert('user_history', $data);
    }

    public function getLoggedinUserHistory($userid){
        $query = $this->db->query("SELECT * FROM user_history ORDER BY last_login DESC LIMIT 1");
        $result = $query->result_array();
        return $result;        
    }

    // create user 
    function register($data)
    {
        return $this->db->insert('users', $data);
    }

    // get user by id
    function read($userid)
    {
        $this->db->where('id', $userid);
        $query = $this->db->get('users');
        if($query->num_rows() == 1)
        {
            return $query->result();
        }
    }

    // update user data by user id
    function update($userid, $data)
    {
        $this->db->where('id', $userid);
        return $this->db->update('users', $data);
    }

    // update password by user id
    function updatePass($userid, $data)
    {
        $this->db->where('id', $userid);
        $this->db->update('users', $data);
        $this->db->trans_complete();
        if($this->db->affected_rows() == 1)
        {
            return true;
        } else{
            if($this->db->trans_status() === FALSE)
            {
                return false;
            }
            return true;
        }
    }

    // remove user record 
    function remove($userid)
    {
        $this->db->where('id', $userid);
        $this->db->delete('users');
    }
}