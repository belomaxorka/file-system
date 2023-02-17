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
   * Example content
   */
  const FOLDER_EXAMPLE = __DIR__ . '/example';
  const FILE_EXAMPLE = self::FOLDER_EXAMPLE . '/example.txt';

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
   * Make folder check
   *
   * @return void
   * @throws Exception
   * @since 0.0.4
   */
  public function testMakeDir(): void
  {
    $this->assertTrue(self::$fileObject::makeDir(self::FOLDER_EXAMPLE));
    $this->assertFileExists(self::FOLDER_EXAMPLE);
  }

  /**
   * Folder is empty check
   *
   * @return void
   * @throws Exception
   * @since 0.0.4
   */
  public function testIsEmptyDir(): void
  {
    $this->assertTrue(self::$fileObject::isDirEmpty(self::FOLDER_EXAMPLE));
  }

  /**
   * Make file check
   *
   * @return void
   * @throws Exception
   * @since 0.0.4
   */
  public function testMakeFile(): void
  {
    $this->assertTrue(self::$fileObject::makeFile(self::FILE_EXAMPLE));
    $this->assertFileExists(self::FILE_EXAMPLE);
  }

  /**
   * File is empty check
   *
   * @return void
   * @throws Exception
   * @since 0.0.4
   */
  public function testIsEmptyFile(): void
  {
    $this->assertTrue(self::$fileObject::isFileEmpty(self::FILE_EXAMPLE));
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
    $this->assertTrue(self::$fileObject::isFileExists(self::FILE_EXAMPLE));
    $this->assertFalse(self::$fileObject::isFileExists(self::FOLDER_EXAMPLE));
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
    $this->assertTrue(self::$fileObject::isDirExists(self::FOLDER_EXAMPLE));
    $this->assertFalse(self::$fileObject::isDirExists(self::FILE_EXAMPLE));
    $this->assertFalse(self::$fileObject::isDirExists((string)random_int(10, 100)));
  }

  /**
   * Remove file check
   *
   * @return void
   * @throws Exception
   * @since 0.0.4
   */
  public function testRemoveFile(): void
  {
    $this->assertTrue(self::$fileObject::removeFile(self::FILE_EXAMPLE));
    $this->assertFileDoesNotExist(self::FILE_EXAMPLE);
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
