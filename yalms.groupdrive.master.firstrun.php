<?php
set_time_limit( 0);
ob_implicit_flush( 1);
//ini_set( 'memory_limit', '4000M');
for ( $prefix = is_dir( 'ajaxkit') ? 'ajaxkit/' : ''; ! is_dir( $prefix) && count( explode( '/', $prefix)) < 4; $prefix .= '../'); if ( ! is_file( $prefix . "env.php")) $prefix = '/web/ajaxkit/'; if ( ! is_file( $prefix . "env.php")) die( "\nERROR! Cannot find env.php in [$prefix], check your environment! (maybe you need to go to ajaxkit first?)\n\n");
if ( is_file( 'requireme.php')) require_once( 'requireme.php'); else foreach ( array( 'functions', 'env') as $k) require_once( $prefix . "$k.php"); clinit(); 
require_once( 'common.php'); extract( jsonload( 'env.json')); // WDIR, BLOCKSIZE, SCALE, PEERS: { url: 'master' | 'peer', ...}

// initiate server timeline by discovering files for the first time
`rm -Rf $WDIR.status`;
echo "\n\n"; $e = echoeinit();
$H = array(); $size = 0;
foreach ( flgetall( $WDIR) as $path => $file) {
	echoe( $e, "size#$size file#$file  ");
	jsondump( $STATUS, $STATUSFILE); $size = filesize( $STATUSFILE);
}
echo " ALL DONE, server should handle the index from this point on\n";

?>