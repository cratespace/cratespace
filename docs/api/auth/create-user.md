# Create New User

Only guests (those without accounts) can create a new user account.

```HTTP
POST /register
```

### Required Parameters

###### Form body parameters

- name (string) - Full name of customer.
- business name (string) - Name of customer business.
- email (string|unique) - Work/Business/Personal email address.
- phone (string) - Work/Business/Personal phone number.
- password (string|min:8) - Uniques string of at least 8 characters.
- password confirmation (string|min:8|match:password) - Exact match of above.

### Expected Response

Successful HTTP response to a `text/html` type request should create a new user account and redirect user to `/home` route with a `302 Redirect` status code.

Successful JSON response to a `application/json` type request should return an empty response body with a HTTP status of `201 Resource created` like the example shown below.

```JSON
{
    "data": ""
}
```

### Error Response

In the case of a validation error, a HTTP status of `422 Unprocessable entity` response is thrown for `application/json` type and `302 Redirect` is returned for `text/html` type requests with relevant parameter error details in session error bag.

```JSON
{
    "data": {
      "message": "The given data was invalid."
      "errors": {
        "attribute": [
          "The attribute field is required."
        ]
      }
    }
}
```
