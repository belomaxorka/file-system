<?php declare(strict_types=1);

namespace belomaxorka\Filesystem;

/**
 * PHP Filesystem - PHP library for file and directory management. Provides basic methods for the filesystem
 *
 * @author belomaxorka
 * @version v0.0.2
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
class Exceptions
{
  /**
   * "Folder not found" Exception
   *
   * @param string $path
   * @return string
   * @since v0.0.2
   */
  public static function folderNotFound(string $path): string
  {
    if (empty($path)) {
      $message = 'Folder could not be found.';
    } else {
      $message = sprintf('Folder (%s) could not be found.', $path);
    }

    return $message;
  }
}
