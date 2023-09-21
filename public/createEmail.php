<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_email = array(
            "sender"       => $_POST['sender'],
            "receiver"     => $_POST['receiver'],
            "subject"      => $_POST['subject'],
            "message"      => $_POST['message'],
            "cc"           => $_POST['cc'],
            "bcc"          => $_POST['bcc'],
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "EMAIL",
                implode(", ", array_keys($new_email)),
                ":" . implode(", :", array_keys($new_email))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_email);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote>Email to <?php echo $_POST['receiver']; ?> successfully sent.</blockquote>
<?php } ?>

<h2>Add a email message</h2>

<form method="post">
    <label for="sender">Sender Email</label>
    <input type="text" name="sender" id="sender">
    <label for="receiver">Receiver Email</label>
    <input type="text" name="receiver" id="receiver">
    <label for="subject">Subject</label>
    <input type="text" name="subject" id="subject">
    <label for="message">Message</label>
    <input type="text" name="message" id="message">
    <label for="cc">CC</label>
    <input type="text" name="cc" id="cc">
    <label for="bcc">BCC</label>
    <input type="text" name="bcc" id="bcc">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="emailHome.php">Back to home</a>

<?php require "templates/footer.php"; ?>
