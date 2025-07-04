<section id="service" class="py-2">
  <div class="container-fluid py-2 pt-5 mt-5 d-flex flex-column align-items-center">
    <h1 class="fw-bold color-hijau pb-3 text-center">SERVICES BENGKEL ARSIP</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3 mb-4 justify-content-center">
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#hapusModal">Hapus</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalEditService">Edit</button>
      </div>
    <?php endif; ?>

    <div class="row gap-5 justify-content-center">
      <?php foreach ($data_services as $service): ?>
        <div class="card-sr col-lg-4 col-md-6 col-sm-12">
          <div class="bg">
            <img src="<?= base_url('img/' . $service['title']) ?>" class="card-img-top" alt="...">
            <h4 class="card-title fw-bolder text-center"><?= $service['content'] ?></h4>
            <div class="button-container">
              <button class="learn-more">
                <span class="circle" aria-hidden="true">
                <span class="icon arrow"></span>
                </span>
                <span class="button-text">Learn More</span>
              </button>
            </div>
          </div>
          <div class="blob"></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= site_url('admin/service/tambah') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="title">Gambar</label>
            <input type="file" name="title" class="form-control" id="title" required>
          </div>
          <div class="form-group mb-3">
            <label for="content">Konten</label>
            <input type="text" name="content" class="form-control" id="content" placeholder="Isi konten layanan" required>
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

<!-- Modal Edit -->
<div class="modal fade" id="modalEditService" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('admin/service/edit') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" class="form-select mb-3" onchange="fillEditService(this)" required>
            <option value="">Pilih Service</option>
            <?php foreach ($data_services as $service): ?>
              <option
                value="<?= $service['id'] ?>"
                data-content="<?= htmlspecialchars($service['content'], ENT_QUOTES) ?>"
                data-title="<?= base_url('img/' . $service['title']) ?>"
              >
                <?= esc($service['content']) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <input type="text" name="content" id="editServiceContent" class="form-control mb-3" placeholder="Konten" required>

          <!-- Gambar Preview -->
          <div class="text-center mb-3">
            <img id="editServicePreview" src="#" alt="Preview Gambar" style="max-width: 100px; display: none;" class="rounded shadow-sm">
          </div>

          <input type="file" name="title" class="form-control mb-3">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('admin/service/hapus') ?>" method="post">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Pilih service yang ingin dihapus:</p>
          <div class="list-group overflow-auto" style="max-height: 300px;">
            <?php foreach ($data_services as $service): ?>
              <label class="list-group-item d-flex align-items-start gap-3">
                <input class="form-check-input mt-1" type="radio" name="id" value="<?= $service['id'] ?>" required>
                <div class="d-flex flex-column justify-content-center align-items-start">
                  <div class="d-flex flex-row align-items-start justify-content-start w-100 gap-2">
                    <p class="fw-bold mb-1 small"><?= esc($service['content']) ?></p>
                    <img src="<?= base_url('img/' . $service['title']) ?>" alt="Service" width="60" height="40" class="rounded shadow-sm mb-1">
                  </div>
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

<!-- Script untuk isi otomatis modal edit -->
<script>
function fillEditService(select) {
  const option = select.options[select.selectedIndex];
  const content = option.getAttribute('data-content');
  const title = option.getAttribute('data-title');

  document.getElementById('editServiceContent').value = content;

  const imgPreview = document.getElementById('editServicePreview');
  if (title) {
    imgPreview.src = title;
    imgPreview.style.display = 'block';
  } else {
    imgPreview.style.display = 'none';
  }
}
</script>