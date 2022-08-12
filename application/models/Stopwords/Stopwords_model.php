<?php
class Stopwords_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('stopwords');
        if ($id != null) {
            $this->db->where('id_stopwords', $id);
        }
        return $this->db->get();
    }
    public function checkWord($text)
    {
        $this->db->select('*');
        $this->db->from('stopwords');
        $this->db->where('text_stopwords', $text);
        return $this->db->get();
    }
    public function update($data, $id_stopwords)
    {
        $this->db->where('id_stopwords', $id_stopwords);
        $this->db->update('stopwords', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('stopwords', $data);
        return $this->db->insert_id();
    }
    public function insertMany($data)
    {
        $this->db->insert_batch('stopwords', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_stopwords)
    {
        $this->db->delete('stopwords', ['id_stopwords' => $id_stopwords]);
        return $this->db->affected_rows();
    }
}
