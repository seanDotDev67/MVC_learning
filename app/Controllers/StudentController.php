<?php
    require_once __DIR__ . '/../Models/Student.php';

    class StudentController{

        private function getStudentModel(): Student{
            $pdo = require __DIR__ . '/../../config/database.php';

            return new Student($pdo);
        }

        public function index(): void{
            $studentModel = $this->getStudentModel();
            $students = $studentModel->all();

            $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));

            $success = $_SESSION['success'] ?? '';
            unset($_SESSION['success']);

            require __DIR__ . '/../views/students/Students.php';
        }

        public function create(): void {
            $_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

            // FIX: was $error — the view checks $errors['name'], $errors['email'], etc.
            $errors = $_SESSION['errors'] ?? [];
            $old = $_SESSION['old'] ?? [];

            unset($_SESSION['errors'], $_SESSION['old']);

            // FIX: was views/Students/Create.php — folder is lowercase "students"
            require __DIR__ . '/../views/students/Create.php';
        }

        public function store(): void{
            if(!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
                !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
                    http_response_code(403);
                    exit('Invalid form token. Please go back and try again.');
                }

            $data = [
                'name'       => trim($_POST['name'] ?? ''),
                'email'      => trim($_POST['email'] ?? ''),
                'course'     => trim($_POST['course'] ?? ''),      // FIX: added ?? ''
                'year_level' => trim($_POST['year_level'] ?? ''),  // FIX: added ?? ''
            ];

            $errors = [];

            if($data['name'] === '' || strlen($data['name']) > 100){
                $errors['name'] = 'Name is required and must be at most 100 characters.';
            }

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL) ||
                strlen($data['email']) > 150){
                $errors['email'] = 'Enter a valid Email';
            }

            if($data['course'] === '' || strlen($data['course']) > 100){
                $errors['course'] = 'Course is required and must be at most 100 characters.';
            }

            $yearLevel = filter_var($data['year_level'], FILTER_VALIDATE_INT);
            if($yearLevel === false || $yearLevel < 1 || $yearLevel > 4){
                $errors['year_level'] = 'Choose a valid year level from 1 to 4';
            }else{
                $data['year_level'] = $yearLevel;
            }

            if($errors){
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $data;

                header('Location: /mvc-fast-track/students/create');
                exit;
            }

            try{
                $studentModel = $this->getStudentModel();
                $studentModel->create($data);   // FIX: was $$studentModel

                $_SESSION['success'] = 'Student added successfully!';
                header('Location: /mvc-fast-track/students');
                exit;
            }catch(PDOException $e){
                error_log($e->getMessage());

                // FIX: duplicate-entry SQLSTATE is '23000', not '2300'
                if($e->getCode() === '23000'){
                    $_SESSION['errors'] = [
                        'email' => 'That email address is already registered. Please use another email.'
                    ];
                    $_SESSION['old'] = $data;
                }else{
                    $_SESSION['errors'] = [
                        'general' => 'Something went wrong while saving. Please try again.'
                    ];
                    $_SESSION['old'] = $data;
                }
                header('Location: /mvc-fast-track/students/create');
                exit;
            }
        }
        public function delete(): void{
            if(!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
             !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
                http_response_code(403);
                exit('Invalid form token. Please return to the student list.');
            }
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

            if($id === false || $id === null || $id < 1){
                $_SESSION['errors'] = [
                    'general' => 'Invalid Student ID.'
                ];
                header('Location: /mvc-fast-tract/students');
                exit;
            }
            try{
                $studentModel = $this->getStudentModel();
                if($studentModel->deleteById($id)){
                    $_SESSION['success'] = 'Student deleted successfully.';
                }else{
                    $_SESSION['errors'] = [
                        'general' => 'Student not found or already deleted.'
                    ];
                }
            }catch(PDOException $e){
                error_log($e->getMessage());

                $_SESSION['errors'] = [
                    'general' => 'Unable to delete this student. Please Try again.'
                ];
            }
            header('Location: /mvc-fast-track/students');
            exit;
        }
        public function edit(): void{
            $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
            if($id === false || $id === null || $id < 1){
                http_response_code(404);
                exit('Student not Found');
            }
            $studentModel = $this->getStudentModel();
            $student = $studentModel->findById($id);

            if($student === null){
                http_response_code(404);
                exit('Student not found.');
            }
            $_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));
            $errors = [];
            $old = [];

            require __DIR__ . '/../views/students/Edit.php';
        }
       public function update(): void
       {
            if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
                !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                http_response_code(403);
                exit('Invalid form token. Please return to the edit page and try again.');
            }

            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
            if ($id === false || $id === null || $id < 1) {
                http_response_code(404);
                exit('Student not found.');
            }

            $studentModel = $this->getStudentModel();          // FIX: was $stuedentModel
            $student = $studentModel->findById($id);
            if ($student === null) {
                http_response_code(404);
                exit('Student not found.');
            }

            $data = [
                'name'       => trim($_POST['name'] ?? ''),
                'email'      => trim($_POST['email'] ?? ''),
                'course'     => trim($_POST['course'] ?? ''),
                'year_level' => trim($_POST['year_level'] ?? ''),
            ];

            $errors = [];

            // FIX: strlen($data['name']) > 100 — and $errors, not $error
            if ($data['name'] === '' || strlen($data['name']) > 100) {
                $errors['name'] = 'Name is required and must be at most 100 characters.';
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 150) {
                $errors['email'] = 'Enter a valid Email';
            }

            if ($data['course'] === '' || strlen($data['course']) > 100) {
                $errors['course'] = 'Course is required and must be at most 100 characters.';
            }

            $yearLevel = filter_var($data['year_level'], FILTER_VALIDATE_INT);
            if ($yearLevel === false || $yearLevel < 1 || $yearLevel > 4) {
                $errors['year_level'] = 'Choose a valid year level from 1 to 4';
            } else {
                $data['year_level'] = $yearLevel;
            }

            if ($errors) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old']    = $data;

                // FIX: return to the edit form, not the list
                header('Location: /mvc-fast-track/students/edit?id=' . $id);
                exit;
            }

            try {
                $studentModel->update($id, $data);

                $_SESSION['success'] = 'Student updated successfully.';
                header('Location: /mvc-fast-track/students');
                exit;
            } catch (PDOException $e) {
                error_log($e->getMessage());

                if ($e->getCode() === '23000') {
                    $_SESSION['errors'] = ['email' => 'That email address is already registered.'];
                } else {
                    $_SESSION['errors'] = ['general' => 'Something went wrong while updating. Please try again.'];
                }
                $_SESSION['old'] = $data;
                header('Location: /mvc-fast-track/students/edit?id=' . $id);
                exit;
            }
        }
        
    }
?>