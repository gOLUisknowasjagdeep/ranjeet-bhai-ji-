<?php
session_start();

if (!isset($_SESSION['IS_LOGIN'])) {
    // Redirect to login page if user is not logged in
    header("Location: ../login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Contact Us Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('../login/cbackground.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        nav {
            background: black;
            color: #fff;
            padding: 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 1em;
        }
        footer {
            background: ;
            color: #fff;
            text-align: center;
            padding: 1em;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .container {
            padding: 2em;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card {
            background: rgba(255, 255, 255, 0.8);
            padding: 1em;
            margin: 1em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            flex: 1 1 calc(33.333% - 2em);
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card button {
            background: #d9534f;
            color: white;
            border: none;
            padding: 0.5em 1em;
            cursor: pointer;
            border-radius: 4px;
        }
        .card:nth-child(odd) {
            margin-left: auto;
            margin-right: 0;
        }
        .card:nth-child(even) {
            margin-left: 0;
            margin-right: auto;
        }
        @media (max-width: 768px) {
            .card {
                flex: 1 1 calc(100% - 2em);
            }
        }
    </style>
</head>
<body>
    <nav>
        <h1>Admin Dashboard</h1>
        <div>
            <a href="../../public/index.php">Home</a>
            <a href="../login/login.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <?php
        // Database credentials
        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname = "dpclass";
        $servername = "127.0.0.1:3306";
        $username = "u431598229_nit";
        $password = "Faxfare@27";
        $dbname = "u431598229_faxfare";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Delete data if delete button is clicked
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
            $delete_id = intval($_POST['delete_id']);
            $delete_sql = "DELETE FROM Contactdata WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $delete_id);

            if ($delete_stmt->execute()) {
                echo "<script>alert('Data deleted successfully');</script>";
            } else {
                echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
            }
            $delete_stmt->close();
        }

        // Fetch data from database
        $sql = "SELECT id, name, email, phone, subject, message FROM Contactdata";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>
                        <h3>" . htmlspecialchars($row['name']) . "</h3>
                        <p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>
                        <p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>
                        <p><strong>Subject:</strong> " . htmlspecialchars($row['subject']) . "</p>
                        <p><strong>Message:</strong> " . nl2br(htmlspecialchars($row['message'])) . "</p>
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                            <input type='hidden' name='delete_id' value='" . intval($row['id']) . "'>
                            <button type='submit'>Delete</button>
                        </form>
                    </div>";
            }
        } else {
            echo "<p>No results found.</p>";
        }

        $conn->close();
        ?>
    </div>

    <footer>
        <p>Ranjeet &copy; 2024</p>
    </footer>
</body>
</html>
