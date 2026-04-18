<?php
class Task_model extends CI_Model {
    public function get_tasks($filter = 'pending', $sort = 'due_date') {
        if ($filter !== 'all') {
            $this->db->where('status', $filter);
        }
        $this->db->order_by($sort, 'ASC');
        return $this->db->get('tasks')->result_array();
    }

    public function get_task_details($id) {

        $this->db->where('id', $id);
        return $this->db->get('tasks')->row_array();
    }

    public function insert_task($data) {
        return $this->db->insert('tasks', $data);
    }

    public function mark_complete($id) {
        $this->db->where('id', $id);
        return $this->db->update('tasks', ['status' => 'completed']);
    }

    public function delete_task($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tasks');
    }

    public function get_counts() {
        return [
            'total' => $this->db->count_all('tasks'),
            'pending' => $this->db->where('status', 'pending')->count_all_results('tasks'),
            'completed' => $this->db->where('status', 'completed')->count_all_results('tasks')
        ];
    }
}
