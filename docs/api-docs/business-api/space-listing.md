# Space Listing

## Show All Spaces

This is a paginated collection of spaces associated with a specific / currently authenticated business. Spaces can be sorted according to relevant attributes.

In order to obtain a proper response the specified user is required to be authenticated. If the user is unauthenticated and attempts to reach the end-point via `application/html`, a `302 Redirect` response is sent. If the end-point is reached via `application/json` and user is unauthenticated, a `401 Unauthorized` status is sent.

```http
GET /spaces
```

### Response

A successful `application/json` content-type request should return the following response object.

```json
HTTP/1.1 200 OK
Content-Type: application/json; charset=utf-8

{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "code": "ZMJNMTWUY52L",
            "reserved_at": null,
            "departs_at": "2020-10-30T03:20:53.000000Z",
            "arrives_at": "2020-12-30T03:20:53.000000Z",
            "origin": "Port Nicolette",
            "destination": "South Dixie",
            "height": "5.0",
            "width": "3.0",
            "length": "3.0",
            "weight": "7.0",
            "note": "Omnis labore sint tempora dolore.",
            "price": "488",
            "tax": "24",
            "user_id": "1",
            "type": "Local",
            "base": "Sri Lanka",
            "created_at": "2020-09-30T03:20:54.000000Z",
            "updated_at": "2020-09-30T03:20:54.000000Z",
            "path": "http:\/\/localhost\/spaces\/ZMJNMTWUY52L"
        },
    ],
    "first_page_url": "http:\/\/localhost\/spaces?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": 
    "http:\/\/localhost\/spaces?page=1",
    "links": [
        {
            "url": null,
            "label": "Previous",
            "active": false
        },
        {
            "url": "http:\/\/localhost\/spaces?page=1",
            "label": 1,
            "active": true
        },
        {
            "url": null,
            "label": "Next",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http:\/\/localhost\/spaces",
    "per_page": 10,
    "prev_page_url": null,
    "to": 10,
    "total": 10
}
```

## Filter Specific Spaces

It is also possible to filter specific spaces according to certain attributes. Such attributes are,

- Status
    + All
    + Available
    + Ordered
    + Expired


```http
GET /spaces?status=Available
```

The request should return the same object as before but with data that only include attribute status as requested status.
