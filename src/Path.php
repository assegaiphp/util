<?php

namespace Assegai\Util;

use Exception;
use InvalidArgumentException;
use SplFileInfo;

/**
 * Path utilities.
 */
class Path
{
  const PARSE_ASSOC = 'assoc';
  const PARSE_OBJECT = 'object';

  private function __construct()
  {
  }

  /**
   * Gets the current working directory.
   *
   * @return string The current working directory.
   */
  public static function getCurrentWorkingDirectory(): string
  {
    return getcwd();
  }

  /**
   * Gets the last part of a path.
   *
   * @param string $path The path to get the last part from.
   * @return string The last part of the path.
   */
  public static function basename(string $path): string
  {
    return basename($path);
  }

  /**
   * Returns the delimiter specified for the platform.
   *
   * @return string The delimiter.
   */
  public static function delimiter(): string
  {
    return DIRECTORY_SEPARATOR;
  }

  /**
   * Gets the directory name of a path.
   *
   * @param string $path The path to get the directory name from.
   * @return string The directory name.
   */
  public static function dirname(string $path): string
  {
    return dirname($path);
  }

  /**
   * Gets the extension of a path.
   *
   * @param string $path The path to get the extension from.
   * @return string The extension.
   */
  public static function extension(string $path): string
  {
    return pathinfo($path, PATHINFO_EXTENSION);
  }

  /**
   * Formats a path object or array into a string.
   *
   * @param object|array $path The path object|array to format.
   * @return string The formatted path.
   */
  public static function format(object|array $path): string
  {
    if (is_object($path))
    {
      if (!isset($path->dir) || !isset($path->base))
      {
        throw new InvalidArgumentException('The path object must have a dir and a base property.');
      }

      return self::join($path->dir, $path->base);
    }

    if (is_array($path))
    {
      if (!isset($path['dir']) || !isset($path['base']))
      {
        throw new InvalidArgumentException('The path array must have a dir and a base key.');
      }

      return self::join($path['dir'], $path['base']);
    }

    throw new InvalidArgumentException('The path must be an object or an array.');
  }

  /**
   * Returns the current working directory.
   *
   * @return string The current working directory.
   */
  public static function getCwd(): string
  {
    return getcwd();
  }

  /**
   * Checks if a path is absolute.
   *
   * @param string $path The path to check.
   * @return bool True if the path is absolute, false otherwise.
   */
  public static function isAbsolute(string $path): bool
  {
    if (PHP_OS_FAMILY === 'Windows')
    {
      return preg_match('/^[a-zA-Z]:\\\\/', $path) === 1;
    }

    return str_starts_with($path, DIRECTORY_SEPARATOR);
  }

  /**
   * Joins paths together.
   *
   * @param string $paths The path to join.
   * @return string The joined path.
   */
  public static function join(...$paths): string
  {
    $path = join('/', $paths);

    $path = preg_replace('/\/+/', '/', $path);
    return rtrim($path, '/');
  }

  /**
   * Normalizes a path. Removes trailing slashes and resolves '..' and '.' segments.
   *
   * @param string $path The path to normalize.
   * @return string The normalized path.
   */
  public static function normalize(string $path): string
  {
    # Trim leading and trailing spaces and normalize slashes
    $path = trim($path);
    $path = str_replace(['\\', '/'], self::delimiter(), $path);

    # Check for special cases
    if ($path === '..' || $path === '../')
    {
      return self::dirname(self::getCurrentWorkingDirectory());
    }
    else if ($path === '.' || $path === './')
    {
      return self::getCurrentWorkingDirectory();
    }

    # Split the path into parts
    $parts = explode(self::delimiter(), $path);
    $normalizedParts = [];

    foreach ($parts as $part)
    {
      if ($part === '..')
      {
        // Handle parent directory (remove the last normalized part)
        array_pop($normalizedParts);
      }
      else if ($part !== '.')
      {
        // Ignore current directory
        $normalizedParts[] = $part;
      }
    }

    # Rebuild the normalized path
    $normalizedPath = implode(DIRECTORY_SEPARATOR, $normalizedParts);

    # Ensure the path starts with the correct separator for the platform
    if (str_starts_with($path, '/') || str_starts_with($path, '\\'))
    {
      $normalizedPath = self::delimiter() . $normalizedPath;
    }

    # Remove double slashes
    return preg_replace('/\/+/', '/', $normalizedPath);
  }

