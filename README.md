<div align="center" style="padding-bottom: 48px">
  <a href="https://assegaiphp.com/" target="blank"><img src="https://assegaiphp.com/images/logos/logo-cropped.png" width="200" alt="AssegaiPHP Logo"></a>
</div>

<p align="center">
  <a href="https://github.com/assegaiphp/util/releases"><img alt="Latest release" src="https://img.shields.io/github/v/release/assegaiphp/util?display_name=tag&sort=semver&style=flat-square"></a>
  <a href="https://github.com/assegaiphp/util/actions/workflows/php.yml"><img alt="Tests" src="https://img.shields.io/github/actions/workflow/status/assegaiphp/util/php.yml?branch=main&label=tests&style=flat-square"></a>
  <img alt="PHP 8.4+" src="https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=flat-square&logo=php&logoColor=white">
  <a href="https://github.com/assegaiphp/util/blob/main/LICENSE"><img alt="License" src="https://img.shields.io/github/license/assegaiphp/util?style=flat-square"></a>
  <img alt="Status active" src="https://img.shields.io/badge/status-active-10b981?style=flat-square">
</p>

# AssegaiPHP Util

<p align="center">Focused array, text, path, and naming helpers used across AssegaiPHP.</p>

`assegaiphp/util` contains lightweight utilities shared by the framework and its tooling. It can also be installed independently in PHP 8.4 applications.

## Requirements

- PHP 8.4 or newer

## Installation

```bash
composer require assegaiphp/util
```

## Usage

```php
use Assegai\Util\ArrayUtil;

$values = [1, 2, 3, 4, 5];

if (ArrayUtil::contains(3, $values)) {
  // The value is present.
}
```

The package also exposes `Text` and `Path` helpers plus shared naming functions loaded through Composer.

## Contributing

For contribution and pull request conventions, see [Commit and PR Guidelines](./docs/commit-and-pr-guidelines.md).

## License

AssegaiPHP Util is [MIT licensed](LICENSE).
