(function() {
  /**
   * Handle telegram sticky subscribe
   */
  var popup = document.getElementById('sticky-subscribe');

  window.addEventListener('load', function () {
    var storage = window.localStorage.getItem('telegram-popup');

    if (storage == null) {
      setTimeout(() => {
        popup.style.visibility = 'visible';
      }, 10000);
    }
  });

  var close = document.getElementById('sticky-subscribe-close');

  close.addEventListener('click', function() {
    window.localStorage.setItem('telegram-popup', new Date().valueOf());
    popup.classList.add('d-none');
  });
})();