<?php /** @noinspection SpellCheckingInspection */

/***********************
 *        Arrays       *
 ***********************/

use Assegai\Util\Text;

if (! function_exists('array_first') )
{
  /**
   * Returns the first element in an array.
   *
   * @param array $array The array to get the first element from.
   * @return mixed|null The first element in the array, or null if the array is empty.
   */
  function array_first(array $array): mixed
  {
    if (empty($array))
    {
      return null;
    }

    if (array_is_associative($array))
    {
      return array_values($array)[0];
    }

    return $array[0];
  }
}

if (! function_exists('array_last') )
{
  /**
   * Returns the last element in an array.
   *
   * @param array $array The array to get the last element from.
   * @return mixed|null The last element in the array, or null if the array is empty.
   */
  function array_last(array $array): mixed
  {
    if (empty($array))
    {
      return null;
    }

    if (array_is_associative($array))
    {
      return array_values($array)[count($array) - 1];
    }

    return $array[count($array) - 1];
  }
}

if (! function_exists('array_find') )
{
  /**
   * Returns the first element in the provided array that satisfies the provided testing function.
   *
   * @param array $arr The array to search through.
   * @param callable $callback A callable function that accepts an element of $arr and returns a boolean value.
   *
   * @return mixed|null The first element in $arr that satisfies $callback. Returns null if no element satisfies the
   * condition.
   */
  function array_find(array $arr, callable $callback): mixed
  {
    foreach ($arr as $item)
    {
      if ($callback($item))
      {
        return $item;
      }
    }
    return null;
  }
}

if (! function_exists('array_find_last') )
{
  /**
   * Iterates the given array in reverse order and returns the value of the first element that satisfies the provided
   * testing function. If no elements satisfy the testing function, null is returned.
   *
   * @param array $arr The array to search through.
   * @param callable $callback A callable function that accepts an element of $arr and returns a boolean value.
   *
   * @return mixed|null The last element in $arr that satisfies $callback. Returns null if no element satisfies the
   * condition.
   */
  function array_find_last(array $arr, callable $callback): mixed
  {
    $reversedArray = array_reverse($arr);
    return array_find($reversedArray, $callback);
  }
}

if (! function_exists('array_is_associative') )
{
  /**
   * Checks if an array is associative. An array is associative if it has at least one key that is not an integer.
   *
   * @param array $array The array to check.
   * @return bool True if the array is associative, false otherwise.
   */
  function array_is_associative(array $array): bool
  {
    return array_keys($array) !== range(0, count($array) - 1);
  }
}

if (! function_exists('array_is_sequential') )
{
  /**
   * Checks if an array is sequential. An array is sequential if it has consecutive integer keys starting at 0.
   *
   * @param array $array The array to check.
   * @return bool True if the array is sequential, false otherwise.
   */
  function array_is_sequential(array $array): bool
  {
    return array_keys($array) === range(0, count($array) - 1);
  }
}

if (! function_exists('array_is_multi_dimensional') )
{
  /**
   * Checks if an array is multidimensional. An array is multidimensional if it contains at least one array.
   *
   * @param array $array The array to check.
   * @return bool True if the array is multidimensional, false otherwise.
   */
  function array_is_multi_dimensional(array $array): bool
  {
    return count($array) !== count($array, COUNT_RECURSIVE);
  }
}

if (! function_exists('array_trim') )
{
  /**
   * Returns an array with all empty elements removed.
   *
   * @param array $array The array to trim.
   * @return array The trimmed array.
   */
  function array_trim(array $array): array
  {
    if (empty($array))
    {
      return $array;
    }

    $result = $array;

    $firstItem = array_first($result);
    while ($firstItem === null || $firstItem === '' || $firstItem === false)
    {
      array_shift($result);
      $firstItem = array_first($result);
    }

    $lastItem = array_last($result);
    while ($lastItem === null || $lastItem === '' || $lastItem === false)
    {
      array_pop($result);
      $lastItem = array_last($result);
    }

    return $result;
  }
}

if (! function_exists('array_clean') )
{
  /**
   * Returns an array with all empty elements removed. Empty elements include empty strings, null values, and false.
   *
   * @param array $array The array to clean.
   * @param bool $null_only If true, only null values will be removed.
   * @return array The cleaned array.
   */
  function array_clean(array $array, bool $null_only = false): array
  {
    $cleanArray = array_filter($array, fn($item) => $null_only ? !is_null($item) : !empty($item));

    if (array_is_sequential($array))
    {
      return array_values($cleanArray);
    }

    return $cleanArray;
  }
}

/***********************
 *       Objects       *
 ***********************/

if (! function_exists('object_to_array') )
{
  /**
   * Converts an object to an array.
   *
   * @param object $object The object to be converted.
   * @return array The object as an array.
   */
  function object_to_array(object $object): array
  {
    return json_decode(json_encode($object), true);
  }
}

