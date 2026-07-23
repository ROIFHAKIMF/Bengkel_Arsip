<footer class="footer">
  <div class="footer-container">
    <div class="row d-flex w-100 justify-content-around align-items-center m-3">
      <!-- Kolom Logo dan Sosial Media -->
      <div class="col-lg-3 col-xl-3 col-sm-12 mb-5 d-flex flex-column justify-content-center align-items-center footer-logo">
        <div class="logo d-flex align-items-center">
          <img src="<?= base_url('img/logo.jpg') ?>" alt="logo" width="40" height="40" class="rounded-circle me-3">
          <h3 class="text-uppercase fw-bold text-white text-nowrap">Bengkel Arsip</h3>
        </div>
        <p class="mt-2 text-white text-start">Solusi kearsipan <br> profesional dan terpercaya</p>
        <div class="text-white text-start mt-2">
          <p class="mb-0 fw-bold footer-links">Jam Operasional</p>
          <p class="mb-0 footer-links">Senin - Jumat: 08.00 - 17.00</p>
          <p class="mb-0 footer-links">Sabtu: 08.00 - 13.00</p>
        </div>
      </div>
      <div class="footer-bottom-row mb-2 p-0 w-auto col-lg-4 col-xl-4 col-sm-12">
        <!-- Kolom Navigasi -->
        <div class="footer-bottom-col ">
          <h5 class="fw-bold footer-links">Navigasi</h5>
          <ul class="footer-nav-grid">
              <li><a href="<?= base_url('/') ?>#Home" class="footer-links">Home</a></li>
              <li><a href="<?= base_url('/') ?>#about" class="footer-links">About</a></li>
              <li><a href="<?= base_url('/') ?>#service" class="footer-links">Service</a></li>
              <li><a href="<?= base_url('/') ?>#partner" class="footer-links">Partner</a></li>
              <li><a href="<?= base_url('/') ?>#testimoni" class="footer-links">Testimoni</a></li>
              <li><a href="<?= base_url('barang') ?>" class="footer-links">Barang</a></li>
              <li><a href="<?= base_url('/') ?>#konsultasi" class="footer-links">Konsultasi</a></li>
              <li><a href="<?= base_url('/') ?>#profile" class="footer-links">Profile</a></li>
              <li><a href="<?= base_url('/') ?>#gallery" class="footer-links">Gallery</a></li>
              <li><a href="<?= base_url('/') ?>#client" class="footer-links">Client</a></li>
              <li><a href="<?= base_url('/') ?>#contact" class="footer-links">Contact</a></li>
          </ul>
        </div>
                <!-- Kolom Services -->
        <div class="footer-bottom-col ">
          <h5 class="fw-bold footer-links">Services</h5>
          <ul class="footer-service-grid">
            <li><a href="#service" class="footer-links">Services</a></li>
            <?php foreach ($data_services as $service): ?>
              <?php if (session()->get('isLoggedIn')): ?>
                <li><a class="footer-links text-nowrap" href="<?= base_url('admin?service=' . $service['id']) ?>#service">Service-<?= $service['id'] ?></a></li>
              <?php else: ?>
                <li><a class="footer-links text-nowrap" href="#service" onclick="showServiceDetail(<?= (int) $service['id'] ?>); return false;">Service-<?= $service['id'] ?></a></li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <div class="footer-kontak-row">
      <h5 class="fw-bold footer-links">&copy;<?= date('Y') ?> Bengkel Arsip. All rights reserved.</h5>
    </div>
  </div>
</footer>

<!-- Script Bootstrap dan JS -->
<script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/index.js') ?>"></script>
<!-- Script Set Tahun -->
<script>
  function sendToWhatsApp(event) {
    event.preventDefault();

    const nama = document.getElementById('namaUser').value.trim();
    const layanan = document.getElementById('serviceSelect').value;

    if (!nama || !layanan) {
      alert("Mohon isi semua field!");
      return;
    }

    const message = `Halo, saya ${nama} ingin menggunakan layanan:\n\n${layanan}`;
    const phone = '<?= $social['wa_number'] ?>'; // ambil dari database

    const url = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);
    window.open(url, '_blank');
  }
</script>

<script>
  document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const subject = encodeURIComponent(document.getElementById('subject').value.trim());
    const message = encodeURIComponent(document.getElementById('message').value.trim());

    if (!subject || !message) {
      alert("Semua field wajib diisi.");
      return;
    }

    const email = "<?= $social['email'] ?>"; // ambil dari database
    const mailtoLink = `mailto:${email}?subject=${subject}&body=${message}`;

    window.location.href = mailtoLink;
  });
