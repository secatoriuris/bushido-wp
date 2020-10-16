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
define('DB_NAME', 'bushido-wp');

/** MySQL database username */
define('DB_USER', 'bushido-wp');

/** MySQL database password */
define('DB_PASSWORD', 'bushido-wp');

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
define('AUTH_KEY',         'o7.N)RDmjmeKm^y!Y+Zi~Ft(:`~wx+|LtkC-5eZ7/)0R%A9pRuQwxnVqn8 7nxsU');
define('SECURE_AUTH_KEY',  '5(Na^gBXkn16+d4y:Eh6b!~y[?MK;G*.8ug/o.g!Hq0.G|~G^:2mLFnL|?e<SX+L');
define('LOGGED_IN_KEY',    'bMHB;:(})>6ddC^<qoG*q-k{r>,;X`#YM|yZS:6I$$]8h(y0=kD-v>zAAxB]WOM}');
define('NONCE_KEY',        'WfoQI$:%5?xdpTWi1 )ygDm*,Soe=N/PvWt)O{zS+_R[!RGV<|7fh^PPq2-qXwB=');
define('AUTH_SALT',        'O&){]L*!3t`:7|>w w%vK.c0R_X44La^.HVn?0{c2nGxaE;KSlEF|0I#vnU;6sEu');
define('SECURE_AUTH_SALT', 'B@*K27CNnVwj@Y/VzkW-eAV) Zz19Si&d.q.J(hlxo:MdJB ;Ef+nG0y<Ccxh+Ez');
define('LOGGED_IN_SALT',   '1qkgPiWQRx~Ojm8;E_u^m%:hT<n8ChlwH|gr!yD9Q:_:0,}de{.}1NF~.$>|eF81');
define('NONCE_SALT',       '6hnzw~]fD{Yf.Z?]Eo)gaJ2]?[jAg[{&X.>6vy)yv]vb4^k3:c%FE;etr4pB*ZQF');

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
