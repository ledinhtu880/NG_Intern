$(document).ready(function () {
  $('.js-open').click(function (e) {
    e.preventDefault();
    $('.js-file').click();
  });

  $('.js-file').change(function () {
    const file = this.files[0];
    if (file) {
      const imageUrl = URL.createObjectURL(file);
      $('.js-image').attr('src', imageUrl);
    }
  });
  
  const toastLiveExample = $('#liveToast');
  const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
  toastBootstrap.show();
})
