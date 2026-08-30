# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [1.1.0] - 2026-08-30

### Added

- CI pipeline (PHPStan, PHP-CS-Fixer, PHPUnit) via GitHub Actions.
- `CONTRIBUTING.md` and `SECURITY.md`.
- `phpunit.xml.dist`, `phpstan.neon.dist` and `.php-cs-fixer.dist.php`.

### Fixed

- The command no longer silently `chdir()`s into a missing `dev/tests/*`
  directory; it now reports the missing directory and fails that suite
  instead of possibly running paratest from an unintended working directory.

### Changed

- Clarified in the README that the DI override is a declarative `preference`
  (not "zero core overrides"), and documented that installing via Composer
  requires a Magento Marketplace `auth.json`.

## [1.0.0] - 2025-11-22

### Added

- Initial release.
- DI override of `Magento\Developer\Console\Command\DevTestsRunCommand` to run
  developer tests through ParaTest.
- `--processes` option to set the number of ParaTest worker processes.
- `--runner` option to select the ParaTest runner (default: `WrapperRunner`).
- Support for static, unit, integration and integrity test suites.

[1.1.0]: https://github.com/CleatSquad/module-parallel-tests-plus/releases/tag/v1.1.0
[1.0.0]: https://github.com/CleatSquad/module-parallel-tests-plus/releases/tag/v1.0.0
