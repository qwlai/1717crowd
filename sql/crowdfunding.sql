DROP TABLE IF EXISTS fund;
DROP TABLE IF EXISTS project;
DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS deleted_project;

CREATE TABLE account (
	email VARCHAR (64) PRIMARY KEY,
	NAME VARCHAR (64) NOT NULL,
	password VARCHAR (255) NOT NULL,
	is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE project (
	owner VARCHAR (64) REFERENCES account (email),
	title VARCHAR (64) NOT NULL,
	description TEXT NOT NULL,
	start_date DATE NOT NULL,
	end_date DATE check(end_date > start_date) NOT NULL,
	keywords VARCHAR (64),
	amount_sought NUMERIC check(amount_sought > 0) NOT NULL,
	primary key (owner, title)
);

CREATE TABLE fund (
	id serial PRIMARY KEY,
	owner varchar(64),
	title varchar(64), 
	investor VARCHAR (64) REFERENCES account (email),
	amount NUMERIC check(amount > 0) NOT NULL,
	foreign key (owner, title) REFERENCES project(owner, title) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE deleted_project (
	id serial PRIMARY KEY,
	delete_time timestamp,
	owner VARCHAR (64) REFERENCES account (email),
	title VARCHAR (64) NOT NULL,
	description TEXT NOT NULL,
	start_date DATE NOT NULL,
	end_date DATE check(end_date > start_date) NOT NULL,
	keywords VARCHAR (64),
	amount_sought NUMERIC check(amount_sought > 0) NOT NULL
);