/***********************
 *       Strings       *
 ***********************/

if (! function_exists('strtocamel') ) {
  /**
   * Converts a string to camel case.
   *
   * @param string $string The string to convert.
   * @return string The converted string.
   */
  function strtocamel(string $string): string
  {
    return lcfirst(strtopascal($string));
  }
}

if (! function_exists('strtopascal') ) {
  /**
   * Converts a string to Pascal Case format.
   *
   * @param string $string The string to be converted.
   *
   * @return string The string in Pascal Case format.
   */
  function strtopascal(string $string): string
  {
    if (ctype_upper($string)) {
      return ucfirst(strtolower($string));
    }

    $words = preg_split('/[\s\-\W_]+/', $string);
    $words = array_map(fn($word) => ucfirst($word), $words);

    return implode('', $words);
  }
}

if (! function_exists('strtosnake') ) {
  /**
   * Converts a string to snake_case.
   *
   * @param string $string The string to be converted.
   * @return string The string in snake_case.
   */
  function strtosnake(string $string): string
  {
    $output = $string;

    # Replace underscores, spaces, and hyphens with underscores
    $output = preg_replace('/[\s\-\W_]+/', '_', $output);

    $output = preg_replace('/([a-z])([A-Z])/', "$1_$2", $output);

    return mb_strtolower($output);
  }
}

if (! function_exists('strtokebab') ) {
  /**
   * Converts a string to Kebab Case.
   *
   * @param string $string The string to be converted.
   * @return string The string in Kebab Case.
   */
  function strtokebab(string $string): string
  {
    $output = $string;

    # Replace underscores, spaces, and hyphens with dashes
    $output = preg_replace('/[\s\-\W_]+/', '-', $output);

    # Replace uppercase letters with dashes
    $output = preg_replace('/([a-z])([A-Z])/', '$1-$2', $output);
    return mb_strtolower($output);
  }
}

if (! function_exists('strtokebab_ucfirst') ) {
  /**
   * Converts a string to kebab case and capitalizes the first letter.
   *
   * @param string $string The string to convert.
   * @return string The converted string.
   */
  function strtokebab_ucfirst(string $string): string
  {
    return ucfirst(strtokebab($string));
  }
}

if (! function_exists('strtoplural') ) {
  /**
   * Converts a string to its plural form.
   *
   * @param string $string The string to convert.
   * @return string The plural form of the string.
   */
  function strtoplural(string $string): string
  {
    $text = new Text($string);
    return $text->getPluralForm();
  }
}

if (! function_exists('strtosingular') ) {
  function strtosingular(string $string): string
  {
    $text = new Text($string);
    return $text->getSingularForm();
  }
}

if (! function_exists('extract_class_name') ) {
  /**
   * Extracts the class name from a string containing a class definition.
   *
   * @param string $class_definition The input string containing the class definition.
   * @return string|false The class name as a string, or false if the input string does not contain a valid class definition.
   */
  function extract_class_name(string $class_definition): string|false
  {
    # Attempt to match the class definition using a regular expression.
    if (false === preg_match('/class\s+([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/', $class_definition, $matches)) {
      # If no match is found, return false.
      return false;
    }

    # Ensure that the $matches array contains at least one element.
    if (count($matches) < 1) {
      # If $matches is empty, return false.
      return false;
    }

    # Return the captured class name from the $matches array.
    return $matches[1];
  }
}

/***********************
 *     Directories     *
 ***********************/

if (! function_exists('empty_directory') )
{
  /**
   * Empties a directory of all its contents.
   *
   * @param string $directory_path The path to the directory to be emptied.
   * @return bool True if the directory was successfully emptied, false otherwise.
   */
  function empty_directory(string $directory_path): bool
  {
    if (!is_dir($directory_path))
    {
      return false;
    }

    $items = scandir($directory_path);

    foreach ($items as $item)
    {
      if ($item === '.' || $item === '..')
      {
        continue;
      }

      $path = $directory_path . DIRECTORY_SEPARATOR . $item;

      if (is_dir($path))
      {
        empty_directory($path);
        rmdir($path);
      }
      else
      {
        unlink($path);
      }
    }

    return true;
  }
}

/***********************
 *        JSON         *
 ***********************/
if (! function_exists('json_is_valid') )
{
  /**
   * Returns true if the JSON string is valid, false otherwise. If the PHP version is 8.3.0 or greater, this function
   * will use the built-in json_validate function.
   *
   * @param string $input The JSON string to validate
   * @return bool Returns true if the JSON string is valid, false otherwise.
   */
  function json_is_valid(string $input): bool
  {
    if (version_compare(PHP_VERSION, '8.3.0', '>=') >= 0)
    {
      if (function_exists('json_validate'))
      {
        return json_validate($input);
      }
    }

    json_decode($input);

    return json_last_error() === JSON_ERROR_NONE;
  }
}