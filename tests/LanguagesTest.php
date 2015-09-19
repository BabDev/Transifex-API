<?php
/**
 * BabDev Transifex Package
 *
 * @copyright  Copyright (C) 2012-2015 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Languages;

/**
 * Test class for \BabDev\Transifex\Languages.
 */
class LanguagesTest extends TransifexTestCase
{
	/**
	 * Object being tested.
	 *
	 * @var  Languages
	 */
	private $object;

	/**
	 * {@inheritdoc}
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Languages($this->options, $this->client);
	}

	/**
	 * @testdox  createLanguage() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::createLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateLanguage()
	{
		$this->prepareSuccessTest('post', '/project/joomla-platform/languages/?skip_invalid_username', 201);

		// Additional options
		$options = array(
			'translators' => array('mbabker'),
		    'reviewers'   => array('mbabker'),
		    'list'        => 'test@example.com'
		);

		$this->assertSame(
			$this->object->createLanguage('joomla-platform', 'en_GB', array('mbabker'), $options, true),
			$this->response
		);
	}

	/**
	 * @testdox  createLanguage() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::createLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateLanguageFailure()
	{
		$this->prepareFailureTest('post', '/project/joomla-platform/languages/');

		$this->object->createLanguage('joomla-platform', 'en_GB', array('mbabker'));
	}

	/**
	 * @testdox  createLanguage() throws an InvalidArgumentException when no contributors are given
	 *
	 * @expectedException  \InvalidArgumentException
	 *
	 * @covers  \BabDev\Transifex\Languages::createLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateLanguageNoUsers()
	{
		$this->object->createLanguage('joomla-platform', 'en_US', array());
	}

	/**
	 * @testdox  deleteLanguage() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::deleteLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteLanguage()
	{
		$this->prepareSuccessTest('delete', '/project/joomla-platform/language/en_US/', 204);

		$this->assertSame(
			$this->object->deleteLanguage('joomla-platform', 'en_US'),
			$this->response
		);
	}

	/**
	 * @testdox  deleteLanguage() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::deleteLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteLanguageFailure()
	{
		$this->prepareFailureTest('delete', '/project/joomla-platform/language/en_US/');

		$this->object->deleteLanguage('joomla-platform', 'en_US');
	}

	/**
	 * @testdox  getCoordinators() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::getCoordinators
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetCoordinators()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/coordinators/');

		$this->assertSame(
			$this->object->getCoordinators('joomla-platform', 'en_US'),
			$this->response
		);
	}

	/**
	 * @testdox  getCoordinators() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::getCoordinators
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetCoordinatorsFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla-platform/language/en_US/coordinators/');

		$this->object->getCoordinators('joomla-platform', 'en_US');
	}

	/**
	 * @testdox  getLanguage() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::getLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguage()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/');

		$this->assertSame(
			$this->object->getLanguage('joomla-platform', 'en_US'),
			$this->response
		);
	}

	/**
	 * @testdox  getLanguage() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::getLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguageFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla-platform/language/en_US/');

		$this->object->getLanguage('joomla-platform', 'en_US');
	}

	/**
	 * @testdox  getLanguages() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::getLanguages
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguages()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/languages/');

		$this->assertSame(
			$this->object->getLanguages('joomla-platform'),
			$this->response
		);
	}

	/**
	 * @testdox  getLanguages() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::getLanguages
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguagesFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla-platform/languages/');

		$this->object->getLanguages('joomla-platform');
	}

	/**
	 * @testdox  getReviewers() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::getReviewers
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetReviewers()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/reviewers/');

		$this->assertSame(
			$this->object->getReviewers('joomla-platform', 'en_US'),
			$this->response
		);
	}

	/**
	 * @testdox  getReviewers() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::getReviewers
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetReviewersFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla-platform/language/en_US/reviewers/');

		$this->object->getReviewers('joomla-platform', 'en_US');
	}

	/**
	 * @testdox  getTranslators() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::getTranslators
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetTranslators()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/translators/');

		$this->assertSame(
			$this->object->getTranslators('joomla-platform', 'en_US'),
			$this->response
		);
	}

	/**
	 * @testdox  getTranslators() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::getTranslators
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetTranslatorsFailure()
	{
		$this->prepareFailureTest('get', '/project/joomla-platform/language/en_US/translators/');

		$this->object->getTranslators('joomla-platform', 'en_US');
	}

	/**
	 * @testdox  updateCoordinators() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::updateCoordinators
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateCoordinators()
	{
		$this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/coordinators/?skip_invalid_username');

		$this->assertSame(
			$this->object->updateCoordinators('joomla-platform', 'en_US', array('mbabker'), true),
			$this->response
		);
	}

	/**
	 * @testdox  updateCoordinators() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::updateCoordinators
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateCoordinatorsFailure()
	{
		$this->prepareFailureTest('put', '/project/joomla-platform/language/en_US/coordinators/');

		$this->object->updateCoordinators('joomla-platform', 'en_US', array('mbabker'));
	}

	/**
	 * @testdox  updateCoordinators() throws an InvalidArgumentException when no contributors are given
	 *
	 * @expectedException  \InvalidArgumentException
	 *
	 * @covers  \BabDev\Transifex\Languages::updateCoordinators
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateCoordinatorsNoUsers()
	{
		$this->object->updateCoordinators('joomla-platform', 'en_US', array());
	}

	/**
	 * @testdox  updateLanguage() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::updateLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateLanguage()
	{
		$this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/');

		// Additional options
		$options = array(
			'translators' => array('mbabker'),
		    'reviewers'   => array('mbabker'),
		    'list'        => 'test@example.com'
		);

		$this->assertSame(
			$this->object->updateLanguage('joomla-platform', 'en_US', array('mbabker'), $options),
			$this->response
		);
	}

	/**
	 * @testdox  updateLanguage() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::updateLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateLanguageFailure()
	{
		$this->prepareFailureTest('put', '/project/joomla-platform/language/en_US/');

		$this->object->updateLanguage('joomla-platform', 'en_US', array('mbabker'));
	}

	/**
	 * @testdox  updateLanguage() throws an InvalidArgumentException when no contributors are given
	 *
	 * @expectedException  \InvalidArgumentException
	 *
	 * @covers  \BabDev\Transifex\Languages::updateLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateLanguageNoUsers()
	{
		$this->object->updateLanguage('joomla-platform', 'en_US', array());
	}

	/**
	 * @testdox  updateReviewers() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::updateReviewers
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateReviewers()
	{
		$this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/reviewers/?skip_invalid_username');

		$this->assertSame(
			$this->object->updateReviewers('joomla-platform', 'en_US', array('mbabker'), true),
			$this->response
		);
	}

	/**
	 * @testdox  updateReviewers() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::updateReviewers
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateReviewersFailure()
	{
		$this->prepareFailureTest('put', '/project/joomla-platform/language/en_US/reviewers/');

		$this->object->updateReviewers('joomla-platform', 'en_US', array('mbabker'));
	}

	/**
	 * @testdox  updateReviewers() throws an InvalidArgumentException when no contributors are given
	 *
	 * @expectedException  \InvalidArgumentException
	 *
	 * @covers  \BabDev\Transifex\Languages::updateReviewers
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateReviewersNoUsers()
	{
		$this->object->updateReviewers('joomla-platform', 'en_US', array());
	}

	/**
	 * @testdox  updateTranslators() returns a Response object on a successful API connection
	 *
	 * @covers  \BabDev\Transifex\Languages::updateTranslators
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslators()
	{
		$this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/translators/?skip_invalid_username');

		$this->assertSame(
			$this->object->updateTranslators('joomla-platform', 'en_US', array('mbabker'), true),
			$this->response
		);
	}

	/**
	 * @testdox  updateTranslators() throws an UnexpectedResponseException on a failed API connection
	 *
	 * @expectedException  \Joomla\Http\Exception\UnexpectedResponseException
	 *
	 * @covers  \BabDev\Transifex\Languages::updateTranslators
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslatorsFailure()
	{
		$this->prepareFailureTest('put', '/project/joomla-platform/language/en_US/translators/');

		$this->object->updateTranslators('joomla-platform', 'en_US', array('mbabker'));
	}

	/**
	 * @testdox  updateTranslators() throws an InvalidArgumentException when no contributors are given
	 *
	 * @expectedException  \InvalidArgumentException
	 *
	 * @covers  \BabDev\Transifex\Languages::updateTranslators
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslatorsNoUsers()
	{
		$this->object->updateTranslators('joomla-platform', 'en_US', array());
	}
}
