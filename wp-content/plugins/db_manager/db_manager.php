<?php
/**
 * Plugin Name: DataBase Manager
 * Description: Simple plug-in ещ view database tables and edit records.
 * Version: 1.0.0
 * Author: Sergey Turetsky (Kelvionald)
 * Author URI: https://nlix.ru/
 */

define('DB_MANAGER_DIR', __DIR__ . '/');

function _trans($key) {
  static $locations;
  $locale = get_locale();
  if ($locale == 'ru_RU') {
    if (!isset($locations[$locale])) {
      $locations[$locale] = require_once(DB_MANAGER_DIR . 'lang/ru.php');
    }
  } else {
    $locale = 2;
    if (!isset($locations[$locale])) {
      $locations[$locale] = require_once(DB_MANAGER_DIR . 'lang/en.php');
    }
  }
  return $locations[$locale][$key];
}

function db_manager_get_results($sql) {
  global $wpdb;
  return $wpdb->get_results($sql);
}

function db_manager_render($tpl, $data = [], $return = false) {
  extract($data);
  if ($return) {
    ob_start();
  }
  require(DB_MANAGER_DIR . 'views/' . $tpl . '.php');
  if ($return) {
    return ob_get_clean();
  }
}

function db_manager_component_table($header, $data, $table = '') {
  return db_manager_render('table', [
    'header' => $header,
    'data' => $data,
    'url' => '//'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
    'table' => $table
  ], 1);
}

function getBreadcrumbsRoot() {
  return [
    '?page=db_manager' => _trans('db.tables_header'),
    '?page=db_manager&sub_page=query' => _trans('db.sql_query')
  ];
}

function db_manager_view_tables() {
  $tables = db_manager_get_results('SHOW TABLES FROM ' . DB_NAME);
  $tables = array_map(function ($t) {
    $table_name = $t->Tables_in_wp;
    $count = db_manager_get_results('SELECT COUNT(1) AS `count` FROM `'.$table_name.'`');
    $row = [
      $table_name,
      $count[0]->count
    ];
    return array_map(function($r) use($table_name) {
      return [
        'value' => $r,
        'link' => '&table='.$table_name
      ];
    }, $row);
  }, $tables);
  db_manager_render('base', [
    'header' => _trans('db.tables_header'),
    'breadcrumbs' => getBreadcrumbsRoot(),
    'content' => db_manager_component_table([
      _trans('db.table_header'),
      _trans('db.table_count')
    ], $tables)
  ]);
}

function db_manager_value($value) {
  return mb_substr(strip_tags($value), 0, 20);
}

function db_manager_table_content($rows, $table = '') {
  if (count($rows) == 0) {
    return '<p>' . _trans('db.table_empty') . '</p>';
  } else {
    $columns = array_keys(get_object_vars($rows[0]));
    $columns = array_map('strtolower', $columns);
    $rows = array_map(function ($t) use($columns) {
      $row = get_object_vars($t);
      foreach ($row as $k => $v) {
        if (!isset($isPk)) {
          $isPk = $v;
        }
        $row[$k] = [
          'value' => db_manager_value($v),
          'raw' => htmlspecialchars($v),
          'field_id' => $columns[0],
          'field' => $k,
          'id' => $isPk
        ];
      }
      return $row;
    }, $rows);
    return db_manager_component_table($columns, $rows, $table);
  }
}

function db_manager_view_table($table) {
  $rows = db_manager_get_results('SELECT * FROM ' . $table . ' LIMIT 0, 20');
  $data = [
    'header' => _trans('db.table_header') . ' ' . $table,
    'breadcrumbs' => getBreadcrumbsRoot()
  ];
  $data['content'] = db_manager_table_content($rows, $table);
  db_manager_render('base', $data);
}

function db_manager_view_query($sql) {
  $sub_content = '';
  $_sql = trim(mb_strtolower($sql));
  if ($_sql) {
    if (
      strpos($_sql, 'select') === 0 || 
      strpos($_sql, 'show tables from') === 0
    ) {
      $rows = db_manager_get_results($_sql);
      $sub_content = db_manager_table_content($rows);
      // print_r($sub_content);
    }
  }
  db_manager_render('base', [
    'header' => _trans('db.sql_query'),
    'breadcrumbs' => getBreadcrumbsRoot(),
    'content' => db_manager_render('query', [
      'submit' => _trans('db.sql_query_submit'),
      'sub_content' => $sub_content,
      'sql' => $sql
    ], 1)
  ]);
}

function db_manager_view() {
  if (isset($_GET['sub_page']) && $_GET['sub_page'] == 'query') {
    db_manager_view_query($_GET['sql']);
  } else if (isset($_GET['table']) && $_GET['table']) {
    db_manager_view_table($_GET['table']);
  } else {
    db_manager_view_tables();
  }
}

function register_my_page(){
	add_menu_page( _trans('menu.title'), _trans('menu.title'), 'administrator', 'db_manager', 'db_manager_view', plugins_url( 'db_manager/db_manager.png' ), 100 ); 
}

add_action( 'wp_ajax_db_manager', 'db_manager_upd_row' );

function db_manager_upd_row() {
  if (isset($_POST['method']) && $_POST['method'] == 'update') {
    global $wpdb;
    $is_result = $wpdb->query(
      "UPDATE `".$_POST['table']."` 
      SET `".$_POST['field']."` = '".$_POST['value']."'
      WHERE `".$_POST['field_id']."` = '".$_POST['id']."'"
    );
    if ($is_result === false) {
      echo json_encode([
        'error' => 'Bad SQL query!'
      ]);
    } else {
      echo json_encode([
        'success' => [
          'new_value' => $_POST['value']
        ]
      ]);
    }
  } else {

  }
	wp_die();
}

add_action( 'admin_menu', 'register_my_page' );