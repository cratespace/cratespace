# Update User Profile Information

Only authenticated users, users with existing accounts can update their profile information.

```HTTP
PUT /user/profile-information
```

### Required Parameters

###### Form body parameters

- name (string) - Full name of customer.
- username (string|unique) - Unique username assigned to customer.
- email (string|unique) - Work/Business/Personal email address.
- phone (string) - Work/Business/Personal phone number.

### Expected Response

Successful HTTP response to a `text/html` type request should update user account details and redirect user back to the page where the request originated from with a `302 Redirect` status code.

Successful JSON response to a `application/json` type request should return an empty response body with a HTTP status of `200 Ok` like the example shown below.

```JSON
{
    "data": ""
}
```

### Error Response

In the case of a validation error, a HTTP status of `422 Unprocessable entity` response is thrown for `application/json` type and `302 Redirect` is returned for `text/html` type requests with relevant parameter error details in session `updateProfileInformation` error bag.

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
