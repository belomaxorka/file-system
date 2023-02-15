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
 * @version v0.0.2
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
class Filesystem
{
  /**
   * Return size of directory
   *
   * @param string $path
   * @param bool $needResetStat
   * @return int
   * @since v0.0.1
   */
  public static function getDirSize(string $path, bool $needResetStat = true): int
  {
    $bytes_total = 0;

    if ($needResetStat) {
      clearstatcache();
    }

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
   * @param bool $needResetStat
   * @return array
   * @since v0.0.1
   */
  public static function getListOfFiles(string $path, bool $needResetStat = true): array
  {
    $files_array = [];

    if ($needResetStat) {
      clearstatcache();
    }

    if (file_exists($path) && is_dir($path)) {
      foreach (new DirectoryIterator($path) as $file) {
        if ($file->isFile()) {
          $files_array[] = $file->getFilename();
        }
      }
    }

    return $files_array;
  }

  /**
   * Return true if directory is empty
   *
   * @param string $path
   * @param bool $needResetStat
   * @return bool
   * @since v0.0.2
   */
  public static function isDirEmpty(string $path, bool $needResetStat = true): bool
  {
    if ($needResetStat) {
      clearstatcache();
    }

    if (file_exists($path) && is_dir($path)) {
      return !(new FilesystemIterator($path))->valid();
    }
  }
}
