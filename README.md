This Project Is Part Of Test  For  Job Application

Endpoints:

- Register

POST /api/register 

- login

POST /api/login

---------------------
 - AUTH Required -
---------------------

- logout

POST /api/logout

- Show Profile

GET /api/profile

- Get All Users (Admin Only)

Get /api/users 

- Get User By Id (self and Admin)

GET /api/users/{user}

- Update User Info (update roles is from Admin)

PATCH /api/users/{user}

- Delete User Account (Admin Only)

DELETE /api/users/{user}

- Header :

Authorization : Bearer Token
