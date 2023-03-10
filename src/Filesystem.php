<?php declare(strict_types=1);

namespace belomaxorka\Filesystem;

use DirectoryIterator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use belomaxorka\Filesystem\Exceptions\FileAlreadyExistsException;
use belomaxorka\Filesystem\Exceptions\FileCannotRemovedException;
use belomaxorka\Filesystem\Exceptions\FileNotFoundException;
use belomaxorka\Filesystem\Exceptions\FileCannotCreatedException;

use belomaxorka\Filesystem\Exceptions\FolderCannotRemovedException;
use belomaxorka\Filesystem\Exceptions\FolderAlreadyExistsException;
use belomaxorka\Filesystem\Exceptions\FolderCannotCreatedException;
use belomaxorka\Filesystem\Exceptions\FolderNotFoundException;

/**
 * PHP Filesystem - PHP library for file and directory management. Provides basic methods for the filesystem
 *
 * @author belomaxorka
 * @version v0.0.4
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
class Filesystem
{
  /**
   * Reset file stat cache (More: https://www.php.net/manual/en/function.clearstatcache.php)
   *
   * @since v0.0.5
   * @var bool
   */
  public static bool $needResetStat = true;

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
   * Make file
   *
   * @param string $filename Name of new file
   * @param bool $overwrite Overwrite file if exists
   * @return bool
   * @throws FileAlreadyExistsException|FileNotFoundException|FileCannotCreatedException|FileCannotRemovedException
   * @since v0.0.4
   */
  public static function makeFile(string $filename, bool $overwrite = false): bool
  {
    if (self::isFileExists($filename)) {
      if ($overwrite) {
        return (self::removeFile($filename) && self::makeFile($filename));
      }

      throw new FileAlreadyExistsException($filename);
    }

    if (touch($filename)) {
      return true;
    }

    throw new FileCannotCreatedException($filename);
  }

  /**
   * Make directory
   *
   * @param string $dirname Name of new folder
   * @param int $mode Permissions (Linux)
   * @return bool
   * @throws FolderAlreadyExistsException|FolderCannotCreatedException
   * @since v0.0.2
   */
  public static function makeDir(string $dirname, int $mode = 0777): bool
  {
    if (self::isDirExists($dirname)) {
      throw new FolderAlreadyExistsException($dirname);
    }

    if (mkdir($dirname, $mode, true)) {
      return true;
    }

    throw new FolderCannotCreatedException($dirname);
  }

  /**
   * Remove folder
   *
   * @param string $dirname Name of target folder
   * @param bool $recursively Remove sub-folders too
   * @return bool
   * @throws FolderNotFoundException|FileCannotRemovedException|FileNotFoundException|FolderCannotRemovedException
   * @since v0.0.4
   */
  public static function removeDir(string $dirname, bool $recursively = false): bool
  {
    if (!self::isDirEmpty($dirname)) {
      if ($recursively) {
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirname, FilesystemIterator::SKIP_DOTS)) as $object) {
          if (!self::removeFile($object->getRealPath())) {
            return false;
          }
        }

        return self::removeDir($dirname);
      }

      throw new FolderCannotRemovedException($dirname);
    }

    if (rmdir($dirname)) {
      return true;
    }

    throw new FolderCannotRemovedException($dirname);
  }

  /**
   * Remove file
   *
   * @param string $filename Name of target file
   * @return bool
   * @throws FileCannotRemovedException|FileNotFoundException
   * @since v0.0.3
   */
  public static function removeFile(string $filename): bool
  {
    if (!self::isFileExists($filename)) {
      throw new FileNotFoundException($filename);
    }

    if (unlink($filename)) {
      return true;
    }

    throw new FileCannotRemovedException($filename);
  }

  /**
   * Return size of directory
   *
   * @param string $dirname Name of target folder
   * @param bool $humanFormat Use human-readable file size
   * @return int|string
   * @throws FolderNotFoundException
   * @since v0.0.1
   */
  public static function getDirSize(string $dirname, bool $humanFormat = false): int|string
  {
    $bytesTotal = 0;

    if (!self::isDirEmpty($dirname)) {
      foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirname, FilesystemIterator::SKIP_DOTS)) as $object) {
        $bytesTotal += $object->getSize();
      }
    }

    return ($humanFormat ? self::humanFormatSize($bytesTotal) : $bytesTotal);
  }

  /**
   * Return size of file
   *
   * @param string $filename Name of target file
   * @param bool $humanFormat Use human-readable file size
   * @return int|string
   * @throws FileNotFoundException
   * @since v0.0.2
   */
  public static function getFileSize(string $filename, bool $humanFormat = false): int|string
  {
    if (!self::isFileExists($filename)) {
      throw new FileNotFoundException($filename);
    }

    return ($humanFormat ? self::humanFormatSize((int)filesize($filename)) : (int)filesize($filename));
  }

  /**
   * Returns directory contents
   *
   * @param string $dirname Name of target folder
   * @param bool $includeDirs Include folders in result
   * @return array
   * @throws FolderNotFoundException
   * @since v0.0.1
   */
  public static function getListOfDirContents(string $dirname, bool $includeDirs = false): array
  {
    $filesArray = [];

    if (!self::isDirEmpty($dirname)) {
      foreach (new DirectoryIterator($dirname) as $file) {
        if ($file->isFile() || ($includeDirs && $file->isDir() && !$file->isDot())) {
          $filesArray[] = $file->getFilename();
        }
      }
    }

    return $filesArray;
  }

  /**
   * Convert bytes to be human-readable format.
   *
   * @param int $bytes Size in bytes
   * @param int|null $precision Precision of rounding size
   * @return string
   * @since v0.0.3
   */
  public static function humanFormatSize(int $bytes, int $precision = null): string
  {
    for ($i = 0; ($bytes / self::HUMAN_FORMAT_SIZE['BYTE_NEXT']) >= 0.9 && $i < count(self::HUMAN_FORMAT_SIZE['BYTE_UNITS']); $i++) {
      $bytes /= self::HUMAN_FORMAT_SIZE['BYTE_NEXT'];
    }

    return (round($bytes, is_null($precision) ? self::HUMAN_FORMAT_SIZE['BYTE_PRECISION'][$i] : $precision) . self::HUMAN_FORMAT_SIZE['BYTE_UNITS'][$i]);
  }

  /**
   * Return true if directory is writable
   *
   * @param string $dirname Name of target folder
   * @return bool
   * @throws FolderNotFoundException
   * @since v0.0.3
   */
  public static function isDirWritable(string $dirname): bool
  {
    if (!self::isDirExists($dirname)) {
      throw new FolderNotFoundException($dirname);
    }

    return is_writable($dirname);
  }

  /**
   * Return true if directory is readable
   *
   * @param string $dirname Name of target folder
   * @return bool
   * @throws FolderNotFoundException
   * @since v0.0.3
   */
  public static function isDirReadable(string $dirname): bool
  {
    if (!self::isDirExists($dirname)) {
      throw new FolderNotFoundException($dirname);
    }

    return is_readable($dirname);
  }

  /**
   * Return true if file is writable
   *
   * @param string $filename Name of target file
   * @return bool
   * @throws FileNotFoundException
   * @since v0.0.3
   */
  public static function isFileWritable(string $filename): bool
  {
    if (!self::isFileExists($filename)) {
      throw new FileNotFoundException($filename);
    }

    return is_writable($filename);
  }

  /**
   * Return true if file is readable
   *
   * @param string $filename Name of target file
   * @return bool
   * @throws FileNotFoundException
   * @since v0.0.3
   */
  public static function isFileReadable(string $filename): bool
  {
    if (!self::isFileExists($filename)) {
      throw new FileNotFoundException($filename);
    }

    return is_readable($filename);
  }

  /**
   * Return true if directory is empty
   *
   * @param string $dirname Name of target folder
   * @return bool
   * @throws FolderNotFoundException
   * @since v0.0.2
   */
  public static function isDirEmpty(string $dirname): bool
  {
    if (!self::isDirExists($dirname)) {
      throw new FolderNotFoundException($dirname);
    }

    return !(new FilesystemIterator($dirname))->valid();
  }

  /**
   * Return true if file is empty
   *
   * @param string $filename Name of target file
   * @return bool
   * @throws FileNotFoundException
   * @since v0.0.2
   */
  public static function isFileEmpty(string $filename): bool
  {
    if (!self::isFileExists($filename)) {
      throw new FileNotFoundException($filename);
    }

    return ((int)filesize($filename) === 0);
  }

  /**
   * Return true if directory exists
   *
   * @param string $dirname Name of target folder
   * @return bool
   * @since v0.0.2
   */
  public static function isDirExists(string $dirname): bool
  {
    if (self::$needResetStat) {
      clearstatcache();
    }

    return (is_dir($dirname) && file_exists($dirname));
  }

  /**
   * Return true if file exists
   *
   * @param string $filename Name of target file
   * @return bool
   * @since v0.0.2
   */
  public static function isFileExists(string $filename): bool
  {
    if (self::$needResetStat) {
      clearstatcache();
    }

    return (is_file($filename) && file_exists($filename));
  }
}
