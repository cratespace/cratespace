# Delete User

Only authenticated users can delete their own accounts.

```HTTP
DELETE /user
```

### Required Parameters

###### Form body parameters

- password (string|match:password) - User's password.

### Expected Response

Successful HTTP response to a `text/html` type request should queue the user account for deletion, log out user session and redirect user to `/` route (welcome page) with a `302 Redirect` status code.

Successful JSON response to a `application/json` type request should return an empty response body with a HTTP status of `204 No Content` like the example shown below.

```JSON
{
    "data": ""
}
```

### Error Response

In the case of a validation error, a HTTP status of `422 Unprocessable entity` response is thrown for `application/json` type and `302 Redirect` is returned for `text/html` type requests with relevant parameter error details in session `deleteUser` error bag.

```JSON
{
    "data": {
      "message": "The given data was invalid."
      "errors": {
        "password": [
          "The password field is required."
        ]
      }
    }
}
```
