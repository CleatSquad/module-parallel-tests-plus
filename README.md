# CleatSquad ParallelTestsPlus

A Magento 2 extension that enhances the core `dev:tests:run` command by enabling **parallel execution** of developer tests using **ParaTest**.

This module significantly reduces execution time for static, unit, integration and integrity tests — with zero core overrides and full CI/CD compatibility.

## Badges

[![Latest Stable Version](http://poser.pugx.org/cleatsquad/module-parallel-tests-plus/v)](https://packagist.org/packages/cleatsquad/module-parallel-tests-plus)
[![Total Downloads](http://poser.pugx.org/cleatsquad/module-parallel-tests-plus/downloads)](https://packagist.org/packages/cleatsquad/module-parallel-tests-plus)
[![Latest Unstable Version](http://poser.pugx.org/cleatsquad/module-parallel-tests-plus/v/unstable)](https://packagist.org/packages/cleatsquad/module-parallel-tests-plus)
[![License](http://poser.pugx.org/cleatsquad/module-parallel-tests-plus/license)](https://packagist.org/packages/cleatsquad/module-parallel-tests-plus)

---

## ✨ Features

- 🚀 **Parallel execution** of Magento developer tests.
- 🔧 Adds `--processes` to set worker count.
- 🧵 Adds `--runner` option (default: `WrapperRunner`).
- ⚙ Fully compatible with Magento’s native `--arguments` passthrough.
- 🧩 Supports all Magento test categories:
    - Static Test Suites (Default, Legacy, JS Exemplar)
    - Unit Tests (Framework + Integration Layer)
    - Integration Tests
    - Integrity Tests
- 🛡 Clean DI override of:
  ```
  Magento\Developer\Console\Command\DevTestsRunCommand
  ```
- 🎯 No core hacks. Safe for production and CI pipelines.

---

## 📦 Installation

You can install this module using Composer (recommended) or manually.

---

### 🔹 1. Install via Composer (recommended)

Requires Packagist entry:

```
composer require cleatsquad/module-parallel-tests-plus --dev
```

Then upgrade Magento:

```
bin/magento setup:upgrade
```

### 🔹 2. Manual installation (app/code)

Copy the module

```
app/code/CleatSquad/ParallelTestsPlus
```

Require ParaTest

```
composer require --dev brianium/paratest
```

Then upgrade Magento:

```
bin/magento setup:upgrade
```

---

## 🚀 Usage

### Run static tests with 8 workers

```
bin/magento dev:tests:run static --processes=8
```

### Run unit tests with 3 workers

```
bin/magento dev:tests:run unit --processes=3
```

### Run all developer tests in parallel

```
bin/magento dev:tests:run all --processes=8
```

### Use a custom runner

```
bin/magento dev:tests:run static --runner=WrapperRunner
```

### Pass arguments to ParaTest/PHPUnit via Magento native `--arguments`

```
bin/magento dev:tests:run static -c "--filter=MyTest"
```

---

## 🤝 Support & Contributions

Issues and pull requests are welcome.

GitHub:  
https://github.com/CleatSquad/module-parallel-tests-plus


---

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/cleatsquad/module-parallel-tests-plus/tags).

---

## 🙏 Acknowledgements

This module is powered by the excellent ParaTest project:

➡️ https://github.com/paratestphp/paratest

ParaTest enables efficient parallel execution of PHPUnit tests and is essential to the performance improvements provided by this module.

---

## Authors

* **Mohamed El Mrabet** - *Initial work* - [mimou78](https://github.com/mimou78)

---

## 📜 License

Released under the **MIT License**.  
See the `LICENSE.txt` file for full details.

© 2025 - CleatSquad (https://cleatsquad.dev)
