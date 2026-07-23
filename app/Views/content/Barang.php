<section id="barang" class="py-2">
  <div class="container-fluid py-2 pt-5 mt-5 d-flex flex-column align-items-center">

    <h1 class="fw-bold text-uppercase mb-4 barang-title">List Barang</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3 mb-4 justify-content-center">
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#hapusModalBarang">Hapus</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#addModalBarang">Tambah</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalEditBarang">Edit</button>
      </div>
    <?php endif; ?>

    <?php if (empty($data_barang)): ?>
      <p class="text-muted" id="barangEmptyMsg">Belum ada barang yang ditambahkan.</p>
    <?php endif; ?>

    <!-- search filter -->
    <div class="row w-75 gap-3 mb-4 justify-content-center align-items-center" id="barangFilterBar">
      <div class="col-lg-5 col-md-6 col-sm-12">
        <input type="text" id="barangSearchInput" class="form-control" placeholder="Cari nama barang...">
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6">
        <select id="barangStokFilter" class="form-select">
          <option value="semua">Semua Stok</option>
          <option value="tersedia">Tersedia</option>
          <option value="habis">Stok Habis</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6">
        <select id="barangSortFilter" class="form-select">
          <option value="default">Urutkan</option>
          <option value="harga_asc">Harga Terendah</option>
          <option value="harga_desc">Harga Tertinggi</option>
          <option value="nama_asc">Nama A-Z</option>
        </select>
      </div>
    </div>

    <p class="text-muted" id="barangNoResultMsg" style="display:none;">Barang tidak ditemukan.</p>
    <div class="row gap-4 justify-content-center" id="barangGrid">
      <?php foreach ($data_barang as $b): ?>
        <?php
          $qtyId = 'qtyBarang' . $b['id'];
          $stokHabis = ((int) $b['stok']) <= 0;
        ?>
        <div class="barang-card col-lg-3 col-md-5 col-sm-10" data-id="<?= $b['id'] ?>" data-nama="<?= esc(strtolower($b['nama'])) ?>" data-harga="<?= (float) $b['harga'] ?>" data-stok="<?= $stokHabis ? 'habis' : 'tersedia' ?>">
          <?php if (!empty($b['gambar'])): ?>
            <img src="<?= base_url('img/' . $b['gambar']) ?>" class="barang-img" alt="<?= esc($b['nama']) ?>">
          <?php else: ?>
            <div class="barang-img barang-img-placeholder"><i class="bi bi-image"></i></div>
          <?php endif; ?>

          <h5 class="barang-nama"><?= esc($b['nama']) ?></h5>
          <p class="barang-harga">Rp<?= number_format((float) $b['harga'], 0, ',', '.') ?></p>
          <p class="barang-stok <?= $stokHabis ? 'text-danger' : '' ?>">
            <?= $stokHabis ? 'Stok habis' : 'Stok: ' . (int) $b['stok'] ?>
          </p>

          <?php if (!empty($b['deskripsi'])): ?>
            <p class="barang-deskripsi"><?= esc($b['deskripsi']) ?></p>
          <?php endif; ?>

          <?php if (!$stokHabis): ?>
            <div class="qty-stepper mb-2">
              <button type="button" class="btn-qty" onclick="stepProductQty('<?= $qtyId ?>', -1, <?= (int) $b['stok'] ?>)">-</button>
              <input type="number" id="<?= $qtyId ?>" class="qty-input" value="1" min="1" max="<?= (int) $b['stok'] ?>" >
              <button type="button" class="btn-qty" onclick="stepProductQty('<?= $qtyId ?>', 1, <?= (int) $b['stok'] ?>)">+</button>
            </div>
            <button
              type="button"
              class="btn-add-cart"
              onclick="addToCart(<?= (int) $b['id'] ?>, '<?= esc($b['nama'], 'js') ?>', <?= (float) $b['harga'] ?>, '<?= !empty($b['gambar']) ? base_url('img/' . $b['gambar']) : '' ?>', '<?= $qtyId ?>')"
            >
              <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
            </button>
          <?php else: ?>
            <button type="button" class="btn-add-cart" disabled>Stok Habis</button>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  (function () {
    var searchInput = document.getElementById('barangSearchInput');
    var stokFilter = document.getElementById('barangStokFilter');
    var sortFilter = document.getElementById('barangSortFilter');
    var grid = document.getElementById('barangGrid');
    var noResultMsg = document.getElementById('barangNoResultMsg');

    if (!searchInput || !stokFilter || !sortFilter || !grid) return;

    function applyBarangFilter() {
      var keyword = searchInput.value.trim().toLowerCase();
      var stok = stokFilter.value;
      var cards = Array.prototype.slice.call(grid.querySelectorAll('.barang-card'));
      var visibleCount = 0;

      cards.forEach(function (card) {
        var nama = card.getAttribute('data-nama') || '';
        var cardStok = card.getAttribute('data-stok') || '';
        var matchKeyword = !keyword || nama.indexOf(keyword) !== -1;
        var matchStok = stok === 'semua' || stok === cardStok;
        var visible = matchKeyword && matchStok;
        card.style.display = visible ? '' : 'none';
        if (visible) visibleCount++;
      });

      if (noResultMsg) {
        noResultMsg.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
      }
      applyBarangSort();
    }

    function applyBarangSort() {
      var sortBy = sortFilter.value;
      if (sortBy === 'default') return;
      var cards = Array.prototype.slice.call(grid.querySelectorAll('.barang-card'));

      cards.sort(function (a, b) {
        if (sortBy === 'harga_asc') return parseFloat(a.getAttribute('data-harga')) - parseFloat(b.getAttribute('data-harga'));
        if (sortBy === 'harga_desc') return parseFloat(b.getAttribute('data-harga')) - parseFloat(a.getAttribute('data-harga'));
        if (sortBy === 'nama_asc') return (a.getAttribute('data-nama') || '').localeCompare(b.getAttribute('data-nama') || '');
        return 0;
      });

      cards.forEach(function (card) { grid.appendChild(card); });
    }

    searchInput.addEventListener('input', applyBarangFilter);
    stokFilter.addEventListener('change', applyBarangFilter);
    sortFilter.addEventListener('change', applyBarangFilter);
  })();
