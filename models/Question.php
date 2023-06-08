<?php
class Question {
    private $id, $title, $creation_date, $content, $likes, $username, $categories;

    function __construct($id, $title, $creation_date, $content) {
        $this->id            = $id;
		$this->title         = $title;
		$this->creation_date = $creation_date;
		$this->content       = $content;
        $this->likes         = null;
        $this->username      = null;
        $this->categories    = null;
    }

    public static function add( int $id_user, $title, $content, array $id_categories ) {
        global $conn;
        $sql = sprintf(
            "INSERT INTO question (title, content, id_user) VALUES ('%s', '%s', $id_user)",
            $conn->real_escape_string( $title ),
            $conn->real_escape_string( $content )
        );
        $conn->query($sql);

        $id_question = mysqli_insert_id($conn);

        foreach ($id_categories as $id_category) {
            $sql = "INSERT INTO has_category (id_question, id_category) VALUES ($id_question, $id_category)";
            $conn->query($sql);
        }
    }

    /**
     * Returns a question from a sql query
     * @return Question the resulting question object
     */
    public static function from_sql(array $res, bool $with_categories = false): Question {
        $question = new Question(
            (int)$res['id'],
            $res['title'],
            $res['creation_date'],
            $res['content']
        );
        if(key_exists('user_name', $res))    $question->username = $res['user_name'];
        if(key_exists('number_likes', $res)) $question->likes = $res['number_likes'];
        if($with_categories)                     $question->get_categories();
        return $question;
    }


    /**
     * Returns a question by its id
     * @param int|null $id_question
     * @return Question|null The question if it exists, null otherwise
    */
    public static function get(?int $id_question): ?Question {
        if($id_question === null) return null;
        global $conn;
        $sql = "SELECT * FROM question WHERE id = $id_question LIMIT 1";
        $res = mysqli_fetch_assoc($conn->query( $sql ));
        if($res === null) return null;
        return Question::from_sql($res);
    }


    /**
     * Returns all questions
     * @return array All the questions
    */
    public static function all(): array {
        global $conn;
        $sql   = 'SELECT * FROM question';
        $res   = $conn->query( $sql );
        $users = array();
        foreach ( $res as $row ) $users[] = Question::from_sql($row);
        return $users;
    }


    private static function private_search(array $options): array
    {
        global $conn;
        $with_username = in_array("with-username", $options);
        $with_categories = in_array("with-categories", $options) || !empty($category);
        $with_likes = in_array("with-likes", $options);
        $category  = key_exists("category", $options) ? $options['category'] : null;
        $label  = key_exists("label", $options) ? $options['label'] : null;
        $unvalidated = in_array("unvalidated", $options);
        $unanswered = in_array("unanswered", $options);

        $sql = "SELECT q.*";
        if($with_username)   $sql .= ", user_name";
        if($with_likes)      $sql .= ", count(*)";
        $sql .= " FROM question q\n";
        if($with_categories) $sql .= " LEFT JOIN has_category hc ON hc.id_question = q.id\n LEFT JOIN category c ON c.id = hc.id_category\n";
        if($with_likes)      $sql .= " LEFT JOIN likes l ON l.id_question = q.id\n";
        if($with_username)   $sql .= " LEFT JOIN user u ON u.id = q.id_user\n";

        $sql .= " WHERE id_validator IS " .($unvalidated ? "NULL" : "NOT NULL")."\n";

        if(!empty($category))           $sql .= " AND c.label LIKE '$category'\n";
        if(!empty($label))              $sql .= " AND (q.content LIKE '%".strtoupper($label)."%' OR q.title LIKE '%".strtoupper($label)."%')\n";
        if($unanswered)                 $sql .= " AND q.id NOT IN (SELECT id_question FROM answer)\n";
        $sql .= " GROUP BY q.id ORDER BY q.creation_date DESC";

        $res = $conn->query($sql);

        $questions = array();
        foreach( $res as $row ) $questions[] = Question::from_sql($row, $with_categories);

        return $questions;
    }

    public static function search_full($category, $string, ...$options): array
    {
        $options["category"] = $category;
        $options["label"] = $string;
        $options[] = "with-likes";
        $options[] = "with-username";
        $options[] = "with-categories";
        return self::private_search($options);
    }

    public static function search(...$options): array {
        return self::private_search($options);
    }

