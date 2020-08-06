# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Builder support for api filters and filter properties
- Introduced standard sets of serialized and deserialized object attributes for our entities

### Changed

- Route prefix for application API (now on /aaas)  
- Route prefixes for some entities
- Revised documentation and wiki
- Redesigned serialization groups
- targetEntity attribute in field relations is now a service relation

## [1.3.0] - 2020-03-28

### Added

- added @ApiSubresource annotation for tree entities
- builder support for validating constraints and theire options

## [1.2.0] - 2020-01-28

### Changed

- fixed some coding issues and continuous integration stuff
- database table name conventions

## [1.1.0] - 2019-12-21

### Changed

- Upgraded to Symfony 5

## [1.0.0] - 2019-09-16

### Added

- migrator actions for clearing application cache and migrating database

## [0.5.0] - 2019-07-25

### Added

- first parts of our documentation (https://aaas-api.readthedocs.io)
- serialization groups for our entities
- API filter for some entities
- validation constraints for some entities
- project repository prefix for generated api routes

## [0.4.0] - 2019-07-07

### Added

- route prefix for application API
- route prefix for generated API
- table name prefix for generated database tables

## [0.3.0] - 2019-07-06

### Changed

- directory structure for generated API source code
- generated API will be dumped to src/Aaas now

## [0.2.0] - 2019-07-06

### Added

- builder now can generate nested set entities and nested set repositories

### Changed

- Kicked fos/user-bundle and implemented own user entity

## [0.1.0] - 2019-07-06

### Added

- build directory
- code generator for entities
- code generator for repositories
- code generator for field relations
- field options now have specific options (default value, unsigned for integers, comment)

## [0.0.9] - 2019-05-02

### Added

- Service fields now can contain relational connections to other service fields

### Changed

- Improvements to docker-compose.yml

## [0.0.8] - 2019-04-30

### Added

- Check for valid data types in service fields
- added more valid data types

### Changed

- Naming of entities
- Modularized database tables

## [0.0.7] - 2019-04-24

### Added

- Entity tests

## [0.0.6] - 2019-04-22

### Added

- some database fixtures and test data
- .travis-ci.yml for ci on travis-ci.org

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

[Unreleased]: https://github.com/christiansiewert/aaas-api/compare/v1.3.0...develop
[1.3.0]: https://github.com/christiansiewert/aaas-api/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/christiansiewert/aaas-api/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/christiansiewert/aaas-api/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/christiansiewert/aaas-api/compare/v0.5.0...v1.0.0
[0.5.0]: https://github.com/christiansiewert/aaas-api/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/christiansiewert/aaas-api/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/christiansiewert/aaas-api/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/christiansiewert/aaas-api/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/christiansiewert/aaas-api/compare/v0.0.9...v0.1.0
[0.0.9]: https://github.com/christiansiewert/aaas-api/compare/v0.0.8...v0.0.9
[0.0.8]: https://github.com/christiansiewert/aaas-api/compare/v0.0.7...v0.0.8
[0.0.7]: https://github.com/christiansiewert/aaas-api/compare/v0.0.6...v0.0.7
[0.0.6]: https://github.com/christiansiewert/aaas-api/compare/v0.0.5...v0.0.6
[0.0.5]: https://github.com/christiansiewert/aaas-api/compare/v0.0.4...v0.0.5
[0.0.4]: https://github.com/christiansiewert/aaas-api/compare/v0.0.3...v0.0.4
[0.0.3]: https://github.com/christiansiewert/aaas-api/compare/v0.0.2...v0.0.3
[0.0.2]: https://github.com/christiansiewert/aaas-api/compare/v0.0.1...v0.0.2
[0.0.1]: https://github.com/christiansiewert/aaas-api/releases/tag/v0.0.1