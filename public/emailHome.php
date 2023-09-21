<?php

/**
 * Function to query information based on
 * a parameter: in this case, receiverEmail.
 *
 */

try  {

    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM EMAIL ORDER BY date DESC limit 3";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<ul>
    <li><a href="createEmail.php"><strong>Create Email</strong></a> - create an email</li>
    <li><a href="searchEmail.php"><strong>Search Email</strong></a> - find an email</li>
</ul>
<?php
if ($result && $statement->rowCount() > 0) { ?>

    <h2>Latest emails</h2>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Date</th>
                <th>Sender Email</th>
                <th>Receiver Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>CC</th>
                <th>BCC</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($result as $row) { ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["date"]); ?> </td>
            <td><?php echo escape($row["sender"]); ?></td>
            <td><?php echo escape($row["receiver"]); ?></td>
            <td><?php echo escape($row["subject"]); ?></td>
            <td><?php echo escape($row["message"]); ?></td>
            <td><?php echo escape($row["cc"]); ?></td>
            <td><?php echo escape($row["bcc"]); ?></td>
            <td> <a href="viewEmail.php?emailId=<?php echo escape($row["id"]); ?>">view</td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php } else { ?>
    <blockquote>No results found </blockquote>
<?php }
?>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
