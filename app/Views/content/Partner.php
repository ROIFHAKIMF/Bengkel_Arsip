<section id="partner" class="py-5">
  <div class="container-fluid text-center pt-5 mt-5">
    <h1 class="fw-bold text-uppercase mb-4 partner-title">Partner By</h1>

    <div class="marquee-wrapper">
      <div class="marquee-track" id="partnerTrack">
        <?php
          // Placeholder dulu: nama & warna acak. Nanti tinggal ganti div ini jadi <img> logo asli.
          $partners = [
            ['nama' => 'Partner Satu',  'kelas' => 'partner-c1'],
            ['nama' => 'Partner Dua',   'kelas' => 'partner-c2'],
            ['nama' => 'Partner Tiga',  'kelas' => 'partner-c3'],
            ['nama' => 'Partner Empat', 'kelas' => 'partner-c4'],
            ['nama' => 'Partner Lima',  'kelas' => 'partner-c5'],
            ['nama' => 'Partner Enam',  'kelas' => 'partner-c6'],
          ];
        ?>
        <?php for ($ulang = 0; $ulang < 6; $ulang++): ?>
          <?php foreach ($partners as $p): ?>
            <div class="partner-item <?= $p['kelas'] ?>">
              <span><?= esc($p['nama']) ?></span>
            </div>
          <?php endforeach; ?>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    var track = document.getElementById('partnerTrack');
    if (!track) return;

    track.querySelectorAll('.partner-item').forEach(function (item) {
      item.addEventListener('mouseenter', function () {
        track.style.animationPlayState = 'paused';
      });
      item.addEventListener('mouseleave', function () {
        track.style.animationPlayState = 'running';
      });
    });
  })();
</script>