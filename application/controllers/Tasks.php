<?php
class Tasks extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Task_model');
        $this->load->database();
        
    }

    public function view_page() {
        $this->load->view('tasks_view');
}

    // GET /tasks
    public function index() {
        $filter = $this->input->get('filter') ?? 'all';
        $sort = $this->input->get('sort') ?? 'due_date';

        $data = [
            'tasks' => $this->Task_model->get_tasks($filter, $sort),
            'counts' => $this->Task_model->get_counts()
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // GET /tasks/count
    public function count() {
        
        $counts = $this->Task_model->get_counts();
        header('Content-Type: application/json');
        echo json_encode($counts);
    }

    // GET /tasks/{id}
    public function show($id) {
        header('Content-Type: application/json');
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID is required']);
            return;
        }

        $task = $this->Task_model->get_task_details($id);

        if (!$task) {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
            return;
        }

        echo json_encode($task);
    }

    // POST /tasks
    public function add() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || empty($input['title']) || empty($input['due_date'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Title and due_date are required']);
            return;
        }

        if (strtotime($input['due_date']) < time()) {
            http_response_code(400);
            echo json_encode(['error' => 'Due date cannot be in the past']);
            return;
        }

        $data = [
            'title' => $input['title'],
            'due_date' => date('Y-m-d H:i:s', strtotime($input['due_date'])),
            'priority' => $input['priority'] ?? 2
        ];

        $this->Task_model->insert_task($data);

        http_response_code(201);
        echo json_encode(['message' => 'Task created']);
    }

    // PUT /tasks/complete/{id}
    public function complete($id) {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID required']);
            return;
        }

        $this->Task_model->mark_complete($id);

        echo json_encode(['message' => 'Task marked as completed']);
    }

     // DELETE /tasks/{id}
    public function delete($id) {
        header('Content-Type: application/json');
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID required']);
            return;
        }

        $this->Task_model->delete_task($id);

        echo json_encode(['message' => 'Task deleted']);
    }

    // Custom validation for future dates
    public function check_future_date($date) {
        if (strtotime($date) < time()) {
            $this->form_validation->set_message('check_future_date', 'The {field} cannot be in the past.');
            return FALSE;
        }
        return TRUE;
    }

    public function handle($id) {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $this->show($id);
        } elseif ($method === 'PUT') {
            $this->complete($id);
        } elseif ($method === 'DELETE') {
            $this->delete($id);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
