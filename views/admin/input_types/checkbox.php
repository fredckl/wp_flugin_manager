<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-13
 * Time: 14:32
 */
?>

<?php if (!empty($checkboxs) && is_array($checkboxs)): ?>
    <?php foreach ($checkboxs as $key => $checkbox): ?>
        <?php $uniq = uniqid(); ?>
        <span<?php echo ($options['inputVars']) ?>>
            <label for="<?php echo $uniq ?>"><?php echo $checkbox ?></label>
            <input type="<?php echo h($type) ?>" name="<?php echo h($id) ?>[]" id="<?php echo ($uniq) ?>" value="<?php echo h($key) ?>" <?php echo !empty($value) && in_array($key, $value) ? 'checked' : ''; ?>>
        </span>
    <?php endforeach; ?>
<?php endif; ?>
