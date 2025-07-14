# mds PHP Code Checker

`mds-code-check` is a CLI tool for running PHP 8.x code checks for Symfony based applications with configurable rule sets with:

- [PHPStan](https://phpstan.org/)
  - [PHPStan Symfony Framework](https://github.com/phpstan/phpstan-symfony)
  - [PHPStan Rules](https://github.com/symplify/phpstan-rules)
- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
- [PHPMD](https://github.com/phpmd/phpmd)

## Installation

```
composer require --dev mds-agenturgruppe/php-code-checker:^4.0
```

## Getting Started

After successful installation run this command:

```
vendor/bin/mds-code-check
```

This will execute code checks with the default ruleset, which is intended for code checks of Symfony projects.

## Configuring rule sets

### Rule sets

Rule sets define which checks and the arguments are used for a project when running the `mds-code-check` script. By
default [`rulesets/default/ruleset.conf`](rulesets/default/ruleset.conf) is used.

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
RULESET="./vendor/mds-agenturgruppe/php-code-checker/rulesets/default/ruleset.conf";
```

### Adapting ruleset

In the project configuration file `.mds-code-checker.conf` the used ruleset can be adjusted as needed by overwriting the defining variables.

Example for disabling checks and changing arguments:

```
RULESET="./vendor/mds-agenturgruppe/php-code-checker/rulesets/default/ruleset.conf";
PHPSTAN_ARGS="--level=9 analyse bundles"
PHPCS_ARGS="--extensions=php --standard=./src/project-phpcs-ruleset.xml ./src -s"
PHPMD_ARGS="./src text --standard=./src/project-phpmp-ruleset.xml --exclude=\"*/Resources/views/*\""
```

## `mds-code-check` arguments

In the development or analysis process, it is sometimes useful to only execute some tests. This can be achieved by passing check names as arguments to `mds-code-check`.

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

---

# Rector

To run rector with our default config execute

```
vendor/bin/mds-rector
```
This will use config `rulesets/default/rector-default.php` and the `dry-run` option.

_Tip:_ For a better overview of the dry-run output forward this to a e.g. `> rector-run.diff` file and open that in sublime.

Use the option `--force-run` to apply all the changes.
```
vendor/bin/mds-rector --force-run
```

## Custom Config
To use a custom config for your project, you can copy `rulesets/default/rector-default.php` to `PROJECT_DIR/rector.php` and adjust that to your needs.

Then use the standard rector cli command.
```
vendor/bin/rector process --dry-run
```

For more information check: https://getrector.com/documentation
