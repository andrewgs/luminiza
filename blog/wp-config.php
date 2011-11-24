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
define('DB_NAME', 'db_luminiza');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '{bvthfVecrkm57');

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
define('AUTH_KEY',         'I5& H56Tu2c4}s4IBs3El_ie^3+/EfDbuej7<lR/A2aU6/5i;LpF@7,vW/iSBX7{');
define('SECURE_AUTH_KEY',  'n>B>a17-<KnQchj{eBn9::y5cIk-^(C3^,GHxh_.9L<88}AthfC B+B7,W0T*(tu');
define('LOGGED_IN_KEY',    '{irb1PZJ*m;?{wcPPZq4[WJvTo?h!0+XP#&uwbd}]WmS>f#4(m-FK&hNbb^BJ._h');
define('NONCE_KEY',        '-h|cAUJQ-n#)Xzm<gfJ%%}n*my|1jZRzT8q|2;@d9|M5^P1h|+R1n*{k~X/)$Iqj');
define('AUTH_SALT',        'hYHkwt0ey*UvXfNNJ#zu)QI@*rupYMzd<Kt&:0Z~1PAUo@aO8-fT(tS;LR?]J0[h');
define('SECURE_AUTH_SALT', '?zDq:.YY SDmc_O983|i11%d-]Z=~,z&/O<PHqEd-as-/M:w.:hy1iP!lV3tj$n?');
define('LOGGED_IN_SALT',   '8%+6ofY.kla=WMmQBH0RCm{{_q!1FGU`=`n(T^=DA](^} U=RST,S}ds@l<ClZ@:');
define('NONCE_SALT',       '(G-4 _@=jRO/Fr<*<J!o^#4^JmTJ{5h6<A+&B!U+erQ/D o-N?d}XSy*>w#K5euJ');

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
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
