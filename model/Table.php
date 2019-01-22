<?php
class TableModel {
	public function insert($table, $fields, $data, $route, $alias, $router = NULL) {
		
		$id = _db()->insert($table)->fields($fields)->values(array($data))->result();

		if ($alias) {
			$route = pzk_properties($route, array('mode' => 'str2arr'));
			$aliasValue = $this->alias($data[$alias]);
				
			if ($router) {
				$router = _loader()->getModel('route/' . $router . 'Router');
				$aliasValue = $router->getAlias($table, $data, $alias, $aliasValue);
			}

			db_set($table, $id, 'alias', $aliasValue);

			$route['id'] = $id; $url = http_build_query($route);
			$user = _session('user');
			_db()->insert('route')
			->fields('`alias`,`url`,`table`,`itemId`,`title`,`permissions`,`userId`')
			->values(array(
			array(
					'alias' => $aliasValue,
					'url' => $url, 'table' => $table, 
					'itemId' => $id, 'title' => $data[$alias], 
					'permissions' => @$data['permissions'], 
					'userId' => pzk_or(@$data['userId'], @$user['id'])
			)))->result();
		}
		return $id;
	}

	public function alias($str) {
		$user = _session('user');
		$str = pzk_replace(array(':' => '-',' ' => '-','_' => '-', '/' => '-', '.' => '', '\\' => '-'), $str);
		$str = khongdauAlias($str);
		return $str;
	}

	public function update($table, $data, $route, $alias, $router = NULL) {
		if ($alias) {
			$route = pzk_properties($route, array('mode' => 'str2arr'));

			$aliasValue = $this->alias($data[$alias]);

			if ($router) {
				$router = _loader()->getModel('route/' . $router . 'Router');
				$aliasValue = $router->getAlias($table, $data, $alias, $aliasValue);
			}

			$data['alias'] = $aliasValue;

			_db()->update('route')
			->set(array('alias' => $aliasValue))
			->where(array(
				'itemId' => $data['id'], 
				'table' => $table
			))->result();
		}

		return _db()->update($table)->set($data)
		->where(array('id' => $data['id']))->result();
	}

	public function delete($table, $id) {
		_db()->delete()->from('route')
		->where(array('itemId' => $id,
				'table' => $table))->result();

		return _db()->delete()->from($table)
		->where(array('id' => $id))->result();
	}

	public function delItems($table, $ids) {
		if (is_array($ids)) {
			_db()->delete()->from('route')
			->where('itemId in (' . implode(',', array_keys($ids)) . ') and `table`=\'' . $table . '\'')
			->result();

			return _db()->delete()->from($table)
			->where('id in (' . implode(',', array_keys($ids)) . ')')
			->result();
		}
	}

	public function getItems($options) {
		return _db()->select($options['fields'])
			->from($options['table'])
			->where(@$options['conditions'])
			->filters(@$options['filters'])
			->groupBy(false)
			->orderBy(pzk_or(@$options['orderBy'], 'createdTime DESC'))
			->limit($options['pageSize'], $options['pageNum'])->result();
	}
	
	public function countItems($options) {
		$rows = _db()->select('count(*) as c')
				->from($options['table'])
				->where(@$options['conditions'])
				->filters(@$options['filters'])
				->groupBy(false)->result();
		if ($rows) {
			return $rows[0]['c'];
		}
		return 0;
	}
}