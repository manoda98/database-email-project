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
<!--<a href="editEmail.php?emailId=<?php echo escape($_GET['emailId']); ?>">Edit email</a><br>-->
<a href="categoryHome.php">Back to categories</a>

<?php require "templates/footer.php"; ?>
