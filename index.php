<?php
// Initialize an array to hold the items
$items = isset($_POST['items']) ? unserialize($_POST['items']) : array();
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'create') {
    // Add new item with an ID based on the current timestamp
    $new_item = array(
        'id' => time(), // Generate a unique ID based on the current timestamp
        'itemName' => $_POST['itemName'],
        'itemDescription' => $_POST['itemDescription']
    );
    $items[] = $new_item;
} elseif ($action == 'update') {
    // Update existing item
    $index = $_POST['index'];
    $items[$index] = array(
        'id' => $_POST['id'], // Keep the same ID when updating
        'itemName' => $_POST['itemName'],
        'itemDescription' => $_POST['itemDescription']
    );
} elseif ($action == 'delete') {
    // Delete item
    $index = $_POST['index'];
    unset($items[$index]);
    $items = array_values($items); // Reindex the array
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP LOCAL CRUD AHMAD FATIH R | 191</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>PHP CRUD Application</h2>

<?php
// If editing, pre-fill the form with existing values
$isEdit = $action == 'edit';
$itemName = $isEdit ? $items[$_POST['index']]['itemName'] : '';
$itemDescription = $isEdit ? $items[$_POST['index']]['itemDescription'] : '';
$itemId = $isEdit ? $items[$_POST['index']]['id'] : '';
$index = $isEdit ? $_POST['index'] : '';
?>

<!-- Form to Add/Update Item -->
<form method="POST" action="index.php">
    <input type="hidden" name="action" value="<?php echo $isEdit ? 'update' : 'create'; ?>">
    <input type="hidden" name="index" value="<?php echo $index; ?>">
    <input type="hidden" name="id" value="<?php echo $itemId; ?>"> <!-- Hidden field to store the item ID -->
    <label for="itemName">Item Name:</label>
    <input type="text" id="itemName" name="itemName" value="<?php echo htmlspecialchars($itemName); ?>" required><br><br>
    <label for="itemDescription">Item Description:</label>
    <input type="text" id="itemDescription" name="itemDescription" value="<?php echo htmlspecialchars($itemDescription); ?>" required><br><br>
    <button type="submit"><?php echo $isEdit ? 'Update' : 'Create'; ?></button>
    <input type="hidden" name="items" value="<?php echo htmlspecialchars(serialize($items)); ?>">
</form>

<!-- Display Items in a Table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $index => $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['id']); ?></td> <!-- Display the ID -->
            <td><?php echo htmlspecialchars($item['itemName']); ?></td>
            <td><?php echo htmlspecialchars($item['itemDescription']); ?></td>
            <td>
                <!-- Edit form -->
                <form style="display:inline;" method="POST" action="index.php">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <input type="hidden" name="items" value="<?php echo htmlspecialchars(serialize($items)); ?>">
                    <button type="submit">Edit</button>
                </form>

                <!-- Delete form -->
                <form style="display:inline;" method="POST" action="index.php">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <input type="hidden" name="items" value="<?php echo htmlspecialchars(serialize($items)); ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
