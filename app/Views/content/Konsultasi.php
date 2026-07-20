<section id="konsultasi" class="py-2">
  <div class="container-fluid py-2 pt-5 mt-5 d-flex flex-column align-items-center">

    <h1 class="fw-bold text-uppercase mb-4 konsultasi-title">Konsultasi Berbayar</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3 mb-4 justify-content-center">
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#hapusModalKonsultasi">Hapus</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#addModalKonsultasi">Tambah</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalEditKonsultasi">Edit</button>
      </div>
    <?php endif; ?>

    <?php if (empty($data_konsultasi)): ?>
      <p class="text-muted">Belum ada paket konsultasi.</p>
    <?php endif; ?>

    <div class="row gap-4 justify-content-center" id="konsultasiGrid">
      <?php foreach ($data_konsultasi as $k): ?>
        <?php $adaHarga = ((float) $k['harga']) > 0; ?>
        <div class="konsultasi-card col-lg-3 col-md-5 col-sm-10" data-id="<?= $k['id'] ?>">
          <h5 class="konsultasi-nama"><?= esc($k['nama_paket']) ?></h5>
          <p class="konsultasi-harga">
            <?= $adaHarga ? 'Rp' . number_format((float) $k['harga'], 0, ',', '.') : 'Hubungi kami untuk harga' ?>
          </p>
          <?php if (!empty($k['deskripsi'])): ?>
            <p class="konsultasi-deskripsi"><?= esc($k['deskripsi']) ?></p>
          <?php endif; ?>
          <button
            type="button"
            class="btn-booking-konsultasi"
            onclick="openBookingKonsultasi('<?= esc($k['nama_paket'], 'js') ?>', <?= (float) $k['harga'] ?>)"
          >
            <i class="bi bi-whatsapp"></i> Booking Konsultasi
          </button>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Modal Booking Konsultasi -->
<div class="modal fade" id="bookingKonsultasiModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form onsubmit="submitBookingKonsultasi(event)">
        <div class="modal-header">
          <h5 class="modal-title">Booking Konsultasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="mb-3">
            Paket: <strong id="bookingKonsultasiPaket"></strong>
          </p>

          <div class="mb-3">
            <label for="konsultasiNama" class="form-label">Nama Lengkap</label>
            <input type="text" id="konsultasiNama" class="form-control" placeholder="Masukkan nama Anda" required>
          </div>
          <div class="mb-3">
            <label for="konsultasiNoHp" class="form-label">No HP / WhatsApp</label>
            <input type="text" id="konsultasiNoHp" class="form-control" placeholder="Contoh: 081234567890" required>
          </div>
          <div class="mb-3">
            <label for="konsultasiKeluhan" class="form-label">Kebutuhan / Topik Konsultasi</label>
            <textarea id="konsultasiKeluhan" class="form-control" rows="3" placeholder="Ceritakan kebutuhan konsultasi Anda" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-whatsapp"></i> Kirim ke WhatsApp
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php if (session()->get('isLoggedIn')): ?>
<!-- Modal Tambah Paket Konsultasi -->
<div class="modal fade" id="addModalKonsultasi" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formTambahKonsultasi" action="<?= site_url('admin/konsultasi/tambah') ?>" method="post">
        <?= csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Paket Konsultasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="nama_paket">Nama Paket</label>
            <input type="text" name="nama_paket" class="form-control" id="nama_paket" required>
          </div>
          <div class="form-group mb-3">
            <label for="harga">Harga (isi 0 kalau belum ditentukan)</label>
            <input type="number" name="harga" class="form-control" id="harga" min="0" step="1" value="0" required>
          </div>
          <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="2"></textarea>
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

