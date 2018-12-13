<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-11
 * Time: 18:22
 */
?>

<textarea type="<?php echo h($type) ?>" name="<?php echo h($id) ?>" id="<?php echo h($id) ?>"><?php echo esc_textarea($value) ?><?php echo ($options['inputVars']) ?></textarea>
