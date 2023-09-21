<?php

/**
 * Function to query information based on
 * a parameter: in this case, receiverEmail.
 *
 */

if (isset($_POST['submit'])) {
    try  {

        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *
                        FROM EMAIL
                        WHERE sender = :sender";

        $sender = $_POST['sender'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':sender', $sender, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>Sender Email</th>
                    <th>Receiver Email</th>
                    <th>Subject</th>
                    <th>Message</th>
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
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['sender']); ?>.</blockquote>
    <?php }
} ?>

<h2>Find user based on receiver Email</h2>

<form method="post">
    <label for="sender">Sender Email</label>
    <input type="text" id="sender" name="sender">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="emailHome.php">Back to home</a>

<?php require "templates/footer.php"; ?>
