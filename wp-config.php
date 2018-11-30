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
define('DB_NAME', 'adco');

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
define('AUTH_KEY',         '1gHOkgi7yq:nV-VZU4%f;O>5^o.W >Jx5;rvx^wi<e}s<Myj3@n#HVn9N*-NfymE');
define('SECURE_AUTH_KEY',  'x,viVG6cV~BWX?wD+z>A]=E?0|>:gYu&sm1I>JZ&%0{DYfiFJntV&cF4!#JoFO]v');
define('LOGGED_IN_KEY',    '9{}<R=67[>-wAps;kDrRPH^2ypFGkW0;X|vjy@75Jf}[D1_tvVR=7fGdh<euw>.b');
define('NONCE_KEY',        '@CV-A[sO%LOpbq&I{eo4W52P@M=U-qK5N3F}wg4:#m}oHR~hT(0]YPG#EHK0i`sS');
define('AUTH_SALT',        'W7CrR0@!c,p$5ytvbTRwr?F>8<^#3URO^1s_vvAOVfU`KS*#Z1Qe<|VJ@}2C,Ef,');
define('SECURE_AUTH_SALT', ' |A-MF+;AK$;1v|zNy$--eJEVM:WxK,n+<5U L5(ghnH>B<n*F:IvWGyYNkm,ll_');
define('LOGGED_IN_SALT',   'hP?e:4w#]#&`wI3GQAlB:]UV!wT>@cyJSf6h7)U-8z}|^aMF4(Z3dFqJ$G?0N?<}');
define('NONCE_SALT',       'sKNHo~1kc?huu/d7/2szKWjq*C`|NsrkP1Csp&dDoneRhi!75;-10>Rid;8{Ky@+');

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
