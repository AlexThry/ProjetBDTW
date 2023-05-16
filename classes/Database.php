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
		 * @param $email
		 * @param $password
		 *
		 * @return bool
		 */
		public static function get_questions() {
			global $conn;
			$sql = 'SELECT * FROM question';
			$res = mysqli_query( $conn, $sql );
			$questions = array();
			foreach( $res as $row ) {
				$question = array(
					'id' => $row['id'],
					'title' => $row['title'],
					'content' => $row['content'],
					'creation_date' => $row['creation_date'],
					'number_like' => $row['number_like']
				);
				array_push( $questions, $question );
			}
			return $questions;
		}

		/**
		 * @param $email
		 * @param $password
		 *
		 * @return bool
		 */
		public static function get_question_by_id( $id ) {
			global $conn;
			$sql = 'SELECT * FROM question WHERE id = ' . $id;
			$res = mysqli_query( $conn, $sql );
			$question = array();
			foreach( $res as $row ) {
				$question = array(
					'id' => $row['id'],
					'title' => $row['title'],
					'content' => $row['content'],
					'creation_date' => $row['creation_date'],
					'number_like' => $row['number_like']
				);
			}
			return $question;
		}

		/**
		 * @param $email
		 * @param $password
		 *
		 * @return bool
		 */
		public static function get_user_by_id( $id ) {
			global $conn;
			$sql = 'SELECT * FROM user WHERE id = ' . $id;
			$res = mysqli_query( $conn, $sql );
			$user = array();
			foreach( $res as $row ) {
				$user = array(
					'id' => $row['id'],
					'user_name' => $row['user_name'],
					'first_name' => $row['first_name'],
					'last_name' => $row['last_name'],
					'is_admin' => $row['is_admin']
				);
			}
			return $user;
		}

		
	}
}