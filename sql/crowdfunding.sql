
CREATE TABLE account (
	email VARCHAR (64) PRIMARY KEY,
	NAME VARCHAR (64) NOT NULL,
	password VARCHAR (255) NOT NULL,
	is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE project (
	advertiser VARCHAR (64) REFERENCES account (email),
	title VARCHAR (64) NOT NULL,
	description TEXT NOT NULL,
	start_date DATE NOT NULL,
	end_date DATE check(end_date > start_date) NOT NULL,
	keywords VARCHAR (64),
	amount_sought NUMERIC check(amount_sought > 0) NOT NULL
	primary key (advertiser, title)
);

CREATE TABLE fund (
	owner varchar(64),
	title varchar(64), 
	investor VARCHAR (64) REFERENCES account (email),
	amount NUMERIC check(amount > 0) NOT NULL
	primary key (owner, title, investor),
	foreign key (owner, title) REFERENCES project(advertiser, title)
);


