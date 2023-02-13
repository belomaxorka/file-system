<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use belomaxorka\Filesystem\Filesystem;

/**
 * PHP Filesystem - PHP library for file and directory management. Provides basic methods for the filesystem
 *
 * @author belomaxorka
 * @version v0.0.2
 * @link https://github.com/belomaxorka/file-system
 * @license MIT
 */
final class FilesystemTest extends TestCase
{
  /**
   * Filesystem object
   *
   * @var Filesystem
   * @since 0.0.2
   */
  private static Filesystem $fileObject;

  /**
   * Init instance
   *
   * @return void
   * @since 0.0.2
   */
  public static function setUpBeforeClass(): void
  {
    self::$fileObject = new Filesystem();
  }

  /**
   * Check if it is an instance of fileObject.
   *
   * @return void
   * @since 0.0.2
   */
  public function testIsInstanceOfObject(): void
  {
    $this->assertInstanceOf('belomaxorka\Filesystem\Filesystem', self::$fileObject);
  }

  /**
   * Unset instance
   *
   * @return void
   * @since 0.0.2
   */
  public static function tearDownAfterClass(): void
  {
    self::$fileObject = null;
  }
}
