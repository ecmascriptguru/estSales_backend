---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->









# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost:8000/docs/collection.json)


<!-- END_INFO -->

#Authentication
This api will be used in chrome extension in guest mode.
<!-- START_8ae5d428da27b2b014dc767c2f19a813 -->
## User Registration API
This api will be used in chrome extension as registration wizard.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/register" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/register",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/register`


<!-- END_8ae5d428da27b2b014dc767c2f19a813 -->

<!-- START_8c0e48cd8efa861b308fc45872ff0837 -->
## User Login API
This api will be used in chrome extension as Login wizard.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/login" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/login",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/login`


<!-- END_8c0e48cd8efa861b308fc45872ff0837 -->

#Initial Sample : Frontend
 This will be used in front end page and API side. But don&#039;t forget to pass xsrf-token because this will be used in origin.
<!-- START_d6a72841e3e6bb628c4b63c18da6ed04 -->
## Front end API to get Initial sample data.

This api is used to get initial samples stored in database according to selected domain. Also this data will be used in computing coefficients to calculate Unit Sales Estimation based on Best seller rank.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/get_initial_samples" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/get_initial_samples",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/get_initial_samples`


<!-- END_d6a72841e3e6bb628c4b63c18da6ed04 -->

#InitialSample
This api will be used in chrome extension to manage initial data. Middelware : JWT Authentication
<!-- START_2234554103caf8623899f56e9a432795 -->
## Initial Sample Data Browsing API
This api will be called in chrome extension to get initial sample data to be used in coefficients correction.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/iSamples" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/iSamples",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/iSamples`


<!-- END_2234554103caf8623899f56e9a432795 -->

#Item (Products to be tracked.)
This api will be called in chrome extension to manage tracking. Middelware : JWT Authentication
<!-- START_7bd5f07d9ba801bd8687585c8cb91196 -->
## Watched Products Browsing API
This api will be called in chrome extension to get all of products tracked by authorized user.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/items" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/items",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/items`


<!-- END_7bd5f07d9ba801bd8687585c8cb91196 -->

<!-- START_f23222161d4405120d2d6a4c70a300f9 -->
## Watched Product Detail API
This api will be called in chrome extension to get a specific product with change histories being tracked by the authorized user.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/items/get" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/items/get",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/items/get`


<!-- END_f23222161d4405120d2d6a4c70a300f9 -->

<!-- START_d5d6ad70f971a5fda06bb1ecda8be70e -->
## Product watch API
This api will be called in chrome extension to track a new product by the authorized user.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/items/new" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/items/new",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/items/new`


<!-- END_d5d6ad70f971a5fda06bb1ecda8be70e -->

<!-- START_3bdf32c97cbef9dbea04cdc9914152db -->
## Product unwatch API
 This api will be called in chrome extension in case of that the authenticated user doesn&#039;t need to track the product any more.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/items/del" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/items/del",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/items/del`


<!-- END_3bdf32c97cbef9dbea04cdc9914152db -->

#Product
This api will be called in chrome extension to manage Products. Middelware : JWT Authentication
Also this will be used to building corpus for machine learning.
<!-- START_949df4027127e587b7550201c3bdc7ab -->
## Add new product API
This api will be called in chrome extension to add a new product into a sample data source for machine learning.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/products/add" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/products/add",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/products/add`


<!-- END_949df4027127e587b7550201c3bdc7ab -->

#Sample
This api will be called in landing page to store new samples given by customers. Middelware : CSRF Token Verification
Also this will be used to building corpus for machine learning.
<!-- START_22ceebf47ac9c808e6a516d023977f83 -->
## Add new Sample API
This api will be called in landing page.

> Example request:

```bash
curl -X POST "http://localhost:8000/api/v1/samples/add" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost:8000/api/v1/samples/add",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/samples/add`


<!-- END_22ceebf47ac9c808e6a516d023977f83 -->

