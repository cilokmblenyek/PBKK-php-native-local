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
    <title>PHP CRUD Application</title>
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

<!-- Form to Add/Update Item -->
<form id="itemForm" method="POST" action="index.php">
    <input type="hidden" name="action" value="create" id="formAction">
    <input type="hidden" name="index" id="itemIndex">
    <input type="hidden" name="id" id="itemId"> <!-- Hidden field to store the item ID -->
    <label for="itemName">Item Name:</label>
    <input type="text" id="itemName" name="itemName" required><br><br>
    <label for="itemDescription">Item Description:</label>
    <input type="text" id="itemDescription" name="itemDescription" required><br><br>
    <button type="submit">Submit</button>
    <input type="hidden" name="items" value="<?php echo htmlspecialchars(serialize($items)); ?>">
</form>

<!-- Display Items in a Table -->
<table id="itemTable">
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
                <button class="editBtn" 
                    data-index="<?php echo $index; ?>" 
                    data-id="<?php echo htmlspecialchars($item['id']); ?>" 
                    data-name="<?php echo htmlspecialchars($item['itemName']); ?>" 
                    data-description="<?php echo htmlspecialchars($item['itemDescription']); ?>">Edit</button>

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

<script>
// JavaScript to handle the Edit button functionality
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', (event) => {
        // Prevent default behavior
        event.preventDefault();

        // Get data from the button's attributes
        const index = button.getAttribute('data-index');
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const description = button.getAttribute('data-description');

        // Populate the form with the item data for editing
        document.getElementById('formAction').value = 'update';
        document.getElementById('itemIndex').value = index;
        document.getElementById('itemId').value = id; // Set the hidden ID field
        document.getElementById('itemName').value = name;
        document.getElementById('itemDescription').value = description;
    });
});
</script>

</body>
</html>