</script>
<!-- Floating Cart Button -->
<button type="button" id="cartFloatBtn" class="cart-float-btn" style="display:none;" onclick="openCartModal()" aria-label="Keranjang">
  <i class="bi bi-cart3 fs-4"></i>
  <span id="cartBadge" class="cart-badge" style="display:none;">0</span>
</button>

<script>
  (function () {
    var barangSection = document.getElementById('barang');
    var cartBtn = document.getElementById('cartFloatBtn');
    if (!barangSection || !cartBtn || typeof IntersectionObserver === 'undefined') return;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        cartBtn.style.display = entry.isIntersecting ? 'flex' : 'none';
      });
    }, { threshold: 0.15 });

    observer.observe(barangSection);
  })();
</script>

<!-- Modal Cart -->
<div class="modal fade" id="cartModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Keranjang Belanja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="cartItemsContainer"></div>
      </div>
      <div class="modal-footer d-flex flex-column align-items-stretch">
        <div class="d-flex justify-content-between w-100 mb-2">
          <span class="fw-bold">Total</span>
          <span class="fw-bold" id="cartTotal">Rp0</span>
        </div>
        <button type="button" class="btn btn-success w-100" onclick="goToCheckout()">Checkout</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Checkout -->
<div class="modal fade" id="checkoutModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form onsubmit="submitCheckout(event)">
        <div class="modal-header">
          <h5 class="modal-title">Form Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="fw-bold mb-1">Ringkasan Pesanan:</p>
          <div id="checkoutSummary" class="small text-muted mb-2"></div>
          <div class="d-flex justify-content-between mb-3">
            <span class="fw-bold">Total</span>
            <span class="fw-bold" id="checkoutTotalPreview">Rp0</span>
          </div>

          <div class="mb-3">
            <label for="checkoutNama" class="form-label">Nama Lengkap</label>
            <input type="text" id="checkoutNama" class="form-control" placeholder="Masukkan nama Anda" required>
          </div>
          <div class="mb-3">
            <label for="checkoutNoHp" class="form-label">No HP / WhatsApp</label>
            <input type="text" id="checkoutNoHp" class="form-control" placeholder="Contoh: 081234567890" required>
          </div>
          <div class="mb-3">
            <label for="checkoutAlamat" class="form-label">Alamat Pengiriman</label>
            <textarea id="checkoutAlamat" class="form-control" rows="2" placeholder="Alamat lengkap" required></textarea>
          </div>
          <div class="mb-3">
            <label for="checkoutCatatan" class="form-label">Catatan (opsional)</label>
            <textarea id="checkoutCatatan" class="form-control" rows="2" placeholder="Catatan tambahan"></textarea>
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
<!-- Modal Tambah Barang -->
<div class="modal fade" id="addModalBarang" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formTambahBarang" action="<?= site_url('admin/barang/tambah') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="nama">Nama Barang</label>
            <input type="text" name="nama" class="form-control" id="nama" required>
          </div>
          <div class="form-group mb-3">
            <label for="harga">Harga</label>
            <input type="number" name="harga" class="form-control" id="harga" min="0" step="1" required>
          </div>
          <div class="form-group mb-3">
            <label for="stok">Stok</label>
            <input type="number" name="stok" class="form-control" id="stok" min="0" step="1" required>
          </div>
          <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="2"></textarea>
          </div>
          <div class="form-group mb-3">
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" class="form-control" id="gambar">
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

