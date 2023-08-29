<?php
	class Redirect
	{
		public static function getAll(int $linkId)
		{
			$data = DB::table('redirects')->where('link_id', '=', $linkId)->orderBy('redirects.redirected_at DESC')->get();

			return $data;
		}

		public static function add(int $linkId): void
		{
			DB::table('redirects')->create(['link_id' => $linkId]);
		}
	}
