<?php
namespace Thepsion5\Admiral;

class StringHelper
{
    /**
     * @param string $pattern
     * @param string $value
     * @return bool
     */
    public static function matchesWildcard($pattern, $value)
    {
        if($pattern == $value) {
            return true;
        }

        $pattern = preg_quote($pattern, '#');
        $pattern = str_replace('\*', '.*', $pattern).'\z';
        return (bool) preg_match('#^'.$pattern.'#', $value);
    }

    /**
     * @param string $class
     * @return string
     */
    public static function classToDotNotation($class)
    {
        $dotClass = str_replace('\\', '.', $class);
        $snakeCase = strtolower( preg_replace('/([a-z])([A-Z])/', '$1_$2', $dotClass) );
        return trim($snakeCase, '.');
    }
}
