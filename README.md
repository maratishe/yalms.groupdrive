
YALMS.groupdrive is analog of Google Drive, Dropbox, etc. but implements a block-wise distributed P2P-like sync logic. 


Design
=======
See `diagrams.pdf` for details on the design. *Slides* will be shared soon.

Deployment
=======

Make sure your *Master* and all *Peers* have web servers on them.  The project includes *portable TinyWeb Server* which can be run on Windows machines without installations. On Linux machines (VMs or physical) access to Apache is trivial.  If not, there is *TinyWeb Server* or *TightHTTP* for Linux which are small and easy to run servers.  Note that you need PHP support because all APIs are PHP.

Then:

1. Deploy `yalms.groupdrive.master.php` inside web server at Master.
2. Deploy `yalms.groupdrive.peer.server.php` inside web server at each peer. 
3. Edit `env.json` in each server to tell the server about its environment. Note that tools run from CLI can be configured through command line parameters. This is not possible with web APIs which is why server scripts have to be configured through `env.json` on each request. 

This should do it.

CLI Examples
==============

Global *trick*: run PHP scripts without parameters to learn which parameters are expected. 

Running sequence:

1. Master (first run): `php yalms.groupdrive.master.firstrun.php`  Will initiate the master copy of your drive. Ran separately because it takes time.
2. Clients in each peer: `php yalms.groupdrive.peer.client.php`  Will run continuously, waiting for updates and uploading local updates when detected. 

**Note:**  `yalms.groupdrive.master.php` and `yalms.groupdrive.peer.server.php` are web APIs and will only respond to HTTP requests.  See the deployment above. 



Basics: how to send POST request using `wget` in commandline. The *trick* is to encode `post.txt` as you would encode a URL, i.e. `k1=v1&k2=v2 ...`:
`wget http://YOUR.URL --post-file=post.txt -O status.json`


