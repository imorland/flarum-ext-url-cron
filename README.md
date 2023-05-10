# URL Cron

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/ianm/url-cron.svg)](https://packagist.org/packages/ianm/url-cron) [![Total Downloads](https://img.shields.io/packagist/dt/ianm/url-cron.svg)](https://packagist.org/packages/ianm/url-cron)

A [Flarum](http://flarum.org) extension. Expose the Flarum scheduler to a URL for use on shared hosting envs

## Installation

Install with composer:

```sh
composer require ianm/url-cron:"*"
```

## Updating

```sh
composer update ianm/url-cron
```

## Usage

When running Flarum on shared hosting, some providers do not allow CLI access in order to setup a cron job for the Flarum Scheduler, but instead offer a solution to trigger a URL in order to accomplish the same goal. This extension exposes `{FORUM_URL}/api/cron/trigger`, which in turn calls the CLI command `php flarum schedule:run`.

Currently, there is no protection on this endpoint, although authorization may be (optionally) added in the future as needs dictate.

## Links

- [Packagist](https://packagist.org/packages/ianm/url-cron)
- [GitHub](https://github.com/imorland/flarum-ext-url-cron)

