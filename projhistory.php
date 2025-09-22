<?php
session_start();
include 'connection1.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Interested Projects — History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .fade-out { transition: opacity 0.35s ease, transform 0.35s ease; opacity: 0; transform: translateY(-8px); }
    .card-fixed-height { min-height: 80vh; }
    .muted-small { font-size: .85rem; color: #6c757d; }
  </style>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  <!-- Favicon -->
  <link href="img/favicon.ico" rel="icon">
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <!-- Libraries Stylesheet -->
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
  <!-- Navbar Start -->
  <?php include 'dashboard_nav.php'; ?>
  <!-- Navbar End -->

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="card shadow-sm card-fixed-height">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div>
              <h5 class="mb-0">My Interested Projects</h5>
              <div class="muted-small">Projects you marked as <strong>Interested</strong></div>
            </div>

            <div class="d-flex gap-2 align-items-center">
              <div class="text-end">
                <div id="totalCount" class="fw-semibold">0</div>
                <div class="muted-small">Total</div>
              </div>

              <button id="clearAllBtn" class="btn btn-sm btn-outline-danger" title="Clear all">Clear All</button>
            </div>
          </div>

          <div class="card-body">
            <!-- Empty state -->
            <div id="emptyState" class="text-center py-5 d-none">
              <img src="https://via.placeholder.com/160x100?text=No+Projects" alt="empty" class="mb-3">
              <h6 class="mb-2">No interested projects yet</h6>
              <p class="muted-small mb-3">Browse projects and click <span class="badge bg-primary">I'm Interested</span> to save them here.</p>
              <a href="#" class="btn btn-primary btn-sm">Browse Projects</a>
            </div>

            <!-- Table -->
            <div id="tableWrap" class="table-responsive">
              <table id="projectsTable" class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                  <tr>
                    <th style="width:50px">#</th>
                    <th>Project Title</th>
                    <th>Domain</th>
                    <th>Technologies</th>
                    <th style="width:140px">Date Added</th>
                    <th style="width:170px">Action</th>
                  </tr>
                </thead>
                <tbody id="projectsTbody">
                  <!-- rows populated by JS -->
                </tbody>
              </table>
            </div>
          </div>

          <div class="card-footer text-muted d-flex justify-content-between">
            <div id="lastUpdated">Last updated: —</div>
            <div class="muted-small">Frontend-only · LocalStorage</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Details Modal -->
  <div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="modalTitle" class="modal-title">Project Title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="modalDesc" class="mb-3"></p>

          <div class="row">
            <div class="col-md-6">
              <dl>
                <dt class="muted-small">Domain</dt>
                <dd id="modalDomain"></dd>
                <dt class="muted-small">Technologies</dt>
                <dd id="modalTech"></dd>
              </dl>
            </div>
            <div class="col-md-6">
              <dl>
                <dt class="muted-small">Date Added</dt>
                <dd id="modalDate"></dd>
                <dt class="muted-small">Document</dt>
                <dd id="modalDoc"></dd>
              </dl>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a id="viewBtn" class="btn btn-outline-primary" target="_blank" href="#">View Project Page</a>
          <button id="modalRemove" type="button" class="btn btn-danger">Remove</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Confirm Remove Dialog -->
  <div class="modal fade" id="confirmRemoveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <p class="mb-3">Are you sure you want to remove this project from your interested list?</p>
          <div class="d-flex justify-content-center gap-2">
            <button id="confirmRemoveYes" class="btn btn-danger btn-sm">Yes, Remove</button>
            <button data-bs-dismiss="modal" class="btn btn-secondary btn-sm">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // ----- Demo dataset (used when localStorage is empty) -----
    const demoData = [
      {
        id: 'p1',
        title: 'AI Chatbot',
        domain: 'Artificial Intelligence',
        technologies: 'Python, NLP, Flask',
        description: 'A chatbot to answer FAQs and handle user queries using NLP.',
        dateAdded: '2025-09-06',
        document: '#'
      },
      {
        id: 'p2',
        title: 'Smart Farming System',
        domain: 'IoT',
        technologies: 'Arduino, Sensors, Node-RED',
        description: 'An IoT-based system to monitor soil moisture and automate irrigation.',
        dateAdded: '2025-09-03',
        document: '#'
      },
      {
        id: 'p3',
        title: 'Online Voting System',
        domain: 'Web Security',
        technologies: 'PHP, MySQL, JWT',
        description: 'Secure online voting platform with role-based access and audit logs.',
        dateAdded: '2025-08-30',
        document: '#'
      }
    ];

    // ----- Utilities -----
    const STORAGE_KEY = 'interestedProjects_v1';
    const tbody = document.getElementById('projectsTbody');
    const totalCountEl = document.getElementById('totalCount');
    const lastUpdatedEl = document.getElementById('lastUpdated');
    const emptyState = document.getElementById('emptyState');
    const tableWrap = document.getElementById('tableWrap');
    const clearAllBtn = document.getElementById('clearAllBtn');

    let projects = loadProjects();

    function loadProjects() {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) {
        // initialize with demo data for first‐time users
        localStorage.setItem(STORAGE_KEY, JSON.stringify(demoData));
        return demoData.slice();
      }
      try {
        const parsed = JSON.parse(raw);
        if (!Array.isArray(parsed) || parsed.length === 0) {
          localStorage.setItem(STORAGE_KEY, JSON.stringify(demoData));
          return demoData.slice();
        }
        return parsed;
      } catch {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(demoData));
        return demoData.slice();
      }
    }

    function saveProjects() {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(projects));
      updateFooter();
    }

    function updateFooter() {
      const now = new Date();
      lastUpdatedEl.textContent = 'Last updated: ' + now.toLocaleString();
    }

    // ----- Rendering -----
    function renderTable() {
      tbody.innerHTML = '';

      if (projects.length === 0) {
        emptyState.classList.remove('d-none');
        tableWrap.classList.add('d-none');
      } else {
        emptyState.classList.add('d-none');
        tableWrap.classList.remove('d-none');

        projects.forEach((p, idx) => {
          const tr = document.createElement('tr');
          tr.dataset.id = p.id;

          tr.innerHTML = `
            <td>${idx + 1}</td>
            <td class="fw-semibold">${escapeHtml(p.title)}</td>
            <td>${escapeHtml(p.domain || '')}</td>
            <td>${escapeHtml(p.technologies || '')}</td>
            <td>${escapeHtml(p.dateAdded || '')}</td>
            <td>
              <div class="btn-group" role="group">
                <button class="btn btn-sm btn-outline-primary view-btn">View Details</button>
                <button class="btn btn-sm btn-outline-danger remove-btn">Remove</button>
              </div>
            </td>
          `;

          tbody.appendChild(tr);
        });
      }

      totalCountEl.textContent = projects.length;
    }

    function escapeHtml(str) {
      if (!str) return '';
      return str.replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;');
    }

    // ----- Handlers -----
    let activeProjectId = null;
    const detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
    const confirmRemoveModal = new bootstrap.Modal(document.getElementById('confirmRemoveModal'));

    tbody.addEventListener('click', (ev) => {
      const btn = ev.target.closest('button');
      if (!btn) return;

      const row = ev.target.closest('tr');
      const id = row?.dataset?.id;
      if (!id) return;

      if (btn.classList.contains('view-btn')) {
        openDetails(id);
      } else if (btn.classList.contains('remove-btn')) {
        askRemove(id);
      }
    });

    function openDetails(id) {
      activeProjectId = id;
      const p = projects.find(x => x.id === id);
      if (!p) return;

      document.getElementById('modalTitle').textContent = p.title;
      document.getElementById('modalDesc').textContent = p.description || 'No description provided.';
      document.getElementById('modalDomain').textContent = p.domain || '-';
      document.getElementById('modalTech').textContent = p.technologies || '-';
      document.getElementById('modalDate').textContent = p.dateAdded || '-';
      const modalDoc = document.getElementById('modalDoc');
      modalDoc.innerHTML = p.document ? `<a href="${p.document}" target="_blank">Open document</a>` : '—';

      const viewBtn = document.getElementById('viewBtn');
      viewBtn.href = p.document || '#';
      viewBtn.classList.toggle('disabled', !p.document);

      detailsModal.show();
    }

    function askRemove(id) {
      activeProjectId = id;
      confirmRemoveModal.show();
    }

    document.getElementById('confirmRemoveYes').addEventListener('click', () => {
      if (!activeProjectId) return;
      removeProject(activeProjectId);
      confirmRemoveModal.hide();
      detailsModal.hide();
      activeProjectId = null;
    });

    document.getElementById('modalRemove').addEventListener('click', () => {
      if (!activeProjectId) return;
      askRemove(activeProjectId);
    });

    function removeProject(id) {
      const idx = projects.findIndex(p => p.id === id);
      if (idx === -1) return;

      const tr = tbody.querySelector(`tr[data-id="${id}"]`);
      if (tr) {
        tr.classList.add('fade-out');
        setTimeout(() => {
          projects.splice(idx, 1);
          saveProjects();
          renderTable();
        }, 350);
      } else {
        projects.splice(idx, 1);
        saveProjects();
        renderTable();
      }
    }

    clearAllBtn.addEventListener('click', () => {
      if (!projects.length) return;
      if (confirm('Clear all interested projects? This cannot be undone.')) {
        projects = [];
        saveProjects();
        renderTable();
      }
    });

    // Initialize
    renderTable();
    updateFooter();

    function addProject(item) {
      if (projects.find(p => p.id === item.id)) return;
      projects.unshift(item);
      saveProjects();
      renderTable();
    }
    window.addProjectToInterested = addProject;
  </script>

  <!-- Footer Start -->
  <?php include 'footer.php'; ?>
  <!-- Footer End -->

  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Template Javascript -->
  <script src="js/main.js"></script>
</body>
</html>

