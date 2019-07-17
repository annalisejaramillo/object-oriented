<?php
namespace Ajaramillo208\ObjectOriented;

use http\Exception\BadQueryStringException;

require_once("autoload.php");


/**
 *
 *this is a an author profile
 *
 * this author profile is data that is stored about a user for a book site. this can be easily extended to
 * emulate more features of this book site
 *
 */



class Author {
	/**
	 * id for this author; this is the primary key
	 * @var Uuid $authorId
	 */
	private $authorId;
	/**
	 * url for this authors avatar
	 * @var string $authorAvatarUrl
	 */
	private $authorAvatarUrl;
	/**
	 * activation token handed out to verify that the auhtor profile is valid and not malicious
	 * @var string $authorActivationToken
	 */
	private $authorActivationToken;
	/**
	 * email address for this author; this is a unique index
	 * @var string $authorEmail
	 */
	private $authorEmail;
	/**
	 * hash for this author
	 * @var string $authorHash
	 */
	private $authorHash;
	/**
	 * username for this author; this is a unique index
	 * @var string $authorUsername
	 */
	private $authorUsername;

	/**
	 * constructor for this author profile
	 * @param string|uuid $newAuthorId id of this author or null if a new author
	 * @param string|null $newAuthorAvatarUrl string containing URL or null if no author avatar URL
	 * @param string|null $newAuthorActivationToken string activation token to safe guard against malicious accounts
	 * @param string $newAuthorEmail new value of email
	 * @param string $newAuthorHash string containing hash for this author
	 * @param string $newAuthorUsername string new value of username
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/

	public function __construct($newAuthorId, $newAuthorAvatarUrl, $newAuthorActivationToken, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setNewAuthorId($newAuthorId);
			$this->setNewAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setNewAuthorActivationToken($newAuthorActivationToken);
			$this->setNewAuthorEmail($newAuthorEmail);
			$this->setNewAuthorHash($newAuthorHash);
			$this->setNewAuthorUsername($newAuthorUsername);
		}
		// determine what exception typw was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 */
	public function getAuthorId(): Uuid {
		return $this->authorId;
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid|string $newAuthorId new value of author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if $newAuthorId is not Uuid or string
	 */
	public function setAuthorId($newAuthorId) : void {
		try {
			$Uuid = self::validateUuid($newAuthorId);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		 // convert and store tweet id
		$this->authorId = $Uuid;
	}

	/**
	 * accessor method for author avatar URL
	 *
	 * @return string
	 */
	public function getAuthorAvatarUrl () {
		return($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author avatar URL or null if no author avatar URL
	 *
	 * @param string $newAuthorAvatarURL new value of author avatar URL
	 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newAuthorAvatarUrl is > 255
	 * @throws \TypeError if $new $newAuthorAvatarUrl is not a string
	 */
	public function setAuthorAvatarUrl(string $authorAvatarUrl) : void {
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify the avatar URL will fit in the database
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("image cloudinary content to large"));
		}
		//store the image cloudinary content
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}
}
?>