<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Http\Response;
use BabDev\Transifex\Http;
use BabDev\Transifex\Languages;

/**
 * Test class for \BabDev\Transifex\Languages.
 *
 * @since  1.0
 */
class LanguagesTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    array  Options for the Languages object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    Http  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    Response  Mock response object.
	 * @since  1.0
	 */
	protected $response;

	/**
	 * @var    Languages  Object under test.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  1.0
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  1.0
	 */
	protected $errorString = '{"message": "Generic Error"}';

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
		$this->options = array();
		$this->client = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->response = $this->getMock('\\BabDev\\Http\\Response');

		$this->object = new Languages($this->options, $this->client);
	}

	/**
	 * Tests the createLanguage method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testCreateLanguage()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('post')
			->with('/project/joomla-platform/languages/')
			->will($this->returnValue($this->response));

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
	 */
	public function testCreateLanguageFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('post')
			->with('/project/joomla-platform/languages/')
			->will($this->returnValue($this->response));

		$this->object->createLanguage('joomla-platform', 'en_GB', array('mbabker'));
	}

	/**
	 * Tests the createLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 */
	public function testDeleteResource()
	{
		$this->response->code = 204;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla-platform/language/en_US/')
			->will($this->returnValue($this->response));

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
	 */
	public function testDeleteLanguageFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla-platform/language/en_US/')
			->will($this->returnValue($this->response));

		$this->object->deleteLanguage('joomla-platform', 'en_US');
	}

	/**
	 * Tests the getCoordinators method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetCoordinators()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/language/en_US/coordinators/')
			->will($this->returnValue($this->response));

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
	 */
	public function testGetCoordinatorsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/language/en_US/coordinators/')
			->will($this->returnValue($this->response));

		$this->object->getCoordinators('joomla-platform', 'en_US');
	}

	/**
	 * Tests the getLanguage method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetLanguage()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/language/en_US/')
			->will($this->returnValue($this->response));

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
	 */
	public function testGetLanguageFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/language/en_US/')
			->will($this->returnValue($this->response));

		$this->object->getLanguage('joomla-platform', 'en_US');
	}

	/**
	 * Tests the getLanguages method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetLanguages()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/languages/')
			->will($this->returnValue($this->response));

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
	 */
	public function testGetLanguagesFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/languages/')
			->will($this->returnValue($this->response));

		$this->object->getLanguages('joomla-platform');
	}

	/**
	 * Tests the getReviewers method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetReviewers()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/language/en_US/reviewers/')
			->will($this->returnValue($this->response));

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
	 */
	public function testGetReviewersFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/language/en_US/reviewers/')
			->will($this->returnValue($this->response));

		$this->object->getReviewers('joomla-platform', 'en_US');
	}

	/**
	 * Tests the getTranslators method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetTranslators()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/language/en_US/translators/')
			->will($this->returnValue($this->response));

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
	 */
	public function testGetTranslatorsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/language/en_US/translators/')
			->will($this->returnValue($this->response));

		$this->object->getTranslators('joomla-platform', 'en_US');
	}

	/**
	 * Tests the updateCoordinators method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testUpdateCoordinators()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/language/en_US/coordinators/')
			->will($this->returnValue($this->response));

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
	 */
	public function testUpdateCoordinatorsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/language/en_US/coordinators/')
			->will($this->returnValue($this->response));

		$this->object->updateCoordinators('joomla-platform', 'en_US', array('mbabker'));
	}

	/**
	 * Tests the updateCoordinators method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 */
	public function testUpdateLanguage()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/language/en_US/')
			->will($this->returnValue($this->response));

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
	 */
	public function testUpdateLanguageFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/language/en_US/')
			->will($this->returnValue($this->response));

		$this->object->updateLanguage('joomla-platform', 'en_US', array('mbabker'));
	}

	/**
	 * Tests the updateLanguage method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 */
	public function testUpdateReviewers()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/language/en_US/reviewers/')
			->will($this->returnValue($this->response));

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
	 */
	public function testUpdateReviewersFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/language/en_US/reviewers/')
			->will($this->returnValue($this->response));

		$this->object->updateReviewers('joomla-platform', 'en_US', array('mbabker'));
	}

	/**
	 * Tests the updateReviewers method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
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
	 */
	public function testUpdateTranslators()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/language/en_US/translators/')
			->will($this->returnValue($this->response));

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
	 */
	public function testUpdateTranslatorsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/language/en_US/translators/')
			->will($this->returnValue($this->response));

		$this->object->updateTranslators('joomla-platform', 'en_US', array('mbabker'));
	}

	/**
	 * Tests the updateTranslators method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 */
	public function testUpdateTranslatorsNoUsers()
	{
		$this->object->updateTranslators('joomla-platform', 'en_US', array());
	}
}
