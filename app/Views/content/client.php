<section id="client" class="pt-5">
  <div class="mt-5 container-fluid w-100 d-flex justify-content-center align-items-center text-center flex-column">
    <h1 class="text-center fw-bold color-hijau pb-4 text-uppercase">Client</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-4 mb-5">
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalDeleteClient">Hapus</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalAddClient">Tambah</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalEditClient">Edit</button>
      </div>

      <!-- Modal Add -->
      <div class="modal fade" id="modalAddClient" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <form id="formTambahClient" action="<?= base_url('admin/client/tambah') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="modal-content modal-half">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="text" name="judul" class="form-control mb-3" placeholder="Judul" required>
                <input type="file" name="gambar" class="form-control mb-3" required>
                <textarea name="deskripsi" class="form-control" rows="5" placeholder="Deskripsi" required></textarea>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Modal Edit -->
      <div class="modal fade" id="modalEditClient" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <form id="formEditClient" action="<?= base_url('admin/client/edit') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="modal-content modal-half">
              <div class="modal-header">
                <h5 class="modal-title">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <select name="id" id="editClientSelect" class="form-select mb-3" onchange="fillEditClient(this)" required>
                  <option value="">Pilih Client</option>
                </select>

                <input type="text" name="judul" id="editClientJudul" class="form-control mb-3" placeholder="Judul" required>

                <div class="text-center mb-3">
                  <img id="editClientPreview" src="#" alt="Preview Gambar" style="max-width: 100px; display: none;" class="rounded shadow-sm">
                </div>

                <input type="file" name="gambar" class="form-control mb-3">
                <textarea name="deskripsi" id="editClientDeskripsi" class="form-control" placeholder="Deskripsi" required></textarea>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Modal Hapus -->
      <div class="modal fade" id="modalDeleteClient" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <form id="formHapusClient" action="<?= base_url('admin/client/hapus') ?>" method="post">
            <?= csrf_field(); ?>
            <div class="modal-content modal-half">
              <div class="modal-header">
                <h5 class="modal-title">Hapus Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <p>Pilih client yang ingin dihapus:</p>
                <div class="list-group overflow-auto" id="hapusClientList" style="max-height: 300px;"></div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    <?php endif; ?>

    <div class="row w-100" id="clientCarouselArea"></div>
  </div>
</section>

<script>
  var initialClientData = <?= json_encode(array_map(function ($c) {
      return [
          'id'         => (int) $c['id'],
          'judul'      => $c['judul'],
          'deskripsi'  => $c['deskripsi'],
          'gambar_url' => !empty($c['gambar']) ? base_url('img/' . $c['gambar']) : null,
      ];
  }, $clients ?? [])) ?>;
</script>

