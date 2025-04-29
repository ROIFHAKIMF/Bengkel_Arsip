<footer class="footer bg-hijau mt-5 py-4 px-5 text-white">
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-5 mb-5 px-5">
        <div class="logo d-flex align-items-center">
            <img src="<?=base_url('img/logo.jpg')?>" alt="logo" width="40" height="40" class="rounded-circle me-3">
            <h3 class="text-uppercase fw-bold">Bengkel Arsip</h3>
        </div>
        <p class="mt-2">solusi kearsipanprofesional dan terpercaya</p>
        <ul class="example-2 ms-0">
            <li class="icon-content">
                <a
                href="https://www.spotify.com/"
                aria-label="Spotify"
                data-social="spotify"
                >
                    <div class="filled"></div>
                    <i class="bi bi-whatsapp fs-3"></i>
                </a>
                <div class="tooltip">Whatsapp</div>
            </li>
            <li class="icon-content">
                <a
                href="https://www.pinterest.com/"
                aria-label="Pinterest"
                data-social="pinterest"
                >
                    <div class="filled"></div>
                    <i class="bi bi-instagram fs-3"></i>
                </a>
                <div class="tooltip">Instagram</div>
            </li>
            <li class="icon-content">
                <a
                href="https://dribbble.com/"
                aria-label="Dribbble"
                data-social="dribbble"
                >
                <div class="filled"></div>
                <i class="bi bi-facebook fs-3"></i>
                </a>
                <div class="tooltip">Facebook</div>
            </li>
            <li class="icon-content">
                <a
                href="https://telegram.org/"
                aria-label="Telegram"
                data-social="telegram"
                >
                <div class="filled"></div>
                <i class="bi bi-youtube fs-3"></i>
                </a>
                <div class="tooltip">Telegram</div>
            </li>
        </ul>
      </div>

      <div class="col-md-4 mb-4 pt-5 row ">
        <h5>Navigasi</h5>
        <ul class="list-unstyled col-6">
          <li><a href="#">Layanan-1</a></li>
          <li><a href="#">Layanan-2</a></li>
          <li><a href="#">Layanan-3</a></li>
          <li><a href="#">Layanan-4</a></li>
          <li><a href="#">Layanan-5</a></li>
        </ul>
        <ul class="list-unstyled col-6">
          <li><a href="#">About</a></li>
          <li><a href="#">Client</a></li>
          <li><a href="#">Gallery</a></li>
          <li><a href="#">Profile</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>

      <div class="col-md-3 mb-3">
        <h5>Kontak</h5>
        <p>Email: bengkelarsip@gmail.com</p>
        <p>Telp/WA: +6285701442698 / +6285701442699</p>
        <p>Instagram: www.instagram.com/bengkel.arsip</p>
      </div>
    </div>

    <div class="text-center mt-1">
      <p class="mb-0">&copy; <span id="year"></span> Bengkel Arsip. All rights reserved.</p>
    </div>
  </div>
</footer>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
<script>
    // Set the current year in the footer
    document.getElementById('year').textContent = new Date().getFullYear();
</script>