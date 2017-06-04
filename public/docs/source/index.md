---
title: API Reference

language_tabs:
- javascript

includes:

search: true

toc_footers:
- <a href='mailTo:ecmascript.guru@gmail.com'>Documented by Alexis Richard</a>
---
<!-- START_INFO -->










# Info

Welcome to API.









<!-- END_INFO -->

#Authentication
This api will be used in chrome extension in guest mode.
<!-- START_8ae5d428da27b2b014dc767c2f19a813 -->
## User Registration API
This api will be used in chrome extension as registration wizard.

> Example request:

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/register",
    "method": "POST",
    "data": {
        "name": "Test user",
        "email": "test@test.com",
        "password": "password"
    },
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
//  Response
{
    "status": true,
    "token": "eyJ0eX...iJIUzI1NiJ9.eyJ...ZEaUEzVjMifQ.ZulM...tHK2ohE",
    "user": {
        "name": "Test user",
        "email": "test@test.com",
        "updated_at": "2017-05-30 08:25:58",
        "created_at": "2017-05-30 08:25:58",
        "id": 3
    }
}
```

### HTTP Request
`POST api/v1/register`


<!-- END_8ae5d428da27b2b014dc767c2f19a813 -->

<!-- START_8c0e48cd8efa861b308fc45872ff0837 -->
## User Login API
This api will be used in chrome extension as Login wizard.

> Example request:

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/login",
    "method": "POST",
    "data": {
        "email": "test@test.com",
        "password": "password"
    },
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

// Response
{
    "status": true,
    "token": "eyJ0e...zI1NiJ9.eyJzdWIiOjMsIml...EaUEzVjMifQ.Zul...5knE-ItHK2ohE",
    "user": {
        "name": "Test user",
        "email": "test@test.com",
        "updated_at": "2017-05-30 08:25:58",
        "created_at": "2017-05-30 08:25:58",
        "id": 3
    }
}
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

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/get_initial_samples",
    "method": "POST",
    "data": {
        "domain" : "amazon.com",
        "category": "Book" // or "eBook"
    },
    "headers": {
        "accept": "application/json",
        "X-CSRF-TOKEN" : "Xg0aM3nvMdYylo8PlPZJR9vRLShuQ91XNBVBTvWS"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

//  Response
{
    "domain":"amazon.com",
    "status":true,
    "samples":[
        {
            "id":65,
            "domain_id":3,
            "min":1,
            "max":5,
            "est":60000,
            "created_at":"2017-05-27 17:22:00",
            "updated_at":"2017-05-27 17:22:00"
        },
        {
            "id":66,
            "domain_id":3,
            "min":6,
            "max":10,
            "est":52500,
            "created_at":"2017-05-27 17:22:00",
            "updated_at":"2017-05-27 17:22:00"
        },
        {
            //...
        }
    ]
}
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

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/iSamples",
    "method": "POST",
    "data": {
        "token": "eyJ0eX..1NiJ9.eyJzdWIi...lJQeGMifQ.-kmnsi_tsr...RHoUYohY",
        "domain": "amazon.co.uk"
    },
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

//  Response
{
    "status":true,
    "domain":"amazon.co.uk",
    "samples":[
        {
            "id":65,
            "domain_id":3,
            "min":1,
            "max":5,
            "est":60000,
            "created_at":"2017-05-27 17:22:00",
            "updated_at":"2017-05-27 17:22:00"
        },
        {
            "id":66,
            "domain_id":3,
            "min":6,
            "max":10,
            "est":52500,
            "created_at":"2017-05-27 17:22:00",
            "updated_at":"2017-05-27 17:22:00"
        },{
            //...
        }
    ]
}
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

```javascript
var settings = {
    "url": "api/v1/items/",
    "data": {
        "token": "eyJ0eXA..JIUzI1NiJ9.eyJzdWIiOjU..lJQeGMifQ.-kmn...4052lRHoUYohY"
    },
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

//  Response
{
    "status":true,
    "items":[
        {
            "id":1,
            "product_id":1,
            "tracked_by":5,
            "caption":"your caption",
            "status":1,
            "created_at":"2017-05-30 09:58:25",
            "updated_at":"2017-05-30 09:58:25"
        }
    ]
}
```


### HTTP Request
`POST api/v1/items`


<!-- END_7bd5f07d9ba801bd8687585c8cb91196 -->

<!-- START_f23222161d4405120d2d6a4c70a300f9 -->
## Watched Product Detail API
This api will be called in chrome extension to get a specific product with change histories being tracked by the authorized user.

> Example request:

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/items/get",
    "method": "POST",
    "data": {
        "id": 1,
        "token": "eyJ0eXA..JIUzI1NiJ9.eyJzdWIiOjU..lJQeGMifQ.-kmn...4052lRHoUYohY"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

//  Response
{
    "status":true,
    "product":{
        "id":1,
        "category_id":2,
        "domain_id":3,
        "asin":"DFDJEPOPEGSLDKFJ",
        "title":"First & Last",
        "created_at":"2017-05-30 09:58:25",
        "updated_at":"2017-05-30 09:58:25",
        "histories":[
            {
                "id":1,
                "product_id":1,
                "bsr":"25468",
                "currency":"USD",
                "price":124.99,
                "est":235,
                "created_at":"2017-05-30 09:58:25",
                "updated_at":"2017-05-30 09:58:25"
            }
        ]
    }
}
```


### HTTP Request
`POST api/v1/items/get`


<!-- END_f23222161d4405120d2d6a4c70a300f9 -->

<!-- START_d5d6ad70f971a5fda06bb1ecda8be70e -->
## Product watch API
This api will be called in chrome extension to track a new product by the authorized user.

> Example request:

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/items/new",
    "method": "POST",
    "data": {
        "token": "eyJ0eXAiOixxUzI1NiJ9.eyJzdWIiOjUsIml...QeGMifQ.-kmnsi...52lRHoUYohY",
        "domain": "amazon.com",
        "title": "First & Last",
        "asin": "DFDJEPOPEGSLDKFJ",
        "bsr": 25468,
        "currency": "USD",
        "price": 124.99,
        "est": 235,
        "caption": "My first product to be tracked."
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

//  Response
{
    "status":true,
    "id":2
}
```


### HTTP Request
`POST api/v1/items/new`


<!-- END_d5d6ad70f971a5fda06bb1ecda8be70e -->

<!-- START_3bdf32c97cbef9dbea04cdc9914152db -->
## Product unwatch API
 This api will be called in chrome extension in case of that the authenticated user doesn&#039;t need to track the product any more.

> Example request:

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/items/del",
    "method": "POST",
    "data" : {
        "token" : "eyJ0eXAiOixxUzI1NiJ9.eyJzdWIiOjUsIml...QeGMifQ.-kmnsi...52lRHoUYohY",
        "id": "1"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

//  Response
{
    "status":true,
    "message":"Successfully removed."
}
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

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/products/add",
    "method": "POST",
    "data": {
        "token": "eyJ0e..UzI1NiJ9.eyJzdWI...lJQeGMifQ.-kmnsi_ts..RHoUYohY",
        "domain": "amazon.com",
        "title": "First & Last",
        "asin": "DFDJEPOPEGSLDKFJ",
        "bsr": 25468,
        "currency": "USD",
        "price": 124.99,
        "est": 235,
        "caption": "My first product to be tracked."
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

//  Response
{
    "status":true,
    "id":3
}
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

```javascript
var settings = {
    "url": "http://localhost:8000/api/v1/samples/add",
    "method": "POST",
    "data": {
        "domain": "amazon.co.uk",
        "bsr": 5315,
        "sales": 235
    },
    "headers": {
        "X-CSRF-TOKEN" : "5uxja9mQt1ln6BWY0IF5YYE1rllrT356XUXWYIIS"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});

//  Response
{
    "status":true,
    "id":5
}
```


### HTTP Request
`POST api/v1/samples/add`


<!-- END_22ceebf47ac9c808e6a516d023977f83 -->

