<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    

    public function login($username, $password)
    {

        $user = $this->db->select('*')
        ->from('users')
        ->where('username', $username)
        ->where('status', '1')
        //->or_where('email', $username)
        ->limit(1)
        ->get()
        ->row_array();


        

        if(!$user){
            return false;
        }

        // if($this->login_ldap($username,$password){
        //     return $user;
        // }

       // $hash = crypt($password, $user['password']);
        if ($password == $user['password'])
        {
            return $user;
        }

        return false;
    }
    
    public function permission($user_id){
        $this->db->select('user_id,group_id,name');
        $this->db->from('users_groups A');
        $this->db->join('groups B','A.group_id=B.id');
        $this->db->where('A.user_id',$user_id);
        $query = $this->db->get()->result();
        //print_r($this->db->last_query()); die;
        foreach ($query as $key) {
            $result[]=$key->name;
        }
        return $result;
    }

    function select_by_id($id_user){
        $sql = $this->db->query('select * from users where id_users='.$id_user)->row();

        return $sql;
    }

}