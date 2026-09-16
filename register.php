<?php
include "config.php";

/*
   Get event ID from URL
   Example:
   register.php?event_id=2
*/
$selected_event_id = $_GET["event_id"] ?? "";

$events = $conn->query(
    "SELECT id, event_name, event_date, event_time, venue
     FROM events
     ORDER BY event_date"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Event Registration</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <!-- College Header -->

    <div class="college-header">

        <img
            src="college_header.jpeg"
            alt="P. R. Pote Patil College of Engineering and Management"
        >

    </div>


    <!-- Navigation -->

    <header>

        <h1>Campus Event Registration</h1>

        <nav>

            <a href="index.php">Home</a>

            <a href="events.php">Events</a>

            <a href="register.php">Register for Event</a>

            <a href="view.php">View Registrations</a>

        </nav>

    </header>


    <!-- Registration Form -->

    <form action="save_registration.php" method="POST">

        <label for="name">
            Student Name:
        </label>

        <input
            type="text"
            name="name"
            id="name"
            required
            maxlength="100"
            pattern="[A-Za-z ]+"
            placeholder="Enter your full name"
        >

        <br><br>


        <label for="email">
            Email:
        </label>

        <input
            type="email"
            name="email"
            id="email"
            required
            maxlength="100"
            placeholder="Enter your email"
        >

        <br><br>


        <label for="department">
            Department:
        </label>

        <input
            type="text"
            name="department"
            id="department"
            required
            maxlength="100"
            placeholder="Enter your department"
        >

        <br><br>


        <label for="event_id">
            Select Event:
        </label>

        <select
            name="event_id"
            id="event_id"
            required
        >

            <option value="">
                -- Select an Event --
            </option>

            <?php while ($event = $events->fetch_assoc()) { ?>

                <option
                    value="<?php echo (int)$event['id']; ?>"
                    <?php
                    if ($selected_event_id == $event['id']) {
                        echo "selected";
                    }
                    ?>
                >

                    <?php
                    echo htmlspecialchars($event['event_name']);
                    echo " - ";
                    echo htmlspecialchars($event['event_date']);
                    echo " - ";
                    echo htmlspecialchars($event['venue']);
                    ?>

                </option>

            <?php } ?>

        </select>

        <br><br>


        <button type="submit">
            Register for Event
        </button>

    </form>


</body>

</html>