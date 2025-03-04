# Authentication

The Student Management System API uses JWT (JSON Web Tokens) for authentication.

## Obtaining a Token

To obtain a token, use one of the login endpoints:

- For students: `POST /api/v1/auth/students/login`
- For teachers: `POST /api/v1/auth/teachers/login`
- For admins: `POST /api/v1/auth/admins/login`

## Using the Token

Include the token in the Authorization header for all authenticated requests:

```
Authorization: Bearer your-token-here
```

## Token Expiration

Tokens expire after 24 hours. You'll need to log in again to obtain a new token.

## Logging Out

To invalidate a token, use one of the logout endpoints:

- For students: `POST /api/v1/auth/students/logout`
- For teachers: `POST /api/v1/auth/teachers/logout`
- For admins: `POST /api/v1/auth/admins/logout`
