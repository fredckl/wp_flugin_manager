<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-13
 * Time: 05:37
 */

if (!function_exists('fk_convert_to_attrs')) {
    function fk_convert_to_attrs ($attrs)
    {
        $_attrs = [];
        foreach ($attrs as $key => $value) {
            $_attrs[] = sprintf('%s="%s"', $key, h($value));
        }

        return !empty($_attrs) ? ' ' . implode(' ', $_attrs) : '';
    }
}

if (!function_exists('fk_slugify')) {
    function fk_slugify($text, $replacment = '-')
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', $replacment, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $replacment);

        // remove duplicate -
        $text = preg_replace('~-+~', $replacment, $text);

        // lowercase
        $text = strtolower($text);

        return $text;
    }
}

if (!function_exists('h')) {
    /**
     * Convenience method for htmlspecialchars.
     *
     * @param mixed $text Text to wrap through htmlspecialchars. Also works with arrays, and objects.
     *    Arrays will be mapped and have all their elements escaped. Objects will be string cast if they
     *    implement a `__toString` method. Otherwise the class name will be used.
     *    Other scalar types will be returned unchanged.
     * @param bool $double Encode existing html entities.
     * @param string|null $charset Character set to use when escaping. Defaults to config value in `mb_internal_encoding()`
     * or 'UTF-8'.
     * @return mixed Wrapped text.
     * @link https://book.cakephp.org/3.0/en/core-libraries/global-constants-and-functions.html#h
     */
    function h($text, $double = true, $charset = null)
    {
        if (is_string($text)) {
            //optimize for strings
        } elseif (is_array($text)) {
            $texts = [];
            foreach ($text as $k => $t) {
                $texts[$k] = h($t, $double, $charset);
            }
            return $texts;
        } elseif (is_object($text)) {
            if (method_exists($text, '__toString')) {
                $text = (string)$text;
            } else {
                $text = '(object)' . get_class($text);
            }
        } elseif ($text === null || is_scalar($text)) {
            return $text;
        }
        static $defaultCharset = false;
        if ($defaultCharset === false) {
            $defaultCharset = mb_internal_encoding();
            if ($defaultCharset === null) {
                $defaultCharset = 'UTF-8';
            }
        }
        if (is_string($double)) {
            deprecationWarning(
                'Passing charset string for 2nd argument is deprecated. ' .
                'Use the 3rd argument instead.'
            );
            $charset = $double;
            $double = true;
        }
        return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, $charset ?: $defaultCharset, $double);
    }
}
