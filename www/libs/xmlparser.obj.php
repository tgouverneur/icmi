<?php
 /** 
  * configuration parser (mostly ripped from m0n0wall trunk)
  * license of m0n0wall is below and has been kept as-is.
  * 
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package xmlparse
  * @category Libs
  *
  */
/*
 *	functions to parse/dump configuration files in XML format
 *	part of m0n0wall (http://m0n0.ch/wall)
 *	
 *	Copyright (C) 2003-2006 Manuel Kasper <mk@neon1.net>.
 *	All rights reserved.
 *	
 *	Redistribution and use in source and binary forms, with or without
 *	modification, are permitted provided that the following conditions are met:
 *	
 *	1. Redistributions of source code must retain the above copyright notice,
 *	   this list of conditions and the following disclaimer.
 *	
 *	2. Redistributions in binary form must reproduce the above copyright
 *	   notice, this list of conditions and the following disclaimer in the
 *	   documentation and/or other materials provided with the distribution.
 *	
 *	THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 *	INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 *	AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *	AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 *	OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 *	SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 *	INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 *	CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 *	ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 *	POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Parse an xml config
 */
class xmlParser
{
  private $_listtags = NULL;
  private $depth, $curpath, $cfg, $havedata, $xml_parser;
  public $error = NULL;

  public function __destruct() {
    
  }

 /**
  * Constructor
  * @param $tags, the list of tags to be threated as lists
  */
  public function __construct($tags) { 

    $this->_listtags = explode(" ", $tags);
 }

 /**
  * @return The config array
  */
  public function getCfg() {
   return $this->cfg;
  }

 /**
  * 
  */
  private function startElement ($parser, $name, $attrs)
  {
    array_push ($this->curpath, strtolower ($name));

    $ptr = &$this->cfg;
    foreach ($this->curpath as $path)
    {
      $ptr = &$ptr[$path];
    }

    /* is it an element that belongs to a list? */
    if (in_array (strtolower ($name), $this->_listtags))
    {

	/* is there an array already? */
	if (!is_array ($ptr))
	{
	    /* make an array */
	    $ptr = array ();
	}

	array_push ($this->curpath, count ($ptr));

    }
    else if (isset ($ptr))
    {
	/* multiple entries not allowed for this element, bail out */
	$this->error = sprintf
	     ("XML error: %s at line %d cannot occur more than once\n",
	      $name, xml_get_current_line_number ($parser));
        return; 
    }

    $this->depth++;
    $this->havedata = $this->depth;
  }

 /**
  * 
  */
  private function endElement ($parser, $name)
  {
    if ($this->havedata == $this->depth)
    {
	$ptr = &$this->cfg;
	foreach ($this->curpath as $path)
	{
	  $ptr = &$ptr[$path];
	}
	$ptr = "";
    }

    array_pop ($this->curpath);

    if (in_array (strtolower ($name), $this->_listtags))
      array_pop ($this->curpath);

    $this->depth--;
  }

 /**
  * 
  */
  private function cData ($parser, $data)
  {
    $data = trim ($data, "\t\n\r");

    if ($data != "")
    {
	$ptr = &$this->cfg;
	foreach ($this->curpath as $path)
	{
	  $ptr = &$ptr[$path];
	}

	if (is_string ($ptr))
	{
	    $ptr .= $data;
	}
	else
	{
	  if (trim ($data, " ") != "")
	  {
            $ptr = $data;
	    $this->havedata++;
	  }
	}
      }
  }

/**
 * Parse the xml config of m0n0wall device
 * @param string $data XML data
 * @param string $rootobj Root object of XML tree (e.g. m0n0wall)
 * @return int 0 if successful, -1 otherwise
 */
  public function parse_xml_config ($data, $rootobj)
  {
    $this->cfg = array ();
    $this->curpath = array ();
    $this->depth = 0;
    $this->havedata = 0;
    $this->xml_parser = xml_parser_create ();
    $this->error = NULL;

    xml_set_object($this->xml_parser, $this);
    xml_set_element_handler ($this->xml_parser, "startElement", "endElement");
    xml_set_character_data_handler ($this->xml_parser, "cData");
 
    if (!xml_parse ($this->xml_parser, $data))
    {
	$this->error = sprintf ("XML error: %s at line %d\n",
			    xml_error_string (xml_get_error_code
					      ($this->xml_parser)),
			    xml_get_current_line_number ($this->xml_parser));
	return -1;
    }
    if ($this->error != NULL) {
      /* error detected while parsing... */
      return -1;
    }
    xml_parser_free($this->xml_parser);

    if (!$this->cfg[$rootobj])
    {
	$this->error = "XML error: no ".$rootobj." object found!\n";
	return -1;
    }

    return 0;
  }


 /**
  * 
  */
  private function dump_xml_config_sub ($arr, $indent)
  {

    $xmlconfig = "";

    foreach ($arr as $ent => $val)
    {
      if (is_array ($val))
      {
	  /* is it just a list of multiple values? */
	  if (in_array (strtolower ($ent), $this->_listtags))
	  {
	      foreach ($val as $cval)
	      {
		if (is_array ($cval))
		{
		    $xmlconfig .= str_repeat("\t", $indent);
		    $xmlconfig .= "<$ent>\n";
		    $xmlconfig .= dump_xml_config_sub ($cval, $indent + 1);
		    $xmlconfig .= str_repeat ("\t", $indent);
		    $xmlconfig .= "</$ent>\n";
		}
		else
		{
		    $xmlconfig .= str_repeat ("\t", $indent);
		    if ((is_bool ($cval) && ($cval == true)) ||
			($cval ===  ""))
		      $xmlconfig .= "<$ent/>\n";
		    else if (!is_bool ($cval))
		      $xmlconfig .=
			"<$ent>".htmlspecialchars ($cval)."</$ent>\n";
		}
	      }
	  }
	  else
	  {
	      /* it's an array */
	      $xmlconfig .= str_repeat ("\t", $indent);
	      $xmlconfig .= "<$ent>\n";
	      $xmlconfig .= dump_xml_config_sub ($val, $indent + 1);
	      $xmlconfig .= str_repeat ("\t", $indent);
	      $xmlconfig .= "</$ent>\n";
	  }
      }
      else
      {
	  if ((is_bool ($val) && ($val == true)) || ($val === ""))
	  {
	      $xmlconfig .= str_repeat ("\t", $indent);
	      $xmlconfig .= "<$ent/>\n";
	  }
	  else if (!is_bool ($val))
	  {
	      $xmlconfig .= str_repeat ("\t", $indent);
	      $xmlconfig .= "<$ent>".htmlspecialchars ($val)."</$ent>\n";
	  }
       }
    }

    return $xmlconfig;
  }

 /**
  * 
  */
  public function dump_xml_config ($arr, $rootobj)
  {
    $xmlconfig = "<?xml version=\"1.0\"?>\n";
    $xmlconfig .= "<$rootobj>\n";

    $xmlconfig .= dump_xml_config_sub ($arr, 1);

    $xmlconfig .= "</$rootobj>\n";

    return $xmlconfig;
  }

}

?>
