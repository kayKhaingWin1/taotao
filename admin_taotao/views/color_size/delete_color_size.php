<?php
include_once __DIR__ . '/../../controller/ColorSizeController.php';

$type = $_GET['type'] ?? 'color';
$id = $_GET['id'] ?? 0;
$controller = new ColorSizeController();
$controller->deleteItem($type, $id);

header("location: color_size_list.php?{$type}_status=success");
exit;
