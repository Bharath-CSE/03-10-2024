<?php
    class StudentController
    {
        public $Obj;
        function __construct()
        {
            if(file_exists("./model/studentModel.php"))
            {
                include_once "./model/studentModel.php";
            }
            $this->Obj=new StudentModel();
        }

        //This function is for call the model and view
        function studentList()
        {   
            if(isset($_SESSION["Name"]))
            {
                $arr=array();
                $arr['department']=isset($_POST['dept_filter']) ? $_POST['dept_filter'] : null;
                $arr['blood_group']=isset($_POST['blood_group_filter']) ? $_POST['blood_group_filter'] : null;
                $arr['passedout_year']=isset($_POST['passedout_year_filter']) ? $_POST['passedout_year_filter'] : null;
                $filteredArray=array_filter($arr);
                $rows=$this->Obj->studentList($filteredArray);
                if(file_exists("./view/studentList.php"))
                {   
                    include_once "./view/studentList.php";
                }
            }
            else
            {
                $this->redirect_login();
            }
        }

        //This function is for studentData Form
        function studentForm()
        {
            if(isset($_SESSION["Name"]))
            {
                if(isset($_POST['submit']))
                {
                    $arr=array();
                    $arr['firstname']=$_POST['firstname'];
                    $arr['lastname']=$_POST['lastname'];
                    $arr['dob']=$_POST['dob'];
                    $arr['email']=$_POST['email'];
                    $arr['number']=$_POST['number'];
                    $imagePath=$this->file_upload();
                    $arr['image']=$imagePath;
                    $arr['department']=$_POST['department'];
                    $arr['age']=$_POST['age'];
                    $arr['blood_group']=$_POST['blood_group'];
                    $arr['gender']=$_POST['gender'];
                    $arr['passedout_year']=$_POST['passedout_year'];
                    $arr['location']=$_POST['location'];
                    $this->Obj->studentForm($arr);
                    header("Location: index.php?mod=student&view=studentList");
                }
                if(file_exists("./view/studentForm.php"))
                {
                    include_once "./view/studentForm.php";
                }
            }
            else
            {
                $this->redirect_login();
            }
            
        }

        function getStudentDetails()
        {
            if(isset($_SESSION["Name"]))
            {
                $id=$_GET['id'];
                $rows=$this->Obj->getStudentDetails($id);
                if(file_exists("./view/updateForm.php"))
                {
                    include_once "./view/updateForm.php";
                }
            }
            else
            {
                $this->redirect_login();
            }
        }

        //This function is for updateData Form
        function updateForm()
        {
            if(isset($_SESSION["Name"]))
            {
                $id=$_GET['id'];
                if(isset($_POST['submit']))
                {
                    $arr=array();
                    $arr['id']=$id;
                    $arr['firstname']=$_POST['firstname'];
                    $arr['lastname']=$_POST['lastname'];
                    $arr['dob']=$_POST['dob'];
                    $arr['email']=$_POST['email'];
                    $arr['number']=$_POST['number'];
                    $imagePath=$this->file_upload();
                    $arr['image']=$imagePath;
                    $arr['department']=$_POST['department'];
                    $arr['age']=$_POST['age'];
                    $arr['blood_group']=$_POST['blood_group'];
                    $arr['gender']=$_POST['gender'];
                    $arr['passedout_year']=$_POST['passedout_year'];
                    $arr['location']=$_POST['location'];
                    $rows=$this->Obj->updateForm($arr);
                    $this->studentList();
                }
            }
            else
            {
                $this->redirect_login();
            }
        }

        function deleteStudent()
        {
            if(isset($_SESSION["Name"]))
            {
                $id=$_GET['id'];
                $this->Obj->deleteStudent($id);
                $this->studentList();
            }
            else
            {
                $this->redirect_login();
            }
        }

        function viewStudent()
        {
            if(isset($_SESSION["Name"]))
            {
                $id=$_GET['id'];
                $data=$this->Obj->getStudentDetails($id);
                if(file_exists("./view/studentView.php"))
                {
                    include_once "./view/studentView.php";
                }
            }
            else
            {
                $this->redirect_login();
            }
        }

        function login()
        {
            if(isset($_SESSION["Name"]))
            {
                header("Location: index.php?mod=student&view=studentList");
            }
            else
            {
                if(isset($_POST['username']) && isset($_POST['password']))
                {
                    $username=$_POST['username'];
                    $givenpassword=$_POST['password'];
                    $dbPassword=$this->Obj->login($username);
                    $row=$dbPassword->fetch(PDO::FETCH_ASSOC);
                    if($givenpassword==$row['password'])
                    {
                        $_SESSION["Name"]=$username;
                        header("Location:index.php?mod=student&view=studentList");
                    }
                    else
                    {
                        header("Location:index.php");
                    }
                } 
                else
                {
                    $this->redirect_login();
                }
            }
        }

        function redirect_login()
        {
            if(file_exists("view/login.php"))
            {
                include_once "view/login.php";
            }
        }

        function file_upload()
        {
            if(isset($_SESSION["Name"]))
            {
                    if ($_FILES["image"]["error"]==0) 
                    {   
                        $uploadDirectory = 'C:/xampp/htdocs/MVC/view/Images';
                        $tmpName = $_FILES["image"]["tmp_name"];
                        $name = $_FILES["image"]["name"];
                        move_uploaded_file($tmpName, "$uploadDirectory/$name");
                        $imagePath = "/MVC/view/Images"."/$name";
                        return $imagePath;
                    }
                    else
                    {
                        $id=$_GET["id"];
                        $oldImagePath=$this->Obj->getOldImage($id);
                        $imagePath=$oldImagePath["image"];
                        return $imagePath;
                    }
            }
        }

        function logout()
        {
            session_destroy();
            header("Location: index.php?mod=student&view=login");
        }

        function __call($name, $arguments)
        {
            isset($_SESSION["Name"]) ? header("Location: index.php?mod=student&view=studentList") : header("Location: index.php?mod=student&view=login");
        }    
    }