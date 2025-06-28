<section id="gallery" class="py-5 bg-hijau">
    <div class="container-fluid mt-5 d-flex justify-content-center align-items-center text-center flex-column">
        <h1 class="text-light fw-bold text-center text-uppercase py-2">Gallery</h1>
        <div id="carouselExample" class="carousel carousel-dark slide w-75 rounded-3" data-bs-ride="carousel">
           
            <!-- INDICATORS -->
            <div class="carousel-indicators">
                <?php foreach ($galeri as $index => $item): ?>
                    <button type="button"
                            data-bs-target="#carouselExample"
                            data-bs-slide-to="<?= $index ?>"
                            class="<?= $index == 0 ? 'active' : '' ?> bg-success bg-opacity-25"
                            aria-current="<?= $index == 0 ? 'true' : 'false' ?>"
                            aria-label="Slide <?= $index + 1 ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- SLIDES -->
            <div class="carousel-inner">
                <?php foreach ($galeri as $index => $item): ?>
                    <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                        <img src="<?= base_url('img/' . $item['gambar']) ?>" class="d-block w-100" alt="<?= esc($item['judul']) ?>">
                        <div class="carousel-caption d-none d-md-block text-light">
                            <h5><?= esc($item['judul']) ?></h5>
                            <p><?= esc($item['deskripsi']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- CONTROLS -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
