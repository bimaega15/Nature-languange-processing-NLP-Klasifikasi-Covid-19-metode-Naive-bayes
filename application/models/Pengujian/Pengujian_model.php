<?php
class Pengujian_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('pengujian');
        if ($id != null) {
            $this->db->where('id_pengujian', $id);
        }
        return $this->db->get();
    }

    public function update($data, $id_pengujian)
    {
        $this->db->where('id_pengujian', $id_pengujian);
        $this->db->update('pengujian', $data);
        return $this->db->affected_rows();
    }
    public function insert($data)
    {
        $this->db->insert('pengujian', $data);
        return $this->db->insert_id();
    }
    public function delete($id_pengujian)
    {
        $this->db->delete('pengujian', ['id_pengujian' => $id_pengujian]);
        return $this->db->affected_rows();
    }
}
