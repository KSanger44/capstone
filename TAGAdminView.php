<!DOCTYPE html>
<?php
session_start();
ob_start();

if (isset($_REQUEST["logout"])) {
    session_unset();
    header("Location: index.php");
}
?>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Edgewood CS Capstone - View</title>
    <style> 
        td, table{
            border: 2px black solid;
        }
        table{
            margin: auto;
        }
    </style>

</head>
<body>
    <div id="nb">
        <button onclick="location.href='AdminHP-TAG.php'">Go Back</button>
        <button onclick="location.href='search.html'">Search</button>
        <button onclick="location.href='add.html'">Add</button>
        <button onclick="location.href='modify.html'">Modify</button>
    </div>
            <form style="display: inline; float: right;"> 
            <input type="hidden" id="logout" name="logout" value="1">
            <button type="submit" > 
                Logout
            </button>
        </form>

    <div style="width: 70%; margin-left: 15%; height: auto; text-align: center;">
        <br> <br>
        
            <h1>Capstone List</h1>
        <br> <br>
    <table>
           

                <?php
                    $conn = new mysqli("localhost", "kmkelmo1", "vYV7v[66(kX9lD", "kmkelmo1_capstone_database");
    
                        if ($conn->connect_error) {
                            echo "Connection error";
                        } else {
                            $sql = "SELECT ProjectID, ProjectName, ProjectDescription, Course, ProjectYear FROM Project where archive=0";
                            $result = $conn->query($sql);
                            
                            echo "
                                <tr>
                                    <th> Capstone Name </th>
                                    <th> Capstone Description </th>
                                    <th> Capstone Memebers </th>
                                    <th> Client </th>
                                    <th> Keywords </th>
                                    <th> Course </th>
                                    <th> Year </th> 
                                </tr>
                            ";
                            
                            while($row = $result->fetch_assoc()){
                                
                                $id = $row['ProjectID'];
                                $name = $row['ProjectName'];
                                $description = $row['ProjectDescription'];
                                $course = $row['Course'];
                                $year = $row['ProjectYear'];
                                
                                
                                $sql1 = "SELECT ClientID FROM ProjectAndClient WHERE ProjectID='$id'";
                                $result1 = $conn->query($sql1);
                                $row1 = $result1->fetch_assoc();
                                $clientID = $row1['ClientID'];
                                
                                $sql2 = "SELECT ClientName FROM Client WHERE ClientID='$clientID'";
                                $result2 = $conn->query($sql2);
                                $row2 = $result2->fetch_assoc();
                                $client = $row2['ClientName'];
                                
                                
                                $sql3 = "SELECT StudentID FROM ProjectAndStudent WHERE ProjectID='$id'";
                                $result3 = $conn->query($sql3);
                                $studentNames = " | ";
                                while($row3=$result3->fetch_assoc()){
                                    $studentID = $row3['StudentID'];
                                    $sql4 = "SELECT FirstName, LastName FROM Student WHERE StudentID='$studentID'";
                                    $result4 = $conn->query($sql4);
                                    $row4 = $result4->fetch_assoc();
                                    $student = $row4['FirstName']." ".$row4['LastName'];
                                    $studentNames = $studentNames."".$student." | ";
                                }
                                
                                $sql5 = "SELECT KeywordID FROM ProjectAndKeyword WHERE ProjectID='$id'";
                                $result5 = $conn->query($sql5);
                                $keywords =" | ";
                                while($row5=$result5->fetch_assoc()){
                                    $keywordID = $row5['KeywordID'];
                                    $sql6 = "SELECT Keyword FROM Keyword WHERE KeywordID='$keywordID'";
                                    $result6 = $conn->query($sql6);
                                    $row6 = $result6->fetch_assoc();
                                    $keyword = $row6['Keyword'];
                                    $keywords = $keywords."".$keyword." | ";
                                }
    
                                echo "
                                    <tr>
                                        <td> $name </td>
                                        <td> $description </td>
                                        <td> $studentNames </td>
                                        <td> $client </td>
                                        <td> $keywords </td>
                                        <td> $course </td>
                                        <td> $year </td>
                                    </tr>
                                ";
    
                            }
                        }
    
                ?>

        </table>

    </div>
    


</body>
</html>