<section id="about" class="py-2">
  <div class="container-fluid d-flex justify-content-center align-items-center text-center flex-column mt-5 pt-5">
    <h1 class="fw-bold color-hijau pb-2">ABOUT BENGKEL ARSIP</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3">
       <button type="button" class="btngallery col-3 mb-4" data-bs-toggle="modal" data-bs-target="#modalDelete">Hapus</button>
        <button type="button" class="btngallery col-3 mb-4" data-bs-toggle="modal" data-bs-target="#modalAdd">Tambah</button>
        <button type="button" class="btngallery col-3 mb-4" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button>
      </div>
    <?php endif; ?>

    <div class="row gap-5" id="aboutGrid">
      <?php foreach ($data_about as $item): ?>
        <div class="card col-lg-3 col-md-4 col-sm-12" data-id="<?= $item['id'] ?>">
          <h5 class="text-start w-100 px-4"><?= $item['title']; ?></h5>
          <p class="text-start w-100 px-4"><?= $item['content']; ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered "> <!-- class kustom -->
    <form id="formTambahAbout" action="<?= base_url('admin/about/tambah'); ?>" method="post">
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="title" class="form-control mb-3" placeholder="Judul" required>
          <textarea name="content" class="form-control" placeholder="Konten" rows="5" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn ">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formEditAbout" action="<?= base_url('admin/about/edit'); ?>" method="post">
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- Dropdown untuk pilih data -->
          <select id="editAboutSelect" class="form-select mb-3" onchange="setEditData(this)" required>
            <option value="">Pilih Data</option>
          </select>

          <!-- Input yang otomatis terisi -->
          <input type="hidden" id="edit-id" name="id">
          <input type="text" id="edit-title" name="title" class="form-control mb-3" placeholder="Judul Baru" required>
          <textarea id="edit-content" name="content" class="form-control" placeholder="Konten Baru" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  function setEditData(select) {
    const selectedOption = select.options[select.selectedIndex];

    const id = selectedOption.value;
    const title = selectedOption.getAttribute('data-title');
    const content = selectedOption.getAttribute('data-content');

    document.getElementById('edit-id').value = id;
    document.getElementById('edit-title').value = title;
    document.getElementById('edit-content').value = content;
  }
</script>


<!-- Modal Hapus -->
<div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <form id="formHapusAbout" action="<?= base_url('admin/about/hapus'); ?>" method="post">
      <div class="modal-content  modal-half ">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" id="hapusAboutSelect" class="form-select" required>
            <option value="">Pilih Data</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  var initialAboutData = <?= json_encode(array_map(function ($item) {
      return ['id' => (int) $item['id'], 'title' => $item['title'], 'content' => $item['content']];
  }, $data_about)) ?>;
  var aboutData = (initialAboutData || []).slice();

  function escapeAboutHtml(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  function buildAboutCardHTML(a) {
    return '<div class="card col-lg-3 col-md-4 col-sm-12" data-id="' + a.id + '">' +
      '<h5 class="text-start w-100 px-4">' + escapeAboutHtml(a.title) + '</h5>' +
      '<p class="text-start w-100 px-4">' + escapeAboutHtml(a.content) + '</p>' +
    '</div>';
  }

  function renderAboutAdminLists() {
    var editSelect = document.getElementById('editAboutSelect');
    var hapusSelect = document.getElementById('hapusAboutSelect');
    if (!editSelect || !hapusSelect) return;

    editSelect.innerHTML = '<option value="">Pilih Data</option>';
    hapusSelect.innerHTML = '<option value="">Pilih Data</option>';

    aboutData.forEach(function (a) {
      editSelect.insertAdjacentHTML('beforeend',
        '<option value="' + a.id + '" data-title="' + escapeAboutHtml(a.title) + '" data-content="' + escapeAboutHtml(a.content) + '">' + escapeAboutHtml(a.title) + '</option>'
      );
      hapusSelect.insertAdjacentHTML('beforeend',
        '<option value="' + a.id + '">' + escapeAboutHtml(a.title) + '</option>'
      );
    });
  }

  renderAboutAdminLists();

  function ajaxSubmitAboutForm(form, onSuccess) {
    var formData = new FormData(form);
    fetch(form.action, { method: 'POST', body: formData })
      .then(function (res) { return res.json(); })
      .then(function (json) {
        window.syncCsrfToken && window.syncCsrfToken();
        if (json.success) {
          onSuccess(json.data);
          window.showAjaxToast && window.showAjaxToast(json.message, false);
        } else {
          window.showAjaxToast && window.showAjaxToast(json.message || 'Terjadi kesalahan.', true);
        }
      })
      .catch(function () {
        window.showAjaxToast && window.showAjaxToast('Gagal menghubungi server.', true);
      });
  }

  var formTambahAbout = document.getElementById('formTambahAbout');
  if (formTambahAbout) {
    formTambahAbout.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitAboutForm(formTambahAbout, function (data) {
        aboutData.push(data);
        document.getElementById('aboutGrid').insertAdjacentHTML('beforeend', buildAboutCardHTML(data));
        renderAboutAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalAdd'));
        if (modal) modal.hide();
        formTambahAbout.reset();
      });
    });
  }

  var formEditAbout = document.getElementById('formEditAbout');
  if (formEditAbout) {
    formEditAbout.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitAboutForm(formEditAbout, function (data) {
        var idx = aboutData.findIndex(function (a) { return a.id === data.id; });
        if (idx !== -1) aboutData[idx] = data;

        var oldCard = document.querySelector('#aboutGrid .card[data-id="' + data.id + '"]');
        if (oldCard) oldCard.outerHTML = buildAboutCardHTML(data);

        renderAboutAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEdit'));
        if (modal) modal.hide();
        formEditAbout.reset();
      });
    });
  }

  var formHapusAbout = document.getElementById('formHapusAbout');
  if (formHapusAbout) {
    formHapusAbout.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitAboutForm(formHapusAbout, function (data) {
        aboutData = aboutData.filter(function (a) { return a.id !== data.id; });

        var card = document.querySelector('#aboutGrid .card[data-id="' + data.id + '"]');
        if (card) card.remove();

        renderAboutAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalDelete'));
        if (modal) modal.hide();
        formHapusAbout.reset();
      });
    });
  }
</script>