# PHP CRUD Application

This simple PHP application allows users to **Create**, **Read**, **Update**, and **Delete** (CRUD) items. The application is built using only PHP and HTML, without JavaScript. It demonstrates how to store, manipulate, and display data using an in-memory array. All data is passed through form submissions and processed on the server.

## How It Works

### 1. **Data Storage in an Array**
- The data (items) are stored in a PHP array. Each item is represented as an associative array with the following structure:
  ```php
  array(
      'id' => time(), // A unique ID generated based on the current timestamp
      'itemName' => 'Sample Name', // The name of the item
      'itemDescription' => 'Sample Description' // The description of the item
  )
  ```

- To maintain data persistence across form submissions (since PHP arrays are not stored between requests), the array is serialized into a string and passed between requests using a hidden form field.

### 2. **Handling CRUD Operations**

#### **Create Operation**
- The form at the top of the page allows the user to enter the item's name and description.
- When the form is submitted, the new item is added to the `$items` array. Each item gets a unique `ID` based on the current timestamp using `time()`.
- The `action` field is set to `create` to indicate that a new item is being created.
- Example:
  ```php
  if ($action == 'create') {
      $new_item = array(
          'id' => time(), // Generate a unique ID based on the current timestamp
          'itemName' => $_POST['itemName'],
          'itemDescription' => $_POST['itemDescription']
      );
      $items[] = $new_item;
  }
  ```

#### **Read Operation**
- The data in the `$items` array is displayed in a table. Each row in the table represents one item, showing its `ID`, `Name`, and `Description`.
- The items are displayed using a `foreach` loop to iterate over the array and output the details.

#### **Update Operation**
- To update an item, the "Edit" button next to the item is clicked. This sends the item's data to the form for editing.
- The `action` field is set to `edit`, which pre-fills the form with the item's current values (`itemName`, `itemDescription`, and `id`).
- After making changes, the form is submitted with the `action` set to `update`, and the item's values in the array are updated without changing its `ID`.
- Example:
  ```php
  elseif ($action == 'update') {
      $index = $_POST['index'];
      $items[$index] = array(
          'id' => $_POST['id'], // Keep the same ID when updating
          'itemName' => $_POST['itemName'],
          'itemDescription' => $_POST['itemDescription']
      );
  }
  ```

#### **Delete Operation**
- Each item has a "Delete" button. When clicked, it sends a form submission with the `delete` action.
- The item at the specified index in the array is removed using `unset()`, and the array is reindexed with `array_values()` to maintain sequential indexes.
- Example:
  ```php
  elseif ($action == 'delete') {
      $index = $_POST['index'];
      unset($items[$index]);
      $items = array_values($items); // Reindex the array
  }
  ```

### 3. **Form and Hidden Fields**
- The form is used to handle both creating and updating items.
- It includes hidden fields (`action`, `index`, `id`, and `items`) to pass information between form submissions.
  - `action`: Determines whether the form should create a new item (`create`) or update an existing one (`update`).
  - `index`: The position of the item in the array, used when updating or deleting items.
  - `id`: The unique identifier for the item, used to ensure the correct item is updated.
  - `items`: A serialized representation of the entire `$items` array, passed between form submissions to maintain state.

```php
<form method="POST" action="index.php">
    <input type="hidden" name="action" value="<?php echo $isEdit ? 'update' : 'create'; ?>">
    <input type="hidden" name="index" value="<?php echo $index; ?>">
    <input type="hidden" name="id" value="<?php echo $itemId; ?>">
    ...
    <input type="hidden" name="items" value="<?php echo htmlspecialchars(serialize($items)); ?>">
</form>
```

### 4. **Pre-filling Form for Edit**
- When editing an item, the form is pre-filled with the item's data. This is controlled by setting the form's `action` to `edit`, and then the item’s `index`, `id`, `itemName`, and `itemDescription` are filled into the form fields.

### 5. **Action Buttons (Edit/Delete)**
- Each item in the table has two buttons: **Edit** and **Delete**.
  - **Edit** button submits the form with the item's details to load it into the form for editing.
  - **Delete** button submits the form to remove the item from the array.
  
```php
<form style="display:inline;" method="POST" action="index.php">
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="index" value="<?php echo $index; ?>">
    <input type="hidden" name="items" value="<?php echo htmlspecialchars(serialize($items)); ?>">
    <button type="submit">Edit</button>
</form>

<form style="display:inline;" method="POST" action="index.php">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="index" value="<?php echo $index; ?>">
    <input type="hidden" name="items" value="<?php echo htmlspecialchars(serialize($items)); ?>">
    <button type="submit">Delete</button>
</form>
```

---

## How to Run the Application

1. Place the `index.php` file in the root directory of your local web server (such as XAMPP or MAMP).
2. Start the server.
3. Open your browser and navigate to `http://localhost/index.php` to access the PHP CRUD application.
4. Add, edit, or delete items using the form and buttons on the page.

This application demonstrates basic CRUD operations in PHP, providing a clear example of how to manage data using PHP arrays and form handling.
