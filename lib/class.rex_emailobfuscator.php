<?php
	class rex_emailobfuscator {
		
		private static $whitelist = [];
		
		public static function whitelistEmail($email) {
			self::$whitelist[] = $email;
		}
		
		public static function encodeEmailLinks($matches) {
			$mail = '';
			for ($i = 0; $i < strlen($matches[2]); $i++) {
				$mail .= chr(ord(substr($matches[2],$i,1))+1);
			}
			
			if ($matches[1] == '"' || $matches[1] == '') {
				return $matches[1]."javascript:decryptUnicorn('".$mail."')";
			} else {
				return $matches[1]."javascript:decryptUnicorn(\"".$mail."\")";
			}
		}
		
		public static function encodeEmail ($matches) {
			if (($_SERVER['REQUEST_METHOD'] == 'POST' && in_array($matches[0], $_POST)) || in_array($matches[0], self::$whitelist)) {
				return $matches[0];
			}
			return $matches[1].'<span class="unicorn">_at_</span>'.$matches[2];
		}
	}
?>