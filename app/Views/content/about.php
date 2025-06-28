<section id="about" class="py-2">
        <div class="container-fluid d-flex justify-content-center align-items-center text-center flex-column mt-5 pt-5">
            <h1 class="fw-bold color-hijau pb-2">ABOUT BENGKEL ARSIP</h1>
            <?php
            if (session()->get('isLoggedIn')) {
            ?>
            <div class="row w-50 gap-3">

                <button type="button" class="btngallery col-3 mb-4"><a  href="">Hapus</a></button>
                <button type="button" class="btngallery col-3 mb-4"><a  href="">Tambah</a></button>
                <button type="button" class="btngallery col-3 mb-4"><a  href="">Edit</a></button>
            </div>
             <?php 
            }
            ?>
            <div class="row gap-5">
            <?php foreach ($data_about as $item): ?>
                <div class="card col-lg-3 col-md-4 col-sm-12">
                    <h5 class="text-start w-100 px-4"><?= $item['title']; ?></h5>
                    <p class="text-start w-100 px-4" ><?= $item['content']; ?></p>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </section>