    /**
     * Returns the questions related to a given question
     *
     * /!\ Related questions are not bidirectionnal !
     * Eg: q1 is related to q2, but not vice-versa
     * @return array The related questions
     */
    public function get_nearby_questions(): array {
        global $conn;
        $sql = "SELECT q.* FROM is_nearby i_n JOIN question q ON q.id = i_n.id_question2 WHERE i_n.id_question1 = $this->id;";
        $res = $conn->query($sql);

        $questions = array();
        foreach( $res as $row ) $questions[] = Question::from_sql($row);
        return $questions;
    }


    public static function exists(int $id) : bool {
        global $conn;
        $sql = "SELECT * FROM question WHERE id = $id";
        return $conn->query($sql)->num_rows > 0;
    }

    public function update( $title, $content, $id_categories ) {

        global $conn;
        $sql = sprintf(
            "UPDATE question SET title = '$title', content = '%s' WHERE id = ".$this->id.";",
            $conn->real_escape_string( $content )
        );
        $conn->query($sql);

        $sql = "DELETE FROM has_category WHERE id_question = ".$this->id.";";
        $conn->query($sql);

        foreach ($id_categories as $id_category) {
            $sql = "INSERT INTO has_category (id_question, id_category) VALUES (".$this->id.", $id_category);";
            $conn->query($sql);
        }
    }


    /**
     * Returns the categories of the question
     * @return array The categories of the question
     */
    public function get_categories(): array
    {
        if($this->categories !== null) return $this->categories;
        global $conn;
        $sql = "SELECT label, id FROM category WHERE id IN (SELECT id_category FROM has_category WHERE id_question = " . $this->id . ")";
        $res = mysqli_query($conn, $sql);

        $categories = array();
        foreach ($res as $row) $categories[] = Category::from_sql($row);
        $this->categories = $categories;
        return $categories;
    }

    /**
     * Returns the categories id of the question
     * @return array The id of each category
     */
    public function get_categories_id(): array {
        global $conn;
        $sql = "SELECT id FROM category WHERE id IN (SELECT id_category FROM has_category WHERE id_question = $this->id)";
        $res = mysqli_query($conn, $sql);
        $ids = array();
        foreach ($res as $row) $ids[] = $row['id'];
        return $ids;
    }

    /**
     * Returns the answer of the question or null
     * @return Answer|null The answer if it exists, null otherwise
     */
    public function get_answer(): ?Answer
    {
        global $conn;
        $sql = "SELECT * FROM answer WHERE id_question = $this->id LIMIT 1";
        $res = mysqli_fetch_assoc($conn->query( $sql ));
        if($res === null) return null;

        return Answer::from_sql($res);
    }
    public function is_answered() : bool {
        global $conn;
        $sql = "SELECT id FROM answer WHERE id_question = ". $this->id;
        return $conn->query($sql)->num_rows > 0;
    }

    public function is_validated() : bool {
        global $conn;
        $sql = "SELECT * FROM question WHERE id = ".$this->id." AND id_validator IS NOT NULL";
        return $conn->query($sql)->num_rows > 0;
    }

    public function is_liked( int $id_user ): bool {
        global $conn;
        $sql = "SELECT * FROM likes WHERE id_question = ".$this->id." AND id_user = $id_user";
        return $conn->query($sql)->num_rows > 0;
    }

    public function toggle_like( int $id_user ) {
        global $conn;
        $sql = self::is_liked(  $id_user ) ?
            "DELETE FROM likes WHERE id_question = ".$this->id." AND id_user = $id_user" :
            "INSERT INTO likes (id_question, id_user) VALUES (".$this->id.", $id_user)";
        $conn->query($sql);
    }

    public function get_id() { return $this->id; }
    public function get_title() { return $this->title; }

    /**
     * Returns the number of likes of the question
     * @return int The number of likes
     */
    public function get_likes(): int
    {
        if($this->likes !== null) return $this->likes;
        global $conn;
        $sql = "SELECT COUNT(*) AS number_likes FROM likes WHERE id_question = ".$this->id;
        $res = mysqli_fetch_assoc($conn->query( $sql ));
        $this->likes = $res['number_likes'];
        return $this->likes;
    }

    public function get_username() {
        if($this->username !== null) return $this->username;
        global $conn;
        $sql = "SELECT user_name FROM question q JOIN user u ON u.id = q.id_user WHERE q.id = ".$this->id.";";
        $res = mysqli_fetch_assoc($conn->query( $sql ));
        $this->username = $res['user_name'];
        return $this->username;
    }

    public function get_creation_date() { return $this->creation_date; }
    public function get_content() { return $this->content; }
}