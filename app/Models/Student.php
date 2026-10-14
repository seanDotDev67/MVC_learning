<?php
    class Student{
        private PDO $db;

        public function __construct(PDO $db){
            $this->db = $db;
        }

        public function all(): array{
            $sql = 'SELECT id, name, email, course, year_level, created_at
                    FROM students
                    ORDER BY id DESC';
            $stmt = $this->db->query($sql);

            return $stmt->fetchAll();
        }
        public function create(array $data): void{
            $sql = 'INSERT INTO students (name, email, course, year_level)
                    VALUES (:name, :email, :course, :year_level)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':course' => $data['course'],
                ':year_level' => $data['year_level']
            ]);
        }
        public function deleteById($id): bool{
            $sql = "DELETE FROM students WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);
            return $stmt->rowCount() > 0;
        }
        public function findById($id): ?array{
            $sql = 'SELECT id, name, email, course, year_level FROM students WHERE id = :id LIMIT 1';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);
            $student = $stmt->fetch();

            return $student ?: null;
        }
        public function update(int $id, array $data){
            $sql = 'UPDATE students SET name = :name, email = :email, course = :course, year_level = :year_level WHERE id = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':course' => $data['course'],
                ':year_level' => $data['year_level']
            ]);

            return $stmt->rowCount() > 0;
        }
    }

?>