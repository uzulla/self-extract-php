generate self-extract-php
==================

1. put you files to `input/`.
2. run `build-self-extract.php`.
3. upload `ouput/XXXXX.php` to your hosting server(or other).
4. open XXXXXX.php with your browser(or shell).
5. extract files to same dir.

## why?

Some hosting server's ftp is toooo slow.

## requirements

- php>7.3
- ext-zip

## cli usage

```
# see
$ ./build-self-extract.php -h
usage: build-self-extract.php [-h] [-q] [-v] [-i /ipath/to/input_dir] [-o /path/to/output.php
-h ,this help
-v ,verbose
-q ,quiet
-i INPUT_DIR ,input directory
-o OUTPUT.php ,output self extract php file name
```

## license

MIT