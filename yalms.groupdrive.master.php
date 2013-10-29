<?php
set_time_limit( 0);
ob_implicit_flush( 1);
//ini_set( 'memory_limit', '4000M');
for ( $prefix = is_dir( 'ajaxkit') ? 'ajaxkit/' : ''; ! is_dir( $prefix) && count( explode( '/', $prefix)) < 4; $prefix .= '../'); if ( ! is_file( $prefix . "env.php")) $prefix = '/web/ajaxkit/'; if ( ! is_file( $prefix . "env.php")) die( "\nERROR! Cannot find env.php in [$prefix], check your environment! (maybe you need to go to ajaxkit first?)\n\n");
if ( is_file( 'requireme.php')) require_once( 'requireme.php'); else foreach ( array( 'functions', 'env') as $k) require_once( $prefix . "$k.php"); clinit(); 
require_once( 'common.php'); extract( jsonload( 'env.json')); // WDIR, BLOCKSIZE, SCALE, PEERS: { url: 'master' | 'peer', ...}
$s = hm( $_GET, $_POST); htg( $s);


if ( $action == 'getpeers') { $JO[ 'peers'] = $PEERS; die( jsonsend( $JO)); }
if ( $action == 'check') { // epoch
 	if ( ! is_file( "$WDIR.status"))	jsondump( array(), "$WDIR.status");
 	
}
if ( $action == 'upload') { // FILES[ 'block.json']
	
}



?>