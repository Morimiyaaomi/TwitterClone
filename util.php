<?php
//////////////////////////////////////
// 便利な関数
//////////////////////////////////////

/**
 * 画像ファイル名から画像のURLを生成する
 * 
 * @param string $name 画像ファイル名
 * @param string $type user | tweet
 * @return string 
 */
function buildImagePath(string $name = null, string $type)
{
  if ($type === 'user' && !isset($name)) {
    return HOME_URL . 'Views/img/icon-default-user.svg';
  }

  return HOME_URL . 'Views/img_uploaded/' . $type . '/' . htmlspecialchars($name);
}

/**
 * 指定した日時からどれだけ経過したかを取得
 * 
 * @param string $datetime 日時 (引数の情報)
 * @return string (戻り値の情報)
 */
function convertToDayTimeAgo(string $datetime)
{
  $unix = strtotime($datetime);
  $now = time();
  $diff_sec = $now - $unix;

  if ($diff_sec < 60) { //経過秒数が60秒未満であれば◯秒前と返す
    $time = $diff_sec;
    $unit = '秒前';
  } elseif ($diff_sec < 3600) { //1時間未満の場合は◯分前と返す
    $time = $diff_sec / 60;
    $unit = '分前';
  } elseif ($diff_sec < 86400) { //24時間未満なら◯時間前と返す
    $time = $diff_sec / 3600;
    $unit = '時間前';
  } elseif ($diff_sec < 2764800) { //32日未満なら◯日前と返す
    $time = $diff_sec / 86400;
    $unit = '日前';
  } else {

    if (date('Y') !== date('Y', $unix)) {
      $time = date('Y年n月j日', $unix);
      //現在の年と投稿日時が違う場合は年月日を返す
    } else {
      $time = date('n月j日', $unix);
      //同じ場合は月と日にちを返す
    }
    return $time;
  }

  return (int)$time . $unit; //カタキャスト:int:intで表せない値は0,小数点以下は切捨て
}

/**
 * ユーザー情報をセッションに保存する
 * 
 * @param array $user
 * @return void
 */
function saveUserSession(array $user)
{
  // セッションを開始していない場合
  if (session_status() === PHP_SESSION_NONE) {
    // セッション開始
    session_start();
  }

  $_SESSION['USER'] = $user;
}
/**
 * ユーザー情報をセッションから削除する
 * 
 * @return void
 */
function deleteUserSession()
{
  // セッションを開始していない場合
  if (session_status() === PHP_SESSION_NONE) {
    // セッション開始
    session_start();
  }

  // セッションのユーザー情報を削除
  unset($_SESSION['USER']);
}

/**
 * セッションのユーザー情報を取得
 * 
 * @return array|false
 */
function getUserSession()
{
  // セッションを開始していない場合
  if (session_status() === PHP_SESSION_NONE) {
    // セッション開始
    session_start();
  }
  if (!isset($_SESSION['USER'])) {
    // セッションにユーザー情報がない場合
    return false;
  }

  $user = $_SESSION['USER'];

  // 画像のファイル名からファイルのURLを取得
  if (!isset($user['image_name'])) {
      $user['image_name'] = null;
  }
  $user['image_path'] = buildImagePath($user['image_name'], 'user');

  return $user;
}