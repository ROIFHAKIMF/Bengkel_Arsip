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
      <form action="<?= site_url('admin/service/store') ?>" method="post" enctype="multipart/form-data">
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
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Service yang Ingin Dihapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-wrap justify-content-center gap-2">
          <?php foreach ($data_services as $service): ?>
            <div class="card text-center d-flex flex-column align-items-center"
                 style="width: 120px; height: 180px; border: 1px solid var(--warna-utama); border-radius: 8px; padding: 0.4rem; overflow: hidden;">
              
              <!-- Gambar -->
              <img src="<?= base_url('img/' . $service['title']) ?>" 
                   style="width: 100%; height: 60px; object-fit: cover; border-radius: 6px;" 
                   alt="Service">

              <!-- Deskripsi Singkat -->
              <div class="mt-1" 
                   style="font-size: 0.65rem; text-align: center; max-height: 3em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                <?= esc($service['content']) ?>
              </div>

              <!-- Tombol Hapus -->
              <a href="<?= site_url('service/delete/' . $service['id']) ?>" 
                 class="btn btn-sm btn-danger w-100 mt-auto py-0"
                 style="font-size: 0.6rem;" 
                 onclick="return confirm('Yakin ingin menghapus ini?')">
                Hapus
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>