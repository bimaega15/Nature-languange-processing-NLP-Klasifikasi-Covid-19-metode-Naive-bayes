<?php
class Users_model extends CI_Model
{
    public function login($username = null, $password = null)
    {
        $this->db->select('*');
        $this->db->from('admin');
        if ($username != null) {
            $this->db->where('username', $username);
        }
        if ($password != null) {
            $this->db->where('password', md5($password));
        }
        return $this->db->get();
    }
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('admin');
        if ($id != null) {
            $this->db->where('id_admin', $id);
        }
        return $this->db->get();
    }
    public function update($data, $id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        $this->db->update('admin', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('admin', $data);
        return $this->db->insert_id();
    }

    public function delete($id_admin)
    {
        $this->db->delete('admin', ['id_admin' => $id_admin]);
        return $this->db->affected_rows();
    }
}
