<?php
class Answer {
    private $id, $id_user, $content;

    function __construct($id, $id_user, $content) {
        $this->id            = $id;
        $this->id_user       = $id_user;
		$this->content       = $content;
    }

    public static function add($id_question, $id_admin, $content) {
        global $conn;
        $sql = sprintf(
            "INSERT INTO answer(id_question, id_user, content) VALUES ($id_question, $id_admin, '%s')",
            $conn->real_escape_string( $content )
        );
        $conn->query($sql);
    }

    /**
     * Returns a answer from a sql query
     * @return Answer the resulting answer object
     */
    public static function from_sql(array $res): Answer {
        return new Answer(
            (int)$res['id'],
            (int)$res['id_user'],
            $res['content']
        );
    }


    /**
     * Returns an answer by its id
     * @param int|null $id_answer
     * @return Answer|null The answer if it exists, null otherwise
    */
    public static function get(?int $id_answer): ?Answer {
        if($id_answer === null) return null;
        global $conn;
        $sql = "SELECT * FROM answer WHERE id = $id_answer LIMIT 1";
        $res = mysqli_fetch_assoc($conn->query( $sql ));
        if($res === null) return null;
        return Answer::from_sql($res);
    }

    public function update($content) {
        global $conn;
        $sql = sprintf(
            "UPDATE answer SET content = '%s' WHERE id = $this->id",
            $conn->real_escape_string( $content )
        );
        $conn->query($sql);
        $this->content = $content;
    }

    public function get_admin(): User {
        return User::get($this->id_user);
    }
    public function get_id() { return $this->id; }
    public function get_content() { return $this->content; }
}