  /**
   * Parses a path into an object or array.
   *
   * @param string $path The path to parse.
   * @param string $type The type of the parsed path. Can be 'assoc' or 'object'.
   * @return object|array The parsed path.
   * @throws Exception If the path could not be parsed.
   */
  public static function parse(string $path, string $type = self::PARSE_OBJECT): object|array
  {
    $path = self::normalize($path);

    $pathInfo = pathinfo($path);

    if ($type === self::PARSE_ASSOC)
    {
      return $pathInfo;
    }

    if ($type === self::PARSE_OBJECT)
    {
      return (object) $pathInfo;
    }

    throw new InvalidArgumentException('The type must be either assoc or object.');
  }

  /**
   * Returns an object containing POSIX specific properties and methods.
   *
   * @param string $path The path to convert.
   * @return SplFileInfo The converted path.
   */
  public static function posix(string $path): SplFileInfo
  {
    $normalizePath = self::normalize($path);
    return new SplFileInfo($normalizePath);
  }

  /**
   * Returns the relative path from one path to another.
   *
   * @param string $from The path to start from.
   * @param string $to The path to end at.
   * @return string The relative path.
   */
  public static function relative(string $from, string $to): string
  {
    $from = substr(self::resolve($from), 1);
    $to = substr(self::resolve($to), 1);

    $fromParts = array_trim(explode(self::delimiter(), $from));
    $toParts = array_trim(explode(self::delimiter(), $to));

    $totalFromParts = count($fromParts);
    $totalToParts = count($toParts);
    $length = min($totalFromParts, $totalToParts);
    $samePartsLength = $length;

    for ($x = 0; $x < $length; $x++)
    {
      if ($fromParts[$x] !== $toParts[$x])
      {
        $samePartsLength = $x;
        break;
      }
    }

    $outputParts = [];

    for ($i = $samePartsLength; $i < $totalFromParts; $i++)
    {
      $outputParts[] = '..';
    }

    $outputTail = array_slice($toParts, $samePartsLength);
    $outputParts = array_merge($outputParts, $outputTail);

    return join(self::delimiter(), $outputParts);
  }

  /**
   * Resolves the specified paths into an absolute path. It works by processing the sequence of paths from right to
   * left, prepending each of the paths until the absolute path is created. The resulting path is normalized and
   * trailing slashes are removed as required.
   *
   * If no path segments are given as parameters, then the absolute path of the current working directory is used.
   *
   * @param string[] $paths The paths to resolve.
   * @return string The resolved path.
   */
  public static function resolve(string ...$paths): string
  {
    if (empty($paths))
    {
      return self::getCwd();
    }

    $resolvedPath = '';
    $reversedPaths = array_reverse($paths);

    # Normalize each path
    foreach ($reversedPaths as $path)
    {
      $resolvedPath = self::join($path, $resolvedPath);

      # If the path is absolute, return it
      if (self::isAbsolute($path))
      {
        return self::normalize($resolvedPath);
      }
    }

    # Normalize the joined path
    $resolvedPath = self::normalize($resolvedPath);

    # If the path is absolute, return it
    if (self::isAbsolute($resolvedPath))
    {
      return $resolvedPath;
    }

    # else prepend the current working directory
    return self::join(self::getCwd(), $resolvedPath);

//    $totalPaths = count($paths);
//
//    $path = '';
//
//    for ($x = $totalPaths - 1; $x >= 0; $x--)
//    {
//      $path .= self::join($paths[$x], $path);
//      $path = self::normalize($path);
//
//      if (self::isAbsolute($path))
//      {
//        return $path;
//      }
//    }
//
//    return '/' . self::normalize($path);
  }

  /**
   * Returns the segment separator specified for the platform.
   *
   * @return string The segment separator.
   */
  public static function sep(): string
  {
    return PATH_SEPARATOR;
  }

  /**
   * Returns the path with backslashes.
   *
   * @param string $path The path to convert.
   * @return string The converted path.
   */
  public static function windows(string $path): string
  {
    return str_replace(DIRECTORY_SEPARATOR, '\\', $path);
  }
}