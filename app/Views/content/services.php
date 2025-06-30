<section id="service" class="py-2">
  <div class="container-fluid py-2 pt-5 mt-5 d-flex flex-column align-items-center">
    <h1 class="fw-bold color-hijau pb-3 text-center">SERVICES BENGKEL ARSIP</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3 mb-4 justify-content-center">
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#hapusModal">Hapus</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah</button>
        <button type="button" class="btngallery col-3">
          <a href="<?= site_url('service/edit/' . (isset($data_services[0]['id']) ? $data_services[0]['id'] : '')) ?>" style="text-decoration: none; color: inherit;">Edit</a>
        </button>
      </div>
    <?php endif; ?>

    <div class="row gap-5 justify-content-center">
      <?php foreach ($data_services as $service): ?>
        <div class="card-sr col-lg-4 col-md-6 col-sm-12">
          <div class="bg">
            <img src="<?= base_url('img/' . $service['title']) ?>" class="card-img-top" alt="...">
            <h4 class="card-title fw-bolder text-center"><?= $service['content'] ?></h4>
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
      <div class="modal-header">
        <h5 class="modal-title">Tambah Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= site_url('admin/service/tambah') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
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
          <button type="submit" class="btn">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus Service -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('admin/service/hapus') ?>" method="post">
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