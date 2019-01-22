<?php
class PzkParser {

    public static $rules = array();

    /**
     * 	@description: parse mot dom document
     * 	thanh cac object va init cac object do
     * 	@param $obj doi tuong can parse: co the la domdocument,
     * 	domelement, string, filepath, dom node
     */
    public static function parse($obj) {
        // neu obj la mot dom document
        if (is_a($obj, 'DOMDocument')) {
            return self::parse($obj->documentElement);

            // neu obj la mot dom node
        } else if (is_a($obj, 'DOMElement')) {
            return self::parseNode($obj);

            // neu obj la mot string
        } else if (is_string($obj)) {
            // neu obj la mot duong dan den file
            if (!preg_match('/[\<\>]/', $obj) && $filePath = self::getFilePath($obj . '.php')) {
                return self::parseFile($obj);
            }
            return self::parseDocument($obj);
        } else if (is_array($obj)) {
            return self::parseArray($obj);
        }
    }

    public static function parseFile($obj) {
		$fileName = BASE_DIR . '/public/' . str_replace('/', '_', $obj . '.php');
		
		$filePath = self::getFilePath($obj . '.php');
		if(!file_exists($fileName) || filemtime($fileName) <= filemtime($filePath)) {
			$fileContent = file_get_contents($filePath);
			$fileContent = self::parseTemplate($fileContent, array());
			file_put_contents($fileName, $fileContent);
		}
		
		$source = '';
        ob_start();
        require $fileName;
        $source = ob_get_contents();
        ob_end_clean();
        $source = str_replace('&', '&amp;', $source);
        
		return self::parseDocument($source);
    }

    public static function parseFilePath($filePath) {
        $source = '';
        ob_start();
        require $filePath;
        $source = ob_get_contents();
        ob_end_clean();
        $source = str_replace('&', '&amp;', $source);
        $source = self::parseTemplate($source, array());
		return self::parseDocument($source);
    }

    public static function parseDocument($source) {
        $pageDom = new DOMDocument('1.0', 'utf-8');
        $pageDom->preserveWhiteSpace = false;
        $pageDom->formatOutput = true;
        try {
            $pageDom->loadXML($source);
            return self::parseNode($pageDom->documentElement);
        } catch (Exception $err) {
			echo $source;
            die($err->getMessage());
            return NULL;
        }
    }

    /**
     * @param $obj doi tuong can check file path
     * @param $dirs thu muc de tim kiem doi tuong
     */
    public static function getFilePath($obj, $dirs = '.') {
        if (strpos($obj, '<') !== FALSE) {
            return false;
        }
        foreach (explode('|', $dirs) as $dir) {
            $filePath = BASE_DIR . '/' . $dir . '/' . $obj;
            if (@$_REQUEST['showParse'])
                echo $filePath . '<br />';
            if (file_exists($filePath)) {
                return $filePath;
            }
        }
    }

    /**
     * Parse mot doi tuong tu array
     */
    public static function parseArray($attrs, $parent = false) {
        $name = $attrs['tagName'];
        $package = $attrs['package'];
        require_once 'objects/' . $package . '/' . str_ucfirst($name) . '.php';
        $className = self::getClass($attrs['className']);
        $obj = new $className($attrs);
        pzk_store_element($obj->id, $obj);
        return $obj;
    }

    /**
     * Parse mot doi tuong tu mot node
     * @param $node node can parse
     * @param $parent la parent cua node can parse
     */
    public static function parseNode($node, $parent = false) {
        require_once BASE_DIR . '/lib/string.php';
        if ($node->nodeType == XML_ELEMENT_NODE) {

            $name = $node->nodeName;

            // xet xem co phai html tag binh thuong khong
            if (self::isHtmlTag($name)) {
                $name = 'HtmlTag';
            }

            // xet xem co ten rut gon khong
            $shorts = explode('.', $name);
            if (count($shorts) == 2) {
                $shortRs = pzk_store('shorty_' . $shorts[0]);
                if ($shortRs) {
                    $name = $shortRs . '.' . $shorts[1];
                }
            }

            $names = explode('.', $name);
            $fullNames = array_merge(array(), $names);

            $name = array_pop($names);
            $package = implode('/', $names);

            $className = self::getClass($fullNames);

            if (!class_exists($className)) {
                require_once BASE_DIR . '/objects/' . $package . '/' . str_ucfirst($name) . '.php';
            }
            // lay cac thuoc tinh
            $attrs = array();
            foreach ($node->attributes as $attr) {
                $attrs[$attr->nodeName] = $attr->nodeValue;
            }
            $attrs['tagName'] = $node->nodeName;
            $attrs['package'] = $package;
            $attrs['className'] = $className;
            $attrs['pzkParentId'] = @$parent->id;
            $attrs['fullNames'] = $fullNames;

            // Tao ra obj
            $obj = new $className($attrs);
            pzk_element($obj->id, $obj);

            $obj->init();

            $obj->text = '';

            // duyet qua cac node con
            $childNodes = $node->childNodes;
            foreach ($childNodes as $childNode) {
                // neu la mot node con binh thuong
                if ($childNode->nodeType == XML_ELEMENT_NODE) {
                    $childObj = self::parseNode($childNode, $obj);
                    $obj->append($childObj);

                    // neu la mot text node
                } else if ($childNode->nodeType == XML_TEXT_NODE) {
                    if (trim($childNode->nodeValue))
                        $obj->append(self::parse('<textLabel value="' . html_escape($childNode->nodeValue) . '" />', $obj));

                    // neu la mot cdata node
                } else if ($childNode->nodeType == XML_CDATA_SECTION_NODE) {
                    if (trim($childNode->nodeValue))
                        $obj->append(self::parse('<textLabel value="' . html_escape($childNode->nodeValue) . '" />', $obj));
                }
            }

            $obj->finish();

            return $obj;
        }
    }

