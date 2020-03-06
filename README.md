Example of CodeIgniter 4 Module : Album Module
==============================================

Installation
------------

1. require via composer

```bash
composer require samsonasik/ci4-album:dev-master
```

OR

manually, by clone and copy to `app/modules`, then register "Album" to `App/Config/Autoload.php`'s psr4 property:\

```php
		$psr4 = [
			'App'         => APPPATH,                // To ensure filters, etc still found,
			APP_NAMESPACE => APPPATH,                // For custom namespace
			'Config'      => APPPATH . 'Config',
			'Album'       => ROOTPATH . 'modules/ci4-album', // <-- add this line
		];
```

2. Set CI_ENVIRONMENT, base url, index page, and database config in your `.env` file.

> If you don't have a `.env` file, you can copy first from `env` file:
> ```bash
> cp env .env
> ```

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

3. Run db migration

```bash
php spark migrate -n Album
```

4. Run development server:

```bash
php spark serve
```

5. Open in browser http://localhost:8080/album

Contributing
------------
Contributions are very welcome. Please read [CONTRIBUTING.md](https://github.com/samsonasik/ci4-album/blob/master/CONTRIBUTING.md)
