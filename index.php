<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Product Management</title>
</head>
<body>
    <div class="container">
        <h2>Tugas Responsi: 5220411125_Nawang Padjar Pancarro</h2>
        <h1>Product Management</h1>
        
        <div class="btn-group">
            <button id="viewCategories" class="btn">View Categories</button>
            <button id="addCategory" class="btn">Add New Category</button>
            <button id="viewProducts" class="btn">View Products</button>
            <button id="addProduct" class="btn">Add New Product</button>
        </div>

        <div id="content">
            <!-- Content will be loaded here via JavaScript -->
        </div>

        <div id="formContainer" style="display:none;">
            <form id="crudForm">
                <input type="hidden" id="formId">
                <label for="name">Name:</label>
                <input type="text" id="name" required>
                <label for="description">Description:</label>
                <textarea id="description" required></textarea>
                <label for="price" id="priceLabel" style="display:none;">Price:</label>
                <input type="text" id="price" style="display:none;">
                <label for="category" id="categoryLabel" style="display:none;">Category:</label>
                <select id="category" style="display:none;"></select>
                <button type="submit" id="submitBtn">Submit</button>
                <button type="button" id="cancelBtn">Cancel</button>
            </form>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>
