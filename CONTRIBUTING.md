CONTRIBUTING
------------
To contribute, you can send pull requests with :

- Typo fix.
- Use [CodeIgniter 4 Coding Standard](https://github.com/codeigniter4/coding-standard), you can fix and check with run commands:

```bash
# fix your code style
composer cs-fix

# check if any error that can't be fixed with cs-fix
# that you need to manually fix
composer cs-check
```
- Ensure the phpstan check shows No errors with run command:

```bash
composer analyze
```

- patch(es) need new/updated test(s) that ensure there is no regression.
- new feature(s) need test(s) that ensure there is no regression.