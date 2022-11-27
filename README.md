
# Bugloos Package

Bugloos Package For Backend Gridview

A Bugloos Package Its for A Backend developer to make a quary in database is more easy and its easy to implement it in any php native projects and its help them with search , pagination , sort, search , filter for a php native projects

## Features

- Easy  to write  quary
- Easy to  implement to php native projects
- Easy Make a pagination , sort, search , filter 




## Installation

Install my-project with npm

```bash
composer require yousry/bugloos
```

Configure the database

```bash
go to this path  and add  your  database Configuration  src/classloader/env.php
```
    

    
## Deployment

To implemnt  the pakage in you project

```bash
$Gridview = new Gridview('posts'); "add the table name"
```

To select a specific column in this table
```bash
$Gridview->setColumns("id, name"); "add the column name  "
```


To Filter the  data
```bash
 $Gridview->setWhere("id = 1"); "add the column name and a value "
```

To sort Data
```bash
$Gridview->setOrder("id DESC"); 
```

To Limit Data
```bash
 $Gridview->setLimit("10");

```


To Make a search
```bash
    $Gridview->setSearchColumns("name");
    $Gridview->setSearchOperator("LIKE");
    $Gridview->setSearchValue("%test%");
    $Gridview->search( "name");
    $Gridview->setSearchType("string");
```


Get data  
```bash
echo $Gridview->dataJson();
```

To get data by Pagination
```bash
echo  $Gridview->Pagination();

Example for data response : 
{
"total_count": "1",
"total_page": 1,
"current_page": 0,
"limit": 1,
"next_page": 1,
"prev_page": -1,
"first_page": 0,
"last_page": 0,
"first_page_url": "localhost/?limit=1&offset=0",
"last_page_url": "localhost/?limit=1&offset=0",
"next_page_url": "localhost/?limit=1&offset=1",
"prev_page_url": "localhost/?limit=1&offset=-1",
"data": [
{
"id": "16",
"name": "test"
}
]
}

```
## Support

For support, email ayousry943@gmail.com .


## Used By

This project is used by the following companies:

- bugloos


