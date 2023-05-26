<?php

const DB_USER_NAME = 'root';
const DB_PASSWORD  = '';

if ( ! class_exists( 'Database' ) ) {
	/**
	 * Database class
	 */
	final class Database {


		public static function setup() {
			self::connect_db();
		}

		public static function connect_db() {
			global $conn;

			$conn = new mysqli( 'localhost', DB_USER_NAME, DB_PASSWORD );

			if ( ! $conn ) {
				echo 'Erreur de connexion à la bdd';
			}

			$conn->query( 'USE info633' );
			$conn->query( 'SET NAMES utf8' );
		}

		/**
		 * Returns a user by its id
		 *
		 * @param int $id_user
		 * @return array|null The user if it exists, null otherwise
		 */
		public static function get_user( int $id_user ) {
			global $conn;
			$sql = "SELECT * FROM user WHERE id = $id_user LIMIT 1";
			$res = mysqli_fetch_assoc($conn->query( $sql ));
			if($res === null) return null;

			$user = array(
				'id'         => (int)$res['id'],
				'user_name'  => $res['user_name'],
				'first_name' => $res['first_name'],
				'last_name'  => $res['last_name'],
				'is_admin'   => (boolean)$res['is_admin'],
				'password' =>$res['password'],
				'email' =>$res['email'],
				'profile_url' =>$res['profile_url']
			);
			return $user;
		}


		/**
		 * Returns all users
		 *
		 * @return array All the users
		 */
		public static function get_users(): array {
			global $conn;
			$sql   = 'SELECT * FROM user';
			$res   = $conn->query( $sql );

			$users = array();
			foreach ( $res as $row ) {
				$users[] = array(
					'id'         => (int)$row['id'],
					'user_name'  => $row['user_name'],
					'first_name' => $row['first_name'],
					'last_name'  => $row['last_name'],
					'is_admin'   => (boolean)$row['is_admin']
				);
			}
			return $users;
		}


		/**
		 * Returns a question by its id
		 *
		 * @param int $id_question The question's id
		 * @return array|null The question if it exists, null otherwise
		 */
		public static function get_question( int $id_question ) {
			global $conn;
			$sql = "SELECT * FROM question WHERE id = $id_question LIMIT 1";
			$res = mysqli_fetch_assoc($conn->query( $sql ));
			if($res === null) return null;

			$question = array(
				'id'            => (int)$res['id'],
				'id_user'		=> (int)$res['id_user'],
				'title'         => $res['title'],
				'content'       => $res['content'],
				'creation_date' => $res['creation_date'],
			);
			return $question;
		}


		/**
		 * Returns all the questions
		 *
		 * @return array All the questions
		 */
		public static function get_questions() {
			global $conn;
			$sql = 'SELECT * FROM question';
			$res = mysqli_query( $conn, $sql );

			$questions = array();
			foreach( $res as $row ) {
				$questions[] = array(
					'id'            => (int)$row['id'],
					'title'         => $row['title'],
					'content'       => $row['content'],
					'creation_date' => $row['creation_date'],
					'number_likes'  => (int)$row['number_likes']
				);
			}
			return $questions;
		}

		/**
		 * Returns all the questions of a user
		 *
		 * @return array All the questions
		 */
		public static function get_user_questions($user_id) {
			global $conn;
			$sql = 'SELECT * FROM question WHERE id_user =' . $user_id;
			$res = mysqli_query( $conn, $sql );

			$questions = array();
			foreach( $res as $row ) {
				$questions[] = array(
					'id'            => (int)$row['id'],
					'title'         => $row['title'],
					'content'       => $row['content'],
					'creation_date' => $row['creation_date'],
					'number_likes'  => (int)$row['number_likes']
				);
			}
			return $questions;
		}

		/**
		 * Returns the questions related to a given question
		 *
		 * /!\ Related questions are not bidirectionnal !
		 * Eg: q1 is related to q2, but not vice-versa
		 *
		 * @param int $id_question The question's id
		 * @return array The related questions
		 */
		public static function get_nearby_questions( $id_question ) {
			global $conn;
			$sql = "SELECT q2.* FROM is_nearby i_n JOIN question q2 ON q2.id = i_n.id_question2 WHERE i_n.id_question = $id_question";
			$res = mysqli_query( $conn, $sql );

			$questions = array();
			foreach( $res as $row ) {
				$questions[] = array(
					'id'            => (int)$row['id'],
					'title'         => $row['title'],
					'content'       => $row['content'],
					'creation_date' => $row['creation_date'],
					'number_likes'  => (int)$row['number_likes']
				);
			}
			return $questions;
		}


		/**
		 * Gets the given user answers
		 *
		 * @param int $id_user The user's id
		 * @return array The user answers
		 */
		public static function get_user_answers( int $id_user ) {
			global $conn;
			$sql = "SELECT * FROM answer WHERE id_user = $id_user";
			$res = mysqli_query( $conn, $sql );
			$answers = array();

			foreach( $res as $row ) {
				$answers[] = array(
					'id'            => (int)$row['id'],
					'content'       => $row['content'],
					'raw_html'      => $row['raw_html'],
					'id_question'   => (int)$row['id_question'],
					'id_user'       => (int)$row['id_user'],
				);
			}
			return $answers;
		}


		/**
		 * Returns all the categories
		 *
		 * @return array All the categories
		 */
		public static function get_categories() {
			global $conn;
			$sql = 'SELECT * FROM category';
			$res = mysqli_query( $conn, $sql );

			$categories = array();
			foreach( $res as $row ) {
				$categories[] = array(
					'id'    => (int)$row['id'],
					'label' => $row['label']
				);
			}
			return $categories;
		}


		/**
		 * Returns the answer of a given question's id
		 *
		 * @param int $id_question The question's id
		 * @return array|null The answer of the question if it exists, null otherwise
		 */
		public static function get_question_answer( int $id_question ) {
			global $conn;
			$sql = "SELECT * FROM answer WHERE id_question = $id_question LIMIT 1";
			$res = mysqli_fetch_assoc($conn->query( $sql ));
			if($res === null) return null;

			$answer = array(
				'id'          => (int)$res['id'],
				'content'     => $res['content'],
				'raw_html'    => $res['raw_html'],
				'id_question' => (int)$res['id_question'],
				'id_user'     => (int)$res['id_user'],
			);
			return $answer;
		}

		/**
		 * Returns the question of a given id
		 *
		 * @param int $id_question The question's id
		 * @return array|null The question if it exists, null otherwise
		 */
		public static function get_categories_by_question_id( $question_id ) {
			global $conn;

			$sql = "SELECT label FROM category WHERE id IN (SELECT id_category FROM has_category WHERE id_question = " . $question_id . ")";
			$categories = array();
			$res = mysqli_query($conn, $sql);
			foreach ($res as $line) {
				$categories[] = array(
					'label' => $line['label']
				);
			}
			return $categories;
		}

		/**
		 * Returns the question of a given id
		 *
		 * @param int $id_question The question's id
		 * @return array|null The question if it exists, null otherwise
		 */
		public static function modify_question( $id_question, $title, $content, $id_categories ) {
			global $conn;

			$sql = "UPDATE question SET title = '$title', content = '$content' WHERE id = $id_question";
			mysqli_query($conn, $sql);

			$sql = "DELETE FROM has_category WHERE id_question = $id_question";
			mysqli_query($conn, $sql);

			if (sizeof($id_categories) == 0) {
				return;
			}

			foreach ($id_categories as $id_category) {
				$sql = "INSERT INTO has_category (id_question, id_category) VALUES ($id_question, $id_category)";
				mysqli_query($conn, $sql);
			}
		}


		public static function get_categories_id_by_question( $id_question ) {
			global $conn;
			$sql = "SELECT id FROM category WHERE id IN (SELECT id_category FROM has_category WHERE id_question = $id_question)";
			$res = mysqli_query($conn, $sql);
			$categories = array();
			foreach ($res as $line) {
				$categories[] = $line['id'];
			}
			return $categories;
		}


		public static function get_likes_number( $id_question ) {
			global $conn;
			$sql = "SELECT COUNT(*) AS number_likes FROM likes WHERE id_question = $id_question";
			$res = mysqli_fetch_assoc($conn->query( $sql ));
			return $res['number_likes'];
		}












		/** INUTILES : ON LES GARDES JUSQU'A LES REMPLACER */
























		/**
		 * Filter books according to the $search parameter.
		 *
		 * @param array  $books Books to filter.
		 * @param string $search Search string.
		 * @return array
		 */
		private static function search_books( $books, $search ): array {
			return array_filter(
				$books,
				function ( $book ) use ( $search ) {
					return strpos( strtolower( $book['title'] ), strtolower( $search ) ) !== false
						|| strpos( strtolower( $book['author'] ), strtolower( $search ) ) !== false
						|| strpos( strtolower( $book['description'] ), strtolower( $search ) ) !== false;
				}
			);
		}


		/**
		 * Query books in the db according to the given parameters.
		 *
		 * @param array $args Arguemnts are :
		 *                - genre : string (a specific genre) (default: null)
		 *                - start : int (default: 0)
		 *                - limit : int (default: null)
		 *                - sort : string (default: 'parution_date'). Possible values are 'title', 'author', 'parution_date', 'genre', 'score'.
		 *                - order : string (default: 'ASC'). Possible values are 'ASC' and 'DESC'.
		 *              All parameters are optionnal.
		 * @return array $books Books matching the query.
		 */
		public static function get_sorted_books( $args ): array {
			global $conn;

			$genre  = isset( $args['genre'] ) && ! empty( $args['genre'] ) ? $args['genre'] : null;
			$start  = isset( $args['start'] ) ? $args['start'] : 0;
			$limit  = isset( $args['limit'] ) ? $args['limit'] : null;
			$sort   = isset( $args['sort'] ) ? $args['sort'] : 'parution_date, score';
			$sort   = $sort == 'genre' ? 'genre.label' : $sort;
			$order  = isset( $args['order'] ) && 'DESC' === $args['order'] ? $args['order'] : 'ASC';
			$search = isset( $args['search'] ) ? $args['search'] : null;

			$sql = 'SELECT book.*, avg(score) "score" FROM book LEFT JOIN review ON review.id_book = book.id';
			if($sort == 'genre.label') $sql .= " LEFT JOIN genre ON genre.id = book.id";

			if (isset($genre)) {
				$sql .= " WHERE book.id in (SELECT id_book FROM has_genre WHERE id_genre in (SELECT id FROM genre WHERE label = '" . $genre . "'))";
			}

			$sql .= ' GROUP BY book.id ';

			$sql .= ' ORDER BY ' . $sort . ' ' . $order . ( isset( $limit ) ? ' LIMIT ' . $limit . ' OFFSET ' . $start : '' ) . ';';

			$res = mysqli_query( $conn, $sql );

			$books = array();
			foreach ( $res as $line ) {
				$book                  = array();
				$book['id']            = $line['id'];
				$book['title']         = $line['title'];
				$book['author']        = $line['author'];
				$book['description']   = $line['description'];
				$book['profile_url']     = $line['profile_url'];
				$book['parution_date'] = $line['parution_date'];
				$book['score']         = $line['score'];
				$books[]               = $book;
			}

			return isset( $search ) ? self::search_books( $books, $search ) : $books;
		}


		/**
		 * Get the best books according to the given parameters.
		 *
		 * @param array $args Arguemnts are :
		 *                - start : int (default: 0)
		 *                - limit : int (default: null)
		 *                - sort : string (default: 'parution_date'). Possible values are 'title', 'author', 'parution_date', 'genre', 'score'.
		 *                - order : string (default: 'ASC'). Possible values are 'ASC' and 'DESC'.
		 *              All parameters are optionnal.
		 * @return array $books Books matching the query.
		 */
		public static function get_book_genre( $genres ) {
			global $conn;

			$book = array();
			foreach ( $genres as $genre ) {
				$sql      = "SELECT * FROM book b INNER JOIN has_genre hg ON b.id = hg.id_book INNER JOIN genre g ON g.id = hg.id_genre WHERE g.label = '$genre'";
				$res      = mysqli_query( $conn, $sql );
				$num_rows = $res->num_rows;
				if ( $num_rows >= 4 && sizeof( $book ) === 0 ) {
					$book = self::get_sorted_books(
						array(
							'genre' => $genre,
							'start' => 0,
							'limit' => 4,
							'sort'  => 'genre',
							'order' => 'ASC',
						)
					);
				} else {
					$book = array_merge(
						$book,
						self::get_sorted_books(
							array(
								'genre' => $genre,
								'start' => 0,
								'limit' => 4 - sizeof( $book ),
								'sort'  => 'genre',
								'order' => 'ASC',
							)
						)
					);
				}
			}

			if ( sizeof( $book ) < 4 ) {
				$sql        = "SELECT label FROM genre WHERE label NOT IN ('" . implode( "','", $genres ) . "')";
				$res        = mysqli_query( $conn, $sql );
				$row        = mysqli_fetch_assoc( $res );
				$otherGenre = $row['label'];
				$book       = array_merge(
					$book,
					self::get_sorted_books(
						array(
							'genre' => $otherGenre,
							'start' => 0,
							'limit' => 4 - sizeof( $book ),
							'sort'  => 'genre',
							'order' => 'ASC',
						)
					)
				);
			}

			return $book;
		}


		/**
		 * Returns the list of books a user wants to read
		 *
		 * @param int $id_user The user's id.
		 * @return array
		 */
		public static function get_user_wishlist( $id_user ): array {
			global $conn;

			$sql = "SELECT b.id, b.title, b.author, b.parution_date, b.image_url, r.score AS score
					FROM book b
					JOIN wants_to_read wr ON wr.id_user = $id_user AND wr.id_book = b.id
					LEFT JOIN review r ON r.id_book = b.id;";

			$res   = $conn->query( $sql );
			$books = array();
			foreach ( $res as $line ) {
				$book                  = array();
				$book['id']            = $line['id'];
				$book['author']        = $line['author'];
				$book['parution_date'] = $line['parution_date'];
				$book['title']         = $line['title'];
				$book['profile_url']     = $line['profile_url'];
				$book['score']         = $line['score'];
				$books[]               = $book;
			}
			return $books;
		}


		/**
		 * Returns whether a user wants to read a book or not
		 * @param int $id_user The user's id.
		 * @param int $book_id The book's id.
		 * @return bool
		 */
		public static function user_wants_to_read( $id_user, $book_id ): bool {
			global $conn;
			$sql = "SELECT id_user FROM wants_to_read WHERE id_user = $id_user AND id_book = $book_id LIMIT 1";
			$result = $conn->query($sql);
			return mysqli_num_rows($result) > 0;
		}


		/**
		 * Returns whether a user has read a book or not
		 * @param int $id_user The user's id.
		 * @param int $book_id The book's id.
		 * @return bool
		 */
		public static function get_review( $id_user, $book_id ) {
			global $conn;

			$sql = "SELECT * FROM review
                WHERE id_user = $id_user
                AND id_book = $book_id";

			$res     = $conn->query( $sql );
			$reviews = array();
			foreach ( $res as $line ) {
				$review                  = array();
				$review['id_user']       = $id_user;
				$review['id_book']       = $book_id;
				$review['content']       = $line['content'];
				$review['score']         = $line['score'];
				$review['parution_date'] = $line['parution_date'];
				$reviews[]               = $review;
			}

			return ( $reviews === null ) ? null : $reviews;
		}


		/**
		 * Update user's informations.
		 *
		 * @param int   $id_user
		 * @param array $args
		 * @return void
		 */
		public static function update_user( $id_user, $args ): void {
			global $conn;

			$user_keys  = array( 'user_name', 'password', 'profile_url', 'first_name', 'last_name', 'email' );
			$sql_values = array();

			foreach ( $user_keys as $user_key ) {
				if ( isset( $args[ $user_key ] ) ) {
					array_push( $sql_values, $user_key . " = '" . $args[ $user_key ] . "'" );
				}
			}

			$sql_set_line = join( ', ', $sql_values );

			$sql = 'UPDATE user SET ' . $sql_set_line . ' WHERE id=' . $id_user . ';';
			$conn->query( $sql );
		}


		public static function create_circle( $title, $description, $admin_id, $image_url = null ): void {
			global $conn;
			if ( $image_url ) {
				$image_url = "'$image_url'";
			} else {
				$image_url = 'NULL';
			}

			$sql = "SELECT * FROM circle WHERE title = '$title';";
			if ( mysqli_query( $conn, $sql )->num_rows > 0 ) {
				throw new Exception( 'Le nom de cercle est déjà utilisé.' );
			}
			$sql = "INSERT INTO circle (title, description, image_url, admin_id) VALUES ('$title', '$description', $image_url, $admin_id)";
			$conn->query( $sql );
		}

		/**
		 * Gets the average score of a book by it's id.
		 *
		 * @param int    $book_id The book's id.
		 * @return float The book's average score.
		 */
		public static function get_book_average($book_id): float {
			global $conn;

			$sql = "SELECT AVG(score) as moyenne FROM review JOIN book ON book.id = review.id_book WHERE id_book = $book_id;";
			$res = $conn->query($sql);
			$moyenne = $res->fetch_assoc()['moyenne'];
			return $moyenne;
		}

		/**
		 * Adds a review.
		 *
		 * @param string      $content The review's comment.
		 * @param int         $id_book The rated book id.
		 * @param int         $id_user The user that rated the book.
		 * @param string      $parution_date The date the review was published.
		 * @param int         $score The score that gave the user.
		 */
		public static function add_review($content, $id_book, $id_user, $parution_date, $score) {
			global $conn;

			$sql = "SELECT * FROM review WHERE id_book = $id_book AND id_user = $id_user AND content = '$content';";
			$res = $conn->query($sql);
			if ($res->num_rows > 0) {
				throw new Exception("Vous avez déjà écrit une critique pour ce livre.");
				return;
			}

			$sql = 'INSERT INTO review (content, id_book, id_user, parution_date, score) VALUES ("' . $content . '", ' . $id_book . ', ' . $id_user . ', "' . $parution_date . '", ' . $score . ');';
			$conn->query($sql);
		}
	}
}

Database::setup();