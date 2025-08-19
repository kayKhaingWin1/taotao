<?php
include_once __DIR__ . '/../../controller/TownshipController.php';
$id = $_GET['id'];
$township_controller = new TownshipController();
if ($township_controller->deleteTownship($id)) {
    header('location: township_list.php?delete_status=success');
    exit;
}
