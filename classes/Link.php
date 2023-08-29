<?php
	require_once 'User.php';

	class Link
	{
		public static function getAll(int $userId)
		{
			$links = [];

			$data = DB::table('links')->where('user_id', '=', $userId)->orderBy('links.created_at DESC')->get();

			foreach($data as $link) {
				$link['redirects'] = DB::table('redirects')->where('link_id', '=', $link['id'])->count();

				$links[] = $link;
			}

			return $links;
		}

		public static function shorten(int $userId, string $url, string $shortCode)
		{
			if(self::linkExists($shortCode) == false) {
				$result = DB::table('links')->create([
					'user_id' => $userId,
					'original_url' => $url,
					'short_code' => $shortCode,
				]);
			}

			return $result;
		}

		public static function track(int $userId, string $url, string $shortCode)
		{
			if(self::linkExists($shortCode) == false) {
				$result = DB::table('links')->create([
					'user_id' => $userId,
					'original_url' => $url,
					'short_code' => $shortCode,
				]);
			}

			return $result;
		}
		
		public static function edit(int $userId, int $linkId, string $shortCode)
		{
			$username = User::getById($userId)['username'];

			if(self::linkExists($shortCode, $userId) == false) {
				$result = DB::table('links')->where('id', '=', $linkId)->where('user_id', '=', $userId)->update([
					'owner' => $username,
					'short_code' => $shortCode,
				]);
			}

			return $result;
		}

		public static function delete(int $userId, int $linkId)
		{
			$result = DB::table('links')->where('id', '=', $linkId)->where('user_id', '=', $userId)->delete();

			return $result;
		}

		private function linkExists(string $shortCode, int $userId = NULL)
		{
			$data = DB::table('links')->where('short_code', '=', $shortCode);

			if($userId) {
				$data = $data->where('user_id', '=', $userId);
			}
			
			if($data->get()) {
				return true;
			}
			
			return false;
		}
	}
