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
define('DB_NAME', '2298500_dev');

/** MySQL database username */
define('DB_USER', '2298500_dev');

/** MySQL database password */
define('DB_PASSWORD', 'pecataroskata22');

/** MySQL hostname */
define('DB_HOST', 'fdb12.biz.nf');

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
define('AUTH_KEY',         'tjYw^-pjN9R6$;U%qC,og:VJ1:aUPW7`~z^xOE72a),HtRqAwNqAvl`s-<j2b.HY');
define('SECURE_AUTH_KEY',  'YSw0p@k@Dc:W5sRt?;ORn1/E:s~ir0$Se1bL[jLBO$d.$c11#vMbC<~MAT0.UYeP');
define('LOGGED_IN_KEY',    'f/Y:h`:#bWEc/5u!fY>CvJI6)}1F:{s_9B#a1`D~oaB |d`Aqv5-Y3!j$>< 2a*P');
define('NONCE_KEY',        'n&0HXU*2@JnyEp}Tnf([e5Lr[w=tzw,pxlo_J9KzsP`=)o]1bCb+X-((JfmLV/!T');
define('AUTH_SALT',        'DT#IpA&v0HQIQ3:B!Cx?Tq]O8Kk=C+:nZb4bshXZlMbr,4GXv_<DO2E,9HdSF&nk');
define('SECURE_AUTH_SALT', 'nUL=@E[s,R5==6LXWbi8cOr{gGN-Lmn$l6$((wwbK>oi=0SL0*nXNZ7pv@e9GC>a');
define('LOGGED_IN_SALT',   ')~I;@V}<_kzsSi`PN<p9Q[~^5do`VTw]_keeFca7c5(x_e>q{#gkv>D<7y^ogU8X');
define('NONCE_SALT',       'tgx}I}suYJ=?iXdidYEM+Lnj&$_H*Johzwh^prT,hEH% Ar=8a#AAPs!m+4(uCa!');

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
