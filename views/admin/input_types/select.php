<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-11
 * Time: 18:21
 */
?>
<?php if (!empty($selects) && is_array($selects)): ?>
    <select name="<?php echo h($id) ?>" id="<?php echo h($id) ?>"<?php echo ($options['inputVars']) ?>>
        <?php if (!empty($empty)): ?>
            <option><?php echo h($empty) ?></option>
        <?php endif; ?>

        <?php foreach ($selects as $key => $select): ?>
            <option value="<?php echo h($key) ?>" <?php echo !empty($value) && $key == $value ? 'selected' : ''; ?>><?php echo $select ?></option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>

