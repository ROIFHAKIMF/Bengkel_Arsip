<section id="gallery" class="py-5 bg-hijau">
    <div class="container-fluid mt-5 d-flex justify-content-center align-items-center text-center flex-column">
        <h1 class="text-light fw-bold text-center text-uppercase py-2">Gallery</h1>
        <!-- Tombol Galeri -->
        <?php if (session()->get('isLoggedIn')): ?>
        <div class="row w-50 gap-4 mb-5">
            <button type="button" class="btngallery1 col-3" data-bs-toggle="modal" data-bs-target="#modalDeleteGallery">Hapus</button>
            <button type="button" class="btngallery1 col-3" data-bs-toggle="modal" data-bs-target="#modalAddGallery">Tambah</button>
            <button type="button" class="btngallery1 col-3" data-bs-toggle="modal" data-bs-target="#modalEditGallery">Edit</button>
        </div>
        <?php endif; ?>
<!-- hapus -->
        <div class="modal fade" id="modalDeleteGallery" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="<?= base_url('/admin/gallery/hapus') ?>" method="post">
            <div class="modal-content modal-half">
                <div class="modal-header">
                <h5 class="modal-title">Hapus Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <p>Pilih item galeri yang ingin dihapus:</p>
                <div class="list-group overflow-auto" style="max-height: 300px;">
                    <?php foreach ($galeri as $item): ?>
                    <label class="list-group-item d-flex align-items-start gap-3">
                        <input class="form-check-input mt-1" type="radio" name="id" value="<?= $item['id'] ?>" required>
                        <div class="d-flex flex-column">
                        <p class="fw-bold mb-1"><?= esc($item['judul']) ?></p>
                        <img src="<?= base_url('img/' . $item['gambar']) ?>" width="60" class="rounded shadow-sm mb-1">
                        <p class="mb-0 small"><?= esc($item['deskripsi']) ?></p>
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
<!-- tambah -->
<div class="modal fade" id="modalAddGallery" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('/admin/gallery/tambah') ?>" method="post" enctype="multipart/form-data">
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
<!-- edit -->
 <div class="modal fade" id="modalEditGallery" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('/admin/gallery/edit') ?>" method="post" enctype="multipart/form-data">
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Gallery</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" class="form-select mb-3" onchange="fillEditGallery(this)" required>
            <option value="">Pilih Item Galeri</option>
            <?php foreach ($galeri as $item): ?>
              <option 
                value="<?= $item['id'] ?>"
                data-judul="<?= htmlspecialchars($item['judul'], ENT_QUOTES) ?>"
                data-deskripsi="<?= htmlspecialchars($item['deskripsi'], ENT_QUOTES) ?>"
                data-gambar="<?= base_url('img/' . $item['gambar']) ?>"
              >
                <?= $item['judul'] ?>
              </option>
            <?php endforeach; ?>
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
<script>
function fillEditGallery(select) {
  const option = select.options[select.selectedIndex];
  document.getElementById('editGalleryJudul').value = option.getAttribute('data-judul');
  document.getElementById('editGalleryDeskripsi').value = option.getAttribute('data-deskripsi');

  const imgPreview = document.getElementById('editGalleryPreview');
  const imgSrc = option.getAttribute('data-gambar');
  if (imgSrc) {
    imgPreview.src = imgSrc;
    imgPreview.style.display = 'block';
  } else {
    imgPreview.style.display = 'none';
  }
}
</script>

        <div id="carouselExample" class="carousel carousel-dark slide w-75 rounded-3" data-bs-ride="carousel">
           
            <!-- INDICATORS -->
            <div class="carousel-indicators">
                <?php foreach ($galeri as $index => $item): ?>
                    <button type="button"
                            data-bs-target="#carouselExample"
                            data-bs-slide-to="<?= $index ?>"
                            class="<?= $index == 0 ? 'active' : '' ?> bg-light bg-opacity-75"
                            aria-current="<?= $index == 0 ? 'true' : 'false' ?>"
                            aria-label="Slide <?= $index + 1 ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- SLIDES -->
            <div class="carousel-inner">
                <?php foreach ($galeri as $index => $item): ?>
                    <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                        <img src="<?= base_url('img/' . $item['gambar']) ?>" class="d-block w-100" alt="<?= esc($item['judul']) ?>">
                        <div class="carousel-caption d-block d-md-block text-light">
                            <h5><?= esc($item['judul']) ?></h5>
                            <p><?= esc($item['deskripsi']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- CONTROLS -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="bg-light text-dark d-flex justify-content-center align-items-center fs-3 p-4 rounded-pill carousel-control-prev-icon" aria-hidden="true"><i class="bi bi-caret-left-fill color-white"></i></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="bg-light text-dark d-flex justify-content-center align-items-center fs-3 p-4 rounded-pill carousel-control-next-icon" aria-hidden="true"><i class="bi bi-caret-right-fill color-white"></i></span>
            </button>
        </div>
    </div>
</section>
