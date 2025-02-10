<?php

if (!defined('INDEX')) die("Forbidden");

class PageManager {
    private static $allowedPages = array(
        "dashboard",
        "user",
        "user_tambah",
        "user_edit",
        "user_hapus",
        "buku",
        "buku_tambah",
        "buku_edit",
        "buku_hapus",
        "kategoribuku",
        "kategoribuku_edit",
        "kategoribuku_tambah",
        "kategoribuku_hapus",
        "ulasan",
        "ulasan_hapus",
        "peminjaman",
        "peminjaman_hapus"
    );

    public static function getPage() {
        return isset($_GET['hal']) && self::isValidPage($_GET['hal']) ? $_GET['hal'] : "dashboard";
    }

    private static function isValidPage($page) {
        return in_array($page, self::$allowedPages);
    }
}

$hal = PageManager::getPage();

include "content_$hal.php";

?>