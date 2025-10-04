// Live search filter
const inp = document.getElementById('search');
if (inp) {
  inp.addEventListener('input', () => {
    const q = inp.value.toLowerCase();
    document.querySelectorAll('#tbl tbody tr').forEach(tr => {
      const rowText = tr.textContent.toLowerCase();
      tr.style.display = rowText.includes(q) ? '' : 'none';
    });
  });
}

// Sidebar toggle
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('active');
  document.getElementById('mainWrapper').classList.toggle('shifted');
}

// Delete modal
let delId = 0;
function askDelete(id) {
  delId = id;
  document.getElementById('delModal').style.display = 'flex';
}
function hideDel() {
  document.getElementById('delModal').style.display = 'none';
}

document.getElementById('delYes')?.addEventListener('click', () => {
  fetch('delete_disposed.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'id=' + delId
  })
  .then(r => r.json())
  .then(res => {
    if (res.ok) {
      location.reload();
    } else {
      alert('Error: ' + res.msg);
      hideDel();
    }
  });
});
