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
   * @param string $dirname
   * @return string
   * @since v0.0.2
   */
  public static function folderNotFound(string $dirname): string
  {
    if (empty($dirname)) {
      $message = 'Folder could not be found.';
    } else {
      $message = sprintf('Folder (%s) could not be found.', $dirname);
    }

    return $message;
  }

  /**
   * "File not found" Exception
   *
   * @param string $filename
   * @return string
   * @since v0.0.2
   */
  public static function fileNotFound(string $filename): string
  {
    if (empty($filename)) {
      $message = 'File could not be found.';
    } else {
      $message = sprintf('File (%s) could not be found.', $filename);
    }

    return $message;
  }

  /**
   * "Folder already exists" Exception
   *
   * @param string $dirname
   * @return string
   * @since v0.0.2
   */
  public static function folderAlreadyExists(string $dirname): string
  {
    if (empty($dirname)) {
      $message = 'Folder already exists.';
    } else {
      $message = sprintf('Folder (%s) already exists.', $dirname);
    }

    return $message;
  }
}
