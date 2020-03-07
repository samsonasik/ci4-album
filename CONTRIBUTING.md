CONTRIBUTING
------------
To contribute, you can send pull requests with :

- Typo fix.
- Use [CodeIgniter 4 Coding Standard](https://github.com/codeigniter4/coding-standard), you can check with run command:

```bash
# fix your code style
composer cs-fix

# check if any error that can't be fixed with cs-fix
# that you need to manually fix
composer cs-check
```

- patch(es) need new/updated test(s).
- new feature(s) need test(s).

Tests
-----
You can run test with :
```shell
$ composer install
$ vendor/bin/phpunit
```
and make sure there is no regression.