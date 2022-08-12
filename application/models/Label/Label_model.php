<?php
class Label_model extends CI_Model
{
    public function get($id = null, $arr_id = [])
    {
        $this->db->select('*');
        $this->db->from('label');
        if ($id != null) {
            $this->db->where('id_label', $id);
        }
        if (count($arr_id) > 0) {
            $this->db->where_in('id_label', $arr_id);
        }
        return $this->db->get();
    }
    public function update($data, $id_label)
    {
        $this->db->where('id_label', $id_label);
        $this->db->update('label', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('label', $data);
        return $this->db->insert_id();
    }

    public function insertMany($data)
    {
        $this->db->insert_batch('label', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_label)
    {
        $this->db->delete('label', ['id_label' => $id_label]);
        return $this->db->affected_rows();
    }
}
