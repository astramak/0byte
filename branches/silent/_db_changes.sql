-- duplicate index (we already have a primary key)
alter table users 
drop index id;

-- make name field as varchar with length limit to 16 characters
-- is 16 enough?
alter table users 
modify column name varchar(16) character set utf8 collate utf8_general_ci not null;

-- make this field unique indexed for faster authorization and user search
alter table users add unique (name);

-- pwd field stores md5 hash and it is 32 char
-- BE CAREFULL AND CHECK IT ON YOUR TEST DATABASE
alter table users
modify column pwd char(32) character set utf8 collate utf8_general_ci not null;
