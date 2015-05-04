<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'hotnewfunny');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('FS_METHOD', 'direct' ) ; 
define('FS_CHMOD_DIR', 0777  ) ; 
define('FS_CHMOD_FILE', 0777  ) ; 
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'U?#Wt-(|95}u!T^p&9=HUjC|QHzzA=M~#b-o%6#_w }m530ETOUFQ~;_J|-3}?cA');
define('SECURE_AUTH_KEY',  'Z-)aM,1w!T(dF}-+!~fLvooV#C93XW|?GO0FAAx38u>b`_|Zi*J^-so$BPX;5U`5');
define('LOGGED_IN_KEY',    '_Y/CY|Gp@BB18|CXQ+=-yBT4jz2nw{+t$F%l&[>FxU PwCsGV(!yyq,-i9ouyT|Y');
define('NONCE_KEY',        '8R62tQUw=xGG5/yeI=-{k<XWq) 0j&5p6a_2z(Ou+f*48|2&r!yVU-;&:I**BH(D');
define('AUTH_SALT',        'M`>byZ4IUa s@EXRirtbl+e3I,-ju|%XQ`oH+skyh-aK?MdeWj#6G9f|_0:VTA!n');
define('SECURE_AUTH_SALT', 'DI6TZ^4q+z|f&l_%EU!+Mgq:tB]^926gx]8yh=Bl41X4A_{nQE5rdVj;A=4nKz!M');
define('LOGGED_IN_SALT',   '%~x#qgIDzg5yTxy|x*ms2gHlY2cR%d+hj>yJ ZWfX*q!g|{;|d[TZ!8`h;WIX&Ln');
define('NONCE_SALT',       ')ug4$$TbsJhq L2Nv/PO6a{Gmh={~0(dzw8O-Bp#!a?8b=O}QZino:Q=cmd%CQ%l');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
