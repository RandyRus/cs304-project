<!--Editing Tutorial 7 Code for Project Milestone 4: Group 36
    Need Update Fix(for all attributes), Deletion, Selection, Projection, Join, Aggregation with Group By, Aggregation with Having, Nested Aggregation with Group By, Division
                -->

                <html>
    <head>
        <title>CPSC 304 Project Group 36</title>
    </head>

    <body>
        <h2>Insert Values into developers</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="insertQueryRequest" name="insertQueryRequest" Speciality="insertQueryRequest">
            devID: <input type="text" name="insdevID"> <br /><br />
            Name: <input type="text" name="insName"> <br /><br />
            Speciality: <input type="text" name="insSpeciality"> <br /><br />


            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Delete Values in developers</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="deleteQueryRequest" name="deleteQueryRequest" Speciality="deleteQueryRequest">
            devID: <input type="text" name="insdevID"> <br /><br />

            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />

        <h2>Update in developers</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="updateQueryRequest" name="updateQueryRequest" Speciality="updateQueryRequest">
            id: <input type="checkbox" id="update1" name="update1" value="1"><br/>
            name: <input type="checkbox" id="update2" name="update2" value="1"><br/>
            speciality: <input type="checkbox" id="update3" name="update3" value="1"><br/>

            <label for="updateDevIDQueryRequest"></label><br>
            devID: <input type="text" name="oldDevID"> <br /><br />
            New value: <input type="text" name="newInput"> <br /><br />
            

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Select developers with given speciality and developer id higher than given developer ID</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="selectTupleRequest" name="selectTupleRequest" Speciality="selectTupleRequest">
            Speciality: <input type="text" name="insSpeciality"> <br /><br />
            devID: <input type="text" name="insdevID"> <br /><br />


            <input type="submit" value="select" name="selectSubmit"></p>
        </form>


        <hr/>
        <h2>Projection, Select Developer columns to display</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="checkbox" id="projection1" name="projection1" value="1">
            <label for="projection1"> Dev id</label><br>
            <input type="checkbox" id="projection2" name="projection2" value="1">
            <label for="projection2"> Name</label><br>
            <input type="checkbox" id="projection3" name="projection3" value="1">
            <label for="projection3"> Speciality</label><br>

            <input type="submit" name="projection"></p>
        </form>
        

        <hr/>

        <h2>Join, Display software being worked on by a developer</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="joinTupleRequest" name="joinTupleRequest" Speciality="joinTupleRequest">
            devID: <input type="text" name="insdevID"> <br /><br />
            <input type="submit" name="joinTuples"></p>
        </form>

        <hr />
        

        <h2>Aggregation with group by - Group by specialization and count the number of developers in them</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="groupTupleRequest" name="groupTupleRequest" Speciality="groupTupleRequest">
            <input type="submit" name="groupTuples"></p>
        </form>
        <hr />

        <h2>Aggregation with having - Group by specialization and count the number of developers in them with count greater than one</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="groupWithHavingTupleRequest" name="groupWithHavingTupleRequest" Speciality="groupWithHavingTupleRequest">
            <input type="submit" name="groupTuples"></p>
        </form>
        <hr />

        <h2>Nested aggregation with group by - Select the smallest developer ID in each speciality (with count) where each specialization has more than or equal to the given number of developers</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="groupByNestedTupleRequest" name="groupByNestedTupleRequest" Speciality="groupByNestedTupleRequest">
            Number: <input type="text" name="num"> <br /><br />
            <input type="submit" name="groupByNestedTuples"></p>
        </form>

        <hr/>
        <h2>Division, Display developers working on all software</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="divideTupleRequest" name="divideTupleRequest" Speciality="divideTupleRequest">
            <input type="submit" name="divideTuples"></p>
        </form>

        <hr />

        <h2>Count the Tuples in developers</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="countTupleRequest" name="countTupleRequest" Speciality="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>
        <hr />

        <h2>Display The Tuples In developers</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" devID="displayTupleRequest" name="displayTupleRequest" Speciality="displayTupleRequest">
            <input type="submit" name="displayTuples"></p>
        </form>


        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr); 

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection. 
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table developers:<br>";
            echo "<table>";
            echo "<tr><th>devID</th><th>Name</th><th>Speciality</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["DEV_ID"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["SPECIALITY"] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function printResultJoin($result) { //prints results from a select statement
            echo "<br>Retrieved data from table developers and work_on:<br>";
            echo "<table>";
            echo "<tr><th>devID</th><th>Name</th><th>Speciality</th><th>software name</th><th>software version</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["DEV_ID"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["SPECIALITY"] . "</td><td>" . $row["SOFTWARE_NAME"] . "</td><td>" . $row["SOFTWARE_VERSION"] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function printGroupByResult($result) {
            echo "<br>Retrieved data from table developers:<br>";
            echo "<table>";
            echo "<tr><th>Speciality</th><th>Count</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["SPECIALITY"] . "</td><td>" . $row["COUNT"] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function printGroupByNestedResult($result) {
            echo "<br>Retrieved data from table developers:<br>";
            echo "<table>";
            echo "<tr><th>Speciality</th><th>Count</th><th>devID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["SPECIALITY"] . "</td><td>" . $row["COUNT"] . "</td><td>" . $row["MIN"] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function printResultProjection($result) { //prints results from a select statement
            echo "<br>Retrieved data from table developers:<br>";
            echo "<table>";
            
            echo "<tr>";

            if ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                if ($row["DEV_ID"])
                    echo "<th>"."dev id" ."</th>";
                if ($row["NAME"])
                    echo "<th>"."name"."</th>";
                if ($row["SPECIALITY"])
                    echo "<th>". "speciality"."</th>";

                echo "</tr>";

                echo "<tr>";

                if ($row["DEV_ID"])
                    echo "<th>".$row["DEV_ID"] ."</th>";
                if ($row["NAME"])
                    echo "<th>".$row["NAME"] ."</th>";
                if ($row["SPECIALITY"])
                    echo "<th>". $row["SPECIALITY"]."</th>";

                echo "</tr>";
            }

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr>";

                if ($row["DEV_ID"])
                    echo "<th>".$row["DEV_ID"] ."</th>";
                if ($row["NAME"])
                    echo "<th>".$row["NAME"] ."</th>";
                if ($row["SPECIALITY"])
                    echo "<th>". $row["SPECIALITY"]."</th>";

                echo "</tr>";
            }

            echo "</table>";
        }

        function printResultDivision($result) {
            echo "<br>Retrieved data from table developers:<br>";
            echo "<table>";
            echo "<tr><th>devID</th><th>Name</th><th>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["DEV_ID"] . "</td><td>" . $row["NAME"] . "</td><td>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_fenliu16", "a43249952", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;

            $old_DevID = $_POST['oldDevID'];
            $new_input = $_POST['newInput'];


            $columns ="";

            // you need the wrap the old name and new name values with single quotations

            if (strcmp($_POST['update1'],"1") == 0) {
                $queryString="UPDATE developers SET dev_id='" . $new_input . "' WHERE dev_id='" . $old_DevID . "'";
                echo $queryString;
                executePlainSQL($queryString);
            }
            else if (strcmp($_POST['update2'],"1") == 0) {
                $queryString="UPDATE developers SET name='" . $new_input . "' WHERE dev_id='" . $old_DevID . "'";
                echo $queryString;
                executePlainSQL($queryString);
            }
            else if (strcmp($_POST['update3'],"1") == 0) {
                $queryString="UPDATE developers SET speciality='" . $new_input . "' WHERE dev_id='" . $old_DevID . "'";
                echo $queryString;
                executePlainSQL($queryString);
            }


            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            // executePlainSQL("DROP TABLE developers");
            // $output1 = shell_exec('/m2_ddl.sql');
            // echo "<br> output $output1 <br>";

            // Create new table
            echo "<br> creating new table <br>";
            // executePlainSQL("CREATE TABLE developers (devID int PRIMARY KEY, name char(30), Speciality char(30))");
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['insdevID'],
                ":bind2" => $_POST['insName'],
                ":bind3" => $_POST['insSpeciality']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into developers values (:bind1, :bind2, :bind3)", $alltuples);
            OCICommit($db_conn);
        }

        function handleDeleteRequest() {
            global $db_conn;

            $id = $_POST['insdevID'];
            $result = executePlainSQL("DELETE FROM developers WHERE dev_id=" . $id);
            
            handleDisplayRequest();
            OCICommit($db_conn);
        }

        function handleJoinRequest() {
            global $db_conn;
            $id = $_GET['insdevID'];

            $result = executePlainSQL("SELECT * FROM developers d natural join work_on w WHERE dev_id=" . $id);
            
            printResultJoin($result);
        }

        function handleSelectRequest() {
            global $db_conn;

            $spec = $_GET['insSpeciality'];
            $id = $_GET['insdevID'];

            $result = executePlainSQL("SELECT * FROM developers WHERE speciality = '" . $spec . "' AND dev_id > ' " . $id ." '");
            
            printResult($result);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM developers");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in developers: " . $row[0] . "<br>";
            }
        }

        function handlegroupTupleRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT speciality, count(*) as COUNT FROM developers GROUP BY speciality");

            printGroupByResult($result);
        }

        function handlegroupWithHavingTupleRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT speciality, count(*) as COUNT FROM developers GROUP BY speciality having count(*) > 1");

            printGroupByResult($result);
        }

        function handlegroupByNestedTupleRequest() {
            global $db_conn;

            $num = $_GET['num'];

            $result = executePlainSQL("SELECT d.speciality, count(dev_id) as COUNT, MIN(dev_id) as MIN FROM developers d GROUP BY d.speciality HAVING ". $num ." <= (SELECT count(*) FROM developers d2 where d2.speciality = d.speciality)");

            printGroupByNestedResult($result);
        }

        function handleDisplayRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM developers");
            
            printResult($result);
        }

        function handleProjectionRequest() {
            global $db_conn;
            $proj1 = isset($_POST['projection1']);
            $proj2 = isset($_POST['projection2']);
            $proj3 = isset($_POST['projection3']);

            $columns ="";

            if (strcmp($_GET['projection1'],"1") == 0)
                $columns = $columns.",dev_id";
            if (strcmp($_GET['projection2'],"1") == 0)
                $columns .=  ",name";
            if (strcmp($_GET['projection3'],"1") == 0)
                $columns .=  ",speciality";

            $columns = substr($columns, 1); #remove comma

            if ($columns != "") {
                $result = executePlainSQL("SELECT " . $columns . " FROM developers");
                
                printResultProjection($result);
            }
        }

        function handleDivideRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM developers D WHERE NOT EXISTS ((SELECT S.software_name FROM software S) MINUS (SELECT W.software_name FROM work_on W WHERE W.dev_id= D.dev_id))");

            printResult($result);
        }
        

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest();
                }
                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } else if (array_key_exists('displayTuples', $_GET)) {
                    handleDisplayRequest();
                } elseif (array_key_exists('selectTupleRequest', $_GET)) {
                    handleSelectRequest();
                } elseif (array_key_exists('joinTupleRequest', $_GET)) {
                    handleJoinRequest();
                } elseif (array_key_exists('groupTupleRequest', $_GET)) {
                    handlegroupTupleRequest();
                } elseif (array_key_exists('groupWithHavingTupleRequest', $_GET)) {
                    handlegroupWithHavingTupleRequest();
                } elseif (array_key_exists('groupByNestedTupleRequest', $_GET)) {
                    handlegroupByNestedTupleRequest();
                } elseif (array_key_exists('projection', $_GET)) {
                    handleProjectionRequest();
                } elseif (array_key_exists('divideTupleRequest', $_GET)) {
                    handleDivideRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateDevIDQueryRequest']) || isset($_POST['updateNameQueryRequest']) || isset($_POST['updateSpecialityQueryRequest']) ||
                                    isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit']) || isset($_POST['updateQueryRequest'])) {
            handlePOSTRequest();
        } else if  (isset($_GET['countTupleRequest']) ||
                    isset($_GET['displayTupleRequest']) ||
                    isset($_GET['selectTupleRequest']) ||
                    isset($_GET['joinTupleRequest'])   ||
                    isset($_GET['groupTupleRequest']) ||
                    isset($_GET['groupWithHavingTupleRequest']) ||
                    isset($_GET['groupByNestedTupleRequest']) ||
                    isset($_GET['divideTupleRequest']) ||
                    isset($_GET['projection1']) || isset($_GET['projection2']) || isset($_GET['projection3'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>
