<?php
	class User
	{
		public static function get(string $email)
		{
			$data = DB::table('users')->where('email', '=', $email)->get()[0];

			return $data;
		}
		public static function getById(int $id)
		{
			$data = DB::table('users')->getById($id);

			return $data;
		}

		public static function create(string $username, string $email, string $password)
		{
			$result = DB::table('users')->create([
				'username' => $username,
				'email' => $email,
				'password' => $password,
			]);

			return $result;
		}

		public static function userExists(string $username, string $email)
		{
			if(DB::table('users')->where('username', '=', $username)->get()[0]) {
				return 'username';
			} elseif(DB::table('users')->where('email', '=', $email)->get()[0]) {
				return 'email';
			}

			return false;
		}
	}
