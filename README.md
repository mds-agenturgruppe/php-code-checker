# mds PHP Code Checker

`mds-code-check` is a CLI tool for running PHP 8.x code checks for Pimcore 11 and Symfony 6 with configurable rule sets with:

- [PHPStan](https://phpstan.org/)
  - [PHPStan Symfony Framework](https://github.com/phpstan/phpstan-symfony)
  - [PHPStan Rules](https://github.com/symplify/phpstan-rules)
- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
- [PHPMD](https://github.com/phpmd/phpmd)

## Installation

```
composer require --dev mds-agenturgruppe/php-code-checker:^3.0
```

## Getting Started

After successfully installation run this command:

```
vendor/bin/mds-code-check
```

This will execute code checks with the default ruleset, which is intended for code checks of [Pimcore 11](https://github.com/pimcore) projects.

## Configuring rule sets

### Rule sets

Rule sets define which checks and the arguments are used for a project when running the `mds-code-check` script. By
default [`rulesets/pimcore11/ruleset.conf`](rulesets/pimcore11/ruleset.conf) is used.

#### Configuration variables

Ruleset files define variables to configure the executed checks.

- Enable (`1`) or disable (`0`) checks:
  - `PHPSTAN`, `PHPCS`, `PHPMD`
- Arguments for each check:
  - `PHPSTAN_ARGS`, `PHPCS_ARGS`, `PHPMD_ARGS`

## Project configuration

`mds-code-check` can be adapted to project specific needs.

### Used ruleset

The used ruleset is configured by placing `.mds-code-checker.conf` into the project root folder defining the `RULESET` variable with the ruleset file to use.

```
RULESET="./vendor/mds-agenturgruppe/php-code-checker/rulesets/pimcore11/ruleset.conf";
```

### Adapting ruleset

In the project configuration file `.mds-code-checker.conf` the used ruleset can be adjusted as needed by overwriting the defining variables.

Example for disabling checks and changing arguments:

```
RULESET="./vendor/mds-agenturgruppe/php-code-checker/rulesets/pimcore11/ruleset.conf";
PHPSTAN_ARGS="--level=9 analyse bundles"
PHPCS_ARGS="--extensions=php --standard=./src/project-phpcs-ruleset.xml ./src -s"
PHPMD_ARGS="./src text --standard=./src/project-phpmp-ruleset.xml --exclude=\"*/Resources/views/*\""
```

## `mds-code-check` arguments

In development or analysis process it is sometimes useful to only execute some tests. This can be achieved by passing check names as arguments to `mds-code-check`.

Only execute phpstan:

```
vendor/bin/mds-code-check phpstan
```

Only execute PHP_CodeSniffer and phpmd:

```
vendor/bin/mds-code-check phpcs phpmd
```

## CI pipeline integration

For usage in CI pipelines and failing code check stages `mds-code-check` returns exit code `1` if at least one of the executed check script returns exit code `1`. If all checks are
successful exit code `0` is returned.
