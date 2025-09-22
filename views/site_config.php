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
    <title>Site Config Management</title>
    <style>
        .main {
            width: 100%;
            min-height: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        #configHeading {
            color: #444;
            margin: 20px;
        }

        #configForm {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input, textarea {
            margin: 8px 0;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        #btn, .btn-config {
            background: #06BBCC;
            color: #fff;
            padding: 8px 12px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            transition: 0.3s;
            margin-right: 6px;
        }

        #btn:hover, .btn-config:hover {
            background: #049aa7;
        }

        .cancel-btn {
            margin-top: 10px;
            background-color: #ccc;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #06BBCC;
            color: #fff;
            text-align: center;
        }

        .actions {
            display: flex;
            gap: 6px;
        }
        
    </style>
</head>
<body>

<?php include "./adminnavbar.php" ?>

<div class="main">
    <h2 id="configHeading">Add Config</h2>
    <form id="configForm">
        <input type="hidden" name="action" value="create">
        <label>Config Key:</label>
        <input type="text" name="config_key" required>
        <label>Config Value:</label>
        <textarea name="config_value" required></textarea>
        <button id="btn" type="submit">Add Config</button>
    </form>
</div>

<?php include __DIR__ . '/../admin_google_map.php' ?>

<section class="load-siteconfig">
    <h2 style="text-align:center;">Config List</h2>
    <div id="siteConfig"></div>
</section>

<?php include "./footer.php" ?>

<script>
    const apiUrl = "../controller/SiteConfigController.php";

    async function loadConfigs() {
        const res = await fetch(apiUrl + "?action=read");
        const data = await res.json();

        const container = document.getElementById("siteConfig");
        container.innerHTML = "";

        if (data.length === 0) {
            const para = document.createElement("p");
            para.innerHTML = "No site configurations found!";
            para.style.textAlign = "center";
            para.style.fontWeight = "bold";
            para.style.paddingTop = "40px";
            container.appendChild(para);
            return;
        }

        const table = document.createElement("table");

        const thead = document.createElement("thead");
        thead.innerHTML = `
            <tr>
                <th>ID</th>
                <th>Key</th>
                <th>Value</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>`;
        table.appendChild(thead);

        const tbody = document.createElement("tbody");

        data.forEach(c => {
            const tr = document.createElement("tr");
            tr.dataset.id = c.id;
            tr.dataset.key = encodeURIComponent(c.config_key);
            tr.dataset.value = encodeURIComponent(c.config_value);

            tr.innerHTML = `
                <td>${c.id}</td>
                <td>${c.config_key}</td>
                <td>${c.config_value}</td>
                <td>${c.created_at}</td>
                <td>${c.updated_at}</td>
                <td class="actions">
                    <button class="btn-config edit" onclick="handleEdit(this)">Edit</button>
                    <button class="btn-config delete" onclick="deleteConfig(${c.id})">Delete</button>
                </td>`;
            tbody.appendChild(tr);
        });

        table.appendChild(tbody);
        container.appendChild(table);
    }

    document.getElementById("configForm").addEventListener("submit", async function(e) {
        e.preventDefault();

        let form = this;
        let key = form.config_key.value.trim();
        let value = form.config_value.value.trim();

        if (key.length < 3) {
            alert("Config Key must be at least 3 characters.");
            return;
        }

        if (value.length < 3) {
            alert("Config Value must be at least 3 characters.");
            return;
        }

        let formData = new FormData(form);
        const res = await fetch(apiUrl, {
            method: "POST",
            body: formData
        });

        const result = await res.json();
        alert(result.message);
        form.reset();
        form.querySelector("button[type='submit']").innerText = "Add Config";
        form.querySelector("input[name='action']").value = "create";
        if (form.querySelector("input[name='id']")) {
            form.querySelector("input[name='id']").remove();
        }
        const cancelBtn = form.querySelector(".cancel-btn");
        if (cancelBtn) cancelBtn.remove();

        loadConfigs();
    });

    function handleEdit(button) {
        const tr = button.closest("tr");
        const id = tr.dataset.id;
        const key = decodeURIComponent(tr.dataset.key);
        const value = decodeURIComponent(tr.dataset.value);

        const form = document.getElementById("configForm");

        form.querySelector("[name='config_key']").value = key;
        form.querySelector("[name='config_value']").value = value;
        form.querySelector("[name='action']").value = "update";

        if (!form.querySelector("[name='id']")) {
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = "id";
            hidden.value = id;
            form.appendChild(hidden);
        } else {
            form.querySelector("[name='id']").value = id;
        }

        const submitBtn = form.querySelector("button[type='submit']");
        submitBtn.innerText = "Update Config";

        if (!form.querySelector(".cancel-btn")) {
            const cancelBtn = document.createElement("button");
            cancelBtn.type = "button";
            cancelBtn.className = "cancel-btn";
            cancelBtn.innerText = "Cancel";
            cancelBtn.id = "btn";
            form.appendChild(cancelBtn);

            cancelBtn.addEventListener("click", () => {
                form.reset();
                form.querySelector("[name='action']").value = "create";
                if (form.querySelector("[name='id']")) form.querySelector("[name='id']").remove();
                cancelBtn.remove();
                submitBtn.innerText = "Add Config";
            });
        }
    }

    async function deleteConfig(id) {
        if (!confirm("Delete this config?")) return;
        const formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);
        const res = await fetch(apiUrl, {
            method: "POST",
            body: formData
        });
        const result = await res.json();
        alert(result.message);
        loadConfigs();
    }

    loadConfigs();
</script>

</body>
</html>