# Contributing

Thanks for considering a contribution to `module-parallel-tests-plus`.

## Getting started

```bash
git clone https://github.com/CleatSquad/module-parallel-tests-plus.git
cd module-parallel-tests-plus
composer install
```

> Resolving `magento/module-developer` requires a valid Magento Marketplace
> `auth.json` (see the README's Installation section).

## Running the tests

```bash
composer test
```

or directly:

```bash
vendor/bin/phpunit --testsuite unit
```

## Submitting changes

1. Fork the repository and create a branch from `master`.
2. Keep changes focused — one topic per pull request.
3. Add or update unit tests for any behavior change in
   `Console/DevTestsRunCommand.php`.
4. Make sure `composer test` passes before opening the PR.
5. Describe the *why* of the change in the PR description, not just the *what*.

## Reporting bugs

Open an issue at
https://github.com/CleatSquad/module-parallel-tests-plus/issues with the
Magento version, PHP version, the command you ran, and the full output.

## Security issues

Do not open a public issue for a security vulnerability — see
[SECURITY.md](SECURITY.md).
