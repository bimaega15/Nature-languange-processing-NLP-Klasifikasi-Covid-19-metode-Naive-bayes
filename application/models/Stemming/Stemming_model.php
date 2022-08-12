<?php
class Stemming_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('stemming');
        if ($id != null) {
            $this->db->where('id_stemming', $id);
        }
        return $this->db->get();
    }
    public function checkWord($awal_stemming = null)
    {
        $this->db->select('*');
        $this->db->from('stemming');
        if ($awal_stemming != null) {
            $this->db->where('awal_stemming', $awal_stemming);
        }
        return $this->db->get();
    }
    public function update($data, $id_stemming)
    {
        $this->db->where('id_stemming', $id_stemming);
        $this->db->update('stemming', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('stemming', $data);
        return $this->db->insert_id();
    }
    public function insertMany($data)
    {
        $this->db->insert_batch('stemming', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_stemming)
    {
        $this->db->delete('stemming', ['id_stemming' => $id_stemming]);
        return $this->db->affected_rows();
    }
}
