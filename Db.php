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
     * @param  string $table
     * @param  array $colArray
     * @param  array $valArray
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
     * Get summary of Questions in DB
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array
     */
    public function getSummary()
    {
        $sql = "SELECT exam_type, name, complexity, count(*) exam_count from questions q
            join subjects s on q.subject_id = s.id
            group by complexity, name, exam_type";
        $result = $this->conn->query($sql);

        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[$row['name']][$row['exam_type']][$row['complexity']] = $row['exam_count'];
            }
        }

        return $data;
    }

    /**
     * Insert question to DB
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  array $post
     *
     * @return boolean
     */
    public function insertQuestion($post)
    {
        $sql = "INSERT INTO questions (
            user_id,
            subject_id,
            exam_type,
            complexity,
            question_type,
            question,
            option_a_type,
            option_a,
            option_b_type,
            option_b,
            option_c_type,
            option_c,
            option_d_type,
            option_d,
            answer,
            comments,
            created_at,
            updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('iissssssssssssssss',
            intval($_SESSION['userId']),
            $post['subject_id'],
            $post['exam_type'],
            $post['complexity'],
            $post['question_type'],
            $post['question'],
            $post['option_a_type'],
            $post['option_a'],
            $post['option_b_type'],
            $post['option_b'],
            $post['option_c_type'],
            $post['option_c'],
            $post['option_d_type'],
            $post['option_d'],
            $post['answer'],
            $post['comments'],
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        );

        if($statement->execute()) {
            $statement->close();
            return true;
        } else {
            die("ERROR: Executing the following SQL command failed: $sql. " . mysqli_error($this->conn));
        }
    }

    /**
     * Insert question to DB
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $columns
     * @param  string $bindParams
     * @param  array $post
     *
     * @return boolean
     */
    public function updateQuestion($columns, $bindParams, $post)
    {
        $sql = "UPDATE questions SET ".$columns." where id = ?";

        $statement = $this->conn->prepare($sql);
        $queryParams[] = $bindParams;
        foreach ($post as $term) {
            $queryParams[] = $term;
        }
        call_user_func_array(array($statement, 'bind_param'), $this->procesBindParams($queryParams));

        if($statement->execute()) {
            $statement->close();
            return true;
        } else {
            die("ERROR: Executing the following SQL command failed: $sql. " . mysqli_error($this->conn));
        }
    }

    /**
     * Process params for inserting into DB
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  array $arr
     *
     * @return array
     */
    private function procesBindParams($arr){
        $refs = array();
        foreach($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }

    /**
     * get question info
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  int $id
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
     * Check login credentials
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $username
     * @param  string $password
     *
     * @return boolean
     */
    public function verifyLogin($username, $password)
    {
        $sql = "SELECT * FROM users where username = ? and password = ?";
        $statement = $this->conn->prepare($sql);
        $statement->bind_param('ss', $username, $password);

        $result = false;
        if($statement->execute()) {
            $query = $statement->get_result();
            if($query->num_rows) {
                $userInfo = $query->fetch_assoc();
                $_SESSION['userId'] = $userInfo['id'];
                $_SESSION['username'] = $userInfo['username'];
                $_SESSION['loggedIn'] = true;
                $result = true;
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

