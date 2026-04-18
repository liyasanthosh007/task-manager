<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
</head>
<body>

<h2>Task Manager</h2>

<!-- STATS -->
<p>
Total: <span id="total">0</span> |
Pending: <span id="pending">0</span> |
Completed: <span id="completed">0</span>
</p>

<hr>

<!-- ADD TASK -->
<h3>Add Task</h3>

<input type="text" id="title" placeholder="Task title"><br><br>

<input type="datetime-local" id="due_date"><br><br>

<select id="priority">
    <option value="1">Low</option>
    <option value="2">Medium</option>
    <option value="3">High</option>
</select><br><br>

<button onclick="addTask()">Add Task</button>

<hr>

<!-- FILTER -->
<select id="filter" onchange="loadTasks()">
    <option value="pending" selected>Pending</option>
    <option value="completed">Completed</option>
    <option value="all">All</option>
</select>

<hr>

<!-- TASK LIST -->
<div id="tasks"></div>

<script>
let API = "http://localhost/codeIgniter/task_mngt/index.php/tasks";

// LOAD TASKS
function loadTasks() {

    let filter = document.getElementById("filter").value;

    fetch(API + "?filter=" + filter)
    .then(res => res.json())
    .then(data => {

        // stats
        document.getElementById("total").innerText = data.counts.total;
        document.getElementById("pending").innerText = data.counts.pending;
        document.getElementById("completed").innerText = data.counts.completed;

        // tasks
        let html = "";

        data.tasks.forEach(t => {

            let due = new Date(t.due_date);
            let now = new Date();
            let diff = (due - now) / (1000 * 60 * 60);

            let color = "";

            if (t.status == "completed") {
                color = "";
            }
            else if (diff < 24 && diff > 0) {
                color = "style='background:#ffcccc;'";
            }

            html += `
                <p ${color}>
                    <b>${t.title}</b><br>
                    Due: ${t.due_date} <br>
                    Priority: ${t.priority} <br>
                    Status: ${t.status}
                    <br>
                    ${t.status != "completed" ? 
                        `<button onclick="completeTask(${t.id})">Complete</button>` 
                        : ""}
                </p>
                <hr>
            `;
        });

        document.getElementById("tasks").innerHTML = html;
    });
}

// ADD TASK
function addTask() {

    let title = document.getElementById("title").value;
    let due_date = document.getElementById("due_date").value;
    let priority = document.getElementById("priority").value;

    if (title == "" || due_date == "") {
        alert("Fill all fields");
        return;
    }

    let now = new Date();
    if (new Date(due_date) < now) {
        alert("Past date not allowed");
        return;
    }

    fetch(API + "/add", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            title: title,
            due_date: due_date,
            priority: priority
        })
    })
    .then(res => res.json())
    .then(() => {
        loadTasks();
    });
}

// COMPLETE TASK
function completeTask(id) {

    fetch(API + "/complete/" + id, {
        method: "PUT"
    })
    .then(res => res.json())
    .then(() => {
        loadTasks();
    });
}

// INIT
loadTasks();
</script>

</body>
</html>