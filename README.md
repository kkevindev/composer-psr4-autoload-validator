# PSR-4 Autoload Validator

![PHPUnit Tests](https://github.com/kkevindev/composer-psr4-autoload-validator/actions/workflows/quality_assurance.yaml/badge.svg)
![Supported PHP Versions](https://img.shields.io/badge/PHP-^8.3-777BB4?logo=php&logoColor=white)

Small CLI tool that runs Composer's PSR-4 autoload script for the current project and prints/validates the results.

## Installation


```bash
composer require --dev kkevindev/composer-psr4-autoload-validator
```

## Usage

Run the binary from the root of the project you want to validate. <br> This is the directory where your `composer.json` file lives.

```bash
vendor/bin/kkevindev-composer-psr4-autoload-validator
```

