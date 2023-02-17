# Change Log

## [v0.0.3](https://github.com/torrentpier/torrentpier/tree/v0.0.3) (2023-02-17)

[Full Changelog](https://github.com/torrentpier/torrentpier/compare/v0.0.2...v0.0.3)

- Added methods list in README
- Added isFileWritable & isFileReadable methods
- Added isDirWritable & isDirReadable methods
- Added removeFile method
- Added humanFormatSize method
- Added $humanFormat argument for getDirSize & getFileSize
- Minor adjustments
- Updated PHPDocs for all methods
- Reworked exceptions

## [v0.0.2](https://github.com/torrentpier/torrentpier/tree/v0.0.2) (2023-02-16)

[Full Changelog](https://github.com/torrentpier/torrentpier/compare/v0.0.1...v0.0.2)

- Added isDirEmpty method
- Added isFileEmpty method
- Added isFileExists method
- Added isDirExists method
- Added getFileSize method
- Added makeDir method
- Added tests
- Added exceptions
- Added optional argument $needResetStat
- Added $includeDirs argument for getListOfDirContents method
- Added missing file_exists and is_dir checks for isDirEmpty method
- Added clearstatcache() functions for isDirEmpty method
- Removed realpath function from methods
- Rename from getListOfFiles to getListOfDirContents
- Minor improvements

## [v0.0.1](https://github.com/torrentpier/torrentpier/tree/v0.0.1) (2023-02-13)

- Added getDirSize method
- Added getListOfFiles method
