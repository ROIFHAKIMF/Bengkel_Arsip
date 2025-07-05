<section id="service">
    <h1>Service 5: PENGADAAN SARANA DAN PRASARANA KEARSIPAN</h1>
    <div class="service-1">
          <a class="btn-exit" href="<?= base_url(relativePath: "#service") ?>"><i class="bi bi-x fw"></i></a>
        <div class="img-group">
            <img src="<?= base_url('img/sv-5.png') ?>" alt="Digitalisasi Arsip" class="img-group">
            <div class="img-mini">
                <img src="<?= base_url('img/slide1.jpg') ?>" alt="Digitalisasi Arsip" class="img-fluid">
            </div>
        </div>
        <div class="desc">
            <p class="">Pengadaan sarana dan prasarana kearsipan adalah proses penting dalam memastikan bahwa organisasi memiliki fasilitas dan peralatan yang diperlukan untuk mengelola arsip dengan efektif. Ini mencakup penyediaan ruang penyimpanan yang aman, perangkat lunak manajemen arsip, serta peralatan fisik seperti rak, lemari arsip, dan alat digitalisasi.</p>
            <p class="">Dengan sarana dan prasarana yang memadai, organisasi dapat memastikan bahwa arsip disimpan dengan baik, mudah diakses, dan terlindungi dari kerusakan atau kehilangan. Pengadaan ini juga mencakup pelatihan bagi staf dalam penggunaan peralatan dan sistem manajemen arsip, sehingga mereka dapat mengelola arsip dengan efisien dan efektif.</p>
            <div class="d-flex flex-row w-50 justify-center align-items-center gap-2">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a class="btn-services w-50" href="<?= base_url('admin?service=4#service') ?>"><i class="bi bi-arrow-left-short fs-bold"></i>Previous</a>
                <?php else:?>
                    <a class="btn-services w-50" href="<?= base_url('/?service=4#service') ?>"><i class="bi bi-arrow-left-short fs-bold"></i>Previous</a>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>