# 2048: a PHP implementation

## Tests

The `Makefile` refers to the automated tests and code quality tools. To
run everything, do

```shell
make ci
```

### Manual console tests (for I/O)

```shell
php tests/manual_io/console_input.php
```

This will allow you to test keystrokes.

```shell
php tests/manual_io/console_output.php
```

This will allow you to test the rendered output on the console.
