<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-11
 * Time: 18:21
 */
?>
<?php
// Traitement sur les images pour éviter d'avoir des duplications
if (!empty($value)) {
    $values = explode(',', $value);
    $values = array_combine(array_values($values), array_values($values));
    $value = implode(',', $values);
}
?>
<input type="<?php WP_DEBUG ? 'text' : 'hidden'; ?>" name="<?php echo h($id) ?>" id="<?php echo h($id) ?>" value="<?php echo $value ?>">
<a href="#" class="button js-uploader" data-id="<?php echo h($id) ?>" data-multiple="<?php echo h($multiple) ?>">Sélectionner une image</a>

<?php if (!empty($value)): ?>
    <div class="<?php echo $prefix ?>-container-images">
        <?php
        $images = explode(',', $value);
        foreach ($images as $imgID): ?>
            <div class="<?php echo $prefix ?>-image">
                <?php echo sprintf('<img src="%s" />', wp_get_attachment_image_url($imgID)); ?>
                <a href="#" class="fk-metabox-image-remove" data-input-id="<?php echo h($id) ?>" data-id="<?php echo h($imgID) ?>"></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
