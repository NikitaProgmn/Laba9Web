<?php
require_once '_db.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<h2>Error: Missing or invalid reservation ID.</h2>");
}

$id = (int)$_GET['id'];


$stmt = $db->prepare("SELECT * FROM reservations WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$reservation) {
    die("<h2>Error: Reservation with ID $id not found.</h2>");
}


$rooms = $db->query("SELECT * FROM rooms");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Reservation</title>
</head>
<body>
    <form id="f" action="backend_update.php" method="post" style="padding:20px;">
        <input type="hidden" name="id" value="<?php echo $reservation['id'] ?>" />

        <div>Name:</div>
        <div><input type="text" name="name" value="<?php echo htmlspecialchars($reservation['name']) ?>" required /></div>

        <div>Start:</div>
        <div><input type="datetime-local" name="start" value="<?php echo date('Y-m-d\TH:i', strtotime($reservation['start'])) ?>" required /></div>

        <div>End:</div>
        <div><input type="datetime-local" name="end" value="<?php echo date('Y-m-d\TH:i', strtotime($reservation['end'])) ?>" required /></div>

        <div>Room:</div>
        <div>
            <select name="room" required>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['id'] ?>" <?= $room['id'] == $reservation['room_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($room['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>Status:</div>
        <div>
            <select name="status" required>
                <?php
                    $statuses = ["New", "Confirmed", "Arrived", "CheckedOut"];
                    foreach ($statuses as $status) {
                        $selected = $reservation['status'] == $status ? 'selected' : '';
                        echo "<option value=\"$status\" $selected>$status</option>";
                    }
                ?>
            </select>
        </div>

        <div>Paid:</div>
        <div>
            <select name="paid" required>
                <?php
                    $paidOptions = [0, 50, 100];
                    foreach ($paidOptions as $option) {
                        $selected = $reservation['paid'] == $option ? 'selected' : '';
                        echo "<option value=\"$option\" $selected>{$option}%</option>";
                    }
                ?>
            </select>
        </div>

        <div class="space">
            <input type="submit" value="Save Changes" />
            <a href="javascript:window.close();">Cancel</a>
        </div>
    </form>
</body>
</html>
