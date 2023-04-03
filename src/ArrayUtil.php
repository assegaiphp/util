<?php

namespace Assegai\Util;

/**
 * Array utilities.
 */
class ArrayUtil
{
    /**
     * Checks if a value is in an array.
     *
     * @param mixed $needle The value to search for.
     * @param array $haystack The array to search in.
     * @return bool True if the value is in the array, false otherwise.
     */
    public static function inArray(mixed $needle, array $haystack): bool
    {
        return in_array($needle, $haystack);
    }

    /**
     * Checks if an array is associative.
     *
     * @param array $array The array to check.
     * @return bool True if the array is associative, false otherwise.
     */
    public static function isAssociative(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Checks if an array is not associative.
     *
     * @param array $array The array to check.
     * @return bool True if the array is not associative, false otherwise.
     */
    public static function isNotAssociative(array $array): bool
    {
        return !self::isAssociative($array);
    }

    /**
     * Checks if an array is sequential. An array is sequential if it
     * has consecutive integer keys starting at 0.
     *
     * @param array $array The array to check.
     * @return bool True if the array is sequential, false otherwise.
     */
    public static function isSequential(array $array): bool
    {
        return array_keys($array) === range(0, count($array) - 1);
    }

    /**
     * Checks if an array is empty.
     *
     * @param array $array The array to check.
     * @return bool True if the array is empty, false otherwise.
     */
    public static function isEmpty(array $array): bool
    {
        return empty($array);
    }

    /**
     * Checks if an array is multidimensional.
     *
     * @param array $array The array to check.
     * @return bool True if the array is multidimensional, false otherwise.
     */
    public static function isMultidimensional(array $array): bool
    {
        return count($array) !== count($array, COUNT_RECURSIVE);
    }

    /**
     * Checks if an array is not empty.
     *
     * @param array $array The array to check.
     * @return bool True if the array is not empty, false otherwise.
     */
    public static function isNotEmpty(array $array): bool
    {
        return !empty($array);
    }

    /**
     * Checks if an array is not multidimensional.
     *
     * @param array $array The array to check.
     * @return bool True if the array is not multidimensional, false otherwise.
     */
    public static function isNotMultidimensional(array $array): bool
    {
        return count($array) === count($array, COUNT_RECURSIVE);
    }

    /**
     * Checks if an array is not sequential.
     *
     * @param array $array The array to check.
     * @return bool True if the array is not sequential, false otherwise.
     */
    public static function isNotSequential(array $array): bool
    {
        return self::isAssociative($array);
    }

    /**
     * Checks if an array is numeric. An array is numeric if it has
     * consecutive integer keys starting at 0.
     *
     * @param array $array The array to check.
     * @return bool True if the array is numeric, false otherwise.
     */
    public static function isNumeric(array $array): bool
    {
        return array_keys($array) === range(0, count($array) - 1);
    }

    /**
     * Checks if an array is not numeric. An array is numeric if it has
     * consecutive integer keys starting at 0.
     *
     * @param array $array The array to check.
     * @return bool True if the array is not numeric, false otherwise.
     */
    public static function isNotNumeric(array $array): bool
    {
        return !self::isNumeric($array);
    }
}