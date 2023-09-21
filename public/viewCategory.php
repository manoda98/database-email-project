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

    $sql = "SELECT * FROM CATEGORY WHERE category_id = :category_id";

    $category_id = $_GET['category_id'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':category_id', $category_id, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();

    $sql2 = "SELECT * FROM `email_category` INNER JOIN email ON email_category.email_id = email.id WHERE category_id = :category_id";


    $statement2 = $connection->prepare($sql2);
    $statement2->bindParam(':category_id', $category_id, PDO::PARAM_STR);
    $statement2->execute();

    $result2 = $statement2->fetchAll();


} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<?php

if ($result && $statement->rowCount() > 0) { ?>
    <h2>View Category No : <?php echo escape($_GET['category_id']); ?></h2>


    <?php foreach ($result as $row) { ?>
        <li><strong>Category Type : </strong><?php echo escape($row["category_type"]); ?></li>
        <li><strong>Colour : </strong><?php echo escape($row["colour"]); ?></li>
    <?php } ?>
</table>
<?php } else { ?>
    <blockquote>No results found for category id : <?php echo escape($_GET['category_id']); ?>.</blockquote>
<?php }
?>

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
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result2 as $row) { ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["date"]); ?> </td>
            <td><?php echo escape($row["sender"]); ?></td>
            <td><?php echo escape($row["receiver"]); ?></td>
            <td><?php echo escape($row["subject"]); ?></td>
            <td><?php echo escape($row["message"]); ?></td>
            <td><?php echo escape($row["cc"]); ?></td>
            <td><?php echo escape($row["bcc"]); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<!--<a href="editEmail.php?emailId=<?php echo escape($_GET['emailId']); ?>">Edit email</a><br>-->
<a href="categoryHome.php">Back to categories</a>

<?php require "templates/footer.php"; ?>
