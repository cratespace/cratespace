# Store Space

To create a new space addition in the specified business, The authenticated user  must be a business owner.

In order to obtain a proper response the specified user is required to be authenticated. If the user is unauthenticated and attempts to reach the end-point via `application/xhtml+xml`, a `302 Redirect` response is sent. If the end-point is reached via `application/json` and user is unauthenticated, a `401 Unauthorized` status is sent.

```http
POST /spaces
```

### Parameters

| Name        | Type     | In    | Description                         |
| ------------| -------- | ----- | ----------------------------------- |
| code        | string   | body  | Unique ID code of space (optional).  |
| departs_at  | datetime | body  | Date and time the space will depart the related business. |
| arrives_at  | datetime | body  | Date and time the space will arrive at a specified arrival point.  |
| origin      | string   | body  | Where the space will begin its journey from. Usually a town or city.  |
| destination | string   | body  | Where the space will end its journey. Usually a town or city  |
| height      | float    | body  | Height of specified space.  |
| width       | float    | body  | Width of specified space. |
| length      | float    | body  | Length of specified space.  |
| weight      | float    | body  | Maximum weight that can be carried. |
| note        | string   | body  | Additional notes (optional)  |
| price       | float    | body  | Price specified by related business for usage of sapce. |
| type        | string   | body  | Travel path. (Local/Internation) |
| base        | string   | body  | The country the business related to the space is stationed at (optional). |



### Response

A successful `application/json` content-type request should return the following response object.

```json
HTTP/1.1 201 OK
Content-Type: application/json; charset=utf-8

{
    "id":1,
    "code":"Y1PZNGOIMXRO",
    "reserved_at":null,
    "departs_at":"2020-11-04T19:58:47.000000Z",
    "arrives_at":"2021-01-04T19:58:47.000000Z",
    "origin":"North Omarifort",
    "destination":"Dominicburgh",
    "height":"6.0",
    "width":"6.0",
    "length":"1.0",
    "weight":"9.0",
    "note":"Quia fugiat id et ab nemo.",
    "price":"417",
    "tax":"21",
    "user_id":"1",
    "type":"Local",
    "base":"Sri Lanka",
    "created_at":"2020-10-04T19:58:47.000000Z",
    "updated_at":"2020-10-04T19:58:47.000000Z",
    "path":"http:\/\/localhost\/spaces\/Y1PZNGOIMXRO",
    "user":{
        "id":1,
        "name":"Zane Rau",
        "username":"chadrick82",
        "email":"savanna44@example.org",
        "profile_photo_path":null,
        "email_verified_at":"2020-10-04T19:58:47.000000Z",
        "two_factor_secret":null,
        "two_factor_recovery_codes":null,
        "phone":"807-499-6198",
        "settings":{
            "notifications_mobile":"everything",
            "notifications_email":[
                "new-order",
                "cancel-order",
                "newsletter"
            ]
        },
        "created_at":"2020-10-04T19:58:47.000000Z",
        "updated_at":"2020-10-04T19:58:47.000000Z",
        "profile_photo_url":"https:\/\/ui-avatars.com\/api\/?name=Zane+Rau&color=7F9CF5&background=EBF4FF"
    },
    "order":null
}
```
