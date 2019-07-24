<?php
namespace Ajaramillo208\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *
 *this is a an author profile
 *
 * this author profile is data that is stored about a user for a book site. this can be easily extended to
 * emulate more features of this book site
 *
 */

class Author implements \JsonSerializable {
	use ValidateUuid;
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
	 * activation token handed out to verify that the author profile is valid and not malicious
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
	 * @param ?string|null $newAuthorAvatarUrl string containing URL or null if no author avatar URL
	 * @param ?string|null $newAuthorActivationToken string activation token to safe guard against malicious accounts
	 * @param string $newAuthorEmail new value of email
	 * @param string $newAuthorHash string containing password hash
	 * @param string $newAuthorUsername string new value of username
	 * @throws\InvalidArgumentException if data types are not valid
	 * @throws\RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws\TypeError if data types violate type hints
	 * @throws\Exception if some other exception occurs
	 **/

	public function __construct($newAuthorId, $newAuthorAvatarUrl, $newAuthorActivationToken, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		}
		// determine what exception type was thrown
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
	public function setAuthorId(string $newAuthorId) : void {
		try {
			$Uuid = self::validateUuid($newAuthorId);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		 // convert and store author id
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
	 * @param string $newAuthorAvatarUrl new value of author avatar URL
	 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newAuthorAvatarUrl is > 255 characters
	 * @throws \TypeError if $new $newAuthorAvatarUrl is not a string
	 */
	public function setAuthorAvatarUrl(?string $newAuthorAvatarUrl) : void {

		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify the avatar URL will fit in the database
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("image cloudinary content to large"));
		}
		//store the image cloudinary content
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * accessor method for activation token
	 *
	 * @return string value of activation token
	 */
	public function getAuthorActivationToken(): string {
		return $this->authorActivationToken;
	}

	/**
	 * mutator method for account activation token
	 *
	 *@param string $newAuthorActivationToken
	 *@throw \InvalidArgumentException if the token is not a string or insecure
	 *@throw \RangeException if th activation token is not exactly 32 characters
	 *@throw \TypeError if the activation token is not a string
	 */
	public function setAuthorActivationToken(string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null){
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false){
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure activation token is only 32 characters
		if(strlen($newAuthorActivationToken) === false){
			throw(new\RangeException("user activation token has to be 32 characters"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}
	/**
	 * accessor method for email address
	 *
	 * @return string value of email
	 */
	public function getAuthorEmail(): string {
		return $this->authorEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email address
	 * @throws \InvalidArgumentException if $newAuthorEmail is not a valid email or insecure
	 * @throws \RangeException if newAuthorEmail is > 128 characters
	 */
	public function setAuthorEmail(string $newAuthorEmail) {

		//verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorEmail)===true) {
			throw(new \InvalidArgumentException("not a valid email address"));
		}
		// store the email
		$this->authorEmail = $newAuthorEmail;
	}
	/**
	 * accessor method for author hash
	 *
	 * @return string value of hash
	 */
	public function getAuthorHash(): string {
		return $this->authorHash;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if author hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash): void {
		//enforce the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \RangeException("password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"]!== "argon2i") {
			throw(new \InvalidArgumentException("hash is not a valid hash"));
		}
		//enforce that this hash is exactly 97 characters
		if(strlen($newAuthorHash) !== 97){
			throw(new \RangeException("hash must be 97 characters"));
		}
		//store this hash
		$this->authorHash = $newAuthorHash;
	}
	/**
	 * accessor for author username
	 *
	 * @returm string value of username
	 */
	public function getAuthorUsername(): string {
		return $this->authorUsername;
	}
	/**
	 * @param string $newAuthorUsername
	 * @throws \InvalidArgumentException if $newAuthorUsername is not a string or insecure
	 * @throws \RangeException if $newAuthorUsername is < 32 characters
	 * @throws \TypeError if $newAuthorUsername is not a string
	 *
	 */
	public function setAuthorUsername(string $newAuthorUsername): void {
		//verify the username is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("author username is empty or insecure"));
		}
		//verify the username will fit in the database
		if(strlen($newAuthorUsername) > 32) {
			throw(new\RangeException("author username is too large"));
		}
		$this->authorUsername = $newAuthorUsername;
	}

	/**
	 * inserts this Author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * \PDOexception when mySQL
	 * \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {

		//create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) 
						VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl,
			"authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash,
			"authorUsername" => $this->authorUsername];
		$statement->execute($parameters);

	}
	/**
	 * deletes this Author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related arrows occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function delete(\PDO $pdo) : void {

		//create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	public function update(\PDO $pdo) : void {

		//create query template
		$query = "UPDATE author SET authorId = :authorId, authorAvatarUrl = :authorAvatarUrl, authorActivationToken = :authorActivationUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * gets the Author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 *
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		//sanitize the tweet id before searching
		try {
			$tweetId = self:: validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		//bind the author id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		//grab the tweet from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== FALSE) {
				$author = new Author ($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}

	/**
	 * gets the Author by Avatar Url
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $authorAvatarUrl avatar Url to search for
	 * @return \SplFixedArray SplFixedArray of authors found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	**/
	public static function getAuthorByAvatarUrl(\PDO $pdo, string $authorAvatarUrl) : \splFixedArray {
		// sanitize the description before searching
		$authorAvatarUrl = trim($authorAvatarUrl);
		$authorAvatarUrl = filter_var($authorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($authorAvatarUrl) === true) {
			throw(new \PDOException("Url invalid"));
		}

		//escape any mySQL wild cards
		$authorAvatarUrl = str_replace("_", "\\_", str_replace("%", "\\%", $authorAvatarUrl));



	/**
	 * gets the Author by Activation Token
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $authorActivationToken activation token to search for
	 * @return \SplFixedArray SplFixedArray of authors found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();

		return($fields);
	}
}
?>