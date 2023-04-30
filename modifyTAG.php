<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="nb">
        <button onclick="window.location.href='home.html'">Home</button>
        <button onclick="window.location.href='view.html'">View</button>
        <button onclick="window.location.href='add.html'">Add</button>
        <button onclick="window.location.href='modify.html'">Modify</button>
        <button onclick="window.location.href='addStudents.php'">Add Student(s)</button>
    </div>
    <button id="trb" onclick="window.location.href='logout.html'">Log out</button>
    <h1>Modify Capstone</h1>
    <div id="modify">
          <form action="" method="post">
            <div class="form-group">
            <label for="project">Select Capstone:</label><br>
            <select class="form-control" id="project" name="projlst">

              <!-- PHP code to establish connection with the localserver -->
              <?php
                  session_start();
                  ob_start();

                  $conn = new mysqli("localhost", "kmkelmo1", "vYV7v[66(kX9lD", "kmkelmo1_capstone_database");

                  // Check connection
                  if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                  }
                      
                  $sql = "SELECT * FROM project"; //Add archive filter
                  $result = mysqli_query($conn,$sql);
                  //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

                  //display the sql result set in an html table
                  $table = $conn->query($sql);
                  if ($table->num_rows > 0) {
                    //output each result row
                    while($row = $result->fetch_assoc()){
                      echo "<option value ='" . $row['ProjectID'] . "'>" . $row['ProjectName'] . "  </option>";
                    }
                  }     
                ?>
              </select></div><br>
        Client <input type="text" id="client" name="clientv"><br>
        Year<input type="number" id="year" name="yearv"><br>
        Title<input type="text" id="title" name="titlev"><br>
        Description<input type="text" id="desc" name="descv"><br>
        Course<input type="text" id="course" name="coursev"><br>
        Key Words<br><br>
        <div class="checkbox-grid">

			<label><input type="checkbox" name="checkbox[]" id="/" value="1">Algorithms</label>
			<label><input type="checkbox" name="checkbox[]" id="/" value="2">CMS</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="3">Communication</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="4">Contest</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="5">Database</label>

            <label><input type="checkbox" name="checkbox[]" id="/" value="6">e-Commerce</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="7">Education</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="8">Events</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="9">External</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="10">External - For Profit</label>

            <label><input type="checkbox" name="checkbox[]" id="/" value="11">File Storage</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="12">Internal</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="13">KMS</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="14">Marketing</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="15">Networks</label>

            <label><input type="checkbox" name="checkbox[]" id="/" value="16">Open Source</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="17">Procedures</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="18">Programming</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="19">Queries</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="20">Resources</label>

            <label><input type="checkbox" name="checkbox[]" id="/" value="21">Security</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="22">Social</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="23">Web</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="24">Website</label>
            <label><input type="checkbox" name="checkbox[]" id="/" value="25">Workshop</label>
        </div>
        <input type="submit">
    </form>

    <?php
        //connect to the db schema
        session_start();
        ob_start();
        $userCheck = new mysqli("localhost", "kmkelmo1", "vYV7v[66(kX9lD", "kmkelmo1_CS302_Project_Combined");
        $dbConn = new mysqli("localhost", "kmkelmo1", "vYV7v[66(kX9lD", "kmkelmo1_capstone_database");
        

        $clientvar=$_REQUEST["clientv"];
        $yearvar=$_REQUEST["yearv"];
        $titlevar=$_REQUEST["titlev"];
        $descvar=$_REQUEST["descv"];
        $coursevar=$_REQUEST["coursev"];
        // When updating capstone, check if client already exists, if not add new client to client table
    
        // Check connection
        if ($userCheck->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        } 

        if (isset($_SESSION["inputUser"])) {

            if ($_SESSION["role"] != Admin) {
                echo "<p>Permission denied</p>";
            } else {
                if ($clientvar != null AND $yearvar != null AND $titlevar != null AND $descvar != null) {
                    $stmtProj = $dbConn->prepare("UPDATE Project SET (ProjectName, ProjectDescription, Course, ProjectYear) VALUES (?,?,?,?)");
                    $stmtProj->bind_param("ssss", $titlevar, $descvar, $coursevar, $yearvar);
                    $stmtProj->execute();
                    $stmtProj->close();
                    echo "echo 0 ";
                    $projID=$dbConn->query("SELECT ProjectID FROM Project ORDER BY ProjectID DESC LIMIT 1;");
                    $projIDrow = $projID->fetch_assoc();
                    echo "echo 1 ";

                    $result1 = $dbConn->query("SELECT ClientName FROM Client WHERE ClientName = '$clientvar'");
                    if($result1->num_rows == 0) {
                        $stmtClient = $dbConn->prepare("INSERT INTO Client(ClientName) VALUES (?)");
                        $stmtClient->bind_param("s", $clientvar);
                        $stmtClient->execute();
                        $stmtClient->close();
                        $clientID=$dbConn->query("SELECT ClientID FROM Client ORDER BY ClientID DESC LIMIT 1;");
                        $clientIDrow = $clientID->fetch_assoc();
                        echo "echo 2 ";
                        echo $projIDrow;
                        echo $clientIDrow;

                        $stmtClient2 = $dbConn->prepare("INSERT INTO ProjectAndClient(ProjectID, ClientID) VALUES (?,?)");
                        $stmtClient2->bind_param("ss", $projIDrow["ProjectID"], $clientIDrow["ClientID"]);
                        $stmtClient2->execute();
                        $stmtClient2->close();
                        echo "echo 3 ";
                    } else {
                        $clientID=$dbConn->query("SELECT ClientID FROM Client WHERE ClientName = '$clientvar'");
                        $clientIDrow = $clientID->fetch_assoc();

                        $stmtClient2 = $dbConn->prepare("INSERT INTO ProjectAndClient(ProjectID, ClientID) VALUES (?,?)");
                        $stmtClient2->bind_param("ss", $projIDrow["ProjectID"], $clientIDrow["ClientID"]);
                        $stmtClient2->execute();
                        $stmtClient2->close();
                        echo "echo 4 ";
                    }
                    

                }
                
                $checked_arr = $_POST['checkbox'];
                $projectID = isset($_POST['project']) ? $_POST['project'] : "";
                $stmtKWdel = $dbConn->prepare("DELETE FROM ProjectAndKeyword WHERE ProjectID = '$projectID'");
                $stmtKWdel->bind_param("s", $clientvar);
                $stmtKWdel->execute();
                $stmtKWdel->close();

                foreach ($checked_arr as $value) {
                    $stmtKW=$dbConn->prepare("INSERT INTO ProjectAndKeyword(KeywordID, ProjectID) VALUES (?,?)");
                    $stmtKW->bind_param("ss", $value, $projIDrow["ProjectID"]);
                    $stmtKW->execute();
                    $stmtKW->close();
                }
                echo "<table>";
                foreach ($_POST as $key => $value) {
                    echo "<tr>";
                    echo "<td>";
                    echo $key;
                    echo "</td>";
                    echo "<td>";
                    echo $value;
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }


        }









$userCheck->close();
$dbConn->close();      
    ?>
</body>
</html>