    /**
     * lay ten class cua tagName
     */
    public static function getClass($fullNames) {
        $className = 'Pzk';
        foreach ($fullNames as $name) {
            $className .= str_ucfirst($name);
        }
        return $className;
    }

    /**
     * La html tag
     */
    public static function isHtmlTag($tagName) {
        static $tags = array(
            'h1' => true, 'h2' => true, 'h3' => true, 'h4' => true, 'h5' => true, 'h6' => true, 'marquee' => true, 'br' => true,
            'p' => true, 'em' => true, 'strong' => true, 'a' => true, 'style' => true, 'div' => true, 'span' => true, 'label' => true, 'b' => true,
            'script' => true, 'link' => true,
            'select' => true, 'option' => true,
            'ul' => true, 'li' => true,
            'table' => true, 'tr' => true, 'td' => true, 'thead' => true, 'tbody' => true, 'caption' => true,
            'input' => true, 'textarea' => true,
            'img' => true, 'pre' => true, 'header' => true,
            'button' => true
        );
        return @$tags[$tagName];
    }

    /**
     * parse layout
     */
    public static function parseLayout($layout, $data, $return = false, $cache = true) {
        if ($filePath = self::getFilePath($layout . '.php', 'app/' . @pzk_app()->name . '/layouts|default/layouts')) {
            $fileName = BASE_DIR . '/public/' . str_replace('/', '_', str_replace(BASE_DIR . '/', '', $filePath));
        } else {
            die('no layout ' . $layout);
        }
        if (!file_exists($fileName) || filemtime($fileName) < filemtime($filePath)) {
            $content = self::parseTemplateFile($filePath, $data);
            file_put_contents($fileName, $content);
        }
        if ($return) {
            ob_start();
            require $fileName;
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        } else {
            require $fileName;
        }
    }

    /**
     * parse layout cho mot file
     */
    public static function parseTemplateFile($filePath, $data) {
        return self::parseTemplate(file_get_contents($filePath), $data);
    }

