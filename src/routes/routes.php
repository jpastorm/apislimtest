<?php

$app->get('/{token}','UserController:GetUsers');
$app->post('/adduser','UserController:AddUser');
$app->post('/login','UserController:Login');
$app->post('/check','UserController:Check');
 ?>
