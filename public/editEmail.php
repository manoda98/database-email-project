<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


try  {
    require "../config.php";
    require "../common.php";
    $connection = new PDO($dsn, $username, $password, $options);

    if (isset($_POST['submit'])) {
        $updated_email = array(
            "sender"       => $_POST['sender'],
            "receiver"     => $_POST['receiver'],
            "subject"      => $_POST['subject'],
            "message"      => $_POST['message'],
            "cc"           => $_POST['cc'],
            "bcc"          => $_POST['bcc'],
        );

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s",
            "EMAIL",
            implode(", ", array_map(function ($column) {
                return "$column = :$column";
            }, array_keys($updated_email))),
            "id = :id"
        );

        $statement = $connection->prepare($sql);
        foreach ($updated_email as $column => $value) {
            $statement->bindValue(":$column", $value);
        }
        $statement->bindParam(':id', $_GET['emailId'], PDO::PARAM_STR);
        $statement->execute();
    }

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

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote>Email to <?php echo $_POST['receiver']; ?> successfully edited.</blockquote>
<?php } ?>

<h2>Add a email message</h2>

<form method="post">
    <?php foreach ($result as $row) { ?>
    <label for="sender">Sender Email</label>
    <input type="text" name="sender" id="sender" value="<?php echo escape($row["sender"]); ?>">
    <label for="receiver">Receiver Email</label>
    <input type="text" name="receiver" id="receiver" value="<?php echo escape($row["receiver"]); ?>">
    <label for="subject">Subject</label>
    <input type="text" name="subject" id="subject" value="<?php echo escape($row["subject"]); ?>">
    <label for="message">Message</label>
    <input type="text" name="message" id="message" value="<?php echo escape($row["message"]); ?>">
    <label for="cc">CC</label>
    <input type="text" name="cc" id="cc" value="<?php echo escape($row["cc"]); ?>">
    <label for="bcc">BCC</label>
    <input type="text" name="bcc" id="bcc" value="<?php echo escape($row["bcc"]); ?>">
    <input type="submit" name="submit" value="Submit">
    <?php } ?>
</form>

<a href="viewEmail.php?emailId=<?php echo escape($row["id"]); ?>">Back to email</a>

<?php require "templates/footer.php"; ?>
