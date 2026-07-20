<section id="partner" class="py-2">
  <div class="container-fluid text-center pt-5 mt-5">
    <h1 class="fw-bold text-uppercase mb-4 partner-title">Partner By</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3 mb-4 justify-content-center mx-auto">
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#hapusModalPartner">Hapus</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#addModalPartner">Tambah</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalEditPartner">Edit</button>
      </div>
    <?php endif; ?>

    <div id="partnerDynamicArea"></div>
  </div>
</section>

<script>
  var initialPartnerData = <?= json_encode(array_map(function ($p) {
      return [
          'id'       => (int) $p['id'],
          'nama'     => $p['nama'],
          'logo_url' => !empty($p['logo']) ? base_url('img/' . $p['logo']) : null,
      ];
  }, $data_partner)) ?>;
</script>

<?php if (session()->get('isLoggedIn')): ?>
<!-- Modal Tambah Partner -->
<div class="modal fade" id="addModalPartner" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formTambahPartner" action="<?= site_url('admin/partner/tambah') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Partner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="nama">Nama Partner</label>
            <input type="text" name="nama" class="form-control" id="nama" required>
          </div>
          <div class="form-group mb-3">
            <label for="logo">Logo (kosongkan dulu kalau belum ada)</label>
            <input type="file" name="logo" class="form-control" id="logo">
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

<!-- Modal Edit Partner -->
<div class="modal fade" id="modalEditPartner" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formEditPartner" action="<?= base_url('admin/partner/edit') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Partner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" id="editPartnerSelect" class="form-select mb-3" onchange="fillEditPartner(this)" required>
            <option value="">Pilih Partner</option>
          </select>

          <input type="text" name="nama" id="editPartnerNama" class="form-control mb-3" placeholder="Nama Partner" required>

          <div class="text-center mb-3">
            <img id="editPartnerPreview" src="#" alt="Preview Logo" style="max-width: 100px; display: none;" class="rounded shadow-sm">
          </div>
          <input type="file" name="logo" class="form-control mb-3">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus Partner -->
<div class="modal fade" id="hapusModalPartner" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formHapusPartner" action="<?= base_url('admin/partner/hapus') ?>" method="post">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Partner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Pilih partner yang ingin dihapus:</p>
          <div class="list-group overflow-auto" id="hapusPartnerList" style="max-height: 300px;"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function fillEditPartner(select) {
  const option = select.options[select.selectedIndex];
  document.getElementById('editPartnerNama').value = option.getAttribute('data-nama') || '';

  const logo = option.getAttribute('data-logo');
  const preview = document.getElementById('editPartnerPreview');
  if (logo) {
    preview.src = logo;
    preview.style.display = 'block';
  } else {
    preview.style.display = 'none';
  }
}
</script>
<?php endif; ?>

