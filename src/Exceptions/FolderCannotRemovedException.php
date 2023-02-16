<?php declare(strict_types=1);

namespace belomaxorka\Filesystem\Exceptions;

use Exception;

/**
 * PHP Filesystem - PHP library for file and directory management. Provides basic methods for the filesystem
 *
 * @author belomaxorka
 * @version v0.0.3
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
class FolderCannotRemovedException extends Exception
{
  /**
   * FolderCannotRemovedException constructor
   *
   * @param string|bool $path Include path to file in error message
   * @since v0.0.3
   */
  public function __construct($path = false)
  {
    parent::__construct(
      ($path ? sprintf('Folder (%s) cannot be removed.', $path) : 'Folder cannot be removed.')
    );
  }
}
