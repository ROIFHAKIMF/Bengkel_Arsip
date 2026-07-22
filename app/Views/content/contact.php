<section id="contact" class="py-2 vh-100">
    <div class="container-fluid pt-5 mt-5">
        <h1 class="fw-bold text-center color-hijau text-uppercase">Location &amp; Contact</h1>
        <div class="container d-flex location justify-content-around p-5 align-items-center text-center text-lg-start flex-column flex-lg-row rounded-5 gap-4">

            <!-- Map -->
            <div class="location-map w-100">
                <iframe
                    src="https://www.google.com/maps?q=Jl.+KS.+Tubun+3/18a+Susukan+Ungaran,+Kabupaten+Semarang&output=embed"
                    width="100%" height="350" style="border:0; border-radius: 20px;"
                    allowfullscreen loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Kantor Pusat Bengkel Arsip">
                </iframe>
            </div>

            <!-- Alamat & Social Media -->
            <div class="location-info w-100 d-flex flex-column align-items-center justify-content-center gap-3">
                <h5 class="fw-bold contact-text mb-1">Kantor Pusat Bengkel Arsip</h5>
                <p class="contact-text mb-4">Jl. KS. Tubun 3/18a, Susukan, Ungaran</p>

                <h5 class="fw-bold contact-text">SOCIAL MEDIA</h5>
                <ul class="example-2 ms-0 d-flex gap-3 list-unstyled mt-3">
                    <li class="icon-content">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#whatsappModal" aria-label="whatsapp" data-social="whatsapp">
                            <div class="filled"></div>
                            <i class="bi bi-whatsapp fs-3"></i>
                        </a>
                        <div class="tooltip">Whatsapp</div>
                    </li>
                    <li class="icon-content">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#instagramModal" aria-label="Instagram" data-social="Instagram">
                        <?php else: ?>
                            <a href="https://www.instagram.com/bengkel.arsip/" target="_blank" aria-label="Instagram" data-social="Instagram">
                        <?php endif; ?>
                            <div class="filled"></div>
                            <i class="bi bi-instagram fs-3"></i>
                        </a>
                        <div class="tooltip">Instagram</div>
                    </li>
                    <li class="icon-content">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#facebookModal" aria-label="Facebook" data-social="Facebook">
                        <?php else: ?>
                            <a href="https://www.facebook.com/bengkel.arsip/" target="_blank" aria-label="Facebook" data-social="Facebook">
                        <?php endif; ?>
                            <div class="filled"></div>
                            <i class="bi bi-facebook fs-3"></i>
                        </a>
                        <div class="tooltip">Facebook</div>
                    </li>
                    <li class="icon-content">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#youtubeModal" data-social="Youtube" aria-label="Youtube">
                        <?php else: ?>
                            <a href="https://www.youtube.com/@bengkelarsip3676" target="_blank" aria-label="Youtube" data-social="Youtube">
                        <?php endif; ?>
                            <div class="filled"></div>
                            <i class="bi bi-youtube fs-3"></i>
                        </a>
                        <div class="tooltip">YouTube</div>
                    </li>
                    <li class="icon-content">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#emailModal" data-social="Email" aria-label="Email">
                            <div class="filled"></div>
                            <i class="bi bi-envelope-at-fill fs-3"></i>
                        </a>
                        <div class="tooltip">Email</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>