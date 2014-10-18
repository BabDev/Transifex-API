<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Languages;

/**
 * Test class for \BabDev\Transifex\Languages.
 *
 * @since  1.0
 */
class LanguagesTest extends TransifexTestCase
{
	/**
	 * @var    Languages  Object under test.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new Languages($this->options, $this->client);
	}

	/**
	 * Tests the createLanguage method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::createLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateLanguage()
	{
		$this->prepareSuccessTest('post', '/project/joomla-platform/languages/', 201);

		// Additional options
		$options = array(
			'translators' => array('mbabker'),
		    'reviewers'   => array('mbabker'),
		    'list'        => 'test@example.com'
		);

		$this->assertEquals(
			$this->object->createLanguage('joomla-platform', 'en_GB', array('mbabker'), $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the createLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the createLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 * Tests the deleteLanguage method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::deleteLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteResource()
	{
		$this->prepareSuccessTest('delete', '/project/joomla-platform/language/en_US/', 204);

		$this->assertEquals(
			$this->object->deleteLanguage('joomla-platform', 'en_US'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the deleteLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the getCoordinators method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::getCoordinators
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetCoordinators()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/coordinators/');

		$this->assertEquals(
			$this->object->getCoordinators('joomla-platform', 'en_US'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the getLanguage method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::getLanguage
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguage()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/');

		$this->assertEquals(
			$this->object->getLanguage('joomla-platform', 'en_US'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the getLanguages method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::getLanguages
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetLanguages()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/languages/');

		$this->assertEquals(
			$this->object->getLanguages('joomla-platform'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getLanguages method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the getReviewers method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::getReviewers
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetReviewers()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/reviewers/');

		$this->assertEquals(
			$this->object->getReviewers('joomla-platform', 'en_US'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getReviewers method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the getTranslators method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::getTranslators
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetTranslators()
	{
		$this->prepareSuccessTest('get', '/project/joomla-platform/language/en_US/translators/');

		$this->assertEquals(
			$this->object->getTranslators('joomla-platform', 'en_US'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getTranslators method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the updateCoordinators method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::updateCoordinators
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateCoordinators()
	{
		$this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/coordinators/');

		$this->assertEquals(
			$this->object->updateCoordinators('joomla-platform', 'en_US', array('mbabker')),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateCoordinators method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the updateCoordinators method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 * Tests the updateLanguage method
	 *
	 * @return  void
	 *
	 * @since   1.0
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

		$this->assertEquals(
			$this->object->updateLanguage('joomla-platform', 'en_US', array('mbabker'), $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the updateLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 * Tests the updateReviewers method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::updateReviewers
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateReviewers()
	{
		$this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/reviewers/');

		$this->assertEquals(
			$this->object->updateReviewers('joomla-platform', 'en_US', array('mbabker')),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateReviewers method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the updateReviewers method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 * Tests the updateTranslators method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Languages::updateTranslators
	 * @covers  \BabDev\Transifex\Languages::updateTeam
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateTranslators()
	{
		$this->prepareSuccessTest('put', '/project/joomla-platform/language/en_US/translators/');

		$this->assertEquals(
			$this->object->updateTranslators('joomla-platform', 'en_US', array('mbabker')),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateTranslators method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
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
	 * Tests the updateTranslators method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
