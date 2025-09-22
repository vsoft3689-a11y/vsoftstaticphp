<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Custom Requirements</title>
    <style>
        /* Similar styles as your inquiries page */
        .main {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #heading {
            margin: 20px 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #06BBCC;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .actions button {
            margin-right: 5px;
        }
        #alert-container {
            margin: 10px;
        }
    </style>
</head>
<body>

<?php include "./adminnavbar.php"; ?>

<div class="main">
    <h2 id="heading">Custom Requirements</h2>
</div>
<section class="load-custom">
    <table id="custom-req-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Title</th>
                <th>Technologies</th>
                <th>Status</th>
                <th>Document</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</section>
<div id="alert-container"></div>

<?php include "./footer.php"; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetchRequirements();

    function fetchRequirements() {
        fetch('../controller/CustomRequirementsController.php?action=read')
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector("#custom-req-table tbody");
                tbody.innerHTML = "";
                data.forEach(item => {
                    const tr = document.createElement("tr");
                    const docLink = item.document_path ? `<a href="../${item.document_path}" target="_blank">Download</a>` : "";

                    tr.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.user_id}</td>
                        <td>${item.title}</td>
                        <td>${item.technologies || '-'}</td>
                        <td>
                            <select onchange="updateStatus(${item.id}, this.value)">
                                <option value="pending"${item.status === 'pending' ? ' selected' : ''}>Pending</option>
                                <option value="approved"${item.status === 'approved' ? ' selected' : ''}>Approved</option>
                                <option value="done"${item.status === 'done' ? ' selected' : ''}>Done</option>
                            </select>
                        </td>
                        <td>${docLink}</td>
                        <td><button onclick="updateStatus(${item.id}, document.querySelector('#status-select-' + ${item.id}).value)">Update</button></td>
                        <td><button onclick="deleteReq(${item.id})">Delete</button></td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(err => console.error("Fetch error:", err));
    }

    window.updateStatus = function(id, status) {
        const formData = new FormData();
        formData.append("action", "updateStatus");
        formData.append("id", id);
        formData.append("status", status);

        fetch('../controller/CustomRequirementsController.php', {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(resp => {
            showAlert(resp.status, resp.message);
            fetchRequirements();
        })
        .catch(err => console.error("Update status error:", err));
    };

    window.deleteReq = function(id) {
        if (!confirm("Are you sure you want to delete this record?")) return;

        const formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);

        fetch('../controller/CustomRequirementsController.php', {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(resp => {
            showAlert(resp.status, resp.message);
            fetchRequirements();
        })
        .catch(err => console.error("Delete error:", err));
    };

    function showAlert(type, message) {
        const container = document.getElementById("alert-container");
        const color = type === "success" ? "green" : "red";
        container.innerHTML = `<div style="padding:10px; border:1px solid ${color}; color:${color}; margin-bottom:10px;">${message}</div>`;
        setTimeout(() => { container.innerHTML = ""; }, 3000);
    }
});
</script>

</body>
</html>