

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <title>Modify Capstone</title>
</head>
<body>
    <div id="nb">
        <button onclick="window.location.href='home.php'">Home</button>
        <button onclick="window.location.href='view.php'">View</button>
        <button onclick="window.location.href='add.php'">Add</button>
        <button onclick="window.location.href='modify.php'">Modify</button>
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

                  //connect to the db schema
                  $servername = "localhost:3306";
                  $username = "root";
                  $password = '';
                  $dbname = "capstone_database";

                  
                  $conn = new mysqli($servername, $username, $password, $dbname);
                  //$userCheck = new mysqli("localhost", "kmkelmo1", "vYV7v[66(kX9lD", "kmkelmo1_CS302_Project_Combined");
                  //$conn = new mysqli("localhost", "kmkelmo1", "vYV7v[66(kX9lD", "kmkelmo1_capstone_database");

                  $clientvar=$_REQUEST["client"];
                  $yearvar=$_REQUEST["year"];
                  $titlevar=$_REQUEST["title"];
                  $descvar=$_REQUEST["desc"];
                  $coursevar=$_REQUEST["course"];


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
            
           <label>Client</label><input type="text" id="client" name="client"><br>
            Year<input type="number" id="year" name="year"><br>
            Title<input type="text" id="title" name="title"><br>
            Description<input type="text" id="desc" name="desc"><br><br>
            Key Words<br><br>

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
    
          $projectID = isset($_POST['project']) ? $_POST['project'] : "";
          $client = isset($_POST['client']) ? $_POST['client'] : "";
          $year = isset($_POST['year']) ? $_POST['year'] : "";
          $title = isset($_POST['title']) ? $_POST['title'] : "";
          $desc = isset($_POST['desc']) ? $_POST['desc'] : "";

          $checked_arr = $_POST['checkbox'];  

          if(isset($_POST['modproj'])){
            if(($client != null AND $year != null AND $title != null AND $desc != null)){

            $updateprojectsql = "UPDATE PROJECT
            SET PROJECT.projectyear = '$year', PROJECT.projectname = '$title', PROJECT.projectdescription = '$desc'
            WHERE PROJECT.ProjectID = '$projectID'";

            $updateclientsql = "UPDATE CLIENT
            SET CLIENT.cient = '$client'
            WHERE CLIENT.ProjectID = '$projectID'";

            $updateKWsql = "DELETE FROM ProjectAndKeyword
            WHERE ProjectAndKeyword.ProjectID = '$projectID'"


              if (mysqli_query($conn, $updateprojectsql)) {
                echo "Project Table Updated successfully.";
              }   else {
                echo "Error: " . $updateprojectsql . "<br>" . mysqli_error($conn);
              }

              if (mysqli_query($conn, $updateclientsql)) {
                echo "Client Table Updated successfully.";
              }   else {
                echo "Error: " . $updateclientsql . "<br>" . mysqli_error($conn);
              }

              if (mysqli_query($conn, $updateKWsql)) {
                  echo "Project Table Updated successfully.";
              }   else {
                  echo "Error: " . $updateKWsql . "<br>" . mysqli_error($conn);
              }  
            } else {
                echo "Please fill in all Fields";
            }
          }



          if(isset($_POST['deleteproj'])){
            
            $deletesql = "UPDATE PROJECT, CLIENT, PROJECTANDCLIENT
            SET PROJECT.archive = 1
            WHERE PROJECTANDCLIENT.ProjectID = '$projectID'";


          if (mysqli_query($conn, $deletesql)) {
            echo "Status Updated successfully.";
          } else {
            echo "Error: " . $deletesql . "<br>" . mysqli_error($conn);
          }
          }
          ?>

          <script>
            function confirmDelete() {
              if (confirm("Are you sure you want to delete this project?")){

              } else {}
            }
          </script>  
</body>


</html>
