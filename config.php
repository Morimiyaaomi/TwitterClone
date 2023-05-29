<?php
// エラー表示あり
ini_set('display_errors', 1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// URL/ディレクトリ設定 置換しておくと後からURLを変更しなければならない時に
//  下記URLを変更すると全ての定数に反映される。
define('HOME_URL', '/TwitterClone/');
