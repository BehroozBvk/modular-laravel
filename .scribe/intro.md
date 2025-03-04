# Student Management System API

Welcome to the Student Management System API documentation. This API provides endpoints for managing students, teachers, lessons, and other educational resources.

## Authentication

Most endpoints require authentication using a Bearer token. To authenticate, include the token in the Authorization header:

```
Authorization: Bearer your-token-here
```

## Response Format

All API responses follow a consistent format:

```json
{
  "success": true|false,
  "message": "A descriptive message",
  "data": { ... },
  "status_code": 200,
  "timestamp": "2023-01-01T00:00:00.000000Z"
}
```

For paginated responses, the data field contains:

```json
{
  "items": [ ... ],
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 10,
    "per_page": 15,
    "to": 15,
    "total": 150
  }
}
```

## Error Handling

When an error occurs, the response will have `success: false` and include error details:

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "field_name": ["Error message"]
  },
  "status_code": 422,
  "timestamp": "2023-01-01T00:00:00.000000Z"
}
```

# Introduction



<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>

    This documentation aims to provide all the information you need to work with our API.

    <aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
    You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>

