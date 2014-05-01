<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'cl52-r2f-accp');

/** MySQL database username */
define('DB_USER', 'cl52-r2f-accp');

/** MySQL database password */
define('DB_PASSWORD', '9fxV6mXt^');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'Rp-MWAdBTAffDAq_d8B57/wKze1TZG2m7bRiJKktqiUMJ!PZw8))ix=+CupasZKI');
define('SECURE_AUTH_KEY',  '7nmMbXhMotVlECEAAWHycBQpeIrz8ho2wv0i!V^-+aznC=HEkr08c/xV-Qs8be6d');
define('LOGGED_IN_KEY',    '7lbAJ3Gs9NfgCP#JCL=p=_if4eFF=)uCVb+)/BAaJvSb_d02slJ!AsyXMaEknrsX');
define('NONCE_KEY',        'MJm9Pb#m7e!^Z(1zZfRbtKnD3OW7NHv5QfG6mmse!3Ui-_WvT4VWNaFWEccoqFrx');
define('AUTH_SALT',        'jxAyC)UoclE/f#cv!3IM!lczhv(Jgq7VSRge^_cF)/W6wtGh!PtVxylxTaYxnZJ2');
define('SECURE_AUTH_SALT', 'HP#j!2-djujG5gB8p)DYzp/dd!9hJMJefl+Dz(aaH/i(voHZYMcrWJb6bbl26^os');
define('LOGGED_IN_SALT',   'VwAegQIp24DpsBk9QdMXEhadTiR_(KZmyoX2NHMhMq9pzXfErTOci(NrJ8MX-XPB');
define('NONCE_SALT',       '+tayVCF/gcN7Q-W(ZNsBbWv+HgBq7B(nyW/iw1T8E5#pR4J2gS7yqXWKGrVOqrOe');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/**
 *  Change this to true to run multiple blogs on this installation.
 *  Then login as admin and go to Tools -> Network
 */
define('WP_ALLOW_MULTISITE', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/* Destination directory for file streaming */
define('WP_TEMP_DIR', ABSPATH . 'wp-content/');

