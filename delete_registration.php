<?php

include "config.php";

// Check whether registration ID is provided

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    die("Invalid registration ID.");

}

$id = (int)$_GET["id"];

// Delete registration using prepared statement

$stmt = $conn->prepare(
    "DELETE FROM registrations WHERE id = ?"
);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    $stmt->close();
    $conn->close();

    header("Location: view.php");
    exit;

} else {

    echo "Unable to delete registration.";

}

$stmt->close();
$conn->close();

?>