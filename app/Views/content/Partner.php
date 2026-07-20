<section id="partner" class="py-5">
  <div class="container-fluid text-center">
    <h1 class="fw-bold text-uppercase mb-4 partner-title">Partner By</h1>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="row w-50 gap-3 mb-4 justify-content-center mx-auto">
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#hapusModalPartner">Hapus</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#addModalPartner">Tambah</button>
        <button type="button" class="btngallery col-3" data-bs-toggle="modal" data-bs-target="#modalEditPartner">Edit</button>
      </div>
    <?php endif; ?>

    <?php if (empty($data_partner)): ?>
      <p class="text-muted">Belum ada partner.</p>
    <?php else: ?>
      <div class="marquee-wrapper">
        <div class="marquee-track" id="partnerTrack">
          <?php
            $warnaCycle = ['partner-c1', 'partner-c2', 'partner-c3', 'partner-c4', 'partner-c5', 'partner-c6'];
          ?>
          <?php for ($ulang = 0; $ulang < 6; $ulang++): ?>
            <?php foreach ($data_partner as $i => $p): ?>
              <?php if (!empty($p['logo'])): ?>
                <div class="partner-item partner-item-logo">
                  <img src="<?= base_url('img/' . $p['logo']) ?>" alt="<?= esc($p['nama']) ?>" class="partner-logo-img">
                </div>
              <?php else: ?>
                <div class="partner-item <?= $warnaCycle[$i % count($warnaCycle)] ?>">
                  <span><?= esc($p['nama']) ?></span>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endfor; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php if (session()->get('isLoggedIn')): ?>
<!-- Modal Tambah Partner -->
<div class="modal fade" id="addModalPartner" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= site_url('admin/partner/tambah') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Partner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="nama">Nama Partner</label>
            <input type="text" name="nama" class="form-control" id="nama" required>
          </div>
          <div class="form-group mb-3">
            <label for="logo">Logo (kosongkan dulu kalau belum ada)</label>
            <input type="file" name="logo" class="form-control" id="logo">
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

<!-- Modal Edit Partner -->
<div class="modal fade" id="modalEditPartner" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('admin/partner/edit') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Edit Partner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select name="id" class="form-select mb-3" onchange="fillEditPartner(this)" required>
            <option value="">Pilih Partner</option>
            <?php foreach ($data_partner as $p): ?>
              <option
                value="<?= $p['id'] ?>"
                data-nama="<?= htmlspecialchars($p['nama'], ENT_QUOTES) ?>"
                data-logo="<?= !empty($p['logo']) ? base_url('img/' . $p['logo']) : '' ?>"
              >
                <?= esc($p['nama']) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <input type="text" name="nama" id="editPartnerNama" class="form-control mb-3" placeholder="Nama Partner" required>

          <div class="text-center mb-3">
            <img id="editPartnerPreview" src="#" alt="Preview Logo" style="max-width: 100px; display: none;" class="rounded shadow-sm">
          </div>
          <input type="file" name="logo" class="form-control mb-3">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus Partner -->
<div class="modal fade" id="hapusModalPartner" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?= base_url('admin/partner/hapus') ?>" method="post">
      <?= csrf_field(); ?>
      <div class="modal-content modal-half">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Partner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Pilih partner yang ingin dihapus:</p>
          <div class="list-group overflow-auto" style="max-height: 300px;">
            <?php foreach ($data_partner as $p): ?>
              <label class="list-group-item d-flex align-items-start gap-3">
                <input class="form-check-input mt-1" type="radio" name="id" value="<?= $p['id'] ?>" required>
                <p class="fw-bold mb-0 small"><?= esc($p['nama']) ?></p>
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
function fillEditPartner(select) {
  const option = select.options[select.selectedIndex];
  document.getElementById('editPartnerNama').value = option.getAttribute('data-nama') || '';

  const logo = option.getAttribute('data-logo');
  const preview = document.getElementById('editPartnerPreview');
  if (logo) {
    preview.src = logo;
    preview.style.display = 'block';
  } else {
    preview.style.display = 'none';
  }
}
</script>
<?php endif; ?>

<script>
  (function () {
    var track = document.getElementById('partnerTrack');
    if (!track) return;

    track.querySelectorAll('.partner-item').forEach(function (item) {
      item.addEventListener('mouseenter', function () {
        track.style.animationPlayState = 'paused';
      });
      item.addEventListener('mouseleave', function () {
        track.style.animationPlayState = 'running';
      });
    });
  })();
</script>