# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [1.0.0] - 2025-11-22

### Added

- Initial release.
- DI override of `Magento\Developer\Console\Command\DevTestsRunCommand` to run
  developer tests through ParaTest.
- `--processes` option to set the number of ParaTest worker processes.
- `--runner` option to select the ParaTest runner (default: `WrapperRunner`).
- Support for static, unit, integration and integrity test suites.

[1.0.0]: https://github.com/CleatSquad/module-parallel-tests-plus/releases/tag/v1.0.0
