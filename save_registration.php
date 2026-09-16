<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $department = trim($_POST["department"] ?? "");
    $event_id = $_POST["event_id"] ?? "";

    // -----------------------------
    // Server-side validation
    // -----------------------------

    if (empty($name) || empty($email) || empty($department) || empty($event_id)) {
        die("Please fill all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address.");
    }

    if (!is_numeric($event_id)) {
        die("Invalid event selected.");
    }

    // -----------------------------
    // Get event details
    // -----------------------------

    $stmt = $conn->prepare(
        "SELECT event_name FROM events WHERE id = ?"
    );

    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    $event_result = $stmt->get_result();

    if ($event_result->num_rows == 0) {
        $stmt->close();
        $conn->close();

        die("Selected event does not exist.");
    }

    $event = $event_result->fetch_assoc();
    $event_name = $event["event_name"];

    $stmt->close();

    // -----------------------------
    // Check whether student exists
    // -----------------------------

    $stmt = $conn->prepare(
        "SELECT id FROM users WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        // Existing student
        $user = $result->fetch_assoc();
        $user_id = $user["id"];

    } else {

        // New student
        $stmt->close();

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, role)
             VALUES (?, ?, 'student')"
        );

        $stmt->bind_param("ss", $name, $email);

        if (!$stmt->execute()) {
            $stmt->close();
            $conn->close();

            die("Unable to create student record.");
        }

        $user_id = $conn->insert_id;
    }

    $stmt->close();

    // -----------------------------
    // Insert event registration
    // -----------------------------

    $stmt = $conn->prepare(
        "INSERT INTO registrations
        (user_id, event_id, department)
        VALUES (?, ?, ?)"
    );

    $stmt->bind_param(
        "iis",
        $user_id,
        $event_id,
        $department
    );

    // -----------------------------
    // Handle registration
    // -----------------------------

    try {

        if ($stmt->execute()) {

            ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>

                <meta charset="UTF-8">

                <meta name="viewport"
                      content="width=device-width, initial-scale=1.0">

                <title>Registration Successful</title>

                <link rel="stylesheet" href="style.css">

            </head>

            <body>

                <main>

                    <h1>Registration Successful! 🎉</h1>

                    <h2>
                        Thank You,
                        <?php echo htmlspecialchars($name); ?>!
                    </h2>

                    <p>
                        Your registration has been successfully completed.
                    </p>

                    <p>
                        <strong>Student Name:</strong>
                        <?php echo htmlspecialchars($name); ?>
                    </p>

                    <p>
                        <strong>Email:</strong>
                        <?php echo htmlspecialchars($email); ?>
                    </p>

                    <p>
                        <strong>Department:</strong>
                        <?php echo htmlspecialchars($department); ?>
                    </p>

                    <p>
                        <strong>Event:</strong>
                        <?php echo htmlspecialchars($event_name); ?>
                    </p>

                    <br>

                    <a href="register.php">
                        <button>
                            Register for Another Event
                        </button>
                    </a>

                    <br><br>

                    <a href="view.php">
                        View All Registrations
                    </a>

                    <br><br>

                    <a href="index.php">
                        Back to Home
                    </a>

                </main>

            </body>

            </html>

            <?php

        }

    } catch (mysqli_sql_exception $e) {

        // MySQL error 1062 = duplicate entry

        if ($e->getCode() == 1062) {

            ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>

                <meta charset="UTF-8">

                <meta name="viewport"
                      content="width=device-width, initial-scale=1.0">

                <title>Already Registered</title>

                <link rel="stylesheet" href="style.css">

            </head>

            <body>

                <main>

                    <h1>Already Registered ⚠️</h1>

                    <h2>
                        <?php echo htmlspecialchars($name); ?>
                    </h2>

                    <p>
                        You are already registered for:
                    </p>

                    <p>
                        <strong>
                            <?php echo htmlspecialchars($event_name); ?>
                        </strong>
                    </p>

                    <p>
                        You cannot register for the same event twice.
                    </p>

                    <br>

                    <a href="register.php">
                        <button>
                            Choose Another Event
                        </button>
                    </a>

                    <br><br>

                    <a href="view.php">
                        View All Registrations
                    </a>

                    <br><br>

                    <a href="index.php">
                        Back to Home
                    </a>

                </main>

            </body>

            </html>

            <?php

        } else {

            echo "Unable to complete registration.";

        }

    }

    $stmt->close();
    $conn->close();

} else {

    echo "Invalid request.";

}

?>