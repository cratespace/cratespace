# Edit Space

A successful response should render an html view of edit given space details page of cratespace web application.

In order to obtain a proper response the end-point can only be reached via `application/xhtml+xml` and user making the request is required to be authenticated. If the user is unauthenticated, a `302 Redirect` response is sent.

```http
GET /spaces/{space}/edit
```

### Parameters

| Name          | Type  | In    | Description              |
| ------------- | ----- | ----- | ------------------------ |
| space         | int   | path  | Unique ID code of space  |
