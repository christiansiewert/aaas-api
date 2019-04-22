# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- some database fixtures and test data

### Changed

- integration of pdepend ci tool
- excluding of src/Migrations directory for ci tools
- ci improvements
- length property of ServiceFields is now an integer

## [0.0.5] - 2019-04-21

### Added

- introduced api filter for some entities
- integrated ci tools and updated docs

## [0.0.4] - 2019-04-20

### Added

- field options, field asserts and field assert options entities

### Changed

- Services now have a `type` field with which the type can be distinguished (list, tree, etc.) 

## [0.0.3] - 2019-04-20

### Added

- gedmo tree for representing trees in the database
- Repository, Service and ServiceField entities

## [0.0.2] - 2019-04-16

### Added

- jwt authentication
- projects and customer entity

## [0.0.1] - 2019-03-31

### Added

- base app

[Unreleased]: https://github.com/siewert87/aaas-api/compare/v0.0.5...HEAD
[0.0.5]: https://github.com/siewert87/aaas-api/compare/v0.0.4...v0.0.5
[0.0.4]: https://github.com/siewert87/aaas-api/compare/v0.0.3...v0.0.4
[0.0.3]: https://github.com/siewert87/aaas-api/compare/v0.0.2...v0.0.3
[0.0.2]: https://github.com/siewert87/aaas-api/compare/v0.0.1...v0.0.2
[0.0.1]: https://github.com/siewert87/aaas-api/releases/tag/v0.0.1