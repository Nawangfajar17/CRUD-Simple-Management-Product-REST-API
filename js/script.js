document.addEventListener("DOMContentLoaded", () => {
    const viewCategoriesBtn = document.getElementById("viewCategories");
    const addCategoryBtn = document.getElementById("addCategory");
    const viewProductsBtn = document.getElementById("viewProducts");
    const addProductBtn = document.getElementById("addProduct");
    const contentDiv = document.getElementById("content");
    const formContainer = document.getElementById("formContainer");
    const crudForm = document.getElementById("crudForm");

    let currentView = "";

    viewCategoriesBtn.addEventListener("click", () => {
        fetchCategories();
        currentView = "categories";
    });

    addCategoryBtn.addEventListener("click", () => {
        showForm("categories");
    });

    viewProductsBtn.addEventListener("click", () => {
        fetchProducts();
        currentView = "products";
    });

    addProductBtn.addEventListener("click", () => {
        showForm("products");
    });

    crudForm.addEventListener("submit", (e) => {
        e.preventDefault();
        handleFormSubmit();
    });

    document.getElementById("cancelBtn").addEventListener("click", () => {
        formContainer.style.display = "none";
    });

    function fetchCategories() {
        fetch("api/categories/read.php")
            .then(response => response.json())
            .then(data => {
                displayData(data.data, "categories");
            });
    }

    function fetchProducts() {
        fetch("api/products/read.php")
            .then(response => response.json())
            .then(data => {
                displayData(data.data, "products");
            });
    }

    function displayData(data, type) {
        let table = "<table><tr><th>ID</th><th>Name</th><th>Description</th>";

        if (type === "products") {
            table += "<th>Price</th><th>Category</th>";
        }

        table += "<th>Actions</th></tr>";

        data.forEach(item => {
            table += `<tr>
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.description}</td>`;
            if (type === "products") {
                table += `<td>${item.price}</td>
                          <td>${item.category_name}</td>`;
            }
            table += `<td>
                        <button onclick="editItem(${item.id}, '${type}')">Edit</button>
                        <button onclick="deleteItem(${item.id}, '${type}')">Delete</button>
                      </td>
                      </tr>`;
        });

        table += "</table>";
        contentDiv.innerHTML = table;

        if (type === "products") {
            fetchCategoriesForProductsForm();
        }
    }

    function showForm(type) {
        formContainer.style.display = "block";
        crudForm.reset();
        document.getElementById("formId").value = "";
        currentView = type;

        if (type === "products") {
            document.getElementById("price").style.display = "block";
            document.getElementById("priceLabel").style.display = "block";
            document.getElementById("category").style.display = "block";
            document.getElementById("categoryLabel").style.display = "block";
            fetchCategoriesForProductsForm();
        } else {
            document.getElementById("price").style.display = "none";
            document.getElementById("priceLabel").style.display = "none";
            document.getElementById("category").style.display = "none";
            document.getElementById("categoryLabel").style.display = "none";
        }
    }

    window.editItem = function(id, type) {
        formContainer.style.display = "block";
        crudForm.reset();

        fetch(`api/${type}/read_single.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("formId").value = data.id;
                document.getElementById("name").value = data.name;
                document.getElementById("description").value = data.description;

                if (type === "products") {
                    document.getElementById("price").style.display = "block";
                    document.getElementById("priceLabel").style.display = "block";
                    document.getElementById("price").value = data.price;
                    document.getElementById("category").style.display = "block";
                    document.getElementById("categoryLabel").style.display = "block";
                    document.getElementById("category").value = data.category_id;
                } else {
                    document.getElementById("price").style.display = "none";
                    document.getElementById("priceLabel").style.display = "none";
                    document.getElementById("category").style.display = "none";
                    document.getElementById("categoryLabel").style.display = "none";
                }
            });
    };

    window.deleteItem = function(id, type) {
        if (confirm("Are you sure you want to delete this item?")) {
            fetch(`api/${type}/delete.php`, {
                method: "DELETE",
                body: JSON.stringify({ id }),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (type === "categories") {
                    fetchCategories();
                } else {
                    fetchProducts();
                }
            });
        }
    };

    function handleFormSubmit() {
        const id = document.getElementById("formId").value;
        const name = document.getElementById("name").value;
        const description = document.getElementById("description").value;
        const price = document.getElementById("price").value;
        const category_id = document.getElementById("category").value;

        const url = `api/${currentView}/` + (id ? "update.php" : "create.php");
        const method = id ? "PUT" : "POST";

        const data = {
            id,
            name,
            description
        };

        if (currentView === "products") {
            data.price = price;
            data.category_id = category_id;
        }

        fetch(url, {
            method: method,
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            formContainer.style.display = "none";
            if (currentView === "categories") {
                fetchCategories();
            } else {
                fetchProducts();
            }
        });
    }

    function fetchCategoriesForProductsForm() {
        fetch("api/categories/read.php")
            .then(response => response.json())
            .then(data => {
                let categorySelect = document.getElementById("category");
                categorySelect.innerHTML = "";

                data.data.forEach(category => {
                    let option = document.createElement("option");
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            });
    }
});
