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
define('DB_NAME', 'za');

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
define('AUTH_KEY',         ' /%H~6d:9wo*j]=sZgA/Mk#nhs4{[Pz}u7&#}cIcn8U!iAtwQ_ >g8Ofs$@9N`;^');
define('SECURE_AUTH_KEY',  'u@}ahSjAqlH;1(K3q/BJ1OH}*>GR=,8xAJf13&5b*c?72mYMUi+KebDBrRCKBeup');
define('LOGGED_IN_KEY',    'VzLqmZ-;k|@#@ $;;3+!-Az:HAV`uexv%my=lN0+i;@Ei3bhv8g*K(C:7LIBA123');
define('NONCE_KEY',        'GF.Af9L#,OOs h+=ArU7OAl=c-I(%cUGDOaSB^V-@yEw:~z26rd*90<@Z5WpE: /');
define('AUTH_SALT',        '<h#,mUqPDF@[nj],WO&wD<S!VO7y[Ma>P~2-.&RVH4hNhWe`UQp_sF_y3!wo[:oY');
define('SECURE_AUTH_SALT', '%0=g`bpO=hNX:OaEZi%!k_o-VRnr996uXg.R9R9J5zez|&{@EXFHj$6yJBU1X!Do');
define('LOGGED_IN_SALT',   'p)8jvk|zc!o]@9O(*;1&9DJu=H4OS!QoCpi]Wa:wKuzm%=DN.ji_B^Ql`vf}$ sT');
define('NONCE_SALT',       'V%=T&>(JY6|+!*v2Aa(sKv:,]z_Mrg5:bE~O%^PUov1B[z8O%95#uq4-d}~2dmBs');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpza_';

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
