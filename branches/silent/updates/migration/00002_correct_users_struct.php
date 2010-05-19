<?php

function description() {
	return <<<EOF
Beautifying [user] table structure
EOF;
}

function fieldInfo($struct, $fieldname) {
	foreach($struct as $field) {
		if ($field['field'] == $fieldname)
			return $field;
	}

	return false;
}

function fieldType($struct, $fieldname) {
	$info = fieldInfo($struct, $fieldname);

	if ($info)
		return strtolower($info['type']);

	return false;
}

function checkField($struct, $fieldname, $expectedtype) {
	ulog('Checking [' . $fieldname . '] field type');

	$fieldType = fieldType($struct, $fieldname);
	if ($fieldType != $expectedtype) {
		ulog('  Field is type of [' . $fieldType . ']');
		ulog('  Converting to [' . $expectedtype . ']');

		return false;
	}

	return true;
}

function update() {
	$struct = DB::select('desc users')->fetchAll();

	// mail -> varchar(255) as specified in RFC 5321 (see maximum path)
	if (!checkField($struct, 'mail', 'varchar(255)')) {
		if (!DB::exec('
alter table users
modify column mail varchar(255) character set utf8 collate utf8_general_ci not null')
		)
			return false;

		ulog('  Converted');
	}

	// jabber -> varchar(255) like as a mail field
	if (!checkField($struct, 'jabber', 'varchar(255)')) {
		if (!DB::exec('
alter table users
modify column jabber varchar(255) character set utf8 collate utf8_general_ci default \'\' not null')
		)
			return false;

		ulog('  Converted');
	}

	// site -> varchar(255) is enough
	if (!checkField($struct, 'site', 'varchar(255)')) {
		if (!DB::exec('
alter table users
modify column site varchar(255) character set utf8 collate utf8_general_ci default \'\' not null')
		)
			return false;

		ulog('  Converted');
	}

	// name -> varchar(32)
	if (!checkField($struct, 'name', 'varchar(32)')) {
		if (!DB::exec('
alter table users
modify column name varchar(32) character set utf8 collate utf8_general_ci not null')
		)
			return false;

		ulog('  Converted');
	}

	// pwd -> char(32)
	if (!checkField($struct, 'pwd', 'char(32)')) {
		if (!DB::exec('
alter table users
modify column pwd char(32) character set utf8 collate utf8_general_ci not null')
		)
			return false;

		ulog('  Converted');
	}

	// online -> int(10)
	if (!checkField($struct, 'online', 'int(10)')) {
		if (!DB::exec('
alter table users
modify column online int(10) default 0 not null')
		)
			return false;

		ulog('  Converted');
	}

	$id_index = DB::select('show indexes from users where Key_name = %s', array('id'));

	if (
		$id_index
		&& $id_index->count() > 0
	) {
		ulog('Duplicate index on users.id found. Dropping.');

		if (!DB::exec('alter table users drop index id'))
			return false;

		ulog('  Success');
	}

	$name_index = DB::select('show indexes from users where Key_name = %s', array('name'));

	if ($name_index->count() == 0	) {
		ulog('Unique index on users.name not found. Creating.');

		if (!DB::exec('	alter table users add unique (name)'))
			return false;

		ulog('  Success');
	}

	$online_index = DB::select('show indexes from users where Key_name = %s', array('online'));

	if ($online_index->count() == 0) {
		ulog('Index on users.online not found. Creating.');

		if (!DB::exec('alter table users add index (online)'))
			return false;

		ulog('  Success');
	}

	return true;
}
