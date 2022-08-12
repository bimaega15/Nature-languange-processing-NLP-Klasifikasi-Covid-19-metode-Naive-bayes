<?php
class PositiveWords_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('positivewords');
        if ($id != null) {
            $this->db->where('id_positivewords', $id);
        }
        return $this->db->get();
    }
    public function checkWord($nama_positivewords = null)
    {
        $this->db->select('*');
        $this->db->from('positivewords');
        if ($nama_positivewords != null) {
            $this->db->where('nama_positivewords', $nama_positivewords);
        }
        return $this->db->get();
    }
    public function update($data, $id_positivewords)
    {
        $this->db->where('id_positivewords', $id_positivewords);
        $this->db->update('positivewords', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('positivewords', $data);
        return $this->db->insert_id();
    }
    public function insertMany($data)
    {
        $this->db->insert_batch('positivewords', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_positivewords)
    {
        $this->db->delete('positivewords', ['id_positivewords' => $id_positivewords]);
        return $this->db->affected_rows();
    }
}
