<?php

include "config.php";

// Get all events for the dropdown

$events = $conn->query(
    "SELECT id, event_name
     FROM events
     ORDER BY event_date"
);

// Get selected event

$event_id = $_GET["event_id"] ?? "";

// Base query

$sql = "SELECT
            registrations.id,
            users.name,
            users.email,
            registrations.department,
            events.event_name,
            events.event_date,
            events.event_time,
            events.venue,
            registrations.registration_date
        FROM registrations
        INNER JOIN users
            ON registrations.user_id = users.id
        INNER JOIN events
            ON registrations.event_id = events.id";

// Add filter if an event is selected

if (!empty($event_id) && is_numeric($event_id)) {

    $stmt = $conn->prepare(
        $sql . " WHERE registrations.event_id = ?
                 ORDER BY registrations.registration_date DESC"
    );

    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $result = $conn->query(
        $sql . " ORDER BY registrations.registration_date DESC"
    );
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Registrations</title>

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

        <h1>Event Registrations</h1>

        <nav>

            <a href="index.php">Home</a>

            <a href="events.php">Events</a>

            <a href="register.php">Register for Event</a>

            <a href="view.php">View Registrations</a>

        </nav>

    </header>


    <!-- Main Content -->

    <main>

        <h2>Registered Participants</h2>


        <!-- Search / Filter -->

        <form method="GET" action="view.php">

            <label for="event_id">
                Search Registrations by Event:
            </label>

            <select name="event_id" id="event_id">

                <option value="">
                    -- All Events --
                </option>

                <?php while ($event = $events->fetch_assoc()) { ?>

                    <option
                        value="<?php echo (int)$event['id']; ?>"
                        <?php
                        if ($event_id == $event['id']) {
                            echo "selected";
                        }
                        ?>
                    >

                        <?php
                        echo htmlspecialchars($event['event_name']);
                        ?>

                    </option>

                <?php } ?>

            </select>


            <button type="submit">
                Search
            </button>


            <a href="view.php">
                Show All
            </a>

        </form>


        <!-- Registration Table -->

        <table>

            <tr>

                <th>ID</th>

                <th>Student Name</th>

                <th>Email</th>

                <th>Department</th>

                <th>Event</th>

                <th>Event Date</th>

                <th>Time</th>

                <th>Venue</th>

                <th>Registration Date</th>

                <th>Action</th>

            </tr>


            <?php if ($result->num_rows > 0) { ?>

                <?php while ($row = $result->fetch_assoc()) { ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($row['id']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['email']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['department']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['event_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['event_date']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['event_time']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['venue']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['registration_date']); ?>
                        </td>

                        <td>

                            <a
                                href="delete_registration.php?id=<?php echo (int)$row['id']; ?>"
                                onclick="return confirm('Are you sure you want to delete this registration?');"
                            >
                                <button type="button">
                                    Delete
                                </button>
                            </a>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="10">

                        No registrations found for this event.

                    </td>

                </tr>

            <?php } ?>

        </table>

    </main>


</body>

</html>

<?php

$conn->close();

?>