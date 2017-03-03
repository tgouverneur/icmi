<?php
 /**
  * mysqlCM management
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage mysql
  * @category classes
  * @filesource
  */

/**
 * Base class for all object that use mysql
 */
class mysqlObj 
{
  protected $_my = array();
  protected $_myc = array();
  protected $_table = "";
  protected $_datas = array();

   /* additionnal datas */
 
  /**
   *
   */
  public function dataCount() {
    return count($this->_datas);
  }

  /**
   *
   */
  public function dataKeys() {
    return array_keys($this->_datas);
  }

  /**
   *
   */
  public function data($name) {
    if (isset($this->_datas[$name])) {
      return $this->_datas[$name];
    } else {
      return NULL;
    }
  }

  /**
   *
   */
  public function dataSet($name, $value) {
    $this->_datas[$name] = $value;
  }

  /**
   *
   */
  public function updateData() {

    $id = array_search(SQL_INDEX, $this->_my);
    if ($id === FALSE)
      return -1; /* no index in obj */

    $my = mysqlCM::getInstance();

    if ($this->{$this->_myc[$id]} == -1) {

      return -1;
    }
    $ret = 0;
    foreach ($this->dataKeys() as $k) {

      $where = "WHERE ``foreign_id`='".$this->{$this->_myc[$id]}."' AND `foreign_table`='".$this->_table."' AND `name`='".$k."'";
      if ($my->count("data", $where) == 1) {
        /* update */

        $set = "`value`='".$this->_datas[$k]."'";
        if ($my->update("data", $set, $where)) {
          $ret++;
        }
      } else {
        /* insert */
        if ($my->insert("`name`,`value`,`foreign_table`,`foreign_id`", "`".$k."`,`".$this->_datas[$k]."`,`".$this->_table."`,`".$this->{$this->_myc[$id]}."`", "data")) {
          $ret++;
        }
      }
    }
    return $ret;
  }

  /**
   *
   */
  public function fetchData() {
    
    $id = array_search(SQL_INDEX, $this->_my);
    if ($id === FALSE)
      return -1; /* no index in obj */

    if ($this->{$this->_myc[$id]} != -1) {

      $where = "WHERE `foreign_id`='".$this->{$this->_myc[$id]}."' AND ";
      $where .= "`foreign_table`='".$this->_table."'";
    
      $my = mysqlCM::getInstance();
      
      if (($data = $my->select("*", "data", $where)) == FALSE)
        return -1;
      else
      { 
        if ($my->getNR() != 0)
        { 
          foreach ($data[0] as $k => $v) {
            $this->_datas[$k] = $v;
          }
        } else return -1;
      }
    } else {
      return -1;
    }
  }

   /* mysql common functions */

  /**
   * Fetch object's index in the table
   * @return -1 on error
   */
  function fetchId()
  {
    $id = array_search(SQL_INDEX, $this->_my);
    if ($id === FALSE) 
      return -1; /* no index in obj */

    $where = "WHERE ";
    $i=0;
    foreach ($this->_my as $k => $v) {
      if ($v & SQL_WHERE)
      {
        if ($i && $i < count($this->_my)) $where .= " AND ";

        $where .= "`".$k."`='".$this->{$this->_myc[$k]}."'";
        $i++;
      }
    }
    
    $my = mysqlCM::getInstance();
    if (($data = $my->select("`".$id."`", $this->_table, $where)))
    {
      if ($my->getNR() == 1)
      {
        $this->{$this->_myc[$id]} = $data[0][$id];
      }
      else return -1;
    } else return -1;
  }

  /**
   * insert object in database
   * @return -1 on error
   */
  function insert()
  {
    $values = "";
    $names = "";
    $i=0;
    foreach ($this->_my as $k => $v) {

      if ($v == SQL_INDEX) continue; /* skip index */

      if ($i && $i < count($this->_my)) { 
        $names .= ","; $values .= ","; 
      }
      $names .= "`".$k."`";
      $values .= "'".$this->{$this->_myc[$k]}."'";
      $i++;
    }

    $my = mysqlCM::getInstance();
    $r = $my->insert($names, $values, $this->_table);
    $id = array_search(SQL_INDEX, $this->_my);
    $vid = $this->_myc[$id];

    if ($vid !== FALSE) 
      $this->{$vid} = $my->getNR();

    return $r;
  }

  /**
   * Update the object into database
   * @return -1 on error
   */
  function update()
  {
    $id = array_search(SQL_INDEX, $this->_my);
    if ($id === FALSE)
      return -1; /* no index in obj */

    $where = "WHERE `".$id."`='".$this->{$this->_myc[$id]}."'";
    $set = "";
    $i = 0;
    foreach ($this->_my as $k => $v) {

      if ($v == SQL_INDEX) continue; /* skip index */

      if ($i && $i < count($this->_my)) { 
        $set .= ","; 
      }
      $set .= "`".$k."`='".$this->{$this->_myc[$k]}."'";
      $i++;
    }
    $my = mysqlCM::getInstance();
    return $my->update($this->_table, $set, $where);

  }

