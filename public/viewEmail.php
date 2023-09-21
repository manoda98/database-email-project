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

    $sql = "SELECT * FROM EMAIL WHERE id = :id";

    $id = $_GET['emailId'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<?php

if ($result && $statement->rowCount() > 0) { ?>
    <h2>View Email No : <?php echo escape($_GET['emailId']); ?></h2>


    <?php foreach ($result as $row) { ?>
        <li><strong>Sender Email : </strong><?php echo escape($row["sender"]); ?></li>
        <li><strong>Receiver Email : </strong><?php echo escape($row["receiver"]); ?></li>
        <li><strong>Date : </strong><?php echo escape($row["date"]); ?></li>
        <li><strong>Subject : </strong><?php echo escape($row["subject"]); ?></li>
        <li><strong>Message : </strong><?php echo escape($row["message"]); ?></li>
        <li><strong>CC : </strong><?php echo escape($row["cc"]); ?></li>
        <li><strong>BCC : </strong><?php echo escape($row["bcc"]); ?></li>
    <?php } ?>
</table>
<?php } else { ?>
    <blockquote>No results found for email id : <?php echo escape($_GET['emailId']); ?>.</blockquote>
<?php }
?>
<a href="editEmail.php?emailId=<?php echo escape($_GET['emailId']); ?>">Edit email</a><br>
<a href="emailHome.php">Back to latest emails</a>

<?php require "templates/footer.php"; ?>
