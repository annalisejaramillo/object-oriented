<?php
namespace Ajaramillo208\ObjectOriented;

require_once("autoload.php");


/**
 *
 *this is a an author profile
 *
 * this author profile is data that is stored about a user for a book site
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
	 * activation token for this author
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
	 * @param string $newAuthorAvatarUrl string containing URL
	 * @param string $newAuthorActivationToken string containing activation token for this author
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
			$this->setAuthorId($newAuthorId);


		}
		}
}
?>