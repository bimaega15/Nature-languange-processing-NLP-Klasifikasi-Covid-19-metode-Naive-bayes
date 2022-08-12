<?php
class Hasil_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('hasil');
        if ($id != null) {
            $this->db->where('id_hasil', $id);
        }
        return $this->db->get();
    }

    public function update($data, $id_hasil)
    {
        $this->db->where('id_hasil', $id_hasil);
        $this->db->update('hasil', $data);
        return $this->db->affected_rows();
    }
    public function insert($data)
    {
        $this->db->insert('hasil', $data);
        return $this->db->insert_id();
    }
    public function delete($id_hasil)
    {
        $this->db->delete('hasil', ['id_hasil' => $id_hasil]);
        return $this->db->affected_rows();
    }
}
