<?php 
include 'db.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO user (fullname, email, mobile, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $mobile, $username, $password);
    if($stmt->execute()){
        ?>
        <div class="alert alert-success" role="alert">
            Registration successful!
            <?php
    header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
     <h2 class="text-center">Register with Us!</h2>
        </header>
        <main>
            <div
                class="container p-3 my-3 border bg-light rounded shadow"
            >
   <form action="" method="post">
    <div class="form-floating mb-3">
        <input
            type="text"
            class="form-control"
            name="name"
            id="formId1"
            placeholder=""
        />
        <label for="formId1">Full Name</label>
    </div>
    <div class="form-floating mb-3">
        <input
            type="text"
            class="form-control"
            name="email"
            id="formId1"
            placeholder=""
        />
        <label for="formId1">Email</label>
    </div>
    <div class="form-floating mb-3">
        <input
            type="text"
            class="form-control"
            name="mobile"
            id="formId1"
            placeholder=""
        />
        <label for="formId1">Mobile Number</label>
    </div>
    <div class="form-floating mb-3">
        <input
            type="text"
            class="form-control"
            name="username"
            id="formId1"
            placeholder=""
        />
        <label for="formId1">User Name</label>
    </div>
    <div class="form-floating mb-3">
        <input
            type="password"
            class="form-control"
            name="password"
            id="formId1"
            placeholder=""
        />
        <label for="formId1">Password</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
   </form>
            </div>
            
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
