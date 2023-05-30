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
		public static function get_question( int $id_question, $with_likes = false ) {
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
			if($with_likes) $question['number_likes'] = self::get_number_likes($id_question);
			return $question;
		}


		/**
		 * Returns all the questions
		 *
		 * @param $with_username    If true, also adds the question's user username
		 * @param $with_categories  If true, also adds the question's categories
		 * @param $with_likes       If true, also adds the question's number of likes
		 * @return array All the questions
		 */
		public static function get_questions($with_username = false, $with_categories = false, $with_likes = false) {
			global $conn;
			$sql = 'SELECT * FROM question';
			if($with_username) $sql = 'SELECT q.*, user_name FROM question q JOIN user u ON u.id = id_user';
			$res = mysqli_query( $conn, $sql );

			$questions = array();
			foreach( $res as $row ) {
				$question = array(
					'id'            => (int)$row['id'],
					'id_user'		=> (int)$row['id_user'],
					'title'         => $row['title'],
					'content'       => $row['content'],
					'creation_date' => $row['creation_date'],
				);
				if($with_likes) $question['number_likes'] = self::get_number_likes($row['id']);
				if($with_categories) $question['number_likes'] = self::get_category((int)$row['id']);
				$questions[] = $question;
			}
			return $questions;
		}


		/**
		 * return all the categories linked to the question id
		 *
		 * @param int $id_ The question's id
		 * @return array all the question's categories
		 */
		public static function get_category($id) {
			global $conn;
			$sql = 'SELECT label FROM category JOIN has_category ON id_category = id WHERE id_question = '.$id;
			$res = mysqli_query( $conn, $sql );

			$categories = array();
			foreach( $res as $row ) {
				$categories[] = $row['label'];
			}
			return $categories;
		}
		/**
		 * Returns all the unvalidated questions
		 *
		 * @return array
		 */
		public static function get_unvalidated_questions(){
			global $conn;
			$sql = "SELECT * FROM question WHERE id_validator IS NULL;";
			$res = $conn->query($sql);

			$questions = array();
			foreach( $res as $row ) {
				$questions[] = [
					'id'            => (int)$row['id'],
					'title'         => $row['title'],
					'content'       => $row['content'],
					'creation_date' => $row['creation_date'],
					'number_likes'  => self::get_number_likes($row['id']),
				];
			}
			return $questions;
		}


		/**
		 * Returns all the unanswered questions
		 *
		 * @return array
		 */
		public static function get_unanswered_questions(){
			global $conn;
			$sql = "SELECT * FROM question
				WHERE id NOT IN (
					SELECT id_question
					FROM answer
				);";
			$res = $conn->query($sql);

			$questions = array();
			foreach( $res as $row ) {
				$questions[] = [
					'id'            => (int)$row['id'],
					'title'         => $row['title'],
					'content'       => $row['content'],
					'creation_date' => $row['creation_date'],
					'number_likes'  => self::get_number_likes($row['id']),
				];
			}
			return $questions;
		}

		/**
		 * Returns all the questions liked by a user
		 *
		 * @return array All the questions
		 */
		public static function get_user_questions_favoris($user_id, $with_likes = false) {
			global $conn;
			$sql = 'SELECT * FROM question q JOIN likes l ON q.id = l.id_question WHERE l.id_user =' . $user_id;
			$res = mysqli_query( $conn, $sql );

			$questions = array();
			foreach( $res as $row ) {
				$question = [
					'id'            => (int)$row['id_question'],
					'title'         => $row['title'],
					'content'       => $row['content'],
					'creation_date' => $row['creation_date'],
				];

				// Optionnal keys
				if($with_likes) $question['number_likes'] = self::get_number_likes($question['id']);

				$questions[] = $question;
			}
			return $questions;
		}

		/**
		 * Returns all the questions of a user
		 *
		 * @return array All the questions
		 */
		public static function get_user_questions($user_id, $with_likes = false) {
			global $conn;
			$sql = "SELECT * FROM question WHERE id_user = $user_id";
			$res = mysqli_query( $conn, $sql );

			$questions = array();
			foreach( $res as $row ) {
				$question = [
					'id'            => (int)$row['id'],
					'title'         => $row['title'],
					'content'       => $row['content'],
					'creation_date' => $row['creation_date'],
				];

				// Optionnal keys
				if($with_likes) $question['number_likes'] = self::get_number_likes($question['id']);

				$questions[] = $question;
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
				);
			}
			return $questions;
		}

		/**
		 * Returns the number of likes of a question
		 *
		 * @param int $id_question The question's id
		 * @return int The number of likes
		 */
		public static function get_number_likes( $id_question ) {
			global $conn;
			$sql = "SELECT count(*) as `number_likes` FROM likes WHERE id_question = $id_question;";
			$res = mysqli_query( $conn, $sql );
			return mysqli_fetch_assoc($res)['number_likes'];
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
					'id_question'   => (int)$row['id_question'],
					'id_user'       => (int)$row['id_user'],
				);
			}
			return $answers;
		}


		public static function get_user_by_question_id( int $id_question ) {
			global $conn;
			$sql = "SELECT user.* FROM user JOIN question ON question.id_user = user.id WHERE question.id = $id_question";
			$res = mysqli_query( $conn, $sql );
			$user = mysqli_fetch_assoc( $res );
			return $user;
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
		 * Returns the categories of a question
		 *
		 * @param int $id_question The question's id
		 * @return array The question categories
		 */
		public static function get_question_categories(int $question_id) {
			global $conn;
			$sql = "SELECT * FROM has_category hc JOIN category c ON id_category = c.id WHERE id_question = $question_id";
			$res = mysqli_query( $conn, $sql );

			$categories = [];
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
				'id_question' => (int)$res['id_question'],
				'id_user'     => (int)$res['id_user'],
			);
			return $answer;
		}

		public static function create_category($category){
			global $conn;
			$sql = "INSERT INTO category(label) VALUES ('$category')";
			$conn->query($sql);
		}

		public static function delete_category($category){
			global $conn;
			$sql = "DELETE FROM category WHERE label='$category'";
			$conn->query($sql);
		}

		public static function question_is_validated( $question_id ) {
			global $conn;
			$sql = "SELECT * FROM question WHERE id = $question_id AND id_validator IS NOT NULL";
			return $conn->query($sql)->num_rows > 0;
		}

		public static function question_is_answered( $question_id ) {
			global $conn;
			$sql = "SELECT id FROM answer WHERE id_question = $question_id";
			return $conn->query($sql)->num_rows > 0;
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

		public static function add_question( $id_user, $title, $content, $id_categories ) {
			global $conn;

			$sql = "INSERT INTO question (title, content, id_user) VALUES ('$title', '$content', $id_user)";
			mysqli_query($conn, $sql);

			$id_question = mysqli_insert_id($conn);

			if (sizeof($id_categories) == 0) {
				AlertManager::display_success('La question à été ajoutée avec succès !');

				return;
			}

			foreach ($id_categories as $id_category) {
				$sql = "INSERT INTO has_category (id_question, id_category) VALUES ($id_question, $id_category)";
				mysqli_query($conn, $sql);
			}
			AlertManager::display_success('La question à été ajoutée avec succès !');

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
				AlertManager::display_success('La question à été modifiée avec succès !');
				return;
			}

			foreach ($id_categories as $id_category) {
				$sql = "INSERT INTO has_category (id_question, id_category) VALUES ($id_question, $id_category)";
				mysqli_query($conn, $sql);
			}

			AlertManager::display_success('La question à été modifiée avec succès !');
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


		public static function create_answer( $id_question, $id_admin, $content ){
			global $conn;
			$sql = sprintf(
				"INSERT INTO answer(id_question, id_user, content) VALUES ($id_question, $id_admin, '%s')",
				$conn->real_escape_string( $content )
			);
			$conn->query($sql);
			AlertManager::display_success('La réponse à été ajoutée avec succès !');

		}

		public static function modify_answer( $id_answer, $content ) {
			global $conn;
			$sql = sprintf(
				"UPDATE answer SET content = '%s' WHERE id = $id_answer",
				$conn->real_escape_string( $content )
			);
			$conn->query($sql);
			AlertManager::display_success('La réponse à été modifiée avec succès !');

		}


		public static function delete_answer( $id_answer ) {
			global $conn;
			$sql = "DELETE FROM answer WHERE id = $id_answer";
			$conn->query($sql);
		}

		public static function question_exists( $id_question ) {
			global $conn;
			$sql = "SELECT * FROM question WHERE id = $id_question";
			return $conn->query($sql)->num_rows > 0;
		}

		public static function is_liked($id_question, $id_user) {
			global $conn;
			$sql = "SELECT * FROM likes WHERE id_question = $id_question AND id_user = $id_user";
			return $conn->query($sql)->num_rows > 0;
		}


		public static function set_is_liked($id_question, $id_user, $bool) {
			global $conn;
			if ($bool) {
				$sql = "INSERT INTO likes (id_question, id_user) VALUES ($id_question, $id_user)";
				$conn->query($sql);
			} else {
				if (self::is_liked($id_question, $id_user)) {
					$sql = "DELETE FROM likes WHERE id_question = $id_question AND id_user = $id_user";
					$conn->query($sql);
				}
			}

		}
	}
}

Database::setup();


