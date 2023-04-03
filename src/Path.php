<?php

namespace Assegai\Util;

/**
 * Path utilities.
 */
class Path
{
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
   * Joins paths together.
   *
   * @param string $paths The path to join.
   * @return string The joined path.
   */
  public static function join(...$paths): string
  {
    $path = '';

    foreach ($paths as $p)
    {
      if (is_string($p))
      {
        $path .= "/$p";
      }
    }

    $path = preg_replace('/\/+/', '/', $path);
    return rtrim($path, '/');
  }
}