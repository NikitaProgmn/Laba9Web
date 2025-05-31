<?php
require_once '_db.php';


date_default_timezone_set("UTC");


$start = isset($_GET['start']) ? $_GET['start'] : null;
$end = isset($_GET['end']) ? $_GET['end'] : null;

if (!$start || !$end) {
    http_response_code(400); 
    echo json_encode(['error' => 'Missing "start" or "end" parameters']);
    exit;
}

try {
    
    $stmt = $db->prepare("SELECT * FROM reservations WHERE NOT ((end <= :start) OR (start >= :end))");
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();
    $result = $stmt->fetchAll();

    class Event {}
    $events = [];

    foreach($result as $row) {
        $e = new Event();
        $e->id = $row['id'];
        $e->text = $row['name'];
        $e->start = $row['start'];
        $e->end = $row['end'];
        $e->resource = $row['room_id'];
        $e->bubbleHtml = "Reservation details: " . $e->text;
        $e->status = $row['status'];
        $e->paid = $row['paid'];
        $events[] = $e;
    }

    header('Content-Type: application/json');
    echo json_encode($events);

} catch (Exception $e) {

    http_response_code(500); 
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
