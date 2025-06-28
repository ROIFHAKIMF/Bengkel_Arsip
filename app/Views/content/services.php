<section id="service" class="py-2">
<div class="container-fluid py-2 pt-5 mt-5 d-flex flex-column align-items-center ">
        <h1 class="fw-bold color-hijau pb-3 text-center ">SERVICES BENGKEL ARSIP</h1>
        <?php
            if (session()->get('isLoggedIn')) {
            ?>
            <div class="row w-50 gap-3 ">
                <button type="button" class="btngallery col-3 mb-4"><a  href="">Hapus</a></button>
                <button type="button" class="btngallery col-3 mb-4"><a  href="">Tambah</a></button>
                <button type="button" class="btngallery col-3 mb-4"><a  href="">Edit</a></button>
            </div>
             <?php 
            }
            ?>
            <div class="row gap-5">
            <?php foreach ($data_services as $service): ?>
                <div class="card-sr col-lg-4 col-md-6 col-sm-12 ">
                    <div class="bg">
                    <img src="<?= base_url('img/' . $service['title']) ?>" class="card-img-top" alt="...">
                    <h4 class="card-title fw-bolder text-center"><?=$service['content']?></h4>
                    </div>
                    <div class="blob"></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>