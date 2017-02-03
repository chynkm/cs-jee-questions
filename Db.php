<?php

class Db
{
    private $conn;

    public function __construct()
    {
        // Create connection
        $conn = new mysqli('localhost', 'root', '', 'jee');
        // Check connection
        if ($conn->connect_error) {
            die("MySQL Connection failed: " . $conn->connect_error);
        }

        $this->conn = $conn;
    }

    /**
     * Insert data into Questions table
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return boolean
     */
    public function insert($table, $colArray, $valArray)
    {
        $sql = "INSERT INTO $table $colArray VALUES $valArray";
        if($this->conn->query($sql)){
            return true;
        } else{
            die("ERROR: Executing the following SQL command failed: $sql. " . mysqli_error($this->conn));
        }
    }

    /**
     * get question info
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array
     */
    public function getQuestion($id)
    {
        $sql = "SELECT * FROM questions where id = ?";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('i', $id);

        $result = array();
        if($statement->execute()) {
            $query = $statement->get_result();
            if($query->num_rows) {
                $result = $query->fetch_assoc();
            }
            $statement->free_result();
            $statement->close();
        } else {
            die("ERROR: Executing the following SQL command failed: $sql. " . mysqli_error($this->conn));
        }

        return $result;
    }

    /**
     * Return all subjects
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array
     */
    public function getSubjectsAsList()
    {
        $sql = "SELECT id, name FROM subjects";
        $result = $this->conn->query($sql);

        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[$row['id']] = $row['name'];
            }
        }

        return $data;
    }

    /**
     * Return all questions for generation pdf
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return object|array
     */
    public function getAllQuestions()
    {
        $sql = "SELECT * FROM questions q join subjects s on s.id = q.subject_id";
        $result = $this->conn->query($sql);

        return $result->num_rows ? $result : array();
    }

    /**
     * Paginate data for table
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  int $limit
     * @param  int $offset
     *
     * @return array
     */
    public function paginateQuestionsTable($limit, $offset = 0)
    {
        $query = "SELECT q.id, name, exam_type, complexity, question_type, question, created_at FROM questions q join subjects s on s.id = q.subject_id ORDER BY created_at DESC, q.id ASC LIMIT ? OFFSET ?";
        $statement = $this->conn->prepare($query);
        $statement->bind_param('ii', $limit, $offset);

        $questions = array();
        if($statement->execute()){
            $statement->store_result();
            $statement->bind_result($id, $name, $exam_type, $complexity, $question_type, $question, $created_at);
            while ($statement->fetch()) {
                $questions[] = array(
                    'id' => $id,
                    'name' => $name,
                    'exam_type' => $exam_type,
                    'complexity' => $complexity,
                    'question' => $question_type == 'text' ? substr($question, 0, 40).'...' : 'Image',
                    'created_at' => $created_at,
                );
            }
            $questionCount = $statement->num_rows;
            $statement->free_result();
        } else {
            die("ERROR: Executing the following SQL command failed: $sql. " . mysqli_error($this->conn));
        }

        $statement->close();
        $total = $this->countAllResults('questions');
        return compact('questionCount', 'questions', 'total');
    }

    /**
     * Count total rows for a table
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $table
     *
     * @return int
     */
    private function countAllResults($table)
    {
        $query = "SELECT count(id) FROM ".$table;
        $statement = $this->conn->prepare($query);
        $total = 0;
        if($statement->execute()) {
            $statement->bind_result($count);
            $statement->fetch();
            $total = $count;
        }
        $statement->close();
        return $total;
    }
}

