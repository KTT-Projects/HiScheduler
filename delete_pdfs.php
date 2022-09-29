<?php
foreach (glob('./pdfs/*.pdf') as $i => $file) {
    if (filemtime($file) < time() - 8640000) {
        unlink($file);
    }
}
