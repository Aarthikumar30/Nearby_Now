<?php include "header.php"; ?>

<?php

function generateProviderID($conn) {
    $prefix = "PROV";
    $unique = false;
    
    while (!$unique) {
        $randomID = $prefix . rand(1000, 9999);
        $checkQuery = "SELECT * FROM providers WHERE provider_id='$randomID'";
        $result = mysqli_query($conn, $checkQuery);
        
        if (mysqli_num_rows($result) == 0) {
            $unique = true;
        }
    }
    return $randomID;
}

// Handle approval/rejection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provider_id = $_POST['provider_id'];
    $status = $_POST['status'];

    if ($status == "approved") {
        $generated_id = generateProviderID($conn);
        $update_query = "UPDATE providers SET status='$status', provider_id='$generated_id' WHERE id='$provider_id'";
    } else {
        $update_query = "UPDATE providers SET status='$status' WHERE id='$provider_id'";
    }

    mysqli_query($conn, $update_query);
}

// Fetch pending providers
$query = "SELECT * FROM providers WHERE status='waiting'";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Verify Providers</title>
</head>
<body>
    <!-- ==================================
         Admin Dashboard - Verify Providers 
         ================================== -->
    <?php if($level == 1): ?>
    <?php if (mysqli_num_rows($result) == 0) { ?>
        <h1>No pending provider approvals</h1>
    <?php } else { ?>
    <h1>Admin Dashboard</h1>
    <h2>Pending Provider Approvals</h2>
    <table border="1">
        <tr>
            <th>Provider Name</th>
            <th>Category</th>
            <th>Service Type</th>
            <th>Description</th>
            <th>Experience</th>
            <th>Price</th>
            <th>State</th>
            <th>District</th>
            <th>Location</th>
            <th>Contact</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['provider_name']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['experience']; ?> years</td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['state']; ?></td>
                <td><?php echo $row['district']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="provider_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="status" value="approved">Approve</button>
                        <button type="submit" name="status" value="rejected">Reject</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php } ?>
    <?php endif; ?>





    
    <!-- ==================================
         Provider Dashboard 
         ================================== -->
    <?php if($level == 2): ?>
        <h1>Provider Dashboard</h1>
        <p>Manage services, view bookings, etc.</p>
    <?php endif; ?>




    <!-- ==================================
         User Dashboard 
         ================================== -->



    <?php if($level == 3): ?>
        <h1>User Dashboard</h1>
        <p>View services, make bookings, etc.</p>
    <?php endif; ?>

</body>
</html>
