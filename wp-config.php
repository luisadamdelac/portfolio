<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'myPortfolio_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'dC.&?(LI&l*55sd*Vqe[KVmN|Q+`uc uhNfz%Wqxy=DzL>X,E=-U^]q#[Um}c*-S' );
define( 'SECURE_AUTH_KEY',  'wl%NaJ}xcE) LwN]r+-Ah/7N~dV24~Fwx7>H5ybu1!RyrY*$/ W:fQG,&&BVXh:!' );
define( 'LOGGED_IN_KEY',    '-k_~gEH#jg|nA#<o_,XKkzZg<CecTSD35J6LFS-H px;wKiu&XL!oCZRF6oTsfr9' );
define( 'NONCE_KEY',        '8LiQ#[^2KUWho28wT,kT40Kg(Lkh-)d;(EJ#:5oz5Gw+axTLml95ihO6`*0~?)o_' );
define( 'AUTH_SALT',        '0(yz8R2t4 oZT~J#EM>EoAhJPLW-kWi@O8)9>,c%r4i-n{c~2tFtdM|QM~f,SI7I' );
define( 'SECURE_AUTH_SALT', '49{nygh:&gFqO$xzIh~-*L2q8qYvl^psK6lhD[/x=d.8wz/#?R_K[/TEVhqaN>3]' );
define( 'LOGGED_IN_SALT',   '*D`7uduv&_kPYK06!phW(d1n)ZEp`TY>OMdE6KS.7od|_[*2fq_wk/l;QR@VV&i1' );
define( 'NONCE_SALT',       '8sBibN$-x]}.=HC8`PPs+;LZxwR3^jp$|Rb$D;U`?S8N(A3/}kfPW(s%XPWvQH B' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
