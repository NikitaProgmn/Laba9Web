<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Reservation</title>
    <link type="text/css" rel="stylesheet" href="media/layout.css" />
    <script src="js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
</head>
<body>
<?php
    require_once '_db.php';

   
    $rooms = $db->query('SELECT * FROM rooms');

    $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : '';
    $end = isset($_GET['end']) ? htmlspecialchars($_GET['end']) : '';
    $resource = isset($_GET['resource']) ? $_GET['resource'] : '';
?>
    <form id="f" action="backend_create.php" method="post" style="padding:20px;">
        <h1>New Reservation</h1>

        <div>Name:</div>
        <div><input type="text" id="name" name="name" required /></div>

        <div>Start:</div>
        <div><input type="text" id="start" name="start" value="<?php echo $start ?>" required /></div>

        <div>End:</div>
        <div><input type="text" id="end" name="end" value="<?php echo $end ?>" required /></div>

        <div>Room:</div>
        <div>
            <select id="room" name="room" required>
                <?php 
                    foreach ($rooms as $room) {
                        $selected = ($resource == $room['id']) ? ' selected="selected"' : '';
                        echo "<option value=\"{$room['id']}\"$selected>{$room['name']}</option>";
                    }
                ?>
            </select>
        </div>

        <div class="space">
            <input type="submit" value="Save" /> 
            <a href="javascript:window.close();">Cancel</a>
        </div>
    </form>
</body>
</html>
