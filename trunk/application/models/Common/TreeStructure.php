<?php

class Common_TreeStructure 
{
    public $data    = array();
    public $child   = array(-1 => array());
    public $layer   = array(0 => 0);
    public $parent  = array();
    
    public function construct($value = 'root')
    {
        $this->setNode(0, -1, $value);
    }

    // --------------------------------------------------------------------
    /**
     *
     * 设置节点
     * @access  private
     * @param   int     ($id        节点ID)
     * @param   int     ($parent    节点父ID)
     * @param   array   ($value     节点元素)
     * @return  void
     */
    private function setNode($id, $parent, $value)
    {
        $parent	= $parent ? $parent : 0;
        $this->data[$id]	= $value;
        if (!isset($this->child[$id])) {
            $this->child[$id]   = array();//设置当前节点子节点
        }
        if (isset($this->child[$parent])) {
            $this->child[$parent][] = $id;//判断当前节点的父节点是否创建，已创建加入当前ID，未创建则创建并加入当前ID
        } else {
            $this->child[$parent]   = array($id);
        }
        $this->parent[$id]  = $parent;//设置当前节点父级节点ID
    }

    // --------------------------------------------------------------------
    /**
     *
     * 设置树层次
     * @access  private
     * @param   int     ($root  节点ID)
     * @return  void
     */
    private function setLayer($root = 0)
    {
        foreach ($this->child[$root] as $id) {
            $parentLayer		= isset($this->layer[$this->parent[$id]]) ? $this->layer[$this->parent[$id]] : 0;
        	$this->layer[$id]	= $parentLayer + 1;
            $this->child[$id] && $this->setLayer($id);
        }
    }

    // --------------------------------------------------------------------
    /**
     *
     * 设置指定节点下的所有子节点
     * @access  private
     * @param   array   ($tree      树)
     * @param   int     ($root      节点ID)
     * @param   int     ($except    移除的节点)
     * @return  void
     */   
    private function setLists(&$tree, $root = 0, $except = NULL)
    {
        foreach ($this->child[$root] as $id) {
            if ($id == $except) {
                continue;
            }
            $tree[]	= $id;
            $this->child[$id] && $this->setLists($tree, $id, $except);
        }
    }

    // --------------------------------------------------------------------
    /**
     *
     * 构造树
     * @access  public
     * @param   array   ($nodes         节点数组)
     * @param   string  ($id_field      节点ID)
     * @param   string  ($parent_field  节点父ID)
     * @return  void
     */
    public function setTree($nodes, $idField, $parentField)
    {
    	if(empty($nodes)) {
    		return false;
    	}
    	$this->data     = array();
    	$this->child    = array(-1  => array());
    	$this->layer    = array(0   => 0);
    	$this->parent   = array();
    	foreach ($nodes as $node) {
    		$this->setNode($node[$idField], $node[$parentField], $node);
    	}
    	$this->setLayer();
    }
    
    // --------------------------------------------------------------------
    /**
     *
     * 获取指定节点ID层次
     * @access  public
     * @param   int     ($id    节点ID)
     * @return  int
     */
    public function getLayer($id, $space = false)
    {
        return $space ? str_repeat($space, $this->layer[$id]) : $this->layer[$id];
    }

    // --------------------------------------------------------------------
    /**
     *
     * 获取指定节点ID值
     * @access  public
     * @param   int     ($id    节点ID)
     * @return  array
     */ 
    public function getValue($id)
    {
        return $this->data[$id];
    }
    
    // --------------------------------------------------------------------
    /**
     *
     * 获取指定节点上级ID
     * @access  public
     * @param   int     ($id    节点ID)
     * @return  int
     */ 
    public function getParent($id)
    {
        return $this->parent[$id];
    }

    // --------------------------------------------------------------------
    /**
     *
     * 获取指定节点所有上级ID
     * @access  public
     * @param   int     ($id    节点ID)
     * @return  array
     */ 
    public function getParents($id)
    {
        while ($this->parent[$id] != -1) {
            $id = $parent[$this->layer[$id]] = $this->parent[$id];
        }
        ksort($parent);
        return $parent;
    }

    // --------------------------------------------------------------------
    /**
     *
     * 获取指定节点子ID
     * @access  public
     * @param   int     ($id    节点ID)
     * @return  int
     */ 
    public function getChild($id)
    {
        return $this->child[$id];
    }

    // --------------------------------------------------------------------
    /**
     *
     * 获取指定节点所有子ID
     * @access  public
     * @param   int     ($id    节点ID) 
     * @return  array
     */ 
    public function getChilds($id = 0, $except = NULL)
    {
        $child  = array();
        $this->setLists($child, $id, $except);
        return $child;
    }

    // --------------------------------------------------------------------
    /**
     *
     * 获取combobox 数组组合
     * @access  public
     * @param	array	($items		回传数组标识索引)
     * @param	string	($field		显示字段)
     * @param	int		($root		节点ID)
     * @return  array
     */
	public function getComboboxArray($items, $field, $root = 0)
	{
		$data	= array();
        $childs	= $this->getChild($root);
        if (empty($childs)) {
        	return false;
        }
		foreach ($childs as $child) {
			$values	= $this->getValue($child);
			$data[]	= array($items[0]=>$child, $items[1]=>htmlspecialchars($values[$field]));
		}
		return $data;
	}
    
    // --------------------------------------------------------------------
    /**
     *
     * 获取combobox option数组组合
     * @access  public
     * @param	string	($field		显示字段)
     * @param	int		($root		节点ID)
     * @param   int     ($layer		下拉深度) 
     * @param	int		($except	移除节点ID)
     * @param	string	($space		显示字段前缀符)
     * @return  array
     */ 
    public function getComboboxOptions($field, $root = 0, $layer = 0, $except = NULL, $space = '&nbsp;&nbsp;')
    {
        $data	= array();
        $childs	= $this->getChilds($root, $except);
        foreach ($childs as $id) {
        	if ($id > 0 && ($layer <= 0 || $this->getLayer($id) <= $layer)) {
        		$values		= $this->getValue($id);
        		$data[$id]	= $this->getLayer($id, $space) . htmlspecialchars($values[$field]);
        	}
        }
        return $data;
    }
    
    // --------------------------------------------------------------------
    /**
     * 根据传递ID数组，遍历生成select
     *
     * @access	public
     * @param	stirng	($name			select名称)
     * @param	int		($id			select ID)
     * @param	int		($pid			根ID)
     * @param	string	($field			显示字段)
     * @param	boolean	($validate		是否验证)
     * @param	int		($default		默认选中ID)
     * @return	text/html
     */
	public function getComboboxHtml($name, $id, $pid, $field, $validate = false, $default = -1)
    {
    	$class	= $validate ? 'validate[required]' : '';
    	$childs	= $this->getChild($pid);
    	if (empty($childs)) {
    		return false;
    	}
    	$select	= '<select name="'.$name.'" id="'.$id.'" class="'.$class.'">';
    	$select.= '<option value="">请选择...</option>';
    	foreach ($childs as $child) {
    		$values	= $this->getValue($child);
    		if ($child == $default) {
    			$select.='<option value="'.$child.'" selected="selected">'.htmlspecialchars($values[$field])."</option>";
    		} else {
    			$select.='<option value="'.$child.'">'.htmlspecialchars($values[$field])."</option>";
    		}
    	}
    	return $select.'</select>';
    }
    
}

/* End of file TreeStructure.php */