<?php
include 'db.php';
$result = $conn->query("SELECT * FROM teams ORDER BY points DESC, goal_difference DESC, name ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Premier League 2025/26 - Standings</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Premier League 2025/26 - Team Standings</h1>
    <table>
      <tr>
        <th>#</th><th>Team</th><th>Played</th><th>Won</th><th>Draw</th><th>Lost</th>
        <th>GF</th><th>GA</th><th>GD</th><th>Points</th>
      </tr>
      <?php $i = 1; while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= $row['played'] ?></td>
        <td><?= $row['won'] ?></td>
        <td><?= $row['draw'] ?></td>
        <td><?= $row['lost'] ?></td>
        <td><?= $row['goals_for'] ?></td>
        <td><?= $row['goals_against'] ?></td>
        <td><?= $row['goal_difference'] ?></td>
        <td><?= $row['points'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
    <p><a href="add_result.php">Add Match Result</a></p>
  </div>
</body>
</html>
