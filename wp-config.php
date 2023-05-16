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
define( 'DB_NAME', 'wordpress-local' );

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


// Memory limit
define('WP_MEMORY_LIMIT', '512M');


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
define( 'AUTH_KEY',         'KrN=`efSQM_t[r@yDTl.dQPnLGU_R55eM64`cIZaia0B xQ%K-N6&u^=N.D,]v`>' );
define( 'SECURE_AUTH_KEY',  '2O#,!E`~~m7J0WZj!fT[uxWizlb[>I@NI$a^&?Fxp{yCWfZzEpXS>]Lz:hN#q)7R' );
define( 'LOGGED_IN_KEY',    '_-N@C!][>PWJl6*A_R2x0$;h+]B_X!FdIa!0#cIa@J6z{s|bt@Jq@16.N-2F+u6T' );
define( 'NONCE_KEY',        '  K0/-X+>s469sHsN61[N1Xi,cO6mbHz!wem>^&`LS[&+Jm<FU8sh=ovOI(MLV8*' );
define( 'AUTH_SALT',        'W}*h*S4f())0Bk4beNO1/JGVP:jAI[A>2p2@W;zS}eg$=UruHa}5gAG0TVt=gO[o' );
define( 'SECURE_AUTH_SALT', 'iNSC>7;H<x+mehNC[n|f#KxeDB.%}Dt:$PRgg-&,e=oK|Hl)h=?b@}6tjGdtfSq*' );
define( 'LOGGED_IN_SALT',   'nQ2-7<WU(fh9q*BN]p{>Pa 0*EJDFr(}I:(+:mMn2Kg}B/~80.JZ8S.[.oz2>|eX' );
define( 'NONCE_SALT',       '>FQiKgu1I[a`:UE`@6JqSim=T(![GKvw{&<7D^]2}`:nd.L,XIrjrc)A5j-wR.@Q' );

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