<!-- Modal Edit Barang -->
<div class="modal fade" id="modalEditBarang" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formEditBarang" action="<?= base_url('admin/barang/edit') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" id="editBarangSelect" class="form-select mb-3" onchange="fillEditBarang(this)" required>
            <option value="">Pilih Barang</option>
            <?php foreach ($data_barang as $b): ?>
              <option
                value="<?= $b['id'] ?>"
                data-nama="<?= htmlspecialchars($b['nama'], ENT_QUOTES) ?>"
                data-harga="<?= (float) $b['harga'] ?>"
                data-stok="<?= (int) $b['stok'] ?>"
                data-deskripsi="<?= htmlspecialchars((string) $b['deskripsi'], ENT_QUOTES) ?>"
                data-gambar="<?= !empty($b['gambar']) ? base_url('img/' . $b['gambar']) : '' ?>"
              >
                <?= esc($b['nama']) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <input type="text" name="nama" id="editBarangNama" class="form-control mb-3" placeholder="Nama Barang" required>
          <input type="number" name="harga" id="editBarangHarga" class="form-control mb-3" placeholder="Harga" min="0" step="1" required>
          <input type="number" name="stok" id="editBarangStok" class="form-control mb-3" placeholder="Stok" min="0" step="1" required>
          <textarea name="deskripsi" id="editBarangDeskripsi" class="form-control mb-3" rows="2" placeholder="Deskripsi"></textarea>

          <div class="text-center mb-3">
            <img id="editBarangPreview" src="#" alt="Preview Gambar" style="max-width: 100px; display: none;" class="rounded shadow-sm">
          </div>
          <input type="file" name="gambar" class="form-control mb-3">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus Barang -->
<div class="modal fade" id="hapusModalBarang" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formHapusBarang" action="<?= base_url('admin/barang/hapus') ?>" method="post">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Pilih barang yang ingin dihapus:</p>
          <div class="list-group overflow-auto" id="hapusBarangList" style="max-height: 300px;">
            <?php foreach ($data_barang as $b): ?>
              <label class="list-group-item d-flex align-items-start gap-3">
                <input class="form-check-input mt-1" type="radio" name="id" value="<?= $b['id'] ?>" required>
                <div class="d-flex flex-column justify-content-center align-items-start">
                  <p class="fw-bold mb-1 small"><?= esc($b['nama']) ?></p>
                  <p class="mb-0 small text-muted">Rp<?= number_format((float) $b['harga'], 0, ',', '.') ?></p>
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
function fillEditBarang(select) {
  const option = select.options[select.selectedIndex];
  document.getElementById('editBarangNama').value = option.getAttribute('data-nama') || '';
  document.getElementById('editBarangHarga').value = option.getAttribute('data-harga') || '';
  document.getElementById('editBarangStok').value = option.getAttribute('data-stok') || '';
  document.getElementById('editBarangDeskripsi').value = option.getAttribute('data-deskripsi') || '';

  const gambar = option.getAttribute('data-gambar');
  const preview = document.getElementById('editBarangPreview');
  if (gambar) {
    preview.src = gambar;
    preview.style.display = 'block';
  } else {
    preview.style.display = 'none';
  }
}
</script>

