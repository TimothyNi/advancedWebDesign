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
define('DB_NAME', 'wordPress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'mysql');

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
define('AUTH_KEY',         'EgoL26}j_hAkf[26PGKd*Sl.:g/Ff,$L5bG{l,F32M`6}86EA){of90QVgnIc7?J');
define('SECURE_AUTH_KEY',  'TKUC60Z6$vn{/-d]&unf$##]NA5`?n@_7emv$rZ-?H*vo2jr:F_jArsGVLKWm@G ');
define('LOGGED_IN_KEY',    '&E/ZR~nj4@,={yQM[IgV.04lc7c^|pC&fJ$zYz4h9e}v6s.s9=fhL)/pM}aC)FAD');
define('NONCE_KEY',        'KLdL.=+0O`E%SVoVuQe06rNb[m/ho1Xy;61INxGXajM]q_1A<Hf>@=6pv]w,,z$J');
define('AUTH_SALT',        'om.g,W0E0^-2V4:F&:&*12A>WE-V5t<5&r}pAP7fkag0wBwWc;m+}:erP/1Jh_O)');
define('SECURE_AUTH_SALT', 'JQqbs_/yYMb6uV85b/*r{3!tEd=yG&i15#qd$o$}|Ek-5K(ptlGsL.b}mKK:i<-D');
define('LOGGED_IN_SALT',   '~7UKw:FLhWjvZc^>g`1}-bT7Yk/OdcI^b~~{-M=AN!?v;ahGtXu-ghjH$>s9s5G:');
define('NONCE_SALT',       '[ag_>`*] j*<Em)Tj;<:[o3/Ip9-8jB;,F62];&w,%k]Q>lQ!H4NsU!1xzRhE>K*');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
