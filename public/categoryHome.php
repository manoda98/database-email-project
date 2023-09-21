<?php
try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM CATEGORY";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<ul>
    <li><a href="createCategory.php"><strong>Create Category</strong></a> - create a category</li>
</ul>
<?php
if ($result && $statement->rowCount() > 0) { ?>
    <h2>Latest Users</h2>

    <table>
        <thead>
            <tr>
                <th>Category Id</th>
                <th>Category Type</th>
                <th>Colour</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($result as $row) { ?>
        <tr>
            <td><?php echo escape($row["category_id"]); ?></td>
            <td><?php echo escape($row["category_type"]); ?></td>
            <td><?php echo escape($row["colour"]); ?></td>
            <td><a href="viewCategory.php?category_id=<?php echo escape($row["category_id"]); ?>">View</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php } else { ?>
    <blockquote>No results found</blockquote>
<?php }
?>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