<!-- Modal Edit Paket Konsultasi -->
<div class="modal fade" id="modalEditKonsultasi" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formEditKonsultasi" action="<?= base_url('admin/konsultasi/edit') ?>" method="post">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Paket Konsultasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" id="editKonsultasiSelect" class="form-select mb-3" onchange="fillEditKonsultasi(this)" required>
            <option value="">Pilih Paket</option>
            <?php foreach ($data_konsultasi as $k): ?>
              <option
                value="<?= $k['id'] ?>"
                data-nama="<?= htmlspecialchars($k['nama_paket'], ENT_QUOTES) ?>"
                data-harga="<?= (float) $k['harga'] ?>"
                data-deskripsi="<?= htmlspecialchars((string) $k['deskripsi'], ENT_QUOTES) ?>"
              >
                <?= esc($k['nama_paket']) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <input type="text" name="nama_paket" id="editKonsultasiNama" class="form-control mb-3" placeholder="Nama Paket" required>
          <input type="number" name="harga" id="editKonsultasiHarga" class="form-control mb-3" placeholder="Harga" min="0" step="1" required>
          <textarea name="deskripsi" id="editKonsultasiDeskripsi" class="form-control mb-3" rows="2" placeholder="Deskripsi"></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus Paket Konsultasi -->
<div class="modal fade" id="hapusModalKonsultasi" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formHapusKonsultasi" action="<?= base_url('admin/konsultasi/hapus') ?>" method="post">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Paket Konsultasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Pilih paket yang ingin dihapus:</p>
          <div class="list-group overflow-auto" id="hapusKonsultasiList" style="max-height: 300px;">
            <?php foreach ($data_konsultasi as $k): ?>
              <label class="list-group-item d-flex align-items-start gap-3">
                <input class="form-check-input mt-1" type="radio" name="id" value="<?= $k['id'] ?>" required>
                <div class="d-flex flex-column justify-content-center align-items-start">
                  <p class="fw-bold mb-1 small"><?= esc($k['nama_paket']) ?></p>
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
function fillEditKonsultasi(select) {
  const option = select.options[select.selectedIndex];
  document.getElementById('editKonsultasiNama').value = option.getAttribute('data-nama') || '';
  document.getElementById('editKonsultasiHarga').value = option.getAttribute('data-harga') || '0';
  document.getElementById('editKonsultasiDeskripsi').value = option.getAttribute('data-deskripsi') || '';
}
</script>

<script>
  function escapeKonsultasiHtml(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  function buildKonsultasiCardHTML(k) {
    var adaHarga = parseFloat(k.harga) > 0;
    var hargaText = adaHarga ? 'Rp' + Number(k.harga).toLocaleString('id-ID') : 'Hubungi kami untuk harga';
    var deskripsiHtml = k.deskripsi ? '<p class="konsultasi-deskripsi">' + escapeKonsultasiHtml(k.deskripsi) + '</p>' : '';

    return '<div class="konsultasi-card col-lg-3 col-md-5 col-sm-10" data-id="' + k.id + '">' +
      '<h5 class="konsultasi-nama">' + escapeKonsultasiHtml(k.nama_paket) + '</h5>' +
      '<p class="konsultasi-harga">' + hargaText + '</p>' +
      deskripsiHtml +
      '<button type="button" class="btn-booking-konsultasi" onclick="openBookingKonsultasi(\'' + escapeKonsultasiHtml(k.nama_paket).replace(/'/g, "\\'") + '\', ' + parseFloat(k.harga) + ')"><i class="bi bi-whatsapp"></i> Booking Konsultasi</button>' +
    '</div>';
  }

  function buildKonsultasiOptionHTML(k) {
    return '<option value="' + k.id + '" data-nama="' + escapeKonsultasiHtml(k.nama_paket) + '" data-harga="' + k.harga + '" data-deskripsi="' + escapeKonsultasiHtml(k.deskripsi || '') + '">' + escapeKonsultasiHtml(k.nama_paket) + '</option>';
  }

  function buildKonsultasiHapusItemHTML(k) {
    return '<label class="list-group-item d-flex align-items-start gap-3">' +
      '<input class="form-check-input mt-1" type="radio" name="id" value="' + k.id + '" required>' +
      '<div class="d-flex flex-column justify-content-center align-items-start">' +
        '<p class="fw-bold mb-1 small">' + escapeKonsultasiHtml(k.nama_paket) + '</p>' +
      '</div>' +
    '</label>';
  }

  function ajaxSubmitKonsultasiForm(form, onSuccess) {
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

  var formTambahKonsultasi = document.getElementById('formTambahKonsultasi');
  if (formTambahKonsultasi) {
    formTambahKonsultasi.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitKonsultasiForm(formTambahKonsultasi, function (data) {
        document.getElementById('konsultasiGrid').insertAdjacentHTML('beforeend', buildKonsultasiCardHTML(data));
        document.getElementById('editKonsultasiSelect').insertAdjacentHTML('beforeend', buildKonsultasiOptionHTML(data));
        document.getElementById('hapusKonsultasiList').insertAdjacentHTML('beforeend', buildKonsultasiHapusItemHTML(data));

        var modal = bootstrap.Modal.getInstance(document.getElementById('addModalKonsultasi'));
        if (modal) modal.hide();
        formTambahKonsultasi.reset();
      });
    });
  }

  var formEditKonsultasi = document.getElementById('formEditKonsultasi');
  if (formEditKonsultasi) {
    formEditKonsultasi.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitKonsultasiForm(formEditKonsultasi, function (data) {
        var oldCard = document.querySelector('.konsultasi-card[data-id="' + data.id + '"]');
        if (oldCard) oldCard.outerHTML = buildKonsultasiCardHTML(data);

        var oldOption = document.querySelector('#editKonsultasiSelect option[value="' + data.id + '"]');
        if (oldOption) oldOption.outerHTML = buildKonsultasiOptionHTML(data);

        var oldRadio = document.querySelector('#hapusKonsultasiList input[value="' + data.id + '"]');
        if (oldRadio) oldRadio.closest('label').outerHTML = buildKonsultasiHapusItemHTML(data);

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditKonsultasi'));
        if (modal) modal.hide();
        formEditKonsultasi.reset();
      });
    });
  }

  var formHapusKonsultasi = document.getElementById('formHapusKonsultasi');
  if (formHapusKonsultasi) {
    formHapusKonsultasi.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitKonsultasiForm(formHapusKonsultasi, function (data) {
        var card = document.querySelector('.konsultasi-card[data-id="' + data.id + '"]');
        if (card) card.remove();

        var option = document.querySelector('#editKonsultasiSelect option[value="' + data.id + '"]');
        if (option) option.remove();

        var radio = document.querySelector('#hapusKonsultasiList input[value="' + data.id + '"]');
        if (radio) radio.closest('label').remove();

        var modal = bootstrap.Modal.getInstance(document.getElementById('hapusModalKonsultasi'));
        if (modal) modal.hide();
        formHapusKonsultasi.reset();
      });
    });
  }
