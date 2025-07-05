<section id="service">
    <h1>Service 3: PENGOLAHAN DAN PENATAAN ARSIP DAN RUANG ARSIP </h1>
    <div class="service-1">
          <a class="btn-exit" href="<?= base_url(relativePath: "#service") ?>"><i class="bi bi-x fw"></i></a>
        <div class="img-group row">
            <img src="<?= base_url('img/sv-3.jpg') ?>" alt="Pengolahan Dan Penataan Arsip Dan Ruang Arsip" class="img-fluid col-12">
            <div class="img-mini col-12">
                <img src="<?= base_url('img/slide4.jpg') ?>" alt="Pengolahan Dan Penataan Arsip Dan Ruang Arsip" class="img-fluid">
                <img src="<?= base_url('img/slide5.jpg') ?>" alt="Pengolahan Dan Penataan Arsip Dan Ruang Arsip" class="img-fluid">
            </div>
        </div>
        <div class="desc">
            <p class="">Pengolahan dan penataan arsip adalah proses penting dalam manajemen arsip yang bertujuan untuk mengorganisir, mengklasifikasikan, dan menyimpan dokumen atau arsip dengan cara yang sistematis. Proses ini memastikan bahwa arsip dapat diakses dengan mudah dan efisien, serta terlindungi dari kerusakan atau kehilangan.</p>
            <p class="">Pengolahan arsip melibatkan identifikasi, pengelompokan, dan penandaan dokumen berdasarkan kategori atau jenisnya. Ini membantu dalam menciptakan struktur yang jelas untuk arsip, sehingga memudahkan pencarian dan pengambilan informasi di masa mendatang. Penataan arsip mencakup penyimpanan dokumen dalam sistem yang terorganisir, baik secara fisik maupun digital, untuk memastikan keamanan dan integritas informasi.</p>
             <div class="d-flex flex-row w-50 justify-center align-items-center gap-2">
               <?php if (session()->get('isLoggedIn')): ?>
                <a class= "btn-services w-50" href="<?= base_url('admin?service=2#service') ?>"><i class="bi bi-arrow-left-short fs-bold"></i>Previous</a>
                <a class="btn-services w-50" href="<?= base_url('admin?service=4#service') ?>">Next<i class="bi bi-arrow-right-short fs-bold" ></i> </a>
                <?php else: ?>
                    <a class= "btn-services w-50" href="<?= base_url('/?service=2#service') ?>"><i class="bi bi-arrow-left-short fs-bold"></i>Previous</a>
                    <a class="btn-services w-50" href="<?= base_url('/?service=4#service') ?>">Next <i class="bi bi-arrow-right-short"></i> </a>
                  <?php endif; ?>
            </div>
        </div>
    </div>
</section>