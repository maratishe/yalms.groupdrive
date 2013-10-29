<?php
set_time_limit( 0);
ob_implicit_flush( 1);
//ini_set( 'memory_limit', '4000M');
for ( $prefix = is_dir( 'ajaxkit') ? 'ajaxkit/' : ''; ! is_dir( $prefix) && count( explode( '/', $prefix)) < 4; $prefix .= '../'); if ( ! is_file( $prefix . "env.php")) $prefix = '/web/ajaxkit/'; if ( ! is_file( $prefix . "env.php")) die( "\nERROR! Cannot find env.php in [$prefix], check your environment! (maybe you need to go to ajaxkit first?)\n\n");
if ( is_file( 'requireme.php')) require_once( 'requireme.php'); else foreach ( array( 'functions', 'env') as $k) require_once( $prefix . "$k.php"); clinit(); 
require_once( 'common.php'); extract( jsonload( 'env.json')); // WDIR, BLOCKSIZE, SCALE, PEERS: { url: 'master' | 'peer', ...}
$s = hm( $_GET, $_POST); htg( $s);


if ( $action == 'check') { // status
 	if ( ! is_file( "$WDIR.status"))	jsondump( array(), "$WDIR.status");
 	$status = json2h( $status, true, null, true);
 	if ( ! $status) die( jsonsend( jsonerr( 'could not unpack')));
 	$diffs = statuspeerdiff( $status);
 	if ( ! count( $diffs)) { $JO[ 'info'] = null; die( jsonsend( $JO)); }
 	extract( lr( $diffs)); // relpath, file, blockpos, hash
 	$in = fopen( "$WDIR/$relpath/$file", 'rb');
 	fread( $in, $blockpos * $BLOCKSIZE); $block = null;  
 	if ( ! feof( $in)) $block = fread( $in, $BLOCKSIZE); if ( ! $block) die( jsonsend( jsonerr( "Did not find stuff at [$relpath/$file:$blockpos]")));
 	fclose( $in); $filehash = md5_file( "$WDIR/$relpath/$file");
 	$block = s2s64( bzcompress( $block));
 	$JO[ 'info'] = compact( ttl( 'relpath,file,blockpos,hash,block,filehash'));
 	die( jsonsend( $JO));
}
if ( $action == 'upload') { 
	
}


?>