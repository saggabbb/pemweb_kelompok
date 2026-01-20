<?php
$target = __DIR__ . '/public/storage';
if (file_exists($target)) {
    if (is_link($target) || is_file($target)) {
        unlink($target);
        echo "Deleted link/file: $target\n";
    } elseif (is_dir($target)) {
        // Simple rmdir for empty or symlinked dir
        @rmdir($target);
        if (file_exists($target)) {
            // Force delete if rmdir failed (junction point)
            exec("rmdir /s /q \"$target\"");
            echo "Deleted dir via exec: $target\n";
        } else {
            echo "Deleted dir: $target\n";
        }
    }
} else {
    echo "Target does not exist: $target\n";
}
