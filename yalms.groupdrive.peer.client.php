<?php
set_time_limit( 0);
ob_implicit_flush( 1);
//ini_set( 'memory_limit', '4000M');
for ( $prefix = is_dir( 'ajaxkit') ? 'ajaxkit/' : ''; ! is_dir( $prefix) && count( explode( '/', $prefix)) < 4; $prefix .= '../'); if ( ! is_file( $prefix . "env.php")) $prefix = '/web/ajaxkit/'; if ( ! is_file( $prefix . "env.php")) die( "\nERROR! Cannot find env.php in [$prefix], check your environment! (maybe you need to go to ajaxkit first?)\n\n");
if ( is_file( 'requireme.php')) require_once( 'requireme.php'); else foreach ( array( 'functions', 'env') as $k) require_once( $prefix . "$k.php"); clinit(); 
require_once( 'common.php'); extract( jsonload( 'env.json')); // WDIR, BLOCKSIZE, SCALE, STATUS, STATUSFILE, PEERS: { url: 'master' | 'peer', ...}
extract( hvak( $PEERS)); $MASTER = $master; // master



if ( ! is_file( "$WDIR.status")) jsondump( array(), "$WDIR.status");
list( $status, $h) = procwget( $master, 'action=getpeers'); if ( ! $status) die( "ERROR! Could not get peers from master at $master\n");
extract( $h); $PEER2H = array(); peersinit(); // PEERS


echo "\n\n"; $e = echoeinit(); $sleep = 1000000;
$FS = array(); foreach ( flgetall( $WDIR) as $path => $file) $FS[ "$path"] = compact( ttl( 'file'));
while ( 1) {
	usleep( $sleep); $sleep = 1000000;
	// download remote changes
	foreach ( peersget() as $url) { 
		list( $status, $v) = reqcheck( $url); // null | block: { epoch, relpath, file, blockpos, hash, block(base64( bzip2)), filehash}
		if ( ! $status) die( " ERROR! [$v]\n");
		if ( ! $v) continue;
		fileupdate( $v);
	}
	// upload local changes
	$ks = hk( $FS); $changes = array(); // [ { path, file, blockpos, type}, ...]
	for ( $i = count( $ks) - 1; $i >= 0; $i++) {
		$path = $ks[ $i]; unset( $h); $h =& $FL[ "$path"];
		if ( ! is_file( "$path")) { `rm -Rf $path*`; $type = 'delfile'; lpush( $changes, compact( ttl( 'path,file,type'))); continue; }
		if ( ! isset( $h[ 'profile'])) $h[ 'profile'] = fdeltaprofile( $path, $BLOCKSIZE);
		extract( $h); // file, profile
		list( $status, $profile2) = fdeltagracefulcheck( $path, $profile);
		unset( $FS[ "$path"]); $FS[ "$path"] = $h; $FS[ "$path"][ 'profile'] = $profile2;
		if ( ! $status) continue; 	// unchanged, keep going
		// file changed, try to upload
		extract( fdeltareport( $profile, $profile2, true)); // details
		foreach ( $details as $blockpos => $type) lpush( $changes, compact( ttl( 'path,file,blockpos,type')));
		break;	// do one file at a time
	}
	foreach ( $changes as $change) {  // path, file, blockpos, type 
		
	}
	
}


?>