    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('toggle');
        const body = document.body;

        // Load from localStorage if exists
        if (localStorage.getItem('darkmode') === 'true') {
            toggle.checked = true;
            body.classList.add('darkmode');
        }else {
            toggle.checked = false;
            body.classList.remove('darkmode');
        }

        toggle.addEventListener('change', function () {
            if (this.checked) {
                body.classList.add('darkmode');
                localStorage.setItem('darkmode', 'true');
            } else {
                body.classList.remove('darkmode');
                localStorage.setItem('darkmode', 'false');
            }
        });
    });
  function adjustAllRows() {
    const rows = document.querySelectorAll('.row.w-50');
    rows.forEach(row => {
      if (window.innerWidth <= 768) {
        row.classList.remove('w-50');
        row.classList.add('w-100');
      } else {
        row.classList.remove('w-100');
        row.classList.add('w-50');
      }
    });
  }

  document.addEventListener('DOMContentLoaded', adjustAllRows);
  window.addEventListener('resize', adjustAllRows);

