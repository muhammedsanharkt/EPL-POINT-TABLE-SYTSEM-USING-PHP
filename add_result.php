<?php
include 'db.php';
$teams = $conn->query("SELECT id, name FROM teams");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $score1 = (int)$_POST['score1'];
    $score2 = (int)$_POST['score2'];

    if ($team1 == $team2) {
        die("A team can't play against itself.");
    }

    $conn->query("UPDATE teams SET played = played + 1 WHERE id IN ($team1, $team2)");
    $conn->query("UPDATE teams SET goals_for = goals_for + $score1, goals_against = goals_against + $score2, goal_difference = goal_difference + ($score1 - $score2) WHERE id = $team1");
    $conn->query("UPDATE teams SET goals_for = goals_for + $score2, goals_against = goals_against + $score1, goal_difference = goal_difference + ($score2 - $score1) WHERE id = $team2");

    if ($score1 > $score2) {
        $conn->query("UPDATE teams SET won = won + 1, points = points + 3 WHERE id = $team1");
        $conn->query("UPDATE teams SET lost = lost + 1 WHERE id = $team2");
    } elseif ($score1 < $score2) {
        $conn->query("UPDATE teams SET won = won + 1, points = points + 3 WHERE id = $team2");
        $conn->query("UPDATE teams SET lost = lost + 1 WHERE id = $team1");
    } else {
        $conn->query("UPDATE teams SET draw = draw + 1, points = points + 1 WHERE id IN ($team1, $team2)");
    }

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Match Result</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Add Match Result</h2>
  <form method="post">
    <label for="team1">Team 1:</label>
    <select name="team1" required>
      <?php while ($t = $teams->fetch_assoc()) echo "<option value='{$t['id']}'>{$t['name']}</option>"; ?>
    </select>

    <label for="score1">Score:</label>
    <input type="number" name="score1" required>

    <br><br>

    <?php $teams->data_seek(0); ?>
    <label for="team2">Team 2:</label>
    <select name="team2" required>
      <?php while ($t = $teams->fetch_assoc()) echo "<option value='{$t['id']}'>{$t['name']}</option>"; ?>
    </select>

    <label for="score2">Score:</label>
    <input type="number" name="score2" required>

    <br><br>
    <input type="submit" value="Submit Result">
  </form>
  <p><a href="index.php">← Back</a></p>
</div>
</body>
</html>
