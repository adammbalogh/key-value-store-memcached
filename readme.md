# Key-Value Memcached Store by [@adammbalogh](http://twitter.com/adammbalogh)

[![Build Status](https://img.shields.io/travis/adammbalogh/key-value-store-memcached/master.svg?style=flat)](https://travis-ci.org/adammbalogh/key-value-store-memcached)
[![Quality Score](https://img.shields.io/scrutinizer/g/adammbalogh/key-value-store-memcached.svg?style=flat)](https://scrutinizer-ci.com/g/adammbalogh/key-value-store-memcached)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/adammbalogh/key-value-store-memcached.svg?style=flat)](https://packagist.org/packages/adammbalogh/key-value-store-memcached)
[![Total Downloads](https://img.shields.io/packagist/dt/adammbalogh/key-value-store-memcached.svg?style=flat)](https://packagist.org/packages/adammbalogh/key-value-store-memcached)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8c151f77-b059-400b-bead-b47bd8cc69cc/small.png)](https://insight.sensiolabs.com/projects/8c151f77-b059-400b-bead-b47bd8cc69cc)

# Description

This library provides a layer to a key value memcached store.

It uses the [memcached](http://hu1.php.net/manual/en/book.memcached.php) extension.

# Support

[![Support with Gittip](http://img.shields.io/gittip/adammbalogh.svg?style=flat)](https://www.gittip.com/adammbalogh/)

# Usage

```php
<?php
use AdammBalogh\KeyValueStore\KeyValueStore;
use AdammBalogh\KeyValueStore\Adapter\MemcachedAdapter as Adapter;

$memcachedClient = new Memcached();
$memcachedClient->addServer('localhost', 11211);

$adapter = new Adapter($memcachedClient);

$kvs = new KeyValueStore($adapter);

$kvs->set('sample_key', 'Sample value');
$kvs->get('sample_key');
```

# Installation

Install it through composer.

```json
{
    "require": {
        "adammbalogh/key-value-store-memcached": "@stable"
    }
}
```

**tip:** you should browse the [`adammbalogh/key-value-store-memcached`](https://packagist.org/packages/adammbalogh/key-value-store-memcached)
page to choose a stable version to use, avoid the `@stable` meta constraint.

# API

**Please visit the [API](https://github.com/adammbalogh/key-value-store/blob/master/readme.md#api) link in the abstract library.**
