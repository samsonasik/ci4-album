Example of CodeIgniter 4 Module : Album Module
==============================================

[![Latest Version](https://img.shields.io/github/release/samsonasik/ci4-album.svg?style=flat-square)](https://github.com/samsonasik/ci4-album/releases)
![ci build](https://github.com/samsonasik/ci4-album/workflows/ci%20build/badge.svg)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fsamsonasik%2Fci4-album%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/samsonasik/ci4-album/master)
[![Code Coverage](https://codecov.io/gh/samsonasik/ci4-album/branch/master/graph/badge.svg)](https://codecov.io/gh/samsonasik/ci4-album)
[![PHPStan](https://img.shields.io/badge/style-level%20max-brightgreen.svg?style=flat-square&label=phpstan)](https://github.com/phpstan/phpstan)
[![Downloads](https://poser.pugx.org/samsonasik/ci4-album/downloads)](https://packagist.org/packages/samsonasik/ci4-album)

Feature
-------

- [x] CRUD with
   - [x] [Domain Driven Design Architecture](https://en.wikipedia.org/wiki/Domain-driven_design) with [Tactical Pattern](http://gorodinski.com/blog/2012/04/25/read-models-as-a-tactical-pattern-in-domain-driven-design-ddd/)
   - [x] [Post/Redirect/Get pattern](https://en.wikipedia.org/wiki/Post/Redirect/Get)
- [x] Pagination, configurable via [`Album\Config\Album`](#settings) class.
- [x] Search
- [x] Layout
- [x] Flash Message after add/edit/delete

Installation
------------

**1.** Get The Module

**a.** require via composer

```bash
composer require samsonasik/ci4-album
```

**OR**

**b.** manually, by go to `app/ThirdParty` directory in project root, and clone this repository to the `app/ThirdParty` directory:

```bash
cd app/ThirdParty
git clone git@github.com:samsonasik/ci4-album.git
```

> see https://help.github.com/en/github/authenticating-to-github/error-permission-denied-publickey# for common clone issue troubleshooting.

then register "Album" to `App/Config/Autoload.php`'s psr4 property:

```php
		$psr4 = [
			'App'         => APPPATH,                // To ensure filters, etc still found,
			APP_NAMESPACE => APPPATH,                // For custom namespace
			'Config'      => APPPATH . 'Config',
			'Album'       => APPPATH . 'ThirdParty/ci4-album/src', // <-- add this line
		];
```

**2.** Set CI_ENVIRONMENT, base url, index page, and database config in your `.env` file based on your existing database (If you don't have a `.env` file, you can copy first from `env` file: `cp env .env` first). If the database not exists, create database first.

```bash
# .env file
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080'
app.indexPage = ''

database.default.hostname = localhost
database.default.database = ci4_crud
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

**3.** Run db migration

```bash
php spark migrate -n Album
```

**4.** Run db seed (Optional)

```bash
php spark db:seed "Album\Database\Seeds\AlbumSeeder"
php spark db:seed "Album\Database\Seeds\TrackSeeder"
```

**5.** Run development server:

```bash
php spark serve
```

**6.** Open in browser http://localhost:8080/album

Settings
--------

Configure pagination per-page, by copy `src/Config/Album.php` file into `app/Config` directory, and modify the namespace to `Config`:

```php
<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Album extends BaseConfig
{
    public $paginationPerPage = 10;
}
// app/Config/Album.php
```

In above class, the `paginationPerPage` property's value can be changed.

Testing
-------

On very first run, you need to create database, and migration for testing purpose with set `phpunit.xml` file from `phpunit.xml.dist`:

```bash
cd /path/to/modules/ci4-album
cp phpunit.xml.dist phpunit.xml
```

and then configure the `phpunit.xml` to ensure it has a match db configuration with your local dev environment.  If the database not exists, create database first.

```xml
	<php>
		<server name="app.baseURL" value="http://localhost:8080"/>
		<const name="HOMEPATH" value="./"/>
		<const name="CONFIGPATH" value="./vendor/codeigniter4/framework/app/Config/"/>
		<const name="PUBLICPATH" value="./vendor/codeigniter4/framework/public/"/>
		<env name="database.tests.hostname" value="localhost"/>
		<env name="database.tests.database" value="ci4_crud_test"/>
		<env name="database.tests.username" value="root"/>
		<env name="database.tests.password" value=""/>
		<env name="database.tests.DBDriver" value="MySQLi"/>
		<env name="database.tests.DBPrefix" value=""/>
	</php>
```

> Ensure that you use **different DB** for `testing`.


After it, install the codeigniter and phpunit dependency:

```bash
cd /path/to/modules/ci4-album && composer install --prefer-source
```

Lastly, run the test:

```bash
vendor/bin/phpunit
````

Contributing
------------
Contributions are very welcome. Please read [CONTRIBUTING.md](https://github.com/samsonasik/ci4-album/blob/master/CONTRIBUTING.md)
