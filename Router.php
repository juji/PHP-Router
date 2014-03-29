<?php
	
	class Router{
		
		public $routes;
		public $base;
		public $notfound;
		

		public function __construct($base=''){
			$this->routes = array();
			$this->base = preg_replace('/\/+/','/','/'. preg_replace('`/$`','',preg_replace('`^/`','',$base)) . '/');
			if($this->base=='/') $this->base = $this->getDir();
		}


		private function getDir(){
			return preg_replace('/\/+/','/',str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', getcwd()) . '/');
		}


		public function finally($c){
			if(!is_callable($c))
			throw new Exception('Router error: Need a callable to respond a route');
			$this->notfound = $c;
		}

		
		public function add($pattern,$callable){
			$num = func_num_args();
			$arg = func_get_args();
			if($num==3){ 
				$arg[1] = preg_replace('`/+$`','',$arg[1]);
				$arg[1] = preg_replace('`^/+`','',$arg[1]);
				$arg[0] = strtolower($arg[0]);

				if( strpos($arg[0], ' ') !== false ){

					$arg[0] = explode(',',str_replace('/\s+/', ' ', $arg[0]));
					
					foreach ($arg[0] as $key => $value)
					$this->routes[] = array($value,$arg[1],$arg[2]);

				}else{

					$this->routes[] = $arg;

				}
			}
			else if($num==2){ 
				$arg[0] = preg_replace('`/+$`','',$arg[0]);
				$arg[0] = preg_replace('`^/+`','',$arg[0]);
				$this->routes[] = array('get',$arg[0],$arg[1]); 
			}
			else throw new Exception('Router error: argument should be 2 or 3');
			
			if(!is_callable($this->routes[sizeof($this->routes)-1][2]))
			throw new Exception('Router error: Need a callable to respond a route');
		}


		private function clean($str){
			if(get_magic_quotes_gpc()) return stripslashes($str);
			return $str;
		}
		

		public function start(){
			
			$method = strtolower($_SERVER['REQUEST_METHOD']);

			if(isset($_GET['_method'])) $method = $this->clean($_GET['_method']);
			if(isset($_POST['_method'])) $method = $this->clean($_POST['_method']);

			$path = preg_replace('`'.preg_quote($this->base).'`','',preg_replace('`\?.*$`','',$_SERVER['REQUEST_URI']));
			$path = preg_replace('`/+$`','',$path);

			$__arr = array();
			$__arr['method'] = $method;
			$__arr['path'] = $path;
			$__arr['base'] = $this->base;
			$__arr['vars'] = array();

			$func = false;
			foreach($this->routes as $k=>$v){
				if($v[0]!=$method) continue;
				
				$r = preg_replace('/\:[^\/\*]+\*/','(.*?)',$v[1]);
				$r = preg_replace('/\:[^\/]+/','([^\/]+)',$r);
				if(!preg_match_all('`^'.$r.'$`',$path,$pat)) continue;

				$__arr['match'] = $v[1];
				$__arr['vars'] = array();
				preg_match_all('/\:([^\/]+)/',$v[1],$var);
				foreach($var[1] as $kk=>$vv){
					$__arr['vars'][preg_replace('/\*/','',$vv)] = $pat[$kk+1][0];
				}

				$func = $v[2];

			}

			if($func) call_user_func($func,$__arr);
			else call_user_func($this->notfound,$__arr);

			return true;
		}
		
	}
	
?>
