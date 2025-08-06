<style>
  .cookie-banner {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #f9f9f9;
    border-top: 1px solid #ccc;
    padding: 15px;
    text-align: center;
    z-index: 1000;
    box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .cookie-buttons {
    margin-top: 10px;
  }

  .cookie-buttons .btn {
    margin: 0 5px;
    padding: 6px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .btn-success {
    background-color: #28a745;
    color: white;
  }

  .btn-success:hover {
    background-color: #218838;
  }

  .btn-danger {
    background-color: #dc3545;
    color: white;
  }

  .btn-danger:hover {
    background-color: #c82333;
  }

  .cookie-dismiss {
    position: absolute;
    top: 5px;
    right: 10px;
    cursor: pointer;
    font-size: 24px;
    color: #777;
  }

  .cookie-dismiss:hover {
    color: #000;
  }
</style>

<div id="cookie-banner" class="cookie-banner" style="display: none;">
  <span id="dismiss-cookie" class="cookie-dismiss">&times;</span>
  <p>This website uses cookies to ensure you get the best experience. Do you accept?</p>
  <div class="cookie-buttons">
    <button id="accept-cookies" class="btn btn-success btn-sm">Accept</button>
    <button id="reject-cookies" class="btn btn-danger btn-sm">Reject</button>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const banner = document.getElementById('cookie-banner');
    const acceptBtn = document.getElementById('accept-cookies');
    const rejectBtn = document.getElementById('reject-cookies');
    const dismissCookie = document.getElementById('dismiss-cookie');

    // Helper to set a cookie
    function setCookie(name, value, days) {
      const expires = new Date(Date.now() + days * 864e5).toUTCString();
      document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
    }

    // Helper to get a cookie
    function getCookie(name) {
      return document.cookie.split('; ').find(row => row.startsWith(name + '='))?.split('=')[1];
    }

    // Show banner only if no consent cookie is set
    if (!getCookie('cookie_consent')) {
      banner.style.display = 'flex';
    }

    acceptBtn.addEventListener('click', function () {
      setCookie('cookie_consent', 'accepted', 365);
      banner.style.display = 'none';
    });

    rejectBtn.addEventListener('click', function () {
      setCookie('cookie_consent', 'rejected', 365);
      banner.style.display = 'none';
    });

    dismissCookie.addEventListener('click', function () {
      banner.style.display = 'none';
    });
  });
</script>
``