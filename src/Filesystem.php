<?php declare(strict_types=1);

namespace belomaxorka\Filesystem;

use DirectoryIterator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use Exception;

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
   * @throws Exception
   * @since v0.0.1
   */
  public static function getDirSize(string $path, bool $needResetStat = true): int
  {
    $bytes_total = 0;

    if (self::isDirExists($path, $needResetStat)) {
      foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
        $bytes_total += $object->getSize();
      }
    } else {
      throw new Exception(Exceptions::folderNotFound($path));
    }

    return $bytes_total;
  }

  /**
   * Return size of file
   *
   * @param string $path
   * @param bool $needResetStat
   * @return int
   * @throws Exception
   * @since v0.0.2
   */
  public static function getFileSize(string $path, bool $needResetStat = true): int
  {
    if (self::isFileExists($path, $needResetStat)) {
      return (int)filesize($path);
    } else {
      throw new Exception(Exceptions::fileNotFound($path));
    }
  }

  /**
   * Returns directory files list as array
   *
   * @param string $path
   * @param bool $needResetStat
   * @return array
   * @throws Exception
   * @since v0.0.1
   */
  public static function getListOfFiles(string $path, bool $needResetStat = true): array
  {
    $files_array = [];

    if (self::isDirExists($path, $needResetStat)) {
      foreach (new DirectoryIterator($path) as $file) {
        if ($file->isFile()) {
          $files_array[] = $file->getFilename();
        }
      }
    } else {
      throw new Exception(Exceptions::folderNotFound($path));
    }

    return $files_array;
  }

  /**
   * Return true if directory is empty
   *
   * @param string $path
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function isDirEmpty(string $path, bool $needResetStat = true): bool
  {
    if (self::isDirExists($path, $needResetStat)) {
      return !(new FilesystemIterator($path))->valid();
    } else {
      throw new Exception(Exceptions::folderNotFound($path));
    }
  }

  /**
   * Return true if file is empty
   *
   * @param string $path
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function isFileEmpty(string $path, bool $needResetStat = true): bool
  {
    if (self::isFileExists($path, $needResetStat)) {
      return ((int)filesize($path) === 0);
    } else {
      throw new Exception(Exceptions::fileNotFound($path));
    }
  }

  /**
   * Return true if directory exists
   *
   * @param string $path
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function isDirExists(string $path, bool $needResetStat = true): bool
  {
    if ($needResetStat) {
      clearstatcache();
    }

    if (file_exists($path) && is_dir($path)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Return true if file exists
   *
   * @param string $path
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function isFileExists(string $path, bool $needResetStat = true): bool
  {
    if ($needResetStat) {
      clearstatcache();
    }

    if (file_exists($path) && is_file($path)) {
      return true;
    } else {
      return false;
    }
  }
}
