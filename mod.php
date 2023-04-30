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

            <?php
                session_start();
                ob_start();

                //connect to the db schema
                $servername = "localhost:3306";
                $username = "root";
                $password = '';
                $dbname = "capstone_database";

                $conn = new mysqli($servername, $username, $password, $dbname);

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
            <label for="client">Client</label>
            <input type="text" id="client" name="clientv"><br>

            <label for="year">Year</label>
            <input type="number" id="year" name="yearv"><br>

            <label for="title">Title</label>
            <input type="text" id="title" name="titlev"><br>

            <label for="desc">Description</label>
            <input type="textarea" id="desc" name="descv"><br>

            <label for="course">Course</label>
            <input type="text" id="course" name="coursev"><br>

            <label for="keyword">Key Words</label><br><br>
            <ul class="checkboxes">
              <li><label><input type="checkbox" name="keyword" id="Algorithms" value="1">Algorithms</label></li>
              <li><label><input type="checkbox" name="keyword" id="CMS" value="2">CMS</label></li>
              <li><label><input type="checkbox" name="keyword" id="Communication" value="3">Communication</label></li>
              <li><label><input type="checkbox" name="keyword" id="Contest" value="4">Contest</label></li>
              <li><label><input type="checkbox" name="keyword" id="Database" value="5">Database</label></li>
              <li><label><input type="checkbox" name="keyword" id="e-Commerce" value="6">e-Commerce</label></li>
              <li><label><input type="checkbox" name="keyword" id="Education" value="7">Education</label></li> 
              <li><label><input type="checkbox" name="keyword" id="Events" value="8">Events</label></li><br>
              <li><label><input type="checkbox" name="keyword" id="External" value="9">External</label></li>
              
              <li><label><input type="checkbox" name="keyword" id="ForProfit" value="10">External - For Profit</label></li>
              <li><label><input type="checkbox" name="keyword" id="FileStorage" value="11">File Storage</label></li>
              <li><label><input type="checkbox" name="keyword" id="Internal" value="12">Internal</label></li>
              <li><label><input type="checkbox" name="keyword" id="KMS" value="13">KMS</label></li>
              <li><label><input type="checkbox" name="keyword" id="Marketing" value="14">Marketing</label></li>
              <li><label><input type="checkbox" name="keyword" id="Networks" value="15">Networks</label></li>
              <li><label><input type="checkbox" name="keyword" id="OpenSource" value="16">Open Source</label></li>
              <li><label><input type="checkbox" name="keyword" id="Procedures" value="17">Procedures</label></li>
              
              <li><label><input type="checkbox" name="keyword" id="Programming" value="18">Programming</label></li>
              <li><label><input type="checkbox" name="keyword" id="Queries" value="19">Queries</label></li>
              <li><label><input type="checkbox" name="keyword" id="Resources" value="20">Resources</label></li>
              <li><label><input type="checkbox" name="keyword" id="Security" value="21">Security</label></li>
              <li><label><input type="checkbox" name="keyword" id="Social" value="22">Social</label></li>
              <li><label><input type="checkbox" name="keyword" id="Web" value="23">Web</label></li>
              <li><label><input type="checkbox" name="keyword" id="Website" value="24">Website</label></li>
              <li><label><input type="checkbox" name="keyword" id="Workshop" value="25">Workshop</label></li>
            </ul>
            <div class="container">
            <input type="submit" id="deleteproj" name="deleteproj" value="Delete" style="width: 50%; float: left;" onclick="confirmDelete()">
            <input type="submit" id="modproj" name="modproj" value="Modify" style="width: 50%; float: left;">
            </div>
          </form>         
          </div></div>

        <?php
            //connect to the db schema
            $servername = "localhost:3306";
            $username = "root";
            $password = '';
            $dbname = "capstone_database";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $clientvar=$_REQUEST["clientv"];
                $yearvar=$_REQUEST["yearv"];
                $titlevar=$_REQUEST["titlev"];
                $descvar=$_REQUEST["descv"];
                $coursevar=$_REQUEST["coursev"];
            }
            //echo "client:" . $clientvar . " year:" . $yearvar . " title:" . $titlevar . " description:" . $descvar . " course:" . $coursevar

            
            //check if client already exists, if not add new client to client table
            if ($clientvar != null AND $yearvar != null AND $titlevar != null AND $descvar != null AND $coursevar != null) {
                $stmtProj = $conn->prepare("UPDATE Project SET (ProjectName, ProjectDescription, Course, ProjectYear) VALUES (?,?,?,?)");
                $stmtProj->bind_param("ssss", $titlevar, $descvar, $coursevar, $yearvar);
                $stmtProj->execute();
                $stmtProj->close();

            //Get Client Table info
            $result1 = $conn->query("SELECT ClientName FROM Client WHERE ClientName = '$clientvar'");
            //if client not found, add to Client table
            if($result1->num_rows == 0) {
                $stmtClient = $conn->prepare("INSERT INTO Client(ClientName) VALUES (?)");
                $stmtClient->bind_param("s", $clientvar);
                $stmtClient->execute();
                $stmtClient->close();
                
                // add new client project association    
                $stmtClient2 = $conn->prepare("INSERT INTO ProjectAndClient(ProjectID, ClientID) VALUES (?,?)");
                $stmtClient2->bind_param("ss", $projIDrow["ProjectID"], $clientIDrow["ClientID"]);
                $stmtClient2->execute();
                $stmtClient2->close();
            //else if client already exists, update CLIENT and ProjectAndClient tables    
            } else {
            $clientID=$conn->query("SELECT ClientID FROM Client WHERE ClientName = '$clientvar'");
            $clientIDrow = $clientID->fetch_assoc();

            $stmtClient3 = $conn->prepare("UPDATE ProjectAndClient SET (ProjectID, ClientID) VALUES (?,?)");
            $stmtClient3->bind_param("ss", $projIDrow["ProjectID"], $clientIDrow["ClientID"]);
            $stmtClient3->execute();
            $stmtClient3->close();
            }
            
            
            } else {
                echo "Please fill in all Fields";
            }    
        ?>    
