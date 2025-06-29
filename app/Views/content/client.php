<section id="client" class="mb-5 pt-3">
  <div class="container-fluid pt-5 mt-5 w-100 d-flex justify-content-center align-items-center text-center flex-column">
    <h1 class="text-center fw-bold color-hijau pb-4 text-uppercase">Client</h1>
    <div class="row gy-5 w-100">

      <?php $carouselId = 1; ?>
      <?php foreach ($groupedClient as $judul => $items): ?>
        <div class="col-lg-6 col-md-10 col-sm-12">
          <div id="minicarousel<?= $carouselId ?>" class="carousel carousel-dark carousel-client slide client-bg rounded-3 clientbg" data-bs-ride="carousel">
            <div class="carousel-inner text-center">
              <?php foreach ($items as $index => $item): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> p-4">
                    <!-- ✅ Judul -->
                    <p class="mb-1 fw-bold"><?= esc($item['judul']) ?></p>
                  <!-- ✅ Gambar -->
                  <?php if (!empty($item['gambar'])): ?>
                    <img class="img-cl" src="<?= base_url('img/' . $item['gambar']) ?>" class="d-block w-100" alt="<?= esc($item['judul']) ?>">
                  <?php endif; ?>
                  <!-- ✅ Deskripsi -->
                  <p class="mb-0"><?= esc($item['deskripsi']) ?></p>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Navigasi Carousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#minicarousel<?= $carouselId ?>" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#minicarousel<?= $carouselId ?>" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>

            <!-- Tombol Admin -->
            <?php if (session()->get('isLoggedIn')): ?>
              <div class="row ubahbg w-100 top-50 gap-3 pb-5">
                <button type="button" class="btngallery col-3 mb-4"><a href="">Hapus</a></button>
                <button type="button" class="btngallery col-3 mb-4"><a href="">Tambah</a></button>
                <button type="button" class="btngallery col-3 mb-4"><a href="">Edit</a></button>
              </div>
              <style>
                #miniCarousel, #minicarousel1, #minicarousel2, #minicarousel3, #minicarousel4, #minicarousel5{ 
                    height: 450px !important;
                    width: calc((100%/4)-20px);
                    box-shadow: 7px 7px 24px rgba(0, 0, 0, 0.6);
                    border: 3px solid var(--warna-utama);
                    border-radius: 20px!important;
                }
              </style>
            <?php endif; ?>
          </div>
        </div>
        <?php $carouselId++; ?>
      <?php endforeach; ?>

    </div>
  </div>
</section>
