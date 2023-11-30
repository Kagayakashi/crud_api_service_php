# CRUD API service
This is JSON API. You can create, read, update, delete products there.

## Create data
http://example.com/api/create
### Request
```
{
    "product": "ProductName",
    "price": "ProductPrice",
    "amount": "ProductAmount",
    "dealer": "ProductDealer"
}
```
### Response
```
{
    "status": 1,
    "id": 1
}
```

## Read data
http://example.com/api/read/{id}
### Request body is empty.
### Response
```
{
    "status":  1,
    "products": [
         {
            "id": 1
            "product": "ProductName",
            "price": "ProductPrice",
            "amount": "ProductAmount",
            "dealer": "ProductDealer"
         }
    ]
}
```

### Update data
http://example.com/api/update/{id}
### Request
```
{
    "product": "ProductName",
    "price": "ProductPrice",
    "amount": "ProductAmount",
    "dealer": "ProductDealer"
}
```
### Response
```
{
    "status": 1
}
```

### Delete data
http://example.com/api/delete/{id}
### Request body is empty.
### Reponse
```
{
    "status": 1
}
```