<script>
  // ==== AJAX CRUD Barang (no reload) ====

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function escapeJsString(str) {
    return String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'");
  }

  function getCookieValue(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? decodeURIComponent(match[2]) : null;
  }

  function syncCsrfToken() {
    var token = getCookieValue('csrf_cookie_name');
    if (!token) return;
    document.querySelectorAll('input[name="csrf_test_name"]').forEach(function (input) {
      input.value = token;
    });
  }

  function showAjaxToast(message, isError) {
    var toast = document.createElement('div');
    toast.className = 'ajax-toast' + (isError ? ' ajax-toast-error' : '');
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(function () {
      toast.classList.add('ajax-toast-hide');
      setTimeout(function () { toast.remove(); }, 300);
    }, 2500);
  }

  function ajaxSubmitForm(form, onSuccess) {
    var formData = new FormData(form);
    fetch(form.action, { method: 'POST', body: formData })
      .then(function (res) { return res.json(); })
      .then(function (json) {
        syncCsrfToken();
        if (json.success) {
          onSuccess(json.data);
          showAjaxToast(json.message, false);
        } else {
          showAjaxToast(json.message || 'Terjadi kesalahan.', true);
        }
      })
      .catch(function () {
        showAjaxToast('Gagal menghubungi server.', true);
      });
  }

  function buildBarangCardHTML(b) {
    var stokHabis = parseInt(b.stok, 10) <= 0;
    var qtyId = 'qtyBarang' + b.id;

    var imgHtml = b.gambar_url
      ? '<img src="' + b.gambar_url + '" class="barang-img" alt="' + escapeHtml(b.nama) + '">'
      : '<div class="barang-img barang-img-placeholder"><i class="bi bi-image"></i></div>';

    var deskripsiHtml = b.deskripsi
      ? '<p class="barang-deskripsi">' + escapeHtml(b.deskripsi) + '</p>'
      : '';

    var actionHtml;
    if (!stokHabis) {
      actionHtml =
        '<div class="qty-stepper mb-2">' +
          '<button type="button" class="btn-qty" onclick="stepProductQty(\'' + qtyId + '\', -1, ' + parseInt(b.stok, 10) + ')">-</button>' +
          '<input type="number" id="' + qtyId + '" class="qty-input" value="1" min="1" max="' + parseInt(b.stok, 10) + '">' +
          '<button type="button" class="btn-qty" onclick="stepProductQty(\'' + qtyId + '\', 1, ' + parseInt(b.stok, 10) + ')">+</button>' +
        '</div>' +
        '<button type="button" class="btn-add-cart" onclick="addToCart(' + b.id + ', \'' + escapeJsString(b.nama) + '\', ' + parseFloat(b.harga) + ', \'' + (b.gambar_url || '') + '\', \'' + qtyId + '\')">' +
          '<i class="bi bi-cart-plus"></i> Tambah ke Keranjang' +
        '</button>';
    } else {
      actionHtml = '<button type="button" class="btn-add-cart" disabled>Stok Habis</button>';
    }

    return (
        '<div class="barang-card col-lg-3 col-md-5 col-sm-10" data-id="' + b.id + '" data-nama="' + escapeHtml(String(b.nama).toLowerCase()) + '" data-harga="' + parseFloat(b.harga) + '" data-stok="' + (stokHabis ? 'habis' : 'tersedia') + '">' +
        imgHtml +
        '<h5 class="barang-nama">' + escapeHtml(b.nama) + '</h5>' +
        '<p class="barang-harga">Rp' + Number(b.harga).toLocaleString('id-ID') + '</p>' +
        '<p class="barang-stok' + (stokHabis ? ' text-danger' : '') + '">' + (stokHabis ? 'Stok habis' : 'Stok: ' + parseInt(b.stok, 10)) + '</p>' +
        deskripsiHtml +
        actionHtml +
      '</div>'
    );
  }

  function buildEditOptionHTML(b) {
    return '<option value="' + b.id + '"' +
      ' data-nama="' + escapeHtml(b.nama) + '"' +
      ' data-harga="' + b.harga + '"' +
      ' data-stok="' + b.stok + '"' +
      ' data-deskripsi="' + escapeHtml(b.deskripsi || '') + '"' +
      ' data-gambar="' + (b.gambar_url || '') + '">' +
      escapeHtml(b.nama) +
      '</option>';
  }

  function buildHapusItemHTML(b) {
    return '<label class="list-group-item d-flex align-items-start gap-3">' +
      '<input class="form-check-input mt-1" type="radio" name="id" value="' + b.id + '" required>' +
      '<div class="d-flex flex-column justify-content-center align-items-start">' +
        '<p class="fw-bold mb-1 small">' + escapeHtml(b.nama) + '</p>' +
        '<p class="mb-0 small text-muted">Rp' + Number(b.harga).toLocaleString('id-ID') + '</p>' +
      '</div>' +
    '</label>';
  }

  var formTambahBarang = document.getElementById('formTambahBarang');
  if (formTambahBarang) {
    formTambahBarang.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitForm(formTambahBarang, function (data) {
        var emptyMsg = document.getElementById('barangEmptyMsg');
        if (emptyMsg) emptyMsg.remove();

        document.getElementById('barangGrid').insertAdjacentHTML('beforeend', buildBarangCardHTML(data));
        document.getElementById('editBarangSelect').insertAdjacentHTML('beforeend', buildEditOptionHTML(data));
        document.getElementById('hapusBarangList').insertAdjacentHTML('beforeend', buildHapusItemHTML(data));

        var modal = bootstrap.Modal.getInstance(document.getElementById('addModalBarang'));
        if (modal) modal.hide();
        formTambahBarang.reset();
      });
    });
  }

  var formEditBarang = document.getElementById('formEditBarang');
  if (formEditBarang) {
    formEditBarang.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitForm(formEditBarang, function (data) {
        var oldCard = document.querySelector('.barang-card[data-id="' + data.id + '"]');
        if (oldCard) oldCard.outerHTML = buildBarangCardHTML(data);

        var oldOption = document.querySelector('#editBarangSelect option[value="' + data.id + '"]');
        if (oldOption) oldOption.outerHTML = buildEditOptionHTML(data);

        var oldRadio = document.querySelector('#hapusBarangList input[value="' + data.id + '"]');
        if (oldRadio) oldRadio.closest('label').outerHTML = buildHapusItemHTML(data);

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditBarang'));
        if (modal) modal.hide();
        formEditBarang.reset();
        document.getElementById('editBarangPreview').style.display = 'none';
      });
    });
  }

  var formHapusBarang = document.getElementById('formHapusBarang');
  if (formHapusBarang) {
    formHapusBarang.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitForm(formHapusBarang, function (data) {
        var card = document.querySelector('.barang-card[data-id="' + data.id + '"]');
        if (card) card.remove();

        var option = document.querySelector('#editBarangSelect option[value="' + data.id + '"]');
        if (option) option.remove();

        var radio = document.querySelector('#hapusBarangList input[value="' + data.id + '"]');
        if (radio) radio.closest('label').remove();

        var modal = bootstrap.Modal.getInstance(document.getElementById('hapusModalBarang'));
        if (modal) modal.hide();
        formHapusBarang.reset();
      });
    });
  }
