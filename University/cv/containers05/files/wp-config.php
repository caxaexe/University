<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', 'wordpress' );

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
define( 'AUTH_KEY',         'eMDU; vrqh%$P[}Id<5=L~)}%aiFyHK$*P_kN6SH=B+u;)A/AU]D!CAW[(u]nZty' );
define( 'SECURE_AUTH_KEY',  'WylHQuV35IM{FeC=M_sSV2S$EYQeFcH<1wU$*yTp#!HFqX0S^h$5XN-WKAe?dHxE' );
define( 'LOGGED_IN_KEY',    '1=S)zGvLd(2gdVcghlz}I+fex)EuYbU+((>HGin7Fux8B }fUy)7V@N.{9|f#$.Q' );
define( 'NONCE_KEY',        'M4s31A;b-m;R}zm;,!D1X-c<{&_6?R&wAQ`K=r~WS4OH@)#0p8mjVSXxKs;,b mN' );
define( 'AUTH_SALT',        ' :l}uK{ DNko<Q_+ixBfVFszBR+fRPDj+Elx_[n7^)@LfgZ$RGN>CeF;.<X`~>7@' );
define( 'SECURE_AUTH_SALT', '.u]tdbHyYh83Yo1nTY3.E1g+o+mAx0n0qV`]p$Dph=])BWa@f1|6op+bt$P<BkL}' );
define( 'LOGGED_IN_SALT',   '?=ERee3Z<{*|?E3x*H/-p+%hzjOQ8& b4PR&AYm0>8tz-$UXk/|e^@Ztb>=h8/00' );
define( 'NONCE_SALT',       'CvL()GM~[I:seSelm7_&X{O$P9/unrN9(J:(a,(0;n^MoRSVu4Cmd;BI+<zj584Q' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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