<script>
  // ==== Client: render penuh via JS (grouping per judul jadi carousel) + AJAX CRUD ====

  var clientData = (initialClientData || []).slice();

  function escapeClientHtml(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  function groupClientData() {
    var groups = {};
    var order = [];
    clientData.forEach(function (c) {
      var key = (c.judul || '').trim();
      if (!groups[key]) {
        groups[key] = [];
        order.push(key);
      }
      groups[key].push(c);
    });
    return order.map(function (key) { return { judul: key, items: groups[key] }; });
  }

  function renderClientCarousels() {
    var area = document.getElementById('clientCarouselArea');
    if (!area) return;

    var groups = groupClientData();
    var html = '';
    var carouselId = 1;

    groups.forEach(function (group) {
      var slidesHtml = group.items.map(function (item, index) {
        var imgHtml = item.gambar_url
          ? '<img class="img-cl" src="' + item.gambar_url + '" style="width:100%" alt="' + escapeClientHtml(item.judul) + '">'
          : '';
        return '<div class="carousel-item ' + (index === 0 ? 'active' : '') + ' p-4">' +
          '<p class="mb-1 fw-bold">' + escapeClientHtml(item.judul) + '</p>' +
          imgHtml +
          '<p class="mt-2">' + escapeClientHtml(item.deskripsi) + '</p>' +
        '</div>';
      }).join('');

      html += '<div class="col-lg-6 col-md-10 col-sm-12 mb-5">' +
        '<div id="minicarousel' + carouselId + '" class="carousel carousel-dark carousel-client slide client-bg rounded-3 clientbg d-flex justify-content-center align-items-center">' +
          '<div class="carousel-inner text-center">' + slidesHtml + '</div>' +
          '<button class="carousel-control-prev" type="button" data-bs-target="#minicarousel' + carouselId + '" data-bs-slide="prev">' +
            '<span class="bg-light d-flex justify-content-center align-items-center text-dark fs-3 p-4 rounded-pill carousel-control-prev-icon" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>' +
          '</button>' +
          '<button class="carousel-control-next" type="button" data-bs-target="#minicarousel' + carouselId + '" data-bs-slide="next">' +
            '<span class="bg-light text-dark d-flex justify-content-center align-items-center fs-3 p-4 rounded-pill carousel-control-next-icon" aria-hidden="true"><i class="bi bi-caret-right-fill"></i></span>' +
          '</button>' +
        '</div>' +
      '</div>';

      carouselId++;
    });

    area.innerHTML = html;

    // Bootstrap carousel butuh di-init manual karena dibuat lewat innerHTML (bukan saat page load)
    area.querySelectorAll('.carousel').forEach(function (el) {
      new bootstrap.Carousel(el);
    });
  }

  function renderClientAdminLists() {
    var select = document.getElementById('editClientSelect');
    var hapusList = document.getElementById('hapusClientList');
    if (!select || !hapusList) return;

    select.innerHTML = '<option value="">Pilih Client</option>';
    hapusList.innerHTML = '';

    clientData.forEach(function (c) {
      select.insertAdjacentHTML('beforeend',
        '<option value="' + c.id + '" data-judul="' + escapeClientHtml(c.judul) + '" data-deskripsi="' + escapeClientHtml(c.deskripsi) + '" data-gambar="' + (c.gambar_url || '') + '">' +
          escapeClientHtml(c.judul) +
        '</option>'
      );

      hapusList.insertAdjacentHTML('beforeend',
        '<label class="list-group-item d-flex align-items-start gap-3">' +
          '<input class="form-check-input mt-1" type="radio" name="id" value="' + c.id + '" required>' +
          '<div class="tabel-modal d-flex flex-column justify-content-center align-items-center">' +
            '<div class="d-flex flex-row align-items-start justify-content-start w-100">' +
              '<p class="fw-bold mb-1">' + escapeClientHtml(c.judul) + '</p>' +
            '</div>' +
            '<p class="mb-0 small">' + escapeClientHtml(c.deskripsi) + '</p>' +
          '</div>' +
        '</label>'
      );
    });
  }

  function fillEditClient(select) {
    var option = select.options[select.selectedIndex];
    document.getElementById('editClientJudul').value = option.getAttribute('data-judul') || '';
    document.getElementById('editClientDeskripsi').value = option.getAttribute('data-deskripsi') || '';

    var gambar = option.getAttribute('data-gambar');
    var preview = document.getElementById('editClientPreview');
    if (gambar) {
      preview.src = gambar;
      preview.style.display = 'block';
    } else {
      preview.style.display = 'none';
    }
  }

  renderClientCarousels();
  renderClientAdminLists();

  function ajaxSubmitClientForm(form, onSuccess) {
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

  var formTambahClient = document.getElementById('formTambahClient');
  if (formTambahClient) {
    formTambahClient.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitClientForm(formTambahClient, function (data) {
        clientData.push(data);
        renderClientCarousels();
        renderClientAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalAddClient'));
        if (modal) modal.hide();
        formTambahClient.reset();
      });
    });
  }

  var formEditClient = document.getElementById('formEditClient');
  if (formEditClient) {
    formEditClient.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitClientForm(formEditClient, function (data) {
        var idx = clientData.findIndex(function (c) { return c.id === data.id; });
        if (idx !== -1) clientData[idx] = data;

        renderClientCarousels();
        renderClientAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditClient'));
        if (modal) modal.hide();
        formEditClient.reset();
        document.getElementById('editClientPreview').style.display = 'none';
      });
    });
  }

  var formHapusClient = document.getElementById('formHapusClient');
  if (formHapusClient) {
    formHapusClient.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitClientForm(formHapusClient, function (data) {
        clientData = clientData.filter(function (c) { return c.id !== data.id; });

        renderClientCarousels();
        renderClientAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteClient'));
        if (modal) modal.hide();
        formHapusClient.reset();
      });
    });
  }
</script>