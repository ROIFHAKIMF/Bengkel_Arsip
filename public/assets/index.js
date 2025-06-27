    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('toggle');
        const body = document.body;

        // Load from localStorage if exists
        if (localStorage.getItem('darkmode') === 'true') {
            toggle.checked = true;
            body.classList.add('darkmode');
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

