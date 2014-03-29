<?php
	
include 'Router.php';
$route = new Router();
$route->add('/','home');
function home($var){  }
/*
* Matches:
* GET /
*/

	
$route->add('POST GET','/user','user');
function user($var){  }
/*
* Matches:
* GET /user
* POST /user
*/


$route->add('PUT DELETE POST','/user','doUser');
function doUser($var){  }
/*
* Matches:
* PUT /user
* DELETE /user
* POST /user
* POST /user?_method=delete
* GET /user?_method=post
* And other permutation... you get the point..
*/

	
/*
* Matches:
* GET /user/fatima
*/
$route->add('/user/:id','profile');
function profile($var){ 
	/*
	*
	* $var = array(
	*   "method" => "get",
	*   "path" => "the/path/no/slashes",
	*	"base" => "/"
	*	"vars" => array( "id" => "fatima" )
	* )
	*
	*/
}	


/*
* Matches:
* GET /user/fatima/posts
* GET /user/fatima/otherstuff/somepage
*/
$route->add('/user/:id*','profileSection');
function profileSection($var){ 
	/*
	*
	* $var = array(
	*   "method" => "get",
	*   "path" => "user/fatima/posts",
	*	"base" => "/"
	*	"vars" => array( "id" => "fatima/posts" )
	* )
	*
	*/
	pp($var);
}	


/*
* Matches:
* GET /user/fatima/posts/edit
* GET /user/fatima/otherstuff/somepage/edit
* 
* NOTE: The last matched Route will be executed.
*/
$route->add('/user/:id*/edit','editSomething');
function editSomething($var) {
/*
	*
	* $var = array(
	*   "method" => "get",
	*   "path" => "user/fatima/otherstuff/somepage/edit",
	*	"base" => "/"
	*	"vars" => array( "id" => "fatima/otherstuff/somepage" )
	* )
	*
	*/		
}


/* 404 Not found function */
$route->finally('notFound');
function notFound($var){ print "Can't find it" }

//start the thing
$route->start();

function pp($v){
	print '<pre>';
	print_r($v);
	print '</pre>';
}
	
?>