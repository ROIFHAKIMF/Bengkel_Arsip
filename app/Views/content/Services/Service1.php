<section id="service">
    <h1>Service 1: Digitalisasi Arsip</h1>
    <div class="service-1">
        <a class="btn-exit" href="<?= base_url(relativePath: "#service") ?>"><i class="bi bi-x fw"></i></a>
        <div class="img-group row">
            <img src="<?= base_url('img/sv-1.jpg') ?>" alt="Digitalisasi Arsip" class="img-fluid col-12">
            <div class="img-mini col-12">
                <img src="<?= base_url('img/slide1.jpg') ?>" alt="Digitalisasi Arsip" class="img-fluid">
                <img src="<?= base_url('img/slide2.jpg') ?>" alt="Digitalisasi Arsip" class="img-fluid">
            </div>
        </div>
        <div class="desc">
            <p class="">Digitalisasi arsip adalah proses mengubah dokumen fisik menjadi format digital untuk memudahkan penyimpanan, pencarian, dan akses informasi. Ini membantu dalam melestarikan arsip penting dan mengurangi penggunaan ruang fisik.</p>
            <p class="">Dengan digitalisasi, arsip dapat diakses dengan cepat dan aman, serta mengurangi risiko kerusakan akibat faktor lingkungan seperti kelembaban atau serangan hama. Proses ini juga memungkinkan integrasi dengan sistem manajemen informasi yang lebih luas, sehingga mempermudah pengelolaan arsip dalam organisasi.</p>
            <div class="d-flex flex-row w-50 justify-center align-items-center gap-2">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a class="btn-services w-50" href="<?= base_url('admin?service=2#service') ?>">Next <i class="bi bi-arrow-right-short fs-bold"></i></a>
                <?php else:?>
                    <a class="btn-services w-50" href="<?= base_url('/?service=2#service') ?>">Next <i class="bi bi-arrow-right-short fs-bold"></i></a>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>