<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Student List</title>
    <link rel='stylesheet' href='view/style.css'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
</head>
<body class='listBackground'>
    <div class='list_logout_button'>
        <a href='index.php?mod=student&view=logout'><button class='btn btn-danger'>Logout</button></a>
    </div>
    <h1 class='listText'>Welcome <?php echo $_SESSION["Name"] ?></h1>
    <div class='border rounded-pill'>
        <h3 class='sub_heading'>Filters</h3>
        <div class='filter'>
                <form method="post" action="index.php?mod=student&view=studentList">
                    <div class='form-group filters'>
                                <label class='list_label'><b>
                                        Department:
                                    </b>
                                </label>
                                <input type='text' name='dept_filter' placeholder='Department' class='form-control filter_input' value='<?php echo isset($_POST["dept_filter"]) ? $_POST["dept_filter"] : '' ?>'>
                                <label class='list_label'><b>Blood Group:</b></label>
                                <input type='text' name='blood_group_filter' placeholder='Blood Group' class='form-control filter_input' value='<?php echo isset($_POST["blood_group_filter"]) ? $_POST["blood_group_filter"] : '' ?>'>
                                <label class='list_label'><b>
                                        Passedout Year:
                                    </b>
                                </label>
                                <input type='number' name='passedout_year_filter' placeholder='Passedout Year' class='form-control filter_input' value='<?php echo isset($_POST["passedout_year_filter"]) ? $_POST["passedout_year_filter"] : '' ?>'>
                                <input type='submit' class='btn btn-primary' name='submit'>
                    </div>
                </form>
        </div>
    </div>
    <a href='index.php?mod=student&view=studentList'><button class='btn btn-primary students'>View All Students</button></a>
    <a href='index.php?mod=student&view=studentForm'><button class='btn btn-primary students'>Create Form</button></a>
    <table cellspacing='0' cellpadding='20' border='1' width='800' class='table table-bordered table-hover table-secondary'>
        <tr class='table-dark'>
            <td align="center"><b>S.NO</b></td>
            <td align="center"><b>Name</b></td>
            <td align="center"><b>Department</b></td>
            <td align="center"><b>Number</b></td>
            <td align="center"><b>Blood Group</b></td>
            <td align="center"><b>Location</b></td>
            <td align="center"><b>Passedout Year</b></td>
            <td align="center"><b>Actions</b></td>
        </tr>
        <?php
        $s_no=0;
        if(is_array($rows))
        {
            foreach ($rows as $row) 
            {
                    $s_no++;
                    echo "<tr>
                                <td align='center'>{$s_no}</td>
                                <td align='center'>{$row['first_name']} {$row['last_name']}</td>
                                <td align='center'>{$row['department']}</td>
                                <td align='center'>{$row['number']}</td>
                                <td align='center'>{$row['blood_group']}</td>
                                <td align='center'>{$row['location']}</td>
                                <td align='center'>{$row['passedout_year']}</td>
                                <td align='center'><a href=index.php?mod=student&view=getStudentDetails&id={$row['student_id']}><button class='btn btn-secondary'>Update</button></a> 
                                <a href=index.php?mod=student&view=deleteStudent&id={$row['student_id']}><button class='btn btn-danger'>Delete</button></a>
                                <a href=index.php?mod=student&view=viewStudent&id={$row['student_id']}><button class='btn btn-success'>View</button></a>
                                </td>
                          </tr>";
            }
        }
        ?>
    </table>
        <?php if(!is_array($rows)) echo "<p class='records'>$rows</p>";?>
</body>
</html>