</script>
<?php endif; ?>

<script>
  var WA_NUMBER_KONSULTASI = '<?= $social['wa_number'] ?>';
  var selectedPaketKonsultasi = { nama: '', harga: 0 };

  function openBookingKonsultasi(nama, harga) {
    selectedPaketKonsultasi = { nama: nama, harga: harga };

    var hargaText = harga > 0
      ? ('Rp' + Number(harga).toLocaleString('id-ID'))
      : 'Hubungi kami untuk harga';

    document.getElementById('bookingKonsultasiPaket').textContent = nama + ' (' + hargaText + ')';

    var modal = new bootstrap.Modal(document.getElementById('bookingKonsultasiModal'));
    modal.show();
  }

  function submitBookingKonsultasi(event) {
    event.preventDefault();

    var nama = document.getElementById('konsultasiNama').value.trim();
    var noHp = document.getElementById('konsultasiNoHp').value.trim();
    var keluhan = document.getElementById('konsultasiKeluhan').value.trim();

    if (!nama || !noHp || !keluhan) {
      alert('Mohon lengkapi nama, no HP, dan kebutuhan konsultasi.');
      return;
    }

    var hargaText = selectedPaketKonsultasi.harga > 0
      ? ('Rp' + Number(selectedPaketKonsultasi.harga).toLocaleString('id-ID'))
      : 'Hubungi kami untuk harga';

    var message = 'Halo, saya ingin booking konsultasi:\n\n' +
      'Paket: ' + selectedPaketKonsultasi.nama + ' (' + hargaText + ')\n\n' +
      'Data Pemesan:\nNama: ' + nama +
      '\nNo HP: ' + noHp +
      '\nKebutuhan/Topik: ' + keluhan;

    var url = 'https://wa.me/' + WA_NUMBER_KONSULTASI + '?text=' + encodeURIComponent(message);
    window.open(url, '_blank');

    var modalEl = document.getElementById('bookingKonsultasiModal');
    var modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    event.target.reset();
  }
</script>