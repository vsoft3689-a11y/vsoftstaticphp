<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Custom Requirements</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .main {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 30px;
    }

    h2#heading {
      color: #333;
    }

    table {
      width: 95%;
      border-collapse: collapse;
      margin: 20px auto;
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }

    th {
      background-color: #06BBCC;
      color: white;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    .status-badge {
      padding: 6px 10px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: bold;
      text-transform: capitalize;
    }

    .badge-pending {
      background-color: #ffc107;
      color: #000;
    }

    .badge-approved {
      background-color: #007bff;
      color: white;
    }

    .badge-done {
      background-color: #28a745;
      color: white;
    }

    .status-select {
      padding: 6px;
      font-size: 14px;
      border-radius: 4px;
      margin-bottom: 6px;
    }

    .update-btn, .delete-btn {
      padding: 6px 10px;
      background-color: #06BBCC;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 13px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .update-btn:hover, .delete-btn:hover {
      background-color: #049eab;
    }

    .alert {
      width: 95%;
      margin: 10px auto;
      padding: 12px;
      border-radius: 6px;
      text-align: center;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/adminnavbar.php'; ?>

<div class="main">
  <h2 id="heading">Custom Requirements</h2>
</div>

<section>
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

<?php include __DIR__ . '/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.querySelector("#custom-req-table tbody");
  const alertContainer = document.getElementById("alert-container");

  function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    alertContainer.innerHTML = `
      <div class="alert ${alertClass}">${message}</div>
    `;
    setTimeout(() => alertContainer.innerHTML = '', 3000);
  }

  function getStatusBadge(status) {
    let badgeClass = 'badge-pending';
    if (status === 'approved') badgeClass = 'badge-approved';
    if (status === 'done') badgeClass = 'badge-done';

    return `<span class="status-badge ${badgeClass}">${status}</span>`;
  }

  function fetchRequirements() {
    fetch("../controller/CustomRequirementsController.php?action=read")
      .then(res => res.json())
      .then(data => {
        tableBody.innerHTML = "";

        data.forEach(req => {
          const docLink = req.document_path 
            ? `<a href="../${req.document_path}" target="_blank">Download</a>` 
            : "-";

          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${req.id}</td>
            <td>${req.user_id}</td>
            <td>${req.title}</td>
            <td>${req.technologies || '-'}</td>
            <td>${getStatusBadge(req.status)}</td>
            <td>${docLink}</td>
            <td>
              <form onsubmit="return updateStatus(event, ${req.id})">
                <select name="status" class="status-select">
                  <option value="pending" ${req.status === 'pending' ? 'selected' : ''}>Pending</option>
                  <option value="approved" ${req.status === 'approved' ? 'selected' : ''}>Approved</option>
                  <option value="done" ${req.status === 'done' ? 'selected' : ''}>Done</option>
                </select>
                <button type="submit" class="update-btn">Update</button>
              </form>
            </td>
            <td>
              <form onsubmit="return deleteRequirement(event, ${req.id})">
                <button type="submit" class="delete-btn">Delete</button>
              </form>
            </td>
          `;
          tableBody.appendChild(tr);
        });
      })
      .catch(err => {
        console.error("Fetch error:", err);
        showAlert("error", "Failed to load data.");
      });
  }

  window.updateStatus = function (event, id) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    formData.append("action", "update_status");
    formData.append("id", id);

    fetch("../controller/CustomRequirementsController.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      showAlert(data.status, data.message);
      fetchRequirements();
    })
    .catch(err => {
      console.error("Update error:", err);
      showAlert("error", "Status update failed.");
    });
  };

  window.deleteRequirement = function (event, id) {
    event.preventDefault();
    if (!confirm("Are you sure you want to delete this requirement?")) return;

    const formData = new FormData();
    formData.append("action", "delete");
    formData.append("id", id);

    fetch("../controller/CustomRequirementsController.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      showAlert(data.status, data.message);
      fetchRequirements();
    })
    .catch(err => {
      console.error("Delete error:", err);
      showAlert("error", "Delete failed.");
    });
  };

  fetchRequirements();
});
</script>

</body>
</html>
