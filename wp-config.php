<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.

define( 'WP_MEMORY_LIMIT', '512M' );
define('WP_ALLOW_REPAIR', true);
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
define('WP_HOME','http://localhost/fst_production/');
define('WP_SITEURL','http://localhost/fst_production/');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'flagstonetravel');

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

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'AjmT(@p^Urfr[w6K4%V_t56{s6hu0 /)ne5mT6ocYmFn%WOby+2,!2>aYTsCGuOL');
define('SECURE_AUTH_KEY',  'Jd4uZp[%9IK(=FOJ~5.iX,vmYsZ4k7Z*?]y;($mh&F3VLaF!A-e:4+Nt-_p_XodZ');
define('LOGGED_IN_KEY',    '*-<T.R43QFNuco@[)jd7Or]=52ox%^zqLD6|Dz~UU9IWN9|}CQ2FGa%^d#a=5/><');
define('NONCE_KEY',        'vxzVDw<S8*x>yZelm(Ngcw`;Cvw#7r=<a(sxrM*|?8C0/qi>K[u4[d?3[O<&vjr~');
define('AUTH_SALT',        ':Re )@1{G7iIi#w9&qVWneF+N3BqA)!RC@;PAw$TE(97q(2NlzQJk&=RzGVIr$Y)');
define('SECURE_AUTH_SALT', 'q.$kicdCcOA||*:Fd:0L[D$Y7By>zK7UWs)VgafGp#U:ElWn,s @JGvQKl.`$J7M');
define('LOGGED_IN_SALT',   'Gm{H:(N1vx1N[^jH~{&la|:3w-5=:?Nvm3:X13PW,w=ks@Tqg;<hBi3/o]PzREQ5');
define('NONCE_SALT',       'q7n*t]10PE3<ZU:;Ki[D]5dxN7*U vt(Q:0tV_bm#%=-PpUDN#qLr,YxDp&Y!|B}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'flags_';

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
