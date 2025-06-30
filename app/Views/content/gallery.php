<section id="gallery" class="py-5 bg-hijau">
    <div class="container-fluid mt-5 d-flex justify-content-center align-items-center text-center flex-column">
        <h1 class="text-light fw-bold text-center text-uppercase py-2">Gallery</h1>
<!-- Tombol Galeri -->
<!-- Tombol Galeri -->
<?php if (session()->get('isLoggedIn')): ?>
  <div class="row w-50 gap-4 mb-5">
    <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalDeleteGallery">Hapus</button>
    <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalAddGallery">Tambah</button>
    <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalEditGallery">Edit</button>
  </div>
<?php endif; ?>


  <!-- Modal Add -->
    <div class="modal fade" id="modalAddClient" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <form action="<?= base_url('admin/client/tambah') ?>" method="post" enctype="multipart/form-data">
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
    <form action="<?= base_url('admin/client/edit') ?>" method="post" enctype="multipart/form-data">
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Client</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" class="form-select mb-3" onchange="fillEditClient(this)" required>
            <option value="">Pilih Client</option>
            <?php foreach ($groupedClient as $judul => $clients): ?>
              <?php foreach ($clients as $item): ?>
                <option 
                  value="<?= $item['id'] ?>"
                  data-judul="<?= htmlspecialchars($item['judul'], ENT_QUOTES) ?>"
                  data-deskripsi="<?= htmlspecialchars($item['deskripsi'], ENT_QUOTES) ?>"
                  data-gambar="<?= base_url('img/' . $item['gambar']) ?>"
                >
                  <?= $item['judul'] ?>
                </option>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </select>

          <input type="text" name="judul" id="editClientJudul" class="form-control mb-3" placeholder="Judul" required>
          
          <!-- Gambar Preview -->
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

<script>
function fillEditClient(select) {
  const option = select.options[select.selectedIndex];
  const judul = option.getAttribute('data-judul');
  const deskripsi = option.getAttribute('data-deskripsi');
  const gambar = option.getAttribute('data-gambar');

  document.getElementById('editClientJudul').value = judul;
  document.getElementById('editClientDeskripsi').value = deskripsi;

  const imgPreview = document.getElementById('editClientPreview');
  if (gambar) {
    imgPreview.src = gambar;
    imgPreview.style.display = 'block';
  } else {
    imgPreview.style.display = 'none';
  }
}
</script>


<!-- Modal Hapus -->
<div class="modal fade" id="modalDeleteClient" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('admin/client/hapus') ?>" method="post">
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Client</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Pilih client yang ingin dihapus:</p>
          <div class="list-group overflow-auto" style="max-height: 300px;">
            <?php foreach ($groupedClient as $judul => $clients): ?>
              <?php foreach ($clients as $client): ?>
                <label class="list-group-item d-flex align-items-start gap-3">
                  <input class="form-check-input mt-1" type="radio" name="id" value="<?= $client['id'] ?>" required>
                  <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="d-flex flex-row align-items-start justify-content-start w-100">
                      <p class="fw-bold mb-1"><?= esc($client['judul']) ?></p>
                      <img src="<?= base_url('img/' . $client['gambar']) ?>" alt="" width="60" height="40" class="rounded shadow-sm mb-1">
                    </div>
                    <p class="mb-0 small"><?= esc($client['deskripsi']) ?></p>
                  </div>
                </label>
              <?php endforeach; ?>
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
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
