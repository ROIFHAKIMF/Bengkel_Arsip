<section id="login">
    <div class="container-fluid bg-login w-100 d-flex justify-content-center align-items-center vh-100 position-relative">
        <a href="/" class="btn btn-warning rounded-5 position-absolute m-3 top-0 end-0 p-2">
            <i class="bi bi-person-circle me-2"></i>Guest
        </a>
        <div class="w-50 form-login p-5 rounded-4 shadow-lg d-flex justify-content-center align-items-center flex-column">
            <form method="post" action="/login" class="form-floating needs-validation w-100">
                <?= csrf_field() ?> <!-- penting kalau CSRF aktif di config -->
                <h1 class="text-white text-center fw-bold">FORM LOGIN ADMIN</h1>
                <h1 class="fw-bold text-center color-hijau mb-3">BENGKEL ARSIP</h1>
                <?php if (session()->getFlashdata('failed')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('failed'); ?>
                    </div>
                <?php endif; ?>

                <!-- Username -->
                <div class="form-floating mb-4">
                    <input type="text" class="form-control" id="floatingInput" name="username" placeholder="masukan username" required>
                    <label for="floatingInput">Username</label>
                </div>
                
                <!-- Password -->
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="masukan Password" required>
                    <label for="floatingPassword">Password</label>
                </div>

                <!-- Tombol Login -->
                <button type="submit" class="button1 mt-4 me-auto" data-text="Awesome">
                    <span class="actual-text fw-bolder">&nbsp;LOGIN&nbsp;</span>
                    <span aria-hidden="true" class="hover-text fw-bolder">&nbsp;LOGIN&nbsp;</span>
                </button>
            </form>
        </div>
    </div>
</section>

<script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
