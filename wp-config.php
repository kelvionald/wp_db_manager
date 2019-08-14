<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wp' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'A*6Qf/wBv7+A~b6D.&({-q<p7rp6N1##@Um~m_dNpSqiXZxdDbr7rK&[Ihuma!Y$' );
define( 'SECURE_AUTH_KEY',  'K/jF9N!|.u@hD{]yV7TIR:Lzs}bUzoup]G*gL!}]JoXFPC/% XEbb!?y$VYUQ3Qf' );
define( 'LOGGED_IN_KEY',    'O3_=f<6k9JWiE@=:Q7=M~FYY>li:Zi6//n.HvL0Vx;eWj-{9Pi]F,gk20uX2*exf' );
define( 'NONCE_KEY',        'ok~HFdlUC6-HF=+JWr0j3LO^m/A2_K@JI9_Ek6Umd;O4TeAiL~~&eVqb-GxAT5xo' );
define( 'AUTH_SALT',        '*|WDTO`p-HOGNPf<5D9/cE;(}N+Ig4so~Up`=2A)Ej#S9VWF|jIJ=+Fo:RX[7C_E' );
define( 'SECURE_AUTH_SALT', 'u(QhL(f &4U]W5o5huRztHiV=.{(Lf4V(=,)*lo1B~vX }~^8gc`T6MHLekA|Y8U' );
define( 'LOGGED_IN_SALT',   'pMF7zs1Iida4:tpGxY;{p7Dz*_zWmp/-K^b}&@}&)|fcLt/lkz;o}*.MaXLB805;' );
define( 'NONCE_SALT',       'Fg0QXip.<}MMy+*MC2n%X$x R(%xRy^Q;y[EXN#/eh$}k~fYPDC!k7KgBqe_EpPv' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
