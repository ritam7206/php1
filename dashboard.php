<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

$products = [];
if ($conn) {
    $result = $conn->query("SELECT pid, pname, category, price, quantity, description FROM products ORDER BY pid DESC");
    if ($result) {
        $products = $result->fetch_all(MYSQLI_ASSOC);
    }
    $conn->close();
}
?>

<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title>Dashboard</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-sm navbar-light bg-light">
                <div class="container bg-dark shadow p-3 mb-5 rounded">
                    <a class="navbar-brand" href="#"><h4>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h4></a>
                    <button
                        class="navbar-toggler d-lg-none"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapsibleNavId"
                        aria-controls="collapsibleNavId"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavId">
                        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                            <form class="d-flex my-2 my-lg-0 m-2" action="pdf.php" method="post">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Download PDF</button>
                            </form>
                            <form class="d-flex my-2 my-lg-0" action="excel.php" method="post">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Download CSV</button>
                            </form>
                        </ul>
                        <form class="d-flex my-2 my-lg-0" action="logout.php" method="post">
                            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <div class="container bg-light shadow p-3 mb-5 rounded border border-2 border-dark bg-dark text-light">
                <h2 class="text-center">Add Product</h2>
                <form action="insert_product.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pname" id="pname" placeholder="" />
                        <label for="pname">Product Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="category" id="category" placeholder="" />
                        <label for="category">Category</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="price" id="price" placeholder="" />
                        <label for="price">Price</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="quantity" id="quantity" placeholder="" />
                        <label for="quantity">Quantity</label>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <h2 class="text-center">Product List</h2>
                <div class="table-responsive">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th scope="col">Product ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars((string) $product['pid']); ?></td>
                                        <td><?php echo htmlspecialchars($product['pname']); ?></td>
                                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                                        <td><?php echo htmlspecialchars((string) $product['price']); ?></td>
                                        <td><?php echo htmlspecialchars((string) $product['quantity']); ?></td>
                                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo htmlspecialchars((string) $product['pid']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="delete.php" method="post" style="display:inline;">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $product['pid']); ?>" />
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No products found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer>
            <!-- place footer here -->
        </footer>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
