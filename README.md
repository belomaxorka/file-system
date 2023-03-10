<h1 align="center">Filesystem</h1>
<p align="center">PHP library for file and directory management. Provides basic methods for the filesystem 📁</p>

<p align="center">
	<a href="https://packagist.org/packages/belomaxorka/file-system"><img src="https://img.shields.io/packagist/v/belomaxorka/file-system" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/torrentpier/torrentpier"><img src="https://img.shields.io/packagist/stars/belomaxorka/file-system" alt="Stars"></a>
	<a href="https://packagist.org/packages/belomaxorka/file-system/stats"><img src="https://img.shields.io/packagist/dt/belomaxorka/file-system" alt="Total Downloads"></a>
	<a href="https://choosealicense.com/licenses/mit/"><img src="https://img.shields.io/github/license/belomaxorka/file-system" alt="License"></a>
  <img src="https://img.shields.io/github/repo-size/belomaxorka/file-system" alt="Size">
</p>

[![Stand With Ukraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://stand-with-ukraine.pp.ua)

<hr>

## Methods

### makeFile

```php
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
```

### makeDir

```php
/**
 * Make directory
 *
 * @param string $dirname Name of new folder
 * @param int $mode Permissions (Linux)
 * @return bool
 * @throws FolderCannotRemovedException|FolderAlreadyExistsException
 * @since v0.0.2
 */
public static function makeDir(string $dirname, int $mode = 0777): bool
```

### removeDir

```php
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
```

### removeFile

```php
/**
 * Remove file
 *
 * @param string $filename Name of target file
 * @return bool
 * @throws FileCannotRemovedException|FileNotFoundException
 * @since v0.0.3
 */
public static function removeFile(string $filename): bool
```

### getDirSize

```php
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
```

### getFileSize

```php
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
```

### getListOfDirContents

```php
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
```

### humanFormatSize

```php
/**
 * Convert bytes to be human-readable format.
 *
 * @param int $bytes Size in bytes
 * @param int|null $precision Precision of rounding size
 * @return string
 * @since v0.0.3
 */
public static function humanFormatSize(int $bytes, int $precision = null): string
```

### isDirWritable

```php
/**
 * Return true if directory is writable
 *
 * @param string $dirname Name of target folder
 * @return bool
 * @throws FolderNotFoundException
 * @since v0.0.3
 */
public static function isDirWritable(string $dirname): bool
```

### isDirReadable

```php
/**
 * Return true if directory is readable
 *
 * @param string $dirname Name of target folder
 * @return bool
 * @throws FolderNotFoundException
 * @since v0.0.3
 */
public static function isDirReadable(string $dirname): bool
```

### isFileWritable

```php
/**
 * Return true if file is writable
 *
 * @param string $filename Name of target file
 * @return bool
 * @throws FileNotFoundException
 * @since v0.0.3
 */
public static function isFileWritable(string $filename): bool
```

### isFileReadable

```php
/**
 * Return true if file is readable
 *
 * @param string $filename Name of target file
 * @return bool
 * @throws FileNotFoundException
 * @since v0.0.3
 */
public static function isFileReadable(string $filename): bool
```

### isDirEmpty

```php
/**
 * Return true if directory is empty
 *
 * @param string $dirname Name of target folder
 * @return bool
 * @throws FolderNotFoundException
 * @since v0.0.2
 */
public static function isDirEmpty(string $dirname): bool
```

### isFileEmpty

```php
/**
 * Return true if file is empty
 *
 * @param string $filename Name of target file
 * @return bool
 * @throws FileNotFoundException
 * @since v0.0.2
 */
public static function isFileEmpty(string $filename): bool
```

### isDirExists

```php
/**
 * Return true if directory exists
 *
 * @param string $dirname Name of target folder
 * @return bool
 * @since v0.0.2
 */
public static function isDirExists(string $dirname): bool
```

### isFileExists

```php
/**
 * Return true if file exists
 *
 * @param string $filename Name of target file
 * @return bool
 * @since v0.0.2
 */
public static function isFileExists(string $filename): bool
```

## License

This repository is licensed under the [MIT License](LICENSE).

Copyright © 2023, [belomaxorka](https://github.com/belomaxorka)