</script>
<?php endif; ?>

<script>
  var CART_KEY = 'bengkelarsip_cart';
  var WA_NUMBER = '<?= $social['wa_number'] ?>';

  function stepProductQty(inputId, delta, maxStok) {
    var input = document.getElementById(inputId);
    var val = parseInt(input.value) || 1;
    val += delta;
    if (val < 1) val = 1;
    if (maxStok && val > maxStok) val = maxStok;
    input.value = val;
  }

  function formatRupiah(angka) {
    return 'Rp' + Number(angka || 0).toLocaleString('id-ID');
  }

  function getCart() {
    try {
      return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    } catch (e) {
      return [];
    }
  }

  function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    renderCartBadge();
  }

  function renderCartBadge() {
    var cart = getCart();
    var totalQty = cart.reduce(function (sum, i) { return sum + i.qty; }, 0);
    var badge = document.getElementById('cartBadge');
    if (!badge) return;
    if (totalQty > 0) {
      badge.style.display = 'flex';
      badge.textContent = totalQty;
    } else {
      badge.style.display = 'none';
    }
  }

  function addToCart(id, nama, harga, gambar, qtyInputId) {
    var qtyInput = document.getElementById(qtyInputId);
    var qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;

    var cart = getCart();
    var existing = cart.find(function (item) { return item.id === id; });
    if (existing) {
      existing.qty += qty;
    } else {
      cart.push({ id: id, nama: nama, harga: harga, gambar: gambar, qty: qty });
    }
    saveCart(cart);
    alert(nama + ' ditambahkan ke keranjang.');
  }

  function renderCartModal() {
    var cart = getCart();
    var container = document.getElementById('cartItemsContainer');
    container.innerHTML = '';

    if (cart.length === 0) {
      container.innerHTML = '<p class="text-center text-muted py-3">Keranjang masih kosong.</p>';
    } else {
      cart.forEach(function (item) {
        var row = document.createElement('div');
        row.className = 'cart-item d-flex align-items-center gap-3 mb-3';

        var imgHtml = item.gambar
          ? '<img src="' + item.gambar + '" alt="" class="cart-item-img">'
          : '<div class="cart-item-img cart-item-img-placeholder"><i class="bi bi-image"></i></div>';

        row.innerHTML =
          imgHtml +
          '<div class="flex-grow-1">' +
            '<p class="fw-bold mb-1">' + item.nama + '</p>' +
            '<p class="mb-1 text-muted small">' + formatRupiah(item.harga) + '</p>' +
            '<div class="d-flex align-items-center gap-2">' +
              '<button type="button" class="btn-qty" onclick="changeQty(' + item.id + ', -1)">-</button>' +
              '<span>' + item.qty + '</span>' +
              '<button type="button" class="btn-qty" onclick="changeQty(' + item.id + ', 1)">+</button>' +
            '</div>' +
          '</div>' +
          '<button type="button" class="btn-remove" onclick="removeFromCart(' + item.id + ')" aria-label="Hapus"><i class="bi bi-trash"></i></button>';

        container.appendChild(row);
      });
    }

    var total = cart.reduce(function (sum, i) { return sum + (i.harga * i.qty); }, 0);
    document.getElementById('cartTotal').textContent = formatRupiah(total);
  }

  function changeQty(id, delta) {
    var cart = getCart();
    var item = cart.find(function (i) { return i.id === id; });
    if (!item) return;

    item.qty += delta;
    if (item.qty <= 0) {
      cart = cart.filter(function (i) { return i.id !== id; });
    }
    saveCart(cart);
    renderCartModal();
  }

  function removeFromCart(id) {
    var cart = getCart().filter(function (i) { return i.id !== id; });
    saveCart(cart);
    renderCartModal();
  }

  function openCartModal() {
    renderCartModal();
    var modal = new bootstrap.Modal(document.getElementById('cartModal'));
    modal.show();
  }

  function renderCheckoutSummary() {
    var cart = getCart();
    var summary = document.getElementById('checkoutSummary');
    var lines = cart.map(function (i) {
      return '- ' + i.nama + ' x' + i.qty + ' = ' + formatRupiah(i.harga * i.qty);
    });
    summary.innerHTML = lines.join('<br>');

    var total = cart.reduce(function (sum, i) { return sum + (i.harga * i.qty); }, 0);
    document.getElementById('checkoutTotalPreview').textContent = formatRupiah(total);
  }

  function goToCheckout() {
    var cart = getCart();
    if (cart.length === 0) {
      alert('Keranjang masih kosong.');
      return;
    }

    var cartModalEl = document.getElementById('cartModal');
    var cartModal = bootstrap.Modal.getInstance(cartModalEl);
    if (cartModal) cartModal.hide();

    renderCheckoutSummary();
    var checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    checkoutModal.show();
  }

  function submitCheckout(event) {
    event.preventDefault();

    var cart = getCart();
    if (cart.length === 0) {
      alert('Keranjang masih kosong.');
      return;
    }

    var nama = document.getElementById('checkoutNama').value.trim();
    var noHp = document.getElementById('checkoutNoHp').value.trim();
    var alamat = document.getElementById('checkoutAlamat').value.trim();
    var catatan = document.getElementById('checkoutCatatan').value.trim();

    if (!nama || !noHp || !alamat) {
      alert('Mohon lengkapi nama, no HP, dan alamat.');
      return;
    }

    var itemLines = cart.map(function (i) {
      return '- ' + i.nama + ' x' + i.qty + ' = ' + formatRupiah(i.harga * i.qty);
    }).join('\n');

    var total = cart.reduce(function (sum, i) { return sum + (i.harga * i.qty); }, 0);

    var message = 'Halo, saya ingin order barang:\n\n' +
      itemLines +
      '\n\nTotal: ' + formatRupiah(total) +
      '\n\nData Pemesan:\nNama: ' + nama +
      '\nNo HP: ' + noHp +
      '\nAlamat: ' + alamat +
      (catatan ? ('\nCatatan: ' + catatan) : '');

    var url = 'https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(message);

    localStorage.removeItem(CART_KEY);
    renderCartBadge();

    window.open(url, '_blank');

    var checkoutModalEl = document.getElementById('checkoutModal');
    var checkoutModal = bootstrap.Modal.getInstance(checkoutModalEl);
    if (checkoutModal) checkoutModal.hide();
  }

  document.addEventListener('DOMContentLoaded', renderCartBadge);
</script>