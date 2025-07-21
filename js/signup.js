   // Enable submit button only if checkbox is checked
    const checkbox = document.getElementById('termsCheck');
    const submitBtn = document.querySelector('button[type="submit"]');
    checkbox.addEventListener('change', () => {
        submitBtn.disabled = !checkbox.checked;
    });