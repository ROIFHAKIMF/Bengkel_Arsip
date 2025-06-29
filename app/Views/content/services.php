<section id="service" class="py-2">
    <div class="container-fluid py-2 pt-5 mt-5 d-flex flex-column align-items-center">
        <h1 class="fw-bold color-hijau pb-3 text-center">SERVICES BENGKEL ARSIP</h1>

        <?php if (session()->get('isLoggedIn')): ?>
            <div class="row w-50 gap-3">
                <button type="button" class="btngallery col-3 mb-4">
                    <a href="<?= site_url('service/delete/' . (isset($data_services[0]['id']) ? $data_services[0]['id'] : '')) ?>" onclick="return confirm('Yakin mau hapus data pertama?')">Hapus</a>
                </button>
                
                <!-- ✅ Tombol Tambah yang tetap pakai class dan buka modal -->
                <button type="button" class="btngallery col-3 mb-4" data-bs-toggle="modal" data-bs-target="#addModal">
                    <a href="#" onclick="return false;">Tambah</a>
                </button>

                <button type="button" class="btngallery col-3 mb-4">
                    <a href="<?= site_url('service/edit/' . (isset($data_services[0]['id']) ? $data_services[0]['id'] : '')) ?>">Edit</a>
                </button>
            </div>
        <?php endif; ?>

        <div class="row gap-5">
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
<div class="modal fade" id="addModal" tabindex="-1">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Service -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg untuk tampilan lebar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Service yang Ingin Dihapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($data_services as $service): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="<?= base_url('img/' . $service['title']) ?>" class="card-img-top" alt="Service">
                                <div class="card-body text-center">
                                    <p class="card-text"><?= esc($service['content']) ?></p>
                                    <a href="<?= site_url('service/delete/' . $service['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus ini?')">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>