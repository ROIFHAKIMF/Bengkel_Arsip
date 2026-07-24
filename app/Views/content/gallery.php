<section id="gallery" class="py-5 bg-hijau">
    <div class="container-fluid mt-5 d-flex justify-content-center align-items-center text-center flex-column">
        <h1 class="text-light fw-bold text-center text-uppercase py-2">Gallery</h1>

        <?php if (session()->get('isLoggedIn')): ?>
        <div class="row w-50 gap-4 mb-5">
            <button type="button" class="btngallery1 col-3" data-bs-toggle="modal" data-bs-target="#modalDeleteGallery">Hapus</button>
            <button type="button" class="btngallery1 col-3" data-bs-toggle="modal" data-bs-target="#modalAddGallery">Tambah</button>
            <button type="button" class="btngallery1 col-3" data-bs-toggle="modal" data-bs-target="#modalEditGallery">Edit</button>
        </div>

        <div class="modal fade" id="modalDeleteGallery" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formHapusGallery" action="<?= base_url('/admin/gallery/hapus') ?>" method="post">
            <div class="modal-content modal-half">
                <div class="modal-header">
                <h5 class="modal-title">Hapus Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <p>Pilih item galeri yang ingin dihapus:</p>
                <div class="list-group overflow-auto" id="hapusGalleryList" style="max-height: 300px;"></div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
            </form>
        </div>
        </div>

        <div class="modal fade" id="modalAddGallery" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <form id="formTambahGallery" action="<?= base_url('/admin/gallery/tambah') ?>" method="post" enctype="multipart/form-data">
              <div class="modal-content modal-half">
                <div class="modal-header">
                  <h5 class="modal-title">Tambah Gallery</h5>
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

        <div class="modal fade" id="modalEditGallery" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <form id="formEditGallery" action="<?= base_url('/admin/gallery/edit') ?>" method="post" enctype="multipart/form-data">
              <div class="modal-content modal-half">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Gallery</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <select name="id" id="editGallerySelect" class="form-select mb-3" onchange="fillEditGallery(this)" required>
                    <option value="">Pilih Item Galeri</option>
                  </select>

                  <input type="text" name="judul" id="editGalleryJudul" class="form-control mb-3" placeholder="Judul" required>

                  <div class="text-center mb-3">
                    <img id="editGalleryPreview" src="#" alt="Preview Gambar" style="max-width: 100px; display: none;" class="rounded shadow-sm">
                  </div>

                  <input type="file" name="gambar" class="form-control mb-3">
                  <textarea name="deskripsi" id="editGalleryDeskripsi" class="form-control" placeholder="Deskripsi" required></textarea>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-warning">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <?php endif; ?>

        <div id="galleryCarouselArea" class="w-75"></div>
    </div>
</section>

<script>
  var initialGalleryData = <?= json_encode(array_map(function ($item) {
      return [
          'id'         => (int) $item['id'],
          'judul'      => $item['judul'],
          'deskripsi'  => $item['deskripsi'],
          'gambar_url' => !empty($item['gambar']) ? base_url('img/' . $item['gambar']) : null,
      ];
  }, $galeri ?? [])) ?>;
</script>

