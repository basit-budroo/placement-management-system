<?php
session_start();
include('includes/config.php');
$company = $_SESSION['company_name'];

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

}
if(isset($_REQUEST['applied']))
	{
	$aeid=intval($_GET['applied']);
	
	$sql = "UPDATE apply_status SET applied = 1 WHERE  id= $aeid";
	$query = $dbh->prepare($sql);
	$query -> execute();
    $msg="Changes Sucessfully";
    
    }
    
if(isset($_REQUEST['notapplied']))
    {
    $aeid=intval($_GET['notapplied']);
    $sql = "UPDATE apply_status SET applied = 1 WHERE  id= $aeid";
    $query = $dbh->prepare($sql);
    $query -> execute();
    $msg="Changes Sucessfully";
    }


if(isset($_REQUEST['present']))
	{
	$aeid=intval($_GET['present']);
	
	$sql = "UPDATE apply_status SET attendance = 0 WHERE  id= $aeid";
	$query = $dbh->prepare($sql);
	$query -> execute();
	$msg="Changes Sucessfully";
    }
    
if(isset($_REQUEST['absent']))
    {
    $aeid=intval($_GET['absent']);
    $sql = "UPDATE apply_status SET attendance = 1 WHERE  id= $aeid";
    $query = $dbh->prepare($sql);
    $query -> execute();
    $msg="Changes Sucessfully";
    }

if(isset($_REQUEST['placed']))
{
$aeid=intval($_GET['placed']);

$sql = "UPDATE apply_status SET placenment_status = 0 WHERE  id= $aeid";
$query = $dbh->prepare($sql);
$query -> execute();
$msg="Changes Sucessfully";
}
    
if(isset($_REQUEST['unplaced']))
    {
    $aeid=intval($_GET['unplaced']);
    $sql = "UPDATE apply_status SET placenment_status = 1 WHERE  id= $aeid";
    $query = $dbh->prepare($sql);
    $query -> execute();
    $msg="Changes Sucessfully";
    }
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Company Student Details</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="ts-main-content">
    <?php include('includes/leftbar.php'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title"><?php echo "Detail of Student Applied for ".$_GET['nm'] ?></h2>
                    <div class="panel panel-default">
                        <div class="panel-heading">Applied Users</div>
                        <table id="zctb" class="display table table-striped table-bordered table-hover"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
								<th>Student Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>CGPA</th>
                                <th>Applied</th>
                                <th>Attendance</th>
                                <th>Placed</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $company = $_GET['nm'];
                            $sql = "SELECT * FROM users WHERE id IN (SELECT user_id FROM apply_status WHERE company_name = '$company')";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($result->id); ?></td>
                                        <td><?php echo htmlentities($result->name); ?></td>
                                        <td><?php echo htmlentities($result->email); ?></td>
                                        <td><?php echo htmlentities($result->mobile); ?></td>
                                        <td><?php echo htmlentities($result->gender); ?></td>
                                        <td><?php echo htmlentities($result->cgpa); ?></td>
                                    
                                    <?php 
                                }
                            } 
                            
                            $sql1 = "SELECT * from  apply_status where company_name = '$company'and applied = 1";
                            $query1 = $dbh->prepare($sql1);
                            $query1->execute();
                            $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                            if ($query1->rowCount() > 0) {
        
                                foreach ($results1 as $result1) { ?>

                                        <td>
                                        <?php if($result1->applied == 1)
                                                    {?>
                                                    <a href="see-student.php?nm=<?php echo htmlentities($company);?>&applied=<?php echo htmlentities($result1->id);?>">Applied <i class="fa fa-check-circle"></i></a> 
                                                    <?php } else {?>
                                                    <a href="see-student.php?nm=<?php echo htmlentities($company);?>&notapplied=<?php echo htmlentities($result1->id);?>">Not-Applied <i class="fa fa-times-circle"></i></a>
                                                    <?php } 
                                                    ?>
                                        </td>
                                        <td>
                                        <?php if($result1->attendance == 1)
                                                    {?>
                                                    <a href="see-student.php?nm=<?php echo htmlentities($company);?>&present=<?php echo htmlentities($result1->id);?>">Present <i class="fa fa-check-circle"></i></a> 
                                                    <?php } else {?>
                                                    <a href="see-student.php?nm=<?php echo htmlentities($company);?>&absent=<?php echo htmlentities($result1->id);?>">Absent <i class="fa fa-times-circle"></i></a>
                                                    <?php } 
                                                    ?>
                                        </td>
                                        <td>
                                        <?php
                                        if($result1->placenment_status == 1)
                                                    {?>
                                                    <a href="see-student.php?nm=<?php echo htmlentities($company);?>&placed=<?php echo htmlentities($result1->id);?>">Placed <i class="fa fa-check-circle"></i></a> 
                                                    <?php } else {?>
                                                    <a href="see-student.php?nm=<?php echo htmlentities($company);?>&unplaced=<?php echo htmlentities($result1->id);?>">UnPlaced <i class="fa fa-times-circle"></i></a>
                                                    <?php } 
                                                    ?>
                                        </td>
                                    </tr>
                <?php
                                }
                            } 
                            
                            $cnt = $cnt + 1; ?>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>