<?php

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @version $Id$
 */

// This will let the permissions be 0777
// needed to get the permission to erase cache file
umask(0000); 

$app = require __DIR__.'/../src/app.php';
$app->run();
