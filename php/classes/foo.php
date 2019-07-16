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



class Author  {
	/**
	 * id for this author; this is the primary key
	 */
	private $authorId;
	/**
	 * url for this authors avatar
	 */
	private $authorAvatarUrl;
	/**
	 * activation token for this author
	 */
	private $authorActivationToken;
	/**
	 * email address for this author
	 */
	private $authorEmail;
	/**
	 * hash for this author
	 */
	private $authorHash;
	/**
	 * username for this author
	 */
	private $authorUsername;

	/**
	 *accessor method for author id
	 *
	 * @return int value of profile id
	 */
	public function getAuthorId() {

	}

}
?>