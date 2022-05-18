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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'flowerst_wp01' );

/** MySQL database username */
define( 'DB_USER', 'flowerst_wp01' );

/** MySQL database password */
define( 'DB_PASSWORD', 'flower2022' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'kV/XJoM9Z7h5ryj0M9M3etMFBn0ksbTpjSNkVCz6j5fRrHH9TNW3ImCKH+UeR3zNAy3tcm5G7+LkGqjnWDjhqg==');
define('SECURE_AUTH_KEY',  'b1Om6S+vvoHNj8Wp5xhSMlx+DJ+Vav9Yqnc1ZEy45vQVMptyHRRjUheb8+tTjNN2YWCW3Q1PaJK3gAE3sCfB0g==');
define('LOGGED_IN_KEY',    '1wME13muEiKvTQGZgYDbYLI9cnNtM2rpVLyCXmdXJOd2Xml5xg3TjhjmDLY0986aw/KLHhI9H0GUgvkF3x8Htw==');
define('NONCE_KEY',        '88bVxtZLS2yvbGl+y4EAXgfIfPNeOTncVSd6O6/0Wqmshf9d2QtqiTSuPu1SSIV/PENcEDFxhdW4psX5hx3uyw==');
define('AUTH_SALT',        'U562aJ0JHMkoJNfvFaIj6Ey0a0wsixLjTMhl0ueM00knZVnS0xNlDGmdTn57hfJiVXvWrGfGXWGXO9ZUU2+B7Q==');
define('SECURE_AUTH_SALT', 'qoMuCg87VX5hNtxOinFysdzLSjF643gyju6s/i2MYoAuwZ3U2z51RhF5s76CjVlZ6j4Ri9T9NJTJYEkMPlA+qw==');
define('LOGGED_IN_SALT',   'cdRdS07PqmAmDVK3iL1n8EeI2EI5OW50mgU2KgvRHhVJx3YLCo3XkpzjfPg4JFETCQxPqT21GBBWfmd4tGXa9w==');
define('NONCE_SALT',       '4qbJ1Juh+AfuKDN2iSIXw2FkXzmPr2qmNk4hbdidEhoZ6RkeSFLKOb4Z/hzkpb4XPeo5itL4hxY8QYx1NCvt2w==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

define('DISALLOW_FILE_EDIT', false);
define('DISALLOW_FILE_MODS', false);