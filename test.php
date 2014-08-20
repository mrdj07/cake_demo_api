<?php
echo "<h1>Correct Queries</h1>";

echo "<h2>GET /clients</h2>";
echo "<pre>".exec('curl cakemail.test.local.com/clients')."</pre>";

$rnd1 = rand(1,100);
echo "<h2>GET /clients/".$rnd1."</h2>";
echo "<pre>". exec('curl cakemail.test.local.com/clients/'.$rnd1)."</pre>";

echo "<h2>POST /clients</h2>";
echo "<pre>". exec('curl -X POST -d "firstname=tayeule&lastname=estlaide" http://cakemail.test.local.com/clients')."</pre>";

$rnd2 = rand(1,100);
echo "<h2>PUT /clients/".$rnd2."</h2>";
echo "<pre>". exec('curl -X PUT -d "firstname=tayeule&lastname=estlaide" http://cakemail.test.local.com/clients/'.$rnd2)."</pre>";

$rnd3 = rand(1,100);
echo "<h2>DELETE /clients/".$rnd3."</h2>";
echo "<pre>". exec('curl -X DELETE http://cakemail.test.local.com/clients/'.$rnd3)."</pre>";

echo "<hr/>";

echo "<h1>Incorrect Queries</h1>";

echo "<h2>GET /cluents/</h2>";
echo "<pre>".exec('curl cakemail.test.local.com/cluents/')."</pre>";

echo "<h2>GET /clients/</h2>";
echo "<pre>".exec('curl cakemail.test.local.com/clients/')."</pre>";

$rnd1 = rand(1,100);
echo "<h2>POST /clients/".$rnd1."</h2>";
echo "<pre>". exec('curl -X POST -d "firstname=tayeule&lastname=estlaide" http://cakemail.test.local.com/clients/'.$rnd1)."</pre>";

echo "<h2>POST /client with wrong params</h2>";
echo "<pre>". exec('curl -X POST -d "firstnamez=tayeule&lastname=estlaide" http://cakemail.test.local.com/clients')."</pre>";

echo "<h2>PUT /clients</h2>";
echo "<pre>". exec('curl -X PUT -d "firstname=tayeule&lastname=estlaide" http://cakemail.test.local.com/clients/')."</pre>";

$rnd2 = rand(1,100);
echo "<h2>PUT /clients/ohreally/".$rnd2."</h2>";
echo "<pre>". exec('curl -X PUT -d "firstname=tayeule&lastname=estlaide" http://cakemail.test.local.com/clients/ohreally/'.$rnd2)."</pre>";


echo "<h2>DELETE /clients</h2>";
echo "<pre>". exec('curl -X DELETE http://cakemail.test.local.com/clients/')."</pre>";
