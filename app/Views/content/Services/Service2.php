<section id="service">
    <h1>Service 2: RESTORASI ARSIP BERHARGA YANG RUSAK</h1>
    <div class="service-1  ">
         <a class="btn-exit" href="<?= base_url(relativePath: "#service") ?>"><i class="bi bi-x fw"></i></a>
        <div class="img-group row">
            <img src="<?= base_url('img/sv-2.jpg') ?>" alt="Restorasi Arsip Berharga Yang Rusak" class="img-fluid col-12">
            <div class="img-mini col-12 ">
                <img src="<?= base_url('img/slide 7.jpg') ?>" alt="Restorasi Arsip Berharga Yang Rusak" class="img-fluid">
                <img src="<?= base_url('img/restorasi 1.jpg') ?>" alt="Restorasi Arsip Berharga Yang Rusak" class="img-fluid">
            </div>
        </div>
        <div class="desc">
            <p class="">Restorasi arsip adalah proses pemulihan dan perbaikan dokumen atau arsip yang telah mengalami kerusakan fisik atau kehilangan informasi. Proses ini penting untuk memastikan bahwa arsip yang berharga tetap dapat diakses dan digunakan meskipun telah mengalami kerusakan akibat faktor lingkungan, usia, atau penggunaan yang tidak tepat.</p>
            <p class="">Restorasi arsip melibatkan berbagai teknik, seperti pembersihan, perbaikan fisik, dan digitalisasi. Pembersihan dilakukan untuk menghilangkan debu, kotoran, atau zat berbahaya yang dapat merusak dokumen. Perbaikan fisik mencakup penambalan lubang, penguatan tepi, dan perbaikan lipatan atau kerutan pada kertas. Digitalisasi memungkinkan arsip yang telah direstorasi untuk disimpan dalam format digital, sehingga memudahkan akses dan penyimpanan jangka panjang.</p>
           <div class="d-flex flex-row w-50 justify-center align-items-center gap-2">
               <?php if (session()->get('isLoggedIn')): ?>
                <a class= "btn-services w-50" href="<?= base_url('admin?service=1#service') ?>"><i class="bi bi-arrow-left-short fs-bold"></i>Previous</a>
                <a class="btn-services w-50" href="<?= base_url('admin?service=3#service') ?>">Next<i class="bi bi-arrow-right-short fs-bold" ></i> </a>
                <?php else: ?>
                    <a class= "btn-services w-50" href="<?= base_url('/?service=1#service') ?>"><i class="bi bi-arrow-left-short fs-bold"></i>Previous</a>
                    <a class="btn-services w-50" href="<?= base_url('/?service=3#service') ?>">Next <i class="bi bi-arrow-right-short"></i> </a>
                  <?php endif; ?>
            </div>
        </div>
    </div>
</section>