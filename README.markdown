BabDev Library
===============

The *BabDev Library* is an extension of the Joomla Platform.  Together with the Joomla Platform, the BabDev Library can be used to develop applications
using PHP and can be leveraged by the Joomla CMS to create advanced extensions.


Using the Library
------------
Since the BabDev Library is dependent upon the Joomla Platform, it uses many of the tools built into the Platform to make things as
convenient for downstream users as possible.  All users will need to do is register the library to the Joomla Platform's autoloader
using this code:

    JLoader::registerPrefix('BD', JPATH_PLATFORM . '/babdev');


Requirements
------------

* Joomla Platform 11.4 (included in Joomla CMS 2.5.x)
* PHP 5.3+


Installation
------------

Get the source code from GIT:

    git clone git://github.com/mbabker/BabDev-Library.git

