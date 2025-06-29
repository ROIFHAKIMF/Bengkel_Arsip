<section id="about" class="py-2">
  <div class="container-fluid d-flex justify-content-center align-items-center text-center flex-column mt-5 pt-5">
    <h1 class="fw-bold color-hijau pb-2">ABOUT BENGKEL ARSIP</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3">
       <button type="button" class="btngallery col-3 mb-4" data-bs-toggle="modal" data-bs-target="#modalDelete">Hapus</button>
        <button type="button" class="btngallery col-3 mb-4" data-bs-toggle="modal" data-bs-target="#modalAdd">Tambah</button>
        <button type="button" class="btngallery col-3 mb-4" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button>
      </div>
    <?php endif; ?>

    <div class="row gap-5">
      <?php foreach ($data_about as $item): ?>
        <div class="card col-lg-3 col-md-4 col-sm-12">
          <h5 class="text-start w-100 px-4"><?= $item['title']; ?></h5>
          <p class="text-start w-100 px-4"><?= $item['content']; ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered "> <!-- class kustom -->
    <form action="<?= base_url('admin/about/tambah'); ?>" method="post">
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="title" class="form-control mb-3" placeholder="Judul" required>
          <textarea name="content" class="form-control" placeholder="Konten" rows="5" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn ">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered ">
    <form action="<?= base_url('admin/about/edit'); ?>" method="post">
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" class="form-select mb-3" required>
            <option value="">Pilih Data</option>
            <?php foreach ($data_about as $item): ?>
              <option value="<?= $item['id']; ?>"><?= $item['title']; ?></option>
            <?php endforeach; ?>
          </select>
          <input type="text" name="title" class="form-control mb-3" placeholder="Judul Baru" required>
          <textarea name="content" class="form-control" placeholder="Konten Baru" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('admin/about/hapus'); ?>" method="post">
      <div class="modal-content  modal-half ">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" class="form-select" required>
            <option value="">Pilih Data</option>
            <?php foreach ($data_about as $item): ?>
              <option value="<?= $item['id']; ?>"><?= $item['title']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>
