# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Feature

- Exclude pattern `*/node_modules*/` PHP_CodeSniffer and PHPMD rule sets

## [3.1.0] - 2023-12-01

### Feature

- PHP_CodeSniffer checks based on PSR12

## [3.0.0] - 2023-11-15

### Feature

- Use `phpstan/phpstan`
- Remove outdated packages:
  - `sebastian/phpcpd`
  - `php-censor/phpdoc-checker`,
  - `phploc/phploc`

## [2.1.1] - 2023-10-11

### Fix

- Lock `phpmd/phpmd` to v2.13.0

## [2.1.0] - 2022-09-23

- Add PHPDoc Checker https://github.com/php-censor/phpdoc-checker

## [2.0.0] - 2022-05-30

- PHP 8 and Pimcore 10 support
