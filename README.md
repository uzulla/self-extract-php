generate self-extract-php
==================

1. Put your files to `input/`.
2. Run `build-self-extract.php`.
3. Upload `ouput/XXXXX.php` to your hosting server(or other).
4. Open XXXXXX.php with your browser(or shell).
5. Files will be extract to same dir.

## why?

Some hosting server's ftp is toooo slow.

## requirements

- php>7.3
- ext-zip

## cli usage

```
# see
$ ./build-self-extract.php -h
usage: build-self-extract.php [-h] [-q] [-v] [-i /ipath/to/input_dir] [-o /path/to/output.php]
-h ,this help
-v ,verbose
-q ,quiet
-i INPUT_DIR ,input directory
-o OUTPUT.php ,output self extract php file name
```

## tips

#### extract fail by max_execution_time

Edit `extractor.php` and retry from generate .

or, need more powerfull server.

#### extract fail by memory_limit

Edit `extractor.php` and retry from generate .

or, need more rich server.

#### zip fail

You need more nice server.

## license

MIT