<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$time = date('l d F Y, h:i:s A');
echo "data: {$time}\n\n";
sleep(rand(1, 3));
flush();
?> 