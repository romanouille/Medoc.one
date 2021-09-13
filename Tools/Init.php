<?php
$db = new PDO("pgsql:dbname=medoc;host=127.0.0.1", "postgres", "azerty", [PDO::ATTR_PERSISTENT => true]);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
