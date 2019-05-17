#The supermarket challenge

Starting the project:

Set up a mysql server in docker:
```
docker run -d --name mysql-test -e MYSQL_ROOT_PASSWORD=simple -e MYSQL_DATABASE=firstdb -p 9999:3306 mysql:5.7
```

Run:
```
initdb.php
```

To "buy" items run:
```
index.php
```

To add products use:
````
additem.php
````

To remove products, use:
```
deleteproduct.php
```

To modify the price of each product:
```
updateprice.php
```

