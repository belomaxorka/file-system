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
   * Make directory
   *
   * @param string $dirname
   * @param int $mode
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function makeDir(string $dirname, int $mode = 0777, bool $needResetStat = true): bool
  {
    if (!self::isDirExists($dirname, $needResetStat)) {
      return mkdir($dirname, $mode, true);
    }

    throw new Exception(Exceptions::folderAlreadyExists($dirname));
  }

  /**
   * Return size of directory
   *
   * @param string $dirname
   * @param bool $needResetStat
   * @return int
   * @throws Exception
   * @since v0.0.1
   */
  public static function getDirSize(string $dirname, bool $needResetStat = true): int
  {
    $bytesTotal = 0;

    if (self::isDirExists($dirname, $needResetStat)) {
      foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirname, FilesystemIterator::SKIP_DOTS)) as $object) {
        $bytesTotal += $object->getSize();
      }
    } else {
      throw new Exception(Exceptions::folderNotFound($dirname));
    }

    return $bytesTotal;
  }

  /**
   * Return size of file
   *
   * @param string $filename
   * @param bool $needResetStat
   * @return int
   * @throws Exception
   * @since v0.0.2
   */
  public static function getFileSize(string $filename, bool $needResetStat = true): int
  {
    if (self::isFileExists($filename, $needResetStat)) {
      return (int)filesize($filename);
    } else {
      throw new Exception(Exceptions::fileNotFound($filename));
    }
  }

  /**
   * Returns directory contents
   *
   * @param string $dirname
   * @param bool $includeDirs
   * @param bool $needResetStat
   * @return array
   * @throws Exception
   * @since v0.0.1
   */
  public static function getListOfDirContents(string $dirname, bool $includeDirs = false, bool $needResetStat = true): array
  {
    $filesArray = [];

    if (self::isDirExists($dirname, $needResetStat)) {
      foreach (new DirectoryIterator($dirname) as $file) {
        if ($file->isFile() || ($includeDirs && $file->isDir() && !$file->isDot())) {
          $filesArray[] = $file->getFilename();
        }
      }
    } else {
      throw new Exception(Exceptions::folderNotFound($dirname));
    }

    return $filesArray;
  }

  /**
   * Return true if directory is empty
   *
   * @param string $dirname
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function isDirEmpty(string $dirname, bool $needResetStat = true): bool
  {
    if (self::isDirExists($dirname, $needResetStat)) {
      return !(new FilesystemIterator($dirname))->valid();
    } else {
      throw new Exception(Exceptions::folderNotFound($dirname));
    }
  }

  /**
   * Return true if file is empty
   *
   * @param string $filename
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function isFileEmpty(string $filename, bool $needResetStat = true): bool
  {
    if (self::isFileExists($filename, $needResetStat)) {
      return ((int)filesize($filename) === 0);
    } else {
      throw new Exception(Exceptions::fileNotFound($filename));
    }
  }

  /**
   * Return true if directory exists
   *
   * @param string $dirname
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function isDirExists(string $dirname, bool $needResetStat = true): bool
  {
    if ($needResetStat) {
      clearstatcache();
    }

    if (file_exists($dirname) && is_dir($dirname)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Return true if file exists
   *
   * @param string $filename
   * @param bool $needResetStat
   * @return bool
   * @throws Exception
   * @since v0.0.2
   */
  public static function isFileExists(string $filename, bool $needResetStat = true): bool
  {
    if ($needResetStat) {
      clearstatcache();
    }

    if (file_exists($filename) && is_file($filename)) {
      return true;
    } else {
      return false;
    }
  }
}
