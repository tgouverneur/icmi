-Initial Release-

 * 02/02/2010 *
 
   - Implemented Jobs and Jobs Logging into database and object libraries.
   - Implemented first job function (monitoring).
   - Monitoring of devices is now working through HTTP/HTTPS reachablility.

 * 01/02/2010 *

   - Integrated new design full compliant with XHTML/CSS
   - Added some AJAX things that gets GUI more userfriendly..
   - Added scheduled jobs to MySQL schema.

 * 27/03/2009 *

   - Rewritten the mysql connection manager to use the PDO function
     to connect to the mysql databse, this will give more perenity to the application;

 * 26/03/2009 *

   - Modified some CLI prerequisites for the updatexml part.   

 * 25/03/2009 *

   - Written test case to load both pfsense and monowall config into array.
   - Fixed the Loader to work with this test case.
   - Modified SQL schema to contain initial datas.
   - Managed to get working monowall 1.2, pfsense 1.2.2, monowall 1.3b15.
   - Modified device object to use the XML loader
   - Reorganized all directory & files structure to allow the creation of a icmi daemon
     together with a collection of CLI tools.
   - Started writting the CLI command "icmi".

 * 24/03/2009 *

   - Reorganized xmlparser.obj.php to be more OO
   - Fixed some bugs with curl.obj.php
   - Added Loader object

 * 17/03/2009 *

   - Implementation of the data modelization design
   - Added xmlParser class
   - Added Curl object
   - Added HTTP singleton

 * 16/03/2009 *

   - Initial import;
   - Work on the mysql driver;
   - Initial DB schema redesign;
