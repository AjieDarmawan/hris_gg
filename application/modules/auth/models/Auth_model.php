<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    

    public function login($username, $password)
    {

         $user = $this->db->select('*')
        ->from('acc_master as u')
         ->join('kar_master as k','k.kar_id = u.kar_id')
        ->join('kar_detail as d','d.kar_id = u.kar_id')
        ->where('u.acc_username', $username)
         ->where('u.acc_password', $password)
        ->where('u.acc_sts', 'A')
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
        if ($password == $user['acc_password'])
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

}