database table 

for products ->   id (int , A.I),
                  name (varchar, 255), 
                  price (decimal , 10,2), 
                  quantity_available (int, ), 
                  img (varchar, 255) (default, null)

for users ->      id (int, A.I),
                  name (varchar, 255),
                  email (varchar, 255),
                  password (varchar, 255),
                  role ENUM(admin, user)

for orders ->     id (int, A.I),
                  username (varchar, 255),
                  product_id (int),
                  qty(int)

composer install and by using vendor/autoload (Psr 4)
