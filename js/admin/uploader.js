(function ($) {
  $(function () {
    $('.js-uploader').click(function (e) {
      e.preventDefault();
      var $this = $(this);
      var $input = $('#' + $this.data('id'));
      var multiple = $this.data('multiple');
      var uploader = wp.media({
        title: 'Choisissez un fichier',
        button: {
          text: 'Selectionnez un fichier'
        },
        multiple: multiple
      });

      uploader.on('select', function (e) {
        var selection = uploader.state().get('selection');
        var urls = selection.map(function (item) {
          return item.toJSON().url
        });
        // On ajoute à l'existant
        urls.push($input.val());

        $input.val(urls.join(','));
      });
      uploader.open();
    })
  })

})(jQuery);