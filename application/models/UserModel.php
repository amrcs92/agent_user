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
        $this->db->select('id, email');
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
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
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    // join 2 tables users & rest_token to get user email by user_id
    public function getEmailByUserid($userid)
    {
        $this->db->select("reset_token.*, users.email as user_email")->from('reset_token')->join('users', 'users.id = reset_token.user_id');
        $this->db->where('user_id', $userid);
        return $this->db->get()->row();        
    }

    // create user history
    public function createUserHistory($data)
    {
        $this->db->insert('user_history', $data);
    }

    // get last ip loggedin
    public function getLoggedinUserHistory($userid)
    {
        $query = $this->db->query("SELECT * FROM user_history ORDER BY last_login DESC LIMIT 1");
        $result = $query->result_array();
        return $result;        
    }

    // create user 
    public function register($data)
    {
        return $this->db->insert('users', $data);
    }

    // get user by id
    public function read($userid)
    {
        $this->db->where('id', $userid);
        $query = $this->db->get('users');
        if($query->num_rows() == 1)
        {
            return $query->result();
        }
    }

    // update user data by user id
    public function update($userid, $data)
    {
        $this->db->where('id', $userid);
        return $this->db->update('users', $data);
    }

    // update password by user id
    public function updatePass($userid, $data)
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
    public function remove($userid)
    {
        $this->db->where('id', $userid);
        $this->db->delete('users');
    }

    // update reset token table: token used status
    public function updateTokenStatus($id, $userid)
    {
        $this->db->set('used_token', 1);
        $this->db->where('id', $id);
        $this->db->where('user_id', $userid);
        $this->db->update('reset_token');
    }

    public function getResetToken($tokenid)
    {
        $this->db->where('id', $tokenid);
        $query = $this->db->get('reset_token');
        if($query->num_rows() == 1)
        {
            return $query->result();
        }
    }
}