  /**
   * Does the object exists in database ?
   * @return 0 = no, 1 = yes
   */
  function existsDb()
  {
    $where = " WHERE ";
    $i = 0;
    foreach ($this->_my as $k => $v) {
      
      if ($v == SQL_INDEX) continue; /* skip index */
      if (!($v & SQL_EXIST)) continue; /* skip properties that shouldn't define unicity of object */
      if ($i && $i < count($this->_my)) $where .= " AND ";

      $where .= "`".$k."`='".$this->{$this->_myc[$k]}."'";
      $i++;
    }
    
    $id = array_search(SQL_INDEX, $this->_my);

    if ($id === FALSE)
    {
      $id = array_keys($this->_my); /* if no index, take the first field of the table */
      $id = $id[0];
    } 

    $my = mysqlCM::getInstance();
    if (($data = $my->select("`".$id."`", $this->_table, $where)) == FALSE)
      return 0;
    else {
      if ($my->getNR()) {
        if ($this->{$this->_myc[$id]} != -1 && $data[0][$id] == $this->{$this->_myc[$id]}) { return 1; }
        if ($this->{$this->_myc[$id]} == -1) return 1;
      } else
        return 0;
    }
  }

  /**
   * Has the object changed ?
   * @return 0 = no; 1 = yes
   */
  function isChanged()
  {
    $where = " WHERE ";
    $i = 0;
    
    if (!$this->existsDb()) return 0;

    foreach ($this->_my as $k => $v) {
      
      if ($v == SQL_INDEX) continue; /* skip index */
      if (!($v & SQL_PROPE)) continue;
      if ($i && $i < count($this->_my)) $where .= " AND ";

      $where .= "`".$k."`='".$this->{$this->_myc[$k]}."'";
      $i++;
    }
    
    $id = array_search(SQL_INDEX, $this->_my);

    if ($id !== FALSE) {
      
      if ($this->{$this->_myc[$id]} != -1) $where .= " AND `".$id."`='".$this->{$this->_myc[$id]}."'";
      
      $my = mysqlCM::getInstance();
      if (($data = $my->select("`".$id."`", $this->_table, $where)) == FALSE)
        return 1;
      else {
        if ($my->getNR()) {
          return 0;
        } else
	  return 1;
      }
    }
   
  }

  /**
   * Fetch object with XXX
   * @return -1 on error
   */
  function fetchFromFields($on_fields)
  {
    $i = 0;
    $fields = "";
    foreach ($this->_my as $k => $v) {
      if ($i && $i < count($this->_my)) $fields .= ",";

      $fields .= "`".$k."`";
      $i++;
    }    
     
    $i=0;
    foreach ($on_fields as $field) {
      if ($i) 
        $where .= " AND ";
      else
        $where = "WHERE ";
    
      $where .= "`".$field."`='".$this->{$this->_myc[$field]}."'";
      $i++;
    }

    $my = mysqlCM::getInstance();
    if (($data = $my->select($fields, $this->_table, $where)) == FALSE)
      return -1;
    else
    {
      if ($my->getNR() != 0)
      {
        foreach ($data[0] as $k => $v) {
          if (array_key_exists($k, $this->_myc))
          {
            $this->{$this->_myc[$k]} = $v;
          }
        }
      } else return -1;
    }
  }


  /**
   * Fetch object with XXX
   * @return -1 on error
   */
  function fetchFromField($field)
  {
    $i = 0;
    $fields = "";
    foreach ($this->_my as $k => $v) {
      if ($i && $i < count($this->_my)) $fields .= ",";

      $fields .= "`".$k."`";
      $i++;
    }    

    $where = "WHERE `".$field."`='".$this->{$this->_myc[$field]}."'";

    $my = mysqlCM::getInstance();
    if (($data = $my->select($fields, $this->_table, $where)) == FALSE)
      return -1;
    else
    {
      if ($my->getNR() != 0)
      {
        foreach ($data[0] as $k => $v) {
          if (array_key_exists($k, $this->_myc))
          {
            $this->{$this->_myc[$k]} = $v;
          }
        }
      } else return -1;
    }
  }


  /**
   * Fetch object with INDEX
   * @return -1 on error
   */
  function fetchFromId()
  {
    $i = 0;
    $fields = "";
    foreach ($this->_my as $k => $v) {
      if ($v != SQL_INDEX)
      {
        if ($i && $i < count($this->_my)) $fields .= ",";

        $fields .= "`".$k."`";
        $i++;
      }
    }    
    $id = array_search(SQL_INDEX, $this->_my);
    if ($id !== FALSE && $this->{$this->_myc[$id]} != -1) {

      $where = "WHERE `".$id."`='".$this->{$this->_myc[$id]}."'";

      $my = mysqlCM::getInstance();
      if (($data = $my->select($fields, $this->_table, $where)) == FALSE)
        return -1;
      else
      {
        if ($my->getNR() != 0)
        {
          foreach ($data[0] as $k => $v) {
            if (array_key_exists($k, $this->_myc))
            {
              $this->{$this->_myc[$k]} = $v;
            }
          }
        } else return -1;
      }
    } else return -1;

    return 0;
  }

  /**
   * delete object in db
   * @return -1 on error, 0 on success
   */
  function delete()
  {
    $i = 0;
    $w = "WHERE ";
    foreach ($this->_my as $k => $v) {
      if ($v == SQL_INDEX)
      {
        if ($i && $i < count($this->_my)) $fields .= ",";

        $w .= "`".$k."`='".$this->{$this->_myc[$k]}."'";
        $i++;
      }
    }
    $id = array_search(SQL_INDEX, $this->_my);
    return mysqlCM::getInstance()->delete($this->_table, $w);
  }

}
?>
