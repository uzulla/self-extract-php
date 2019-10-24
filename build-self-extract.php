#!/usr/bin/env php
<?php
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

$options = getopt("hvqi:o:");
# usage
if (isset($options['h'])) {
    echo "usage: build-self-extract.php [-h] [-q] [-v] [-i /ipath/to/input_dir] [-o /path/to/output.php]" . PHP_EOL;
    echo "-h ,this help" . PHP_EOL;
    echo "-v ,verbose" . PHP_EOL;
    echo "-q ,quiet" . PHP_EOL;
    echo "-i INPUT_DIR ,input directory" . PHP_EOL;
    echo "-o OUTPUT.php ,output self extract php file name" . PHP_EOL;
    die();
}

$is_verbose = isset($options['v']);
$is_quiet = isset($options['q']);

$tmp_zip_path = __DIR__ . "/tmp.zip";
$input_dir = $options['i'] ?? __DIR__ . "/input/";
$output_zip_path = $options['o'] ?? "output/" . md5(random_bytes(128)) . ".php";

if (file_exists($tmp_zip_path)) {
    unlink($tmp_zip_path);
}

# scan files
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(
        $input_dir,
        FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::SKIP_DOTS
    ),
    RecursiveIteratorIterator::SELF_FIRST
);

# make zip file
$zip = new ZipArchive();
$result = $zip->open($tmp_zip_path, ZipArchive::CREATE);
if ($result !== true) {
    die($result . PHP_EOL);
}

# process scaned files.
if ($files->valid() === false) {
    die("any file found, exit." . PHP_EOL);
}

foreach ($files as $file_path => $file_info) {
    $sub_path = substr($file_path, strlen($input_dir));
    $sub_path = preg_replace('|\A[/.]+|u', '', $sub_path);

    if (!$is_quiet && $is_verbose) {
        echo $sub_path . PHP_EOL;
    }

    if ($file_info->isFile()){
        $zip->addFile($file_path, $sub_path) or die("addFile Failed");
    } elseif($file_info->isDir()) {
        $zip->addEmptyDir($sub_path) or die("addEmptyDir Failed");
    }
}

# save
$zip->close();

# build self-extract-php
copy("extractor.php", $output_zip_path);

$output_zip_fp = fopen($output_zip_path, "a+");
$tmp_zip_fp = fopen($tmp_zip_path, "r");
fwrite($output_zip_fp, fread($tmp_zip_fp, filesize($tmp_zip_path)));

# cleanup
fclose($output_zip_fp);
fclose($tmp_zip_fp);

unlink($tmp_zip_path);

if (!$is_quiet) {
    echo PHP_EOL . "built file name: {$output_zip_path}" . PHP_EOL;
}
