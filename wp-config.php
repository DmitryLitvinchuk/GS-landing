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
define('DB_NAME', 'landing');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9J1@_((NGCSTt&pM4cBTZ<0F].5%d/c{/uf&{nh} o72I`}j$ ^W?$IkiH;GU)4w');
define('SECURE_AUTH_KEY',  '?X;&XG]x$oIy*EQ*=Ul<0P.1SD;xy!L5M32]0K##N)v6k;i/MEv1NJdzo2ld+w%8');
define('LOGGED_IN_KEY',    '?F p<z|y|G##=,5XA&!E-XpbKMjeKDIW<js/l=5`q-I2GgJS{xk&aORHz4K|&G$U');
define('NONCE_KEY',        's#V09p_f(CJH5#1CBdc#ip_FC`$/=+<ViT/ILm7jS>LQdwJ.[3(G4KO(=Xeh+_a4');
define('AUTH_SALT',        '83]?t$y{yjUCH!g{X=9[|R$O(uS-S8 AkH<hiLI%t3I|p}~o2ot.t:Q-G`x!bSj#');
define('SECURE_AUTH_SALT', 'S4/-&Qp@rem^:y_E?.<]2#ukB.dQKMWpBC]!(rQh~OIV?w|a#mKit&B>M[^ITH-;');
define('LOGGED_IN_SALT',   'Lqtf.;nz!4Md0Qi=krY-2ShX~&3`C.Q<Vl?4W:+u(uQV6Unv]))lWn2=|$uyt(!!');
define('NONCE_SALT',       ']v7?W+zz.b4l!pNG`m0ut>Z|f6.R|K_pq+l+u#5qC`hcGkCFXb8os6V4lL=-#``f');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'gs_';

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
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