<script>
  var galleryData = (initialGalleryData || []).slice();

  function escapeGalleryHtml(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  function renderGalleryCarousel() {
    var area = document.getElementById('galleryCarouselArea');
    if (!area) return;

    if (galleryData.length === 0) {
      area.innerHTML = '<p class="text-light">Belum ada item galeri.</p>';
      return;
    }

    var indicatorsHtml = galleryData.map(function (item, index) {
      return '<button type="button" data-bs-target="#carouselExample" data-bs-slide-to="' + index + '" class="' + (index === 0 ? 'active' : '') + ' bg-light bg-opacity-75" aria-current="' + (index === 0 ? 'true' : 'false') + '" aria-label="Slide ' + (index + 1) + '"></button>';
    }).join('');

    var slidesHtml = galleryData.map(function (item, index) {
      var imgHtml = item.gambar_url ? '<img src="' + item.gambar_url + '" class="d-block w-100" alt="' + escapeGalleryHtml(item.judul) + '">' : '';
      return '<div class="carousel-item ' + (index === 0 ? 'active' : '') + '">' +
        imgHtml +
        '<div class="carousel-caption d-block d-md-block text-light">' +
          '<h5>' + escapeGalleryHtml(item.judul) + '</h5>' +
          '<p>' + escapeGalleryHtml(item.deskripsi) + '</p>' +
        '</div>' +
      '</div>';
    }).join('');

    area.innerHTML =
      '<div id="carouselExample" class="carousel carousel-dark slide rounded-3">' +
        '<div class="carousel-indicators">' + indicatorsHtml + '</div>' +
        '<div class="carousel-inner">' + slidesHtml + '</div>' +
        '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">' +
          '<span class="bg-light text-dark d-flex justify-content-center align-items-center fs-3 p-4 rounded-pill carousel-control-prev-icon" aria-hidden="true"><i class="bi bi-caret-left-fill color-white"></i></span>' +
        '</button>' +
        '<button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">' +
          '<span class="bg-light text-dark d-flex justify-content-center align-items-center fs-3 p-4 rounded-pill carousel-control-next-icon" aria-hidden="true"><i class="bi bi-caret-right-fill color-white"></i></span>' +
        '</button>' +
      '</div>';

  new bootstrap.Carousel(document.getElementById('carouselExample'), {
  ride: 'carousel',
  interval: 3000,
  pause: false
  });
  }

  function renderGalleryAdminLists() {
    var select = document.getElementById('editGallerySelect');
    var hapusList = document.getElementById('hapusGalleryList');
    if (!select || !hapusList) return;

    select.innerHTML = '<option value="">Pilih Item Galeri</option>';
    hapusList.innerHTML = '';

    galleryData.forEach(function (item) {
      select.insertAdjacentHTML('beforeend',
        '<option value="' + item.id + '" data-judul="' + escapeGalleryHtml(item.judul) + '" data-deskripsi="' + escapeGalleryHtml(item.deskripsi) + '" data-gambar="' + (item.gambar_url || '') + '">' +
          escapeGalleryHtml(item.judul) +
        '</option>'
      );

      hapusList.insertAdjacentHTML('beforeend',
        '<label class="list-group-item d-flex align-items-start gap-3">' +
          '<input class="form-check-input mt-1" type="radio" name="id" value="' + item.id + '" required>' +
          '<div class="d-flex flex-column">' +
            '<p class="fw-bold mb-1">' + escapeGalleryHtml(item.judul) + '</p>' +
            '<p class="mb-0 small">' + escapeGalleryHtml(item.deskripsi) + '</p>' +
          '</div>' +
        '</label>'
      );
    });
  }

  function fillEditGallery(select) {
    var option = select.options[select.selectedIndex];
    document.getElementById('editGalleryJudul').value = option.getAttribute('data-judul') || '';
    document.getElementById('editGalleryDeskripsi').value = option.getAttribute('data-deskripsi') || '';

    var gambar = option.getAttribute('data-gambar');
    var preview = document.getElementById('editGalleryPreview');
    if (gambar) {
      preview.src = gambar;
      preview.style.display = 'block';
    } else {
      preview.style.display = 'none';
    }
  }

  renderGalleryCarousel();
  renderGalleryAdminLists();

  function ajaxSubmitGalleryForm(form, onSuccess) {
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

  var formTambahGallery = document.getElementById('formTambahGallery');
  if (formTambahGallery) {
    formTambahGallery.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitGalleryForm(formTambahGallery, function (data) {
        galleryData.push(data);
        renderGalleryCarousel();
        renderGalleryAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalAddGallery'));
        if (modal) modal.hide();
        formTambahGallery.reset();
      });
    });
  }

  var formEditGallery = document.getElementById('formEditGallery');
  if (formEditGallery) {
    formEditGallery.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitGalleryForm(formEditGallery, function (data) {
        var idx = galleryData.findIndex(function (g) { return g.id === data.id; });
        if (idx !== -1) galleryData[idx] = data;

        renderGalleryCarousel();
        renderGalleryAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditGallery'));
        if (modal) modal.hide();
        formEditGallery.reset();
        document.getElementById('editGalleryPreview').style.display = 'none';
      });
    });
  }

  var formHapusGallery = document.getElementById('formHapusGallery');
  if (formHapusGallery) {
    formHapusGallery.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmitGalleryForm(formHapusGallery, function (data) {
        galleryData = galleryData.filter(function (g) { return g.id !== data.id; });

        renderGalleryCarousel();
        renderGalleryAdminLists();

        var modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteGallery'));
        if (modal) modal.hide();
        formHapusGallery.reset();
      });
    });
  }
</script>