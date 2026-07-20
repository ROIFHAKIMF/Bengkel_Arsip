<section id="testimoni" class="py-2">
  <div class="container-fluid py-2 pt-5 mt-5 d-flex flex-column align-items-center">

    <h1 class="fw-bold text-uppercase mb-4 testimoni-title">Testimoni</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3 mb-4 justify-content-center">
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#hapusModalTestimoni">Hapus</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#addModalTestimoni">Tambah</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalEditTestimoni">Edit</button>
      </div>
    <?php endif; ?>

    <?php if (empty($data_testimoni)): ?>
      <p class="text-muted">Belum ada testimoni.</p>
    <?php endif; ?>

    <div class="row gap-4 justify-content-center" id="testimoniGrid">
      <?php foreach ($data_testimoni as $t): ?>
        <div class="testimoni-card col-lg-3 col-md-5 col-sm-10" data-id="<?= $t['id'] ?>">
          <?php if (!empty($t['foto'])): ?>
            <img src="<?= base_url('img/' . $t['foto']) ?>" class="testimoni-foto" alt="<?= esc($t['nama']) ?>">
          <?php else: ?>
            <div class="testimoni-foto testimoni-foto-placeholder"><i class="bi bi-person-fill"></i></div>
          <?php endif; ?>

          <h5 class="testimoni-nama"><?= esc($t['nama']) ?></h5>

          <div class="testimoni-rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <i class="bi <?= $i <= (int) $t['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
            <?php endfor; ?>
          </div>

          <p class="testimoni-ulasan">&ldquo;<?= esc($t['ulasan']) ?>&rdquo;</p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if (session()->get('isLoggedIn')): ?>
<!-- Modal Tambah Testimoni -->
<div class="modal fade" id="addModalTestimoni" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formTambahTestimoni" action="<?= site_url('admin/testimoni/tambah') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Testimoni</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" required>
          </div>
          <div class="form-group mb-3">
            <label for="ulasan">Ulasan</label>
            <textarea name="ulasan" class="form-control" id="ulasan" rows="3" required></textarea>
          </div>
          <div class="form-group mb-3">
            <label for="rating">Rating</label>
            <select name="rating" class="form-select" id="rating" required>
              <option value="5">5 - Sangat Puas</option>
              <option value="4">4 - Puas</option>
              <option value="3">3 - Cukup</option>
              <option value="2">2 - Kurang</option>
              <option value="1">1 - Tidak Puas</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="foto">Foto</label>
            <input type="file" name="foto" class="form-control" id="foto">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Testimoni -->
<div class="modal fade" id="modalEditTestimoni" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formEditTestimoni" action="<?= base_url('admin/testimoni/edit') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Testimoni</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" id="editTestimoniSelect" class="form-select mb-3" onchange="fillEditTestimoni(this)" required>
            <option value="">Pilih Testimoni</option>
            <?php foreach ($data_testimoni as $t): ?>
              <option
                value="<?= $t['id'] ?>"
                data-nama="<?= htmlspecialchars($t['nama'], ENT_QUOTES) ?>"
                data-ulasan="<?= htmlspecialchars($t['ulasan'], ENT_QUOTES) ?>"
                data-rating="<?= (int) $t['rating'] ?>"
                data-foto="<?= !empty($t['foto']) ? base_url('img/' . $t['foto']) : '' ?>"
              >
                <?= esc($t['nama']) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <input type="text" name="nama" id="editTestimoniNama" class="form-control mb-3" placeholder="Nama" required>
          <textarea name="ulasan" id="editTestimoniUlasan" class="form-control mb-3" rows="3" placeholder="Ulasan" required></textarea>
          <select name="rating" id="editTestimoniRating" class="form-select mb-3" required>
            <option value="5">5 - Sangat Puas</option>
            <option value="4">4 - Puas</option>
            <option value="3">3 - Cukup</option>
            <option value="2">2 - Kurang</option>
            <option value="1">1 - Tidak Puas</option>
          </select>

          <div class="text-center mb-3">
            <img id="editTestimoniPreview" src="#" alt="Preview Foto" style="max-width: 100px; display: none;" class="rounded-circle shadow-sm">
          </div>
          <input type="file" name="foto" class="form-control mb-3">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus Testimoni -->
<div class="modal fade" id="hapusModalTestimoni" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formHapusTestimoni" action="<?= base_url('admin/testimoni/hapus') ?>" method="post">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Testimoni</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Pilih testimoni yang ingin dihapus:</p>
          <div class="list-group overflow-auto" id="hapusTestimoniList" style="max-height: 300px;">
            <?php foreach ($data_testimoni as $t): ?>
              <label class="list-group-item d-flex align-items-start gap-3">
                <input class="form-check-input mt-1" type="radio" name="id" value="<?= $t['id'] ?>" required>
                <div class="d-flex flex-column justify-content-center align-items-start">
                  <p class="fw-bold mb-1 small"><?= esc($t['nama']) ?></p>
                  <p class="mb-0 small text-muted"><?= esc(mb_strimwidth($t['ulasan'], 0, 60, '...')) ?></p>
                </div>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function fillEditTestimoni(select) {
  const option = select.options[select.selectedIndex];
  document.getElementById('editTestimoniNama').value = option.getAttribute('data-nama') || '';
  document.getElementById('editTestimoniUlasan').value = option.getAttribute('data-ulasan') || '';
  document.getElementById('editTestimoniRating').value = option.getAttribute('data-rating') || '5';

  const foto = option.getAttribute('data-foto');
  const preview = document.getElementById('editTestimoniPreview');
  if (foto) {
    preview.src = foto;
    preview.style.display = 'block';
  } else {
    preview.style.display = 'none';
  }
}
</script>

<script>
  function escapeTestimoniHtml(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  function buildTestimoniStars(rating) {
    var html = '';
    for (var i = 1; i <= 5; i++) {
      html += '<i class="bi ' + (i <= rating ? 'bi-star-fill' : 'bi-star') + '"></i>';
    }
    return html;
  }

  function buildTestimoniCardHTML(t) {
    var fotoHtml = t.foto_url
      ? '<img src="' + t.foto_url + '" class="testimoni-foto" alt="' + escapeTestimoniHtml(t.nama) + '">'
      : '<div class="testimoni-foto testimoni-foto-placeholder"><i class="bi bi-person-fill"></i></div>';

    return '<div class="testimoni-card col-lg-3 col-md-5 col-sm-10" data-id="' + t.id + '">' +
      fotoHtml +
      '<h5 class="testimoni-nama">' + escapeTestimoniHtml(t.nama) + '</h5>' +
      '<div class="testimoni-rating">' + buildTestimoniStars(parseInt(t.rating, 10)) + '</div>' +
      '<p class="testimoni-ulasan">&ldquo;' + escapeTestimoniHtml(t.ulasan) + '&rdquo;</p>' +
    '</div>';
  }

  function buildTestimoniOptionHTML(t) {
    return '<option value="' + t.id + '" data-nama="' + escapeTestimoniHtml(t.nama) + '" data-ulasan="' + escapeTestimoniHtml(t.ulasan) + '" data-rating="' + t.rating + '" data-foto="' + (t.foto_url || '') + '">' + escapeTestimoniHtml(t.nama) + '</option>';
  }

  function buildTestimoniHapusItemHTML(t) {
    return '<label class="list-group-item d-flex align-items-start gap-3">' +
      '<input class="form-check-input mt-1" type="radio" name="id" value="' + t.id + '" required>' +
      '<div class="d-flex flex-column justify-content-center align-items-start">' +
        '<p class="fw-bold mb-1 small">' + escapeTestimoniHtml(t.nama) + '</p>' +
      '</div>' +
    '</label>';
  }

  function ajaxSubmitTestimoniForm(form, onSuccess) {
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

  var formTambahTestimoni = document.getElementById('formTambahTestimoni');
  if (formTambahTestimoni) {
    formTambahTestimoni.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitTestimoniForm(formTambahTestimoni, function (data) {
        var emptyMsg = document.querySelector('#testimoniGrid').parentElement.querySelector('p.text-muted');
        if (emptyMsg) emptyMsg.remove();

        document.getElementById('testimoniGrid').insertAdjacentHTML('beforeend', buildTestimoniCardHTML(data));
        document.getElementById('editTestimoniSelect').insertAdjacentHTML('beforeend', buildTestimoniOptionHTML(data));
        document.getElementById('hapusTestimoniList').insertAdjacentHTML('beforeend', buildTestimoniHapusItemHTML(data));

        var modal = bootstrap.Modal.getInstance(document.getElementById('addModalTestimoni'));
        if (modal) modal.hide();
        formTambahTestimoni.reset();
      });
    });
  }

  var formEditTestimoni = document.getElementById('formEditTestimoni');
  if (formEditTestimoni) {
    formEditTestimoni.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitTestimoniForm(formEditTestimoni, function (data) {
        var oldCard = document.querySelector('.testimoni-card[data-id="' + data.id + '"]');
        if (oldCard) oldCard.outerHTML = buildTestimoniCardHTML(data);

        var oldOption = document.querySelector('#editTestimoniSelect option[value="' + data.id + '"]');
        if (oldOption) oldOption.outerHTML = buildTestimoniOptionHTML(data);

        var oldRadio = document.querySelector('#hapusTestimoniList input[value="' + data.id + '"]');
        if (oldRadio) oldRadio.closest('label').outerHTML = buildTestimoniHapusItemHTML(data);

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditTestimoni'));
        if (modal) modal.hide();
        formEditTestimoni.reset();
        document.getElementById('editTestimoniPreview').style.display = 'none';
      });
    });
  }

  var formHapusTestimoni = document.getElementById('formHapusTestimoni');
  if (formHapusTestimoni) {
    formHapusTestimoni.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitTestimoniForm(formHapusTestimoni, function (data) {
        var card = document.querySelector('.testimoni-card[data-id="' + data.id + '"]');
        if (card) card.remove();

        var option = document.querySelector('#editTestimoniSelect option[value="' + data.id + '"]');
        if (option) option.remove();

        var radio = document.querySelector('#hapusTestimoniList input[value="' + data.id + '"]');
        if (radio) radio.closest('label').remove();

        var modal = bootstrap.Modal.getInstance(document.getElementById('hapusModalTestimoni'));
        if (modal) modal.hide();
        formHapusTestimoni.reset();
      });
    });
  }
</script>
<?php endif; ?>