
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('mainWrapper').classList.toggle('shifted');
    }
    function showLoader(f) { document.getElementById('pageLoader').style.display = f ? 'flex' : 'none'; }

    /* Rebind row click/edit/dispose */
    function rebindRowExtras() {
      document.querySelectorAll('.log-row').forEach(row => {
        const id = row.dataset.id;
        row.onclick = () => location.href = 'view_log.php?id=' + id;
        row.querySelector('.fa-pencil-alt').onclick =
          e => { e.stopPropagation(); openEditModal(id); };
        row.querySelector('.fa-trash-alt').onclick =
          e => { e.stopPropagation(); confirmDispose(id); };
      });
    }
    rebindRowExtras();

    /* Dispose confirm */
    let disposeId = 0;
    function confirmDispose(id) {
      disposeId = id;
      document.getElementById('disposeModal').style.display = 'flex';
    }
    function hideModal() { document.getElementById('disposeModal').style.display = 'none'; }
    document.getElementById('confirmBtn').onclick = () => {
      fetch('dispose_log.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + disposeId
      }).then(r => r.json()).then(res => {
        if (res.ok) location.reload();
        else { alert('Failed'); hideModal(); }
      });
    };

    /* Live search */
    let timer = null;
    document.getElementById('searchBox').addEventListener('input', e => {
      clearTimeout(timer);
      timer = setTimeout(() => liveSearch(e.target.value), 300);
    });
    function liveSearch(term) {
      fetch('../ajax/search_logs.php?q=' + encodeURIComponent(term))
        .then(r => r.text())
        .then(html => {
          document.getElementById('logBody').innerHTML = html;
          rebindRowExtras();
        })
        .catch(err => console.error(err));
    }

    /* Edit modal loader */
    let editLoadedId = 0;
    function openEditModal(id) {
      if (editLoadedId === id) { showEditModal(); return; }
      showLoader(true);
      fetch('../ajax/get_edit_log_form.php?id=' + id)
        .then(r => r.text()).then(html => {
          document.getElementById('editLogModal')?.remove();
          document.body.insertAdjacentHTML('beforeend', html);
          attachEditSubmit(); editLoadedId = id;
          showLoader(false); showEditModal();
        })
        .catch(e => { showLoader(false); alert('Cannot load form'); console.error(e); });
    }
    function showEditModal() { document.getElementById('editLogModal').style.display = 'flex'; }
    function closeEditModal() { document.getElementById('editLogModal').style.display = 'none'; }

    function attachEditSubmit() {
      document.getElementById('editLogForm').addEventListener('submit', e => {
        e.preventDefault();
        const data = new URLSearchParams(new FormData(e.target)).toString();
        showLoader(true);
        fetch('update_log.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: data
        }).then(r => r.text()).then(txt => {
          showLoader(false);
          if (txt.trim() === 'OK') { closeEditModal(); refreshRow(e.target.id.value); }
          else alert('Update failed');
        }).catch(err => { showLoader(false); alert('Error'); console.error(err) });
      });
    }
    function refreshRow(id) {
      fetch('../ajax/search_logs.php?q=&id=' + id)
        .then(r => r.text())
        .then(html => {
          const old = document.querySelector(`tr[data-id="${id}"]`);
          if (old) old.outerHTML = html.trim();
          rebindRowExtras();
        });
    }
