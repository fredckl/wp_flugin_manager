<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-11
 * Time: 18:21
 */
?>

<input type="<?php echo $tye ?>" name="<?php echo $id ?>" id="<?php echo $id ?>" value="<?php echo $value ?>">
<a href="#" class="button js-uploader" data-id="<?php echo $id ?>" data-multiple="true">Sélectionner une image</a>

<?php if (!empty($value)): ?>
    <div class="<?php echo $cls ?>-images">
        <?php
        $images = explode(',', $value);
        foreach ($images as $img) {
            echo sprintf('<img src="%s" width="100" />', $img);
        }
        ?>
    </div>
<?php endif; ?>
