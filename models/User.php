<?php

class User {
    private $id, $user_name, $first_name, $last_name, $password, $is_admin, $profile_url, $email;

    function __construct($id, $user_name, $first_name, $last_name, $password, $is_admin, $profile_url, $email) {
        $this->id          = $id;
		$this->user_name   = $user_name;
		$this->first_name  = $first_name;
		$this->last_name   = $last_name;
		$this->password    = $password;
		$this->is_admin    = $is_admin;
		$this->profile_url = $profile_url;
		$this->email       = $email;
    }


    /**
     * Returns a user from a sql query
     * @return User the resulting user object
     */
    public static function from_sql(array $res): User {
        return new User(
            (int)$res['id'],
            $res['user_name'],
            $res['first_name'],
            $res['last_name'],
            $res['password'],
            (boolean)$res['is_admin'],
            $res['profile_url'],
            $res['email'],
        );
    }


    /**
     * Returns a user by its id
     * @param int $id_user
     * @return User|null The user if it exists, null otherwise
    */
    public static function get(int $id_user): ?User {
        global $conn;
        $sql = "SELECT * FROM user WHERE id = $id_user LIMIT 1";
        $res = mysqli_fetch_assoc($conn->query( $sql ));
        if($res === null) return null;

        return User::from_sql($res);
    }


    /**
     * Returns all users
     * @return array All the users
    */
    public static function all(): array {
        global $conn;
        $sql   = 'SELECT * FROM user';
        $res   = $conn->query( $sql );

        $users = array();
        foreach ( $res as $row ) $users[] = User::from_sql($row);
        return $users;
    }


    /**
     * Updates the user by changing the properties listed in $submitted_args
     * $editable_args diminishes the range of editable properties
     */
    public function update(array $submitted_args) {
        if(empty($submitted_args)) return;

        global $conn;
        $sql = "UPDATE user SET";
        $editable_args = array("profile_url", "first_name", "last_name", "email", "password");
        foreach ($editable_args as $arg) {
            if(array_key_exists($arg, $submitted_args))
                $sql .= sprintf(
                    " $arg = '%s',",
                    $conn->real_escape_string( $submitted_args[$arg] )
                );
        }
        // Removing ", " before adding the rest of the query
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE id = ".$this->id.";";
        $conn->query($sql);
    }


    /**
     * Returns all the questions liked by the user
     * @return array All the favorite questions
     */
    public function get_favorite_questions(): array {
        return $this->get_questions("favorites", "with-likes");
    }


    public function get_questions(...$options): array {
        global $conn;
        $with_likes = in_array("with-likes", $options);
        $favorites = in_array("favorites", $options);

        $sql = "SELECT q.*";
        if($with_likes)  $sql .= ", count(*) `number_likes`";
        $sql .= " FROM question q\n";
        if($favorites || $with_likes) $sql .= " JOIN likes l ON q.id = l.id_question\n";
        if($favorites) $sql .= " WHERE l.id_user = $this->id\n";
        else           $sql .= " WHERE q.id_user = $this->id\n";
        $sql .= " GROUP BY q.id;";
        $res = $conn->query($sql);

        $questions = array();
        foreach( $res as $row ) $questions[] = Question::from_sql($row);
        return $questions;
    }

    public function get_id() { return $this->id; }

    public function is_admin() { return $this->is_admin; }

    public function has_profile_url(): bool { return !empty($this->get_profile_url()); }

    public function get_profile_url() { return $this->profile_url; }
    public function get_user_name() { return $this->user_name; }
    public function get_password() { return $this->password; }
    public function get_first_name() { return $this->first_name; }
    public function get_last_name() { return $this->last_name; }
    public function get_email() { return $this->email; }

    public function full_name(): string { return ucfirst($this->first_name)." ".ucfirst($this->last_name); }
}