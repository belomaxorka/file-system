<?php declare(strict_types=1);

namespace belomaxorka\Filesystem\Exceptions;

use Exception;

/**
 * PHP Filesystem - PHP library for file and directory management. Provides basic methods for the filesystem
 *
 * @author belomaxorka
 * @version v0.0.4
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
class FolderCannotCreatedException extends Exception
{
  /**
   * FolderCannotCreatedException constructor
   *
   * @param string|bool $path Include path to file in error message
   * @since v0.0.3
   */
  public function __construct($path = false)
  {
    parent::__construct(
      ($path ? sprintf('Folder (%s) cannot be created.', $path) : 'Folder cannot be created.')
    );
  }
}
