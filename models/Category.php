<?php
class Category {
    private $id, $label;
    function __construct($id, $label) {
        $this->id            = $id;
        $this->label         = $label;
    }


    /**
     * Returns all categories
     * @return array All the categories
     */
    public static function all(): array {
        global $conn;
        $res = $conn->query('SELECT * FROM category');

        $categories = array();
        foreach( $res as $row ) $categories[] = Category::from_sql($row);
        return $categories;
    }

    public static function add($label) {
        global $conn;
        $sql = sprintf(
            "INSERT INTO category(label) VALUES ('%s')",
            $conn->real_escape_string( $label )
        );
        $conn->query($sql);
    }

    public static function delete($id) {
        global $conn;
        $sql = "DELETE FROM category WHERE id=$id";
        $conn->query($sql);
    }

    /**
     * Returns a category from a sql query
     * @return Category the resulting answer object
     */
    public static function from_sql(array $res): Category {
        return new Category(
            (int)$res['id'],
            $res['label']
        );
    }


    /**
     * Returns a category by its id
     * @param int|null $id
     * @return Category|null The category if it exists, null otherwise
    */
    public static function get(?int $id): ?Category {
        if($id === null) return null;
        global $conn;
        $sql = "SELECT * FROM category WHERE id = $id LIMIT 1";
        $res = mysqli_fetch_assoc($conn->query( $sql ));
        if($res === null) return null;
        return Category::from_sql($res);
    }

    /**
     * Returns the number of questions that the category has
     * @return int The number of questions
     */
    public function nb_questions(): int
    {
        global $conn;
        $sql = "SELECT * FROM has_category hc WHERE id_category = $this->id";
        return $conn->query($sql)->num_rows;
    }
    public function get_id() { return $this->id; }
    public function get_label() { return ucfirst($this->label); }
}