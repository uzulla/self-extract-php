<?php
# 解凍には結構負荷がかかかるので
// ini_set("max_execution_time", 300);
// ini_set("memory_limit", 512*1024*1024);

$fp = fopen(__FILE__, 'r');
fseek($fp, __COMPILER_HALT_OFFSET__);
$tmp_path = tempnam(sys_get_temp_dir(), "TMP_ZIP_");
file_put_contents($tmp_path, $fp);

try {
    $zip = new \ZipArchive;
    if ($zip->open($tmp_path) === true) {
        $zip->extractTo(__DIR__ . '/');
        $zip->close();
        unlink(__FILE__);
        echo 'success';
    } else {
        throw new \Exception("open failed");
    }
} catch (Throwable $e) {
    echo 'zip open failed';
    var_dump($e);
} finally {
    unlink($tmp_path);
}

// 以下__halt_compiler();の後には一切文字をいれてはいけない。
__halt_compiler();