    /**
     * parse template, chua require
     * @param $content noi dung template can parse
     * @param $data du lieu can parse
     */
    public static function parseTemplate($content, $data) {
        $o = '\{';
        $c = '\}';
        $content = preg_replace_callback("/{$o}include ([^{$c}]+){$c}/", function($matches){
            $file_content = file_get_contents(BASE_DIR . '/' . pzk_app()->getPageUri($matches[1]).'.php');
            return $file_content;
        }, $content);
        $content = preg_replace('/\{\?/', '<?php', $content);
        $content = preg_replace('/\?\}/', '?>', $content);
        $content = preg_replace('/\{url ([^\}]+)\}/', '<?php echo BASE_REQUEST . \'$1\'; ?>', $content);
		$content = preg_replace('/\{rurl ([^\}]+)\}/', BASE_URL . '$1', $content);
		$content = preg_replace('/\{turl ([^\}]+)\}/', '<?php echo pzk_element("page")->getTemplatePath("$1"); ?>', $content);
        $content = preg_replace('/\{echo ([^\}]+)\}/', '<?php echo @$1?>', $content);

        $content = preg_replace('/\{prop ([^\}]+)\}/', '<?php echo @$data->$1;?>', $content);
		
		preg_match_all('/\{attrs ([^\}]+)\}/', $content, $matches);
		foreach($matches[1] as $index => $attrsText) {
			$attrs = explodetrim(',', $attrsText);
			$attrTexts = array();
			foreach($attrs as $attr) {
				$attrTexts[] = '{attr ' . $attr . '}';
			}
			$attrTexts = implode(' ', $attrTexts);
			$content = str_replace($matches[0][$index], $attrTexts, $content);
		}
		
        $content = preg_replace('/\{attr ([^\}]+)\}/', '<?php $tmp = @$data->$1; if (isset($data->$1) && $data->$1 !== "null" && $data->$1 !== null && $data->$1 !== false) {echo \'$1="\'.$tmp.\'"\'; } ?>', $content);
        $content = preg_replace('/\{style ([^\}]+)\}/', '<?php $tmp = @$data->$1; if (isset($data->$1) && $data->$1 !== "" && $data->$1 !== false) {echo \'$1:\'.$tmp.\';\'; } ?>', $content);
        $content = preg_replace('/\{filter ([^\}]+)\}/', '$data->filter(\'$1\')', $content);
        $content = preg_replace('/\{children ([^\}]+)\}/', '<?php $data->displayChildren(\'$1\');?>', $content);
		$content = preg_replace('/\{event ([^\}]+)\}/', '<?php echo $data->onEvent(\'$1\');?>', $content);
        $idExp = '[\w\d_]+';
        
        $content = preg_replace("/{$o}else{$c}/", '<?php else: ?>', $content);
		$content = preg_replace("/{$o}({$idExp}){$c}/", '<?php echo @$$1;?>', $content);
        $content = preg_replace("/{$o}({$idExp})\.({$idExp}){$c}/", '<?php echo @$$1->$2;?>', $content);
        $content = preg_replace("/{$o}({$idExp})\[({$idExp})\]{$c}/", '<?php echo @$$1[\'$2\'];?>', $content);
		$content = preg_replace("/{$o}region\s+({$idExp})\.({$idExp})\[({$idExp})\]{$c}/", '<?php pzk_element(\'region\')->displayElements(\'$1.$2\', \'$3\');?>', $content);
		$content = preg_replace("/{$o}region\s+({$idExp})\[({$idExp})\]{$c}/", '<?php pzk_element(\'region\')->displayElements(\'$1\', \'$2\');?>', $content);
		$content = preg_replace("/{$o}region\s+({$idExp}){$c}/", '<?php pzk_element(\'region\')->pageElements(\'$1\');?>', $content);
		$content = preg_replace("/{$o}pageappregion\s+({$idExp}){$c}/", '<?php if(get_class($data) == \'PzkIdeAppPage\') $data->displayRegion(\'$1\');?>', $content);
        $content = preg_replace("/{$o}({$idExp})\.({$idExp})\[({$idExp})\]{$c}/", '<?php echo @$$1->$2[\'$3\'];?>', $content);
        $content = preg_replace("/{$o}thumb ([\d]+)x([\d]+) ([^{$c}]+){$c}/", '<img src="<?php echo BASE_URL . createThumb($3, $1, $2);?>" />', $content);
        $content = preg_replace("/{$o}each ([^ ]+) as ([^{$c}]+){$c}/", '<?php foreach ( $1 as $2 ) : ?>', $content);
        $content = preg_replace("/{$o}each ([^ ]+) as ([^= ]+)=>([^{$c}]+){$c}/", '<?php foreach ( $1 as $2 => $3 ) : ?>', $content);
        $content = preg_replace("/{$o}\/each{$c}/", '<?php endforeach; ?>', $content);
		$content = preg_replace("/{$o}if ([^{$c}]+){$c}/", '<?php if ( $1 ) : ?>', $content);
		$content = preg_replace("/{$o}ifvar ({$idExp}){$c}/", '<?php if ( @$$1 ) : ?>', $content);
		$content = preg_replace("/{$o}ifvar ({$idExp})=([^{$c}]+){$c}/", '<?php if ( @$$1=="$2" ) : ?>', $content);
		$content = preg_replace("/{$o}ifprop ({$idExp}){$c}/", '<?php if ( @$data->$1 ) : ?>', $content);
		$content = preg_replace("/{$o}ifpermission ({$idExp})\/({$idExp}){$c}/", '<?php if ( @pzk_element(\'permission\')->check(\'$1\', \'$2\') ) : ?>', $content);
		$content = preg_replace("/{$o}ifprop ({$idExp})=([^{$c}]+){$c}/", '<?php if ( @$data->$1=="$2" ) : ?>', $content);
        $content = preg_replace("/{$o}\/if{$c}/", '<?php endif; ?>', $content);
		
        $content = preg_replace("/{$o}date ([^{$c}]+){$c}/", '<?php echo date(\'G:i:s d/m/Y\', intval($1)) ?>', $content);
        $content = preg_replace("/{$o}utf8 ([^{$c}]+){$c}/", '<?php echo html_entity_decode($1, ENT_COMPAT, "UTF-8"); ?>', $content);
		return $content;
    }

}
