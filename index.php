<?php 
// databse connection 
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "search";
$conn = new mysqli($server, $user, $pass, $db);
$notify = $valid = $error = $sms = null;
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass  = $_POST['password'];
    if(!empty($name) && !empty($email) && !empty($pass)) {
        if(is_string($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $insert_sql = "INSERT INTO s_box(name, email, password) VALUES('$name','$email','$pass')";
            if($conn ->query($insert_sql)) {
                $notify = "<h4 class='text-success'>Data inserted successfully</h4>";
            } else {
                die($conn ->error);
            }
        } else {
            $valid = "<h4 class='text-danger'>Please, insert valid name & email</h4>";
        }
    } else {
        $error = "<h4 class='text-danger'>Empty field is not accepted</h4>";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="mt-5">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
                <div class="my-5">
                    <?php 
                    echo $notify;
                    echo $valid;
                    echo $error;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <div class="mb-3">
                <label for="search" class="form-label">Search by name</label>
                <input type="search" class="form-control" id="search" name="search">
            </div>
            <button type="submit" name="find" class="btn btn-success">Search</button>
        </form>
    </div>
    <div class="container">
        
        <table class="table bordered">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
            <?php 
            if(isset($_POST['find'])) {
                $search = $_POST['search'];
                $select_sql = "SELECT * FROM s_box WHERE `name` LIKE '%$search%'";
                $select_run = $conn ->query($select_sql);
                if($select_run ->num_rows > 0) {
                    while($result = mysqli_fetch_assoc($select_run)) {
                        $sms = "<h4>Results by <span style='text-decoration: underline;color:green;'>$search</span> </h4>";
                        echo 
                        "
                        <tr>
                            <td>".$result['name']."</td>
                            <td>".$result['email']."</td>
                            <td>".$result['password']."</td>
                        </tr>
                        ";
                    }
                } else {
                    echo 
                    "
                    <tr>
                        <td>No result found.</td>
                        <td></td>
                        <td></td>
                    </tr>
                    ";
                }
                } else {
                    echo 
                    "
                    <tr>
                        <td>Search to see data.</td>
                        <td></td>
                        <td></td>
                    </tr>
                    ";
                }
            ?>
            <?php echo $sms; ?>
        </table>
    </div>
    <script>
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>