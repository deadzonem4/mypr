<?php
namespace Zing\Core\CoreBundle\Plugin;

/**
* Data encrypt/decrypt class. Used for safe and secure encryption/decryption of data.
*
* @author Hristo Boyarov <hristo939393@gmail.com>
*
*/

class CryptIT {
/**
 * An extra key used for security purposes.
 * It will be used in all encrypt/decrypt operation.
 * IT IS GOOD THE BE CHANGE ONLY BEFORE YOU ENCRYPT ANY DATA,
 * AFTER THAH CHANGING IT WILL CAUSE THE DECRYPT METHOD TO NOT WORK PROPERLY!
 */
CONST SYSTEM_SECURITY_KEY = 'qbO73EKtYvI5YAapo84IMPJZ9TIEpO0hdynmo8XaGVMM0xDvXOggMpe1W2PlmHV';

/**
 * Array containing configurations for the way how the system will work.
 * They could be changed after the class is initialized and the method cryptConfigure
 * is called.
 * All values set here are used default from the system to work properly.
 */
private $crypt = array(
   'hash' => 'sha256',
   'cipher' => MCRYPT_RIJNDAEL_256,
   'mode' => MCRYPT_MODE_CBC,
   'iv_source' => MCRYPT_DEV_URANDOM,
   'key' => 'rbE5rQQQPkcO3rYj1T5YQfp0Db9gy9HMtmIZT6zhVAMy7NrdLkpJlZbvu3TFObl'
);

public function __construct() {
   if (version_compare(phpversion(), '5.4', '<')) {
       throw new \Exception("You are running lower version of PHP the encrypt/decrypt system will not work properly with default configurations!
                To use the encrypt/decrypt class with default configurations you need PHP version bigger or equal to 5.4.");
    }
}

/**
* Setting values.
* @param array $configure  Values to be set for subsequent use.
*/
public function cryptConfigure($configure = array()) {
 foreach($configure as $conf => $value) {
     if(isset($this->crypt[$conf])) {
         $this->crypt[$conf] = $value;
     }
 }
}

/**
* Encrypt data with mcrypt.
* @param string $data    Data to be encrypted.
* @param string $key     Key specified for security purposes.
*                        If it's left blank it will get the default key
*                        set in $crypt array for encrypting data.
* @return                Encrypted data.
*/

public function encrypt($data, $key = false){
  if($key != false){$this->cryptConfigure(array('key' => $key));}

    $iv = mcrypt_create_iv(mcrypt_get_iv_size($this->crypt['cipher'], $this->crypt['mode']), $this->crypt['iv_source']);
            return base64_encode(
                mcrypt_encrypt($this->crypt['cipher'],
                $this->_cryptKey(),
                $data,
                $this->crypt['mode'],
                $iv)
            )."|".base64_encode($iv);
}

/**
* Decrypt data with mcrypt.
* @param string $data    Data to be decrypted.
* @param string $key     Key specified for security purposes.
*                        If it's left blank it will get the default key
*                        set in $crypt array for decrypting data.
* @return                Decrypted data.
*/
public function decrypt($data, $key = false){
  if($key != false){$this->cryptConfigure(array('key' => $key));}

        $data = array_filter(explode("|", $data));

            return rtrim(
                mcrypt_decrypt(
                        $this->crypt['cipher'],
                        $this->_cryptKey(),
                        base64_decode($data[0]),
                        $this->crypt['mode'],
                        base64_decode($data[1])
                        )
                );

}

public function encryptUrl($data)
{
  return $this->_base64UrlEncode($this->encrypt($data));
}

public function decodeUrl($data)
{
    if(!$this->isValidEncryption($this->_base64UrlDecode($data))) {
        return false;
    }

    return $this->decrypt($this->_base64UrlDecode($data));
}

private function _base64UrlEncode($data) {
    return strtr(base64_encode($data), '+/=', '-_.');
}

private function _base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_.', '+/='));
}

public function isValidEncryption($data)
{
  if(count(array_filter(explode("|", $data))) == 2) {
      return true;
  }

  return false;
}

/**
* Hashing the given key for encrypt/decrypt with the given hash algorithm
* and with a constant system key.
* @return                32 string length
*/

private function _cryptKey() {
  return substr(hash_hmac($this->crypt['hash'], $this->crypt['key'], self::SYSTEM_SECURITY_KEY), 0, 32);
}
}

