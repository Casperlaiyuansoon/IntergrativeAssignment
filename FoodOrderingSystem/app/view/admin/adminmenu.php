<?php
require_once '../../controller/FoodController.php';

// Fetch all food items
$foodItems = $food->read()->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <!-- ===== Style ===== -->
        <link rel="stylesheet" href="../../../public/css/adminmenu.css">
        <link rel="stylesheet" href="../../../public/css/adminmenu2.css">
        <link rel="stylesheet" href="../../../public/css/print.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    </head>
    <body>
        <!-- ================== Navigation ========================== -->
        <div class="container">
            <div class="navigation">
                <ul>
                    <li>
                        <a href="#">
                            <span class="icon"><img src="../../../public/image/logo.png"></span>
                            <span class="title">Ordering System</span>
                        </a>
                    </li>
                    <li>
                        <a href="admindashboard.php">
                            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../../view/user.php">
                            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                            <span class="title">User</span>
                        </a>
                    </li>
                    <li>
                        <a href="adminmenu.php">
                            <span class="icon"><ion-icon name="fast-food-outline"></ion-icon></span>
                            <span class="title">Menu</span>
                        </a>
                    </li>
                    <li>
                      <a href="adminorder.php">
                            <span class="icon"><ion-icon name="bag-remove-outline"></ion-icon></ion-icon></span>
                            <span class="title">Order</span>
                        </a>
                    </li>
                    <li>
                        <a href="../../controller/adminLogout.php">
                            <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                            <span class="title">Sign Out</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ================================= Main ================================= -->
            <div class="main">
                <div class="topbar">
                    <div class="toggle">
                        <ion-icon name="menu-outline"></ion-icon>
                    </div>
                    <div class="search">
                        <label>
                            <input type="text" id="searchInput" placeholder="Search here" onkeyup="filterTable()">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </div>
                    <div class="user">
                        <img src="../../../public/image/review_1.png" alt="">
                    </div>
                </div>

                <!-- ================================= Food Menu ================================= -->
                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>Food Menu</h2>

                            <!-- Print fucntion -->

                            <!-- display the food info in the food form table -->
                            <a href="#" class="btn" onclick="document.getElementById('foodForm').style.display = 'block'">Create Food</a>

                        </div>

                        <!-- Food Form -->
                        <div id="foodForm"  style="display: none;">
                            <form action="adminmenu.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="foodId" value="<?php echo isset($foodId) ? htmlspecialchars($foodId) : ''; ?>">
                                <label for="name">Food Name:</label>
                                <input type="text" name="name" required value="<?php echo isset($foodName) ? htmlspecialchars($foodName) : ''; ?>">

                                <label for="price">Food Price:</label>
                                <input type="text" name="price" required value="<?php echo isset($foodPrice) ? htmlspecialchars($foodPrice) : ''; ?>">

                                <label for="image">Food Image:</label>
                                <input type="file" name="image" accept="image/*">

                                <input type="submit" value="Add Food">
                            </form>
                        </div>

                        <!-- Food Items Table -->
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <!-- Display theFood Items in the table -->
                                    <?php foreach ($foodItems as $index => $item): ?>                      
                                        <td><?php echo $index + 1; ?></td>                                 <!--No +1-->
                                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 50px; height: auto;"></td>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="edit-btn" 
                                               onclick="openEditModal('<?php echo htmlspecialchars($item['id']); ?>', '<?php echo htmlspecialchars($item['name']); ?>', '<?php echo htmlspecialchars($item['price']); ?>', '<?php echo htmlspecialchars($item['image']); ?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            |
                                            <!-- <a href="?action=delete&id=<?php echo htmlspecialchars($item['id']); ?>" class="delete-btn">-->
                                            <a href="?action=delete&id=<?php echo htmlspecialchars($item['id']); ?>" class="delete-btn" onclick="return confirmDelete()">

                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php endforeach ?>
                        </table>   
                      
                        <div class="button-container">
                            <a href="viewsupplier.php" class="btn">Check food stock</a>

                            <button onclick="window.print()" class="btn btn-primary">Print Menu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Food Modal -->
        <div id="editFoodModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeEditModal()">&times;</span>
                <h2>Edit Food</h2>
                <form id="editFoodForm" action="adminmenu.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editFoodId">

                    <label for="editName">Food Name:</label>
                    <input type="text" name="name" id="editName" required>

                    <label for="editPrice">Food Price:</label>
                    <input type="text" name="price" id="editPrice" required>

                    <label for="editImage">Food Image:</label>
                    <input type="file" name="image" id="editImage" accept="image/*">

                    <input type="submit" value="Update Food">
                </form>
            </div>
        </div>





        <!-- =============== Scripts =============== -->
        <script src="../../../public/js/adminmenu.js"></script>

        <!-- =============== ionicons =============== -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <!-- =============== Scripts =============== -->
        <script>
                    // Function to open the Edit modal and populate the form with existing data
                    function openEditModal(id, name, price, image) {
                        // Show the modal
                        document.getElementById('editFoodModal').style.display = 'block';

                        // Populate the modal with the current food item data
                        document.getElementById('editFoodId').value = id;
                        document.getElementById('editName').value = name;
                        document.getElementById('editPrice').value = price;

                        // Optionally set image if needed (usually for displaying the current image)
                    }

                    // Function to close the Edit modal
                    function closeEditModal() {
                        document.getElementById('editFoodModal').style.display = 'none';
                    }

                    // Close the modal when clicking outside the modal content
                    window.onclick = function (event) {
                        const modal = document.getElementById('editFoodModal');
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
        </script>
        <script>
            function filterTable() {
                // Get the search input value and convert it to uppercase
                var input = document.getElementById('searchInput').value.toUpperCase();

                // Get the table and its rows
                var table = document.querySelector('table');
                var rows = table.getElementsByTagName('tr');

                // Loop through all rows, starting from the second row (skipping the header row)
                for (var i = 1; i < rows.length; i++) {
                    var row = rows[i];
                    var cell = row.getElementsByTagName('td')[2]; // Assuming the name is in the third column

                    if (cell) {
                        var cellText = cell.textContent || cell.innerText;
                        if (cellText.toUpperCase().indexOf(input) > -1) {
                            row.style.display = ""; // Show the row if it matches
                        } else {
                            row.style.display = "none"; // Hide the row if it doesn't match
                        }
                    }
                }
            }
        </script>

        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this item?');
            }
        </script>

    </body>
</html>




