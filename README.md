# Zephir C Call

An extension that allows you to call C functions in Zephir.

## Installation

If your zephir is installed in project scope:

```php
composer require xtlsoft/zephir-c-call
```

If your zephir is installed in global scope:

```php
composer g require xtlsoft/zephir-c-call
```

If your zephir was installed as zephir.phar:

You need to re-pack the zephir.phar file.

## Usage

You can call `c_include`, `c_call`, `c_runf` functions from Zephir.

### c_include

```php
c_include(string filename);
```

The filename must be a literal. Don't use the return value.

### c_call

```php
c_call(
    string ret_type, string func_name,
    [string param1_type, string param1_value,
    [string param2_type, string param2_value,
    [string...
);
```

`type` can be one of `int`, `long`, `double`, `float`, `string`.

except values, all types and func_names should be literals.

### c_runf

```php
c_runf(
    string ret_type, string expr,
    [string arg1, [string arg2, [string arg3...
);
```

ret_type and expr must be literals.

You can access the arguments using \${1}, \${2}, \${3}... in expr.

All arguments are `zval*` typed.
