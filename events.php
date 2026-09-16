<?php

include "config.php";

$result = $conn->query(
    "SELECT id, event_name, event_date, event_time, venue, description
     FROM events
     ORDER BY event_date, event_time"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Events</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <!-- College Header -->
    <div class="college-header">
        <img src="college_header.jpeg"
             alt="P. R. Pote Patil College of Engineering and Management">
    </div>


    <!-- Navigation -->
    <header>

        <h1>Campus Events</h1>

        <nav>
            <a href="index.php">Home</a>
            <a href="events.php">Events</a>
            <a href="register.php">Register</a>
            <a href="view.php">Registrations</a>
        </nav>

    </header>


    <!-- Main Content -->
    <main>

        <h2>Available Campus Events</h2>

        <div class="events-container">

            <?php if ($result->num_rows > 0) { ?>

                <?php while ($event = $result->fetch_assoc()) { ?>

                    <div class="event-card">

                        <h3>
                            <?php echo htmlspecialchars($event['event_name']); ?>
                        </h3>

                        <p>
                            <strong>📅 Date:</strong>
                            <?php echo htmlspecialchars($event['event_date']); ?>
                        </p>

                        <p>
                            <strong>⏰ Time:</strong>
                            <?php echo htmlspecialchars($event['event_time']); ?>
                        </p>

                        <p>
                            <strong>📍 Venue:</strong>
                            <?php echo htmlspecialchars($event['venue']); ?>
                        </p>

                        <p>
                            <strong>📝 Description:</strong>
                            <?php echo htmlspecialchars($event['description']); ?>
                        </p>

                        <a href="register.php?event_id=<?php echo (int)$event['id']; ?>">
                            <button type="button">
                                Register for this Event
                            </button>
                        </a>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="no-events">
                    <p>No events are currently available.</p>
                </div>

            <?php } ?>

        </div>

    </main>


</body>

</html>

<?php

$conn->close();

?>