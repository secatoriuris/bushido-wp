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

@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'curacao');

/** MySQL database username */
define('DB_USER', 'curacao');

/** MySQL database password */
define('DB_PASSWORD', 'curacao');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         ';bmo=ans+Jiuz;yH_TJg(Si5:`Rbm9e HvJPqYs;!FxZr|Avjfa^o,.uiKb2nO;L');
define('SECURE_AUTH_KEY',  'XJT.=q*!94PHjQ%[0tM%X_]c!;=asXH.^lDn;3G3wPDCxu<>9T#HDkD:6%dBmMld');
define('LOGGED_IN_KEY',    'v8C.QZpmt0EY* XS>IqD`F8$}}DuvVS;rbsRl3Ju5MS=-5Raid9[.oF72l<@A.U5');
define('NONCE_KEY',        '%Rba4XLT{O8Peai)$HIWb7]uW-F#[A%z`m%7Npec~cm5C[us6JFNv>%~8AR.=e~e');
define('AUTH_SALT',        'M4|h3{!LiOM$h]22RPa,0Ne4+[<}GfLnmv0#6 e>ay/L[,dz(xcQIC#7c4+:;7s%');
define('SECURE_AUTH_SALT', '~q.r*9|~)T#&Sv.lo4gNJ~MOzf>/rSh1w7Rg4&xm~B(m(ZFHTUyNMo}vQzhQ;fq0');
define('LOGGED_IN_SALT',   'iI0#xyS&q:uCHK@;ZBE|M{d{<{@?Asg<@&%b+Iv^3z6%|hx}J64-5%8i&rWNg5&+');
define('NONCE_SALT',       '}NL@Iu&G^KJ %kYSqV[*yg7`7|M&}s?G2BFncko]72.(}V)X%jYgV08<=M-)iLi~');

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


