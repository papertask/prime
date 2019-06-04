<?php
define('WP_CACHE', true); // Added by WP Rocket
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
define( 'DB_NAME', 'cigarprime_com' );

/** MySQL database username */
define( 'DB_USER', 'cigarprime_com' );

/** MySQL database password */
define( 'DB_PASSWORD', 'SPJX6ctHkr44XK5E' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_MAX_MEMORY_LIMIT', '256M' );

define( 'WPMS_ON', true );
define( 'WPMS_SMTP_PASS', 'FumfRivbToza6$' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'NR54%o-Xl|3nTK1mHKtWKa!Ah}R9iyW*E1}01(2!p]]r4j7v1P)9j^$2UT,VK0lz' );
define( 'SECURE_AUTH_KEY',  'z~ct#oe%,()~,I8Bi gdhw4Qg!@%ruW_S5IE-TAfCYX-c(}jc<{XeRXS} AsC_]G' );
define( 'LOGGED_IN_KEY',    '0gBH*C;~rR_->sPxjyf%`8f/{}D72fbUFxl)rN?#KGjn9+r7Ym${1Ff>}ndHC#|+' );
define( 'NONCE_KEY',        'dVO}9kF82`T(>$6C,G.R#X8%I/jn1tY(;&cwU0C6x1oZq|_5ZB^E$zmD;yS<J494' );
define( 'AUTH_SALT',        'Eo)Eyx(O;[i(Z=7UQCv.)cQz;% K#?RB$(+cu{1]6j`{(&%iY|*z1/{I~9(NCx,m' );
define( 'SECURE_AUTH_SALT', 'f5v3 GX2CJ2s@!mJ#DS(0XJM_(_7q-qP7EU_sa*FFO@KksWC45&9/]FR0kT<qT]x' );
define( 'LOGGED_IN_SALT',   'I1N#i-l9y%a<BS8=XTDd_uKg_5YB4b&)Q#-zHL2IigOO<{D<|yhGhj]<5BIUOij~' );
define( 'NONCE_SALT',       'ib_%89MzbvWM[3:2nknR>gUmkK}Kw^z?H4tWb{V3CAg^aeNR_Aj`F# X6u?mzSl)' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
