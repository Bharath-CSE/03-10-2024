<?php

    if(file_exists("common/database.php"))
    {
        include_once "common/database.php";
    }
    
    class StudentModel extends database_connection
    {
        //This function is for get the data from database and return the data
        function studentList($filteredArray)
        {
            $db=$this->connect();
            $query="select student_id,first_name,last_name,department,number,blood_group,passedout_year,location from student_list where status=:status";
            foreach($filteredArray as $key=>$value)
            {
                $query=$query." && $key"."='$value'";
            }
            $status="Yes";
            $data=$db->prepare($query);
            $data->bindParam(":status",$status);
            $data->execute();
            $rows = $data->fetchAll(PDO::FETCH_ASSOC);
            $check=$data->rowCount();
            if($check==0)
            {
                return "No Records Found";
            }
            else
            {
                return $rows;
            }
        }

        //This function is for insert the data to the database
        function studentForm($arr)
        {
                $db=$this->connect();
                $data=$db->prepare("insert into student_list(first_name,last_name,dob,email,number,image,department,age,blood_group,gender,passedout_year,location) values(:first_name,:last_name,:dob,:email,:number,:image,:department,:age,:blood_group,:gender,:passedout_year,:location)");
                $data->bindParam(":first_name",$arr["firstname"]);
                $data->bindParam(":last_name",$arr['lastname']);
                $data->bindParam(":dob",$arr['dob']);
                $data->bindParam(":email",$arr['email']);
                $data->bindParam(":number",$arr['number']);
                $data->bindParam(":image",$arr['image']);
                $data->bindParam(":department",$arr['department']);
                $data->bindParam(":age",$arr['age']);
                $data->bindParam(":blood_group",$arr['blood_group']);
                $data->bindParam(":gender",$arr['gender']);
                $data->bindParam(":passedout_year",$arr['passedout_year']);
                $data->bindParam(":location",$arr['location']);
                $data->execute();
        }

        function getStudentDetails($id)
        {
            $db=$this->connect();
            $data=$db->prepare("select * from student_list where student_id=:id");
            $data->bindParam(":id",$id);
            $data->execute();
            $rows = $data->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }

        function updateForm($arr)
        {
                $db=$this->connect();
                $data=$db->prepare("update student_list set first_name=:first_name,last_name=:last_name,dob=:dob,email=:email,number=:number,image=:image,department=:department,age=:age,blood_group=:blood_group,gender=:gender,passedout_year=:passedout_year,location=:location where student_id=:id");
                $data->bindParam(":first_name",$arr["firstname"]);
                $data->bindParam(":last_name",$arr['lastname']);
                $data->bindParam(":dob",$arr['dob']);
                $data->bindParam(":email",$arr['email']);
                $data->bindParam(":number",$arr['number']);
                $data->bindParam(":image",$arr['image']);
                $data->bindParam(":id",$arr["id"]);
                $data->bindParam(":department",$arr['department']);
                $data->bindParam(":age",$arr['age']);
                $data->bindParam(":blood_group",$arr['blood_group']);
                $data->bindParam(":gender",$arr['gender']);
                $data->bindParam(":passedout_year",$arr['passedout_year']);
                $data->bindParam(":location",$arr['location']);
                $data->execute();
                $rows = $data->fetchAll(PDO::FETCH_ASSOC);
                return $rows;
        }

        function deleteStudent($id)
        {
                $status="No";
                $db=$this->connect();
                $data=$db->prepare("update student_list set status=:status where student_id=:id");
                $data->bindParam(":status",$status);
                $data->bindParam(":id",$id);
                $data->execute();
        }

        function getOldImage($id)
        {
            $db=$this->connect();
            $data=$db->prepare("select image from student_list where student_id=:id");
            $data->bindParam(":id",$id);
            $data->execute();
            $rows = $data->fetch(PDO::FETCH_ASSOC);
            return $rows;
        }

        function login($username)
        {
            $db=$this->connect();
            $data=$db->prepare("select password from students where userName=:userName");
            $data->bindParam(":userName",$username);
            $data->execute();
            return $data;
        }
    }
?>