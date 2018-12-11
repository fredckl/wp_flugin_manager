<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-11
 * Time: 15:53
 */
?>
<p class="<?php echo $clsForm ?>">
    <label for="<?php echo $id ?>"><?php echo $label ?></label>
    <?php require __DIR__ . DS . 'inputs' . DS . $type . '.php' ; ?>
</p>

