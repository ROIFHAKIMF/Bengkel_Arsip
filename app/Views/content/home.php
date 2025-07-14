    <!-- home start -->
    <section id="Home" class="pt-5">
        <div class="home" >
            <div class="home-img">
                <div class="text-center bg-hijau foto-awal ">
                    <img src="<?= base_url('img/home.png') ?>" class="rounded-3" alt="...">
                </div>
            </div>
            <div class="home-text">
                <h1 class="color-hijau fw-bolder display-3">BENGKEL ARSIP</h1>
                <p class="color-hijau fw-bold fs-5">KANTOR PUSAT SEMARANG   |   SINCE 2016</p>
                <h3 class="color-kuning fw-bold fs-3 text-start">solusi kearsipan<br>
                profesional dan terpercaya</h3>
                <p class="color-hijau fw-bold fs-5 pt-4">KONSULTASI SAJA DULU DENGAN KAMI</p>
                <button class="button shadow-lg" data-bs-toggle="modal" data-bs-target="#whatsappModal">
                    <span></span><span></span><span></span><span></span>
                    <i class="bi bi-telephone-fill"></i>
                    HUBUNGI KAMI
                </button>
            </div>
            <a href="#about" class="s-down text-center shadow-lg"><i class="bi bi-arrow-down"></i></a>
        </div>
    </section>
    
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
    <?php endif; ?>


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

