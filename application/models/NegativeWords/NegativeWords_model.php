<?php
class NegativeWords_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('negativewords');
        if ($id != null) {
            $this->db->where('id_negativewords', $id);
        }
        return $this->db->get();
    }
    public function checkWord($nama_negativewords = null)
    {
        $this->db->select('*');
        $this->db->from('negativewords');
        if ($nama_negativewords != null) {
            $this->db->where('nama_negativewords', $nama_negativewords);
        }
        return $this->db->get();
    }
    public function update($data, $id_negativewords)
    {
        $this->db->where('id_negativewords', $id_negativewords);
        $this->db->update('negativewords', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('negativewords', $data);
        return $this->db->insert_id();
    }
    public function insertMany($data)
    {
        $this->db->insert_batch('negativewords', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_negativewords)
    {
        $this->db->delete('negativewords', ['id_negativewords' => $id_negativewords]);
        return $this->db->affected_rows();
    }
}
