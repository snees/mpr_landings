<?php
$path = trim($_SERVER['DOCUMENT_ROOT']).'/include/phpseclib';

set_include_path(get_include_path() . PATH_SEPARATOR . $path);
include_once(trim($_SERVER['DOCUMENT_ROOT']).'/include/phpseclib/Crypt/RSA.php');

class Rsa {

    private $privatekey = "-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDRXdxqihd82xJ44wdgLt7z0pih75AsZ/aql3A11KDy+l8T1ffAvkhro38ejjuR
xZ4GcaxxSmaVY8Z3zAxoKVZRK5RxaDPVodqdftIvctioYepSDLfaWwcg6RFX6a5Y+8O3UkC30qst
kXMhcy/2fnptGdu6GCqTEyStSsMjqe/HMwIDAQABAoGAcuKoYqXoAZFM75zUnUja+rxjGOkWGefq
iO2Um1VUBECzD3VoABHqN3Z9+Mxfj7v63Npfn8MNy4f2jiIf5MBaJi4vSsvD771nvmGDONp85AV1
8HMC1EEyWl9p9z26GCoXJTtVuNeOxjdszpUU3cCio2wiPzavWcjWalBJiLfUoQECQQDuNKu+9hQz
PqNbyDSjb3EpEyO2HfBqaFo5TlO8hXDHge++35iNxj2Z2Kwiq3UerKn7cJrxNOpf6pUaZeaK95Vz
AkEA4QGvdSue8J0A8pQFgSLsO2AED6XdNi3ZbKjCFtrRBkovNInL9TYMcLZc+93ozBNEnYftpIOO
7elVJdgObWSXQQJBAMv7TKtNXMT5Obip+/GMyBGNc0JL5wmn7MMwAOLqPkaKTXxdSuz1OuEYu2dA
/h1TbIiFyBkP4Dhc0Gv3oPGVzGMCQHYbrV8i25ZPw6yRuGX1z+zG1LrmBL0oygV4fBEFIU1c6XR5
lH8NtPABOcPX0xg0UQMj08FUcVU+8rwfsksHz0ECQQDKzhtAi5NZUq7EdUyzK0baVZIvODoK5wna
HWMxZLMDSETTNnlCsAnwtio/C7Kn658gRRiwjl01ef8JPriF5sLD
-----END RSA PRIVATE KEY-----";


    /**
     * 공개키를 생성한다.
     */
    function publicKeyToHex() {
		
		$rsa = new Crypt_RSA();
	
		$rsa->loadKey($this->privatekey);
		$raw = $rsa->getPublicKey(CRYPT_RSA_PUBLIC_FORMAT_RAW);
		return $raw['n']->toHex();			
	}
	
    /**
     * 복호화
     */
	function decrypt($encrypted) {
		$rsa = new Crypt_RSA();

		$encrypted=pack('H*', $encrypted);

		$rsa->loadKey($this->privatekey);
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
		return $rsa->decrypt($encrypted);		
	}
	
    /*
	if (isset($_POST['encrypted'])) {
		echo '<div class="alert alert-info span10">';
		echo "<h2>Received encrypted data</h2><p style=\"word-wrap: break-word\">".$_POST['encrypted']."</p>";
		echo "<h2>After decreption:</h2><p>".decrypt($privatekey, $_POST['encrypted'])."</p>";
		echo '</div>';
		return;
	}
    */

}

$Rsa = new Rsa();
?>