PHP Simple Router
==================

A stupid, simple router for PHP

changelog
```
* 'finally' statement giving errors [fixed]
```

```php
include 'Router.php';
Router::init();

//Router::init('/basedir');
```

<br />
###Simple Usage
```php
//add stuff

// GET /
Router::add('/','home');
function home($var){ /* Do something */ }

// GET /user
Router::add('/user',function($var){ 
	/* Do something */ 
});

//404
Router::notfound('notfound');
function notfound($vara){ print "Can't find it"; }

//start the thing
Router::start();
```


<br />
###Multiple Method
```php
Router::add('POST GET','/user','user');
function user($var){  }

/*
* Matches:
* GET /user
* POST /user
*/
```


<br />
###Use `_method` Parameter for unsupported browser
```php
Router::add('PUT DELETE POST','/user','doUser');
function doUser($var){  }

/*
* Matches:
* PUT /user
* DELETE /user
* POST /user
* POST /user?_method=delete
* GET /user?_method=post
* and other permutations,
* You get the point..
*/
```


<br />
###Use variables
```php
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
}	
```


<br />
###Wildcard
```php
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
```


<br />
###Wildcard (with limit)
```php
/*
* Matches:
* GET /user/fatima/posts/edit
* GET /user/fatima/otherstuff/somepage/edit
* 
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
}
```


<br />
###Last Matched Route
```php
// GET /user/fatima/somepage
Router::add('/user/:id*','profile');                //this one will be executed
Router::add('/user/:id*/edit','profileSection');


// GET /user/fatima/somepage/something/edit
Router::add('/user/:id*','profile');         
Router::add('/user/:id*/edit','profileSection');    //this one will be executed
```


<br />
Cheers [jujiyangasli.com](http://jujiyangasli.com)
