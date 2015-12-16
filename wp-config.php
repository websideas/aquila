<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'aquila');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ' d+aYPf^|[*GP5TpV|T=]Xmxf$T}26&*BGuSq(sQW7R;|mJzAmv]#RM/wqIH|`|>');
define('SECURE_AUTH_KEY',  'B}@~@HQ.sw[x3sDrVDjg&(L}8jx/&<@&z7.}~h|3& qw8]m]yv_X@gHVf<;bt`n|');
define('LOGGED_IN_KEY',    'x/!a;ncmq6$TMlGs-+7a+{xp-9&y,9Wyy&HZ/^oj4SQ9h/^@wSIC1{$0|Uox_!FL');
define('NONCE_KEY',        ']#7$ETasG#QXx An/[XF(p*A6pab:+6a^}MF#8}4]Yr_d1N&CMjDHi1L+e~&ySA+');
define('AUTH_SALT',        'b+NmX3iF;y*im+*YlR7dOF8b|Z(FB::+=K=1+Up*d5~iN?s ycDa|?/*??|+BnF-');
define('SECURE_AUTH_SALT', '8lP`H,||0H|fH@7HVMdt@y+%Iw;H`+nNTY$rt9G~~+]p.jT_S)&`mO.]lRA[*_qQ');
define('LOGGED_IN_SALT',   'LZz2/>|7oDa1Jr@7GwsFJ#-v1q/0HlIF|<L/A=]bm</%v]}N$Um8mEX!r;=6R/zD');
define('NONCE_SALT',       'M}hJ&zqMB.0*-TgHA?MOY7SDNr[LYVp),b.W?Lz[/5K`P0Ddu*Dy{1J-J`+X+-n7');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'aq_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
