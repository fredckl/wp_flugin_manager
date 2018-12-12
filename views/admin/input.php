<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-11
 * Time: 15:53
 */
?>
<div class="<?php echo $cls ?>">
    <label for="<?php echo $id ?>"><?php echo $label ?></label>
    <?php require __DIR__ . DS . 'input_types' . DS . $type . '.php' ; ?>
</div>

