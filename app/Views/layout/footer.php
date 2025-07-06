<footer class="footer">
  <div class="footer-container">
    <div class="row d-flex w-100 justify-content-center align-items-center">
      <!-- Kolom Logo dan Sosial Media -->
      <div class="col-lg-3 col-xl-3 col-sm-10 mb-5 px-5 d-flex flex-column justify-content-center align-items-start">
        <div class="logo d-flex align-items-center">
          <img src="<?= base_url('img/logo.jpg') ?>" alt="logo" width="40" height="40" class="rounded-circle me-3">
          <h3 class="text-uppercase fw-bold ">Bengkel Arsip</h3>
        </div>
        <p class="mt-2 text-white text-start">Solusi kearsipan <br> profesional dan terpercaya</p>
        <p class="mb-0 fs-6 text-secondary">&copy; <span id="year"></span> Bengkel Arsip. All rights reserved.</p>
      </div>
      <div class="col-lg-6 col-xl-6 col-sm-10 d-flex justify-content-center align-items-center flex-column">
        <h5 class="fw-bold footer-links">SOCIAL MEDIA </h5>
        <ul class="example-2 ms-0 d-flex gap-3 list-unstyled mt-3">
          <li class="icon-content">
            <a href="#" data-bs-toggle="modal" data-bs-target="#whatsappModal" aria-label="whatsapp" data-social="whatsapp">
              <div class="filled"></div>
              <i class="bi bi-whatsapp fs-3"></i>
            </a>
            <div class="tooltip">Whatsapp</div>
          </li>
          <li class="icon-content">
              <?php if (session()->get('isLoggedIn')): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#instagramModal" aria-label="Instagram" data-social="Instagram">
              <?php else: ?>
                <a href="https://www.instagram.com/bengkel.arsip/" target="_blank" aria-label="Instagram" data-social="Instagram">
              <?php endif; ?>
              <div class="filled"></div>
              <i class="bi bi-instagram fs-3"></i>
            </a>
            <div class="tooltip">Instagram</div>
          </li>
          <li class="icon-content">
              <?php if (session()->get('isLoggedIn')): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#facebookModal" aria-label="Facebook" data-social="Facebook">
              <?php else: ?>
                <a href="https://www.facebook.com/bengkel.arsip/" target="_blank" aria-label="Facebook" data-social="Facebook">
              <?php endif; ?>
              <div class="filled"></div>
              <i class="bi bi-facebook fs-3"></i>
            </a>
            <div class="tooltip">Facebook</div>
          </li>
          <li class="icon-content">
              <?php if (session()->get('isLoggedIn')): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#youtubeModal" data-social="Youtube" aria-label="Youtube">
              <?php else: ?>
                <a href="https://www.youtube.com/@bengkelarsip3676" target="_blank" aria-label="Youtube" data-social="Youtube">
              <?php endif; ?>
              <div class="filled"></div>
              <i class="bi bi-youtube fs-3"></i>
            </a>
            <div class="tooltip">YouTube</div>
          </li>
          <li class="icon-content">
            <?php if (session()->get('isLoggedIn')): ?>
              <a href="#" data-bs-toggle="modal" data-bs-target="#emailModal" data-social="Email" aria-label="Email">
                <?php else: ?>
                  <a href="bengkelarsip@gmail.com" target="_blank" aria-label="Email" data-social="Email">
              <?php endif; ?>
              <div class="filled"></div>
                  <i class="bi bi-envelope-at-fill fs-3"></i>
            </a>
              <div class="tooltip">Email</div>
          </li>
        </ul>
      </div>
              <!-- Kolom Kontak -->
      <div class="col-lg-3 col-xl-3 col-sm-10 mb-3 d-flex flex-column justify-content-center align-items-start text-start">
        <h4 class="fw-bold footer-links">Kontak</h4>
        <p class="footer-links">Email:<br> bengkelarsip@gmail.com</p>
        <p class="footer-links">Telp/WA: <br>+6285701442698 / +6285701442699</p>
        <p class="footer-links">Instagram: www.instagram.com/bengkel.arsip</p>
      </div>
      <!-- Kolom Navigasi -->
      <div class="col-lg-6 col-xl-6 col-sm-10 mb-4 pt-5">
        <h5 class="fw-bold footer-links">Navigasi</h5>
        <ul class="list-unstyle row row-cols-4 footer-links">
          <li><a href="#Home" class="footer-links">Home</a></li>
          <li><a href="#about" class="footer-links">About</a></li>
          <li><a href="#service" class="footer-links">Service</a></li>
          <li><a href="#client" class="footer-links">Client</a></li>
          <li><a href="#gallery" class="footer-links">Gallery</a></li>
          <li><a href="#profile" class="footer-links">Profile</a></li>
          <li><a href="#contact" class="footer-links">Contact</a></li>
          <li><a href="#footer" class="footer-links">Footer</a></li>
        </ul>
      </div>
      <div class="col-lg-6 col-xl-6 col-sm-10 mb-4 pt-5">
        <h5 class="fw-bold footer-links">Services</h5>
          <ul class="row d-flex justify-content-start align-items-center flex-row footer-links">
            <li class="col-4"><a href="#service" class="footer-links">All Service</a></li>
              <?php foreach ($data_services as $service): ?>
                  <?php if (session()->get('isLoggedIn')): ?>
                    <li class="col-4"><a class="footer-links" href="<?= base_url('admin?service=' . $service['id']) ?>#service">Service-<?= $service['id'] ?></a></li>
                  <?php else: ?>
                    <li class="col-4"><a class="footer-links" href="<?= base_url('/?service=' . $service['id']) ?>#service">Service-<?= $service['id'] ?></a></li>
                  <?php endif; ?>
              <?php endforeach;?>
          </ul>
      </div>
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
              <form method="post" action="<?= base_url('/update-social-media') ?>">
                <div class="modal-body">
                  <input type="hidden" name="id" value="<?= $social['id'] ?>">
                  <label for="wa_number" class="form-label">Nomor WhatsApp Baru</label>
                  <input type="text" name="wa_number" class="form-control" id="wa_number" value="<?= $social['wa_number'] ?>" required>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
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
                <div class="modal-body">
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
                  <button type="submit" class="btn btn-primary">Kirim ke WhatsApp</button>
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
                <div class="modal-header">
                  <h5 class="modal-title">Edit Link Instagram</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="<?= base_url('/update-social-media') ?>">
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $social['id'] ?>">
                    <label for="instagram" class="form-label">Link Instagram Baru</label>
                    <input type="text" name="instagram" class="form-control" id="instagram" value="<?= $social['instagram'] ?>" required>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Facebook -->
          <div class="modal fade" id="facebookModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Link Facebook</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="<?= base_url('/update-social-media') ?>">
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $social['id'] ?>">
                    <label for="facebook" class="form-label">Link Facebook Baru</label>
                    <input type="text" name="facebook" class="form-control" id="facebook" value="<?= $social['facebook'] ?>" required>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal YouTube -->
          <div class="modal fade" id="youtubeModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Link YouTube</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="<?= base_url('/update-social-media') ?>">
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $social['id'] ?>">
                    <label for="youtube" class="form-label">Link YouTube Baru</label>
                    <input type="text" name="youtube" class="form-control" id="youtube" value="<?= $social['youtube'] ?>" required>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Email -->
          <div class="modal fade" id="emailModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Email</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="<?= base_url('/update-social-media') ?>">
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $social['id'] ?>">
                    <label for="email" class="form-label">Email Baru</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= $social['email'] ?>" required>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php endif; ?>