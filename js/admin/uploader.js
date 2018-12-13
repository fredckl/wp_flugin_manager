(function ($) {

  function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
  }

  $(function () {
    $('.js-uploader').on('click', function (e) {
      e.preventDefault();
      var $this = $(this),
          $input = $('#' + $this.data('id')),
          multiple = $this.data('multiple'),
          uploader;

      uploader = wp.media({
        title: 'Choisissez un fichier',
        button: {
          text: 'Selectionnez un fichier'
        },
        multiple: multiple
      });

      uploader.on('select', function (e) {
        var selection = uploader.state().get('selection');
        var images, imagesID;

        images = selection.toJSON();
        console.log(images);
        imagesID = selection.map(function (item) {
          return item.toJSON().id;
        });
        // On ajoute à l'existant
        imagesID.push($input.val());

        // Supprime les doublon
        imagesID = imagesID.filter(onlyUnique);
        $input.val(imagesID.join(','));
      });
      uploader.open();
    });

    $('.fk-metabox-image-remove').on('click', function (e) {
      e.preventDefault();
        var $this = $(this);
        var $input = $('#' + $this.data('input-id'));
        var id = $this.data('id');

        var values = $input.val().split(',').filter(function (item) {
            return item != id;
        });

        $this.parent().remove();

        $input.val(values.join(','));
    })

  })

})(jQuery);