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
  <meta charset="UTF-8" />
  <title>Manage Custom Requirements</title>
  <style>

    .main {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 20px 0;
    }

    #heading {
      color: #333;
      font-size: 24px;
    }

    table {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto 30px auto;
      border-collapse: collapse;
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      text-align: left;
      vertical-align: middle;
    }

    th {
      background-color: #06BBCC;
      color: white;
      user-select: none;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    .status-badge {
      padding: 6px 14px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: bold;
      text-transform: capitalize;
      display: inline-block;
      min-width: 90px;
      text-align: center;
      color: white;
    }

    .status-pending {
      background-color: #ffc107;
      color: #000;
    }

    .status-approved {
      background-color: #007bff;
    }

    .status-done {
      background-color: #28a745;
    }

    input[type="text"], select {
      padding: 6px 10px;
      font-size: 14px;
      border-radius: 4px;
      border: 1px solid #ccc;
      width: 100%;
      box-sizing: border-box;
    }

    button.update-btn {
      background-color: #06BBCC;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 6px 14px;
      font-size: 14px;
      cursor: pointer;
      white-space: nowrap;
      transition: background-color 0.3s ease;
    }

    button.update-btn:hover {
      background-color: #049eab;
    }

    button.delete-btn {
      background-color: #dc3545;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 6px 14px;
      font-size: 14px;
      cursor: pointer;
      white-space: nowrap;
      transition: background-color 0.3s ease;
    }

    button.delete-btn:hover {
      background-color: #b02a37;
    }

    .download-btn {
      background-color: #28a745;
      color: white;
      border-radius: 4px;
      padding: 6px 14px;
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
      white-space: nowrap;
      transition: background-color 0.3s ease;
      display: inline-block;
    }

    .download-btn:hover {
      background-color: #1e7e34;
    }

    #alert-container {
      width: 80%;
      max-width: 1200px;
      margin: 10px auto;
      text-align: center;
    }

    .alert {
      padding: 12px;
      border-radius: 6px;
      font-weight: bold;
      font-size: 15px;
      margin-bottom: 10px;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
  </style>
</head>
<body>

<?php include "./adminnavbar.php"; ?>

<div class="main">
  <h2 id="heading">Custom Requirements</h2>
</div>

<section class="load-custom">
  <table id="custom-req-table" aria-label="Custom Requirements Table">
    <thead>
      <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Title</th>
        <th>Description</th>
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
          let statusClass = "";
          if(item.status === 'pending') statusClass = "status-pending";
          else if(item.status === 'approved') statusClass = "status-approved";
          else if(item.status === 'done') statusClass = "status-done";

          const documentInfo = item.document_path
            ? `<a href="../${item.document_path}" class="download-btn" target="_blank" download>Download</a>`
            : `<span style="color:#888;">No document</span>`;

          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${item.id}</td>
            <td>${item.user_id}</td>
            <td><input type="text" id="title-${item.id}" value="${escapeHtml(item.title || '')}"></td>
            <td><input type="text" id="desc-${item.id}" value="${escapeHtml(item.description || '')}"></td>
            <td><input type="text" id="tech-${item.id}" value="${escapeHtml(item.technologies || '')}"></td>
            <td><span id="status-badge-${item.id}" class="status-badge ${statusClass}">${item.status}</span></td>
            <td>${documentInfo}</td>
            <td>
              <select id="status-${item.id}">
                <option value="pending"${item.status === 'pending' ? ' selected' : ''}>Pending</option>
                <option value="approved"${item.status === 'approved' ? ' selected' : ''}>Approved</option>
                <option value="done"${item.status === 'done' ? ' selected' : ''}>Done</option>
              </select>
              <button class="update-btn" onclick="updateRequirement(${item.id})">Update</button>
            </td>
            <td>
              <button class="delete-btn" onclick="deleteReq(${item.id})">Delete</button>
            </td>
          `;
          tbody.appendChild(tr);
        });
      })
      .catch(err => {
        console.error("Fetch error:", err);
        showAlert("error", "Failed to load requirements.");
      });
  }

  window.updateRequirement = function(id) {
    const titleInput = document.querySelector(`#title-${id}`);
    const descInput = document.querySelector(`#desc-${id}`);
    const techInput = document.querySelector(`#tech-${id}`);
    const statusSelect = document.querySelector(`#status-${id}`);

    if (!titleInput || !descInput || !statusSelect) {
      showAlert("error", "Form fields missing for this row.");
      return;
    }

    const title = titleInput.value.trim();
    const description = descInput.value.trim();
    const technologies = techInput.value.trim();
    const status = statusSelect.value;

    if (!title) {
      showAlert("error", "Title cannot be empty.");
      return;
    }
    if (!description) {
      showAlert("error", "Description cannot be empty.");
      return;
    }

    const formData = new FormData();
    formData.append("action", "update");
    formData.append("id", id);
    formData.append("title", title);
    formData.append("description", description);
    formData.append("technologies", technologies);
    formData.append("status", status);

    fetch('../controller/CustomRequirementsController.php', {
      method: "POST",
      body: formData
    })
    .then(res => {
      if (!res.ok) {
        throw new Error("Network response was not OK");
      }
      return res.json();
    })
    .then(resp => {
      console.log("UpdateResp", resp);
      if (resp.status === "success") {
        showAlert("success", resp.message);
        const badge = document.querySelector(`#status-badge-${id}`);
        badge.textContent = status;
        badge.className = "status-badge";
        if (status === 'pending') badge.classList.add("status-pending");
        else if (status === 'approved') badge.classList.add("status-approved");
        else if (status === 'done') badge.classList.add("status-done");
      } else {
        showAlert("error", resp.message || "Update failed.");
      }
    })
    .catch(err => {
      console.error("Update error:", err);
      showAlert("error", "Failed to update requirement.");
    });
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
      if (resp.status === "success") {
        showAlert("success", resp.message);
        fetchRequirements();
      } else {
        showAlert("error", resp.message || "Delete failed.");
      }
    })
    .catch(err => {
      console.error("Delete error:", err);
      showAlert("error", "Failed to delete requirement.");
    });
  };

  function showAlert(type, message) {
    const container = document.getElementById("alert-container");
    container.innerHTML = `
      <div class="alert alert-${type === "success" ? "success" : "error"}">
        ${escapeHtml(message)}
      </div>
    `;
    setTimeout(() => { container.innerHTML = ""; }, 3000);
  }

  function escapeHtml(text) {
    if (!text) return "";
    return text.replace(/[&<>"']/g, m => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;'
    })[m]);
  }
});
</script>

</body>
</html>