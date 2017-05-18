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
define('DB_NAME', 'dbdormistar');

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
define('AUTH_KEY',         'R[S?P%%PxIb P?>fZPHuiY4l<OGb5hJ4M;MiBCDcb]0!`t@gcAKLAUVJ?`}A.oK|');
define('SECURE_AUTH_KEY',  'nR?2qU|CW1}q40w@QI/|aP-/Um,)?]m1ihgH8_}Db)F8?zfL-!xT:D6wDQ|4U2M#');
define('LOGGED_IN_KEY',    ':>IxNG5o&e6sAr9m]]E6EPPE:mb*sGs(HZOzFVfK`0qfcQ=-WfU)ihu}#1:2t}j ');
define('NONCE_KEY',        'cLI.hH%z/N9}<,J]o&<R[%Z88SX{11i4%a eCWoKV($*oaXs,$h_OvOzQ_5AHXnM');
define('AUTH_SALT',        'o,nIYM<FL70} aKye?K}g}R`#]]nPhPr7I-(),HifbcBWTBBr$oz9H0S-47{`EJW');
define('SECURE_AUTH_SALT', '*T@ _f 2/QJ3~-+:Jps*-Iq/><_S>h7ceHIO;PnYR!3dtfM;G]: m)@cl`Gr:+MP');
define('LOGGED_IN_SALT',   '%g^k},bM?q)j9?s_`]nf7T.u#sZ0oc}5@AWhD9%gbl^?<[{v_+#p^X,Tvx4$1J_L');
define('NONCE_SALT',       '7{iVN10h3QEkULJsX)wBPMv9uLFy2PQVjJ#~e5 nArKOgT~!1@q4_8;%l=]K<;|o');

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
