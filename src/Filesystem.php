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
 * @version v0.0.3
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
class Filesystem
{
  /**
   * Params for humanFormatSize method
   *
   * @since v0.0.3
   */
  private const HUMAN_FORMAT_SIZE = [
    'BYTE_UNITS' => ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"],
    'BYTE_PRECISION' => [0, 0, 1, 2, 2, 3, 3, 4, 4],
    'BYTE_NEXT' => 1024
  ];

  /**
   * Make directory
   *
   * @param string $dirname
   * @param int $mode
   * @param bool $needResetStat
   * @return bool
   * @throws FilesystemException
   * @since v0.0.2
   */
  public static function makeDir(string $dirname, int $mode = 0777, bool $needResetStat = true): bool
  {
    if (!self::isDirExists($dirname, $needResetStat)) {
      return mkdir($dirname, $mode, true);
    }

    throw new FilesystemException('folderAlreadyExists');
  }

  /**
   * Return size of directory
   *
   * @param string $dirname
   * @param bool $humanFormat
   * @param bool $needResetStat
   * @return int|string
   * @throws FilesystemException
   * @since v0.0.1
   */
  public static function getDirSize(string $dirname, bool $humanFormat = false, bool $needResetStat = true): int|string
  {
    $bytesTotal = 0;

    if (self::isDirExists($dirname, $needResetStat)) {
      foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirname, FilesystemIterator::SKIP_DOTS)) as $object) {
        $bytesTotal += $object->getSize();
      }
    } else {
      throw new FilesystemException('folderNotFound');
    }

    return $humanFormat ? self::humanFormatSize($bytesTotal) : $bytesTotal;
  }

  /**
   * Return size of file
   *
   * @param string $filename
   * @param bool $humanFormat
   * @param bool $needResetStat
   * @return int|string
   * @throws FilesystemException
   * @since v0.0.2
   */
  public static function getFileSize(string $filename, bool $humanFormat = false, bool $needResetStat = true): int|string
  {
    if (self::isFileExists($filename, $needResetStat)) {
      return $humanFormat ? self::humanFormatSize((int)filesize($filename)) : (int)filesize($filename);
    } else {
      throw new FilesystemException('fileNotFound');
    }
  }

  /**
   * Returns directory contents
   *
   * @param string $dirname
   * @param bool $includeDirs
   * @param bool $needResetStat
   * @return array
   * @throws FilesystemException
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
      throw new FilesystemException('folderNotFound');
    }

    return $filesArray;
  }

  /**
   * Convert bytes to be human-readable.
   *
   * @param int $bytes
   * @param int|null $precision
   * @return string
   * @since v0.0.3
   */
  public static function humanFormatSize(int $bytes, int $precision = null): string
  {
    for ($i = 0; ($bytes / self::HUMAN_FORMAT_SIZE['BYTE_NEXT']) >= 0.9 && $i < count(self::HUMAN_FORMAT_SIZE['BYTE_UNITS']); $i++) $bytes /= self::HUMAN_FORMAT_SIZE['BYTE_NEXT'];

    return round($bytes, is_null($precision) ? self::HUMAN_FORMAT_SIZE['BYTE_PRECISION'][$i] : $precision) . self::HUMAN_FORMAT_SIZE['BYTE_UNITS'][$i];
  }

  /**
   * Return true if directory is empty
   *
   * @param string $dirname
   * @param bool $needResetStat
   * @return bool
   * @throws FilesystemException
   * @since v0.0.2
   */
  public static function isDirEmpty(string $dirname, bool $needResetStat = true): bool
  {
    if (self::isDirExists($dirname, $needResetStat)) {
      return !(new FilesystemIterator($dirname))->valid();
    } else {
      throw new FilesystemException('folderNotFound');
    }
  }

  /**
   * Return true if file is empty
   *
   * @param string $filename
   * @param bool $needResetStat
   * @return bool
   * @throws FilesystemException
   * @since v0.0.2
   */
  public static function isFileEmpty(string $filename, bool $needResetStat = true): bool
  {
    if (self::isFileExists($filename, $needResetStat)) {
      return ((int)filesize($filename) === 0);
    } else {
      throw new FilesystemException('fileNotFound');
    }
  }

  /**
   * Return true if directory exists
   *
   * @param string $dirname
   * @param bool $needResetStat
   * @return bool
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
