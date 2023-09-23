<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
require "../config.php";
require "../common.php";
$emailSelectOption = "";
try  {
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT * FROM EMAIL";
    $result = $connection -> query($sql);

    if($result -> rowCount() > 0) {
        foreach ($result as $row) {
            $id = $row["id"];
            $subject = escape($row["subject"]);
            $emailSelectOption .= "<option value='$id'>$subject</option>";
        }
    } else {
        $emailSelectOption = "<option value='0'>No available emails</option>";
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

if (isset($_POST['submit'])) {
    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        // Start a transaction
        $connection->beginTransaction();

        $new_category = array(
            "category_type"  => $_POST['category_type'],
            "colour"   => $_POST['colour'],
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "CATEGORY",
                implode(", ", array_keys($new_category)),
                ":" . implode(", :", array_keys($new_category))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_category);
        $categoryId = $connection -> lastInsertId();

        if(!empty($_POST['selected_emails'])) {
            foreach ($_POST['selected_emails'] as $id) {
                $sql = "INSERT INTO EMAIL_CATEGORY (email_id , category_id) VALUES (:email_id , :category_id)";
                $statement = $connection->prepare($sql);
                $statement->execute(array(':email_id' => $id, ':category_id' => $categoryId));
            }
        }
        // Commit the transaction
        $connection->commit();

    } catch(PDOException $error) {
    // Rollback the transaction if an error occurs
        $connection->rollBack();
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote>Category <?php echo $_POST['category_type']; ?> successfully created.</blockquote>
<?php } ?>

<h2>Add a category to email</h2>

<form method="post">
    <label for="category_type">Category Type</label>
    <input type="text" name="category_type" id="category_type">
    <label for="colour">Colour</label>
    <input type="text" name="colour" id="colour">
    <label for="selected_emails">Select Emails for Category</label>
    <select multiple name="selected_emails[]" id="selected_emails">
        <?php echo $emailSelectOption; ?>
    </select>
    <input type="submit" name="submit" value="Submit">

</form>

<a href="categoryHome.php">Back to home</a>

<?php require "templates/footer.php"; ?>
