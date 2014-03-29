<?php
	
include 'Router.php';
Router::init();

Router::add('/','home');
function home($var){ pp($var); }
/*
* Matches:
* GET /
*/

	
Router::add('POST GET','/user','user');
function user($var){ pp($var); }
/*
* Matches:
* GET /user
* POST /user
*/


Router::add('PUT DELETE POST','/user','doUser');
function doUser($var){ pp($var); }
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
Router::add('/user/:id','profile');
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
	pp($var);
}	


/*
* Matches:
* GET /user/fatima/posts
* GET /user/fatima/otherstuff/somepage
*/
Router::add('/user/:id*','profileSection');
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
Router::add('/user/:id*/edit','editSomething');
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
	pp($var);
}


/* 404 Not found function */
Router::finally('notFound');
function notFound($var){ print "Can't find it"; }

//start the thing
Router::start();

function pp($v){
	print '<pre>';
	print_r($v);
	print '</pre>';
}
	
?>