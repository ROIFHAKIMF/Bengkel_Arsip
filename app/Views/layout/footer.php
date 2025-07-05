<footer class="footer bg-hijau mt-5 py-4 px-5 text-white">
  <div class="container-fluid w-100 d-flex justify-content-center align-items-center">
    <div class="row d-flex w-100 justify-content-center align-items-center">

      <!-- Kolom Logo dan Sosial Media -->
      <div class="col-lg-6 col-xl-4 col-sm-10 mb-5 px-5 d-flex flex-column justify-content-center align-items-center">
        <div class="logo d-flex align-items-center">
          <img src="<?= base_url('img/logo.jpg') ?>" alt="logo" width="40" height="40" class="rounded-circle me-3">
          <h3 class="text-uppercase fw-bold">Bengkel Arsip</h3>
        </div>
        <p class="mt-2 text-center">Solusi kearsipan <br> profesional dan terpercaya</p>

        <ul class="example-2 ms-0 d-flex gap-3 list-unstyled mt-3">
          <li class="icon-content">
            <a href="#" data-bs-toggle="modal" data-bs-target="#whatsappModal" aria-label="Whatsapp" data-social="Whatsapp">
              <div class="filled"></div>
              <i class="bi bi-whatsapp fs-3"></i>
            </a>
            <div class="tooltip">Whatsapp</div>
          </li>
          <li class="icon-content">
              <?php if (session()->get('isLoggedIn')): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#instagramModal" aria-label="Instagram">
              <?php else: ?>
                <a href="https://www.instagram.com/bengkel.arsip/" target="_blank" aria-label="Instagram">
              <?php endif; ?>
              <div class="filled"></div>
              <i class="bi bi-instagram fs-3"></i>
            </a>
            <div class="tooltip">Instagram</div>
          </li>
          <li class="icon-content">
              <?php if (session()->get('isLoggedIn')): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#facebookModal" aria-label="Facebook">
              <?php else: ?>
                <a href="https://www.facebook.com/bengkel.arsip/" target="_blank" aria-label="Facebook">
              <?php endif; ?>
              <div class="filled"></div>
              <i class="bi bi-facebook fs-3"></i>
            </a>
            <div class="tooltip">Facebook</div>
          </li>
          <li class="icon-content">
              <?php if (session()->get('isLoggedIn')): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#youtubeModal" aria-label="YouTube">
              <?php else: ?>
                <a href="https://www.youtube.com/@bengkelarsip3676" target="_blank" aria-label="YouTube">
              <?php endif; ?>
              <div class="filled"></div>
              <i class="bi bi-youtube fs-3"></i>
            </a>
            <div class="tooltip">YouTube</div>
          </li>
        </ul>

        <!-- Modal WhatsApp -->
                <?php if (session()->get('isLoggedIn')): ?>
                    <div class="modal fade" id="whatsappModal" tabindex="-1" data-bs-backdrop="static">
                      <div class="modal-dialog modal-dialog-centered">
                        <form id="whatsappForm" onsubmit="sendToWhatsApp(event)">
                          <div class="modal-content modal-wa">
                            <div class="modal-header">
                              <h5 class="modal-title">Mengganti nomor baru</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="namaUser" class="form-label">Nomor Tujuan</label>
                                <input type="text" name="namaUser" class="form-control" id="namaUser" placeholder="Masukkan Nomor Tujuan" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Kirim</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php else:?>
                    <div class="modal fade" id="whatsappModal" tabindex="-1" data-bs-backdrop="static">
                      <div class="modal-dialog modal-dialog-centered">
                        <form id="whatsappForm" onsubmit="sendToWhatsApp(event)">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Kirim Pesan WhatsApp</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="namaUser" class="form-label">Nama</label>
                                <input type="text" name="namaUser" class="form-control" id="namaUser" placeholder="Masukkan nama Anda" required>
                              </div>
                              <div class="mb-3">
                                <label for="serviceSelect" class="form-label">Pilih Layanan</label>
                                <select class="form-select" name="serviceSelect" id="serviceSelect" required>
                                  <option value="">Pilih layanan</option>
                                  <?php foreach ($data_services as $service): ?>
                                    <option value="<?= esc($service['content']) ?>">
                                      <?= esc($service['content']) ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Kirim</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php endif;?>

                <?php if (session()->get('isLoggedIn')): ?>
          <!-- Modal Instagram -->
          <div class="modal fade" id="instagramModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Link Instagram</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <label for="instagramLink" class="form-label">Link Instagram Baru</label>
                  <input type="text" id="instagramLink" class="form-control" placeholder="https://www.instagram.com/..." required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="saveInstagram()">Simpan</button>
                </div>
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
                <div class="modal-body">
                  <label for="facebookLink" class="form-label">Link Facebook Baru</label>
                  <input type="text" id="facebookLink" class="form-control" placeholder="https://www.facebook.com/..." required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="saveFacebook()">Simpan</button>
                </div>
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
                <div class="modal-body">
                  <label for="youtubeLink" class="form-label">Link YouTube Baru</label>
                  <input type="text" id="youtubeLink" class="form-control" placeholder="https://www.youtube.com/..." required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="saveYouTube()">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

      <!-- Kolom Navigasi -->
      <div class="col-lg-6 col-xl-4 col-sm-10 mb-4 pt-5 row d-flex flex-row justify-content-center align-items-start">
        <ul class="list-unstyled col-6">
          <li><h5 class="fw-bold">Navigasi</h5></li>
          <li><a href="#Home" class="text-white text-decoration-none">Home</a></li>
          <li><a href="#About" class="text-white text-decoration-none">About</a></li>
          <li><a href="#Service" class="text-white text-decoration-none">Service</a></li>
        </ul>
        <ul class="list-unstyled col-6">
          <li><a href="#Client" class="text-white text-decoration-none">Client</a></li>
          <li><a href="#Gallery" class="text-white text-decoration-none">Gallery</a></li>
          <li><a href="#Profile" class="text-white text-decoration-none">Profile</a></li>
          <li><a href="#Contact" class="text-white text-decoration-none">Contact</a></li>
        </ul>
      </div>

      <!-- Kolom Kontak -->
      <div class="col-lg-6 col-xl-4 col-sm-10 mb-3 d-flex flex-column justify-content-center align-items-center text-center">
        <h5 class="fw-bold">Kontak</h5>
        <p>Email: bengkelarsip@gmail.com</p>
        <p>Telp/WA: +6285701442698 / +6285701442699</p>
        <p>Instagram: www.instagram.com/bengkel.arsip</p>
        <p class="mb-0">&copy; <span id="year"></span> Bengkel Arsip. All rights reserved.</p>
      </div>

    </div>
  </div>
</footer>

<!-- Script Bootstrap dan JS -->
<script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/index.js') ?>"></script>

<!-- Script Set Tahun -->
<script>
  document.getElementById('year').textContent = new Date().getFullYear();
</script>

<!-- Script WhatsApp Manual -->
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
  const phone = '6282242502468'; // Ganti dengan nomor WA tujuan

  const url = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);
  window.open(url, '_blank');
}
</script>