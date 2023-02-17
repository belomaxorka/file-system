<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use belomaxorka\Filesystem\Filesystem;

/**
 * PHP Filesystem - PHP library for file and directory management. Provides basic methods for the filesystem
 *
 * @author belomaxorka
 * @version v0.0.4
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
   * File exists check
   *
   * @return void
   * @throws Exception
   * @since 0.0.4
   */
  public function testIsFileExists(): void
  {
    $this->assertTrue(self::$fileObject::isFileExists(__FILE__));
    $this->assertFalse(self::$fileObject::isFileExists(__DIR__));
    $this->assertFalse(self::$fileObject::isFileExists((string)random_int(10, 100)));
  }

  /**
   * Folder exists check
   *
   * @return void
   * @throws Exception
   * @since 0.0.4
   */
  public function testIsFolderExists(): void
  {
    $this->assertTrue(self::$fileObject::isDirExists(__DIR__));
    $this->assertFalse(self::$fileObject::isDirExists(__FILE__));
    $this->assertFalse(self::$fileObject::isDirExists((string)random_int(10, 100)));
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