</script>


      <!-- Modal WhatsApp -->
      <?php if (session()->get('isLoggedIn')): ?>
        <!-- Versi ADMIN: Edit nomor WA -->
        <div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Nomor WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form id="formSocialWhatsapp" method="post" action="<?= base_url('/update-social-media') ?>">
                <div class="modal-body modal-wa">
                  <input type="hidden" name="id" value="<?= $social['id'] ?>">
                  <label for="wa_number" class="form-label">Nomor WhatsApp Baru</label>
                  <input type="text" name="wa_number" class="form-control" id="wa_number" value="<?= $social['wa_number'] ?>" required>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php else: ?>
        <!-- Modal WhatsApp untuk Guest -->
        <div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
              <!-- HEADER -->
              <div class="modal-header">
                <h5 class="modal-title">Konsultasi via WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <!-- FORM -->
              <form onsubmit="sendToWhatsApp(event)">
                <div class="modal-body modal-wa">
                  <div class="mb-3">
                    <label for="namaUser" class="form-label">Nama Anda</label>
                    <input type="text" class="form-control" id="namaUser" placeholder="Masukkan nama Anda" required>
                  </div>
                  <div class="mb-3">
                    <label for="serviceSelect" class="form-label">Pilih Layanan</label>
                    <select class="form-select" id="serviceSelect" required>
                      <option value="" selected disabled>-- Pilih Layanan --</option>
                      <?php foreach ($data_services as $service): ?>
                        <option value="<?= esc($service['content']) ?>"><?= esc($service['content']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-dark">Kirim ke WhatsApp</button>
                </div>
              </form>
            </div>
          </div>
        </div>
                <!-- Modal Email untuk Guest -->
<div class="modal fade" id="emailModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <!-- HEADER -->
      <div class="modal-header">
        <h5 class="modal-title">Kirim Feedback via Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- FORM -->
      <form id="contactForm">
        <div class="modal-body modal-em">
          <div class="mb-3">
            <label for="subject" class="form-label">Label :</label>
            <input type="text" class="form-control" id="subject" placeholder="Masukkan label/judul" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Pesan :</label>
            <textarea class="form-control" id="message" rows="4" placeholder="Masukkan pesan" required></textarea>
          </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark">Kirim ke Email</button>
        </div>
      </form>
    </div>
  </div>
</div>

      <?php endif; ?>


        <?php if (session()->get('isLoggedIn')): ?>
          <!-- Modal Instagram -->
          <div class="modal fade" id="instagramModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header ">
                  <h5 class="modal-title">Edit Link Instagram</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formSocialInstagram" method="post" action="<?= base_url('/update-social-media') ?>">
                  <div class="modal-body modal-ig">
                    <input type="hidden" name="id" value="<?= $social['id'] ?>">
                    <label for="instagram" class="form-label">Link Instagram Baru</label>
                    <input type="text" name="instagram" class="form-control" id="instagram" value="<?= $social['instagram'] ?>" required>
                  </div>
                  <div class="modal-footer ">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Facebook -->
          <div class="modal fade" id="facebookModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header ">
                  <h5 class="modal-title">Edit Link Facebook</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formSocialFacebook" method="post" action="<?= base_url('/update-social-media') ?>">
                  <div class="modal-body modal-fb">
                    <input type="hidden" name="id" value="<?= $social['id'] ?>">
                    <label for="facebook" class="form-label">Link Facebook Baru</label>
                    <input type="text" name="facebook" class="form-control" id="facebook" value="<?= $social['facebook'] ?>" required>
                  </div>
                  <div class="modal-footer ">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal YouTube -->
          <div class="modal fade" id="youtubeModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header ">
                  <h5 class="modal-title">Edit Link YouTube</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formSocialYoutube" method="post" action="<?= base_url('/update-social-media') ?>">
                  <div class="modal-body modal-yt">
                    <input type="hidden" name="id" value="<?= $social['id'] ?>">
                    <label for="youtube" class="form-label">Link YouTube Baru</label>
                    <input type="text" name="youtube" class="form-control" id="youtube" value="<?= $social['youtube'] ?>" required>
                  </div>
                  <div class="modal-footer ">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Email -->
          <div class="modal fade" id="emailModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header ">
                  <h5 class="modal-title">Edit Email</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formSocialEmail" method="post" action="<?= base_url('/update-social-media') ?>">
                  <div class="modal-body modal-em">
                    <input type="hidden" name="id" value="<?= $social['id'] ?>">
                    <label for="email" class="form-label">Email Baru</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= $social['email'] ?>" required>
                  </div>
                  <div class="modal-footer ">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php endif; ?>
<?php if (session()->get('isLoggedIn')): ?>
<script>
  function ajaxSubmitSocialForm(form) {
    var formData = new FormData(form);
    fetch(form.action, { method: 'POST', body: formData })
      .then(function (res) { return res.json(); })
      .then(function (json) {
        window.syncCsrfToken && window.syncCsrfToken();
        window.showAjaxToast && window.showAjaxToast(json.message, !json.success);

        var modalEl = form.closest('.modal');
        if (json.success && modalEl) {
          var modal = bootstrap.Modal.getInstance(modalEl);
          if (modal) modal.hide();
        }
      })
      .catch(function () {
        window.showAjaxToast && window.showAjaxToast('Gagal menghubungi server.', true);
      });
  }

  ['formSocialWhatsapp', 'formSocialInstagram', 'formSocialFacebook', 'formSocialYoutube', 'formSocialEmail'].forEach(function (formId) {
    var form = document.getElementById(formId);
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        ajaxSubmitSocialForm(form);
      });
    }
  });
</script>
<?php endif; ?>