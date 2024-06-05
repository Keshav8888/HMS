<?php
// Starting the session.
session_start();
include("adheader.php");
include("dbconnection.php");

if (!isset($_SESSION['patientid'])) {
    echo "<script>window.location='patientlogin.php';</script>";
    exit();
}


if (!$con) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Use prepared statements to prevent SQL injection
$stmtPatient = $con->prepare("SELECT * FROM patient WHERE patientid = ?");
$stmtPatient->bind_param("i", $_SESSION['patientid']);
$stmtPatient->execute();
$resultPatient = $stmtPatient->get_result();
$rspatient = $resultPatient->fetch_assoc();

$stmtAppointment = $con->prepare("SELECT * FROM appointment WHERE patientid = ?");
$stmtAppointment->bind_param("i", $_SESSION['patientid']);
$stmtAppointment->execute();
$resultAppointment = $stmtAppointment->get_result();
$rspatientappointment = $resultAppointment->fetch_assoc();
?>
<div class="container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
    </div>

    <div class="card">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <div class="alert bg-teal">
                            <h3>Welcome, <?php echo htmlspecialchars($rspatient['patientname']); ?>!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home_animation_1"
                            aria-expanded="true">Registration History</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile_animation_1"
                            aria-expanded="false">Appointment</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="padding: 10px">
                    <div role="tabpanel" class="tab-pane animated flipInX active" id="home_animation_1"
                        aria-expanded="true"> <b>Registration History</b>
                        <h3>You have been with us since <?php echo htmlspecialchars($rspatient['admissiondate']); ?>
                            <?php echo htmlspecialchars($rspatient['admissiontime']); ?></h3>
                    </div>
                    <div role="tabpanel" class="tab-pane animated flipInX" id="profile_animation_1"
                        aria-expanded="false"> <b>Appointment</b>
                        <?php
                        if ($resultAppointment->num_rows == 0) {
                            echo "<h3>Appointment records not found.</h3>";
                        } else {
                            echo "<h3>Last Appointment taken on - " . htmlspecialchars($rspatientappointment['appointmentdate']) . " " . htmlspecialchars($rspatientappointment['appointmenttime']) . "</h3>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("adfooter.php");
$stmtPatient->close();
$stmtAppointment->close();
$con->close();
?>
