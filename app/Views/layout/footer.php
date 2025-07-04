<footer class="footer bg-hijau mt-5 py-4 px-5 text-white">
  <div class="container-fluid w-100 d-flex justify-content-center align-items-center">
    <div class="row d-flex w-100 justify-content-center align-items-center">
      <div class="col-lg-6 col-xl-4 col-sm-10 mb-5 px-5  d-flex flex-column justify-content-center align-items-center">
        <div class="logo d-flex align-items-center">
            <img src="<?=base_url('img/logo.jpg')?>" alt="logo" width="40" height="40" class="rounded-circle me-3">
            <h3 class="text-uppercase fw-bold">Bengkel Arsip</h3>
        </div>
        <p class="mt-2">solusi kearsipan <br> profesional dan terpercaya</p>
        <ul class="example-2 ms-0">
            <li class="icon-content">
              <a href="#" data-bs-toggle="modal" data-bs-target="#whatsappModal" aria-label="whatsapp" data-social="whatsapp">
                <div class="filled"></div>
                <i class="bi bi-whatsapp fs-3"></i>
              </a>
              <div class="tooltip">Whatsapp</div>
            </li>
            <li class="icon-content">
                <a
                href="https://www.instagram.com/bengkel.arsip/"
                aria-label="Instagram"
                data-social="Instagram"
                >
                    <div class="filled"></div>
                    <i class="bi bi-instagram fs-3"></i>
                </a>
                <div class="tooltip">Instagram</div>
            </li>
            <li class="icon-content">
                <a
                href="https://www.facebook.com/bengkel.arsip/"
                aria-label="Facebook"
                data-social="Facebook"
                >
                <div class="filled"></div>
                <i class="bi bi-facebook fs-3"></i>
                </a>
                <div class="tooltip">Facebook</div>
            </li>
            <li class="icon-content">
                <a
                href="https://www.youtube.com/@bengkelarsip3676"
                aria-label="Email"
                data-social="Email"
                >
                <div class="filled"></div>
                <i class="bi bi-envelope fs-3"></i>
                </a>
                <div class="tooltip">Youtube</div>
            </li>
        </ul>
      </div>


      <div class="col-lg-6 col-xl-4 col-sm-10 mb-4 pt-5 row  d-flex flex-row justify-content-center align-items-center">
        <ul class="list-unstyled col-6">
          <li><h4>Navigasi</h4></li>
          <li><a href="#Home">Home</a></li>
          <li><a href="#About">About</a></li>
          <li><a href="#Service">Service</a></li>
        </ul>
        <ul class="list-unstyled col-6">
          <li><a href="#Client">Client</a></li>
          <li><a href="#Gallery">Gallery</a></li>
          <li><a href="#Profile">Profile</a></li>
          <li><a href="#Contact">Contact</a></li>
        </ul>
      </div>

      <div class="col-lg-6 col-xl-4 col-sm-10  mb-3  d-flex flex-column justify-content-center align-items-center">
        <h5>Kontak</h5>
        <p>Email: bengkelarsip@gmail.com</p>
        <p>Telp/WA: +6285701442698 / +6285701442699</p>
        <p>Instagram: www.instagram.com/bengkel.arsip</p>
              <p class="mb-0">&copy; <span id="year"></span> Bengkel Arsip. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>
    <script src="<?=base_url("assets/index.js")?>"></script>
    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

</body>
</html>
<script>
    // Set the current year in the footer
    document.getElementById('year').textContent = new Date().getFullYear();
</script>
<script>
let selectedImageUrl = '';

function updateSelectedImage() {
  const select = document.getElementById('serviceSelect');
  const option = select.options[select.selectedIndex];
  selectedImageUrl = option.getAttribute('data-img') || '';
}

function sendToWhatsApp(event) {
  event.preventDefault();

  const nama = document.getElementById('namaUser').value;
  const layanan = document.getElementById('serviceSelect').value;

  let pesan = Halo, saya ${nama}. Saya tertarik dengan layanan: ${layanan};
  if (selectedImageUrl) {
    pesan += \nBerikut adalah gambar layanan:\n${selectedImageUrl};
  }

  const nomorTujuan = "6282242502468"; // Ganti dengan nomor WA tujuan
  const url = https://wa.me/${nomorTujuan}?text=${encodeURIComponent(pesan)};

  window.open(url, '_blank');
}
</script>