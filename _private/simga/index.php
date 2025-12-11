<?php
require_once "Products.php";
require_once "dbhelper.php";

// Initialize database connection
$db = new DbHelper("127.0.0.1", "root", "", "salesdb");

// Initialize variables
$name = "";
$size = "";
$barcode = "";
$buttonText = "Add";

// 🧩 Check if user is editing (update mode)
if (isset($_GET['update'])) {
    $name = $_GET['name'] ?? "";
    $size = $_GET['size'] ?? "";
    $barcode = $_GET['barcode'] ?? "";
    $buttonText = "Update";

    echo "Editing product...";
}

// 🧾 Handle form submission (Add or Update)
if (isset($_POST['sub'])) {
    $name = $_POST['name'] ?? "";
    $size = $_POST['size'] ?? "";
    $barcode = $_POST['barcode'] ?? "";

    // If updating an existing product
    if (isset($_GET['update'])) {
        echo "Updating now...";
        $db->updateProduct((int)$_GET['update'], $name, $size, $barcode);
    } else {
        // Adding a new product
        echo "Adding new product...";
        $product = new Products(null, $name, $size, $barcode);
        $db->addProduct($product);
    }

    // Refresh product list
    $allProducts = $db->getAllProducts();
} else {
    // Load all products initially
    $allProducts = $db->getAllProducts();
}

// 🗑 Handle delete
if (isset($_GET['id']) && isset($_GET['up'])) {
    $id = (int)$_GET['id'];
    $db->deleteProduct($id);
    $allProducts = $db->getAllProducts();
}
?>

<!-- 🔗 Link to reset form when updating -->
<?php if (isset($_GET['update'])): ?>
    <a href="index.php">New Record</a>
<?php endif; ?>

<!-- 🧍 Product Form -->
<form method="post" action="">
    <input type="text" name="name" value="<?= $name ?>" placeholder="Name..." required>
    <input type="text" name="size" value="<?= $size ?>" placeholder="Size..." required>
    <input type="text" name="barcode" value="<?= $barcode ?>" placeholder="Barcode..." required>
    <input type="submit" name="sub" value="<?= $buttonText ?>">
</form>

<!-- 📋 Product Table -->
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Size</th>
        <th>Barcode</th>
        <th colspan="2">Actions</th>
    </tr>

    <?php foreach ($allProducts as $prod): ?>
        <tr>
            <td><?= $prod['prod_id'] ?></td>
            <td><?= $prod['name'] ?></td>
            <td><?= $prod['size'] ?></td>
            <td><?= $prod['barcode'] ?></td>
            <td>
                <a href="index.php?id=<?= $prod['prod_id'] ?>&up=1">Delete</a>
            </td>
            <td>
                <a href="index.php?update=<?= $prod['prod_id'] ?>
                    &name=<?= $prod['name'] ?>
                    &size=<?= $prod['size'] ?>
                    &barcode=<?= $prod['barcode'] ?>
                    &up=1">Update</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>