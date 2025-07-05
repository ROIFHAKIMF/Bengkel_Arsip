<section id="service">
    <h1>Service 4: PELATIHAN DAN KONSULTASI KEARSIPAN</h1>
    <div class="service-1">
          <a class="btn-exit" href="<?= base_url(relativePath: "#service") ?>"><i class="bi bi-x fw"></i></a>
        <div class="img-group row">
            <img src="<?= base_url('img/sv-4.png') ?>" alt="Pelatihan Dan Konsultasi Kearsipan" class="img-fluid col-12">
            <div class="img-mini col-12">
                <img src="<?= base_url('img/PELATIHAN DAN KONSULTASI KEARSIPAN.png') ?>" alt="Pelatihan Dan Konsultasi Kearsipan" class="img-fluid">
                 <img src="<?= base_url('img/PELATIHAN DAN KONSULTASI KEARSIPAN1.png') ?>" alt="Pelatihan Dan Konsultasi Kearsipan" class="img-fluid">
            </div>
        </div>
        <div class="desc">
                <p class="">Pelatihan dan konsultasi kearsipan adalah layanan yang ditawarkan untuk membantu individu atau organisasi dalam memahami dan mengelola arsip dengan lebih efektif. Layanan ini mencakup berbagai aspek, mulai dari pengenalan dasar tentang kearsipan, teknik pengelolaan arsip, hingga penerapan teknologi digital dalam pengarsipan.</p>
                <p class="">Pelatihan biasanya mencakup sesi teori dan praktik, di mana peserta dapat belajar tentang prinsip-prinsip dasar kearsipan, cara mengklasifikasikan dan menyimpan arsip, serta penggunaan perangkat lunak manajemen arsip. Konsultasi kearsipan memberikan kesempatan bagi organisasi untuk mendapatkan saran dan rekomendasi khusus sesuai dengan kebutuhan mereka, termasuk pengembangan sistem pengarsipan yang efisien dan aman.</p>
                  <div class="d-flex flex-row w-50 justify-center align-items-center gap-2">
               <?php if (session()->get('isLoggedIn')): ?>
                <a class= "btn-services w-50" href="<?= base_url('admin?service=3#service') ?>"><i class="bi bi-arrow-left-short fs-bold"></i>Previous</a>
                <a class="btn-services w-50" href="<?= base_url('admin?service=5#service') ?>">Next<i class="bi bi-arrow-right-short fs-bold" ></i> </a>
                <?php else: ?>
                    <a class= "btn-services w-50" href="<?= base_url('/?service=3#service') ?>"><i class="bi bi-arrow-left-short fs-bold"></i>Previous</a>
                    <a class="btn-services w-50" href="<?= base_url('/?service=5#service') ?>">Next <i class="bi bi-arrow-right-short"></i> </a>
                  <?php endif; ?>
            </div>
        </div>
    </div>
</section>