<script>
  // ==== Partner: render penuh via JS (termasuk marquee 6x-repeat) + AJAX CRUD ====

  var partnerData = (initialPartnerData || []).slice();
  var PARTNER_WARNA_CYCLE = ['partner-c1', 'partner-c2', 'partner-c3', 'partner-c4', 'partner-c5', 'partner-c6'];

  function escapePartnerHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function buildPartnerItemHTML(p, index) {
    if (p.logo_url) {
      return '<div class="partner-item partner-item-logo">' +
        '<img src="' + p.logo_url + '" alt="' + escapePartnerHtml(p.nama) + '" class="partner-logo-img">' +
      '</div>';
    }
    var warna = PARTNER_WARNA_CYCLE[index % PARTNER_WARNA_CYCLE.length];
    return '<div class="partner-item ' + warna + '"><span>' + escapePartnerHtml(p.nama) + '</span></div>';
  }

  function attachPartnerHoverPause() {
    var track = document.getElementById('partnerTrack');
    if (!track) return;
    track.querySelectorAll('.partner-item').forEach(function (item) {
      item.addEventListener('mouseenter', function () {
        track.style.animationPlayState = 'paused';
      });
      item.addEventListener('mouseleave', function () {
        track.style.animationPlayState = 'running';
      });
    });
  }

  function renderPartnerArea() {
    var area = document.getElementById('partnerDynamicArea');
    if (!area) return;

    if (partnerData.length === 0) {
      area.innerHTML = '<p class="text-muted">Belum ada partner.</p>';
      return;
    }

    var itemsHtml = '';
    for (var ulang = 0; ulang < 6; ulang++) {
      partnerData.forEach(function (p, index) {
        itemsHtml += buildPartnerItemHTML(p, index);
      });
    }

    area.innerHTML =
      '<div class="marquee-wrapper">' +
        '<div class="marquee-track" id="partnerTrack">' + itemsHtml + '</div>' +
      '</div>';

    attachPartnerHoverPause();
  }

  function renderPartnerAdminLists() {
    var select = document.getElementById('editPartnerSelect');
    var hapusList = document.getElementById('hapusPartnerList');
    if (!select || !hapusList) return;

    select.innerHTML = '<option value="">Pilih Partner</option>';
    hapusList.innerHTML = '';

    partnerData.forEach(function (p) {
      select.insertAdjacentHTML('beforeend',
        '<option value="' + p.id + '" data-nama="' + escapePartnerHtml(p.nama) + '" data-logo="' + (p.logo_url || '') + '">' +
          escapePartnerHtml(p.nama) +
        '</option>'
      );

      hapusList.insertAdjacentHTML('beforeend',
        '<label class="list-group-item d-flex align-items-start gap-3">' +
          '<input class="form-check-input mt-1" type="radio" name="id" value="' + p.id + '" required>' +
          '<p class="fw-bold mb-0 small">' + escapePartnerHtml(p.nama) + '</p>' +
        '</label>'
      );
    });
  }

  renderPartnerArea();
  renderPartnerAdminLists();

  // ---- AJAX submit helpers (dipakai bareng file lain kalau belum ada) ----
  if (typeof window.getCookieValue !== 'function') {
    window.getCookieValue = function (name) {
      var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
      return match ? decodeURIComponent(match[2]) : null;
    };
  }

  if (typeof window.syncCsrfToken !== 'function') {
    window.syncCsrfToken = function () {
      var token = window.getCookieValue('csrf_cookie_name');
      if (!token) return;
      document.querySelectorAll('input[name="csrf_test_name"]').forEach(function (input) {
        input.value = token;
      });
    };
  }

  if (typeof window.showAjaxToast !== 'function') {
    window.showAjaxToast = function (message, isError) {
      var toast = document.createElement('div');
      toast.className = 'ajax-toast' + (isError ? ' ajax-toast-error' : '');
      toast.textContent = message;
      document.body.appendChild(toast);
      setTimeout(function () {
        toast.classList.add('ajax-toast-hide');
        setTimeout(function () { toast.remove(); }, 300);
      }, 2500);
    };
  }

  function ajaxSubmitPartnerForm(form, onSuccess) {
    var formData = new FormData(form);
    fetch(form.action, { method: 'POST', body: formData })
      .then(function (res) { return res.json(); })
      .then(function (json) {
        window.syncCsrfToken();
        if (json.success) {
          onSuccess(json.data);
          window.showAjaxToast(json.message, false);
        } else {
          window.showAjaxToast(json.message || 'Terjadi kesalahan.', true);
        }
      })
      .catch(function () {
        window.showAjaxToast('Gagal menghubungi server.', true);
      });
  }

  var formTambahPartner = document.getElementById('formTambahPartner');
  if (formTambahPartner) {
    formTambahPartner.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitPartnerForm(formTambahPartner, function (data) {
        partnerData.push(data);
        renderPartnerArea();
        renderPartnerAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('addModalPartner'));
        if (modal) modal.hide();
        formTambahPartner.reset();
      });
    });
  }

  var formEditPartner = document.getElementById('formEditPartner');
  if (formEditPartner) {
    formEditPartner.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitPartnerForm(formEditPartner, function (data) {
        var idx = partnerData.findIndex(function (p) { return p.id === data.id; });
        if (idx !== -1) partnerData[idx] = data;

        renderPartnerArea();
        renderPartnerAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditPartner'));
        if (modal) modal.hide();
        formEditPartner.reset();
        document.getElementById('editPartnerPreview').style.display = 'none';
      });
    });
  }

  var formHapusPartner = document.getElementById('formHapusPartner');
  if (formHapusPartner) {
    formHapusPartner.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitPartnerForm(formHapusPartner, function (data) {
        partnerData = partnerData.filter(function (p) { return p.id !== data.id; });

        renderPartnerArea();
        renderPartnerAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('hapusModalPartner'));
        if (modal) modal.hide();
        formHapusPartner.reset();
      });
    });
  }
</script>