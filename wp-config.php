<?php
/** Enable W3 Total Cache */
//Added by WP-Cache Manager


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
//Added by WP-Cache Manager
//Added by WP-Cache Manager
define( 'WPCACHEHOME', '/nfs/c03/h06/mnt/50925/domains/v3.geekwiseacademy.com/html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'geekwise');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');


/**#@+
* Authentication Unique Keys and Salts.
*
* Change these to different unique phrases!
* You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
* You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
*
* @since 2.6.0
*/
define('AUTH_KEY', 'XH3GjT1fV43f5dv4fQbBPoE26FXkyJEB9ON9uYeRmG7wzTCLpMApSNzIBIw80i81');
define('SECURE_AUTH_KEY', 'q47ey+hlV48OEpS009mX3c76UOTIRV7bzDR4jv/R7NQq50GoyUkpM4p8AprDT3vl');
define('LOGGED_IN_KEY', 'xqypi28zo2UVUlfi8tIHv+BScLnbCYlZbUo99QyXI/AyCw66tOyRIK3vReNsRD1F');
define('NONCE_KEY', '/1GG04T88Ct/ifGutzu4CwgjjbXsvR9u2x2YYNBv2NVATxfK4puOnq7+rfUrjY9Y');
define('AUTH_SALT', 'IJawD/aQ4x4qm8vIVTugN7Os5WmZxg+bGshWEJFpcx85F8f9WNNSJHROT+hpWcE+');
define('SECURE_AUTH_SALT', 'utpoxMp6gJhhJKvSuLy6X9LqMgXPVWGFXIJ34ToUaPnq9KbArsgX8xA1wyCi+gU5');
define('LOGGED_IN_SALT', 'ZEJVgGZDGD9Fp9thYxOzo8dPnQZIS0jHhI/tWnfQZ83DoHv+B+BesnyJoMXel4sn');
define('NONCE_SALT', 'T7aCx8hDTNs68NYo0EiTMDHaGvJjzCsyZFA+son2Rv6FDJobjzPWKrzgEYuIVowR');
define('NONCE_SALT', 'T7aCx8hDTNs68NYo0EiTMDHaGvJjzCsyZFA+son2Rv6FDJobjzPWKrzgEYuIVowR');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

