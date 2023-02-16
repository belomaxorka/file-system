<?php declare(strict_types=1);

namespace belomaxorka\Filesystem;

use Exception;
use Throwable;

/**
 * PHP Filesystem - PHP library for file and directory management. Provides basic methods for the filesystem
 *
 * @author belomaxorka
 * @version v0.0.3
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
class FilesystemException extends Exception
{
  /**
   * Exceptions list
   *
   * @since v0.0.3
   */
  private const EXCEPTIONS_LIST = [
    'fileNotFound' => 'File could not be found.',
    'fileAlreadyExists' => 'File already exists.',
    'folderNotFound' => 'Folder could not be found.',
    'folderAlreadyExists' => 'Folder already exists.'
  ];

  /**
   * FilesystemException constructor
   *
   * @param string $message
   * @since v0.0.3
   */
  public function __construct(string $message)
  {
    parent::__construct(
      array_key_exists($message, self::EXCEPTIONS_LIST) ?
        self::EXCEPTIONS_LIST[$message] : $message
    );
  }
}
