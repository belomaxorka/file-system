<?php declare(strict_types=1);

namespace belomaxorka\Filesystem;

use DirectoryIterator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * PHP Filesystem - PHP library for file and directory management. Provides basic methods for the filesystem
 *
 * @author belomaxorka
 * @version v0.0.1
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
class Filesystem
{
  /**
   * Return size of directory
   *
   * @param string $path
   * @return int
   * @since v0.0.1
   */
  public static function getDirSize(string $path): int
  {
    $bytes_total = 0;

    clearstatcache();

    if (file_exists($path) && is_dir($path)) {
      foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
        $bytes_total += $object->getSize();
      }
    }

    return $bytes_total;
  }

  /**
   * Returns directory files list as array
   *
   * @param string $path
   * @return array
   * @since v0.0.1
   */
  public static function getListOfFiles(string $path): array
  {
    $files_array = [];

    clearstatcache();

    if (file_exists($path) && is_dir($path)) {
      foreach (new DirectoryIterator($path) as $file) {
        if ($file->isFile()) {
          $files_array[] = $file->getFilename();
        }
      }
    }

    return $files_array;
  }
}
